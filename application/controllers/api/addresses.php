<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Addresses extends CI_Controller
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

	function _remap($method)
	{
		switch($method)
		{
			case 'index':
				$this->index();
				break;
			case 'near':
				$this->near();
				break;
			case 'get':
				$this->near();
				break;
			case 'user':
				$this->user();
				break;
			default:
				show_404();
				break;
		}
	}
	
	function index()
	{
	   
	}

	function near()
	{
		$addresses = $this->artists_model->get_geo_addresses($this->uri->segment(4), $this->uri->segment(5), $this->uri->segment(6));
	    $data['encoded_data'] = json_encode($addresses);         
	    $this->load->view('api/json',$data);  
	}	
	
	//get a specific address
	function get ()
	{
	
	}
	
	//get users address/es
	function user ()
	{
	
	}
}