# Building a layout file from scratch

Let's walk through building a layout from a blank HTML file until it includes all the essentials of an Elefant layout.

## Starting out

Let's take the most basic HTML outline to start with:

~~~
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
</body>
</html>
~~~

## Title and body

This in itself is a valid Elefant layout, it simply doesn't display anything dynamic. First, let's add our page title and body to the `<body>` area.

    <!DOCTYPE html>
    <html>
    <head>
        <title></title>
    </head>
    <body>
    <h1>{{ title }}</h1>
    {{ body }}
    </body>
    </html>

Our layout will now include the title and body contents from any page in the site. However, it's good practice to do two more things before moving on from these:

1. Our title may be blank, so let's wrap it in a condition:

    {% if title %}<h1>{{ title|none }}</h1>{% end %}

2. Our page title and body may contain HTML or other special symbols (non-ascii characters for example), so let's disable the default output filter that replaces `<` and `>` characters with `&lt;` and `&gt;` for security purposes:

~~~
{{ body|none }}
~~~

## Window title

Now let's add the site name and title to the `<title>` tag. Elefant allows you to have separate titles for menus and for the browser window, called `{{ menu_title }}` and `{{ window_title }}`, so here we'll use one of those.

We're also going to call a special function that pulls the site name from the global configuration settings of the site, so that the site name prefixes the specific title of a given page in the browser window bar.

~~~
<head>
    <title>{{ conf('General', 'site_name') }} - {{ window_title|none }}</title>
</head>
~~~

The first tag literally calls the following PHP code:

~~~
echo conf('General', 'site_name');
~~~

## Heads and tails

Elefant's admin interface requires a special tag to be inserted into our templates in order for it to be loaded. The whole admin interface is essentially an include in our templates, and without it our templates can still power a website, but we lose all the benefits of the CMS running behind the scenes.

Just before the closing `</head>` tag, add two lines:

~~~
<html>
<head>
    <title>{{ conf('General', 'site_name') }} - {{ window_title|none }}</title>
    {! admin/head !}
    {{ head|none }}
</head>
~~~

And just before the closing `</body>` tag, add one line:

~~~
{{ tail|none }}
</body>
</html>
~~~

The first line includes the Elefant admin interface. For advanced users, it translates into the following PHP code:

~~~
echo $controller->run ('admin/head');
~~~

The other two lines are just ordinary variables like `{{ title }}` and `{{ body|none }}`. Because some Elefant pages are dynamic and call out to PHP code that may in turn want to include some extra Javascript code, these are like placeholders that tell Elefant ""you can put any scripts you need to here"".

The reason there are two is that some Javascript needs to be loaded inside your `<head></head>` tags, and some is better left for the end of the page, after your content has rendered.

## Putting it all together

Now that we have all our tags in place, our HTML should look like this:

    <html>
    <head>
        <title>{{ conf('General', 'site_name') }} - {{ window_title|none }}</title>
        {! admin/head !}
        {{ head|none }}
    </head>
    <body>
    {% if title %}<h1>{{ title|none }}</h1>{% end %}
    {{ body|none }}
    
    {{ tail|none }}
    </body>
    </html>

Now we're ready to add things like stylesheets and other markup to build out the design of our site.

Next: [[Creating editable areas]]