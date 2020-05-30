# View templates

Elefant uses a [Mustache](http://mustache.github.com/)-like template syntax that should be familiar to many developers, with a few simple extensions.

Templates compile to pure PHP code before executing, making them fast and lightweight. PHP tags can be used directly in templates as well.

See the [[Designers / template language]] page for a complete overview with examples of the template syntax.

## Views versus layouts

There are two differences between layout templates and view templates:

1. Layouts live in the `layouts` folder, whereas views live in the `views` folder of a particular app.
2. Layout templates are always passed the [Page](https://www.elefantcms.com/visor/lib/Page) object, which defines the [tags that are available](/docs/2.2/designers/available-template-tags), whereas you may pass any data you need to a view template.

## Rendering a template

To render a view template, you call `$tpl->render()` like this:

~~~php
<?php

echo $tpl->render ('myapp/templatename', array ('name' => 'Joe'));

?>
~~~

This will look for a template file named `apps/myapp/views/templatename.html`, and pass it the array `['name' => 'Joe']`, which can then be accessed within the template like this:

~~~html
<p>Hello, {{name}}</p>
~~~

You may nest templates in subfolders of your `views` folder as well, for example:

~~~php
<?php

echo $tpl->render ('myapp/email/welcome', array ('name' => 'Joe'));

?>
~~~

This will look for a template file named `apps/myapp/views/email/welcome.html`.

## Encapsulating view logic

There are times when complex views begin to bleed presentational logic into a handler, since templates themselves are not very sophisticated by design. Elefant provides a [View](https://www.elefantcms.com/visor/lib/View) class to help in these cases.

`View::render()` differs from `$tpl->render()` in that it also accepts a [callable](http://ca2.php.net/manual/en/language.types.callable.php) in place of a template name.

For example:

~~~php
<?php

echo View::render (function ($params) {
	return sprintf ('<p>%s</p>', join (', ', $params));
});

?>
~~~

This bypasses the usual template rendering altogether, however you can see that any code within the callable is part of the view rendering. In this way, you can encapsulate additional logic around your template rendering rather easily:

~~~php
<?php

echo View::render (function ($params) {
	if (empty ($params['name'])) {
		return View::render ('myapp/newuser', $params);
	}
	return View::render ('myapp/user', $params);
});

?>
~~~

And of course you can offload the callable to a class:

~~~php
<?php // apps/myapp/lib/UserViews.php

namespace myapp;

use View;

class UserViews {
	public static function some_view ($params) {
		return View::render ('myapp/some_view', $params);
	}
}

?>
~~~

And to call it, simply specify your callable method name instead of a template name:

~~~php
<?php

echo View::render ('myapp\UserViews::some_view', array ('name' => 'Joe'));

?>
~~~

Aside from these more complex cases, you can often use `View::render()` and `$tpl->render()` interchangeably.

Next: [[:Form handling]]
