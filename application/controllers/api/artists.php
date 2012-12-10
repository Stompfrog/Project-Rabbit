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
		switch($method)
		{
			case 'index':
				$this->index();
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) === 'total')):
				$this->total();
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) === 'artist')):
				if (!is_numeric ($this->uri->segment(4)))
					$this->artist($this->artists_model->get_user_id_from_username($this->uri->segment(4)));
				else
					$this->artist($this->uri->segment(4));
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) === 'latest')):
				if ($this->uri->segment(4))
					$this->latest($this->uri->segment(4));
				else
					show_404();
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) === 'interests')):
					$this->interests();
				break;
			default:
				show_404();
				break;
		}
	}
	
	function index()
	{
	    $all_artists = $this->artists_model->all_artists();
	    $data['encoded_data'] = json_encode($all_artists);              
	    $this->load->view('api/json',$data);
	}

	function total()
	{
	    $total = $this->artists_model->get_total_artists();
	    $data['encoded_data'] = json_encode($total);            
	    $this->load->view('api/json',$data);
	}
	
	function latest($number)
	{
	    $latest = $this->artists_model->latest_artists($number);
	    $data['encoded_data'] = json_encode($latest);           
	    $this->load->view('api/json',$data);	
	}
	

	function artist($user_id)
	{
		$artist = $this->artists_model->get_user_data($user_id);
		$data['encoded_data'] = json_encode($artist);
		$this->load->view('api/json',$data);
	}
	
	function interests()
	{
		//get any get parameters
	    $params = $this->input->get('interests');
	    $all_artists = $this->artists_model->all_artists_interests((is_array($params)) ? $params : null);
	    $data['encoded_data'] = json_encode($all_artists);
	    $this->load->view('api/json',$data);    
	}
}