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
		
		$this->load->library('form_validation');
		$this->load->library('email');
	}
	
	/**
	 * Loads the homepage of the site
	 *
	 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
	 * @version 2012-01-22
	 */
	public function index()
	{
		$this->load->view('theme/header', array('stylesheets' => array('homepage')));
		$this->load->view('static/'.$this->config->item('language').'/homepage');
		$this->load->view('theme/footer');
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
				$this->load->view('theme/header', array('page_title' => $this->lang->line('view.tos')));
				$this->load->view('static/'.$this->config->item('language').'/tos');
				$this->load->view('theme/footer');
			break;
			// privacy policy
			case 'privacy':
				$this->load->view('theme/header', array('page_title' => $this->lang->line('view.privacy')));
				$this->load->view('static/'.$this->config->item('language').'/privacy');
				$this->load->view('theme/footer');
			break;
			// disclaimers
			case 'disclaimers':
				$this->load->view('theme/header', array('page_title' => $this->lang->line('view.disclaimers')));
				$this->load->view('static/'.$this->config->item('language').'/disclaimers');
				$this->load->view('theme/footer');
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
		$this->load->view('theme/header', array('page_title' => $this->lang->line('view.about')));
		$this->load->view('static/'.$this->config->item('language').'/about');
		$this->load->view('theme/footer');
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
			$this->load->view('theme/header', array('page_title' => $this->lang->line('view.contact')));
			$this->load->view('static/'.$this->config->item('language').'/contact');
			$this->load->view('theme/footer');
		}
		else
		{
			$this->email->from($this->input->post('email'), $this->input->post('name'));
			$this->email->to('contact@mozhunt.com');
			$this->email->subject($this->input->post('subject'));
			$this->email->message($this->input->post('message'));
			$this->email->send();
			
			$this->load->view('theme/header', array('page_title' => $this->lang->line('view.contact')));
			$this->load->view('static/'.$this->config->item('language').'/contact', array('success'=>true));
			$this->load->view('theme/footer');
		}
	}
}

/* End of file static_content.php */
/* Location: ./application/controllers/static_content.php */