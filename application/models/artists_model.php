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
        include_once(APPPATH.'classes/Address.php');
    }
    
    /****** Artist/user section *********************************
        
    
    *************************************************************/
    
	/*
	    Parameters: user_id (will probably change it to be either username or id, username can refer to url /artists/roppa
	    Returns: User object
	*/
	function get_user($user_id)
	{
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
			    return $row['id'];
			}
	    } else {
	    	return $user_name;
	    }
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
	
	function latest_artists($limit = 5)
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
			array_push($results, $row);
	    }
	    
	    return $results;
	}
	
	function get_total_artists () {
	    
	    $query = $this->db->query("SELECT COUNT(id) AS total_artitsts FROM users where activated = 1");
	
	    if ($query->num_rows() > 0)
	    {
	       $row = $query->row();
	       return $row->total_artitsts;
	    }
	    
	    return false;
	}
	
	function get_interests($user_id)
	{
	    $interests = array();
	    $interests_query = $this->db->query("SELECT interests.title AS 'title' 
                                            FROM interests, user_interests 
                                            WHERE interests.id = user_interests.role_type_id 
                                            AND user_interests.user_id = " . (int) $user_id);
	
	    foreach ($interests_query->result_array() as $row)
	    {
	    	array_push($interests, $row['title']);
	    }
	    
	    return $interests;
	}
	
	/******* Friends section *********************************
	
	    DB Table structure
	    ------------------------------------------------------
	    u1_id           #user id of person requesting
	    u2_id           #user id of friend who was requested
	    status          #varchar: 'requested', 'ignored', 'friend'
	    befriended      #date u2_id accepted
	    ------------------------------------------------------
	    
	*************************************************************/
	
	function add_friend ($u1_id, $u2_id)
	{               
	    //find out if both users exist
	    $u1_id_query = $this->db->query('SELECT COUNT(id) AS id FROM users where id = ' . $u1_id);
	    $u2_id_query = $this->db->query('SELECT COUNT(id) AS id FROM users where id = ' . $u2_id);
	    
	    $u1 = $u1_id_query->row();
	    $u2 = $u2_id_query->row();
	    
	    if($u1->id == 1 && $u2->id == 1)
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
	function confirm_friend ($user_id, $friend_id)
	{
	    if($this->already_friends($user_id, $friend_id)) return 'you are already friends';
	    if(! $this->friend_requested($friend_id, $user_id)) return 'friendship was not requested from that user';
	
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
	function already_friends ($u1_id, $u2_id) {
	
	    $query = $this->db->query("SELECT COUNT(id) AS is_friend FROM friends where u1_id = " . $u1_id . " AND u2_id = " . $u2_id . " AND `friends`.`status` = 'friend'");
	
	    if ($query->num_rows() > 0)
	    {
	       $row = $query->row();
	       if($row->is_friend == 1) return true;
	    }

	    return false;
	}
	
	/*
	    Establish if a friendship as been requested
	    $u1_id = person who initiates the request
	    $u2_id = person who has been asked to be a friend
	*/
	function friend_requested ($u1_id, $u2_id) {
	
	    $query = $this->db->query("SELECT COUNT(id) AS friend_requested FROM friends where u1_id = " . $u1_id . " AND u2_id = " . $u2_id . " AND `friends`.`status` = 'requested'");
	
	    if ($query->num_rows() > 0)
	    {
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
	       return $row->total_friends;
	    }
	    
	    return false;
	}
	
	/****** Address section ***************************************
	
	//Create address
	
	//get address
	
	//add address
	
	//update address
	
	*************************************************************/

	function get_address ($user_id, $address_id = null) {
		$and = '';
		if ($address_id)
			$and = ' AND `id` = ' . $address_id;
		$query = $this->db->query('SELECT * FROM `address` WHERE `user_id` = ' . $user_id . $and);
	    if ($query->num_rows() > 0)
	    {
			return $query->row_array();
	    }
	    return false;
	}
	
	function get_addresses ($user_id) {
		$addresses = array();
		if ($address_id)
		$query = $this->db->query('SELECT * FROM `address` WHERE `user_id` = ' . $user_id);
	    if ($query->num_rows() > 0)
	    {
			foreach ($query->row_array() as $row) {
				array_push($addresses, $row);
			}
			return $addresses;
	    }
	    return false;
	}
	
	function add_address ($user_id) {
		//add image to image table
/*
		$data = array(
		   'user_id' => $user_id,
		   'title' => '',
		   'alt' => '',
		   'file_name' => $file,
		   'description' => ''
		);
		$this->db->insert('image', $data);
		//foreign key for profile_image table
		$img_id = $this->db->insert_id();
*/
	}
	
	function valid_address ($address_id, $user_id) {
	
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
	
	/****** Geolocational section ********************************
	
	
	*************************************************************/
	
	
	
	
	/****** Groups section ***************************************
	
	//Create group
	
	*************************************************************/
	
	
	
	
	
	/****** Image methods ****************************************
	
	
	*************************************************************/
	
	function get_profile_image ()
	{
		
	}
	
	/*
	    get all profile images
	*/
    function get_all_profile_images ($user_id)
    {
    	$query = $this->db->query("SELECT `profile_image`.`image_id`, `image`.`file_name` FROM `profile_image`, `image` WHERE `profile_image`.`user_id` = " . $user_id . " AND `profile_image`.`image_id` = `image`.`id`");
	
		if (sizeof($query->result_array()) > 0)
		{
			$images = '';
			foreach ($query->result_array() as $row)
			{
				$images .= '<li><a href="#"><img class="thumbnail" src="' . base_url() . $this->config->item('profile_thumb_path') . $row['file_name'] . '" alt=""></a></li>';
			}
			return $images;
	    }
	    return false;
    }
	
	function set_profile_image ($user_id, $img_id)
	{
		//update user_profiles set avatar to be $img_id where user_id = $user_id
	}
	
	function add_profile_image ($user_id, $file)
	{
		//add image to image table
		$data = array(
		   'user_id' => $user_id,
		   'title' => '',
		   'alt' => '',
		   'file_name' => $file,
		   'description' => ''
		);
		$this->db->insert('image', $data);
		//foreign key for profile_image table
		$img_id = $this->db->insert_id();

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
	}
	
	function delete_profile_image ()
	{
		//
	}
	
	/****** Timeline methods ****************************************
	
	
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