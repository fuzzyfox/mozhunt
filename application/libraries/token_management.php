<?php
// ./application/libraries/token_management.php
if (!defined('BASEPATH')) exit('Naughty Naughty!');

/*
 * Useful functions for token management and finding
 * @author Joe Harrison
 * @version 2012-03-28
 */

class Token_management
{
    private $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('user_session');
        $this->CI->load->model(array('token_model', 'domain_model', 'find_model'));
        $this->CI->config->load('domains');
    }
    
    public function getMaxTokens()
    {
        return $this->CI->config->item('max_domain_tokens', 'domains');
    }
    
    public function generateTokenID()
    {
        do {
            $id = $this->generateRandomID();
        } while($this->CI->token_model->tokenIDExists($id));
        
        return $id;
    }
    
    public function generateRandomID()
    {
        return $this->CI->user_session->generateRandomString(30);
    }
    
    public function generateRandomOTK()
    {
        return $this->CI->user_session->generateRandomString(30);
    }
    
    public function generateOTK()
    {
        do {
            $otk = $this->generateRandomOTK();
        } while($this->CI->find_model->OTKExists($otk));
        
        return $otk;
    }
    
    public function userOwnsToken($tokenID)
    {
        $domain = $this->CI->domain_model->getDomainByToken($tokenID);
        $result = $this->CI->domain_management->userOwnsDomain($domain[0]['domainID']);
        return $result;
    }
}
?>
