<?php 
class Artists_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        
        $this->load->model('tank_auth/profiles', 'profiles_model');
        
        //load in classes
        include_once(APPPATH.'classes/Image.php');
        include_once(APPPATH.'classes/Profile_Image.php');
        include_once(APPPATH.'classes/User.php');
        include_once(APPPATH.'classes/Address.php');
        include_once(APPPATH.'classes/Group.php');
    }
    
    /****** Artist/user section *********************************
        
    
    *************************************************************/
    
	/*
	    Parameters: user_id (will probably change it to be either username or id, username can refer to url /artists/roppa
	    Returns: User object
	*/
	function get_user($user_id)
	{
		/*
		//find out if param is an int
			if it is, see if it is a valid user
		//else if it is a string, see if it is a valid user
		//else return false
		if (is_int($user_id)) {
		
		}
		*/
		
		if(! isset($user_id)) {
			return false;
		}
		
	    $properties = array();
	
		//get all artists addresses
		$addresses = array();
		$address_query = $this->db->query("SELECT * FROM address WHERE user_id = " . $user_id);
		if ($address_query->num_rows() > 0) {
			foreach ($address_query->result_array() as $row) {
				$address = new Address($row);
				array_push($addresses, $address);
			}
		}
	
	    $query = $this->db->query("SELECT users.username, users.email, users.created, users.modified, users.last_login, users.id, user_profiles.website, user_profiles.first_name, user_profiles.last_name, image.file_name AS avatar_filename, user_profiles.status, user_profiles.sex, user_profiles.about_me  
                                    FROM users 
                                    JOIN user_profiles ON users.id = user_profiles.user_id 
                                    LEFT JOIN image ON image.id = user_profiles.avatar
                                    WHERE users.id = " . (int) $user_id);

	    if ($query->num_rows() > 0)
	    {
            $row = $query->row_array();
            $properties['interests'] = $this->get_interests($row['id']);
            $properties['username'] = $row['username'];
            $properties['email'] = $row['email'];
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
            $properties['addresses'] = $addresses;
            
            $properties['groups'] = $this->get_groups($user_id);
            
            $user = new User($properties);
            return $user;
	    }
	    return false;
	}
        
	function get_user_id_from_username ($user_name) {
	
	    if(!is_numeric ($user_name))
	    {
			$query = $this->db->query("SELECT id FROM users WHERE username = '$user_name'");
			if ($query->num_rows() > 0) {
			    $row = $query->row_array();
			    return intval($row['id']);
			}
	    } else {
	    	return $user_name;
	    }
	    return false;
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
	
	function all_artists($params = array())
	{
	    $users = $this->db->query("SELECT * FROM user_profiles, address where address.user_id = user_profiles.user_id");
	    if ($users->num_rows() > 0)
	    {
	    	return $users->result_array();
	    }
	    else
	    {
	    	return false;
	    }
	}

	/*
		Get artists based on thier interests
	*/
	function all_artists_interests($params = array())
	{
		$query = 'SELECT * FROM user_profiles, address where address.user_id = user_profiles.user_id';
	
		if(sizeof($params) > 0 && $params !== false) {
			//make sure array is ok
			foreach ($params as $param) {
				
			}
			$query .= ' AND user_profiles.user_id IN (SELECT user_id FROM user_interests WHERE interest_type_id IN (' . implode(",", $params) . '))';
	    }
	    
	    $users = $this->db->query($query);
	    
	    if ($users->num_rows() > 0) {
	    	return $users->result_array();
	    } else {
	    	return false;
	    }
	}
	
	function latest_artists ($limit = 5)
	{
	    $results = array();
	    //$query = $this->db->query("SELECT * FROM user_profiles ORDER BY user_id DESC LIMIT " . $limit);
	    $query = $this->db->query("SELECT user_profiles.*, users.email FROM user_profiles, users WHERE users.id = user_profiles.user_id ORDER BY user_profiles.user_id DESC LIMIT " . $limit);
	    
	    foreach ($query->result() as $row)
	    {
			$row->interests = $this->get_interests($row->user_id);
			array_push($results, $row);
	    }
	    
	    return $results;
	}
	
	/*
	    page = current page
	    limit = number of artists to get
	    offset = number of artists to get from
	    
	    100 artists (total), 10 artists per page (limit) , current page is 5 (offset = page * limit)
	    offset will be 50, and 10 records brought back
	*/
	function latest_artists_paginated ($page = 1, $limit = 5)
	{
	    $offset = ($page - 1) * $limit;
	    
	    $results = array();
	    
	    $query = $this->db->query("SELECT user_profiles.*, users.email FROM user_profiles, users WHERE users.id = user_profiles.user_id ORDER BY user_profiles.user_id DESC LIMIT " . $offset . ", " . $limit);
	    
	    foreach ($query->result() as $row)
	    {
			$row->interests = $this->get_interests($row->user_id);
			if ($row->avatar !== null) {
				$row->avatar = $this->artists_model->get_profile_image($row->avatar);
			}
			array_push($results, $row);
	    }
	    
	    return $results;
	}
	
	function get_total_artists () {
	    
	    $query = $this->db->query("SELECT COUNT(id) AS total_artitsts FROM users where activated = 1");
	
	    if ($query->num_rows() > 0)
	    {
	       $row = $query->row();
	       return intval($row->total_artitsts);
	    }
	    
	    return false;
	}
	
	function get_interests($user_id)
	{
	    $interests = array();
	    $query = $this->db->query("SELECT interests.title AS 'title' 
                                    FROM interests, user_interests 
                                    WHERE interests.id = user_interests.interest_type_id 
                                    AND user_interests.user_id = " . (int) $user_id);
	    if ($query->num_rows() > 0) {
		    foreach ($query->result_array() as $row) {
		    	array_push($interests, $row['title']);
		    }
		    return $interests;
	    }
	    return false;
	}
	
	function get_all_interests ()
	{
		$query = $this->db->query("SELECT * FROM interests");
	    if ($query->num_rows() > 0)
	    {
	    	return $query->result_array();
	    }
	    return false;
	}
	
	/******* Friends section *********************************
	
	    DB Table structure
	    ------------------------------------------------------
	    u1_id           #user id of person requesting (current logged in user)
	    u2_id           #user id of friend who was requested
	    status          #varchar: 'requested', 'ignored', 'friend'
	    befriended      #date u2_id accepted
	    ------------------------------------------------------
	    
	*************************************************************/
	
	function add_friend ($u1_id, $u2_id)
	{
	    //find out if user exist
	    $u2_id_query = $this->db->query('SELECT COUNT(id) AS id FROM users where id = ' . $u2_id);
	    
	    $u2 = $u2_id_query->row();
	    
	    if ($u1_id == $u2_id) {
	    	return "You cannot add yourself as a friend";
	    }
	    
	    if($u2->id == 1)
	    {
			if(! $this->friend_requested($u1_id, $u2_id)) {
			    //check to see if they are already friends
			    if (! $this->already_friends($u1_id, $u2_id))
			    {
					//if true, insert into friends table
					$sql = 'INSERT INTO friends (u1_id, u2_id, status) VALUES (' . $u1_id . ', ' . $u2_id . ', \'requested\')';
					$this->db->query($sql);
					if($this->db->affected_rows() > 0)
					{
					    return 'We have sent a request to the user';
					}
				//they are friends
			    } else {
			    	return 'you are already friends';
			    }
			} else {
			    return 'you have already requested to be friends';
			}
	    }
	    
	    return 'It was not possible to add this user as a friend';
  
	}
	
	/*
	    update status record to have 'friend' and the date
	    make sure we add user ids in right order
	    requester is u1_id and new friend is u2_id
	    so user_id becomes u2_id, and u1_id is friend_id
	*/
	function confirm_friend ($u1_id, $u2_id)
	{
	    if($this->already_friends($u1_id, $u2_id)) return 'you are already friends';
	    if ($u1_id === $u2_id) return "you cannot befriend yourself";
	    if(! $this->friend_invite($u1_id, $u2_id)) return 'friendship was not requested from that user';
	
	    $data = array(
		   'status' => 'friend',
		   'befriended' => date('Y-m-d H:i:s')
		);
	    $this->db->where('u1_id', $u2_id);
	    $this->db->where('u2_id', $u1_id);
	    $this->db->update('friends', $data);
	    
	    /*
	            now, create 2 way friendship by inserting a new record for user_id
	    */
	    $data = array(
	       'u1_id' => $u1_id,
	       'u2_id' => $u2_id,
	       'status' => 'friend' ,
	       'befriended' => date('Y-m-d H:i:s')
	    );
	    $this->db->insert('friends', $data);
	    
	    return "You are now friends";
	}
	
	/*
	    I think we should just remove the records rather than setting the status
	*/
	function unfriend ($user_id, $friend_id)
	{
	    $this->db->delete('friends', array('u1_id' => $user_id, 'u2_id' => $friend_id));
	    $this->db->delete('friends', array('u2_id' => $user_id, 'u1_id' => $friend_id));
	    if($this->db->affected_rows() > 0) {
	    	return "You are no longer friends";
	    } else {
	    	return "No records have been changed";
	    }
	}
	
	/*
	    if no limit parameter, default is 5
	*/
	function get_friends ($user_id, $limit = 5)
	{
	    $friends = array();
	
	    $query = $this->db->query("SELECT `friends`.`u2_id`, `user_profiles`.`first_name`, `user_profiles`.`last_name` 
		    FROM `friends`, `user_profiles` 
		    WHERE `user_profiles`.`user_id` = `friends`.`u2_id` 
		    AND `friends`.`u1_id` = " . $user_id . " 
		    AND `friends`.`status` = 'friend'");
		
		if (sizeof($query->result_array()) > 0) {
		    foreach ($query->result_array() as $row)
		    {
				$data = array();
				$data['id'] = $row['u2_id'];
				$data['name'] = $row['first_name'] . ' ' . $row['last_name'];
				array_push($friends, $data);
		    }
		} else {
		    $friends == null;
		}
	    return $friends;
	}
	
	/*
	    page = current page
	    limit = number of artists to get
	    offset = number of artists to get from
	    
	    100 artists (total), 10 artists per page (limit) , current page is 5 (offset = page * limit)
	    offset will be 50, and 10 records brought back
	*/
	function get_friends_paginated ($user_id, $page = 1, $limit = 5)
	{
	    $offset = ($page - 1) * $limit;
	    $friends = array();
	    
		$query = $this->db->query("SELECT `friends`.`u2_id`, `user_profiles`.`first_name`, `user_profiles`.`last_name` 
		    FROM `friends`, `user_profiles` 
		    WHERE `user_profiles`.`user_id` = `friends`.`u2_id` 
		    AND `friends`.`u1_id` = " . $user_id . " 
		    AND `friends`.`status` = 'friend' LIMIT " . $offset . ", " . $limit);
	    
		if (sizeof($query->result_array()) > 0) {
		    foreach ($query->result_array() as $row)
		    {
				$data = array();
				$data['id'] = $row['u2_id'];
				$data['name'] = $row['first_name'] . ' ' . $row['last_name'];
				array_push($friends, $data);
		    }
		} else {
		    $friends == null;
		}

	    return $friends;
	}
	
	/*
	    
	*/
	function get_pending_friends ($user_id)
	{
	    $friends = array();
	
	    $query = $this->db->query("SELECT `friends`.`u1_id`, `user_profiles`.`first_name`, `user_profiles`.`last_name` 
                                    FROM `friends`, `user_profiles` 
                                    WHERE `user_profiles`.`user_id` = `friends`.`u1_id` 
                                    AND `friends`.`status` = 'requested'
                                    AND u2_id = " . $user_id);
	
	    if (sizeof($query->result_array()) > 0) {
			foreach ($query->result_array() as $row)
			{
				$data = array();
				$data['id'] = $row['u1_id'];
				$data['name'] = $row['first_name'] . ' ' . $row['last_name'];
				array_push($friends, $data);
			}
	    } else {
	    	$friends == null;
	    }
	    return $friends;
	}
	
	/*
	    Establish if the two users are aready friends
	*/
	function already_friends ($u1_id, $u2_id)
	{
	    $query = $this->db->query("SELECT COUNT(id) AS is_friend FROM friends where u1_id = " . $u1_id . " AND u2_id = " . $u2_id . " AND `friends`.`status` = 'friend'");
	
	    if ($query->num_rows() > 0)
	    {
	       $row = $query->row();
	       if($row->is_friend == 1) return true;
	    }			

	    return false;
	}
	
	function friend_invite ($u1_id, $u2_id) 
	{
	    $query = $this->db->query("SELECT COUNT(id) AS friend_requested FROM friends where u1_id = " . $u2_id . " AND u2_id = " . $u1_id . " AND `friends`.`status` = 'requested'");
	
	    if ($query->num_rows() > 0) {
	       $row = $query->row();
	       if ($row->friend_requested == 1) return true;
	    }		

	    return false;
	}
	
	/*
	    Establish if a friendship as been requested. 
	    
	    $u1_id = person who has been asked to be a friend
	    $u2_id = person who initiates the request
	*/
	function friend_requested ($u1_id, $u2_id) {
		
	    $query = $this->db->query("SELECT COUNT(id) AS friend_requested FROM friends where u1_id = " . $u1_id . " AND u2_id = " . $u2_id . " AND `friends`.`status` = 'requested'");
	
	    if ($query->num_rows() > 0) {
	       $row = $query->row();
	       if ($row->friend_requested == 1) return true;
	    }

	    return false;
	
	}

	/*
	    Get total number of friends for user
	*/
	function get_total_friends ($user_id) {
	    
	    $query = $this->db->query("SELECT COUNT(u1_id) AS total_friends FROM friends where status = 'friend' and u1_id = " . $user_id);
	
	    if ($query->num_rows() > 0)
	    {
	       $row = $query->row();
	       return intval($row->total_friends);
	    }
	    
	    return false;
	}
	
	/****** Address section ***************************************

	/**
	 * Add address
	 *
	 * @param       int
	 * @param       array
	 * @return      array
	 */

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

	//get address
	function get_address ($user_id, $address_id = null) {
		$and = '';
		if ($address_id) {
			$and = ' AND `id` = ' . $address_id;
		}
		$query = $this->db->query('SELECT * FROM `address` WHERE `user_id` = ' . $user_id . $and . ' LIMIT 1');
	    if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	    return false;
	} 
	 
	function add_address ($data) {
		if ($this->db->insert('address', $data))
			return true;
		return false;
	}
	
	function valid_address ($user_id, $address_id) {
	
		if (isset($address_id) && is_numeric($address_id)) {
	    	$query = $this->db->query("SELECT COUNT(id) AS address_exists FROM address where id = " . $address_id . " AND user_id = " . $user_id);
		    if ($query->num_rows() > 0)
		    {
		       $row = $query->row();
		       if($row->address_exists > 0) return true;
		    } else {
		    	return false;
		    }    	
		}

	    return false;
	}
	
	//update address
	function update_address ($user_id, $address_id, $data) {
		if ($this->valid_address($user_id, $address_id)) {
	        $this->db->where('user_id', (int) $user_id);
	        $this->db->where('id', (int) $address_id);
	        if ($this->db->update('address', $data)) {
	        	return true;
	        }
	        return false;
	    }
	    return false;
	}
	
	function delete_address ($user_id, $address_id) {
		if ($this->valid_address($user_id, $address_id)) {
			if ($this->db->delete('address', array('id' => $address_id, 'user_id' => $user_id))) {
				return true;
			} else {
				return false;
			}
		}
		return false;
	}
	
	/********* Places ****************************************************/

	function popular_places ($limit = 5) {
	
	    $results = array();
	    $query = $this->db->query("SELECT * FROM address WHERE is_venue = 1 ORDER BY id DESC LIMIT " . $limit);
	    
	    return $query->row_array();
	}

	/****** Geolocational section ********************************
	*************************************************************/
	function get_geo_addresses ($distance, $lat, $lng) {
	    $results = array();
	    $query = $this->db->query('SELECT *, ( 3959 * acos( cos( radians(37) ) * cos( radians( ' . $lat . ' ) ) * cos( radians( ' . $lng . ' ) - radians(-122) ) + sin( radians(37) ) * sin( radians( ' . $lat . ' ) ) ) ) AS distance FROM address HAVING distance < ' . $distance . ' ORDER BY distance LIMIT 0 , 20');
	    return $query->result_array();
	}
	
	/****************************** Groups section ******************************/
	
	
	/************************************************************
	*
	* Information: Group membership (`group_users`.`rights` column)
	*
	* Creator: 1
	* Admin: 2
	* Member: 3
	* Requested: 4
	* Invited: 5
	* Blocked: 6
	* Declined: 7
	*
	*************************************************************/

	/************************************************************
	*
	* Function: Create group
	*
	*************************************************************/
	
	function create_group ($user_id, $data) 
	{
		$data['created_date'] = date('Y-m-d H:i:s');
		if ($this->db->insert('group', $data)) {
			$group_users = array(
				'group_id' => $this->db->insert_id(),
				'user_id' => $user_id,
				'join_date' => date('Y-m-d H:i:s'),
				'rights' => 1
			);
			if( $this->db->insert('group_users', $group_users)) {
				return true;
			}
		}
	
		return false;
	}
	
	function update_group ($user_id, $group_id, $data) {

		//find out if user is admin
		if ($this->user_is_group_admin($user_id, $group_id)) {
        	$this->db->where('id', (int) $group_id);
	        if ($this->db->update('group', $data)) {
	        	return true;
	        }
		}

        return false;
	}
	
	function delete_group ($user_id, $group_id) 
	{
		if ($this->user_is_group_creator($user_id, $group_id)) {
			//if user is admin at least. If other admin are there, ask their permission too?
			//where user_id is creator_id
			if ($this->db->delete('group', array('id' => $group_id))) {
				return true;
			}	
		}
		return false;
	}
	
	function get_group_members ($group_id) {
	    $query = $this->db->query("SELECT * FROM `group_users`, `user_profiles` WHERE `group_users`.`user_id` = `user_profiles`.`user_id` AND `group_users`.`group_id` = " . $group_id . ' AND `group_users`.`rights` < 4');
	    if ($query->num_rows() > 0)
	    {
	    	return $query->result_array();
	    }
	    return false;
	}
	
	function user_is_group_admin ($user_id, $group_id) {
		$query = $this->db->query('SELECT count(*) AS admin FROM `group_users` WHERE `user_id` = ' . $user_id . ' AND `group_id` = ' . $group_id . ' AND `group_users`.`rights` <= 2');
	    if ($query->num_rows() > 0) {
			$row = $query->row_array();
			if ( $row['admin'] > 0) return true;
		}
	    return false;
	}
	
	function user_is_group_creator ($user_id, $group_id) {
		$query = $this->db->query('SELECT count(*) AS is_creator FROM `group_users`, `group` WHERE `group`.`id` = `group_users`.`group_id` and `group`.`id` = ' . $group_id . ' AND `group_users`.`user_id` = ' . $user_id . ' AND `group_users`.`rights` = 1');
	    if ($query->num_rows() > 0) {
			$row = $query->row_array();
			if ( $row['is_creator'] > 0) return true;
		}
	    return false;
	}
	
	function user_is_group_member ($user_id, $group_id) {
		$query = $this->db->query('SELECT count(*) AS is_member FROM `group_users`, `group` WHERE `group`.`id` = `group_users`.`group_id` and `group`.`id` = ' . $group_id . ' AND `group_users`.`user_id` = ' . $user_id . ' AND `group_users`.`rights` <= 3');
	    if ($query->num_rows() > 0) {
			$row = $query->row_array();
			if ( $row['is_member'] > 0) return true;
		}
	    return false;
	}
	
	function user_group_invited ($user_id, $group_id) {
		$query = $this->db->query('SELECT count(*) AS is_invited FROM `group_users` WHERE `user_id` = ' . $user_id . ' AND `group_id` = ' . $group_id . ' AND `rights` = 5');
	    if ($query->num_rows() > 0) {
			$row = $query->row_array();
			if ( $row['is_invited'] == 1) return true;
		}
	    return false;
	}
	
	function valid_user_group ($user_id, $group_id) {
		if (isset($group_id) && is_numeric($group_id)) {
	    	$query = $this->db->query("SELECT count(*) as valid_group FROM `group_users`, `group` WHERE `group`.`id` = `group_users`.`group_id` and `group`.`id` = " . $group_id . " AND `group_users`.`user_id` = " . $user_id);
		    if ($query->num_rows() > 0)
		    {
		       $row = $query->row();
		       if($row->valid_group > 0) return true;
		    } else {
		    	return false;
		    }    	
		}
	    return false;
	}
	
	function valid_group ($group_id) {
		if (isset($group_id) && is_numeric($group_id)) {
	    	$query = $this->db->query("SELECT count(*) as valid_group FROM `group_users`, `group` WHERE `group`.`id` = `group_users`.`group_id` and `group`.`id` = " . $group_id);
		    if ($query->num_rows() > 0)
		    {
		       $row = $query->row();
		       if($row->valid_group > 0) return true;
		    } else {
		    	return false;
		    }    	
		}
	    return false;
	}
	
	/*
		If a user requests to join a group they are in some way connected to we need to handle the correct response.
		Find out if user is connected to this group in any capacity
	*/
	function group_user_request ($user_id, $group_id) {
	
		$error = array();
	
		//if invalid group, return error message
		if (! $this->valid_group($group_id)) {
			$error["message"] = "group does not exist";
			return $error;
		}
	
	    $query = $this->db->query("SELECT rights, COUNT(*) AS total_groups FROM `group_users` WHERE group_id = " . $group_id . " AND user_id = " . $user_id);
	
		//user record already exists, now find out what they are
		if ($query->num_rows() > 0) {

			$row = $query->row();
			
			if($row->total_groups > 0) {
			
				//is_admin, is_creator, is_member, invited, requested, blocked, declined
				
				switch ($row->rights) {
					case 1:
						//is creator
						$error["message"] = "User is the creator of this group already";
						return $error;
				        break;
				    case 2:
				    	//is admin
						$error["message"] = "User is an administrator of this group already";
						return $error;
				        break;
				    case 3:
				    	//is member
						return $error["message"] = "User is already a member";
						return $error;
				        break;
				   	case 4:
				   		//has requested
				   		$error["message"] = "User has already requested to join";
						return $error;
				   		break;
				   	case 5:
				   		//is invited
						$error["message"] = "User has already been invited";
						return $error;				   	
				   		break;
				   	case 6:
				   		//user is blocked
						return $error["message"] = "User is blocked from this group";
						return $error;				   		
				   		break;
				   	case 7:
				   		//user has declined invite
						return $error["message"] = "User does not want to join group";
						return $error;				   		
				   		break;
				}

			} else {
	    		return true;
	    	}
	    }
	    //generic error fallover
	    return $error["message"] = "An error with the database has occurred";
	}
	
	function get_all_groups($page = 1, $limit = 5)
	{
		$offset = ($page - 1) * $limit;

	    $query = $this->db->query("SELECT * FROM `group` ORDER BY  `created_date` DESC LIMIT " . $offset . ", " . $limit);
	    if ($query->num_rows() > 0)
	    {
	    	return $query->result_array();
	    }
	    return false;
	}
	
	function total_groups ()
	{
	    $query = $this->db->query("SELECT COUNT(id) AS total_groups FROM `group`");
	
	    if ($query->num_rows() > 0)
	    {
	       $row = $query->row();
	       return intval($row->total_groups);
	    }
	    
	    return 0;
	}
	
	function latest_groups ($limit = 5) {
	
	    $results = array();
	    $query = $this->db->query("SELECT * FROM `group` ORDER BY `created_date` DESC LIMIT " . $limit);
	    
	    return $query->result();
	}
	
	//get the grups that user is a member of
	function get_groups ($user_id) {
		$groups = array();
		$query = $this->db->query('SELECT DISTINCT * FROM `group_users`, `group` WHERE `group_users`.`user_id` = '  . $user_id . ' AND `group`.`id` = `group_users`.`group_id`');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$group = new Group($row);
				array_push ($groups, $group);
			}
			return $groups;
		}
			
		return false;
	}
	
	function get_group ($group_id) {
		$query = $this->db->query('SELECT DISTINCT * FROM `group_users`, `group` WHERE `group`.`id` = `group_users`.`group_id` and `group`.`id` = ' . $group_id . ' AND `group_users`.`rights` <= 3');
	    if ($query->num_rows() > 0) {
	    	$data = array();
	    	$data['group_members'] = $this->get_group_members($group_id);
	    	$data = array_merge($data, $query->row_array());
			$group = new Group($data);
			return $group;
		}
	    return false;
	}
	
	function get_group_json ($group_id) {
		$query = $this->db->query('SELECT DISTINCT * FROM `group_users`, `group` WHERE `group`.`id` = `group_users`.`group_id` and `group`.`id` = ' . $group_id);
	    if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	    return false;
	}
	
	function get_user_group ($user_id, $group_id) {
	    $query = $this->db->query("SELECT * FROM `group_users`, `group` WHERE `group`.`id` = `group_users`.`group_id` and `group`.`id` = " . $group_id . " AND `group_users`.`user_id` = " . $user_id);
	    if ($query->num_rows() > 0)
	    {
	    	return $query->row_array();
	    }
	    return false;
	}

	//request to join group
	function join_group ($user_id, $group_id)
	{
		//if the group is not valid return "group does not exist"
		if (!$this->valid_group($group_id)) {
			return "group does not exist";
		}
		
		//if user is already a member return "you are already a member"
		//if user has already requested membership return "you have already requested membership"
		$user_result = $this->group_user_request($user_id, $group_id);
		if ($user_result !== true) {
			//handle error response
			return $user_result;
		}

		//otherwise
		$group_user = array(
			'group_id' => $group_id,
			'user_id' => $user_id,
			'join_date' => date('Y-m-d H:i:s'),
			'rights' => 4
		);

		if($this->db->insert('group_users', $group_user)) {
			return true;
		}

		return false;
	}
	
	function leave_group ($user_id, $group_id)
	{
		//if user is creator of group, the user has to pass the group onto someone else? or all administrator
		if ($this->user_is_group_creator($user_id, $group_id)) {
			return "You are the creator of the group";
		}
		//if they are a member of the group, delete their entry in group_users
		if ($this->user_is_group_member($user_id, $group_id)) {
			if ($this->db->delete('group_users', array('user_id' => $user_id, 'group_id' => $group_id))) {
				return true;
			}			
		} else {
			return "You are not a member of the group";
		}

		return false;
	}
	
	//get user requests to join group
	function get_group_requests($group_id) {
		$query = $this->db->query("SELECT `group_users`.`id`, `user_profiles`.* FROM `group_users`, `user_profiles` WHERE `group_users`.`group_id` = " . $group_id . " AND `group_users`.`rights` = 4 AND `user_profiles`.`user_id` = `group_users`.`user_id`");
	    if ($query->num_rows() > 0) {
	    	return $query->result_array();
	    }
	    return false;
	}
	
	//invite user to join group
	function invite_user_to_group($inviter_id, $user_id, $group_id)
	{
		//find out if group is valid
		if (!$this->valid_group($group_id)) {
			$message = array("error" => "Group does not exist");
			return $message;
		}
		//find out if user has admin rights
		if (!$this->user_is_group_admin($inviter_id, $group_id)) {
			$message = array("error" => "You do not have admin rights to invite users");
			return $message;
		}
		//find out if user has already been invited or has requested
		$user_result = $this->group_user_request($user_id, $group_id);
		if ($user_result !== true) {
			//handle error response
			return $user_result;
		}

		$data = array('group_id' => $group_id, 'user_id' => $user_id, 'rights' => 5);

		if ($this->db->insert('group_users', $data))
			return true;
		
		return false;
	}
	
	//user declines group invite
	function decline_group_invite ($user_id, $group_id)
	{
		//find out if user has been invited
		if ($this->user_group_invited($user_id, $group_id)) {
			//if yes, update group_users, set rights to 7
			$data = array('rights' => 7);
			$this->db->where('user_id', (int) $user_id);
			$this->db->where('group_id', (int) $group_id);
	        if ($this->db->update('group_users', $data)) {
	        	return true;
	        }
	        return false;
				//return true
		} else {
			return "You have not been invited into this group";
		}
	}
	
	//deny user entry into group
	function deny_user_group_entry ($admin_id, $user_id, $group_id) 
	{
		//if user is group admin
		if ($this->user_is_group_admin($admin_id, $group_id)) {
			if (!$this->user_is_group_member($user_id, $group_id)) {
				//if yes, update group_users, set declined to 1
				$data = array('rights' => 6);
				$this->db->where('user_id', (int) $user_id);
				$this->db->where('group_id', (int) $group_id);
		        if ($this->db->update('group_users', $data))
		        	return true;
		    } else {
		    	return "User is already a member of the group";
		    }   	
		} else {
			return "You are not authorised to perform this action";
		}
	}

	//accept user into group
	function accept_group_invitation ($user_id, $group_id) 
	{
		//if user is group admin
		if ($this->user_group_invited($user_id, $group_id)) {
			//if yes, update group_users, set rights to 3
			$data = array('rights' => 3);
			$this->db->where('user_id', (int) $user_id);
			$this->db->where('group_id', (int) $group_id);
	        if ($this->db->update('group_users', $data)) {
	        	return true;
	        }
		} else {
			return "You have not been invited into this group";
		}
	}

	//accept user into group
	function accept_user_into_group ($admin_id, $user_id, $group_id) 
	{
		//if user is group admin
		if ($this->user_is_group_admin($admin_id, $group_id)) {
			//if yes, update group_users, set rights to 3
			$data = array('rights' => 3);
			$this->db->where('user_id', (int) $user_id);
			$this->db->where('group_id', (int) $group_id);
	        if ($this->db->update('group_users', $data))
	        	return true;
		} else {
			return "You are not authorised to perform this action";
		}
	}
	
	//remove user from group
	function remove_user_from_group ($admin_id, $user_id, $group_id)
	{
		//if user is group admin
		if ($this->user_is_group_admin($admin_id, $group_id)) {
			//if yes, update group_users, set rights to 6
			$data = array('rights' => 6,);
			$this->db->where('user_id', (int) $user_id);
			$this->db->where('group_id', (int) $group_id);
	        if ($this->db->update('group_users', $data))
	        	return true;
		} else {
			return "You are not authorised to perform this action";
		}
	}
	
	/* set user as group creator*/
	function reassign_group ($user_id, $group_id) 
	{
        $this->db->where('user_id', (int) $user_id);
        $this->db->where('group_id', (int) $group_id);
        $data = array('rights' => 1);
        if ($this->db->update('group_users', $data))
        	return true;
        return false;
	}
		
	/****** Gallery and Image methods **********************************/
	
	function get_galleries ($user_id) {
		$galleries = array();
		$query = $this->db->query('SELECT gallery.id, gallery.title, gallery.description, image.id as image_id, image.title as image_title, image.alt, image.file_name FROM `gallery` LEFT JOIN `gallery_image` ON `gallery_image`.`gallery_id` = `gallery`.`id` LEFT JOIN `image` ON `gallery_image`.`image_id` = `image`.`id` WHERE `gallery`.`user_id` = ' . $user_id . ' GROUP BY `gallery`.`id`');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$gallery_data['id'] = $row['id'];
				$gallery_data['user_id'] = $user_id;
				$gallery_data['title'] = $row['title'];
				$gallery_data['description'] = $row['description'];
				$gallery_data['images'] = null;
				if ($row['image_id'] != null) {
					$image_data = array('id' => $row['image_id'],
										'title' => $row['image_title'],
										'alt' => $row['alt'],
										'description' => $row['description'],
										'file_name' => $row['file_name']
										);
					$image = new Image($image_data);
					$gallery_data['images'] = array($image);
				}
				$gallery = new Gallery($gallery_data);
				array_push ($galleries, $gallery);
			}
			return $galleries;
		}
			
		return false;
	}
	
	function get_gallery ($user_id, $gallery_id) {
		$query = $this->db->query('SELECT * FROM `gallery` WHERE `id` = ' . $gallery_id . ' AND `user_id` = ' . $user_id);
	    if ($query->num_rows() > 0) {
	    	$gallery = $query->row_array();
	    	$gallery['images'] = $this->get_gallery_images($user_id, $gallery_id);
			return $gallery;
		}
	    return false;
	}
	
	function add_gallery ($data) 
	{
		if ($this->db->insert('gallery', $data))
			return true;
		return false;
	}
	
	function update_gallery ($user_id, $gallery_id, $data) {
        $this->db->where('user_id', (int) $user_id);
        if ($this->db->update('gallery', $data))
        	return false;
        return false;
	}	

	function delete_gallery ($user_id, $gallery_id) 
	{
		if ($this->db->delete('gallery', array('id' => $gallery_id, 'user_id' => $user_id)))
			return true;
		return false;
	}
	
	function get_gallery_images ($user_id, $gallery_id) {
		$images = array();

		$query = $this->db->query('SELECT * FROM `image` WHERE id IN (SELECT image_id FROM `gallery_image` WHERE user_id = ' . $user_id . ' AND gallery_id = ' . $gallery_id . ')');
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$image = new Image($row);
				array_push ($images, $image);
			}
			return $images;
		}
		return false;
	}

	function valid_gallery ($user_id, $gallery_id) {
		$query = $this->db->query('SELECT DISTINCT COUNT( * ) AS valid_gallery FROM gallery WHERE user_id = ' . $user_id . ' AND id = ' . $gallery_id);
	    if ($query->num_rows() > 0) {
			$row = $query->row_array();
			if ( $row['valid_gallery'] > 0) return true;
		}
	    return false;
	}
	
	/*
	 @param int user_id
	 @returns array of user image objects
	*/
	function get_images ($user_id)
	{
		$images = array();
		$query = $this->db->query('SELECT DISTINCT * FROM image WHERE user_id = ' . $user_id . ' GROUP BY file_name');
	    if ($query->num_rows() > 0) {
	    	foreach ($query->result_array() as $row) {
				$image = new Image($row);
				array_push ($images, $image);
			}
			return $images;
		}
	    return false;
	}
	
	function get_user_image ($user_id, $image_id) {

		$query = $this->db->query('SELECT * FROM `image` WHERE id = ' . $image_id . ' AND user_id = ' . $user_id);
		if ($query->num_rows() > 0) {
			$image = new Image($query->row_array());
			return $image;
		}
		return false;
	}
	
	function all_images($page = 1, $limit = 12) {

	    $offset = ($page - 1) * $limit;
	    $query = $this->db->query("SELECT * FROM image WHERE NOT EXISTS (SELECT avatar FROM user_profiles WHERE user_profiles.avatar = image.id) ORDER BY image.date_added  ASC LIMIT " . $offset . ", " . $limit);

	    if ($query->num_rows() > 0) {
			return $query->result_array();
		}
	    return false;
	}

	function get_image_data ($user_id, $image_id) {
		$query = $this->db->query('SELECT * FROM `image` WHERE id = ' . $image_id . ' AND user_id = ' . $user_id);
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
		return false;
	}	

	function add_image ($user_id, $file)
	{
		//add image to image table
		$data = array(
		   'user_id' => $user_id,
		   'title' => '',
		   'alt' => '',
		   'file_name' => $file,
		   'description' => '',
		   'date_added' => date('Y-m-d H:i:s')
		);
		$this->db->insert('image', $data);
		//foreign key for profile_image table
		$img_id = $this->db->insert_id();
		return $img_id;
	}

	function update_image ($user_id, $image_id, $data)
	{
        $this->db->where('user_id', (int) $user_id);
        $this->db->where('id', (int) $image_id);
        if ($this->db->update('image', $data))
        	return true;
        return false;
	}

	function delete_image ($user_id, $image_id)
	{
		$file_name = $this->get_image_file_name($user_id, $image_id);
		
		$this->db->delete('image', array('id' => $image_id, 'user_id' => $user_id));
		
		//if deleted image was current profile image, set avatar in profiles table to NULL
		$query = $this->db->query('SELECT avatar  FROM `user_profiles` WHERE `user_id` = ' . $user_id);
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			if ( $row['avatar'] == $image_id) {
				$this->db->where('user_id', $user_id);
				$this->db->update('user_profiles', array('avatar' => NULL ));
			}
		}
		
		//TODO: Handle warning messages
		//unlink the images
		try {
			unlink('./' . $this->config->item('large_path') . $file_name);
			unlink('./' . $this->config->item('image_path') . $file_name);
			unlink('./' . $this->config->item('thumb_path') . $file_name);
			return true;
		} catch(Exception $e) {
			return $e;
		}
		
		return false;
	}

	function valid_image($user_id, $image_id) {
		$query = $this->db->query('SELECT count(*) AS image_count FROM `image` WHERE `user_id` = ' . $user_id . ' AND `id` = ' . $image_id);
	    if ($query->num_rows() > 0) {
			$row = $query->row_array();
			if ( $row['image_count'] > 0) return true;
		}
	    return false;
	}
	
	/****** Profile Image methods ****************************************
	*************************************************************/

	function get_profile_image ($image_id)
	{
		$query = $this->db->query('SELECT * FROM image WHERE id = ' . $image_id);
		if($query->num_rows() > 0) {
			$row = $query->row_array();
			$image = new Profile_Image($row);
			return $image;
		}
		return false;
	}

	/*
	   profile images
	*/
    function get_all_profile_images ($user_id)
    {
    	$query = $this->db->query("SELECT `profile_image`.`image_id`, `image`.`file_name` FROM `profile_image`, `image` WHERE `profile_image`.`user_id` = " . $user_id . " AND `profile_image`.`image_id` = `image`.`id`");
	
		if (sizeof($query->result_array()) > 0)
		{
			$images = '';
			foreach ($query->result_array() as $row)
			{
				$images .= '<li><a href="' . site_url() . 'artists/' . $user_id . '/image/' . $row['image_id'] . '"><img class="thumbnail" src="' . site_url() . $this->config->item('thumb_path') . $row['file_name'] . '" alt=""></a></li>';
			}
			return $images;
	    }
	    return false;
    }
	
	/*
		Current logged in user sets his profile image to only his own images
	*/
	function set_profile_image ($user_id, $img_id)
	{
		//if image is the current users
		if($this->valid_image($user_id, $img_id)) {
			//update user_profiles set avatar to be $img_id where user_id = $user_id
			$this->db->where('user_id', $user_id);
			$this->db->update('user_profiles', array('avatar' => $img_id ));
			return true;			
		}
		return false;
	}

	function add_profile_image ($user_id, $file)
	{
		$img_id = $file['image_id'];
		$data = array(
		   'user_id' => $user_id,
		   'image_id' => $img_id
		);
		$this->db->insert('profile_image', $data);
		//update user_profiles set avatar
		$data = array(
		   'avatar' => $img_id
		);
		$this->db->where('user_id', $user_id);
		$this->db->update('user_profiles', $data);
		return true;
	}
	
	function get_image_file_name ($user_id, $image_id)
	{
		$query = $this->db->query('SELECT DISTINCT file_name FROM `image` WHERE id = ' . $image_id . ' AND user_id = ' . $user_id);
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['file_name'];
		}
		return false;
	}
	
	/****** events methods ****************************************
	
	
	*************************************************************/
	
	
	function latest_events ($limit = 5) {
	
	    $results = array();
	    $query = $this->db->query("SELECT * FROM events ORDER BY id DESC LIMIT " . $limit);
	    
	    return $query->result_array();
	}

	/****************************** Events section ******************************/
	/*
	A user can create an event and add groups or users to it as being the group/user holding the event
	An event has a address (location, related to an existing user or place address), a date and time, duration. Some events are recurrent
	Invitations can be sent to other users, and they can accept with yes, maybe, no
	reminders are sent to users who have said yes
	an event is open or closed
	
	*/
	
	function create_event ($data) 
	{
		if ($this->db->insert('event', $data))
			return true;
		return false;
	}

	function delete_event ($event_id, $user_id) 
	{
		if ($this->db->delete('event', array('id' => $event_id, 'user_id' => $user_id)))
			return true;
		return false;
	}
	
	function update_event ($user_id, $event_id, $data) 
	{
        $this->db->where('user_id', (int) $user_id);
        if ($this->db->update('event', $data))
        	return true;
        return false;
	}
	
	function get_event ($user_id, $event_id) 
	{
		$query = $this->db->query('SELECT * FROM `group` WHERE `id` = ' . $event_id . ' AND `user_id` = ' . $user_id);
	    if ($query->num_rows() > 0)
			return $query->row_array();
	    return false;
	}
	
	function get_events ($user_id) 
	{
		$events = array();
		$query = $this->db->query('SELECT * FROM events WHERE user_id = ' . $user_id);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$group = new Group($row);
				array_push ($groups, $group);
			}
			return $groups;
		}
		return false;
	}
	
	
	/****************************** Interests section ******************************/
	
	function get_user_interests ($user_id) {
		$query = $this->db->query('SELECT * FROM `user_interests` WHERE `user_id` = ' . $user_id);
	    if ($query->num_rows() > 0)
			return $query->row_array();
	    return false;
	}
	
	function get_full_user_interests ($user_id) {
		$query = $this->db->query('SELECT interests.id, interests.title, user_interests.user_id, user_interests.interest_type_id FROM interests LEFT JOIN user_interests ON interests.id = user_interests.interest_type_id AND user_interests.user_id = ' . $user_id);

	    if ($query->num_rows() > 0)
			return $query->result_array();
	    return false;
	}
	
	function add_user_interest ($user_id, $interest_id) {
		if ($this->db->insert('user_interests', array('user_id' => $user_id, 'interest_type_id' => $interest_id)))
			return true;
		return false;
	}
	
	function delete_user_interest ($user_id, $interest_id) {
		if ($this->db->delete('user_interests', array('user_id' => $user_id, 'interest_type_id' => $interest_id)))
			return true;
		return false;
	}
	
	/****************************** Message section ******************************/
	/*
	A user clicks send message to user. they fill in a text area and click send
	A user gets notified that a message has been sent
	the user can delete the message (also block this person?)
	the user can view the message thread which is organised by date sent
	Get all messages sent/recieved by user
	get all users that have sent a message
	get users that user_id has sent a message to that have not replied	
	*/
	
	function get_total_new_messages ($user_id) 
	{
		$query = $this->db->query('SELECT COUNT(*) AS new_messages FROM messages WHERE recipient_id = ' . $user_id . ' AND is_read = false');
		if($query->num_rows() > 0) {
			$row = $query->row();
			return $row->new_messages;
		}
		return false;
	}

	function get_all_messages ($user_id)
	{
		$query = $this->db->query('SELECT DISTINCT * FROM `messages` AS msg LEFT JOIN `user_profiles` ON msg.sender_id = `user_profiles`.user_id WHERE recipient_id = ' . $user_id . ' OR (sender_id = ' . $user_id . ' AND NOT EXISTS (SELECT recipient_id FROM `messages` WHERE recipient_id = ' . $user_id . ' AND sender_id = msg.recipient_id))  GROUP BY `sender_id`, `recipient_id` ORDER BY date');

		if($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}

	/*
		Get conversation messages that were sent between 2 users
	*/
	function get_messages_from_user ($sender_id, $user_id)
	{	
		$query = $this->db->query('SELECT * FROM messages LEFT JOIN `user_profiles` ON messages.sender_id = `user_profiles`.user_id WHERE (sender_id = ' . $user_id . ' AND recipient_id = ' . $sender_id . ') OR (sender_id = ' . $sender_id . ' AND recipient_id = ' . $user_id . ') ORDER BY date');

		if($query->num_rows() > 0) {
			return $query->result_array();
		}
		return false;
	}
	
	function send_message ($message, $sender_id, $recipient_id) 
	{
		$query = $this->db->query('INSERT INTO messages (message, date, sender_id, recipient_id, sender_is_group, recipient_is_group, is_read) VALUES ("' . $message . '", NOW(), ' . $sender_id . ', ' . $recipient_id . ', 0, 0, 0)');
		return $query;
	}
	
	function delete_message ($user_id, $message_id) 
	{
		
	}
	
	/************************************************************
	* Timeline methods 
	*
	*************************************************************/
	
	/*
	this should be updated each time any of the above methods are called
	*/
	function update_timeline () {
	    /*
	            id,
	            user_id
	            table,
	            updated record id,
	            date
	            description?
	            
	    */
	} 
}