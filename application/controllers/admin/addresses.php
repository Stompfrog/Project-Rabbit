<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Addresses extends CI_Controller
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
	    include_once(APPPATH.'classes/Address.php');	    
	}
	
	/**
	 * 	Address -  show list of addresses, with links to edit/delete, provide link to add address
	 *
	 *  @return void
	 */
	function index ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$data = array();
			//get addresses

			$addresses = $this->profiles_model->get_addresses($this->tank_auth->get_user_id());

			if ($addresses)
				$data['addresses'] = $addresses;
		    $this->load->view('templates/header');
		    $this->load->view('auth/address_list',$data);
		    $this->load->view('templates/footer');
		}
	}
	
	/**
	 * 	 Add address - form and error handling for entering address
	 *
	 * @return void
	 */
	function add_address ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
		
			$data = array();
			
			$this->form_validation->set_rules('is_venue', 'is_venue', 'trim|xss_clean');
			$this->form_validation->set_rules('address_type', 'address_type', 'trim|xss_clean');
	
			$this->form_validation->set_rules('address_1', 'address_1', 'trim|required|xss_clean');
			$this->form_validation->set_rules('address_2', 'address_2', 'trim|xss_clean');
			$this->form_validation->set_rules('city', 'city', 'trim|required|xss_clean');
			$this->form_validation->set_rules('postcode', 'postcode', 'trim|required|xss_clean');
			$this->form_validation->set_rules('lat', 'lat', 'trim|xss_clean');
			$this->form_validation->set_rules('lon', 'lon', 'trim|xss_clean');
			$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
			
			//load map in footer
			$data['loadmap'] = TRUE;
			
			$this->load->view('/templates/header', $data);
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('/auth/add_address', $data);
			}
			else
			{
				$data = array(
					'is_venue' => 0,
					'user_id' => $this->tank_auth->get_user_id(),
					'address_type' => 1,
					'address_1' => $this->form_validation->set_value('address_1'),		
					'address_2' => $this->form_validation->set_value('address_2'),
					'city' => $this->form_validation->set_value('city'),
					'postcode' => $this->form_validation->set_value('postcode'),
					'lat' => $this->form_validation->set_value('lat'),
					'lon' => $this->form_validation->set_value('lon'));
	
				if($this->profiles_model->add_address($data))
				{
					$data['message'] = 'Address added successfully!';
					$this->load->view('/auth/add_address', $data);
				} else {
					$data['message'] = 'Oops, there was a problem adding to the database.';
					$this->load->view('/auth/add_address', $data);
				}
			}
			$this->load->view('/templates/footer', $data);
		}
	}

	/**
	 * 	 Edit address - if no address_id, show error message, else show edit form
	 *
	 * @return void
	 */
	function edit_address ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			//if there is a parameter, and it is numeric, and it is a valid address
			if (is_numeric ($this->uri->segment(4)) && $this->artists_model->valid_address($this->uri->segment(4), $this->tank_auth->get_user_id()) ) {
				$address_id = $this->uri->segment(4);
				$data = array();
				$user_id = $this->tank_auth->get_user_id();
				$table_values = $this->profiles_model->get_address($user_id, $address_id);

				$data['table_values'] = $table_values;
		
				$this->form_validation->set_rules('is_venue', 'is_venue', 'trim|xss_clean');
				$this->form_validation->set_rules('address_type', 'address_type', 'trim|xss_clean');
		
				$this->form_validation->set_rules('address_1', 'address_1', 'trim|required|xss_clean');
				$this->form_validation->set_rules('address_2', 'address_2', 'trim|xss_clean');
				$this->form_validation->set_rules('city', 'city', 'trim|required|xss_clean');
				$this->form_validation->set_rules('postcode', 'postcode', 'trim|required|xss_clean');
				$this->form_validation->set_rules('lat', 'lat', 'trim|xss_clean');
				$this->form_validation->set_rules('lon', 'lon', 'trim|xss_clean');
				$this->form_validation->set_error_delimiters('<span class="help-inline">', '</span>');
				
				$data['loadmap'] = TRUE;
			
				$this->load->view('/templates/header', $data);
				if ($this->form_validation->run() == FALSE)
				{
					$this->load->view('/auth/address', $data);
				}
				else
				{
					$updated_values = array(
						'is_venue' => $this->form_validation->set_value('is_venue'),		
						'address_type' => $this->form_validation->set_value('address_type'),
						'address_1' => $this->form_validation->set_value('address_1'),		
						'address_2' => $this->form_validation->set_value('address_2'),
						'city' => $this->form_validation->set_value('city'),
						'postcode' => $this->form_validation->set_value('postcode'),
						'lat' => $this->form_validation->set_value('lat'),
						'lon' => $this->form_validation->set_value('lon'));
		
					if($this->profiles_model->update_address($user_id, $address_id, $updated_values))
					{
						$data['message'] = 'Your details were updated successfully!';
						$this->load->view('/auth/address', $data);
					} else {
						$data['message'] = 'Oops, there was a problem updating the database.';
						$this->load->view('/auth/address', $data);
					}
				}
				$this->load->view('/templates/footer', $data);
			} else {
				$data['error_message'] = 'address does not exist';
				$this->load->view('/templates/header');
				$this->load->view('/templates/error', $data);
				$this->load->view('/templates/footer', $data);
			}
		}
	}

	/**
	 * 	 Delete address - if no address_id, show error message, else prompt, and if yes, delete address
	 *
	 * @return void
	 */

	function delete_address ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			if (is_numeric ($this->uri->segment(4)) && $this->artists_model->valid_address($this->uri->segment(4), $this->tank_auth->get_user_id()) ) {
				$this->profiles_model->delete_address ($this->uri->segment(4), $this->tank_auth->get_user_id());
			}
			redirect('/admin/addresses/');
		}
	}
}