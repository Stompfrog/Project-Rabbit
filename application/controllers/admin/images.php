<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Images extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();

	    $this->load->helper('pagination');
	    
	    $this->load->library('tank_auth');
	    $this->load->library('pagination');
	    $this->load->library('form_validation');
		$this->load->library('security');
		    
	    $this->load->model('artists_model');
	    $this->load->model('upload_model');
		$this->lang->load('tank_auth');
		
	    include_once(APPPATH.'classes/User.php');
	    include_once(APPPATH.'classes/Gallery.php');
	    include_once(APPPATH.'classes/Image.php');
	}
	
	function index()
	{   
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$data = array();
			
			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
			
			$images = $this->artists_model->get_images($this->tank_auth->get_user_id());
			if ($images)	{
				$data['images'] = $images;
			}
		    $this->load->view('templates/header');
		    $this->load->view('images/image_list',$data);
		    $this->load->view('templates/footer');
		}
	}
	
	function image ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			//get 
			$data = array();
			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
			
			$image_id = false;
			
			if (is_numeric ($this->uri->segment(4)) && $this->artists_model->valid_image($user_id, $this->uri->segment(4))) {
				$image_id = $this->uri->segment(4);
			}
			
			if ($image_id) {
				$data['image'] = $this->artists_model->get_user_image($user_id, $image_id);			
			} else {
				$data['error'] = 'Oops, there has been a problem';
			}

		    $this->load->view('templates/header');
		    $this->load->view('images/image',$data);
		    $this->load->view('templates/footer');
		}
	}
	
	/**
	 * Add, delete, update profile images
	 *
	 * @return void
	 */	
	
	function add_image ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$data = array();
			
			if ($this->input->post('upload')) {
				$data = $this->upload_model->img_upload();
			}
			
			$user_id = $this->tank_auth->get_user_id();

		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		    
			$this->load->view('/templates/header', $data);
			$this->load->view('/images/add_image', $data);
			$this->load->view('/templates/footer', $data);
		}
	}
	
	/*I think this is redundant*/
	function add_profile_image ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$data = array();
			if ($this->input->post('upload')) {
				$data = $this->upload_model->profile_img_upload();
			}
			
			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
	
			$this->load->view('/templates/header', $data);
			$this->load->view('/images/add_image', $data);
			$this->load->view('/templates/footer', $data);
		}
	}

	//profile images, automatically add any profile images to profile image table
	function profile_images() 
	{
		//if posted
		if ($this->tank_auth->is_logged_in()) {
			$data = array();
			
			if ($this->input->post('upload')) {
				$data = $this->upload_model->profile_img_upload();
			}
			
			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
			
			$data['profile_images'] = $this->artists_model->get_all_profile_images($this->tank_auth->get_user_id());
			
			$images = $this->artists_model->get_images($this->tank_auth->get_user_id());
			if ($images) {
				$data['images'] = $images;
			}

			$this->load->view('/templates/header', $data);
			$this->load->view('/images/profile_image', $data);
			$this->load->view('/templates/footer', $data);
		} else {
			redirect('/auth/login/');
		}
	}
	
	/**
	 * 	 Delete image
	 */

	function delete_image ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			if (is_numeric ($this->uri->segment(4))) {
				$this->artists_model->delete_image ($this->tank_auth->get_user_id(), (intval($this->uri->segment(4))));
			}
			redirect('/admin/images/');
		}
	}

	/**
	 * 	 Edit image
	 */

	function edit_image ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {

			$data = array();

			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		    
			$image_id = false;
			
			if (is_numeric ($this->uri->segment(4)) && $this->artists_model->valid_image($user_id, $this->uri->segment(4))) {
				$image_id = $this->uri->segment(4);
			}
			
			if ($image_id) {
				$data['images'] = $this->artists_model->get_user_image($user_id, $image_id);			
			} else {
				$data['error'] = 'Oops, there has been a problem';
			}
			
			if ($this->input->post('upload')) {
				
			}

		    $this->load->view('templates/header');
		    $this->load->view('images/edit_image',$data);
		    $this->load->view('templates/footer');
		}
	}

}