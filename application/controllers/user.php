<?php
// ./application/controllers/user.php


/**
 * Deals with logging in/out and creating new users.
 * @see useradmin.php for user administration
 * @author Steve "Uru" West <uru@mozhunt.com>, William Duyck <william@mozhunt.com>
 * @version 2012-03-31
 */
class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('user_model');
		$this->load->helper(array('security', 'url'));
		$this->load->library(array('form_validation', 'theme'));
	}

	/**
	 * Controls the creation of users and validating input from the user create view
	 * @author Steve "Uru" West, William Duyck <william@mozhunt.com>
	 * @version 2012-03-31
	 */
	public function join()
	{
		//Load up the helpers we need
		$this->load->helper('form');

		//Set up the validation
		//Usernames have to have a min length of 3, max of 30 and be unique
		$this->form_validation->set_rules('nickname', 'lang:form.join.nickname.label', 'required|min_length[3]|max_length[30]|callback_nicknameValid|is_unique[user.nickname]');
		//Needs to be a valid and unique email with a max length of 254
		$this->form_validation->set_rules('email', 'lang:form.join.email.label', 'required|valid_email|is_unique[user.email]|max_length[254]');
		//Needs to match pw2
		$this->form_validation->set_rules('pw1', 'lang:form.join.password.label', 'required');
		$this->form_validation->set_rules('pw2', 'lang:form.join.passwordconf.label', 'required|matches[pw1]');
		// ensure user has agreed to the tos and priv policy
		$this->form_validation->set_rules('privacy', 'lang:form.join.privacy.statement', 'required');
		$this->form_validation->set_rules('tos', 'lang:form.join.tos.statement', 'required');

		//Check to see if the form was submitted and all was found to be ok
		if($this->form_validation->run() === FALSE)
		{
			//It was not submitted or that was a problem so show the create page
			$this->theme->view('static/join', array('page_title'=>'view.join'));
		}
		else
		{
			//Grab the time so we can use that as date of registration
			$dor = time();
			//Clean up the password first
			$password = $this->input->post('pw1');
			//There where no problems co clean up the data and request the model for a new user
			$data = array(
				'email' => $this->input->post('email'),
				'password' => $this->user_session->hashPassword($password, $dor),
				'nickname' => $this->input->post('nickname'),
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
	 * @version 2012-01-29
	 */
	public function nicknameValid($nickname)
	{
		//Returns true if the nickname only contains alpha-numeric or _ - [ ] ( ) " " ' ' | (and space)
		$this->form_validation->set_message('nicknameValid', $this->lang->line('form.invalid.chars'));
		return $this->user_session->nicknameValid($nickname);
	}

	/**
	 * Activates a user that has the given key. A 404 will be shown if the key does not exist
	 * @param string key The key to activate
	 * @auhtor Steve "Uru" West
	 * @version 2012-01-22
	 */
	public function activate($key)
	{
		//Try and load the right user data
		$user = $this->user_model->getUserBy('activationKey', $key);
		if(empty($user))
		{
			show_404();
		}
		
		$user = $user[0]; //Make sure we only have 1 user to deal with

		$user['activationKey'] = '';
		$user['userStatus'] = 3;
		$this->user_model->update($user);

		$data = array(
			'nickname' => $user['nickname'],
		);
		$this->load->view('user/userActivated', $data);
	}

	/**
	 * Allows the user to login. Performs validation on user input to see if the session should be updated.
	 * @param string redirectPath Where to send the user after they log in
	 * @author Steve "Uru" West
	 * @version 2012-01-23
	 */
	public function login($redirectPath = '')
	{
		//check where we are going to send the user to
		if($redirectPath == '')
		{
			$redirectPath = index_page();
		}

		//Set up the validation rules
		$this->form_validation->set_rules('email', 'email', 'required|max_length[254]|valid_email');
		$email = $this->input->post('email');
		$this->form_validation->set_rules('password', 'password', "required|callback_validLogin[$email]");

		if($this->form_validation->run() === FALSE)
		{
			//Show the log in form
			$this->theme->view('form/login', array('page_title'=>'view.login'));
		}
		else
		{
			//Update the session to say the user have been logged in and also tell the user
			$user = $this->user_model->getUserBy('email', $email);
			$this->user_session->logUserIn($user[0]['userID']);
			redirect($redirectPath);
		}
	}

	/**
	 * Logs the user out of the system
	 * @author Steve "Uru" West, William Duyck <william@mozhunt.com>
	 * @version 2012-03-31
	 */
	public function logout()
	{
		//Ask the user_session to invalidate the user
		$this->user_session->logUserOut();
		redirect('?logout=true');
	}

	/**
	 * Checks to see if a user with the given email exists and then if the given password is correct
	 * @param string password The user-inputted password
	 * @param string email The user's email address
	 * @author Steve "Uru" West
	 * @version 2012-01-30
	 */
	public function validLogin($password, $email)
	{
		//Load the user with the given email
		$user = $this->user_model->getUserBy('email', $email);
		//Set an error message for if there is a problem
		$this->form_validation->set_message('validLogin', 'There was a problem with your login. Please check your email address and password where entered correctly.');
		if(empty($user))
		{
			//No user was found with this email so return false
			return FALSE;
		}
		//Make sure we have only one user
		$user = $user[0];

		//Check to see if the user has a "good" status
		if($user['userStatus'] == User_session::$USER_PENDING)
		{
			$this->form_validation->set_message('validLogin', 'Your email is awating activation.');
			return FALSE;
		}

		if($user['userStatus'] == User_session::$USER_INACTIVE)
		{
			$this->form_validation->set_message('validLogin', 'Your account is currently flagged as inactive');
			return FALSE;
		}

		//Hash the password we have been given and see if it matches
		$newPW = $this->user_session->hashPassword($password, $user['registeredAt']);
		//Compare the result and return
		return $newPW == $user['password'];
	}
}


// End of file user.php
