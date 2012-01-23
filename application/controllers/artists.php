<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Artists extends CI_Controller
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
	    if ($method == 'index')
	    {
	    	// domain/artists/
	        $this->index();
	    }
	    else if ($method == 'get_user')
	    {
	    	// domain/artists/
	        $this->get_user($this->uri->segment(3));
	    }
	    else
	    {
	    	// domain/artists/artist_id/
	        $this->render($method);
	    }
	}

	function index()
	{

		$data['latest'] = $this->artists_model->latest_artists(5);
	
		$this->load->view('templates/header');
		$this->load->view('artists/index',$data);
		$this->load->view('templates/footer');
	}
	
	function render($user_id)
	{
		$data['user'] = $this->artists_model->get_user($user_id);
		$this->load->view('templates/header');
		$this->load->view('artists/render',$data);
		$this->load->view('templates/footer');
	}
	
	function get_user($user_id)
	{
		$data['user'] = $this->artists_model->get_user($user_id);
		$this->load->view('templates/header');
		$this->load->view('artists/render',$data);
		$this->load->view('templates/footer');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */