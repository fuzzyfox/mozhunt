<?php
	
	class Play extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->library(array('user_session', 'domain_management', 'token_management', 'theme'));
			$this->load->model(array('domain_model', 'token_model', 'user_model'));
			$this->load->helper('number');
		}
		
		public function index()
		{
			if($this->user_session->isUserLoggedIn())
			{
				$data = array(
					'user' 		=> $this->user_model->getUserBy('userID', $this->session->userdata('userID')),
					'user_rank' => $this->user_model->getUserRank($this->session->userdata('userID')),
					'domains' 	=> $this->domain_model->getUserDomains($this->session->userdata('userID'))
				);
			}
			$data['leaders'] = $this->db->query('SELECT user.nickname, COUNT(*) \'token_count\'
												FROM userToken
												INNER JOIN user ON user.userID = userToken.userID
												WHERE user.userStatus != 0
												GROUP BY userToken.userID
												ORDER BY token_count DESC
												LIMIT 10');
			$data['loggedIn'] = $this->user_session->isUserLoggedIn();
			$this->theme->view('play', array('page_title'=>'view.play', 'data'=>$data));
		}
	}
	
/* End of file play.php */
/* Location: application/controllers/play.php */