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
			$user_id = $this->tank_auth->get_user_id();
			$data = array();
			$data['messages'] = array();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
			
			$user_id = $this->tank_auth->get_user_id();
			$messages = $this->artists_model->get_all_messages($user_id);
			
			if ($messages) {
				foreach ($messages as $message) {
					$message['message_url'] = site_url();	
					//we don't want to show the users icon or name, only the recipient or sender
					if ($message['sender_id'] == $user_id) {
						$message['message_url'] .= 'artists/' . $message['recipient_id'] . '/message/';
						$other_user = $this->profiles_model->get_profile($message['recipient_id']);
						$message['avatar'] = $other_user['avatar'];
						$message['first_name'] = $other_user['first_name'];
						$message['last_name'] = $other_user['last_name'];
					} else {
						$message['message_url'] .= 'artists/' . $message['sender_id'] . '/message/';
					}
					
					if ($message['avatar'] !== null) {
						$image = $this->artists_model->get_profile_image($message['avatar']);
						$message['profile_image'] = $image;
					}
					
					array_push($data['messages'], $message);
				}
			}		
	
		    $this->load->view('templates/header');
		    $this->load->view('messages/message_list',$data);
		    $this->load->view('templates/footer');
		}	
	}
}