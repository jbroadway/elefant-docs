# Users and access control

Elefant provides a flexible but very simple solution for providing role-based access
control (RBAC). End users define roles under the Tools > Users > Roles admin screen,
based on the roles defined by the apps that are installed on the site.

## Defining your resources

To define custom resources for your app, create a `conf/acl.php` file in your app that
looks like this:

~~~php
; <?php /*

myapp           = "Access My App"
myapp/feature-x = "Modify feature X"

; */ ?>
~~~

This defines two new resources, one matching the app itself, and the second representing
a specific feature in the app. Save this file and you'll see these are immediately
available in the role add/edit forms under Tools > Users > Roles.

## Verifying access rights

To verify that the current user can access one or more resources only takes a single line
of code:

~~~php
<?php

$this->require_acl ('admin', 'myapp');

// carry on, the user is verified

?>
~~~

This verifies that the current user can access the `admin` and `myapp` resources. You
may specify any number of resources in a single call. If any fails, the user will be
sent to `/admin` where they can log in as an administrator, or if they're logged in
already, they'll simply see the homepage of the site.

This behaviour is okay for most cases, but sometimes you may need to take specific
action, such as sending an AJAX error, which you can do like this:

~~~php
<?php

if (! User::require_acl ('admin', 'myapp')) {
	echo $this->restful_error (__ ('Forbidden'), 403);
	return;
}

// carry on, the user is verified

?>
~~~

You can also include this in a condition in your view templates:

~~~html
{% if User::require_acl ('admin', 'myapp', 'myapp/feature-x') %}
	<a href="/myapp/feature-x">{"Feature X"}</a>
{% end %}
~~~

For more info on managing users and roles, see the
[User](http://api.elefantcms.com/visor/lib/User) and
[Acl](http://api.elefantcms.com/visor/lib/Acl) classes.

## Convenience methods

There are two additional methods you'll see used in Elefant for access control, which are:

~~~php
$this->require_admin ();
~~~

Which is an alias for:

~~~php
$this->require_acl ('admin');
~~~

And:

~~~php
$this->require_login ();
~~~

Which wraps `User::require_login()` and instead redirects unauthorized users to `/user/login`
instead of `/admin`.

Next: [[:Caching]]
