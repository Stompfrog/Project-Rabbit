<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Up extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();
	
	    $this->load->helper(array('form', 'url'));
	    $this->load->model('artists_model');
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('tank_auth/profiles', 'profiles_model');
		$this->load->model('upload_model'); 
	}
	
	function index () 
	{
	
	}

	/*
		ideally want multiple upload, can do it with js and set input as array form_upload('userfile[]') in the view
	*/
	function profile_image() 
	{
		//if posted
		if ($this->tank_auth->is_logged_in()) {
			$data = array();
			if ($this->input->post('upload')) {
				$data = $this->upload_model->profile_img_upload();
			}
			
			$this->load->view('profile_image', $data);
			
		} else {
			redirect('/auth/login/');
		}
	}
	
}

/* End of file up.php */
/* Location: ./application/controllers/up.php */