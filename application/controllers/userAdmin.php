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
		$this->load->library('form_validation');
		$this->load->helper('url');

		//Check that an admin is logged in
		if(!$this->user_session->isUserLoggedIn() || $this->user_session->getUserLevel() != User_session::$USER_ADMIN)
		{
			redirect('user/login', 'location');
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
		for($u=0; $u<count($users); $u++)
		{
			$users[$u]['deleteLink'] = anchor('userAdmin/remove/'.$users[$u]['userID'], 'Delete');
			$users[$u]['editLink'] = anchor('userAdmin/edit/'.$users[$u]['userID'], 'Edit');
		}
		$this->load->view('userAdmin/userList', array('users' => $users));
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

			$this->load->view('userAdmin/remove', $data);
		}
		else
		{
			$this->user_model->deleteUser($badID);
			redirect('userAdmin/index', 'location');
		}
	}

	public function edit($editID)
	{
		//Set up the validation
		//Usernames have to have a min length of 3, max of 30
		$newNick = $this->input->post('newname');
		$user = $this->user_model->getUserBy('userID', $editID);
		$data = array(
			'nickname' => $user[0]['nickname'],
			'email' => $user[0]['email'],
			'userID' => $editID
		);

		//The validation does something weird that I don't understand
		//After processing the newname/nickname becomes 1, so grabbing it here before it gets mangled.
		$this->form_validation->set_rules('newname', 'nickname', 'required|min_length[3]|max_length[30]|callback_nicknameValid');
		//Needs to be a valid and unique email with a max length of 254
		$this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[254]');
		$pw = $this->input->post('pw1');
		if(!empty($pw)){
			//Needs to match pw2
			$this->form_validation->set_rules('pw1', 'password', 'required|matches[pw2]');
			$this->form_validation->set_rules('pw2', 'password comfirmation', 'required');
}
		if($this->form_validation->run() === FALSE)
		{
			$this->load->view('userAdmin/edit', $data);
		}
		else
		{
			//All good so do the update dance
			$data['nickname'] = $newNick;
			$data['email'] = $this->input->post('email');
			
			//Check if we need to update the password too
			$newPW = $this->input->post('pw1');
			if(!empty($newPW))
				$data['password'] = $this->user_session->hashPassword($newPW, $user[0]['registeredAt']);
			$this->user_model->updateUser($data);
			redirect('userAdmin/index', 'location');
		}
	}
	
	/**
	 * Checks to see if the given name contains only valid characters
	 * @param string nickname The name to check agaist
	 * @return FALSE if nickname contains anything other than 0-9, a-z, A-Z, _-[]()"'| and space
	 * @author Steve "Uru" West
	 * @version 2012-02-06
	 */
	public function nicknameValid($nickname)
	{
		//Returns true if the nickname only contains alpha-numeric or _ - [ ] ( ) " " ' ' | (and space)
		$this->form_validation->set_message('nicknameValid', 'The %s you entered contains invalid characters');
		return $this->user_session->nicknameValid($nickname);
	}
}

// End file file userAdmin.php
