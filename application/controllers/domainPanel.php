<?php
// ./application/controllers/domainPanel.php

/*
 * Contains everything needed to allow users to manage their own domains
 * @author Joe Harrison
 * @version 2012-03-28
 */

class DomainPanel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('domain_model');
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('domain_management', 'form_validation', 'theme'));
        $this->config->load('domains');
        
        if(!$this->user_session->isUserLoggedIn()) {
                redirect('user/login/' . htmlentities(uri_string()), 'location');
        }
        
        if(ENVIRONMENT === 'testing' || ENVIRONMENT === 'development')
		{
			$this->output->enable_profiler(TRUE);
		}
    }
    
    public function index()
    {
        if($this->domain_management->userIsEligible()) {
            $data = array(
                'domainCount' => $this->domain_model->getUserDomainCount($this->session->userdata('userID')),
                'maxDomainCount' => $this->domain_management->getMaxDomains(),
                'createLink' => anchor('domainPanel/create', 'Create Domain'),
                'manageLink' => anchor('domainPanel/manage', 'Manage Domains'),
                'domains' => $this->domain_model->getUserDomains($this->session->userdata('userID'))
            );
            
            $this->theme->view('domain/overview', array('page_title' => 'view.domain.overview', 'data' => $data));
        }
        else {
            show_error('you are not able to create domains at this time');
        }
    }
    
    public function create()
    {
        $userID = $this->session->userdata('userID');
        if(!$this->domain_management->userIsEligible()) {
            show_error('you are not able to create domains at this time');
        }
        else if ($this->domain_model->getUserDomainCount($userID) >= $this->domain_management->getMaxDomains()) {
            show_error('limit reached... you cannot create any more domains');
        }
        else {
            $this->_create_form($userID);
        }
    }
    
    public function _create_form($userID)
    {
        $this->form_validation->set_message('domain_is_unique', 'That domain is already in use');
        $this->form_validation->set_rules('domain', 'domain name', 'required|is_unique[domain.url]');
        
        if($this->form_validation->run() == FALSE) {
            $this->theme->view('domain/create');
        }
        else {
            $apiKey = $this->domain_management->generateApiKey();
            $data = array(
                'url' => $this->input->post('domain'),
                'userID' => $this->session->userdata('userID'),
                'apiKey' => $apiKey,
                'apiSecret' => $this->domain_management->generateApiSecret(),
                'activationKey' => $this->domain_management->generateActivationKey(),
                'domainStatus' => Domain_management::$DOMAIN_PENDING
            );
            $this->domain_model->insert($data);
            $domainID = $this->domain_model->getDomainByField('apiKey', $apiKey);
            redirect('domain/verify/'.$domainID[0]['domainID'], 'Location');
        }
    }
    
    public function view($domainID = NULL)
    {
        $userID = $this->session->userdata('userID');
        if($domainID === NULL) {
            $domains = $this->domain_model->getUserDomains($userID);
            $numDomains = count($domains);
            
            foreach($domains as $domain) {
                $domain['viewLink'] = anchor('domainPanel/view/' . $domain['domainID'], 'View ' . $domain['url']);
                $domain['manageLink'] = anchor('domainPanel/manage/' . $domain['domainID'], 'Manage ' . $domain['url']);
            }
            $data = array(
                'domains' => $domains,
                'numDomains' => $numDomains,
            );
            
            $this->load->view('domain', $data);
            
        }
        else {
            $domain = $this->domain_model->getUserDomain($domainID, $userID);
            if(count($domain) === 0) {
                show_error('domain not found');
            }
            else {
                $this->load->library('token_management');
                $this->load->model('token_model');
                $data = array(
                    'domain' => $domain[0],
                    'tokens' => $this->token_model->getTokensByDomain($domainID),
                    'tokenCount' => $this->token_model->getTokensByDomain($domainID),
                    'maxTokenCount' => $this->token_management->getMaxTokens()
                );
                
                $this->theme->view('domain/view', array('data' => $data));
            }
        }
    }
    
    public function manage($domainID = NULL)
    {
        $userID = $this->session->userdata('userID');
        if($domainID === NULL) {
            $domains = $this->domain_model->getUserDomains($userID);
            foreach($domains as $domain) {
                $domain['manageLink'] = anchor('domainPanel/manage/' . $domain['domainID'], 'Manage ' . htmlentities($domain['url']));
            }
            $this->load->view('domainPanel/manageAll');
        }
        else {
            $domain = $this->domain_model->getUserDomain($domainID, $userID);
            if(empty($domain) === 0) {
                show_error('domain not found');
            }
            else {
                $data = array(
                    'deleteLink' => anchor('domainPanel/delete/'.$domain[0]['domainID'], 'Delete ' . htmlentities($domain['url']))
                );
                $this->load->view('domainPanel/manage', $data);
            }
        }
    }
    
    public function delete($domainID)
    {
        $this->form_validation->set_rules('submit', 'submit', 'required');
        if($this->form_validation->run() === false)
        {
            $data = $this->domain_model->getDomainByID($domainID);
            $this->theme->view('domain/delete', array('data' => $data));
        }
        else
        {
            if($this->domain_management->userOwnsDomain($domainID)) {
                $this->domain_model->delete($domainID);
                $data = array(
                    'backLink' => anchor('domainPanel/index', 'Back')
                );
                $this->load->view('domainPanel/deleted', $data);
            }
        }
    }
    
    public function verify($domainID, $method)
    {
        if(empty($domainID)) {
            show_error('Missing a domain id to verify');
        }
        else if(empty($method)) {
            $domain = $this->domain_model->getDomainByID($domainID);
            $data = array(
                'domain' => $domain[0],
                'textLink' => anchor('domainPanel/verify/'.$domainID.'/text', 'Text File'),
                'dnsLink' => anchor('domainPanel/verify/'.$domainID.'/dns', 'TXT DNS Record')
            );
            $this->theme->view('domain/verify', array('page_title'=>'view.domain.verify','data' => $domain[0]));
        }
        else {
            if($method == 'text') {
                if($this->_textVerify($domainID)) {
                    $this->_setVerified($domainID);
                    redirect('domain?verify=success');
                }
                show_error('Failed to verify by text file... reload page to try again or go back to try another method.');
            }
            else if($method == 'dns') {
                if($this->_dnsVerify($domainID)) {
                    $this->_setVerified($domainID);
                    redirect('domain?verify=success');
                }
                show_error('Failed to verify by dns record... reload page to try again or go back to try another method.');
            }
        }
    }

    public function _textVerify($domainID)
    {
        $domain = $this->domain_model->getDomainByID($domainID);
        $domainURL = $domain[0]['url'];
        $url = 'http://'.$domainURL.'/mozhunt.txt';
        $file = file_get_contents($url, FALSE, NULL, -1, 128);
        $fileKey = trim($file);
        return ($fileKey === $domain[0]['activationKey']);
    }

    public function _dnsVerify($domainID)
    {
        $domain = $this->domain_model->getDomainByID($domainID);
        $dns = dns_get_record($domain[0]['url'], DNS_TXT);
        if(empty($dns)) {
            return FALSE;
        }
        else {
            foreach($dns as $record) {
                if($record['txt'] == $domain[0]['activationKey']) {
                    return TRUE;
                }
            }
            return FALSE;
        }
    }

    public function _setVerified($domainID)
    {
       $data = array(
           'domainID' => $domainID,
           'domainStatus' => Domain_management::$DOMAIN_REGULAR
       );
       
       $this->domain_model->updateDomain($data);
    }
    
    public function register()
    {
        if($this->session->userdata('userStatus') > 2)
        {
            $this->session->set_userdata('userStatus', 2);
            $this->user_model->updateUser(array(
                'userID' => $this->session->userdata('userID'),
                'userStatus' => 2
            ));
            redirect('user?upgrade=success');
        }
        else
        {
            // error message
        }
    }

}
?>
