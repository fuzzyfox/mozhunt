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
        $this->CI->load->model(array('token_model', 'domain_model'));
        $this->CI->config->load('tokens');
    }
    
    public function getMaxTokens()
    {
        return $this->config->item('max_user_tokens', 'tokens');
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
    
    public function generateOTK()
    {
       do {
           $otk = $this->generateRandomOTK();
       } while($this->CI->find_model->OTKExists($otk));
       
       return $otk;
    }
    
    public function userOwnsToken($tokenID)
    {
        $domain = $this->domain_model->getDomainByToken($tokenID);
        $result = $this->domain_management->userOwnsDomain($domain['domainID']);
    }
}
?>
