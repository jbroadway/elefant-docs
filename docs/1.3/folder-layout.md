# Folder layout

### .htaccess

Rewrites and permissions for the Apache web server.

### apps

Your apps go here. Each app gets its own folder structure that looks like this:

* apps
    * appname
        * conf
        * forms
        * handlers
        * lib
        * models
        * views

### cache

Templates rendered to PHP are saved here.

### conf

Global configurations including database connection info.

### css

Global CSS files.

### files

Files uploaded through the admin area.

### index.php

This is the front-end controller, or request router.

### install

The web-based installer.

### js

Global Javascript files.

### layouts

Design layouts/templates go here.

### lib

These are the main libraries that form the core of the framework.

### LICENSE

The MIT license info.

### nginx.conf

Rewrites and permissions for the Nginx web server.

### README.md

The main README file.

### tests

Unit tests written using PHPUnit.