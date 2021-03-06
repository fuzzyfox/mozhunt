<?php
// ./application/model/user_model.php

/**
 * Contains the various models for reading and writing user data
 * @author Steve "Uru" West <uru@mozhunt.com>, William Duyck <william@mozhunt.com>
 * @version 2012-04-01
 */
class User_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * Gets the first user with a $field that matches $value. Only returns the first user found
	 * @param string field The field to search for
	 * @param string value The value to search for
	 * @return The user information or an empty array if no user was found
	 * @author Steve "Uru" West
	 * @version 2012-01-22
	 */
	public function getUserBy($field, $value)
	{
		$conditions = array(
			$field => $value,
		);

		$query = $this->db->get_where('user', $conditions);
		return $query->result_array();
	}

	/**
	 * Checks to see if the given key is already in use
	 * @param string key The key to check for
	 * @return TRUE if the key is already in use
	 * @author Steve "Uru" West
	 * @version 2012-01-21
	 */
	public function authKeyExists($key)
	{
		$result = $this->getUserBy('activationKey', $key);
		if(!empty($result))
		{
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Inserts a new user into the database.
	 * @param array data The data for the new user
	 * @return int The new user's ID
	 * @author Steve "Uru" West
	 * @version 2012-01-22
	 */
	public function insert($data)
	{
		$this->db->insert('user', $data);
		return $this->db->insert_id();
	}

	/**
	 * Updates a user in the database
	 * @param array data The new data to use. Must contain a 'userID' key and value
	 * @author Steve "Uru" West
	 * @version 2012-01-22
	 */
	public function updateUser($data)
	{
		$this->db->where('userID', $data['userID']);
		$this->db->update('user', $data);
	}

	/**
	 * Gets all users in the database
	 * @author Steve "Uru" West
	 * @version 2012-02-05
	 */
	public function getAllUsers()
	{
		return $this->db->get('user')->result_array();
	}

	/**
	 * Deletes the given user
	 * @param int userID The ID of the user to delete
	 * @author Steve "Uru" West
	 * @version 2012-02-06
	 */
	public function deleteUser($userID)
	{
		$this->db->delete('user', array('userID' => $userID));
	}
	
	/**
	 * Gets a human readable version of the users status code
	 *
	 * @author William Duyck <william@mozhunt.com>
	 * @version 2012.04.01
	 * 
	 * @param int userID The user to get the status for
	 * @return string Human readable version of the users status
	 */
	public function getHumanStatus($userID)
	{
		$user = $this->getUserBy('userID', $userID);
		$userStatus = $user[0]['userStatus'];
		$this->config->load('status_codes');
		$codes = $this->config->item('status_codes');
		return $codes['user'][$userStatus];
	}
	
	public function getUserRank($userID)
	{
		$this->db->query('SET @rownum := 0');
		$rank = $this->db->query("SELECT *, rank FROM (
				SELECT @rownum := @rownum + 1 AS rank, COUNT(*) 'token_count'
				FROM userToken
				WHERE userToken.userID = $userID
				GROUP BY userToken.userID
				ORDER BY token_count DESC
				LIMIT 1
			) AS result");
		$rank = $rank->result_array();
		return $rank[0]['rank'];
	}
}

// End fo file user_model.php
