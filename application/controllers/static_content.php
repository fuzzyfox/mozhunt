<?php

/**
 * Deals with the loading of static content on the site.
 *
 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
 * @version 2012-01-22
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
		// code to come
	}
	
	/**
	 * Loads the legal information for the site
	 *
	 * @author William "FuzzyFox" Duyck <william@mozhunt.com>
	 * @version 2012-01-22
	 *
	 * @param string $doc The legal document to load.
	 */
	public function legal($doc = '')
	{
		switch($doc)
		{
			// landing page
			case '':
				
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
				
			break;
			// 404 page not found
			default:
				show_404("/legal/$doc/");
			break;
		}
	}
}

/* End of file static_content.php */
/* Location: ./application/controllers/static_content.php */