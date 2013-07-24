# Database API and models

The database layer is based on PDO, and consists of two libraries: `lib/DB.php` and `lib/Model.php`.

The former provides a connection manager that handles things like lazy-loading connections, master/slave marshalling for read/write requests, and a set of convenience functions around PDO for common database query types.

The latter provides a base class to extend when creating models to contain the logic for your apps. Of course, functions from the former are always available when adding custom methods to your models, but you'll likely interface with the database mostly through the Model API, since that's the best way to organize your app logic in Elefant apps.

## Connection

Database connections are created for you automatically in the global controller, from the settings in `conf/config.php`. A PDO connection can be retrieved any time via:

	<?php
	
	$conn = DB::get_connection ();
	
	?>

For writes, you would say:

	<?php
	
	$conn = DB::get_connection (1);
	
	?>

This is rarely needed in practice however, but good to understand how the database layer works (which is a very thin layer over PDO). It also sets two PDO connection attributes as well:

    PDO::ATTR_ERRORMODE = PDO::ERRMODE_EXCEPTION
    PDO::ATTR_DEFAULT_FETCH_MODE = PDO::FETCH_OBJ

So if you use the PDO connection directly, be aware of those settings.

### Replication support

Elefant transparently supports replicated databases, and knows to send writes to the master and reads are distributed randomly across slaves automatically with no extra code required.

Requests will die on connection failure only if all connections fail, or the master connection fails (since master is required for write commands). However, it will continue serving from the available connections if one or more of the slaves become unavailable.

### Next up

* [[Models]]
* [[Relations]]
* [[Validation in Models]]
* [[Flexible schemas with ExtendedModel]]
* [[Database convenience functions]]
