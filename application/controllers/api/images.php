<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Images extends CI_Controller
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
			case 'latest':
				$this->latest();
				break;
			default:
				show_404();
				break;
		}
	}

	function index()
	{
	    return false;
	}

	//get a list of all images, latest to earliest
	function latest()
	{
	    $images = $this->artists_model->all_images($this->uri->segment(4), $this->uri->segment(5));
	    $data['encoded_data'] = json_encode($images);         
	    $this->load->view('api/json',$data);
	}
}