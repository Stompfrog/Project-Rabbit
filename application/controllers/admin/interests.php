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
		$this->load->model('tank_auth/profiles', 'profiles_model');
    
	}
	
	/**
	 * 	Interests -  show list of interests, with links to edit/delete
	 *  
	 	The user starts typing, and autosuggest pulls in data from the interests table.
	 	Once selected, a record is inserted into the user_interests table with the user_id and interest_id
	 	If no interest exists, a temporary one is created until authorised by admin
	 */
	function index ()
	{
	
	}
	
}