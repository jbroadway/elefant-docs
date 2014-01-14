# Installation and upgrade processes

Elefant provides a simple method of tracking the install/upgrade status for each app. If an app's install handler needs to be run, you will see it highlighted in the Tools menu like this:

![Click to install](/apps/docs/docs/2.0/pix/click-to-install.png)

A similar notice will appear if an app's upgrade handler needs to be run.

## How it works

In the `[Admin]` block of your app's `config.php`, you can specify the version of your app, as well as the install and upgrade handlers, like this:

~~~ini
[Admin]

name = Myapp
version = 1.0
handler = myapp/admin
install = myapp/install
upgrade = myapp/upgrade
~~~

Elefant tracks which versions of which apps have been installed. If an app is not tracked, then its install handler has not yet been run. If it has, but the version number in its `config.php` is greater than the one Elefant has tracked, then the upgrade handler needs to be run.

The install handler runs after the files have been installed into the `apps` folder, and is meant to perform tasks like creating any new database tables used by the app.

When the install handler is finished, it marks itself as installed like this:

~~~php
$this->mark_installed ($this->app, Appconf::get ($this->app, 'Admin', 'version'));
~~~

Similarly, the upgrade handler doesn't install the updated source files, but rather performs additional maintenance tasks such as updating the database schema or clearing cached data.

When the upgrade handler is finished, it calls the same method above to mark the current version as installed.

## Install handler

Here is a commented example of a complete install handler script. For a typical app that only needs to create new database tables for itself, this is all you should need.

~~~php
<?php

// keep unauthorized users out
$this->require_admin ();

// set the layout
$page->layout = 'admin';

// get the version and check if the app installed
$version = Appconf::get ($this->app, 'Admin', 'version');
$current = $this->installed ($this->app, $version);

if ($current === true) {
    // app is already installed and up-to-date, stop here
    $page->title = __ ('Already installed');
    printf ('<p><a href="/%s/admin">%s</a>', $this->app, __ ('Continue'));
    return;

} elseif ($current !== false) {
    // earlier version found, redirect to upgrade handler
    $this->redirect ('/' . Appconf::get ($this->app, 'Admin', 'upgrade'));
}

$page->title = sprintf (
    '%s: %s',
    __ ('Installing App'),
    Appconf::get ($this->app, 'Admin', 'name')
);

// grab the database driver and begin the transaction
$conn = conf ('Database', 'master');
$driver = $conn['driver'];
DB::beginTransaction ();

// parse the database schema into individual queries
$file = 'apps/' . $this->app . '/conf/install_' . $driver . '.sql';
$sql = sql_split (file_get_contents ($file));

// execute each query in turn
foreach ($sql as $query) {
    if (! DB::execute ($query)) {
        // show error and rollback on failures
        printf (
            '<p class="visible-notice">%s: %s</p><p>%s</p>',
            __ ('Error'),
            DB::error (),
            __ ('Install failed.')
        );
        DB::rollback ();
        return;
    }
}

// commit transaction and mark the app installed
DB::commit ();
$this->mark_installed ($this->app, $version);

printf ('<p><a href="/%s/admin">%s</a></p>', $this->app, __ ('Done.'));

?>
~~~

## Upgrade handler

Here is the outline of an upgrade handler, minus any database logic since that will depend on your app.

~~~php
<?php

// keep unauthorized users out
$this->require_admin ();

// set the layout
$page->layout = 'admin';

// get the version and check if the app installed
$version = Appconf::get ($this->app, 'Admin', 'version');
$current = $this->installed ($this->app, $version);

if ($current === true) {
    // app is already installed and up-to-date, stop here
    $page->title = __ ('Already up-to-date');
    printf ('<p><a href="/%s/admin">%s</a>', $this->app, __ ('Home'));
    return;
}

$page->title = sprintf (
    '%s: %s',
    __ ('Upgrading App'),
    Appconf::get ($this->app, 'Admin', 'name')
);

// add your upgrade logic here

// mark the new version installed
$this->mark_installed ($this->app, $version);

printf ('<p><a href="/%s/admin">%s</a></p>', $this->app, __ ('Done.'));

?>
~~~

Back: [[Developers / Sharing your apps]]