# Securing your site

Here are some tips to help you keep your site secure:

### Always use HTTPS

With the introduction of the [Let's Encrypt](https://letsencrypt.org/) project,
it's now free to get an SSL certificate for your website, so there's no reason
to not use HTTPS to secure all communication with your website.

With their [certbot](https://certbot.eff.org/) tool, you can completely automate
the process of acquiring an SSL certificate and renewing it too. If you're on
a host that doesn't give you SSH access to set this up yourself, [look them up
here](https://community.letsencrypt.org/t/web-hosting-who-support-lets-encrypt/6920)
to make sure they support Let's Encrypt and ask them to make sure you're using it.

While the use of HTTPS is usually configured at the web server level (e.g., Apache
or Nginx), you can enforce HTTPS at the application level in Elefant by adding
a `bootstrap.php` file to the root of your site with the following code:

```php
<?php

$controller->force_https ();
```

### Use key-based authentication instead of passwords over SSH

Disabling password-based shell access to your server and using public/private keys
instead increases your security because keys are much longer and way harder for
someone to crack. Just make sure to keep your private keys safe and backed up,
and never share or email them.

[Here's a great overview](https://www.digitalocean.com/community/tutorials/how-to-configure-ssh-key-based-authentication-on-a-linux-server)
of how to change over to key-based authentication courtesy of DigitalOcean.
The first part you only have to do once, and if you're using DigitalOcean's
services you simply click on the SSH key to add it to new instances so the
entire process becomes one-click easy.

For those not using DigitalOcean, the post also covers how to transfer your
public key to your server and install it, how to log in via SSH with your
keys, and how to disable password-based authentication once you have it
working.

### Don't make your database accessible to the internet

Some desktop database management software will connect remotely to your database
so you can browse your data and perform common operations on it. We recommend you
use a firewall to keep anything but port 22 (SSH) closed on your database server,
or ports 22, 80, and 443 (HTTP and HTTPS) if your database lives on the same
machine as your web server. [UFW](https://help.ubuntu.com/community/UFW) is an
easy-to-use firewall manager for Linux.

We recommend you dedicate a database exclusively to your site, with credentials
that are not shared with other databases, to decrease the likelihood of those
credentials being compromised externally as well as the degree of damage someone
could do with any given set of credentials in your overall system.

### Configure your mime types correctly

Misconfigured mime types in your web server can be used to make browsers treat
non-Javascript files as executable by a web browser, which can be used to trick
your site admins into uploading and unknowingly executing an exploit that gives
away access to your website.

Elefant provides a file manager that lets admins upload files to your site, which
are then served by the web server directly. This exposes a degree of risk if your
web server is not properly configured to use the correct mime types for a wide range
of file types.

Unknown file extensions should be set to something like `application/octet-stream`
instead of `text/plain`, so they're not treated as text and potentially as executable
Javascript. In Nginx, this would be done using the [default_type](https://nginx.org/en/docs/http/ngx_http_core_module.html#default_type)
directive. In Apache, this would be done with the [mod_mime](https://httpd.apache.org/docs/current/mod/mod_mime.html)
module.

It should also be noted that you should not blindly give out admin access to those
you do not trust, and Elefant can be [configured to limit access](https://www.elefantcms.com/docs/2.0/user-manual/users-and-roles)
to things like the file manager to only certain admins and not others, or to none
at all. However, we leave you to choose the level that best suits your needs.

> Note: Similarly, we recommend against using the [DB Manager](https://github.com/jbroadway/dbman) app on any live
> web site.

### Back up your data regularly

It's important to be able to recover, not just from a hack, but from other risks
like hardware failures which do happen. [Here's a basic shell script](https://gist.github.com/jbroadway/a669e25fc4a71fa11ad3801745947090)
you can use along with the [s3cmd](https://s3tools.org/s3cmd) tool to back your
Elefant website up automatically every day.

### Use environment variables to inject your app's secrets

Using environment variables instead of hard-coding app secrets like your database
credentials ensures your credentials can be stored safely using a tool like
[Vault](https://www.vaultproject.io/) and aren't written down in a config file
sitting on your web server.

This means that if your web server is compromised, the attacker won't find your
database password just lying around. They may still be able to escalate their
access, but not without additional effort.

See [[Administration / Environment variables]] for the list of environment
variables Elefant supports for injecting secrets like your database credentials,
and how to map them to other environment variable names if others are already
defined by your host or container management system.

### Containerize your application

Containers offer an additional level of isolation from the surrounding system
by putting each container in its own sandboxed environment. [Docker](https://www.docker.com/)
is the most popular container format, but others are emerging and standards
are forming to make them interoperable across the various container management
systems.

Container management is a complex topic and beyond the scope of this page, but
there are many tutorials out there about it. However, I'll add that you can find
pre-made containers for all of the requirements of a PHP-based app like Element on the
[Docker Hub](https://hub.docker.com/) directory, and tutorials to help create
a [Docker configuration for deploying PHP apps](https://linuxconfig.org/how-to-create-a-docker-based-lamp-stack-using-docker-compose-on-ubuntu-18-04-bionic-beaver-linux).

Next: [[Getting started / Troubleshooting]]
