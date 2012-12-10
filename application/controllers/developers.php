<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Developers extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();
	
	    $this->load->helper('url');
	    $this->load->library('tank_auth');
	    $this->load->model('artists_model');
	    
	    include_once(APPPATH.'classes/Image.php');
	    include_once(APPPATH.'classes/User.php');
	}
	
	function index()
	{
	    $this->load->view('templates/header');
	    $this->load->view('api/index');
	    $this->load->view('templates/footer');
	}




	/*
	* Venues
	*/

	/*
	* Events
	*/
	
	/*
	* Interests
	*/
	    
}