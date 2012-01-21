<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users
 *
 * This model represents user pro data. It operates the following tables:
 * - user profiles
 */
class Profiles extends CI_Model
{
	private $profile_table_name	= 'user_profiles';	// user profiles

	function __construct()
	{
		parent::__construct();

		$ci =& get_instance();
		$this->profile_table_name	= $ci->config->item('db_table_prefix', 'tank_auth').$this->profile_table_name;
	}

	/**
	 * Update profile
	 *
	 * @param	int
	 * @param	array
	 * @return	array
	 */
	function update_profile($data) {

		if ($this->db->insert($this->table_name, $data)) {
			return TRUE;
		}
		return FALSE;
	}
}

/* End of file users.php */
/* Location: ./application/models/auth/profiles.php */