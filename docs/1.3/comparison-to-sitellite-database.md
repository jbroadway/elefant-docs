# Comparison to Sitellite: Database

Back to [[Comparison to Sitellite CMS]].

***

Elefant borrows its core database functions directly from Sitellite, but renames them from `db_*()` to `DB::*()`. It strays from Sitellite in providing a database connection manager that supports lazy-loading, master/slave awareness (reads are sent to master automatically), and uses a base `Model` class for organizing application logic.

The functions from Sitellite that Elefant supports are:

* `DB::error()` - Return the last error message
* `DB::execute()` - Execute and return boolean
* `DB::fetch()` - Fetch an array of objects
* `DB::last_id()` - Fetch the last inserted id
* `DB::pairs()` - Fetch an associative array of two fields
* `DB::shift()` - Fetch a single field from the first result
* `DB::shift_array()` - Fetch an array of a single field
* `DB::single()` - Fetch a single object

The PDO connections are stored in a static Database object and can be retrieved via `DB::get_connection()`.

From here, the two diverge. Sitellite uses its collections with lots of introspection and layers, and Elefant opts for a very stripped down `Model` class (see [[Database API and models]]).