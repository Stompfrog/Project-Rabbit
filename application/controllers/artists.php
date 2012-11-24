<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Artists extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();
	
	    $this->load->helper('pagination');
	    
	    $this->load->library('tank_auth');
	    $this->load->library('form_validation');
	    
	    $this->load->model('artists_model');
	    $this->load->model('tank_auth/profiles', 'profiles_model');
	    
	    include_once(APPPATH.'classes/Gallery.php');
	    include_once(APPPATH.'classes/Image.php');
	    include_once(APPPATH.'classes/User.php');
	}
	/*
	URLs:
		/artists/
		/artists/id||username
		/artists/id||username/images/
		/artists/id||username/image/id
		/artists/id||username/edit_image/id
		/artists/id||username/gallery/id
		/artists/id||username/edit_gallery/id
		/artists/id||username/messages
	*/
	function _remap($method)
	{
		switch($method)
		{
			case 'index':
				$this->index();
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) === 'images')):
				if (!is_numeric ($this->uri->segment(2)))
					$this->images($this->artists_model->get_user_id_from_username($this->uri->segment(2)));
				else
					$this->images($this->uri->segment(2));
				break;				
			case (($this->uri->segment(3) && ($this->uri->segment(3) === 'image')) && $this->uri->segment(4)):
				if (!is_numeric ($this->uri->segment(2)))
					$this->image($this->artists_model->get_user_id_from_username($this->uri->segment(2)), $this->uri->segment(4));
				else
					$this->image($this->uri->segment(2), $this->uri->segment(4));
				break;
			case (($this->uri->segment(3) && ($this->uri->segment(3) === 'edit_image')) && $this->uri->segment(4)):
				if (!is_numeric ($this->uri->segment(2)))
					$this->edit_image($this->artists_model->get_user_id_from_username($this->uri->segment(2)), $this->uri->segment(4));
				else
					$this->edit_image($this->uri->segment(2), $this->uri->segment(4));
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) === 'edit_gallery') && ($this->uri->segment(4))):
				if (!is_numeric ($this->uri->segment(2)))
					$this->edit_gallery($this->artists_model->get_user_id_from_username($this->uri->segment(2)), $this->uri->segment(4));
				else
					$this->edit_gallery($this->uri->segment(2), $this->uri->segment(4));
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) === 'gallery') && ($this->uri->segment(4))):
				if (!is_numeric ($this->uri->segment(2)))
					$this->gallery($this->artists_model->get_user_id_from_username($this->uri->segment(2)), $this->uri->segment(4));
				else
					$this->gallery($this->uri->segment(2), $this->uri->segment(4));
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) === 'messages')):
				if (!is_numeric ($this->uri->segment(2)))
					$this->messages($this->artists_model->get_user_id_from_username($this->uri->segment(2)));
				else
					$this->messages($this->uri->segment(2));
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) === 'message')):
				if (!is_numeric ($this->uri->segment(2)))
					$this->message($this->artists_model->get_user_id_from_username($this->uri->segment(2)));
				else
					$this->message($this->uri->segment(2));
				break;
			case (!is_numeric ($this->uri->segment(2))):
				$this->get_user($this->artists_model->get_user_id_from_username($this->uri->segment(2)));
				break;
			case (is_numeric ($this->uri->segment(2))):
				$this->get_user($this->uri->segment(2));
				break;
			default:
				$this->page_not_found();
				break;
		}
	}
	
	function index()
	{
	    //used for pagination, page, offset
	    $params = $this->input->get(NULL, TRUE);
	    
	    $url = site_url() . 'artists/';
	    $page = (isset($params['page'])) ? $params['page'] : 1;
	    $offset = (isset($params['offset'])) ? $params['offset'] : 5;
	    $pagination_config = array(
	            'url' => $url,
	            'total' => $this->artists_model->get_total_artists(),
	            'page' => $page,
	            'offset' => $offset
	    );
	    $data['pagination'] = pagination($pagination_config);
	    //this displays the results
	    $data['artists'] = $this->artists_model->latest_artists_paginated($page, $offset);
	    
	    //latest artists
	    $data['latest'] = $this->artists_model->latest_artists();
	    $this->load->view('templates/header');
	    $this->load->view('artists/index',$data);
	    $this->load->view('templates/footer');
	}
	
	function get_user($user_id)
	{
		if ($user_id === null) {
			show_404('page', 'log_error');
		}
	    $data['user'] = $this->artists_model->get_user($user_id);
	    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
	    $data['friends'] = $this->artists_model->get_friends($user_id);
	    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
	    
	    $data['galleries'] = $this->artists_model->get_galleries($user_id);
	    $data['images'] = $this->artists_model->get_images($user_id);
	    
	    //if user is logged in
	    if ($this->tank_auth->is_logged_in()) {
			$data['already_friends'] = $this->artists_model->already_friends($this->tank_auth->get_user_id(), $user_id);
			$data['friend_requested'] = $this->artists_model->friend_requested($this->tank_auth->get_user_id(), $user_id);
			$data['friend_requested_reverse'] = $this->artists_model->friend_requested($user_id, $this->tank_auth->get_user_id());
	    }
	    
	    $this->load->view('templates/header');
	    $this->load->view('artists/render',$data);
	    $this->load->view('templates/footer');
	}
	
	function gallery ($user_id, $gallery_id) 
	{
		$data = array();
		$gallery = false;
		
	    $data['user'] = $this->artists_model->get_user($user_id);
	    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
	    $data['friends'] = $this->artists_model->get_friends($user_id);
	    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		
		if (is_numeric ($gallery_id) && $this->artists_model->valid_gallery($gallery_id, $user_id) ) {
			$gallery = $gallery_id;
		}
		
		if ($gallery) {
			$data['gallery'] = $this->artists_model->get_gallery($user_id, $gallery);			
		} else {
			$data['error'] = 'Oops, there has been a problem';
		}

	    $this->load->view('templates/header');
	    $this->load->view('gallery/gallery',$data);
	    $this->load->view('templates/footer');
	}
	
	function edit_gallery ($user_id, $gallery_id) 
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$data = array();
			$data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);

			//if there is a parameter, and it is numeric, and it is a valid gallery
			if (is_numeric ($this->uri->segment(4)) && $this->artists_model->valid_gallery($user_id, $this->uri->segment(4)) ) {
				$gallery_id = $this->uri->segment(4);
				$table_values = $this->artists_model->get_gallery($user_id, $gallery_id);
				
				$data['table_values'] = $table_values;
				
				$this->form_validation->set_rules('title', 'title', 'trim|xss_clean');
				$this->form_validation->set_rules('description', 'description', 'trim|xss_clean');
	
				$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
				
				$this->load->view('/templates/header', $data);
				if ($this->form_validation->run() == FALSE)
				{
					$this->load->view('/gallery/edit_gallery', $data);
				}
				else
				{
					$data = array(
						'title' => $this->form_validation->set_value('title'),
						'description' => $this->form_validation->set_value('description'));
		
					if($this->artists_model->update_gallery($user_id, $gallery_id, $data))
					{
						$data['message'] = 'Gallery updated successfully!';
						$this->load->view('/gallery/edit_gallery', $data);
					} else {
						$data['message'] = 'Oops, there was a problem adding to the database.';
						$this->load->view('/gallery/edit_gallery', $data);
					}
				}
				$this->load->view('/templates/footer', $data);
			} else {
				$data['error_message'] = 'gallery does not exist';
				$this->load->view('/templates/header');
				$this->load->view('/templates/error', $data);
				$this->load->view('/templates/footer', $data);
			}
	    }
	}
	
	function images ($user_id)
	{
		$data = array();
		
	    $data['user'] = $this->artists_model->get_user($user_id);
	    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
	    $data['friends'] = $this->artists_model->get_friends($user_id);
	    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		
		$data['images'] = $this->artists_model->get_images($user_id);			

	    $this->load->view('templates/header');
	    $this->load->view('gallery/images',$data);
	    $this->load->view('templates/footer');
	}
	
	function image ($user_id, $image_id)
	{
		$data = array();
		
	    $data['user'] = $this->artists_model->get_user($user_id);
	    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
	    $data['friends'] = $this->artists_model->get_friends($user_id);
	    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		
		$data['image'] = $this->artists_model->get_user_image($user_id, $image_id);			

	    $this->load->view('templates/header');
	    $this->load->view('images/image',$data);
	    $this->load->view('templates/footer');
	}
	
	function add_image ($user_id)
	{
		$data = array();
		
	    $data['user'] = $this->artists_model->get_user($user_id);
	    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
	    $data['friends'] = $this->artists_model->get_friends($user_id);
	    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		
		$data['image'] = $this->artists_model->get_user_image($user_id, $image_id);			

	    $this->load->view('templates/header');
	    $this->load->view('images/image',$data);
	    $this->load->view('templates/footer');
	}
	
	function edit_image ($user_id, $image_id)
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$data = array();
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
			$data['image'] = $this->artists_model->get_user_image($user_id, $image_id);	
	    
			$user_id = $this->tank_auth->get_user_id();
			
			//if there is a parameter, and it is numeric, and it is a valid image
			if (is_numeric ($image_id) && $this->artists_model->valid_image($user_id, $image_id)) {
				//get image object
				$data['image'] = $this->artists_model->get_user_image($user_id, $image_id);
				//get image data
				$table_values = $this->artists_model->get_image_data($user_id, $image_id);
				
				$data['table_values'] = $table_values;
				
				$this->form_validation->set_rules('title', 'title', 'trim|xss_clean');
				$this->form_validation->set_rules('description', 'description', 'trim|xss_clean');
	
				$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
				
				$this->load->view('/templates/header', $data);
				if ($this->form_validation->run() == FALSE)
				{
					$this->load->view('/images/edit_image', $data);
				}
				else
				{
					$data = array(
						'title' => $this->form_validation->set_value('title'),
						'description' => $this->form_validation->set_value('description'));
		
					if($this->artists_model->update_image($user_id, $image_id, $data))
					{
						$data['message'] = 'Image updated successfully!';
					} else {
						$data['message'] = 'Oops, there was a problem adding to the database.';
					}
					$this->load->view('/images/edit_image', $data);
				}
				$this->load->view('/templates/footer', $data);
			} else {
				$data['error_message'] = 'Image does not exist';
				$this->load->view('/templates/header');
				$this->load->view('/templates/error', $data);
				$this->load->view('/templates/footer', $data);
			}
		}
	}

	function messages ($user_id) 
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
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
						$message['message_url'] .= '/artists/' . $message['recipient_id'] . '/message/';
						//change icon and name to that of recipient_id
						$message['message_url'] .= $message['recipient_id'];
						$other_user = $this->profiles_model->get_profile($message['recipient_id']);
						$message['avatar'] = $other_user['avatar'];
						$message['first_name'] = $other_user['first_name'];
						$message['last_name'] = $other_user['last_name'];
					} else {
						$message['message_url'] .= '/artists/' . $message['sender_id'] . '/message/';
						$message['message_url'] .= $message['sender_id'];
					}
					
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
	function message ($user_to_message_id) 
	{
		//get parameter that should have the sender user id
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
		
			$data = array();
			$data['messages'] = array();
			
			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);

			$messages = $this->artists_model->get_all_messages($user_id);
			
			$this->form_validation->set_rules('message', 'message', 'trim|required|xss_clean');

			//TODO: check if username is parameter
			if (is_numeric ($this->uri->segment(2))) {
				if ($this->form_validation->run() == TRUE)
					$this->artists_model->send_message ($this->form_validation->set_value('message'), $this->tank_auth->get_user_id(), $this->uri->segment(2));
				$data['message_form'] = $this->load->view('auth/message_form',  $data, true);
				$messages = $this->artists_model->get_messages_from_user($this->uri->segment(2), $this->tank_auth->get_user_id());
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

/* End of file artists.php */
/* Location: ./application/controllers/artists.php */