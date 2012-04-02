<?php
// ./application/model/find_model.php

/*
 * Contains the various models needed to allow users to find tokens
 * @author Joe Harrison
 * @version 2012-03-20
 */

class Token_model extends CI_Model{
    
    public function find($userID, $tokenID)
    {
        $data = array(
            'userID' => $userID,
            'tokenID' => $tokenID,
        );
        $this->db->insert('userToken', $data);
        $id = $this->db->insert_id();
    }
    
    public function OTKExists($otk)
    {
        $result = $this->getOTK($otk);
        return !empty($result);
    }
    
    public function insertOTK($tokenID, $otk, $time)
    {
        $data = array(
            'tokenID' => $tokenID,
            'key' => $otk,
            'time' => $time
        );
        $this->db->insert('find', $data);
        return $this->db->insert_id();
    }
    
    public function getOTK($otk)
    {
        $query = $this->db->get_where('find', array('key' => $otk));
        return $query->result_array();
    }
    
    public function deleteOTK($otk)
    {
        $this->db->delete('find', array('key' => $otk));
    }
    
    
}
?>
