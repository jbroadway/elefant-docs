# Date time formatting and time zones

Elefant 1.3 introduces new template filters for outputting dates and times formatted and adjusted to the current user's time zone. Here's how you can use them in your views:

1. Include the `admin/util/dates` handler in your view template that loads the necessary JavaScript to convert the dates once the page has loaded. Simply add this line anywhere in your view file:

	{! admin/util/dates !}

2. Use one of these five filters for your dates and times:

	{{ date_value|I18n::time }}
	{{ date_value|I18n::date }}
	{{ date_value|I18n::short_date }}
	{{ date_value|I18n::date_time }}
	{{ date_value|I18n::short_date_time }}

These will display dates and times in the following formats (with the month names translated into the available languages as well):

	5:30PM
	January 16, 2012
	Jan 16
	April 8, 2012 - 11:02AM
	Apr 8 - 11:02AM

## How it works

First, the date filters wrap the date in a `<time>` tag that looks like this:

	<time class=""date"" datetime=""2012-01-16T11:02:00+00:00"">January 16, 2012</time>

Next, the jQuery localize plugin is used to adjust the dates shown for the current user's time zone like this:

	$('time.date').localize ('mmmm d, yyyy');

Dates are displayed initially in UTC, but as soon as the page loads they are converted and the value in the `<time>` tag is updated with the correct date/time for the current user.

The reason we have to take these steps is that PHP doesn't know the current user's time zone, so we have to pass it off to JavaScript to determine that info.

## Storing dates

Dates should always be stored in UTC. To get the current date/time, simply use:

	$date = gmdate ('Y-m-d H:i:s');

This value is ready to be stored in the database or sent to the user via the I18n date/time filters. Note that the filters can use date strings as well as unix timestamps as returned by the PHP `time()` function.