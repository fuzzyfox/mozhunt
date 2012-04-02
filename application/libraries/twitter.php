<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
	/**
	 * Contains a collection of functions that provide utility like functions
	 * to mozhunt.
	 *
	 * @author William Duyck <william@mozhunt.com>
	 * @version 2012.04.01
	 */
	class Twitter
	{
		private $CI;
		
		function __construct()
		{
			$this->CI =& get_instance();
			$this->CI->load->library('oauth', $this->CI->config->item('twitter'));
		}
		
		/**
		 * Posts a tweet from the official mozhunt twitter account.
		 *
		 * @author William Duyck <william@mozhunt.com>
		 * @version 2012.04.01
		 *
		 * @param string $tweet The message to tweet out.
		 * @return boolean True on success
		 */
		public function tweet($tweet)
		{
			// make the api call
			$this->CI->oauth->request('POST', $this->CI->oauth->url('1/statuses/update'), array('status'=>$tweet));
			
			return ($this->CI->oauth->response['code'] == 200);
		}
		
		/**
		 * Get latest @mentions
		 *
		 * @author William Duyck <william@mozhunt.com>
		 * @version 2012.04.01
		 *
		 * @param int $limit The number of @mentions to get
		 * @return mixed Returns false if no @mentions could be retrieved
		 */
		public function mentions($limit)
		{
			$this->CI->oauth->request('GET', $this->CI->oauth->url('1/statuses/mentions'), array('count'=>$limit));
			return ($this->CI->oauth->response['code'] == 200)?json_decode($this->CI->oauth->response['response']):false;
		}
	}