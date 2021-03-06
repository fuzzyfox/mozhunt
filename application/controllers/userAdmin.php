<?php
// ./application/controllers/userAdmin.php

/**
 * Contains the methods for adminstering users
 * @author Steve "Uru" West <sw349@kent.ac.uk>
 * @version 2012-02-06
 */
class UserAdmin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library(array('form_validation', 'theme'));
		$this->load->helper('url');
		
		//Check that an admin is logged in
		if(!$this->user_session->isUserLoggedIn() || $this->user_session->getUserLevel() != User_session::$USER_ADMIN)
		{
			redirect('user/login', 'location');
		}
		
		if(ENVIRONMENT === 'testing' || ENVIRONMENT === 'development')
		{
			$this->output->enable_profiler(TRUE);
		}
	}

	/**
	 * Shows a list of users
	 * @suthor Steve "Uru" West
	 * @version 2012-02-06
	 */
	public function index()
	{
		$users = $this->user_model->getAllUsers();
		$this->theme->view('admin/users', array('page_title'=>'view.admin.user', 'data'=>array('users' => $users)));
	}
	
	/**
	 * Alows the admin to see the users account page.
	 */
	public function view()
	{
		$this->theme->view('user/account', array('page_title'=>'view.admin.user'));
	}
	
	/**
	 * Deletes the given user after asking
	 * @param int badID the ID of the user to remove
	 * @author Steve "Uru" West
	 * @version 2012-02-06
	 */
	public function remove($badID)
	{
		$this->form_validation->set_rules('submit', 'submit', 'required');
		if($this->form_validation->run() === FALSE)
		{
			$user = $this->user_model->getUserBy('userID', $badID);
			$data['nickname'] = $user[0]['nickname'];
			$data['email'] = $user[0]['email'];
			$data['badID'] = $badID;

			$this->theme->view('admin/remove_user', array('page_title'=>'view.admin.user','data'=>$data));
		}
		else
		{
			$this->user_model->deleteUser($badID);
			redirect('admin/user', 'location');
		}
	}

	public function edit($editID)
	{
		//Set up the validation
		//Usernames have to have a min length of 3, max of 30
		$newNick = $this->input->post('nickname');
		$user = $this->user_model->getUserBy('userID', $editID);
		$data = array(
			'nickname' => $user[0]['nickname'],
			'email' => $user[0]['email'],
			'userID' => $editID
		);

		//The validation does something weird that I don't understand
		//After processing the newname/nickname becomes 1, so grabbing it here before it gets mangled.
		$this->form_validation->set_rules('nickname', 'nickname', 'required|min_length[3]|max_length[30]|callback_nicknameValid');
		//Needs to be a valid and unique email with a max length of 254
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[254]');
		if($this->input->post('pw1')){
			//Needs to match pw2
			$this->form_validation->set_rules('pw1', 'password', 'required');
			$this->form_validation->set_rules('pw2', 'confirm password', 'required|matches[pw1]');
		}
		if($this->form_validation->run() === FALSE)
		{
			$this->theme->view('admin/edit_user', array('page_title'=>'view.admin.user','data'=>$data));
		}
		else
		{
			//All good so do the update dance
			$data['nickname'] = $newNick;
			$data['email'] = $this->input->post('email');
			
			//Check if we need to update the password too
			if($this->input->post('pw1'))
				$data['password'] = $this->user_session->hashPassword($newPW, $user[0]['registeredAt']);
			$this->user_model->updateUser($data);
			redirect('admin/user', 'location');
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
}

// End file file userAdmin.php
