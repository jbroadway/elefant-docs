# Code example: Sending email

You can use the Mailer class (based on [Zend_Mail](http://framework.zend.com/manual/en/zend.mail.html) which [our benchmarks show](#php-email-library-benchmarks) is the leanest email package) to easily and reliably send emails.

Usage:

	<?php
	
	// Using Mailer::send() as a wrapper:
	$mail = Mailer::send (array (
		'to'          => array ('user@example.com', 'Joe User'),
		'from'        => array ('me@widgets.com', 'Alternate Sender'),
		'cc'          => array ('me@widgets.com', 'CC This Guy'),
		'bcc'         => array ('me@widgets.com', 'BCC This Guy'),
		'reply_to'    => array ('me@widgets.com', 'Reply to This Guy'),
		'subject'     => 'Subject line',
		'text'        => 'This is a plain text message.',
		'html'        => 'This is an <b>html</b> message.',
		'attachments' => array (
			'File data...',
			// or
			new Zend_Mime_Part ('File data...')
		)
	));
	
	// Using the Zend_Mail object directly:
	$mail = Mailer::getInstance ();
	$mail->setBodyText ('This is an email message.');
	$mail->setSubject ('Subject line');
	$mail->addTo ('user@example.com', 'Joe User');
	// Etc.
	$mail->send ();
	
	?>

## Error handling

Since `Mailer` is a simple wrapper around `Zend_Mail`, it does not catch exceptions thrown by `Zend_Mail` for you. To handle errors, use the following pattern:

	<?php
	
	// Using Mailer::send() as a wrapper:
	try {
		$mail = Mailer::send (array (
			'to'          => array ('user@example.com', 'Joe User'),
			'from'        => array ('me@widgets.com', 'Alternate Sender'),
			'subject'     => 'Subject line',
			'text'        => 'This is a plain text message.'
		));
	} catch (Exception $e) {
		// Handle mail error
	}
	
	?>

## PHP email library benchmarks

Benchmark source:

https://github.com/jbroadway/php-mail-test

Memory usage for initializing and sending a single email message through the default Sendmail transport method:

* Baseline `mail()` - 632 KB
* PHPMailer - 1862 KB
* Swift Mailer - 3641 KB
* Zend_Mail - 1511 KB

Clearly, Zend_Mail is by far the most efficient email library of those we tested.