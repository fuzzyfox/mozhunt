<?php
// ./application/libraries/user_session.php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Defines useful features for dealing with users and sessions
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-01-30
 */
class User_session
{
	private $CI;

	public static $USER_ADMIN = 0;
	public static $USER_SUPPORT = 1;
	public static $USER_HIDER = 2;
	public static $USER_PLAYER = 3;
	public static $USER_PENDING = 4;
	public static $USER_INACTIVE = 5;
	public static $USER_GUEST = 100;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('session');
		$this->CI->load->model('user_model');

		//check to see if a user is logged in
		$userID = $this->CI->session->userdata('userID');
		if(!empty($userID))
		{
			//If they are grab their information and load it into the session
			$user = $this->CI->user_model->getUserBy('userID', $userID);
			$user = $user[0];
			//Update the user table with the current time
			$user['lastActive'] = time();
			$this->CI->user_model->updateUser($user);
			//Finally update the session
			$this->CI->session->set_userdata($user);
		}
	}

	/**
	 * Generates a random authentication key for email activation. This will be compared to existing keys to ensure the new key is unique
	 * @return string A random alpha-numeric string 25 characters long
	 * @author Steve "Uru" West
	 * @version 2012-01-21
	 */
	public function generateAuthKey()
	{
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

	/**
	 * Logs a user in with the given ID
	 * @param int userID The userID of the user to log in
	 * @author Steve "Uru" West
	 * @version 2012-01-24
	 */
	public function logUserIn($userID)
	{
		$this->CI->session->set_userdata(array('userID' => $userID));
	}

	/**
	 * Logs a user out of the system if one is logged in
	 * @author Steve "Uru" West
	 * @version 2012-01-30
	 */
	public function logUserOut()
	{
		$this->CI->session->sess_destroy();
	}

	/**
	 * Checks to see if a user is logged in or not
	 * @return boolean TRUE if there is a user logged in (Well, at least a userID set in the session)
	 * @author Steve "Uru" West
	 * @version 2012-01-24
	 */
	public function isUserLoggedIn()
	{
		$userID = $this->CI->session->userdata('userID');
		return !empty($userID);
	}

	/**
	 * Returns the level of this user.
	 * @return int The level of this user
	 * @author Steve "Uru" West
	 * @version 2012-01-24
	 */
	public function getUserLevel()
	{
		$userLevel = $this->CI->session->userdata('userStatus');
		if(!empty($userLevel))
		{
			return self::$USER_GUEST;
		}
		return $userLevel;
	}

	/**
	 * Checks to see if the given nickname contains only valid characters
	 * @param string nickname The name/string to check
	 * @return TRUE if the given nickname only contains a-z, A-Z, 0-9 []()'"-_ or space
	 * @author Steve "Uru" West
	 * @version 2012-01-29
	 */
	public function nicknameValid($nickname)
	{
		return preg_match('/^[\da-z-A-Z0-9_\-\[\]\(\)"\'\| ]*$/', $nickname);
	}

	/**
	 * Hashes the given string with the given salt. Uses sha1()
	 * @param string password The string to hash
	 * @param string salt The salt to add to the password
	 * @return string The final hashed string
	 * @author Steve "Uru" West
	 * @version 2012-01-30
	 */
	public function hashPassword($password, $salt)
	{
		return sha1($password.$salt);
	}

	/**
	 * Checks to see if the given password is valid for the currenly logged in user
	 * @param string password The password to check
	 * @return TRUE if the password is good. FALSE if the password is incorrect or there is no user logged in
	 * @author Steve "Uru" West
	 * @version 2012-01-30
	 */
	public function validPassword($password)
	{
		$userID = $this->session->userdata('userID');
		if(empty($userID))
		{
			return FALSE;
		}

		return $this->hashPassword($password, $this->session->userdata('registeredAt')) == $this->session->userdata('password');
	}
}

// End of file user_session.php
