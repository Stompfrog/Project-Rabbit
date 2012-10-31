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
		$data['popular_places'] = $this->artists_model->get_popular_places(5);
		$data['latest_events'] = $this->artists_model->get_latest_events(5);
		$data['latest_groups'] = $this->artists_model->get_latest_groups(5);
		
		$this->load->view('templates/header');
		$this->load->view('welcome_message',$data);
		$this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */