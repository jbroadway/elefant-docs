# Custom user pages

Elefant's built-in user app provides default handlers for most common member-based site needs, including sign up, log in/out, password recovery, profile pages, and a profile update form. For example, you can include a user sidebar in your pages through the [Dynamic Objects](https://github.com/jbroadway/elefant/wiki/Dynamic-handlers-and-the-wysiwyg-editor) menu in the WYSIWYG editor, which includes a login form as well as links to the sign up and password recovery forms.

However, on many sites a one-size-fits-all solution just doesn't work. That's why the user app lets you specify which of these features you want to enable, as well as custom handlers that override the built-in functionality with your own.

Open the file `apps/user/conf/config.php` and you'll see a section called `[Custom Handlers]`. To disable a handler, such as the user signup, simply set it to Off like this:

	user/signup = Off

To specify an alternate signup form for your site, set it to the handler of your choice:

	user/signup = myapp/signupform

Now in `apps/myapp/handlers/signupform.php` you can include the code for your own custom signup form. Often the easiest way is to duplicate the default handler and use it as a guide while writing your own.

Once yours is ready, you can go to `/user/signup` on your site and it will load your custom `myapp/signupform` handler in place of the default action.