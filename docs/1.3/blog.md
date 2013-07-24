# Blog

The blog app comes installed by default in Elefant, but has several options you can configure. Edit the file `apps/blog/conf/config.php` and you can adjust the following options:

* Blog title - name of the blog (defaults to ""Blog"")
* Blog layout - layout template to use for the main blog pages
* Blog post layout - layout template to use for blog post pages
* Blog comments - set to ""facebook"" by default to use Facebook's social comments, or set to ""Off"" to disable
* Twitter username/password - set these if you want blog posts to be auto-tweeted when you post them

You can write blog posts under Tools > Blog Posts, and you can visit the blog on your site at the URL `/blog`. You can also embed certain blog elements into editable blocks via the Dynamic Objects dialog, including:

* Latest Headlines - last 10 blog posts
* Tag Cloud - popular tags
* RSS Viewer - takes an external RSS link and embeds it into your site

> Note: The Dynamic Objects dialog is the last button on the right of the WYSIWYG editor:

![Dynamic Objects button](http://www.elefantcms.com/files/docs/dynamic-objects-icon.png)

### Including the blog in your site navigation

To include your blog as a page in your site navigation, follow these steps:

1. Create a [redirect page](/wiki/Redirecting-Pages) that points to `/blog`. Make sure its page ID is something other than `blog` (`blog-link`,  `our-blog`, or even `news` all work)
2. Go to Tools > Navigation and add your new page to the site tree.

Next: [[Files]]