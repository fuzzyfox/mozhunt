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

	public function add()
	{
	}

	public function edit()
	{
	}
}

// End file file userAdmin.php
