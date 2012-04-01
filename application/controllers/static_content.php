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
		$this->load->helper('date');
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
}

/* End of file static_content.php */
/* Location: ./application/controllers/static_content.php */