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
	
	}
}