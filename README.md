# Elefant Docs App

This app is the basis for the [Elefant CMS documentation](http://www.elefantcms.com/docs).
It provides the browsing functionality around pages stored in
[PHP Markdown](http://michelf.ca/projects/php-markdown/) format
in its `docs` folder.

It is meant to be used by forking it on Github and using Git to
manage pages in the `docs` folder. This way, documentation can
be collaborated on just as easily as source code.

# Usage summary

1. Fork this project on Github. This page will refer to the forked project as `project-docs`.
2. Add your pages to the `docs` folder (see below for more info).
3. Clone the project into the `apps/docs` folder of your [Elefant CMS](http://www.elefantcms.com/) installation:
		
		cd /path/to/your/site
		git clone https://github.com/user/project-docs.git apps/docs
		
4. Edit your `apps/docs/conf/config.php` file to customize your app settings.
5. Log into Elefant and go to Tools > Navigation. Add the new `Documentation` page to your site tree.

## Editing the docs

The documentation is written in [PHP Markdown](http://michelf.ca/projects/php-markdown/)
(with some small additions). The pages are stored as `.md` files in the `docs` subfolder
using the following naming convention:

    docs/1.0.md     # The docs index page for the 1.0 version
    docs/1.0-nav.md # The sidebar navigation for the 1.0 version
    docs/1.0/*.md   # Additional pages for the 1.0 version

The file names should be the "url-ified" equivalent of the page title,
as returned by [`URLify::filter()`](https://github.com/jbroadway/urlify).
For example:

    Getting started with Project Name -> getting-started-with-project-name

## Markdown extensions

The documentation is written in [PHP Markdown](http://michelf.ca/projects/php-markdown/)
with the following additions:

### Internal links

To link to a page within the documentation, you can use the following
format:

    [[Page title]]

This will link to `/docs/${CURRENT_VERSION}/page-title` with the link text
`Page title`, for example:

	<a href="/docs/1.0/page-title">Page title</a>

To link to a child page within the documentation, you can use the following
format:

    [[>Page title]

This will link to `/docs/${CURRENT_VERSION}/${CURRENT_PAGE}/page-title` with
the link text `Page title`, for example:

	<a href="/docs/1.0/current-page/page-title">Page title</a>

You can also ensure the page is a sibling of the current page like this:

    [[:Page title]

And of course if a page is nested, you can specify its path via:

    [[Parent page / Child page]]

This will create a link like the following:

	<a href="/docs/1.0/parent-page/child-page">Child page</a>

### Targets

Targets, are different audiences the documentation may be targeting. This could
be different languages (PHP, JavaScript), or platforms (PC, Mac, iOS), or
anything else.

Targets help to eliminate information that needs explaining to only
one group, but that would otherwise have to be repeated for the others
as well.

Here is the syntax to specify targets for different content:

    Show this content to everyone.
    
    --- Platform: Linux ---
    
    Show this content to Linux users.
    
    --- Platform: Mac ---
    
    Show this content to Mac users.
    
    --- Platform: Windows ---
    
    Show this content to Windows users.
    
    --- /Platform ---
    
    More content...

This will create a "Platform" select box in the top-right of the page contents
with options for Linux, Mac, and Windows. The first part is the name of the
type of target, following by the target name.

The first one is the default selected for new visitors, but it will set a
cookie to remember your preferences across site visits in the same browser.
