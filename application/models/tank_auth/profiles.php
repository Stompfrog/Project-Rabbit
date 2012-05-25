<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users
 *
 * This model represents user pro data. It operates the following tables:
 * - user profiles
 */
class Profiles extends CI_Model
{
	private $profile_table_name = 'user_profiles';      // user profiles
	
	function __construct()
	{
		parent::__construct();
		
		$ci =& get_instance();
		$this->profile_table_name = $ci->config->item('db_table_prefix', 'tank_auth').$this->profile_table_name;
		include_once(APPPATH.'classes/Address.php');
	}

	/****************************** Profile section ******************************/
	
	/**
	 * Get profile values
	 *
	 * @param       int
	 * @return      array
	 */
	function get_profile($user_id) {
		$query = $this->db->query("select first_name, about_me, website, sex, last_name from " . $this->profile_table_name . ' where user_id = ' . $user_id);
		
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		} else {                
			return $data = array('first_name' => '', 
		                    'about_me' => '',
		                    'website' => '', 
		                    'sex' => '', 
		                    'last_name' => '');
		}
	}
		
	/**
	 * Update profile
	 *
	 * @param       int
	 * @param       array
	 * @return      array
	 */
	function update_profile($user_id, $data)
	{
        $this->db->where('user_id', (int) $user_id);
        if ($this->db->update($this->profile_table_name, $data))
        {
        	return TRUE;
        }
        return FALSE;
	}
	
	/****************************** Address section ******************************/

	/**
	 * Add address
	 *
	 * @param       int
	 * @param       array
	 * @return      array
	 */
	function add_address ($data) {
		if ($this->db->insert('address', $data))
			return true;
		return false;
	}
	
	function get_addresses ($user_id) {
		$addresses = array();
		$query = $this->db->query('SELECT * FROM address WHERE user_id = ' . $user_id);
	    if ($query->num_rows() > 0)
	    {
		    foreach ($query->result_array() as $row)
		    {
				$address = new Address($row);
				array_push($addresses, $address);
		    }
			return $addresses;
	    }
	    return false;
	}	
	
	function get_address ($user_id, $address_id = null) {
		$and = '';
		if ($address_id)
			$and = ' AND `id` = ' . $address_id;
		$query = $this->db->query('SELECT * FROM `address` WHERE `user_id` = ' . $user_id . $and);
	    if ($query->num_rows() > 0)
			return $query->row_array();
	    return false;
	}
	
	function update_address ($user_id, $address_id, $data) {
        $this->db->where('user_id', (int) $user_id);
        if ($this->db->update('address', $data))
        	return TRUE;
        return FALSE;
	}
	
	function delete_address ($address_id, $user_id) {
		if ($this->db->delete('address', array('id' => $address_id, 'user_id' => $user_id)))
			return true;
		return false;
	}
	
	/****************************** Gallery section ******************************/
	
	function add_gallery ($data) 
	{
		if ($this->db->insert('gallery', $data))
			return true;
		return false;
	}

	function delete_gallery ($gallery_id, $user_id) 
	{
		if ($this->db->delete('gallery', array('id' => $gallery_id, 'user_id' => $user_id)))
			return true;
		return false;
	}
	
	function update_gallery ($user_id, $gallery_id, $data) {
        $this->db->where('user_id', (int) $user_id);
        if ($this->db->update('gallery', $data))
        	return TRUE;
        return FALSE;
	}
	
	function get_gallery ($user_id, $gallery_id) {
		
	}
	
	function get_galleries ($user_id) {
		$galleries = array();
		$query = $this->db->query('SELECT * FROM gallery WHERE user_id = ' . $user_id);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$gallery = new Gallery($row);
				array_push ($galleries, $gallery);
			}
			return $galleries;
		}
			
		return false;
	}
}

/* End of file profiles.php */
/* Location: ./application/models/auth/profiles.php */