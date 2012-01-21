<?php

class Faq_model extends CI_Model{
	
	public function __construct(){
		$this->load->database();
	}

	public function get_faq_list(){
		$query = $this->db->get('faq');
		return $query->result_array();
	}

	public function get_questions($faq_id){
		$query = $this->db->get_where('faqQuestion', array('faqID' => $faq_id));
		return $query->result_array();
	}
}
