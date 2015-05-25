<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],
		
	'facebook' => [
		'client_id' => env('FACEBOOK_APP_ID','1540782392825687'),
		'client_secret' => env('FACEBOOK_APP_SECRET','9f0902b14809eb7f247a606fe3651a53'),
		'redirect' => env('FACEBOOK_REDIRECT_URL','http://demo.gogogo2u.com/'),
	],

	'google' => [
		'client_id' => env('GOOGLE_APP_ID'),
		'client_secret' => env('GOOGLE_APP_SECRET'),
		'redirect' => env('GOOGLE_REDIRECT_URL'),
	],

];
