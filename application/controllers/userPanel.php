<?php
// ./application/controllers/userPanel.php

/**
 * Contains the code for allowing the user to modify their information
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-01-30
 */
class UserPanel extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper(array('url', 'form'));
		$this->load->library(array('user_session', 'form_validation'));

		if(!$this->user_session->isUserLoggedIn())
		{
			redirect('user/login', 'location');
		}
	}

	/**
	 * Shows the user an overview of their account
	 * @author Steve "Uru" West
	 * @version 2012-01-27
	 */
	public function index()
	{

		$data = array(
			'nickname' => $this->session->userdata('nickname'),
			'nickLink' => anchor('userPanel/nickname', 'Change Nickname'),
			'passLink' => anchor('userPanel/password', 'Change Password'),
		);
		$this->load->view('userPanel/accountOverview', $data);
	}
	
	/**
	 * Allows the user to change their passoword
	 * @author Steve "Uru" West
	 * @version 2012-01-30
	 */
	public function password()
	{
		//Set up the validation rules
		$this->form_validation->set_rules('cpw', 'current password', 'required'); //Add a check to see if this is the right password
		$this->form_validation->set_rules('pw1', 'new password', 'required|matches[pw2]');
		$this->form_validation->set_rules('pw2', 'password re-entry', 'required');

		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('userPanel/password');
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
			redirect('userPanel/index');
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
		$data = array(
			'nickname' => $this->session->userdata('nickname'),
		);

		$this->form_validation->set_rules('newname', 'nickname', 'required|min_length[3]|max_length[30]|callback_newnameValid|is_unique[user.nickname]');
		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('userPanel/nickname', $data);
		}
		else
		{
			//Update user's nickname
			$data = array(
				'userID' => $this->session->userdata('userID'),
				'nickname' => $this->input->post('newname'),
			);
			$this->user_model->updateUser($data);
			redirect('userPanel/index', 'location');
		}
	}
	
	/**
	 * Performs a check on the given nickname to see if it contains invalid characters
	 * @param string nickname The name to check
	 * @return TRUE if the name does not contain invalid characters
	 * @author Steve "Uru" West
	 * @version 2012-01-29
	 */
	public function nicknameValid($nickname)
	{
		$this->form_validation->set_rules('nicknameValid', 'The %s you entered contains invalid characters');
		return $this->user_session->nicknameValid($nickname);
	}
}


// End of file userPanel.php
