# Blogging

The blog app comes installed by default in Elefant, and is a simple but customizable blogging engine with everything you need for the average company or personal blog.

## Configuring your blog

Elefant has several blog options you can configure. Log in and go to Tools > Blog Posts > Settings to customize the following blog settings:

* Blog title - The name of the blog (defaults to "Blog")
* Page layout - The layout template to use for the main blog pages
* Post page layout - The layout template to use for blog post pages
* Comments - Choose from Disqus, Facebook comments, the [Comments app](https://github.com/jbroadway/comments), or "Off" to disable comments
* Edit posts with - Choose from the [[:WYSIWYG Editor]] or [Markdown formatting](http://daringfireball.net/projects/markdown/) to write your posts
* Limit post previews - The number of characters to limit post sizes on listing pages
* Social buttons - Whether to include share buttons for Twitter, Facebook, and Google+

## Writing posts

You can write blog posts under Tools > Blog Posts. You can also import posts from an existing Wordpress or Blogger site, or from a CSV file under Tools > Blog Posts > Import Posts.

## Adding the blog to your site

You can visit the blog on your site at the URL `/blog`, and you can include it in your site navigation by dragging and dropping it into your site tree under Tools > Navigation.

You can also embed certain blog elements into pages or blocks via the [[:Dynamic Objects]] dialog, including:

* Headlines - Embed links to your latest blog posts
* Latest Posts - Embed the latest blog posts into the current page
* Tag Cloud - Embed a tag cloud into the current page
* RSS Viewer - Takes an external RSS link and embeds it into your site

Your blog's RSS feed is also available at the URL `/blog/rss`.

Next: [[:Uploading files]]