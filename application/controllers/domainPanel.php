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
        $this->load->library(array('domain_management', 'form_validation'));
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
                'manageLink' => anchor('domainPanel/manage', 'Manage Domains')
            );
            
            $this->load->view('domainPanel/domainOverview', $data);
        }
        else {
            $data = array(
                'eligibilityLink' => anchor('domainPanel/register', 'upgrade')
            );
            $this->load->view('domainPanel/ineligible', $data);
        }
    }
    
    public function create()
    {
        $userID = $this->session->userdata('userID');
        if(!$this->domain_management->userIsEligible()) {
            $data = array(
                'eligibilityLink' => anchor('domainPanel/register', 'upgrade')
            );
            $this->load->view('domainPanel/ineligible', $data);
        }
        else if ($this->domain_model->getUserDomainCount($userID) >= $this->domain_management->getMaxDomains()) {
            $this->load->view('domainPanel/limitReached');
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
            $this->load->view('domainPanel/create');
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
            $domainID = $this->domain_model->getDomainByField('apiKey', $apiKey);
            redirect('domainPanel/verify/'.$domainID[0]['domainID'], 'Location');
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
            
            $this->load->view('domainPanel/viewAll', $data);
            
        }
        else {
            $domain = $this->domain_model->getUserDomain($domainID, $userID);
            if(count($domain) === 0) {
                $this->load->view('domainPanel/gone');
            }
            else {
                $this->load->view('domainPanel/view', $domain[0]);
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
                $this->load->view('domainPanel/gone');
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
        if($this->domain_management->userOwnsDomain($domainID)) {
            $this->domain_model->delete($domainID);
            $data = array(
                'backLink' => anchor('domainPanel/index', 'Go back to your domains')
            );
            $this->load->view('domainPanel/deleted', $data);
        }
    }
    
    public function verify($domainID, $method)
    {
        if(empty($domainID)) {
            $conditions = array(
                'userID' => $this->session->userdata('userID'),
                'domainStatus' => Domain_management::$DOMAIN_PENDING
            );
            $unverifiedDomains = $this->domain_model->getDomainByFields($conditions);

            $data = array('domains' => $unverifiedDomains);
            $this->load->view('domainPanel/verifyAll');

        }
        else if(empty($method)) {
            $domain = $this->domain_model->getDomainByID($domainID);
            $data = array(
                'domain' => $domain[0],
                'textLink' => anchor('domainPanel/verify/'.$domainID.'/text', 'Text File'),
                'dnsLink' => anchor('domainPanel/verify/'.$domainID.'/dns', 'TXT DNS Record')
            );
            $this->load->view('domainPanel/verify', $data);
        }
        else {
            if($method == 'text') {
                if(_textVerify($domainID)) {
                    _setVerified($domainID);                    
                }
                $data = array('textError' => TRUE);
                $this->load->view('domainPanel/verify', $data);
            }
            else if($method == 'dns') {
                if(_dnsVerify($domainID)) {
                    _setVerified($domainID);
                }
                $data = array('dnsError' => TRUE);
                $this->load->view('domainPanel/verify', $data);
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
       
       $this->domain_model->update($data);
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
