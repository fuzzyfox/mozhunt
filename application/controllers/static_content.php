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
		$this->load->view('static/homepage');
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
				$this->load->view('theme/header', array('page_title' => 'Terms Of Service'));
				$this->load->view('static/tos');
				$this->load->view('theme/footer');
			break;
			// privacy policy
			case 'privacy':
				$this->load->view('theme/header', array('page_title' => 'Privacy Policy'));
				$this->load->view('static/privacy');
				$this->load->view('theme/footer');
			break;
			// disclaimers
			case 'disclaimers':
				$this->load->view('theme/header', array('page_title' => 'Disclaimers'));
				$this->load->view('static/disclaimers');
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
		switch($page)
		{
			// landing page
			case 'landing':
				
			break;
			// history of mozhunt
			case 'history':
				$this->load->view('theme/header', array('page_title' => 'History'));
				$this->load->view('static/history');
				$this->load->view('theme/footer');
			break;
			// how to play play mozhunt
			case 'howto':
				$this->load->view('theme/header', array('page_title' => 'How To Play'));
				$this->load->view('static/howto');
				$this->load->view('theme/footer');
			break;
			// the rules of engagement
			case 'rules':
				$this->load->view('theme/header', array('page_title' => 'The Rules'));
				$this->load->view('static/rules');
				$this->load->view('theme/footer');
			break;
			// 404 page not found
			default:
				show_404("/about/$page/");
			break;
		}
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
			// contact landing page
			case 'landing':
				
			break;
			// support page
			case 'support':
				$this->load->view('theme/header', array('page_title' => 'Got an issue?'));
				$this->load->view('static/contact/support');
				$this->load->view('theme/footer');
			break;
			// feedback page
			case 'feedback':
				$this->load->view('theme/header', array('page_title' => 'Feedback'));
				$this->load->view('static/contact/feedback');
				$this->load->view('theme/footer');
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