<?php
// ./application/model/domain_model.php

/*
 * Contains the various models needed for managing registered participating domains
 * @author Joe Harrison
 * @version 2012-03-20
 */

class Domain_model extends CI_Model
{
    
    public function getDomainByField($field, $value)
    {
        $conditions = array(
            $field => $value
        );
        
        $query = $this->db->get_where('domain', $conditions);
        return $query->result_array();
    }

    public function getDomainByFields($data)
    {
        $query = $this->db->get_where('domain', $data);
        return $query->result_array();
    }
    
    public function getDomainByID($domainID)
    {
        return $this->getDomainByField('domainID', $domainID);
    }
    
    public function getUserDomain($domainID, $userID)
    {
        $conditions = array(
            'domainID' => $domainID,
            'userID' => $userID
        );
        $query = $this->db->get_where('domain', $conditions);
        return $query->result_array();
    }
    
    public function getUserDomains($userID)
    {
        $conditions = array(
            'userID' => $userID
        );
        
        $query = $this->db->get_where('domain', $conditions);
        return $query->result_array();
    }
    
    public function getUserDomainCount($userID)
    {
        $conditions = array(
            'userID' => $userID
        );
        
        $query = $this->db->get_where('domain', $conditions);
        return $query->num_rows();
    }
    
    public function authKeyExists($key)
    {
        $result = $this->getDomainByField('activationKey', $key);
        return !empty($result) ? TRUE : FALSE;        
    }
    
    public function apiKeyExists($key)
    {
        $result = $this->getDomainByField('apiKey', $key);
        return !empty($result) ? TRUE : FALSE;        
    }
    
    public function insert($data)
    {
        $this->db->insert('domain', $data);
        return $this->db->insert_id();
    }
    
    public function updateDomain($data)
    {
        $this->db->where('domainID', $data['domainID']);
        $this->db->update('domain', $data);
    }
    
    public function deleteDomain($domainID)
    {
        $masterUser = $this->config->item('master_user_id');
        $data = array(
            'userID' => $masterUser,
            'domainStatus' => Domain_management::$DOMAIN_DELETED
        );
        $this->db->where('domainID', $domainID);
        $this->db->update('domain', $data);
    }
    
    public function purgeDomain($domainID)
    {
        $this->db->delete('domain', array('domainID' => $domainID));
    }
    
    public function getDomainByToken($tokenID)
    {
        $this->load->model('token_model');
        $token = $this->token_model->getTokenByField('tokenID', $tokenID);
        $domainID = $token[0]['domainID'];
        return $this->getDomainByField('domainID', $domainID);
    }
    
    public function getUserFoundDomains($userID)
    {
        $domains = $this->db->query("SELECT * FROM domain
                         INNER JOIN userToken ON userToken.userID = domain.userID
                         WHERE userToken.userID = $userID
                         GROUP BY userToken.userID
                         ORDER BY COUNT(*)");
        return $domains->result_array();
    }
    
    /**
	 * Gets a human readable version of the domain status code
	 *
	 * @author William Duyck <william@mozhunt.com>
	 * @version 2012.04.01
	 * 
	 * @param int domainStatus The status to translate
	 * @return string Human readable version of the domain status
	 */
	public function getHumanStatus($domainStatus)
	{
		$this->config->load('status_codes');
		$codes = $this->config->item('status_codes');
		return $codes['domain'][$domainStatus];
	}
}
?>
