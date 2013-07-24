# Elefant Documentation Project

This is the new source for the [Elefant documentation](http://www.elefantcms.com/docs).
Using Github, it becomes just as easy for contributors to help with
documentation as it is with Elefant's source code.

To help by adding new docs, or making edits and corrections, [fork
this repository](https://help.github.com/articles/fork-a-repo) and
commit your changes, then make a [pull request](https://help.github.com/articles/using-pull-requests)
to this project so they can be incorporated into the Elefant docs.

We've even added an edit link to the footer of each page, so that
you can just click that to fork and edit any page right from your
web browser!

This helps us track each change and makes it possible for as many
contributors to work on it at the same time without worrying about
squashing each others work.

> Note: To use this app for your own project's documentation, [fork it on
> Github here.](https://github.com/jbroadway/docs)

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

    Getting started with Elefant -> getting-started-with-elefant

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
