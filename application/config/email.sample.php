<?php
	
	/**
	 * This file contains the needed configuration for sending emails as
	 * noreply@mozhunt.com
	 *
	 * @author William Duyck <william@mozhunt.com>
	 * @version 2012.04.06
	 */
	
	$config['protocol']     = 'smtp';
	$config['useragent']    = 'mozhunt';
	$config['smtp_host']    = 'ssl://smtp.gmail.com';
	$config['smtp_user']    = 'noreply@mozhunt.com';
	$config['smtp_pass']    = '';
	$config['smtp_port']    = '465';
	$config['charset']      = 'iso-8859-1';
	$config['newline']      = "\r\n";