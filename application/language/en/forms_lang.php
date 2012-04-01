<?php
	
	
	/**
	 * English language file for the mozhunt forms
	 * 
	 * This file contains all the strings that can be translated for the
	 * mozhunt system that relate to the forms on the site.
	 *
	 * ALL language keys must be prefixed with `form.{form name}.`
	 *
	 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
	 * @version 2012-03-31
	 */
	
	/*
	 Generic Form Strings
	*/
	$lang['form.invalid.chars'] = 'The %s you entered contains invalid characters';
	
	/*
	 Contact Form
	*/
	$lang['form.contact.legend'] 				= 'Send us an email';
	// name
	$lang['form.contact.name.label'] 			= 'Name';
	$lang['form.contact.name.placeholder'] 		= 'Jo Doe';
	// email
	$lang['form.contact.email.label'] 			= 'Email';
	$lang['form.contact.email.placeholder'] 	= 'j.doe@example.com';
	// subject
	$lang['form.contact.subject.label'] 		= 'Subject';
	$lang['form.contact.subject.feedback'] 		= 'Giving Feedback';
	$lang['form.contact.subject.enquiry'] 		= 'Asking a Question';
	$lang['form.contact.subject.problem'] 		= 'Reporting a Problem';
	// messege
	$lang['form.contact.message.label'] 		= 'Message';
	$lang['form.contact.message.placeholder'] 	= 'Loved playing mozhunt... thanks for all the hard work!';
	// privacy
	$lang['form.contact.privacy.label'] 		= 'Privacy Policy';
	$lang['form.contact.privacy.statement'] 	= 'I have read and agree to the mozhunt <a href="legal/privacy" target="_blank">privacy policy</a>';
	// controls
	$lang['form.contact.submit'] 				= 'Send';
	$lang['form.contact.reset'] 				= 'Reset';
	// success message
	$lang['form.contact.success'] 				= 'Your email was sent successfully!';
	$lang['form.contact.error'] 				= '<strong>Oops!</strong> Something went wrong... check below to find out what it was.';
	
	/*
	 Login Form
	*/
	$lang['form.login.legend'] 					= 'Sign in';
	$lang['form.login.email.label'] 			= 'Email';
	$lang['form.login.email.placeholder'] 		= 'j.doe@example.com';
	$lang['form.login.password.label'] 			= 'Password';
	$lang['form.login.password.placeholder'] 	= 'Password';
	$lang['form.login.submit'] 					= 'Sign in';
	$lang['form.login.cancel'] 					= 'Cancel';
	$lang['form.login.new'] 					= 'I don&rsquo;t have an account... <a href="user/join">I&rsquo;d like to create one now.</a>';
	
	/*
	 Join Form
	*/
	$lang['form.join.legend'] 				= 'Join now!';
	$lang['form.join.nickname.label'] 		= 'Nickname';
	$lang['form.join.nickname.placeholder'] = 'j.doe';
	$lang['form.join.email.label'] 			= 'Email';
	$lang['form.join.email.placeholder'] 	= 'j.doe@example.com';
	$lang['form.join.password.label'] 		= 'Password';
	$lang['form.join.passwordconf.label'] 	= 'Confirm Password';
	$lang['form.join.legal.label'] 			= 'Agreements';
	$lang['form.join.legal.error'] 			= 'You <strong>must</strong> agree to both the Privacy Policy and Terms Of Service to join.';
	$lang['form.join.privacy.statement'] 	= 'I have read and agree to the mozhunt <a href="legal/privacy" target="_blank">Privacy Policy</a>';
	$lang['form.join.tos.statement'] 		= 'I have read and agree to the mozhunt <a href="legal/tos" target="_blank">Terms Of Service</a>';
	$lang['form.join.submit'] 				= 'Join';
	$lang['form.join.error'] 				= '<strong>Oops!</strong> Looks like there was a problem. Check below for more.';
	
/* End of file forms_lang.php */
/* Location: ./application/language/en/forms_lang.php */