<?php

class Faq extends CI_Controller{

	public function __construct(){
		parent::__construct();

		$this->load->model('faq_model');
		$this->load->helper('url');
	}

	public function show($id=null){

		if($id == null){
			$faqList = $this->faq_model->get_faq_list();
			$faqData = array();
			foreach($faqList as $faq){
				$faqData[] = array(
					'link' => site_url('faq/'.$faq['faqID']),
					'name' => $faq['name']
				);
			}

			$data = array(
				'title' => "FAQs",
				'faqs' => $faqData,
			);

			$this->load->view('faq/faqlist', $data);
		} else {
			//load up the requested faq to see if it exists
			$questions = $this->faq_model->get_questions($id);
			if(empty($questions))
				show_404();
			
			$data['questions'] = $questions;
			$data['title'] = 'FAQ Questions';

			$this->load->view('faq/questionlist', $data);
		}
	}
}
