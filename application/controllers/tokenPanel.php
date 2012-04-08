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
        $this->load->library(array('token_management', 'domain_management', 'form_validation', 'theme'));
        if(!$this->user_session->isUserLoggedIn()) {
            redirect('user/login');
        }
        else if(!$this->domain_management->userIsEligible()) {
            redirect('domainPanel/register', 'location');
        }
        else {
            $this->userID = $this->session->userdata('userID');
        }
        
        if(ENVIRONMENT === 'testing' || ENVIRONMENT === 'development')
		{
			$this->output->enable_profiler(TRUE);
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
            $tokenCount = $this->token_model->getDomainTokenCount($domainID);
            if($tokenCount >= $this->token_management->getMaxTokens()) {
                show_error('Limit for the number of tokens has been reached for this domain.');
            }
            else {
                $this->form_validation->set_rules('name', 'name', 'required');
                $this->form_validation->set_rules('clue', 'clue', 'required|max_length[140]');
                
                if($this->form_validation->run() === FALSE) {
                    $data['domainID'] = $domainID;
                    $this->theme->view('token/create', array('data' => $data));
                }
                else {
                    $data = array(
                        'domainID' => $domainID,
                        'name' => $this->input->post('name'),
                        'clue' => $this->input->post('clue')
                    );
                    
                    $this->token_model->insert($data);
                    redirect('domain/view/'.$domainID.'?token=success', 'Location');
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
            $token = $this->token_model->getTokenByID($tokenID);
            $domain = $this->domain_model->getDomainByID($token['domainID']);
            $data = $token;
            $data['domain'] = $domain[0];
            $data['scripts'] = array('mozhuntclient', 'token_view');
            $this->theme->view('token/view', $data);
        }
    }
    
}
?>
