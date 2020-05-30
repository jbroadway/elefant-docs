# Browser detection

Elefant includes a basic browser detection function based on the user agent of the
client, via the `detect()` function. This is handy for use in device- or
browser-specific layout changes, and in providing alternate execution paths for
different devices.

## Usage

In PHP, it's as simple as:

~~~php
<?php

if (detect ('ipad')) {
	$page->add_script ('/js/for-ipad-only.js');
} elseif (detect ('iphone')) {
	$page->add_script ('/js/for-iphone-only.js');
} elseif (detect ('android')) {
	$page->add_script ('/js/for-android-only.js');
} else {
	$page->add_script ('/js/for-everything-else.js');
}

?>
~~~

Similarly, in a template, you can use it like this:

~~~html
{% if detect('mobile') %}
	<link rel="stylesheet" href="/css/mobile.css" />
{% else %}
	<link rel="stylesheet" href="/css/default.css" />
{% end %}
~~~

## Options

`detect()` is very simple, but allows you to detect any of the following browsers.
Note that these are the strings you pass to `detect()`, and aliases are listed after
the first on one line.

 * `msie`, `ie`
 * `firefox`, `ff`, `moz`
 * `chrome`
 * `safari`
 * `webkit`
 * `opera`
 * `opera mini`
 * `opera mobi`
 * `ios`
 * `iphone`
 * `ipad`
 * `android`
 * `iemobile`
 * `webos`
 * `blackberry`
 * `googlebot`
 * `bot`
 * `mobile`
 * `tablet`

## Notes

It's good to know some edge cases that may surprise you in `detect()`. Here are some notes to better understand how it works:

* `mobile` and `tablet` matches are not exhaustive, they only list the common platforms.
* iPods are reported as mobile devices in the user agent string, so `detect()` reports that to be true as well.
* Android reports true for both mobile and tablet.
* Some matches might be seen as false-positives, such as Chrome matching Safari. In these cases, look at other detection options. For example, you may want to specify `webkit` instead of a particular browser.
* No version detection. For IE version-specific needs, use conditional comments in your HTML, or use a string like `msie 10`.
* Other lowercase strings that are not listed above can be used as well, for example `wap`, or `smartphone`.

Next: [[:Hooks, Elefant's event system]]
