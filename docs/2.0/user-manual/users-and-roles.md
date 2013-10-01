# Users and roles

To manage users and roles, go to Tools > Users.

Users include ordinary site members, as well as site administrators. Admin roles can edit pages and make changes to the site, whereas members can simply see members-only content.

There are three built-in roles, and new roles can be created at any time. These include:

* Member - Public site members
* Editor - Site admin that can edit content but cannot change settings
* Admin - A master admin role that can perform all admin tasks

## User settings

Click on the `Settings` link on the Users page to edit your site's user settings. These currently include the following options:

* Which social login methods to enable for the site. Supported methods include Facebook, Google, OpenID, Twitter, and Persona.
* Facebook app settings for authorizing Facebook logins.
* Twitter app settings for authorizing Twitter logins.

## User properties

Users have the following built-in properties:

* Name
* Email
* Password
* Role

Custom properties such as a company name, phone number, etc. can be added to users by clicking the `Custom Fields` link on the Users page. These will appear under the `Custom Fields` section of the user add/edit forms.

## User roles

To create a new user role, click on the `Roles` link on the Users page, then click the `Add Role` link on the Roles page.

Each role has a name and a series of checkboxes that specify the permissions for that role.

The first checkbox, labelled `Default access for this role`, determines whether Elefant should default to denying or allowing access to the various permissions. Checking it will also check every other permission, so you can then uncheck specific permissions to limit the role from accessing. For most roles, you will want to leave this unchecked.

Some examples of the available permissions include:

* Basic admin access - Is this an admin or a non-admin role?
* Create new content - Can this role create new site content?
* Delete content - Can this role delete content from the site?
* Edit site navigation - Can this role modify the site's navigation structure?
* Modify user accounts - Can this role add/remove users from the site?
* Post to the blog - Can this role publish to your site's blog?

The available permissions will grow as you install new Elefant apps, which may define their own custom permissions in addition to the core permissions.

Next: [[:Version control]]