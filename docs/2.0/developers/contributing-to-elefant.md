# Contributing to Elefant

Elefant is an open source project, which means we're always looking for new community members to help push the project forward. Here are some ways you can get involved:

* [Improve the documentation](https://github.com/jbroadway/elefant-docs#elefant-documentation-project)
* [Translate Elefant into a new language](/docs/2.0/administration/multilingual-setup)
* [Create a new design theme](/docs/2.0/designers/sharing-your-themes)
* [Help test and fix bugs](https://github.com/jbroadway/elefant/issues?_=1336681340159&state=open)

## Contributors

[Here is a list of contributors to the Elefant project.](/docs/2.0/developers/contributing-to-elefant/contributors)

## License

Elefant is licensed under the [MIT software license](/docs/2.0/developers/contributing-to-elefant/license).

## Code conventions

The basic naming conventions are outlined on the [[>code conventions]] page.

The core design principles and architectural overview are here and here:

* [[>Elefant design principles]]
* [[>Elefant architecture]]

## Contributing code

To hack on Elefant, please [create a fork of the repository](http://github.com/jbroadway/elefant), create a feature branch, and make your changes there.

If you are working on a feature or bug listed in our [Github issues](https://github.com/jbroadway/elefant/issues?_=1336681340159&state=open), please add a comment on the issue to let others know you've ""claimed"" it like this:

	Working on this in [https://github.com/username/elefant/tree/branchname]

The link should point to the branch in your fork on Github.

Once you have changes to be included in the main repo, create a pull request so we can track and review the changes before committing.

[Here's a great tutorial on the GitHub development process.](http://gun.io/blog/how-to-github-fork-branch-and-pull-request/)

### Branching policy

Elefant's branching scheme works as follows:

* `master` - This is the main development branch that new features are pulled into, but should always be relatively stable since new features are implemented in their own branches.
* `a.b` - Each minor release gets a new branch (e.g., `1.0`) so that updates can be made for it as needed.
* `feature-x` - Separate branch for ""feature x"", to be merged into `master` when complete.

Releases are tagged on the branch they were made, using the naming convention `elefant_a_b_c_status` e.g., `elefant_1_1_2_beta`.

### Version numbers

Elefant uses three-digit version numbers of the form `a.b.c` where `a` is the major release number, `b` is the minor release number, and `c` is the bug fix release number.

Odd minor release numbers are considered development releases leading up to the next even number. For example, `1.1.x` is a development release leading up to a stable `1.2.0` release.

Releases are also tagged with a status descriptor, which is one of:

* `alpha` - Incomplete or partially finished work.
* `beta` - Working but needs testing.
* `rc` - A release candidate, requesting further testing before calling it stable.
* `stable` - A release that is considered stable and well tested.

## Running Elefant's unit tests

Elefant uses [PHPUnit](http://www.phpunit.de/manual/current/en/index.html) to run its test suite.

The database-bound tests use an in-memory SQLite database instead of mock objects.

The MongoModel tests require a locally running [MongoDB](http://www.mongodb.org/) instance, but will be skipped if the `mongo` PHP extension is not installed or a MongoDB connection cannot be established on `localhost:27017`.

To run an individual test, use:

	$ cd /path/to/your/site
	$ phpunit tests/CacheTest.php

To run the full suite of tests, use:

	$ cd /path/to/your/site
	$ phpunit tests

Next: [API reference](http://api.elefantcms.com/)
