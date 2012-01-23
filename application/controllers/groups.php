<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller
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
		$this->load->view('groups/index');
		$this->load->view('templates/footer');
	}


	function render()
	{
		$this->load->view('templates/header');
		$this->load->view('groups/render');
		$this->load->view('templates/footer');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */