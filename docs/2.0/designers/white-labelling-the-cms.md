# White labelling the CMS

Creating a white label/custom branded CMS from Elefant is easy. To rebrand Elefant as your own CMS solution, follow these steps:

1\. Edit the file `conf/product.php` to point to your own custom product info. For example, say you wanted to call the CMS `Ultra CMS`, you would change it to something like this:

~~~ini
; <?php /*

name = Ultra CMS
website = "http://www.ultracms.com/"
logo_login = "/apps/admin/css/admin/ultracms_logo_login.png"
logo_toolbar = "/apps/admin/css/admin/ultracms_logo.png"
stylesheet = "/apps/admin/css/ultracms.css"

; */ ?>
~~~

2\. Duplicate the `apps/admin/css/admin.css` stylesheet to `apps/admin/css/ultracms.css` and make any style changes you want, such as custom colour choices.

3\. Duplicate the two logo files (`apps/admin/css/admin/elefant_logo.png` and `apps/admin/css/admin/elefant_logo_login.png`) to the ones named in your `conf/product.php`. Edit the new images in an image editor to replace the Elefant logo with your own custom logo.

That's it. Elefant should be completely rebranded as `Ultra CMS` and any references to Elefant throughout the system will automatically be updated.

Next: [[Developers]]