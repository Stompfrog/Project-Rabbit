<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Addresses extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();
	
	    $this->load->library('tank_auth');
	    $this->load->library('form_validation');
		$this->load->library('security');

		$this->lang->load('tank_auth');

	    $this->load->model('artists_model');
		$this->load->model('upload_model');

	    include_once(APPPATH.'classes/Image.php');
	    include_once(APPPATH.'classes/User.php');
	    include_once(APPPATH.'classes/Address.php');	    
	}
	
	/**
	 * 	Address -  show list of addresses, with links to edit/delete, provide link to add address
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
		    
		    //get addresses
			$addresses = $this->artists_model->get_addresses($this->tank_auth->get_user_id());

			if ($addresses)
				$data['addresses'] = $addresses;
		    $this->load->view('templates/header');
		    $this->load->view('addresses/address_list',$data);
		    $this->load->view('templates/footer');
		}
	}
	
	/**
	 * 	 Add address - form and error handling for entering address
	 */
	function add_address ()
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
				$this->load->view('/addresses/add_address', $data);
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
	
				if($this->artists_model->add_address($data))
				{
					$data['message'] = 'Address added successfully!';
					$this->load->view('/addresses/add_address', $data);
				} else {
					$data['message'] = 'Oops, there was a problem adding to the database.';
					$this->load->view('/addresses/add_address', $data);
				}
			}
			$this->load->view('/templates/footer', $data);
		}
	}

	/**
	 * 	 Edit address - if no address_id, show error message, else show edit form
	 *
	 */
	function edit_address ()
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

			//if there is a parameter, and it is numeric, and it is a valid address
			if (is_numeric ($this->uri->segment(3)) && $this->artists_model->valid_address($user_id, $this->uri->segment(3)) ) {
				$address_id = $this->uri->segment(3);

				$table_values = $this->artists_model->get_address($user_id, $address_id);

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
				if ($this->form_validation->run() == FALSE) {
					$this->load->view('/addresses/address', $data);
				} else {
					$updated_values = array(
						'is_venue' => $this->form_validation->set_value('is_venue'),		
						'address_type' => $this->form_validation->set_value('address_type'),
						'address_1' => $this->form_validation->set_value('address_1'),		
						'address_2' => $this->form_validation->set_value('address_2'),
						'city' => $this->form_validation->set_value('city'),
						'postcode' => $this->form_validation->set_value('postcode'),
						'lat' => $this->form_validation->set_value('lat'),
						'lon' => $this->form_validation->set_value('lon'));
		
					if($this->artists_model->update_address($user_id, $address_id, $updated_values)) {
						$data['message'] = 'Your details were updated successfully!';
						$this->load->view('/addresses/address', $data);
					} else {
						$data['message'] = 'Oops, there was a problem updating the database.';
						$this->load->view('/addresses/address', $data);
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
	 */

	function delete_address ()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			if (is_numeric ($this->uri->segment(3)) && $this->artists_model->valid_address($this->tank_auth->get_user_id(), $this->uri->segment(3)) ) {
				$this->artists_model->delete_address ($this->tank_auth->get_user_id(), $this->uri->segment(3));
			}
			redirect('/addresses/');
		}
	}
}