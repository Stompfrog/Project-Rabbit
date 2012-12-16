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
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'leave')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)))
					$this->leave($this->uri->segment(5));
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
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'deny')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && is_numeric($this->uri->segment(6)))
					$this->deny($this->uri->segment(5), $this->uri->segment(6));
				else
					show_404();
				break;
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'decline')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)))
					$this->decline($this->uri->segment(5));
				else
					show_404();
				break;
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'accept')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && is_numeric($this->uri->segment(6)))
					$this->accept($this->uri->segment(5), $this->uri->segment(6));
				else
					show_404();
				break;
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'remove')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && is_numeric($this->uri->segment(6)))
					$this->remove($this->uri->segment(5), $this->uri->segment(6));
				else
					show_404();
				break;
			case 'group':
				if ($this->uri->segment(4))
					$this->group($this->uri->segment(4));
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
		if($this->tank_auth->is_logged_in()) {
		    $join_result = $this->artists_model->join_group($group_id);
		    $data['encoded_data'] = json_encode($join_result);
		    $this->load->view('api/json',$data);
		} else {
			$this->load->view('api/json', 'You are not logged in');
		}  
	}

	function leave($group_id)
	{
		if($this->tank_auth->is_logged_in()) {
		    $leave_result = $this->artists_model->leave_group($group_id);
		    $data['encoded_data'] = json_encode($leave_result);
		    $this->load->view('api/json',$data);
		} else {
			$this->load->view('api/json', 'You are not logged in');
		}	    
	}
	
	function requests($group_id)
	{
		if($this->tank_auth->is_logged_in()) {
		    $requests = $this->artists_model->get_group_requests($group_id);
		    $data['encoded_data'] = json_encode($requests);
		    $this->load->view('api/json',$data);
		} else {
			$this->load->view('api/json', 'You are not logged in');
		}
	}
	
	function invite($group_id, $user_id)
	{
		if($this->tank_auth->is_logged_in()) {
		    $invite_result = $this->artists_model->invite_user_to_group($user_id, $group_id);
		    $data['encoded_data'] = json_encode($invite_result);
		    $this->load->view('api/json',$data);
		} else {
			$this->load->view('api/json', 'You are not logged in');
		}
	}
	
	function accept($group_id, $user_id)
	{
		if($this->tank_auth->is_logged_in()) {
			$accepted = $this->artists_model->accept_user_into_group($user_id, $group_id);
		    $data['encoded_data'] = json_encode($accepted);
		    $this->load->view('api/json',$data);
		} else {
			$this->load->view('api/json', 'You are not logged in');
		}
	}
	
	function decline($group_id)
	{
		if($this->tank_auth->is_logged_in()) {
			$declined = $this->artists_model->decline_group_invite($group_id);
		    $data['encoded_data'] = json_encode($declined);
		    $this->load->view('api/json',$data);
		} else {
			$this->load->view('api/json', 'You are not logged in');
		}
	}
	
	function deny ($group_id, $user_id) {
		if($this->tank_auth->is_logged_in()) {
			$declined = $this->artists_model->deny_user_group_entry($user_id, $group_id);
		    $data['encoded_data'] = json_encode($declined);
		    $this->load->view('api/json',$data);
		} else {
			$this->load->view('api/json', 'You are not logged in');
		}
	}
	
	function remove($group_id, $user_id)
	{
		if($this->tank_auth->is_logged_in()) {
			$removed = $this->artists_model->remove_user_from_group($user_id, $group_id);
		    $data['encoded_data'] = json_encode($removed);
		    $this->load->view('api/json',$data);
		} else {
			$this->load->view('api/json', 'You are not logged in');
		}
	}	
}