# Sharing your themes

To make your theme available to others, here are the steps:

1\. Go to [GitHub](http://github.com/) and register for a free account. Remember your GitHub username for step 4.

2\. Create a new public repository on GitHub. This is where your files will be stored online. Remember your repository name for step 4.

3\. Install [git](http://git-scm.com/) itself, or one of its [desktop clients](http://git-scm.com/downloads/guis).

4\. Create an `elefant.json` file and place it in your [theme folder](/docs/2.0/designers/making-your-own-theme). This is a [JSON](http://en.wikipedia.org/wiki/JSON)-formatted file that describes your theme (name, version, author, etc.). It is used by Elefant's theme installer to verify and install your theme onto someone else's website.

Your `elefant.json` file should contain the following:

~~~json
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

~~~bash
cd /var/www/layouts/your-theme                   # <- adjust this path
git init                                         # initialize a new repository
git add *                                        # add your files to the repository
git commit -m "Initial import" *                 # commit the changes
git remote add origin \
    https://github.com/user/repository.git       # <- adjust the user and repository
git push origin master                           # upload the changes to github
~~~

Using GitHub for Mac, once you set your account info in the app, you would select File > New Repository and enter your theme info in the dialog that opens up. It should look like this:

![GitHub for Mac - New repository](/apps/docs/docs/2.0/pix/github-for-mac-new-repo.png)

## Sharing with Composer

Elefant apps and themes can also be shared through [Composer](http://getcomposer.org/), PHP's dependency manager. Here are the steps to sharing your theme through Composer and its package directory, [Packagist](https://packagist.org/).

1\. Follow the steps above to setup your shared theme.

2\. Create a `composer.json` file and place it in your theme folder. This tells Composer about your package and how to install it.

Your `composer.json` file should contain the following:

~~~json
{
    "name": "elefant/theme-yourtheme",
    "type": "elefant-theme",
    "description": "Description of your theme for the Elefant CMS",
    "keywords": ["theme", "design", "layout", "template", "elefant", "cms", "app"],
    "license": "MIT",
	"authors": [
		{
			"name": "Your Name",
			"email": "you@your-website.com",
			"homepage": "http://www.your-website.com/"
		}
	],
    "repositories": [
        {"type": "git", "url": "http://github.com/jbroadway/theme_installer"}
    ],
    "require": {
        "elefant/theme-installer": "*"
    }
}
~~~

Edit the values to reflect your theme info.

3\. Add your `composer.json` file to the repository and upload it to GitHub. From the command line, here are the steps:

~~~bash
cd /var/www/layouts/your-theme                   # <- adjust this path
git add composer.json                            # add the new file
git commit -m "Add composer file" composer.json  # commit the changes
git push origin master                           # upload the changes to github
~~~

In GitHub for Mac, you would open the project, then under `Uncommitted Changes` select the `composer.json` file and make a new commit. Click `Sync Branch` to upload the new file to GitHub.

4\. Create a new account at [Packagist](https://packagist.org/), then click `Submit Package`. Paste the clone URL from your GitHub project page into the `Repository URL` field on Packagist. This can be found on the right side of the GitHub page and looks like this:

![GitHub clone URL](/apps/docs/docs/2.0/pix/github-clone-url.png)

Users should now be able to install your theme via Composer like this:

~~~bash
composer require elefant/theme-mytheme
~~~

[Here is a complete list of Elefant apps and themes available through Composer.](https://packagist.org/packages/elefant/)

Next: [[:Search engine optimization]]