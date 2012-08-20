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
		$query = $this->db->query('SELECT * FROM `gallery` WHERE `id` = ' . $gallery_id . ' AND `user_id` = ' . $user_id);
	    if ($query->num_rows() > 0)
			return $query->row_array();
	    return false;
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

	/****************************** Groups section ******************************/
	
	function create_group ($data) 
	{
		if ($this->db->insert('group', $data))
			return true;
		return false;
	}

	function delete_group ($group_id, $user_id) 
	{
		//if user is 
		if ($this->db->delete('group', array('id' => $group_id, 'user_id' => $user_id)))
			return true;
		return false;
	}
	
	function update_group ($user_id, $group_id, $data) {
        $this->db->where('user_id', (int) $user_id);
        if ($this->db->update('group', $data))
        	return true;
        return false;
	}
	
	function get_group ($group_id) {
		$query = $this->db->query('SELECT * FROM `group` WHERE `id` = ' . $group_id);
	    if ($query->num_rows() > 0)
			return $query->row_array();
	    return false;
	}
	
	function get_groups ($user_id) {
		$groups = array();
		$query = $this->db->query('SELECT * FROM group WHERE user_id = ' . $user_id);
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$group = new Group($row);
				array_push ($groups, $group);
			}
			return $groups;
		}
			
		return false;
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
		/*
			//join user profiles. need to join on the sender/recipient
			SELECT DISTINCT * FROM `messages` AS msg LEFT JOIN `user_profiles` ON msg.sender_id = `user_profiles`.user_id WHERE recipient_id = 1 OR (sender_id = 1 AND NOT EXISTS (SELECT recipient_id FROM `messages` WHERE recipient_id = 1 AND sender_id = msg.recipient_id))  GROUP BY `sender_id`, `recipient_id` ORDER BY date
			
			//this is without avatar
			'SELECT DISTINCT * FROM `messages` AS msg WHERE recipient_id = ' . $user_id . ' OR (sender_id = ' . $user_id . ' AND NOT EXISTS (SELECT recipient_id FROM `messages` WHERE recipient_id = ' . $user_id . ' AND sender_id = msg.recipient_id)) GROUP BY `sender_id`, `recipient_id` ORDER BY date'
		*/
		
		/*
		SELECT DISTINCT * FROM `messages` AS msg 
		LEFT JOIN `user_profiles` ON msg.sender_id = `user_profiles`.user_id
		WHERE recipient_id = 2 
		OR (sender_id = 1 AND NOT EXISTS (SELECT recipient_id FROM `messages` WHERE recipient_id = 2 AND sender_id = msg.recipient_id))  
		GROUP BY `sender_id`, `recipient_id` 
		ORDER BY date
		
		SELECT DISTINCT * FROM `messages` AS msg, `user_profiles`
		WHERE msg.sender_id = `user_profiles`.user_id
		AND recipient_id = 2 
		OR (sender_id = 1 AND NOT EXISTS (SELECT recipient_id FROM `messages` WHERE recipient_id = 2 AND sender_id = msg.recipient_id))  
		GROUP BY `sender_id`, `recipient_id` 
		ORDER BY date
		*/

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

}

/* End of file profiles.php */
/* Location: ./application/models/auth/profiles.php */