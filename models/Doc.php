<?php

namespace docs;

use FileManager, URLify;

/**
 * Reads docs from the filesystem and renders them.
 */
class Doc {
	public $id;

	public $doc;

	public $root = 'apps/docs/docs';
	
	public $link_base = '/docs';
	
	public $error = false;
	
	public $targets = null;

	public function __construct ($id = null) {
		if ($id) $this->open ($id);
	}

	/**
	 * Opens the documentation file and loads the contents.
	 */
	public function open ($id) {
		if (! FileManager::verify_file ($id . '.md', $this->root)) {
			$this->error = 'Invalid Doc ID';
			return;
		}
		$this->id = trim ($id, '/');
		$this->file = $this->root . '/' . $this->id . '.md';
		$this->doc = file_get_contents ($this->file);
	}

	/**
	 * Returns the path as an array.
	 */
	public function path () {
		return explode ('/', $this->id);
	}

	/**
	 * Returns the page link.
	 */
	public function link () {
		return $this->link_base . '/' . $this->id;
	}

	/**
	 * Returns a link to the current page in another version of the documentation,
	 * if that page is available. If not, then it simply links to the index page
	 * for that version.
	 */
	public function alt_version_link ($version) {
		$path = preg_replace ('/^(' . preg_quote ($this->root, '/') . ')\/([0-9\.]+)/', '\1/' . $version, $this->file);

		if (file_exists ($path)) {
			return preg_replace ('/^(' . preg_quote ($this->link_base, '/') . ')\/([0-9\.]+)/', '\1/' . $version, $this->link ());
		}

		return $this->link_base . '/' . $version;
	}

	/**
	 * Parses the link for parents (aside from the version link).
	 */
	public function parent_links () {
		$links = array ();

		$vlink = $this->link_base . '/' . $this->version ();

		$link = $this->link ();
		$link = preg_replace ('/\/[^\/]+$/', '', $link);

		while (! empty ($link) && $link != $vlink) {
			$id = preg_replace ('/^' . preg_quote ($this->link_base, '/') . '\//', '', $link);
			$doc = new Doc ($id);
			$links[$link] = $doc->title ();

			$link = preg_replace ('/\/[^\/]+$/', '', $link);
		}

		$links = array_reverse ($links, true);

		return $links;
	}
	
	/**
	 * Parse the body for targets.
	 */
	public function targets () {
		if ($this->targets !== null) {
			return $this->targets;
		}

		if (preg_match_all ('/--- ?(.*) ?: ?(.*) ?---/', $this->doc, $regs)) {
			$this->targets = array ();
			for ($i = 0; $i < count ($regs[1]); $i++) {
				if (! isset ($this->targets[$regs[1][$i]])) {
					$this->targets[$regs[1][$i]] = array ($regs[2][$i]);
				} else {
					$this->targets[$regs[1][$i]][] = $regs[2][$i];
				}
			}
		} else {
			$this->targets = array ();
		}
		return $this->targets;
	}

	/**
	 * Render the page body.
	 */
	public function render ($out = false, $strip_title = true) {
		$out = $out ? $out : $this->doc;

		if ($strip_title) {
			$out = preg_replace ('/^# ' . preg_quote ($this->title (), '/') . '/', '', $out);
		}

		require_once ('apps/blog/lib/markdown.php');
		$out = Markdown ($out);
		
		$targets = $this->targets ();

		foreach ($targets as $label => $target_list) {
			foreach ($target_list as $k => $target) {
				$pre = ($k === 0) ? '' : "</div>\n";

				$out = preg_replace (
					'/<p>--- ?' . preg_quote ($label, '/') . ' ?: ?' . preg_quote ($target, '/') . ' ?---<\/p>/',
					$pre . '<div class="target-' . URLify::filter ($label) . '" id="target-' . URLify::filter ($label . ' ' . $target) . "\">\n",
					$out
				);
			}

			$out = preg_replace ('/<p>--- ?\/' . preg_quote ($label, '/') . ' ?---<\/p>/', "</div>\n", $out);
		}

		// parse internal links
		$out = preg_replace_callback (
			'/\[\[(>|:)?(.+?)\]\]/',
			array ($this, 'make_link'),
			$out
		);

		return $out;
	}

	/**
	 * Make the HTML for a `[[Linked page]]` style link.
	 */
	public function make_link ($regs) {
		$match = (is_array ($regs) && isset ($regs[2])) ? $regs[2] : $regs;
		$type = (is_array ($regs) && isset ($regs[1])) ? $regs[1] : null;

		$link = $this->link ();
		$prefix = $this->link_base . '/' . $this->version ();
		$parts = explode ('/', $match);
		$text = trim (array_pop ($parts));

		switch ($type) {
			case '>': // sub-pages
				$link = $this->link ();
				$href = $link . '/' . $this->filter_parts ($match);
				break;

			case ':': // sibling pages
				$link = preg_replace ('/\/[^\/]+$/', '', $this->link ());
				$href = $link . '/' . $this->filter_parts ($match);
				break;
			
			default: // top-level pages
				$prefix = $this->link_base . '/' . $this->version ();
				$href = $prefix . '/' . $this->filter_parts ($match);
				break;
		}
		
		return sprintf ('<a href="%s">%s</a>', $href, $text);
	}

	/**
	 * Filter a path's individual parts with `URLify::filter()`.
	 */
	public function filter_parts ($id) {
		$parts = explode ('/', $id);
		foreach ($parts as $k => $p) {
			$parts[$k] = URLify::filter (trim ($p));
		}
		return join ('/', $parts);
	}
	
	/**
	 * Parse the page title from the first line of the body.
	 */
	public function title () {
		return str_replace ('# ', '', trim (strtok ($this->doc, "\n")));
	}

	/**
	 * Look for a version in the request URI.
	 */
	public function version () {
		if ($_SERVER['REQUEST_URI'] !== '/docs') {
			return current (explode ('/', $this->id));
		}
		return false;
	}
	
	/**
	 * Returns a list of documentation versions.
	 */
	public function versions () {
		$files = glob ($this->root . '/*');

		$out = array ();
		foreach ($files as $file) {
			if (is_dir ($file)) {
				$out[] = basename ($file);
			}
		}

		rsort ($out);

		return $out;
	}
	
	/**
	 * Parse and return the sidebar navigation.
	 */
	public function nav () {
		$version = $this->version ();
		if (! $version) {
			return false;
		}

		if (file_exists ($this->root . '/' . $version . '-nav.md')) {
			return $this->render (file_get_contents ($this->root . '/' . $version . '-nav.md'), false);
		}
		return false;
	}
}

?>