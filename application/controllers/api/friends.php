<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends CI_Controller
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

	function _remap($method)
	{
		switch($method)
		{
			case 'index':
				$this->index();
				break;
			case 'pending':
				$this->pending();
				break;
			case 'add':
					$this->add();
				break;
			case 'confirm':
					$this->confirm($this->uri->segment(4));
				break;
			case 'unfriend':
					$this->unfriend();
				break;
			case 'already_friends':
				$this->already_friends();
				break;
			case 'already_requested':
				$this->already_requested();
				break;
			default:
				show_404();
				break;
		}
	}
	
	function index()
	{
	    $all_friends = $this->artists_model->get_friends($this->tank_auth->get_user_id());
	    $data['encoded_data'] = json_encode($all_friends);              
	    $this->load->view('api/json',$data);
	}

	function pending()
	{
		if ($this->tank_auth->is_logged_in()) {
		    $pending_friends = $this->artists_model->get_pending_friends($this->tank_auth->get_user_id());
		    $data['encoded_data'] = json_encode($pending_friends);
		} else {
			$data['encoded_data'] = json_encode(false);           
		}
		$this->load->view('api/json',$data);
	}

	function add()
	{
		if ($this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $this->uri->segment(4)) {
			$friend_request_message = $this->artists_model->add_friend($this->tank_auth->get_user_id(), $this->uri->segment(5));
			$data['encoded_data'] = json_encode($friend_request_message);
		} else {
			$data['encoded_data'] = json_encode(false);
		}
		$this->load->view('api/json',$data);
	}
	
	function confirm()
	{
		if ($this->tank_auth->is_logged_in() && $this->tank_auth->get_user_id() == $this->uri->segment(4)) {
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
			$friend_request_message = $this->artists_model->unfriend($this->tank_auth->get_user_id(), $this->uri->segment(5));
			$data['encoded_data'] = json_encode($friend_request_message);
		} else {
			$data['encoded_data'] = json_encode(false);           
		}
		$this->load->view('api/json',$data);
	}
	
	function already_friends () {
	    $isfriend_message = $this->artists_model->already_friends($this->uri->segment(4), $this->uri->segment(5));
	    $data['encoded_data'] = json_encode($isfriend_message);         
	    $this->load->view('api/json',$data);
	}
	
	function already_requested () {
	    $isfriend_message = $this->artists_model->friend_requested($this->uri->segment(4), $this->uri->segment(5));
	    $data['encoded_data'] = json_encode($isfriend_message);         
	    $this->load->view('api/json',$data);
	}
}