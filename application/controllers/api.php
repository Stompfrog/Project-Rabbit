<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller
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
	
	function artist(){
	
		$artist = $this->artists_model->get_user_data($this->uri->segment(3));
		
		$data['encoded_data'] = json_encode($artist);
		$this->load->view('api/json',$data);	
				
	}
	
	function artists()
	{
		$latest = $this->artists_model->latest_artists($this->uri->segment(3));

		$data['encoded_data'] = json_encode($latest);		
		$this->load->view('api/json',$data);
	}
		
}