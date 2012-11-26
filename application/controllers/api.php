<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();
	
	    $this->load->helper('url');
	    $this->load->library('tank_auth');
	    $this->load->model('artists_model');
	    
	    include_once(APPPATH.'classes/Image.php');
	    include_once(APPPATH.'classes/User.php');
	}
	
	function index()
	{
	    $this->load->view('templates/header');
	    $this->load->view('api/index');
	    $this->load->view('templates/footer');
	}

	/*
	* Artists section
	*/

	function artist()
	{
		$artist = $this->artists_model->get_user_data($this->uri->segment(3));
		$data['encoded_data'] = json_encode($artist);
		$this->load->view('api/json',$data);
	}
	
	function artists()
	{
	    $latest = $this->artists_model->latest_artists($this->uri->segment(3));
	    $data['encoded_data'] = json_encode($latest);           
	    $this->load->view('api/json',$data);
	}

	function gettotalartists () {
	    $total = $this->artists_model->get_total_artists();
	    $data['encoded_data'] = json_encode($total);            
	    $this->load->view('api/json',$data);
	}

	function allartists()
	{
	    $all_artists = $this->artists_model->all_artists();
	    $data['encoded_data'] = json_encode($all_artists);              
	    $this->load->view('api/json',$data);
	    
	}
	
	function all_artists_interests()
	{
		//get any get parameters
	    $params = $this->input->get('interests');
	    $all_artists = $this->artists_model->all_artists_interests((is_array($params)) ? $params : null);
	    $data['encoded_data'] = json_encode($all_artists);
	    $this->load->view('api/json',$data);    
	}
	
	function get_artists()
	{
		//$lat, $lng)
	}
	
	/*
	* Friends section
	*/

	function friends()
	{
	    $all_friends = $this->artists_model->get_friends($this->uri->segment(3));
	    $data['encoded_data'] = json_encode($all_friends);              
	    $this->load->view('api/json',$data);
	}

	function pendingfriends()
	{
		if ($this->tank_auth->is_logged_in()) {
		    $pending_friends = $this->artists_model->get_pending_friends($this->tank_auth->get_user_id());
		    $data['encoded_data'] = json_encode($pending_friends);
		} else {
			$data['encoded_data'] = json_encode(false);           
		}
		$this->load->view('api/json',$data);
	}

	function addfriend()
	{
		if ($this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $this->uri->segment(3)) {
			$friend_request_message = $this->artists_model->add_friend($this->tank_auth->get_user_id(), $this->uri->segment(4));
			$data['encoded_data'] = json_encode($friend_request_message);
		} else {
			$data['encoded_data'] = json_encode(false);
		}
		$this->load->view('api/json',$data);
	}
	
	function confirmfriend()
	{
		if ($this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $this->uri->segment(3)) {
		    $friend_request_message = $this->artists_model->confirm_friend($this->tank_auth->get_user_id(), $this->uri->segment(4));
		    $data['encoded_data'] = json_encode($friend_request_message);
		} else {
			$data['encoded_data'] = json_encode(false);           
		}
		$this->load->view('api/json',$data);
	}
	
	function unfriend()
	{
		if ($this->tank_auth->is_logged_in()) {
			$friend_request_message = $this->artists_model->unfriend($this->tank_auth->get_user_id(), $this->uri->segment(4));
			$data['encoded_data'] = json_encode($friend_request_message);
		} else {
			$data['encoded_data'] = json_encode(false);           
		}
		$this->load->view('api/json',$data);
	}
	
	function already_friends () {
	    $isfriend_message = $this->artists_model->already_friends($this->uri->segment(3), $this->uri->segment(4));
	    $data['encoded_data'] = json_encode($isfriend_message);         
	    $this->load->view('api/json',$data);
	}
	
	function already_requested () {
	    $isfriend_message = $this->artists_model->friend_requested($this->uri->segment(3), $this->uri->segment(4));
	    $data['encoded_data'] = json_encode($isfriend_message);         
	    $this->load->view('api/json',$data);
	}

	/*
	* Messages
	*/

	/*
	* Addresses
	*/
	//get addresses by passing in coordinates
	function get_addresses()
	{
	    $addresses = $this->artists_model->get_geo_addresses($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
	    $data['encoded_data'] = json_encode($addresses);         
	    $this->load->view('api/json',$data);
	}	
	
	//get a specific address
	function get_address ()
	{
	
	}
	//get users address/es
	function get_user_addresses ()
	{
	
	}


	/*
	* Groups
	*/

	/*
	* Venues
	*/

	/*
	* Events
	*/
	
	/*
	* Interests
	*/
	    
}