# Docker-based development

This page will take you through the steps to setup and use multiple Docker apps each running their own instance of Elefant, with the goal of easily switching between instances for local development of multiple websites.

At the end of these steps, you'll have an app with the following containers connected and working together:

- Apache + PHP-FPM + Elefant CMS configured for local development
- MariaDB as a connected data store
- Redis as a connected cache server
- Beanstalkd as a connected worker queue
- PHP-CLI container running all Elefant CMS worker scripts

Each instance will be accessible through the web browser via `www.sitename.lo` domains. The `.lo` is a fake top-level domain that's short for "local".

> Note: Some steps are macOS-specific, but the equivalent Docker setup could be used on Windows or Linux.

## Setup

First, install the following prerequisites:

- [Docker Desktop for Mac](https://hub.docker.com/editions/community/docker-ce-desktop-mac)
- [Homebrew](https://brew.sh/)
- [Composer](ttps://getcomposer.org/)

Next, install and configure [DnsMasq](https://thekelleys.org.uk/dnsmasq/doc.html) using the following terminal commands:

~~~bash
brew install dnsmasq
sh -c 'echo "address=/.lo/127.0.0.1\naddress=/.lo/::1\n" > /usr/local/etc/dnsmasq.conf'
sudo mkdir -p /etc/resolver
sudo sh -c 'echo "nameserver 127.0.0.1\n" > /etc/resolver/lo'
sudo brew services start dnsmasq
~~~

## Creating an instance

For this setup, we're going to assume each project lives in its own `~/projects/sitename/www` folder. If you'd like them to point somewhere else, feel free to adjust this path in the commands below.

Use the following commands to download the Elefant CMS into this folder:

~~~bash
mkdir -p ~/projects/sitename
cd ~/projects/sitename
composer create-project elefant/cms www
~~~

We now have a local copy of Elefant in what will be our new project root folder.

The next step is one **we only have to do the first time**, which will build `elefant-dev` and `elefant-worker` Docker images that we can then reuse on each subsequent project. To build the containers, run:

~~~bash
cd ~/projects/sitename/www
make dev
make worker
~~~

Before we spin up a Docker app, we're going to edit the `docker-compose.yml` file that ships with Elefant and change two lines:

1. Change both instances of `ELEFANT_DOMAIN: "localhost:8080"` to `ELEFANT_DOMAIN: "www.sitename.lo"` to let Elefant know that's the domain we'll be using.
2. Change `"8080:80"` to `"80:80"` under the `www` service's `ports` section so we don't need to include a port number when accessing our instances in a browser.

Feel free to customize other settings as needed, such as the development database credentials or the default password (`ELEFANT_DEFUALT_PASS`).

> Note: The default Elefant username is `you@example.com`. You may change this along with changing your password when you first log into your new site.

Once you're happy with your configuration, you should now be ready to spin up your instances via:

~~~bash
docker compose -p sitename up -d
~~~

This will create and run a Docker app named `sitename` with the following containers:

- `sitename-beanstalkd-1` - Beanstalkd container.
- `sitename-mysql-1` - MariaDB container.
- `sitename-redis-1` - Redis container.
- `sitename-worker-1` - PHP-CLI container.
- `sitename-www-1` - Apache + PHP-FPM container.

The `-d` flag means it should detach from the current terminal and run as a background process.

Your `~/projects/sitename/www` folder will be mapped to the document root of the web server and worker containers so any changes you make will be immediately reflected upon refreshing your browser.

Note that you must restart the `sitename-worker-1` container for worker changes to take effect, but there's no need to restart the whole app.

To see your new site, visit [https://www.sitename.lo/](https://www.sitename.lo/). If all went well, you should see the default Elefant homepage with a login form along the top.

You can now start and stop your project's Docker-based development environment for your Elefant-powered site, and have a repeatable process for creating additional development environments for new Elefant-powered sites.

## Running background workers

To configure Elefant to connect to Beanstalkd, edit `conf/config.php` and change the `[JobQueue]` settings to the following:

~~~ini
backend = beanstalkd
host = beanstalkd
port = 11300
~~~

To add a background worker script to the list to run in the `sitename-worker-1` container, edit the file `conf/workers.php` and add the worker script to the list. There's an example worker script in `apps/jobqueue/handlers/worker.php` that you can use as the basis for writing your own.

> Note that changes to your worker scripts will only take effect when you restart the `sitename-worker-1` container.

To help see what's going on with your worker queues, you can also visit `http://localhost:2080/` to access a Beanstalkd console. The default username and password are `bean_admin` and `bean_pass`, which can be changed in the docker compose file if you'd like.

To see your worker queues, connect the console to your Beanstalkd server at `beanstalkd:11300`.

## Watching your server logs

To tail the output of your web server log output, you can use the following Docker command:

~~~
docker logs -f --details sitename-www-1
~~~

This will continuously output your web server logs as you develop and make requests for pages.

Similarly, you can tail the output of your workers with the following command:

~~~
docker logs -f --details sitename-worker-1
~~~

This is a great way to watch for errors as you develop.

Next: [[:File permissions]]
