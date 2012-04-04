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
    
    /**
	 * Gets a human readable version of the domain status code
	 *
	 * @author William Duyck <william@mozhunt.com>
	 * @version 2012.04.01
	 * 
	 * @param int domainID The domain to get the status for
	 * @return string Human readable version of the domain status
	 */
	public function getHumanStatus($domainID)
	{
		$domain = $this->getDomainByField('domainID', $domainID);
		$domainStatus = $domain[0]['domainStatus'];
		$this->config->load('status_codes');
		$codes = $this->config->item('status_codes');
		return $codes['domain'][$domainStatus];
	}
}
?>
