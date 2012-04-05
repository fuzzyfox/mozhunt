<?php

/**
 * Deals with the loading of static content on the site.
 *
 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
 * @version 2012-03-28
 */
class Static_content extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('form_validation', 'email', 'theme'));
		$this->load->helper(array('date', 'url'));
		if(ENVIRONMENT === 'testing' || ENVIRONMENT === 'development')
		{
			$this->output->enable_profiler(TRUE);
		}
	}
	
	/**
	 * Loads the homepage of the site
	 *
	 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
	 * @version 2012-01-22
	 */
	public function index()
	{
		$this->theme->view('static/homepage', array('scripts'=>array('homepage')));
	}
	
	/**
	 * Loads the legal information for the site
	 *
	 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
	 * @version 2012-01-24
	 *
	 * @param string $doc The legal document to load.
	 */
	public function legal($doc = '')
	{
		switch($doc)
		{
			// terms of service
			case 'tos':
				$this->theme->view('static/tos', array('page_title'=>'view.tos'));
			break;
			// privacy policy
			case 'privacy':
				$this->theme->view('static/privacy', array('page_title'=>'view.privacy'));
			break;
			// disclaimers
			case 'disclaimers':
				$this->theme->view('static/disclaimers', array('page_title'=>'view.disclaimers'));
			break;
			// 404 page not found
			default:
				show_404("/legal/$doc/");
			break;
		}
	}
	
	/**
	 * Loads the about information for the site
	 *
	 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
	 * @version 2012-01-24
	 *
	 * @param string $page The about page to load.
	 */
	public function about($page = '')
	{
		$this->theme->view('static/about', array(
			'page_title' => 'view.about'
		));
	}
	
	/**
	 * Allows users to submit feedback via a contact form as well as provide
	 * information on how to get in contact via other channels.
	 *
	 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
	 * @version 2012-03-28
	 *
	 * @param string $page The contact page to load
	 */
	public function contact($page = '')
	{
		// validation rules
		$this->form_validation->set_rules('name', 'lang:form.contact.name.label', 'required');
		$this->form_validation->set_rules('email', 'lang:form.contact.email.label', 'required|valid_email');
		$this->form_validation->set_rules('subject', 'lang:form.contact.subject.label', 'required');
		$this->form_validation->set_rules('message', 'lang:form.contact.message.label', 'required');
		$this->form_validation->set_rules('privacy', 'lang:form.contact.privacy.label', 'required');
		
		if($this->form_validation->run() === false)
		{
			$this->theme->view('static/contact', array('page_title'=>'view.contact'));
		}
		else
		{
			$this->email->from($this->input->post('email'), $this->input->post('name'));
			$this->email->to('contact@mozhunt.com');
			$this->email->subject($this->input->post('subject'));
			$this->email->message($this->input->post('message'));
			$this->email->send();
			
			$this->theme->view('static/contact', array('page_title'=>'view.contact', 'data'=>array('success'=>true)));
		}
	}
	
	/**
	 * Provides a basic admin dashboard
	 *
	 * @author William Duyck <william@mozhunt.com>
	 * @version 2012.04.01
	 */
	public function admin()
	{
		if(!$this->user_session->isUserLoggedIn() || $this->user_session->getUserLevel() > User_session::$USER_SUPPORT)
		{
			redirect('user/login', 'location');
		}
		
		// get utility library for twitter related stuff
		$this->load->library('twitter');
		
		// things to get for admins
		if($this->session->userdata('userStatus') == 0)
		{
			// get some users from the database
			$this->db->order_by('registeredAt', 'desc');
			$data['latestUsers'] = $this->db->get('user', 5);
			
			// setup validation for tweet widget
			$this->form_validation->set_rules('tweet', 'message', 'required|max_length['.(138 - strlen($this->session->userdata('nickname'))).']');
		}
		
		if($this->session->userdata('userStatus') < 2)
		{
			// get latest @mentions
			$data['mentions'] = $this->twitter->mentions(5);
		}
		
		if($this->form_validation->run() === false)
		{
			$this->theme->view('static/admin', array('page_title'=>'view.admin', 'data'=>$data));
		}
		else
		{
			$status = ($this->twitter->tweet($this->input->post('tweet').' ^'.$this->session->userdata('nickname')))?'success':'fail';
			redirect('admin?tweet='.$status);
		}
	}
	
	/**
	 * For now this provides a url alias to the github issue tracker. In future
	 * it will contain the administration pages for the issue tracker that will
	 * be built into mozhunt.
	 */
	public function issue()
	{
		redirect('http://www.github.com/fuzzyfox/mozhunt/issues');
	}
}

/* End of file static_content.php */
/* Location: ./application/controllers/static_content.php */