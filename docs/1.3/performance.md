# Performance

[Click here for benchmarks](/wiki/PHP-Framework-Benchmarks) against several other frameworks (CakePHP, CodeIgniter, FatFree, FuelPHP, Kohana, Laravel, Silex, Symfony, Yii, and Zend).

I've also added [template benchmarks comparing Elefant, Twig, and Smarty 3 here](https://github.com/jbroadway/template-bench), and [database abstraction layer benchmarks comparing Elefant, Doctrine, Idiorm/Paris, Propel, RedBean, and Zend_Db here](https://github.com/jbroadway/php-dbal-bench).

## Memory usage

The output of `memory_get_peak_usage()` for the homepage of a default Elefant installation is 1700504 (1.6MB).

This is a very good indicator of real memory usage, since it makes use of all the core elements of the framework: routing, controllers, template rendering, ORM/database usage, dynamic embeds within templates (the homepage slideshow), i18n, output escaping, and user auth checking.

This compares [very favourably against other frameworks](http://www.laurencegellert.com/2011/06/memory-usage-in-php-frameworks/).

This is not a hello world, this is a complete and working website making use of all the advanced features of Elefant, and yet it uses a fraction of the memory most other frameworks do.

Memory usage directly affects how many requests your site can serve.

> Also, see [this post](http://www.elefantcms.com/forum/discussion/42/big-memory-reduction-with-php-5.4/p1) about Elefant's memory usage dropping by half with PHP 5.4!

## Javascript/CSS optimization

In addition to compiled templates, built-in gzip compression, and Memcache support, Elefant also has a very easy to use add-on for compiling and optimizing your other assets (CSS, Javascript), [available here](https://github.com/jbroadway/assetic). This add-on can drastically reduce your bandwidth and page rendering times automatically, and integrates seamlessly into the Elefant development workflow.

## Older `ab` tests

Here are a couple encouraging - albeit not very scientifically rigorous - performance tests. The test calls the default `admin/page` handler on a default installation using SQLite as the database. The front controller routes the request to the appropriate handler, which then fetches a page using the `Webpage` model, sends it to the `admin/base` view to render the page body, then on to the default layout template to render the final output. As such this is a decent indicator of the overall performance of the framework itself, since it touches most areas of it.

Default Apache on OSX Snow Leopard running `ab` on the same machine (iMac 3GHz duo):

~~~
$ ab -n 10000 -c 100 http://www.elefant.lo/
This is ApacheBench, Version 2.3 <$Revision: 655654 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking www.elefant.lo (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests

Server Software:        Apache/2.2.17
Server Hostname:        www.elefant.lo
Server Port:            80

Document Path:          /
Document Length:        170 bytes

Concurrency Level:      100
Time taken for tests:   21.037 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Total transferred:      3925880 bytes
HTML transferred:       1702550 bytes
Requests per second:    475.35 [#/sec] (mean)
Time per request:       210.373 [ms] (mean)
Time per request:       2.104 [ms] (mean, across all concurrent requests)
Transfer rate:          182.24 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0   10  24.6      1     189
Processing:     5  199  66.3    192     705
Waiting:        1  191  66.3    187     674
Total:         15  210  62.1    195     705

Percentage of the requests served within a certain time (ms)
  50%    195
  66%    202
  75%    206
  80%    213
  90%    275
  95%    343
  98%    402
  99%    505
 100%    705 (longest request)
~~~

Now with APC enabled:

~~~
$ ab -n 10000 -c 100 http://www.elefant.lo/
This is ApacheBench, Version 2.3 <$Revision: 655654 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking www.elefant.lo (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests

Server Software:        Apache/2.2.17
Server Hostname:        www.elefant.lo
Server Port:            80

Document Path:          /
Document Length:        170 bytes

Concurrency Level:      100
Time taken for tests:   11.176 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Total transferred:      3920000 bytes
HTML transferred:       1700000 bytes
Requests per second:    894.81 [#/sec] (mean)
Time per request:       111.755 [ms] (mean)
Time per request:       1.118 [ms] (mean, across all concurrent requests)
Transfer rate:          342.55 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    5  13.9      1     132
Processing:     6  107  33.4    101     431
Waiting:        2  103  32.7     98     431
Total:         13  112  30.5    102     433

Percentage of the requests served within a certain time (ms)
  50%    102
  66%    106
  75%    109
  80%    114
  90%    147
  95%    185
  98%    207
  99%    237
 100%    433 (longest request)
~~~

I would like to do similar tests on nginx + fpm as well at some point, or if anyone else wants to run some tests I'd love to see them too.

---

Here's a small benchmark I ([ZaneA](http://github.com/ZaneA)) did on my local Nginx + fpm setup. Note that this is with APC enabled and using only 2 PHP child processes. Also the default page has changed a bit since the benchmarks above and so is returning a slightly longer document.

~~~
d3v:web/ % ab -n 10000 -c 100 http://elefant.www/
This is ApacheBench, Version 2.3 <$Revision: 655654 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking elefant.www (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        nginx
Server Hostname:        elefant.www
Server Port:            80

Document Path:          /
Document Length:        2929 bytes

Concurrency Level:      100
Time taken for tests:   11.596 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Total transferred:      33030000 bytes
HTML transferred:       29290000 bytes
Requests per second:    862.33 [#/sec] (mean)
Time per request:       115.965 [ms] (mean)
Time per request:       1.160 [ms] (mean, across all concurrent requests)
Transfer rate:          2781.52 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.2      0      14
Processing:    18  115  32.1    107     387
Waiting:       10  115  32.1    107     387
Total:         30  115  32.4    107     398

Percentage of the requests served within a certain time (ms)
  50%    107
  66%    108
  75%    109
  80%    110
  90%    120
  95%    154
  98%    240
  99%    290
 100%    398 (longest request)
~~~