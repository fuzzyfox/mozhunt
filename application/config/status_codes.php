<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| Status Codes
| -------------------------------------------------------------------
| This file contains an array of status codes for conversion from int to human
| readable string
*/
$config['status_codes'] = array(
	'user' => array(
		0 => 'Administrator',
		1 => 'Support Administrator',
		2 => 'Hider',
		3 => 'Player',
		4 => 'Pending',
		5 => 'Inactive',
		100 => 'Guest'
	),
	'domain' => array(
		0 => 'Active',
		1 => 'Pending',
		2 => 'Revoked',
		3 => 'Deleted'
	),
	'token' => array(
		0 => 'Active',
		1 => 'Revoked',
		2 => 'Deleted',
		3 => 'Disabled'
	)
);