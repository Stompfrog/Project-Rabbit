<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
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
		$data['latest'] = $this->artists_model->latest_artists(5);
		//latest groups
		//latest events/places
		
		$this->load->view('templates/header');
		$this->load->view('welcome_message',$data);
		$this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */