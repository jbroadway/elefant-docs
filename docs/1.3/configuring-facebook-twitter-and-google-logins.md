# "Configuring Facebook

-Twitter,-and-Google-logins","Elefant's user app supports logins via Facebook, Twitter, Google, and OpenID. To enable these, you need to edit the file `apps/user/conf/config.php` in a couple places:

## Choosing your login methods

~~~
; You can enable or disable alternative login methods here.
; Each name corresponds to a handler in apps/user/handlers/login.

login_methods[] = openid
login_methods[] = google
;login_methods[] = twitter
;login_methods[] = facebook
~~~

Uncomment or comment out the login methods shown above to enable or disable them.

> Note: Google and OpenID don't require any further configuration, but you'll need to follow the steps below for Facebook and Twitter support.

## Configuring Facebook login support

Visit [https://developers.facebook.com/apps](https://developers.facebook.com/apps) and register your website as a Facebook app. Make sure you enter the correct domain for your site, since Facebook will only allow authentication and perform the necessary callback request to this domain.

This will generate `application_id` and `application_secret` values on Facebook. Copy and paste them into the section below:

~~~
[Facebook]

; To enable Facebook login support, register your site at
; https://developers.facebook.com/apps to generate the following
; values for your site.

application_id = """"
application_secret = """"
~~~

## Configuring Twitter login support

Visit [https://dev.twitter.com/apps/new](https://dev.twitter.com/apps/new) and register your website with Twitter. This will generate `consumer_key` and `consumer_secret` values on Twitter. Copy and paste them into the section below:

~~~
[Twitter]

; To enable Twitter login support, register your site at
; https://dev.twitter.com/apps/new to generate the following
; values for your site.

consumer_key = """"
consumer_secret = """"
~~~

Save the `apps/user/conf/config.php` file and you should see your chosen login methods in the user sidebar block on your site.

Next: [[White labelling the CMS]]"
