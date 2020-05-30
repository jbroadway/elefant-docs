# Database configurations

The database configuration section is a list of one or more connections. The main connection should be named `master`, and the connection parameters needed depends on the database being used (SQLite, MySQL, or PostgreSQL).

Here are some examples of common configurations.

## SQLite connection

~~~ini
master[driver] = sqlite
master[file] = "conf/site.db"
~~~

## MySQL basic

~~~ini
master[driver] = mysql
master[host] = "localhost:3306"
master[name] = my_db
master[user] = my_user
master[pass] = "********"
~~~

## MySQL master/slave

~~~ini
master[driver] = mysql
master[host] = "192.168.101.123:3306"
master[name] = my_db
master[user] = my_user
master[pass] = "********"

slave_one[driver] = mysql
slave_one[host] = "192.168.101.234:3306"
slave_one[name] = my_db
slave_one[user] = my_user
slave_one[pass] = "********"
~~~

# PostgreSQL connection

~~~ini
master[driver] = pgsql
master[host] = "localhost:5432"
master[name] = my_db
master[user] = my_user
master[pass] = "********"
~~~

Next: [[:Setting up dev, staging, and production environments]]