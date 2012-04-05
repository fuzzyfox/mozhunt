<?php
// ./application/model/token_model.php

/*
 * Contains the various models needed for registering domains and managing them
 * @author Joe Harrison
 * @version 2012-03-20
 */

class Token_model extends CI_Model{
    
    public function getTokenByField($field, $value)
    {
        $conditions = array(
            $field => $value
        );
        
        $query = $this->db->get_where('token', $conditions);
        return $query->result_array();
    }
    
    public function getTokensByDomain($domainID)
    {
        $conditions = array(
            'domainID' => $domainID
        );
        
        $query = $this->db->get_where('token', $conditions);
        return $query->result_array();
    }
    
    public function getTokenByID($tokenID)
    {
        $result = $this->getTokenByField('tokenID', $tokenID);
        return $result[0];
    }
    
    public function insert($data)
    {
        $this->db->insert('token', $data);
        return $this->db->insert_id();
    }
    
    public function updateToken($data)
    {
        $this->db->where('tokenID', $data['tokenID']);
        $this->db->update('domain', $data);
    }
    
    public function deleteToken($tokenID)
    {
        $masterDomain = $this->config->item('master_domain_id', 'domains');
        $this->db->where('tokenID', $tokenID);
        $this->db->update('token', array('domainID' => $masterDomain));
    }
    
    public function purgeToken($tokenID)
    {
        $this->db->delete('token', array('tokenID' => $tokenID));
    }
    
    /**
	 * Gets a human readable version of the domain status code
	 *
	 * @author William Duyck <william@mozhunt.com>
	 * @version 2012.04.01
	 * 
	 * @param int tokenStatus The status to translate
	 * @return string Human readable version of the domain status
	 */
	public function getHumanStatus($tokenStatus)
	{
		$this->config->load('status_codes');
		$codes = $this->config->item('status_codes');
		return $codes['token'][$domainStatus];
	}
}
?>
