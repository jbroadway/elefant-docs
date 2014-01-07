# Sharing your themes

To make your theme available to others, here are the steps:

1\. Go to [GitHub](http://github.com/) and register for a free account. Remember your GitHub username for step 4.

2\. Create a new public repository on GitHub. This is where your files will be stored online. Remember your repository name for step 4.

3\. Install [git](http://git-scm.com/) itself, or one of its [desktop clients](http://git-scm.com/downloads/guis).

4\. Create an `elefant.json` file and place it in your [theme folder](/docs/2.0/designers/making-your-own-theme). This is a [JSON](http://en.wikipedia.org/wiki/JSON)-formatted file that describes your theme (name, version, author, etc.). It is used by Elefant's theme installer to verify and install your theme onto someone else's website.

Your `elefant.json` file should contain the following:

~~~
{
    "type":         "theme",
    "folder":       "your-theme",
    "name":         "Your Theme Name",
    "version":      "1.0.0",
    "website":      "http://www.your-website.com/",
    "repository":   "git://github.com/github-username/repository-name.git",
    "author": {
        "name":     "Your Name",
        "email":    "you@your-website.com"
    },
    "requires": {
        "php": "5.3.6",
        "elefant": "1.3.6"
    }
}
~~~

Edit the values to reflect your theme info.

5\. Initialize your theme as a git repository and push your files to the server. These are the steps using git directly from the command line:

~~~
cd /var/www/layouts/your-theme
git init
git add *
git commit -m "Initial import" *
git remote add origin https://github.com/github-username/repository-name.git
git push origin master
~~~

...

## Sharing with Composer

Elefant apps and themes can also be shared through [Composer](http://getcomposer.org/), PHP's dependency manager. Here are the steps to sharing your theme through Composer and its package directory, [Packagist](https://packagist.org/).

1\. Follow the steps above to setup your shared theme.

2\. Create a `composer.json` file and place it in your theme folder.

...

[Here is a complete list of Elefant apps and themes available through Composer.](https://packagist.org/packages/elefant/)

Next: [[:Search engine optimization]]