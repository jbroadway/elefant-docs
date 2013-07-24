<?php

// redirect /docs to /docs/LATEST_VERSION
if ($_SERVER['REQUEST_URI'] === '/docs') {
	$this->redirect ('/docs/' . Appconf::docs ('Docs', 'default_version'));
}

// show version index
if (preg_match ('|^/docs/([0-9]+\.[0-9]+)$|', $_SERVER['REQUEST_URI'], $regs)) {
	$doc = new docs\Doc ($regs[1]);
	if ($doc->error) return $this->error (404);
} else {
	$docid = join ('/', $this->params);
	$doc = new docs\Doc ($docid);
	if ($doc->error) return $this->error (404);
}

$page->id = 'docs';
$page->title = $doc->title ();
$page->add_style ('/apps/docs/css/style.css');
$page->add_script ('/js/jquery.cookie.js');
$page->add_script ('/apps/docs/js/targets.js');

URLify::$remove_list = array ();

echo $tpl->render ('docs/page', array (
	'link' => $doc->link (),
	'parent_links' => $doc->parent_links (),
	'targets' => $doc->targets (),
	'version' => $doc->version (),
	'versions' => $doc->versions (),
	'title' => $doc->title (),
	'body' => $doc->render (),
	'doc' => $doc
));

?>