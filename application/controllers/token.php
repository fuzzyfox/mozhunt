<?php

// ./application/controllers/token.php

/**
 * Controller which deals with generation of one-time-keys for token redemption
 * and redemption of those one-time-tokens 
 */

class Token extends CI_Controller
{
    public function __construst()
    {
        parent::__construct();
        $this->load->model(array('domain_model', 'token_model', 'find_model'));
        $this->load->helper(array('url', 'date'));
        $this->load->library(array('token_management', 'domain_management', 'form_validation'));
        if(ENVIRONMENT === 'testing' || ENVIRONMENT === 'development')
		{
			$this->output->enable_profiler(TRUE);
		}
    }
    
    public function generate($apiKey, $tokenID)
    {
        if(!empty($apiKey) && !empty($tokenID)) {
            $domain = $this->domain_management->getDomainByToken($tokenID);
            if(empty($domain)) {
                // invalid token id error
            }
            else if ($apiKey != $domain['apiKey']) {
                // invalid api key error
            }
            else {
                $OTK = $this->token_management->generateOTK();
                $data = array('oneTimeKey' => $OTK);
                $this->find_model->insertOTK($tokenID, $OTK, now());
                $this->load->view('token/generate', $data);
            }
        }
        else {
            // display error about missing info
        }
    }
    
    public function find($otk)
    {
        $this->load->model('find_model');
        $result = $this->find_model->getOTK($otk);
        if(!empty($result)) {
            $timeTaken = time() - $result[0]['time'];
            if(!$this->user_session->isUserLoggedIn()) {
                echo json_encode(array(
                    'success' => false,
                    'aletString' => array('visit www.mozhunt.com to find out more.')
                ));
            }
            else if (empty($otk)) {
                echo json_encode(array(
                    'success' => false,
                    'aletString' => array('The token key supplied is not valid.')
                ));
            }
            else if ($timeTaken > 3600) {
                echo json_encode(array(
                    'success' => false,
                    'aletString' => array('The token key expired... reload and try again.')
                ));
            }
            else {
                $userID = $this->session->userdata('userID');
                $tokenID = $result[0]['tokenID'];
                $this->find_model->find($userID, $tokenID);
                $this->find_model->deleteOTK($otk);
                echo json_encode(array(
                    'success' => true,
                    'aletString' => array('Token found!', 'Oops! Looks like you found this one already.')
                ));
            }
        }
    }
    
    public function api($action, $tokenID, $apikey)
    {
        $this->load->library('domain_management');
        if($action == 'verify')
        {
            // check api key is valid as is token id
            $domain = $this->domain_management->getDomainByToken($tokenID);
            if($domain && ($apikey == $domain[0]['apiKey']))
            {
                // check user is logged in and has not already found this token
                if($this->user_session->isUserLoggedIn($this->session->userdata('userID')))
                {
                    $test = $this->db->get_where('userToken', array('userID'=>$this->session->userdata('userID'), 'tokenID'=>$tokenID));
                    if($test->num_rows != 1)
                    {
                        $this->load->library('token_management');
                        $otk = $this->token_management->generateOTK();
                        $this->find_model->insertOTK($tokenID, $otk, time());
                        $data = array(
                            'status' => 'default',
                            'otk' => $otk
                        );
                    }
                    else
                    {
                        $data = array(
                            'status' => 'found',
                            'otk' => ''
                        );
                    }
                }
                else
                {
                    $data = array(
                        'status' => 'guest',
                        'otk' => ''
                    );
                }
                
                $this->load->view('api_proxy', $data);
            }
            elseif($domain)
            {
                $data = array(
                    'status' => 'invalid_apikey',
                    'otk' => ''
                );
                $this->load->view('api_proxy', $data);
            }
            else
            {
                $data = array(
                    'status' => 'invalid_token',
                    'otk' => ''
                );
                $this->load->view('api_proxy', $data);
            }
        }
    }
    
    public function img($style, $img)
    {
        $this->load->helper('url');
        $img = substr($img, 0, strlen($img) - 4);
        $this->output->set_content_type('png');
        echo file_get_contents(site_url()."/asset/img/token/$style/$img".(($this->input->get('s'))?'_'.$this->input->get('s'):null).'.png');
    }
}
?>
