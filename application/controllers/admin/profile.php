<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller
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

	    include_once(APPPATH.'classes/Image.php');
	    include_once(APPPATH.'classes/User.php');
	}
	
	/**
	 * Add, delete, update profile information
	 *
	 * @return void
	 */
	function index ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			
			$data = array();
			
			$user_id = $this->tank_auth->get_user_id();
			$table_values = $this->profiles_model->get_profile($user_id);
			
			$data['table_values'] = $table_values;

			$this->form_validation->set_rules('first_name', 'first_name', 'trim|required|xss_clean');
			$this->form_validation->set_rules('about_me', 'about_me', 'trim|required|xss_clean');			
			$this->form_validation->set_rules('sex', 'sex', 'trim|xss_clean');
			$this->form_validation->set_rules('website', 'website', 'trim|xss_clean');
			$this->form_validation->set_rules('last_name', 'last_name', 'trim|xss_clean');
			$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
		
			$this->load->view('/templates/header', $data);
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('/auth/update_profile', $data);
			}
			else
			{	
				$updated_values = array(	
					'first_name' => $this->form_validation->set_value('first_name'),		
					'last_name' => $this->form_validation->set_value('last_name'),
					'about_me' => $this->form_validation->set_value('about_me'),
					'sex' => $this->form_validation->set_value('sex'),
					'website' => $this->form_validation->set_value('website'));

				if($this->profiles_model->update_profile($user_id, $updated_values))
				{
					$data['message'] = 'Your details were updated successfully!';
					$this->load->view('/auth/update_profile', $data);
				} else {
					$data['message'] = 'Oops, there was a problem updating the database.';
					$this->load->view('/auth/update_profile', $data);
				}
			}
			$this->load->view('/templates/footer', $data);

		}
	}	
}