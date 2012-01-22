<?php
// ./application/libraries/user_session.php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Defines useful features for dealing with users and sessions
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-01-22
 */
class User_session
{
	private $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	/**
	 * Generates a random authentication key for email activation. This will be compared to existing keys to ensure the new key is unique
	 * @return string A random alpha-numeric string 25 characters long
	 * @author Steve "Uru" West
	 * @version 2012-01-21
	 */
	public function generateAuthKey()
	{
		$this->CI->load->model('user_model');

		do{
			$newKey = $this->generateRandomString();
		} while($this->CI->user_model->authKeyExists($newKey));

		return $newKey;
	}

	/**
	 * Generates a random alpha-numeric string
	 * @param int length The number of characters in the reutrnd string. Default is 25
	 * @return A string of the given length composed randomly of alpha-numberic characters
	 * @author Steve "Uru" West
	 * @version 2012-01-21
	 */
	public function generateRandomString($length=25)
	{
		//Build and array of alpha-numeric characters
		$chars = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
		//for the length choose a random character and add it to the result
		$result = "";
		for($i=0; $i<$length; $i++)
		{
			$result .= $chars[rand(0, count($chars)-1)];
		}
		return $result;
	}

	/**
	 * Sends an activation email to a user
	 * @param string nickname The name of the user
	 * @param string email The email address of the user
	 * @param string key The user's activation key
	 * @author Steve "Uru" West
	 * @version 2012-01-22
	 */
	public function sendActivationEmail($nickname, $email, $key)
	{
		//Load the library
		$this->CI->load->library('email');
		$this->CI->load->helper('url');

		//Build the email up
		$this->CI->email->from('noreply@mozhunt.com', 'No Reply');
		$this->CI->email->to($email);
		$this->CI->email->subject('Mozhunt account activation');

		//Make the activation URL
		$activationURL = site_url('user/acivate/'.$key);

		$this->CI->email->message("Welcome to Mozhunt, $nickname!\n\nTo finish your registration please click the link below or visit it in your browser.
\n{unwrap}$activationURL{/unwrap}\n\nHappy hunting,\nThe Mozhunt team.");
		$this->CI->email->send();
	}
}

// End of file user_session.php
