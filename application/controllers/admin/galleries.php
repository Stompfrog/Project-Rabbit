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
	    $this->load->model('tank_auth/profiles', 'profiles_model');

		$this->lang->load('tank_auth');
		
	    include_once(APPPATH.'classes/User.php');
	    include_once(APPPATH.'classes/Gallery.php');
	    include_once(APPPATH.'classes/Image.php');
	}
	
	function index()
	{   
		$data = array();
		$galleries = $this->profiles_model->get_galleries($this->tank_auth->get_user_id());
		if ($galleries)	$data['galleries'] = $galleries;
	    $this->load->view('templates/header');
	    $this->load->view('auth/gallery_list',$data);
	    $this->load->view('templates/footer');
	}
	
	function gallery ()
	{
		echo '<h1>TODO: show images in gallery, add/edit/delete images</h1>';
	}
	
	function add_gallery ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
		
			$data = array();
			
			$this->form_validation->set_rules('name', 'name', 'trim|xss_clean|required');
			$this->form_validation->set_rules('description', 'description', 'trim|xss_clean');

			$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
			
			$this->load->view('/templates/header', $data);
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('/auth/add_gallery', $data);
			}
			else
			{
				$data = array(
					'name' => $this->form_validation->set_value('name'),
					'description' => $this->form_validation->set_value('description'),
					'user_id' => $this->tank_auth->get_user_id());
	
				if($this->profiles_model->add_gallery($data))
				{
					$data['message'] = 'Gallery added successfully!';
					$this->load->view('/auth/add_gallery', $data);
				} else {
					$data['message'] = 'Oops, there was a problem adding to the database.';
					$this->load->view('/auth/add_gallery', $data);
				}
			}
			$this->load->view('/templates/footer', $data);
		}
	}
}