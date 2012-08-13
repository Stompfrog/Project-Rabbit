<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();
	
	    $this->load->library('tank_auth');
	    $this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');

		$this->lang->load('tank_auth');

	    $this->load->model('artists_model');
		$this->load->model('tank_auth/profiles', 'profiles_model');
    
	}
	
	/**
	 * 	Messages -  show list of conversations, with links to edit/delete
	 *  
	 */
	function index ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$data['messages'] = array();
			$user_id = $this->tank_auth->get_user_id();
			$messages = $this->profiles_model->get_all_messages($user_id);
			if ($messages) {
				foreach ($messages as $message) {
					if ($message['sender_id'] == $user_id)
						array_push($data['messages'], '<div class="sender"><a href="' . base_url() . 'index.php/messages/message/' . $message['recipient_id'] . '">' . $message['message'] . '</a></div>');
					else
						array_push($data['messages'], '<div class="receiver"><a href="' . base_url() . 'index.php/messages/message/' . $message['sender_id'] . '">' . $message['message'] . '</a></div>');
				}
			}

		    $this->load->view('templates/header');
		    $this->load->view('auth/message_list',$data);
		    $this->load->view('templates/footer');
		}
	}
	
	/*
	Takes the username or user id as a parameter for the message
	*/
	function message () 
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			
		}
	}
	
}