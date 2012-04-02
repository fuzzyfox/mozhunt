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
        $result = $this->find_model->getOTK($otk);
        if(!empty($result)) {
            $timeTaken = now() - $result[0]['time'];
            if(!$this->user_session->isUserLoggedIn()) {
                // tell about login
            }
            else if (empty($otk)) {
                // display error about null key
            }
            else if ($timeTaken > 3600) {
                // took too long
            }
            else {
                $userID = $this->session->userdata('userID');
                $tokenID = $result[0]['tokenID'];
                $this->find_model->find($userID, $tokenID);
                $this->find_model->deleteOTK($otk);
                // display success
            }
        }
    }
}
?>
