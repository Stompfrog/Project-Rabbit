<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tests extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();
	    
	    $this->load->library('tank_auth');
	    $this->load->library('unit_test');
	    
	    $this->load->model('artists_model');
	    $this->load->model('tank_auth/profiles', 'profiles_model');

	    include_once(APPPATH.'classes/Gallery.php');
	    include_once(APPPATH.'classes/Image.php');
	    include_once(APPPATH.'classes/User.php');
	}
	
	function index () {

		//set new format for test result display
		$str = '
		<table border="0" cellpadding="4" cellspacing="1">
		    {rows}
		        <tr>
		        <td>{item}</td>
		        <td>{result}</td>
		        </tr>
		    {/rows}
		</table>';
		
		//set the above
		$this->unit->set_template($str);
		
		echo '<h1>Artists/User section</h1>';
		echo '<h2>Get user/user data</h2>';
	
		/*
			@function: get_user
			@params: (int) user_id
			@returns: User object
		*/
		//pass in Mark's user id
		$test = $this->artists_model->get_user(1);
		$test_name = "get_user with valid id, using Mark's i";
		echo $this->unit->run($test, 'is_object', $test_name);

		//try invalid characther
		/*
		$test = $this->artists_model->get_user('r');
		$test_name = 'get_user with invalid char';
		echo $this->unit->run($test, 'is_false', $test_name);
		*/
		/*
			@function: get_user_id_from_username
			@params: (str) user_name
			@returns: int or false
		*/
		echo '<h2>Get user_id/username</h2>';
		//get user id from user_name
		$test = $this->artists_model->get_user_id_from_username('roppa_uk');
		$test_name = 'get_user_id_from_username with "roppa_uk"';
		echo $this->unit->run($test, 1, $test_name, $test);

		//pass random string
		$test = $this->artists_model->get_user_id_from_username('randomstring');
		$test_name = 'get_user_id_from_username with "roppa_uk"';
		echo $this->unit->run($test, 'is_bool', $test_name);

		/*
			@function: get_user_data
			@params: (int) user_id
			@returns: array
		*/
		echo '<h2>Get user data</h2>';
		//pass in Mark's id
		$test = $this->artists_model->get_user_data(1);
		$test_name = 'get_user_data with valid id';
		echo $this->unit->run($test, 'is_array', $test_name);

		//try invalid characther
		$test = $this->artists_model->get_user_data('asdf');
		$test_name = 'get_user_data with invalid valid characters';
		echo $this->unit->run($test, 'is_bool', $test_name);

		/*
			@function: all_artists
			@params: (array) (optional) - not implimented at the moment????
			@returns: array
		*/
		echo '<h2>Get all artists</h2>';
		$test = $this->artists_model->all_artists();
		$test_name = 'all_artists';
		echo $this->unit->run($test, 'is_array', $test_name);
		
		/*
			@function: all_artists_interests
			@params: (array) (optional) interests id
			@returns: array
		*/
		echo '<h2>Get artist based on interests</h2>';
		$test = $this->artists_model->all_artists_interests();
		$test_name = 'all_artists_interests';
		echo $this->unit->run($test, 'is_array', $test_name);
		
		$test = $this->artists_model->all_artists_interests(array(1, 3, 4));
		$test_name = 'all_artists_interests with params array of (1, 3, 4)';
		echo $this->unit->run($test, 'is_array', $test_name);

		$test = $this->artists_model->all_artists_interests(array(1, 99, 4));
		$test_name = 'all_artists_interests with params array of (1, 99, 4), 99 being invalid';
		echo $this->unit->run($test, 'is_array', $test_name);
		
		//TODO: 
		/*
		$test = $this->artists_model->all_artists_interests(array(1, 3, 'sdf'));
		$test_name = 'all_artists_interests with invalid value in parameter ';
		echo $this->unit->run($test, 'is_array', $test_name);
		*/
		
		/*
			@function: latest_artists
			@params: (int) (optional) number of users
			@returns: array
		*/
		echo '<h2>Get latest artists</h2>';
		$test = $this->artists_model->latest_artists();
		$test_name = 'latest_artists';
		echo $this->unit->run($test, 'is_array', $test_name);
		
		/*
			@function: latest_artists_paginated
			@params: (int), (int) (both optional)
			@returns: array
		*/
		$test = $this->artists_model->latest_artists_paginated();
		$test_name = 'latest_artists_paginated';
		echo $this->unit->run($test, 'is_array', $test_name);
		
		/*
			@function: get_total_artists
			@params: 
			@returns: int
		*/
		echo '<h2>Total artists</h2>';
		$test = $this->artists_model->get_total_artists();
		$test_name = 'get_total_artists';
		echo $this->unit->run($test, 'is_int', $test_name);
		
		echo '<h2>Interests section</h2>';
		/*
			@function: get_interests
			@params: (int) user_id
			@returns: array
		*/
		//using Mark's id
		$test = $this->artists_model->get_interests(1);
		$test_name = 'get_interests using valid id';
		echo $this->unit->run($test, 'is_array', $test_name);

		//using invalid id
		$test = $this->artists_model->get_interests('asd');
		$test_name = 'get_interests using incorrect character';
		echo $this->unit->run($test, 'is_bool', $test_name);
			
		/*
			@function: get_all_interests
			@params: 
			@returns: array
		*/
		$test = $this->artists_model->get_all_interests();
		$test_name = 'get_all_interests';
		echo $this->unit->run($test, 'is_array', $test_name);
		
		echo '<h2>Friends section</h2>';
		
		/*
			@function: add_friend
			@params: (int) logged in user_id, (int) friend_id
			@returns: string
		*/
		$test = $this->artists_model->add_friend(1, 1);
		$test_name = 'add_friend';
		echo $this->unit->run($test, 'is_string', $test_name, $test);
	
		/*
			@function: confirm_friend
			@params: (int) logged in user_id, (int) friend_id
			@returns: string "you cannot befriend yourself"
		*/
		$test = $this->artists_model->confirm_friend(1, 1);
		$test_name = 'confirm_friend';
		echo $this->unit->run($test, 'is_string', $test_name, $test);
		
		/*
			@function: unfriend
			@params: (int) logged in user_id, (int) friend_id
			@returns: string
		*/
		$test = $this->artists_model->unfriend(1, 1);
		$test_name = 'unfriend';
		echo $this->unit->run($test, 'is_string', $test_name, $test);
			
		/*
			@function: get_friends
			@params: (int) user_id, (int) (optional)
			@returns: array
		*/
		$test = $this->artists_model->get_friends(1);
		$test_name = "get_friends using Mark's id (1)";
		echo $this->unit->run($test, 'is_array', $test_name);

		$test = $this->artists_model->get_friends(99);
		$test_name = "get_friends using invalid id (99)";
		echo $this->unit->run($test, 'is_array', $test_name);
		
		/*
			@function: get_friends_paginated
			@params: (int) user_id, (int) (optional), (int) (optional)
			@returns: array
		*/
		$test = $this->artists_model->get_friends_paginated(1);
		$test_name = "get_friends_paginated using Mark's id (1)";
		echo $this->unit->run($test, 'is_array', $test_name);

		$test = $this->artists_model->get_friends_paginated(99);
		$test_name = "get_friends_paginated using invalid id (99)";
		echo $this->unit->run($test, 'is_array', $test_name);
		
		/*
			@function: get_pending_friends
			@params: (int) user_id,
			@returns: array
		*/
		$test = $this->artists_model->get_pending_friends(1);
		$test_name = "get_pending_friends using Mark's id (1)";
		echo $this->unit->run($test, 'is_array', $test_name);
		
		$test = $this->artists_model->get_pending_friends(99);
		$test_name = "get_pending_friends using invalid id (99)";
		echo $this->unit->run($test, 'is_array', $test_name);
		
		/*
			@function: already_friends
			@params: (int) user_id, (int) (optional), (int) (optional)
			@returns: boolean
		*/
		$test = $this->artists_model->already_friends(1, 1);
		$test_name = 'already_friends';
		echo $this->unit->run($test, false, $test_name, $test);
		
		/*
			@function: friend_invite
			@params: (int) logged in user_id, (int) friend_id
			@returns: boolean
		*/
		$test = $this->artists_model->friend_invite(1, 1);
		$test_name = 'friend_invite';
		echo $this->unit->run($test, false, $test_name, $test);
		
		/*
			@function: friend_requested
			@params: (int) logged in user_id, (int) friend_id
			@returns: boolean
		*/
		$test = $this->artists_model->friend_requested(1, 1);
		$test_name = 'friend_requested';
		echo $this->unit->run($test, false, $test_name, $test);
		
		/*
			@function: get_total_friends
			@params: (int) user_id
			@returns: int or false if some sort of db error
		*/
		$test = $this->artists_model->get_total_friends(1);
		$test_name = "get_total_friends using Mark's id (1)";
		echo $this->unit->run($test, 'is_int', $test_name);
		
		$test = $this->artists_model->get_total_friends(99);
		$test_name = "get_total_friends using invalid id (99)";
		echo $this->unit->run($test, 'is_int', $test_name);
		
		echo '<h2>Addresses section</h2>';
		/*
			@function: get_addresses
			@params: (int) user_id
			@returns: array of address objects
		*/
		$test = $this->artists_model->get_addresses(1);
		$test_name = "get_addresses using Mark's id (1)";
		echo $this->unit->run($test, 'is_array', $test_name);
		
		$test = $this->artists_model->get_addresses(99);
		$test_name = "get_addresses using invalid id (99)";
		echo $this->unit->run($test, 'is_bool', $test_name);
		
		/*
			@function: get_address
			@params: (int) user_id, (int) (optional) address_id
		 	@returns: array or false
		*/
		$test = $this->artists_model->get_address(1);
		$test_name = "get_address using Mark's id (1) and no optional param";
		echo $this->unit->run($test, 'is_array', $test_name);
		
		$test = $this->artists_model->get_address(1, 5);
		$test_name = "get_address using Mark's id (1) and valid optional param (5)";
		echo $this->unit->run($test, 'is_array', $test_name);

		$test = $this->artists_model->get_address(1, 99);
		$test_name = "get_address using Mark's id (1) and invalid optional param (99)";
		echo $this->unit->run($test, 'is_bool', $test_name);

		$test = $this->artists_model->get_address(99);
		$test_name = "get_address using invalid user_id (99) and no optional param";
		echo $this->unit->run($test, 'is_bool', $test_name);

		$test = $this->artists_model->get_address(1, 99);
		$test_name = "get_address using invalid user_id (99) and invalid optional param (99)";
		echo $this->unit->run($test, 'is_bool', $test_name);
		
		/*
			@function: add_address
			@params: (array) address_data
			@returns: boolean
		*/
		/*	
			@function: valid_address
			@params: (int) user_id, (int) address_id
			@returns: boolean
		*/
		$test = $this->artists_model->valid_address(1, 5);
		$test_name = "valid_address using Mark's id (1) and valid optional param (5)";
		echo $this->unit->run($test, true, $test_name);

		$test = $this->artists_model->valid_address(1, 99);
		$test_name = "valid_address using Mark's id (1) and invalid optional param (99)";
		echo $this->unit->run($test, false, $test_name);
	
		/*	
			@function: update_address
			@params: (int) user_id, (int) address_id, (array) data
			@returns: boolean
		*/
		$test = $this->artists_model->update_address(1, 99, array("", ""));
		$test_name = "update_address using Mark's id (1) and invalid address_id (99), and empty data array";
		echo $this->unit->run($test, false, $test_name);
		
		/*	
			@function: delete_address
			@params: (int) user_id, (int) address_id 
			@returns: boolean
		*/
		$test = $this->artists_model->delete_address(1, 99);
		$test_name = "delete_address using Mark's id (1) and invalid address_id (99)";
		echo $this->unit->run($test, false, $test_name);
		
		echo '<h2>Places section</h2>';
		/*
			@function: popular_places
			@params: (int) (optional) limit
			@returns: array
		*/
		$test = $this->artists_model->popular_places();
		$test_name = "popular_places using no optional param";
		echo $this->unit->run($test, 'is_array', $test_name);
		
		/*	
			@function: get_geo_addresses
			@params: (int) distance, (long) lat, (long) lng
			@returns: array
		*/
		
		echo '<h2>Group section</h2>';
		/*	
			@function: create_group
			@params: (array) data
			@returns: boolean
		*/
		
		/*	
			@function: update_group
			@params: (int) user_id, (int) group_id, (arra) data
			@returns: boolean
		*/
		$test = $this->artists_model->update_group(1, 99, array());
		$test_name = "update_group using Mark's valid user_id, an invalid group_id, and an empty array";
		echo $this->unit->run($test, false, $test_name);
		
		/*	
			@function: delete_group
			@params: (int) user_id, (int) group_id
			@returns: boolean
		*/
		$test = $this->artists_model->delete_group(1, 99);
		$test_name = "delete_group using Mark's valid user_id, an invalid group_id";
		echo $this->unit->run($test, false, $test_name);
		
		/*	
			@function: get_group_members
			@params: (int) group_id
			@returns: array or false
		*/
		$test = $this->artists_model->get_group_members(17);
		$test_name = "get_group_members with valid group_id of 17";
		echo $this->unit->run($test, 'is_array', $test_name, $test);

		$test = $this->artists_model->get_group_members(99);
		$test_name = "get_group_members with invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);
	
		/*
			@function: user_is_group_admin
			@params: (int) user_id, (int) group_id
			@returns: boolean
		*/
		$test = $this->artists_model->user_is_group_admin(1, 17);
		$test_name = "user_is_group_admin with valid user_id of 1 and valid group_id of 17";
		echo $this->unit->run($test, true, $test_name);
		
		$test = $this->artists_model->user_is_group_admin(1, 99);
		$test_name = "user_is_group_admin with valid user_id of 1 and invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);

		$test = $this->artists_model->user_is_group_admin(99, 17);
		$test_name = "user_is_group_admin with invalid user_id of 1 and valid group_id of 17";
		echo $this->unit->run($test, false, $test_name);
				
		$test = $this->artists_model->user_is_group_admin(99, 99);
		$test_name = "user_is_group_admin with invalid user_id of 99 and invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);
		
		/*
			@function: user_is_group_creator
			@params: (int) user_id, (int) group_id
			@returns: boolean
		*/
		$test = $this->artists_model->user_is_group_creator(1, 17);
		$test_name = "user_is_group_creator with valid user_id of 1 and valid group_id of 17";
		echo $this->unit->run($test, true, $test_name);

		$test = $this->artists_model->user_is_group_creator(1, 99);
		$test_name = "user_is_group_creator with valid user_id of 1 and invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);
		
		$test = $this->artists_model->user_is_group_creator(99, 17);
		$test_name = "user_is_group_creator with invalid user_id of 99 and invalid group_id of 17";
		echo $this->unit->run($test, false, $test_name);
		
		$test = $this->artists_model->user_is_group_creator(99, 99);
		$test_name = "user_is_group_creator with invalid user_id of 99 and invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);	
		
		/*	
			@function: user_is_group_member
			@params: (int) user_id, (int) group_id
			@returns: boolean
		*/
		$test = $this->artists_model->user_is_group_member(1, 17);
		$test_name = "user_is_group_member with valid user_id of 1 and valid group_id of 17";
		echo $this->unit->run($test, true, $test_name);

		$test = $this->artists_model->user_is_group_member(1, 99);
		$test_name = "user_is_group_member with valid user_id of 1 and invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);
		
		$test = $this->artists_model->user_is_group_member(99, 17);
		$test_name = "user_is_group_member with invalid user_id of 99 and invalid group_id of 17";
		echo $this->unit->run($test, false, $test_name);
		
		$test = $this->artists_model->user_is_group_member(99, 99);
		$test_name = "user_is_group_member with invalid user_id of 99 and invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);
		
		/*	
			@function: user_group_invited
			@params: (int) user_id, (int) group_id
			@returns: boolean
		*/
		$test = $this->artists_model->user_group_invited(1, 17);
		$test_name = "user_group_invited with valid user_id of 1 and valid group_id of 17, but user has not been invited";
		echo $this->unit->run($test, false, $test_name);

		$test = $this->artists_model->user_group_invited(99, 17);
		$test_name = "user_group_invited with invalid user_id of 1 and valid group_id of 17";
		echo $this->unit->run($test, false, $test_name);

		$test = $this->artists_model->user_group_invited(99, 99);
		$test_name = "user_group_invited with invalid user_id of 1 and invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);

		/*	
			@function: valid_user_group
			@params: (int) user_id, (int) group_id
			@returns: boolean
		*/
		$test = $this->artists_model->valid_user_group(1, 17);
		$test_name = "valid_user_group with valid user_id of 1 and valid group_id of 17";
		echo $this->unit->run($test, true, $test_name);

		$test = $this->artists_model->valid_user_group(1, 99);
		$test_name = "valid_user_group with valid user_id of 1 and invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);
		
		$test = $this->artists_model->valid_user_group(99, 99);
		$test_name = "valid_user_group with invalid user_id of 99 and invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);
			
		/*	
			@function: valid_group
			@params: (int) group_id
			@returns: boolean
		*/
		$test = $this->artists_model->valid_group(17);
		$test_name = "valid_group with valid group_id of 17";
		echo $this->unit->run($test, true, $test_name);

		$test = $this->artists_model->valid_group(99);
		$test_name = "valid_group with invalid group_id of 99";
		echo $this->unit->run($test, false, $test_name);
			
		/*	
			@function: group_user_request
			@params: (int) user_id, (int) group_id
			@returns: boolean or (array) error
		*/
		$test = $this->artists_model->group_user_request(1, 17);
		$test_name = "group_user_request with valid user_id of 1 and valid group_id of 17, but user is already a member";
		echo $this->unit->run($test, 'is_array', $test_name, $test);
	
		$test = $this->artists_model->group_user_request(4, 17);
		$test_name = "group_user_request with valid user_id of 4 and valid group_id of 17, and user is not a member";
		echo $this->unit->run($test, true, $test_name);
		
		$test = $this->artists_model->group_user_request(4, 99);
		$test_name = "group_user_request with valid user_id of 4 and invalid group_id of 99";
		echo $this->unit->run($test, 'is_array', $test_name, $test);

		$test = $this->artists_model->group_user_request(99, 99);
		$test_name = "group_user_request with invialid user_id of 99 and invalid group_id of 99";
		echo $this->unit->run($test, 'is_array', $test_name, $test);
		
		/*	
			@function: get_all_groups
			@params: (int) (optional) page, (int) (optional) offset
			@returns: array
		*/
		$test = $this->artists_model->get_all_groups();
		$test_name = "get_all_groups";
		echo $this->unit->run($test, 'is_array', $test_name);
		
		/*	
			@function: total_groups
			@params: 
			@returns: int
		*/
		$test = $this->artists_model->total_groups();
		$test_name = "total_groups";
		echo $this->unit->run($test, 'is_int', $test_name, $test);
		
		/*	
			@function: latest_groups
			@params: (int) (optional) limit
			@returns: result object?
		*/
		/*	
			@function: get_groups
			@params: (int) user_id
			@returns: array or false?
		*/
		/*	
			@function: get_group
			@params: (int) group_id
			@returns: (object) Group
		*/
		/*	
			@function: get_group_json
			@params: (int) group_id
			@returns: json
		*/
		/*	
			@function: get_user_group
			@params: (int) user_id, (int) group_id
			@returns: array
		*/
		/*	
			@function: join_group
			@params: (int) user_id, (int) group_id
			@returns: boolean
		*/
		$test = $this->artists_model->join_group(1, 99);
		$test_name = "join_group using Mark's valid user_id, and invalid group_id (99)";
		echo $this->unit->run($test, 'is_string', $test_name, $test);
		
		/*	
			@function: leave_group
			@params: (int) user_id, (int) group_id
			@returns: string or boolean
		*/
		$test = $this->artists_model->leave_group(1, 99);
		$test_name = "leave_group using Mark's valid user_id, and invalid group_id (99)";
		echo $this->unit->run($test, 'is_string', $test_name, $test);
		
		/*	
			@function: get_group_requests
			@params: (int) group_id
			@returns: array
		*/
		/*	
			@function: invite_user_to_group
			@params: (int) inviter_id (current logged in user), (int) user_id, (int) group_id
			@returns: boolean
		*/
		$test = $this->artists_model->invite_user_to_group(1, 99, 99);
		$test_name = "invite_user_to_group using Mark's valid user_id, an invalud user_id (99), and invalid group_id (99)";
		echo $this->unit->run($test, 'is_array', $test_name, print_r($test));
		
		/*	
			@function: decline_group_invite
			@params: (int) user_id, (int) group_id
			@returns: boolean or string
		*/
		$test = $this->artists_model->decline_group_invite(1, 99);
		$test_name = "decline_group_invite using Mark's valid user_id, and invalid group_id (99)";
		echo $this->unit->run($test, 'is_string', $test_name, $test);
		
		/*	
			@function: deny_user_group_entry
			@params: (int) admin_id (logged in user_id), (int) user_id, (int) group_id
			@returns: boolean or string
		*/
		$test = $this->artists_model->deny_user_group_entry(1, 1, 99);
		$test_name = "deny_user_group_entry using Mark's valid admin_id, the same valid user_id, and invalid group_id (99)";
		echo $this->unit->run($test, 'is_string', $test_name, $test);
		
		/*	
			@function: accept_group_invitation
			@params: (int) group_id
			@returns: true or error string
		*/
		$test = $this->artists_model->accept_group_invitation(1, 99);
		$test_name = "accept_group_invitation using Mark's valid user_id, and invalid user_id (99)";
		echo $this->unit->run($test, 'is_string', $test_name, $test);
		
		/*	
			@function: accept_user_into_group
			@params: (int) admin_id (current logged in user), (int) user_id, (int) group_id
			@returns: boolean or string
		*/
		$test = $this->artists_model->accept_user_into_group(1, 99, 99);
		$test_name = "accept_user_into_group using Mark's valid user_id, and invalid user_id (99), and invalid group_id (99)";
		echo $this->unit->run($test, 'is_string', $test_name, $test);
		
		/*	
			@function: remove_user_from_group
			@params: (int) user_id, (int) group_id
			@returns: boolean or string
		*/
		$test = $this->artists_model->remove_user_from_group(1, 99, 99);
		$test_name = "remove_user_from_group using Mark's valid user_id, and invalid user_id (99), and invalid group_id (99)";
		echo $this->unit->run($test, 'is_string', $test_name, $test);
		
		/*	
			@function: reassign_group
			@params: (int) user_id, (int) group_id
			@returns: boolean
		*/
		/*	
			@function: get_galleries
			@params: (int) user_id
			@returns: array of Gallery objects, or false
		*/
		/*	
			@function: get_gallery
			@params: (int) user_id, (int) gallery_id
			@returns: array or false
		*/
		/*	
			@function: add_gallery
			@params: (array) data
			@returns: boolean
		*/
		/*	
			@function: update_gallery
			@params: (int) user_id, (int) gallery_id, (array) data
			@returns: boolean
		*/
		/*	
			@function: delete_gallery
			@params: (int) user_id, (int) gallery_id
			@returns: array of Image objects
		*/
		/*	
			@function: get_gallery_images
			@params: (int) user_id, (int) gallery_id
			@returns: array of image objects
		*/
		/*	
			@function: valid_gallery
			@params: (int) user_id, (int) gallery_id
			@returns: boolean
		*/
		/*	
			@function: get_images
			@params: (int) user_id
			@returns: array of image objects or boolean
		*/
		/*	
			@function: get_user_image
			@params: (int) user_id, (int) image_id
			@returns: Image object or boolean
		*/
		/*	
			@function: all_images
			@params: (int) (optional) page, (int) (optional) limit
			@returns: array or false
		*/
		/*	
			@function: get_image_data
			@params: (int) user_id, (int) image_id
			@returns: array or boolean
		*/
		/*	
			@function: add_image
			@params: (int) user_id, (file) file
			@returns: (int) image_id
		*/
		/*	
			@function: update_image
			@params: (int) user_id, (int) image_id, (array) data
			@returns: boolean
		*/
		/*	
			@function: delete_image
			@params: (int) user_id, (int) image_id
			@returns: true or exception
		*/
		$test = $this->artists_model->delete_image(1, 99);
		$test_name = "delete_image using Mark's valid user_id, and invalid image_id (99))";
		echo $this->unit->run($test, false, $test_name, $test);
		
		/*	
			@function: valid_image
			@params: (int) user_id, (int) image_id
			@returns: boolean
		*/
		/*	
			@function: get_profile_image
			@params: (int) image_id
			@returns: image object or false
		*/
		/*	
			@function: get_all_profile_images
			@params: (int) user_id
			@returns: formatted html string - must refactor
		*/
		/*	
			@function: set_profile_image
			@params: (int) user_id, (int) image_id
			@returns: boolean
		*/
		$test = $this->artists_model->set_profile_image(1, 99);
		$test_name = "set_profile_image using Mark's valid user_id, and invalid image_id (99))";
		echo $this->unit->run($test, false, $test_name, $test);
		
		/*	
			@function: add_profile_image
			@params: (int) user_id, (file) file
			@returns: boolean - at moment no checks are made!!!
		*/
		/*	
			@function: get_image_file_name
			@params: (int) user_id, (int) image_id
			@returns: string or boolean
		*/
		/*	
			@function: latest_events
			@params: (int) (optional) limit
			@returns: array
		*/
		/*	
			//Events
		*/
		/*	
			@function: create_event
			@params: 
			@returns: 
		*/
		/*	
			@function: delete_event
			@params: 
			@returns: 
		*/
		/*	
			@function: update_event
			@params: 
			@returns: 
		*/
		/*	
			@function: get_event
			@params: 
			@returns: 	
		*/
		/*	
			@function: get_events
			@params: 
			@returns: 
		*/
		/*		
			//interests section
		*/
		/*
			@function: get_user_interests
			@params: (int) user_id
			@returns: array or false
		*/
		/*	
			@function: get_full_user_interests
			@params: (int) user_id
			@returns: array or boolean
		*/
		/*	
			@function: add_user_interest
			@params: (int) user_id, (int) interest_id
			@returns: boolean
		*/
		/*	
			@function: delete_user_interest
			@params: (int) user_id, (int) interest_id
			@returns: boolean
		*/
		/*	
			//message section
		*/
		/*	
			@function: get_total_new_messages
			@params: (int) user_id
			@returns: int or false
		*/
		/*	
			@function: get_all_messages
			@params: (int) user_id
			@returns: array or false
		*/
		/*	
			@function: get_messages_from_user
			@params: (int) sender_id, (int) user_id
			@returns: array or false
		*/
		/*	
			@function: send_message
			@params: (string) message, (int) sender_id, (int) recipient_id
			@returns: boolean
		*/
		/*
			@function: delete_message
			@params: 
			@returns: 
			
		*/	
		

		
	}
}