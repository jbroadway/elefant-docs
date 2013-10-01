# Troubleshooting

Here are some pointers to common issues people run into. For additional help, please post to our [support forum](/forum/).

### I see the error `Failed to generate cached template` in the web installer

If you're seeing this, you need to increase the file permissions for your site. See the [[Getting started / File permissions]] page for more information about what this means.

### I see a folder listing instead of the home page

If you're seeing this, your web server is not configured to call the `index.php` file by default, or it isn't reading the `.htaccess` file included with Elefant. If you're using the Apache web server, check that mod_rewrite is enabled, or try adding the line `DirectoryIndex index.php` to the `.htaccess` file.

### I see `<?php` tags in the home page

If you're seeing these, it means PHP is not working properly. Double check that your web server has PHP 5.3+ installed and configured correctly, or contact your hosting provider or system administrator for help.

### `/admin` and everything but the homepage comes up `Not found`

Make sure you've copied the `.htaccess` file to the server. It's often hidden in file browsers since its name starts with a `.` (called dot-files), but FTP programs usually make them visible or have a setting to do so. A trick to make sure you upload all the files is to upload the folder itself then copy the files into your site root.

If that doesn't fix it, and you're using the Apache web server, check that Apache's mod_rewrite module is enabled. This module is used to properly route requests into Elefant.

Also make sure Apache has the setting `AllowOverride All` in the `<Directory>` block around your virtual host.

### I keep getting a database connection error

Double check that the database connection information in `conf/config.php` is correct and that your database is running.

Next: [[User manual]]