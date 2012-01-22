<?php
// ./application/controllers/user.php


/**
 * Deals with logging in/out and creating new users.
 * @see useradmin.php for user administration
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-01-22
 */
class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
		$this->load->helper('security');
		$this->load->library(array('form_validation','user_session'));
	}

	/**
	 * Controls the creation of users and validating input from the user create view
	 * @author Steve "Uru" West
	 * @version 2012-01-22
	 */
	public function create()
	{
		//Load up the helpers we need
		$this->load->helper('form');

		//Set up the validation
		//Specify some more user firendly messages for is_unique
		$this->form_validation->set_message('is_unique', 'That %s is already in use');
		//Usernames have to have a min length of 3, max of 30 and be unique
		$this->form_validation->set_rules('nickname', 'nickname', 'required|min_length[3]|max_length[30]|callback_nicknameValid|is_unique[user.nickname]');
		//Needs to be a valid and unique email with a max length of 254
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[user.email]|max_length[254]');
		//Needs to match pw2
		$this->form_validation->set_rules('pw1', 'password', 'required|matches[pw2]');
		//Just required
		$this->form_validation->set_rules('pw2', 'password comfirmation', 'required');

		//Check to see if the form was submitted and all was found to be ok
		if($this->form_validation->run() === FALSE)
		{
			//It was not submitted or that was a problem so show the create page
			$this->load->view('user/create');
		}
		else
		{
			//Grab the time so we can use that as date of registration
			$dor = time();
			//Clean up the password first
			$password = xss_clean($this->input->post('pw1'));
			//Now hash the password with the time to get the actual password that we store
			$password = sha1($password+$dor);
			//There where no problems co clean up the data and request the model for a new user
			$data = array(
				'email' => xss_clean($this->input->post('email')),
				'password' => $password,
				'nickname' => xss_clean($this->input->post('nickname')),
				'lastActive' => time(),
				'registeredAt' => $dor,
				'activationKey' => $this->user_session->generateAuthKey(),
			);
			//Perform the insert
			$this->user_model->insert($data);
			//Fire off an email with the activation link

			$this->user_session->sendActivationEmail($data['nickname'], $data['email'], $data['activationKey']);
			//Then direct the user to the thank you page
			$this->load->view('user/userCreated', $data);
		}
	}

	/**
	 * Checks to see if the given name contains only valid characters
	 * @param string nickname The name to check agaist
	 * @return FALSE if nickname contains anything other than 0-9, a-z, A-Z, _-[]()"'| and space
	 * @author Steve "Uru" West
	 * @version 2012-01-21
	 */
	public function nicknameValid($nickname)
	{
		//Returns true if the nickname only contains alpha-numeric or _ - [ ] ( ) " " ' ' | (and space)
		if(preg_match('/^[\da-zA-Z_\-\[\]\(\)"\'\| ]*$/', $nickname))
		{
			return TRUE;
		}
		$this->form_validation->set_message('nicknameValid', 'The %s you entered contains invalid characters');
		return FALSE;
	}

	//TODO: remove this
	public function foo(){
		$this->user_session->sendActivationEmail('Nickname', 'uru@mozhunt.com', 'some key');
	}
}


// End of file user.php
