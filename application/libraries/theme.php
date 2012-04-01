<?php
	
	/**
	 * This file contains a collection of helper functions for dealing with the
	 * site theme and loading views into it.
	 *
	 * @author William Duyck <william@mozhunt.com>
	 * @version 2012.03.31
	 */
	
	// stop direct script access
	if( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Theme
	{
		private $CI;
		
		function __construct()
		{
			$this->CI =& get_instance();
		}
		
		/**
		 * Deals with opening views that include the site default header and footer.
		 *
		 * @author William Duyck <william@mozhunt.com>
		 * @version 2012.03.31
		 *
		 * Usage:
		 * 		load_view('static/about', array(
		 * 			'page_title' => 'view.about', // this helper will take care of getting the right language
		 * 			'stylesheets' => array('homepage', 'slider'), // any additional css files to load
		 * 			'scripts' => array('homepage', 'slider'), // any additional js files to load
		 *			// any data to be passed to the view
		 * 			'data' => array(
		 *				'users' => $this->CI->db->get('user')
		 *			)
		 * 		));
		 *
		 * @param string $view The view file to load. IF it starts with static/ the language will be added automatically
		 * @param assoc_array $options The settings that need to passed onto the view
		 */
		function view($view, $options = false)
		{
			// work out if we need to get a specific file due to localization.
			if(preg_match('/static\//', $view))
			{
				$view = explode('/', $view, 2);
				$view = $view[0] . '/' . $this->CI->config->item('language') . '/' . $view[1];
			}
			
			// check if options were set
			if(!$options)
			{
				// no options set, load header footer and view now to save time.
				$this->CI->load->view('theme/header');
				$this->CI->load->view($view);
				$this->CI->load->view('theme/footer');
			}
			else
			{
				// check if there is any data to be sent to the view
				if(key_exists('data', $options))
				{
					$data = $options['data'];
					unset($options['data']);
				}
				// check if there is still anything left in $options before passing it to the header
				if(count($options) > 0)
				{
					// check for a page_title and localize it
					if(key_exists('page_title', $options))
					{
						$options['page_title'] = $this->CI->lang->line($options['page_title']);
					}
					// load header with options
					$this->CI->load->view('theme/header', $options);
				}
				else
				{
					// load header without options
					$this->CI->load->view('theme/header');
				}
				
				// check there is data to give to the view
				if(isset($data))
				{
					// load view with data
					$this->CI->load->view($view, $data);
				}
				else
				{
					// load view without data
					$this->CI->load->view($view);
				}
				// load footer
				$this->CI->load->view('theme/footer');
			}
		}
	}
	
	/* End of file MH_view_helper.php */
	/* Location: ./application/helpers/MH_view_helper.php */
	