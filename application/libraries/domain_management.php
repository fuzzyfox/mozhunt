<?php
// ./application/libraries/domain_management.php
if (!defined('BASEPATH')) exit('Naughty Naughty!');

/*
 * Defines constants and functions useful to domain management
 * @author Joe Harrison
 * @version 2012-03-28
 */
class Domain_management
{
    private $CI;
    
    public static $DOMAIN_MASTER = 0;
    public static $DOMAIN_REGULAR = 1;
    public static $DOMAIN_PENDING = 2;
    public static $DOMAIN_DELETED = 3;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('user_session');
        $this->CI->load->model(array('domain_model', 'token_model'));
        $this->CI->config->load('domains');
    }
    
    
    public function userIsEligible()
    {
        return ($this->CI->user_session->getUserLevel() <= User_session::$USER_HIDER);
    }
    
    public function generateAuthKey()
    {
        do {
            $newKey = $this->CI->user_session->generateRandomString();
        } while ($this->CI->domain_model->authKeyExists($newKey));
        
        return $newKey;
    }
    
    public function generateApiKey()
    {
        do {
            $newKey = $this->CI->user_session->generateRandomString(30);
        } while ($this->CI->domain_model->apiKeyExists($newKey));
        
        return $newKey;
    }
    
    public function generateApiSecret()
    {
        return md5($this->CI->user_session->generateRandomString(20));
    }

    public function generateActivationKey()
    {
        return $this->CI->user_session->generateRandomString(20);
    }

    
    public function userOwnsDomain($domainID)
    {
        return ($this->CI->domain_model->getUserDomain($domainID, $this->CI->session->userdata('userID')))?true:false;
    }
    
    public function getMaxDomains()
    {
        return $this->CI->config->item('max_user_domains', 'domains');
    }
    
    public function domainIsActive($domainID)
    {
        $domain = $this->CI->domain_model->getDomainByID($domainID);
        if(empty($domain)) {
            return FALSE;
        }
        return $domain[0]['status'] < $this->DOMAIN_PENDING;
    }
    
    public function getDomainByToken($tokenID)
    {
        $token = $this->CI->token_model->getTokenByID($tokenID);
        return $this->CI->domain_model->getDomainByID($token['domainID']);
    }
    
}
?>
