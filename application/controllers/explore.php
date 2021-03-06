<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Explore extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->model('artists_model');
	}

	function index()
	{
		$data['interests'] = $this->artists_model->get_all_interests();
	
		$this->load->view('templates/header');
		$this->load->view('explore/index', $data);
		$this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */