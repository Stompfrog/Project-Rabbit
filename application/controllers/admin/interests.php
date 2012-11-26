<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Interests extends CI_Controller
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
	
	/**
	 * 	Interests -  show list of interests, with links to edit/delete
	 *  
	 	This will be ideal when site is up and running, for now (13 August 2012) just have series of checkboxes:
	 	---------------------------------------------------------------------------------------------------------
	 	The user starts typing, and autosuggest pulls in data from the interests table.
	 	Once selected, a record is inserted into the user_interests table with the user_id and interest_id
	 	If no interest exists, a temporary one is created until authorised by admin
	 	---------------------------------------------------------------------------------------------------------
	 */
	function index ()
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
		    
			$dump = '';

			$interests = $this->artists_model->get_full_user_interests($this->tank_auth->get_user_id());
			
			if (!$this->input->post(NULL, TRUE))
			{
				if ($interests)
					$data['interests'] = $interests;
			}
			else
			{
				//put all post values into array for easy comparason
				$post = array();
				foreach ( $_POST as $key => $value )
				{
					$post[$key] = $this->input->post($key);
				}
				
				//for all interests that exist
				foreach ($interests as $interest) {
					//if the user has the interest already
					if (is_null($interest['interest_type_id']) && in_array($interest['id'], $post)) {
						//check if it exists in the $_POST
						//if it is there, continue. if it isnt, delete the record
						$this->artists_model->add_user_interest($this->tank_auth->get_user_id(), $interest['id']);
					} else if (!is_null($interest['interest_type_id']) && !in_array($interest['id'], $post)) {
						//if the user does not have the interest, check if it exists
						$this->artists_model->delete_user_interest($this->tank_auth->get_user_id(), $interest['id']);
					}
					//if it does, create new record in the user_interests table
				}
				//now get the updated records
				$interests = $this->artists_model->get_full_user_interests($this->tank_auth->get_user_id());
				$data['interests'] = $interests;
				
				//select exists (select interest_type_id from user_interests where user_id = 1)
			}

		    $this->load->view('templates/header');
		    $this->load->view('auth/interests_list',$data);
		    $this->load->view('templates/footer');
		    echo $dump;
		}
	}
	
}