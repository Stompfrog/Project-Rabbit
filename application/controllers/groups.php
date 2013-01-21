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
	}

	function _remap($method)
	{
		switch($method)
		{
			case 'index':
				$this->index();
				break;
			case 'create':
				$this->create();
				break;
			case 'edit_group':
				if(is_numeric ($this->uri->segment(3)) && $this->artists_model->valid_user_group($this->tank_auth->get_user_id(), $this->uri->segment(3))) {
					$this->edit_group($this->uri->segment(3));
				} else {
					show_404();
				}
				break;
			case 'reassign':
				if(is_numeric ($this->uri->segment(3)) && $this->artists_model->valid_user_group($this->tank_auth->get_user_id(), $this->uri->segment(3))) {
					$this->reassign($this->uri->segment(3));
				} else {
					show_404();
				}
				break;
			case 'delete':
				if (is_numeric ($this->uri->segment(3)) && $this->artists_model->valid_user_group($this->tank_auth->get_user_id(), $this->uri->segment(3))) {
					$this->delete($this->uri->segment(3));
				} else {
					show_404();
				}
				break;
			case ($this->uri->segment(2) === 'group'):
				if (is_numeric ($this->uri->segment(3)) && $this->artists_model->valid_group($this->uri->segment(3))) {
					$this->group($this->uri->segment(3));
				} else {
					show_404();
				}
				break;
			default:
				show_404();
				break;
		}
	}

	/**
	 * 	Groups -  show list of interests, with links to edit/delete
	 */
	function index ()
	{	
		//public view
		$data = array();
		
		if ($this->tank_auth->is_logged_in()) { // not logged in or not activated
			$user_id = $this->tank_auth->get_user_id();
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		}
		
		//used for pagination, page, offset
	    $params = $this->input->get(NULL, TRUE);
	    $url = site_url() . 'groups/';
	    $page = (isset($params['page'])) ? $params['page'] : 1;
	    $offset = (isset($params['offset'])) ? $params['offset'] : 2;
	    
	    $pagination_config = array(
	            'url' => $url,
	            'total' => $this->artists_model->total_groups(),
	            'page' => $page,
	            'offset' => $offset
	    );
	    
	    $data['pagination'] = pagination($pagination_config);
	    
		$this->load->view('templates/header');

	    $groups = $this->artists_model->get_all_groups($page, $offset);
	    if ($groups) {
			$data['groups'] = $groups;
		}
		
		$this->load->view('groups/index', $data);
		$this->load->view('templates/footer');
		
		/*
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated	
		} else {

	    }
	    */
	}
	
	function group ($group_id = false)
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			$this->load->view('templates/header');
			
			$data = array();
		    $data['group'] = $this->artists_model->get_group($group_id);
				
		    $this->load->view('templates/header');
		    $this->load->view('groups/group', $data);
		    $this->load->view('templates/footer');
		} else {
		
			$data = array();

			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		    
			//if ($this->artists_model->valid_user_group($user_id, $group_id) ) { }
			
		    $group = $this->artists_model->get_group($group_id);
		    if ($group)
				$data['group'] = $group;
				
		    $this->load->view('templates/header');
		    $this->load->view('auth/group', $data);
		    $this->load->view('templates/footer');					

	    }
	}
	
	function create () {
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {

			$data = array();

			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);

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
	
	function edit_group ($group_id = false) {
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {

			$data = array();
	
			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);

			if ($group_id) {

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

	function reassign ($group_id = false) {
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {

			$data = array();
	
			$user_id = $this->tank_auth->get_user_id();
			
		    $data['user'] = $this->artists_model->get_user($user_id);
		    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
		    $data['friends'] = $this->artists_model->get_friends($user_id);
		    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);

			//get a list of group members and above
			$data['members'] = $this->artists_model->get_group_members($group_id);
			$data['group'] = $this->artists_model->get_group($group_id);

			$this->load->view('/templates/header');
			$this->load->view('/auth/group_reassign', $data);
			$this->load->view('/templates/footer', $data);
	    }
	}

	
	function delete ($group_id) {

		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$user_id = $this->tank_auth->get_user_id();
			//user must be creator to delete group.
			//Other users must be updated that the group has been deleted			
			if (($this->artists_model->valid_user_group($user_id, $group_id)) && ($this->artists_model->user_is_group_creator($user_id, $group_id)) ) {
				$this->artists_model->delete_group ($user_id, $group_id);
			}
			
			//if an administrator is not the creator of the group but deletes,
			//the creator is notified and ok's it.
			
			redirect('/artists/' . $user_id . '/groups/');
		}
	}
	
	function change_group_owner() {
		//if an administrator is not the creator of the group but deletes,
		//the creator is notified and ok's it.
	}
}