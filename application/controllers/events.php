<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function index()
	{
		$this->load->view('templates/header');
		$this->load->view('events/index');
		$this->load->view('templates/footer');
	}


	function render()
	{
		$this->load->view('templates/header');
		$this->load->view('events/render');
		$this->load->view('templates/footer');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */