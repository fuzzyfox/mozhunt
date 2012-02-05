<?php
// ./application/controllers/userAdmin.php

/**
 * Contains the methods for adminstering users
 * @author Steve "Uru" West <sw349@kent.ac.uk>
 * @version 2012-02-05
 */
class UserAdmin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

	/**
	 * Shows a list of users
	 * @suthor Steve "Uru" West
	 * @version 2012-02-05
	 */
	public function index()
	{
		$users = $this->user_model->getAllUsers();
		$this->load->view('userAdmin/userList', array('users' => $users));
	}

	public function remove()
	{
	}

	public function add()
	{
	}

	public function edit()
	{
	}
}

// End file file userAdmin.php
