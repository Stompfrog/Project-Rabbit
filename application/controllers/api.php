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
	
	function friends()
	{
	    $all_friends = $this->artists_model->get_friends($this->uri->segment(3));
	
	    $data['encoded_data'] = json_encode($all_friends);              
	    $this->load->view('api/json',$data);
	}
	
	function pendingfriends()
	{
	    $pending_friends = $this->artists_model->get_pending_friends($this->uri->segment(3));
	
	    $data['encoded_data'] = json_encode($pending_friends);          
	    $this->load->view('api/json',$data);
	}
	
	function addfriend()
	{
	    //just use the current users logged in id
	    $friend_request_message = $this->artists_model->add_friend($this->uri->segment(3), $this->uri->segment(4));
	
	    $data['encoded_data'] = json_encode($friend_request_message);           
	    $this->load->view('api/json',$data);
	}
	
	function confirmfriend()
	{
	    //just use the current users logged in id
	    $friend_request_message = $this->artists_model->confirm_friend($this->uri->segment(3), $this->uri->segment(4));
	
	    $data['encoded_data'] = json_encode($friend_request_message);           
	    $this->load->view('api/json',$data);
	}
	
	function unfriend()
	{
	    //just use the current users logged in id
	    $friend_request_message = $this->artists_model->unfriend($this->uri->segment(3), $this->uri->segment(4));
	
	    $data['encoded_data'] = json_encode($friend_request_message);           
	    $this->load->view('api/json',$data);
	}
	
	function already_friends () {
	    //just use the current users logged in id
	    $isfriend_message = $this->artists_model->already_friends($this->uri->segment(3), $this->uri->segment(4));
	
	    $data['encoded_data'] = json_encode($isfriend_message);         
	    $this->load->view('api/json',$data);
	    
	}
	//artists with a particular interest
	
	//get artists friends
	
	//
	    
}