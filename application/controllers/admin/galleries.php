<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Galleries extends CI_Controller
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
			
			$galleries = $this->artists_model->get_galleries($this->tank_auth->get_user_id());
			if ($galleries)	{
				$data['galleries'] = $galleries;
			}
		    $this->load->view('templates/header');
		    $this->load->view('gallery/gallery_list',$data);
		    $this->load->view('templates/footer');
		}
	}
	
	function gallery ($message = null)
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			//get 
			$data = array();
			
			$user_id = $this->tank_auth->get_user_id();
			
			$gallery_id = false;
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
			
			if (is_numeric ($this->uri->segment(4)) && $this->artists_model->valid_gallery($user_id, $this->uri->segment(4)) ) {
				$gallery_id = $this->uri->segment(4);
			}
			
			if ($gallery_id) {
				$data['gallery'] = $this->artists_model->get_gallery($user_id, $gallery_id);			
			} else {
				$data['error'] = 'Oops, there has been a problem';
			}

		    $this->load->view('templates/header');
		    $this->load->view('gallery/gallery',$data);
		    $this->load->view('templates/footer');
		}
	}
	
	function add_gallery ()
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
			
			$this->form_validation->set_rules('title', 'title', 'trim|xss_clean|required');
			$this->form_validation->set_rules('description', 'description', 'trim|xss_clean');

			$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
			
			$this->load->view('/templates/header', $data);
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('/gallery/add_gallery', $data);
			}
			else
			{
				$data = array(
					'title' => $this->form_validation->set_value('title'),
					'description' => $this->form_validation->set_value('description'),
					'user_id' => $this->tank_auth->get_user_id());
	
				if($this->artists_model->add_gallery($data))
				{
					$data['message'] = 'Gallery added successfully!';
					$this->load->view('/gallery/add_gallery', $data);
				} else {
					$data['message'] = 'Oops, there was a problem adding to the database.';
					$this->load->view('/gallery/add_gallery', $data);
				}
			}
			$this->load->view('/templates/footer', $data);
		}
	}
	
	/**
	 * 	 Delete gallery
	 	 images in this gallery will go into a default gallery?
	 */

	function delete_gallery ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			if (is_numeric ($this->uri->segment(4))) {
				$this->artists_model->delete_gallery ($this->tank_auth->get_user_id(), $this->uri->segment(4));
			}
			redirect('/admin/galleries/');
		}
	}
	
}