<?php
	
	class Landing extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
			$this->load->helper(array('number', 'url'));
			$this->load->library(array('token_management', 'domain_management', 'user_session', 'theme', 'form_validation'));
			$this->load->model(array('token_model', 'domain_model', 'find_model', 'user_model'));
		}
		
		public function about($tokenAlphaID)
		{
			if(isset($tokenAlphaID) && $this->user_session->isUserLoggedIn())
			{
				$tokenID = substr(alphaID($tokenAlphaID, true, 5, $this->config->item('encryption_key')), 0, 1);
				$test = $this->db->get_where('userToken', array('userID'=>$this->session->userdata('userID'), 'tokenID'=>$tokenID));
				if($test->num_rows() == 0)
				{
					$data = array(
						'page_title' => 'landing.about',
						'data' => array(
							'verifycode' => alphaID(rand(), false, 5),
							'alphaID' => $tokenAlphaID,
							'loggedIn' => $this->user_session->isUserLoggedIn()
						)
					);
					$this->form_validation->set_rules('verifycode', 'verification code', 'required');
					$this->form_validation->set_message('matches', '%ss did not match, try again?');
					$this->form_validation->set_rules('confcode', 'confirmation code', 'required|matches[verifycode]');
					
					if($this->form_validation->run() === false)
					{
						$this->theme->view('landing/about', $data);
					}
					else
					{
						$userID = $this->session->userdata('userID');
						$this->find_model->find($userID, $tokenID);
						redirect('landing/about?added=true');
					}
				}
				else
				{
					redirect('landing/found');
				}
			}
			else
			{
				$data = array(
					'page_title' => 'landing.about',
					'data' => array(
						'loggedIn' => $this->user_session->isUserLoggedIn()
					)
				);
				$this->theme->view('landing/about', $data);
			}
		}
		
		public function guest()
		{
			redirect('play');
		}
		
		public function found()
		{
			$this->theme->view('landing/found');
		}
	}
	
/* End of file landing.php */
/* Location: application/controllers/landing.php */