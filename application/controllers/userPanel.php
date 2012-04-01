<?php
// ./application/controllers/userPanel.php

/**
 * Contains the code for allowing the user to modify their information
 * @author Steve "Uru" West <uru@mozhunt.com>, William Duyck <william@mozhunt.com>
 * @version 2012-04-01
 */
class UserPanel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('user_session', 'form_validation', 'theme'));

		if(!$this->user_session->isUserLoggedIn())
		{
			redirect('user/login', 'location');
		}
	}

	/**
	 * Shows the user an overview of their account
	 * @author Steve "Uru" West, William Duyck <william@mozhunt.com>
	 * @version 2012-04-01
	 */
	public function index()
	{

		$data = array(
			'nickname' => $this->session->userdata('nickname'),
			'nickLink' => anchor('userPanel/nickname', 'Change Nickname'),
			'passLink' => anchor('userPanel/password', 'Change Password'),
		);
		//$this->load->view('userPanel/accountOverview', $data);
		$this->theme->view('user/account', array('page_title'=>'view.user.account'));
	}
	
	/**
	 * Allows the user to change their passoword
	 * @author Steve "Uru" West, William Duyck <william@mozhunt.com>
	 * @version 2012-04-01
	 */
	public function password()
	{
		//Set up the validation rules
		$this->form_validation->set_rules('cpw', 'lang:form.change.password.current.label', 'required|callback_passwordValid[cpw]'); //Add a check to see if this is the right password
		$this->form_validation->set_rules('pw1', 'lang:form.change.password.new.label', 'required');
		$this->form_validation->set_rules('pw2', 'lang:form.change.password.newconf.label', 'required|matches[pw1]');

		if($this->form_validation->run() === FALSE)
		{
			$this->theme->view('form/change_password');
		}
		else
		{
			//Hash that password!
			$newPW = $this->user_session->hashPassword($this->input->post('pw1'), $this->session->userdata('registeredAt'));
			$data = array(
				'userID' => $this->session->userdata('userID'),
				'password' => $newPW,
			);
			$this->user_model->updateUser($data);
			redirect('user');
		}
	}

	public function passwordValid($password)
	{
		$this->form_validation->set_message('passwordValid', 'Your current password is invalid');
		return $this->user_session->validPassword($password);
	}

	/**
	 * Allows the user to change their nickname
	 * @author Steve "Uru" West
	 * @version 2012-01-30
	 */
	public function nickname()
	{
		$this->form_validation->set_rules('nickname', 'lang:form.change.nickname.label', 'required|min_length[3]|max_length[30]|callback_nicknameValid|is_unique[user.nickname]');
		if($this->form_validation->run() === FALSE)
		{
			$this->theme->view('form/change_nickname');
		}
		else
		{
			//Update user's nickname
			$data = array(
				'userID' => $this->session->userdata('userID'),
				'nickname' => $this->input->post('nickname'),
			);
			$this->user_model->updateUser($data);
			redirect('user?change=nickname', 'location');
		}
	}
	
	/**
	 * Checks to see if the given name contains only valid characters
	 * @param string nickname The name to check agaist
	 * @return FALSE if nickname contains anything other than 0-9, a-z, A-Z, _-[]()"'| and space
	 * @author Steve "Uru" West, William Duyck <william@mozhunt.com>
	 * @version 2012-04-01
	 */
	public function nicknameValid($nickname)
	{
		//Returns true if the nickname only contains alpha-numeric or _ - [ ] ( ) " " ' ' | (and space)
		$this->form_validation->set_message('nicknameValid', $this->lang->line('form.invalid.chars'));
		return $this->user_session->nicknameValid($nickname);
	}
	
	/**
	 * Allows the user to change their email address on the priviso that their
	 * account is susspended till the new email is verified
	 *
	 * @author William Duyck <william@mozhunt.com>
	 * @version 2012.04.01
	 */
	public function email()
	{
		$this->form_validation->set_rules('email', 'lang:form.change.email.label', 'required|valid_email|is_unique[user.email]|max_length[254]');
		$this->form_validation->set_rules('emailconf', 'lang:form.change.emailconf.label', 'required|valid_email|matches[email]|max_length[254]');
		$this->form_validation->set_rules('password', 'lang:form.change.password.label', "required|callback_passwordValid[password]");
		
		if($this->form_validation->run() === false)
		{
			$this->theme->view('form/change_email');
		}
		else
		{
			//Update user's email
			$data = array(
				'userID' => $this->session->userdata('userID'),
				'email' => $this->input->post('email'),
				'userStatus' => 4,
				'activationKey' => $this->user_session->generateAuthKey()
			);
			$this->user_session->sendActivationEmail($this->session->userdata('nickname'), $this->input->post('email'), $data['activationKey']);
			$this->user_model->updateUser($data);
			$this->user_session->logUserOut();
			redirect('user/login?change=email', 'location');
		}
	}
}


// End of file userPanel.php
