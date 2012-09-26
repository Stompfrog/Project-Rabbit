<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller
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
		$this->load->model('upload_model');
		$this->load->model('tank_auth/profiles', 'profiles_model');
    
	}
	
	/**
	 * 	Groups -  show list of interests, with links to edit/delete
	 */
	function index ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$user_id = $this->tank_auth->get_user_id();
			$data = array();
			
		    $groups = $this->profiles_model->get_groups($user_id);
		    if ($groups)
				$data['groups'] = $groups;
				
		    $this->load->view('templates/header');
		    $this->load->view('auth/group_list',$data);
		    $this->load->view('templates/footer');
	    }
	}
	
	function create_group () {
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$user_id = $this->tank_auth->get_user_id();
			$data = array();

			$this->form_validation->set_rules('group_name', 'group_name', 'trim|xss_clean|required');
			$this->form_validation->set_rules('description', 'description', 'trim|xss_clean');

			$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
			
			$this->load->view('/templates/header', $data);
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('/auth/create_group', $data);
			}
			else
			{
				$data = array(
					'group_name' => $this->form_validation->set_value('group_name'),
					'description' => $this->form_validation->set_value('description'));
	
				if($this->profiles_model->create_group($user_id, $data))
				{
					$data['message'] = 'Group created successfully!';
					$this->load->view('/auth/create_group', $data);
				} else {
					$data['message'] = 'Oops, there was a problem adding to the database.';
					$this->load->view('/auth/create_group', $data);
				}
			}
			$this->load->view('/templates/footer', $data);	    
	    }
	}
}