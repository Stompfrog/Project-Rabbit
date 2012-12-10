<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller
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
			case 'total':
				$this->total();
				break;
			case 'latest':
				if ($this->uri->segment(4))
					$this->latest($this->uri->segment(4));
				else
					show_404();
				break;
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'join')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)))
					$this->join($this->uri->segment(5));
				else
					show_404();
				break;
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'requests')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)))
					$this->requests($this->uri->segment(5));
				else
					show_404();
				break;
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'invite')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && is_numeric($this->uri->segment(6)))
					$this->invite($this->uri->segment(5), $this->uri->segment(6));
				else
					show_404();
				break;
			case 'group':
				if ($this->uri->segment(4))
					$this->group($this->uri->segment(4));
				else
					show_404();
				break;
			case 'accept':
				if ($this->uri->segment(4))
					$this->accept($this->uri->segment(4));
				else
					show_404();
				break;
			case 'block':
				if ($this->uri->segment(4))
					$this->block($this->uri->segment(4));
				else
					show_404();
				break;
			case 'remove':
				if ($this->uri->segment(4))
					$this->remove($this->uri->segment(4));
				else
					show_404();
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
	    $total = $this->artists_model->total_groups();
	    $data['encoded_data'] = json_encode($total);            
	    $this->load->view('api/json',$data);
	}
	
	function latest($number)
	{
	    $latest = $this->artists_model->latest_groups($number);
	    $data['encoded_data'] = json_encode($latest);           
	    $this->load->view('api/json',$data);	
	}
	

	function group($group_id)
	{
		$group = $this->artists_model->get_group_json($group_id);
		$data['encoded_data'] = json_encode($group);
		$this->load->view('api/json',$data);
	}
	
	function join($group_id)
	{
	    $join_result = $this->artists_model->join_group($group_id);
	    $data['encoded_data'] = json_encode($join_result);
	    $this->load->view('api/json',$data);	    
	}
	
	function requests($group_id)
	{
	    $requests = $this->artists_model->get_group_requests($group_id);
	    $data['encoded_data'] = json_encode($requests);
	    $this->load->view('api/json',$data);	
	}
	
	function invite($group_id, $user_id)
	{
	    $invite_result = $this->artists_model->invite_user_to_group($user_id, $group_id);
	    $data['encoded_data'] = json_encode($invite_result);
	    $this->load->view('api/json',$data);
	}
	
	function accept()
	{
		return "test";
	}
	
	function block()
	{
		return "test";
	}
	
	function remove()
	{
		return "test";
	}	
}