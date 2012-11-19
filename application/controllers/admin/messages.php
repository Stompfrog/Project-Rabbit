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
		
    	include_once(APPPATH.'classes/Profile_Image.php');
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
			$messages = $this->artists_model->get_all_messages($user_id);
			
			if ($messages) {
				foreach ($messages as $message) {
					$message['message_url'] = site_url() . '/admin/messages/message/';	
					//we don't want to show the users icon or name, only the recipient or sender
					if ($message['sender_id'] == $user_id) {
						//change icon and name to that of recipient_id
						$message['message_url'] .= $message['recipient_id'];
						$other_user = $this->profiles_model->get_profile($message['recipient_id']);
						$message['avatar'] = $other_user['avatar'];
						$message['first_name'] = $other_user['first_name'];
						$message['last_name'] = $other_user['last_name'];
					} else
						$message['message_url'] .= $message['sender_id'];
					
					if ($message['avatar'] !== null) {
						$image = $this->artists_model->get_profile_image($message['avatar']);
						$message['profile_image'] = $image;
					}
					
					array_push($data['messages'], $message);
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
		//get parameter that should have the sender user id
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$data['messages'] = array();
			$user_id = $this->tank_auth->get_user_id();
			
			$this->form_validation->set_rules('message', 'message', 'trim|required|xss_clean');

			//TODO: check if username is parameter
			if (is_numeric ($this->uri->segment(4))) {
				if ($this->form_validation->run() == TRUE)
					$this->artists_model->send_message ($this->form_validation->set_value('message'), $this->tank_auth->get_user_id(), $this->uri->segment(4));
				$data['message_form'] = $this->load->view('auth/message_form',  $data, true);
				$messages = $this->artists_model->get_messages_from_user($this->uri->segment(4), $this->tank_auth->get_user_id());
				if ($messages) {
					foreach ($messages as $message) {
						if ($message['avatar']) {
							$image = $this->artists_model->get_profile_image($message['avatar']);
							$message['profile_image'] = $image;
						}
						
						array_push($data['messages'], $message);
					}
				}
			}

		    $this->load->view('templates/header');
		    $this->load->view('auth/message_conversation',$data);
		    $this->load->view('templates/footer');	
 		}
	}
	
}