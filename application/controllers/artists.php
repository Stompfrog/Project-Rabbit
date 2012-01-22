<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Artists extends CI_Controller
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
		$this->load->view('artists/index');
		$this->load->view('templates/footer');
	}
<<<<<<< HEAD
=======


	function render()
	{
		$this->load->view('templates/header');
		$this->load->view('artists/render');
		$this->load->view('templates/footer');
	}


>>>>>>> 2b91b7a61b063b4df8998d6c8fd45c8aa3b56d0e
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */