<?php

// ./application/controllers/tokenPanel.php

/**
 * Controller for domain owners to manage their tokens for their domains
 * @author Joe Harrison
 * @version 2012-03-28 
 */

class TokenPanel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('domain_model', 'token_model'));
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('token_management', 'domain_management', 'form_validation'));
        if(!$this->user_session->isUserLoggedIn()) {
            redirect('user/login');
        }
        else if(!$this->domain_management->userIsEligible()) {
            redirect('domainPanel/register', 'location');
        }
        else {
            $this->userID = $this->session->userdata('userID');
        }
    }
    
    public function index()
    {
        $domains = $this->domain_model->getUserDomains($this->userID);
        foreach($domains as $domain) {
            $domain['tokens'] = $this->token_model->getTokensByDomain($domain['domainID']);
        }
        
        $this->load->view('tokenPanel/index', $domains);
    }
    
    public function create($domainID)
    {   
        if($this->domain_management->userOwnsDomain($domainID)) {
            $tokenCount = $this->token_model-getDomainTokenCount($domainID);
            if($tokenCount >= $this->token_management->getMaxTokens()) {
                $this->load->view('tokenPanel/limitReached');
            }
            else {
                $this->form_validation->set_rules('name', 'name', 'required');
                $this->form_validation->set_rules('clue', 'clue', 'required');
                
                if($this->form_validation->run() === FALSE) {
                    $this->load->view('tokenPanel/create');
                }
                else {
                    $tokenID = $this->token_management->getTokenID();
                    $data = array(
                        'tokenID' => $tokenID,
                        'domainID' => $domainID,
                        'name' => $this->input->post('name'),
                        'clue' => $this->input->post('clue')
                    );
                    
                    $this->token_model->insert($data);
                    redirect('tokenPanel/view/'.$tokenID, 'Location');
                }
            }
        }
        else {
            $this->load->view('tokenPanel/error'); // Change as needed for generic error
        }
    }
    
    public function manage($tokenID)
    {
        if($this->token_management->userOwnsToken($tokenID)) {
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('clue', 'clue', 'required');
            
            $tokenData = $this->token_model->getTokenByID($tokenID);
            $currentData = array(
                'name' => $tokenData[0]['name'],
                'clue' => $tokenData[0]['clue']
            );
            
            if($this->form_validation->run() === FALSE) {
                $this->load->view('tokenPanel/manage', $currentData);
            }
            else {
                $data = array(
                    'tokenID' => $tokenID,
                    'name' => $this->input->post('name'),
                    'clue' => $this->input->post('clue')
                );
                $this->token_model->update($tokenID);
                $this->load->view('tokenPanel/manage', $data);
            }
        }
        else {
            $this->load->view('tokenPanel/error');
        }
    }
    
    public function delete($tokenID)
    {
        if($this->token_management->userOwnsToken($tokenID)) {
            $this->token_model->delete_token($tokenID);
        }
    }
    
    public function view($tokenID)
    {
        if($this->token_management->userOwnsToken($tokenID)) {
            $token = $this->tokens->getTokenByID($tokenID);
            $data = $token[0];
            $data['deleteLink'] = anchor('tokenPanel/delete/'.$tokenID, 'Delete Token');
            $this->load->view('tokenPanel/view', $data);
        }
    }
    
}
?>
