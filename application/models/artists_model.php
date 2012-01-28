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

	/*
		Parameters: user_id (will probably change it to be either username or id, username can refer to url /artists/roppa
		Returns: User object
	*/
	function get_user($user_id)
	{
		$properties = array();
		$properties['interests'] = array();
		
		$query = $this->db->query("SELECT users.username, users.created, users.modified, users.last_login, users.id, user_profiles.website, user_profiles.first_name, user_profiles.last_name, user_profiles.avatar_filename, user_profiles.status, user_profiles.sex, user_profiles.about_me, user_profiles.lat, user_profiles.lon FROM users JOIN user_profiles ON users.id = user_profiles.user_id WHERE users.id = " . (int) $user_id);
		
		$interests_query = $this->db->query("SELECT role_types.title AS 'title' FROM role_types, user_roles WHERE role_types.id = user_roles.role_type_id AND user_roles.user_id = " . (int) $user_id);

		foreach ($interests_query->result_array() as $row)
		{
			array_push($properties['interests'], $row['title']);
		}

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
	
		/*
		hit a problem getting interests in one query:
		SELECT user_profiles.* , GROUP_CONCAT(role_types.title SEPARATOR ', ') AS 'interests'
				FROM user_profiles, role_types, user_roles
				WHERE role_types.id = user_roles.role_type_id
				AND user_roles.user_id = user_profiles.user_id ORDER BY user_profiles.user_id
		
		*/
	
		// Get the latest people to sign up
		if($limit==0){
			return $this->db->query("SELECT * FROM user_profiles ORDER BY user_id DESC");
		}
		else
		{
			return $this->db->query("SELECT * FROM user_profiles ORDER BY user_id DESC LIMIT ".$limit);
		}
		
		
	}



	/******* Friends section ********
	*/
	
	/* 
		DB Table structure
		------------------------------------------------------
		u1_id		#user id of person requesting
		u2_id		#user id of friend who was requested
		status		#varchar: 'requested', 'ignored', 'friend'
		befriended	#date u2_id accepted
	*/
	function add_friend ($u1_id, $u2_id)
	{
		/*
			u1_id #user id of person requesting
			u2_id #user id of friend who was requested
			status #varchar requested, ignore, friends
			befriended #date u2_id accepted
		*/
		
		//find out if both users exist
		$u1_id_query = $this->db->query('SELECT COUNT(id) AS id FROM users where id = ' . $u1_id);
		$u2_id_query = $this->db->query('SELECT COUNT(id) AS id FROM users where id = ' . $u2_id);
		
		$u1 = $u1_id_query->row();
		$u2 = $u2_id_query->row();
		
		if($u1->id == 1 && $u2->id == 1)
		{
			//check to see if record already exists first
			$query = $this->db->query('SELECT COUNT(id) AS id FROM friends where u1_id = ' . $u1_id . ' AND u2_id = ' . $u2_id);
			$row = $query->row();
			if ($row->id == 0)
			{
				//if true, insert into friends table
				$sql = 'INSERT INTO friends (u1_id, u2_id, status) VALUES (' . $u1_id . ', ' . $u2_id . ', \'requested\')';
				$this->db->query($sql);
				if($this->db->affected_rows() > 0)
				{
					return true;
				}
			}
			
		}
		
		return false;
	}

	
	/*
		update status record to have 'friend' and the date
		make sure we add user ids in right order
		requester is u1_id and new friend is u2_id
		so user_id becomes u2_id, and u1_id is friend_id
	*/
	function confirm_friend ($user_id, $friend_id)
	{
		$data = array(
           'status' => 'friend',
           'befriended' => date('Y-m-d H:i:s')
        );
		$this->db->where('u1_id', $friend_id);
		$this->db->where('u2_id', $user_id);
		$this->db->update('friends', $data);
		
		/*
			now, create 2 way friendship by inserting a new record for user_id
		*/
		
		$data = array(
		   'u1_id' => $user_id,
		   'u2_id' => $friend_id,
		   'status' => 'friends' ,
		   'befriended' => date('Y-m-d H:i:s')
		);
		$this->db->insert('friends', $data);
		
		return true;
	}
	
	/*
		
	*/
	function unfriend ($user_id, $friend_id)
	{
		//update status record to have 'friend' and the date
	}
	
	/*
		if no limit parameter, default is 5
	*/
	function get_friends ($user_id, $limit = 5)
	{
	
		$friends = array();
	
		$query = $this->db->query("SELECT `friends`.`u2_id`, `user_profiles`.`first_name`, `user_profiles`.`last_name` FROM `friends`, `user_profiles` WHERE `user_profiles`.`user_id` = `friends`.`u2_id` AND u1_id = " . $user_id);
		
		foreach ($query->result_array() as $row)
		{
			$data = array();
			$data['id'] = $row['u2_id'];
			$data['name'] = $row['first_name'] . ' ' . $row['last_name'];
			array_push($friends, $data);
		}
		
		return $friends;
		
	}

}
