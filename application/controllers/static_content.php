<?php

/**
 * Deals with the loading of static content on the site.
 *
 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
 * @version 2012-01-24
 */
class Static_content extends CI_Controller
{
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
			// landing page
			case 'landing':
				
			break;
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
	 * Loads the contact pages for the site
	 *
	 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
	 * @version 2012-01-24
	 *
	 * @param string $page The contact page to load
	 */
	public function contact($page = '')
	{
		switch($page)
		{
			// view the contact page
			case 'view':
				$this->load->view('theme/header', array('page_title' => $this->lang->line('view.contact')));
				$this->load->view('static/'.$this->config->item('language').'/contact');
				$this->load->view('theme/footer');
			break;
			// process the contact form
			case 'process':
				// processing code
			break;
			// contact page not found
			default:
				show_404("/contact/$page/");
			break;
		}
	}
}

/* End of file static_content.php */
/* Location: ./application/controllers/static_content.php */