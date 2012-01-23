<?php 
class Artists_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
		//load in classes
		include_once(APPPATH.'classes/Image.php');
		include_once(APPPATH.'classes/User.php');
    }

	function get_user_data($user_id)
	{
		// Query the database to get the users details
		$user = $this->db->query("SELECT * FROM user_profiles WHERE user_id = ?",array($user_id));
		if ($user->num_rows() > 0)
		{
			return $user->row_array();
		}
		else
		{
			return false;		
		}
	}
	
	

	
	
	
	function get_user($user_id)
	{
		$query = $this->db->query("select users.username, users.created, users.modified, users.last_login, users.id, user_profiles.country, user_profiles.website, user_profiles.first_name, user_profiles.last_name, user_profiles.avatar_filename, user_profiles.status, user_profiles.sex, user_profiles.about_me, user_profiles.lat, user_profiles.lon from users join user_profiles on users.id = user_profiles.user_id where users.id = " . (int) $user_id);

		if ($query->num_rows() > 0)
		{
		   $row = $query->row_array();

			$properties['username'] = $row['username'];
			$properties['last_login'] = $row['last_login'];
			$properties['created'] = $row['created'];
			$properties['id'] = $row['id'];
			$properties['website'] = $row['website'];
			$properties['first_name'] = $row['first_name'];
			$properties['last_name'] = $row['last_name'];
			$properties['avatar_filename'] = $row['avatar_filename'];
			$properties['status'] = $row['status'];
			$properties['sex'] = $row['sex'];
			$properties['about_me'] = $row['about_me'];
			$properties['lat'] = $row['lat'];
			$properties['lon'] = $row['lon'];
			$user = new User($properties);
			return $user;
		}
		return false;
	}

	function latest_artists($limit){
		// Get the latest people to sign up
		if($limit==0){
			return $this->db->query("SELECT * FROM user_profiles ORDER BY id DESC");
		}
		else
		{
			return $this->db->query("SELECT * FROM user_profiles ORDER BY id DESC LIMIT ".$limit);
		}
	}

   
}
