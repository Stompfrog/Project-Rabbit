<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Artists extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
	}
	
	function _remap($method)
	{
	    if ($method == 'index')
	    {
	    	// domain/artists/
	        $this->index();
	    }
	    else
	    {
	    	// domain/artists/artist_id/
	        $this->render($method);
	    }
	}

	function index()
	{
	
		$this->load->model('artists_model');

		$data['latest'] = $this->artists_model->latest_artists(5);
	
		$this->load->view('templates/header');
		$this->load->view('artists/index',$data);
		$this->load->view('templates/footer');
	}
	
	function render($user_id)
	{
		$this->load->model('artists_model');
		
		$user = $this->artists_model->get_user_data($user_id);
			
		if($user){

			$data['user'] = $user;
			
			$this->load->view('templates/header');
			$this->load->view('artists/render',$data);
			$this->load->view('templates/footer');

		
		}else{
		
			$this->load->view('templates/header');
			$this->load->view('artists/not_found');
			$this->load->view('templates/footer');
		}

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */