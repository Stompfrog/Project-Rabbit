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
			
		    $groups = $this->artists_model->get_groups($user_id);
		    if ($groups)
				$data['groups'] = $groups;
				
		    $this->load->view('templates/header');
		    $this->load->view('auth/group_list',$data);
		    $this->load->view('templates/footer');
	    }
	}
	
	function render ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$user_id = $this->tank_auth->get_user_id();
			$data = array();
			
			if (is_numeric ($this->uri->segment(4)) && $this->artists_model->valid_user_group($this->uri->segment(4), $user_id) ) {
			    $group_id = $this->uri->segment(4);
			    $group = $this->artists_model->get_group($group_id);
			    if ($group)
					$data['group'] = new Group($group);
					
			    $this->load->view('templates/header');
			    $this->load->view('groups/render', $data);
			    $this->load->view('templates/footer');			
			} else {
				redirect('/auth/groups/');
			}
	    }
	}
	
	//should just be called this
	function create () {
		$this->create_group();
	}
	
	function create_group () {
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$user_id = $this->tank_auth->get_user_id();
			$data = array();

			$this->form_validation->set_rules('group_name', 'group_name', 'trim|xss_clean|required');
			$this->form_validation->set_rules('description', 'description', 'trim|xss_clean|required');

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
	
				if($this->artists_model->create_group($user_id, $data))
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
	
	function edit_group () {
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$user_id = $this->tank_auth->get_user_id();
			//if there is a parameter, and it is numeric, and it is a valid address
			if (is_numeric ($this->uri->segment(4)) && $this->artists_model->valid_user_group($this->uri->segment(4), $user_id) ) {
				$group_id = $this->uri->segment(4);
				$data = array();
				$table_values = $this->artists_model->get_user_group($user_id, $group_id);
				
				$data['table_values'] = $table_values;
				
				$this->form_validation->set_rules('group_name', 'group_name', 'trim|xss_clean|required');
				$this->form_validation->set_rules('description', 'description', 'trim|xss_clean|required');
	
				$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
				
				$this->load->view('/templates/header', $data);
				if ($this->form_validation->run() == FALSE)
				{
					$this->load->view('/auth/edit_group', $data);
				}
				else
				{
					$data = array(
						'group_name' => $this->form_validation->set_value('group_name'),
						'description' => $this->form_validation->set_value('description'));
		
					if($this->artists_model->update_group($user_id, $group_id, $data))
					{
						$data['message'] = 'Group updated successfully!';
						$this->load->view('/auth/edit_group', $data);
					} else {
						$data['message'] = 'Oops, there was a problem adding to the database.';
						$this->load->view('/auth/edit_group', $data);
					}
				}
				$this->load->view('/templates/footer', $data);
			} else {
				$data['error_message'] = 'group does not exist';
				$this->load->view('/templates/header');
				$this->load->view('/templates/error', $data);
				$this->load->view('/templates/footer', $data);
			}
	    }
	}
	
	function delete () {

		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			if (!is_numeric ($this->uri->segment(4)))
				redirect('/admin/groups/');
			$user_id = $this->tank_auth->get_user_id();
			$group_id = $this->uri->segment(4);
			//user must be creator to delete group.
			//Other users must be updated that the group has been deleted			
			if (($this->artists_model->valid_user_group($group_id, $user_id)) && ($this->artists_model->user_is_group_creator($user_id, $group_id)) ) {
				$this->artists_model->delete_group ($group_id, $user_id);
			}
			
			//if an administrator is not the creator of the group but deletes,
			//the creator is notified and ok's it.
			
			redirect('/admin/groups/');
		}
	}
	
	function change_group_owner() {
		//if an administrator is not the creator of the group but deletes,
		//the creator is notified and ok's it.
	}
}