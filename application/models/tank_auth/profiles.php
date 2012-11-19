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
		include_once(APPPATH.'classes/Group.php');
	}

	/****************************** Profile section ******************************/
	
	/**
	 * Get profile values
	 *
	 * @param       int
	 * @return      array
	 */
	function get_profile($user_id) {
		$query = $this->db->query("select first_name, about_me, website, sex, avatar, last_name from " . $this->profile_table_name . ' where user_id = ' . $user_id);
		
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		} else {                
			return $data = array('first_name' => '', 
	            'about_me' => '',
	            'website' => '', 
	            'sex' => '', 
	            'avatar' => '', 
	            'last_name' => '');
		}
	}
		
	/**
	 * Update profile
	 *
	 * @param       int
	 * @param       array
	 * @return      bool
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
	
	/****************************** Gallery and image section ******************************/

	//moved all gallery and image code to artists_model

}

/* End of file profiles.php */
/* Location: ./application/models/auth/profiles.php */