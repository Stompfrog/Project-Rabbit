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
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5))) {
				
					if ($this->uri->segment(6) && is_numeric($this->uri->segment(6))) {
						$this->accept($this->uri->segment(5), $this->uri->segment(6));
					} else {
						$this->accept_group_invitation($this->uri->segment(5));
					}
				} else {
					show_404();
				}
				break;
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'remove')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && is_numeric($this->uri->segment(6)))
					$this->remove($this->uri->segment(5), $this->uri->segment(6));
				else
					show_404();
				break;
			case ($this->uri->segment(4) && ($this->uri->segment(4) === 'reassign')):
				if ($this->uri->segment(5) && is_numeric($this->uri->segment(5)) && $this->uri->segment(6) && is_numeric($this->uri->segment(6)))
					$this->reassign($this->uri->segment(5), $this->uri->segment(6));
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
	
	/*
	Current logged in user selects "join" on individual group
	Params: Group id
	Returns: Boolean
	*/
	function join($group_id)
	{
		if($this->tank_auth->is_logged_in()) {
		    $join_result = $this->artists_model->join_group($this->tank_auth->get_user_id(), $group_id);
		    $data['encoded_data'] = json_encode($join_result);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);
	}

	/*
	Current logged in user selects "leave group"
	Params: Group id
	Returns: Boolean
	*/
	function leave($group_id)
	{
		if($this->tank_auth->is_logged_in()) {
		    $leave_result = $this->artists_model->leave_group($this->tank_auth->get_user_id(), $group_id);
		    $data['encoded_data'] = json_encode($leave_result);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);    
	}
	
	/*
	Current logged in user who is admin or above can access a list of users who have requested to join group
	Params: Group id
	Returns: Array of user data
	*/
	function requests($group_id)
	{
		if($this->tank_auth->is_logged_in()) {
		    $requests = $this->artists_model->get_group_requests($group_id);
		    $data['encoded_data'] = json_encode($requests);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);
	}
	
	/*
	Current logged in user who is admin or above invites another user to join group
	Params: Group id, user id
	Returns: boolean
	*/
	function invite($group_id, $user_id)
	{
		if($this->tank_auth->is_logged_in()) {
		    $invite_result = $this->artists_model->invite_user_to_group($this->tank_auth->get_user_id(), $user_id, $group_id);
		    $data['encoded_data'] = json_encode($invite_result);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);
	}
	
	/*
	Current logged in user who has been invited to join a group accepts
	Params: Group id
	Returns: Boolean
	*/
	function accept_group_invitation ($group_id)
	{
		if($this->tank_auth->is_logged_in()) {
			$accepted = $this->artists_model->accept_group_invitation($this->tank_auth->get_user_id(), $group_id);
		    $data['encoded_data'] = json_encode($accepted);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);
	}

	/*
	Current logged in user who is admin or above accepts user into group
	Params: Group id, user id
	Returns: boolean
	*/
	function accept($group_id, $user_id)
	{
		if($this->tank_auth->is_logged_in()) {
			$accepted = $this->artists_model->accept_user_into_group($this->tank_auth->get_user_id(), $user_id, $group_id);
		    $data['encoded_data'] = json_encode($accepted);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);
	}
	
	/*
	Current logged in user declines group invitation
	Params: Group id
	Returns: boolean
	*/
	function decline($group_id)
	{
		if($this->tank_auth->is_logged_in()) {
			$declined = $this->artists_model->decline_group_invite($this->tank_auth->get_user_id(), $group_id);
		    $data['encoded_data'] = json_encode($declined);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);
	}
	
	/*
	Current logged in user who is admin or above denies user entry into group
	Params: Group id, user id
	Returns: boolean
	*/
	function deny ($group_id, $user_id) {
		if($this->tank_auth->is_logged_in()) {
			$declined = $this->artists_model->deny_user_group_entry($this->tank_auth->get_user_id(), $user_id, $group_id);
		    $data['encoded_data'] = json_encode($declined);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);
	}

	/*
	Current logged in user who is admin or above removes user from group
	Params: Group id, user id
	Returns: boolean
	*/	
	function remove ($group_id, $user_id)
	{
		if($this->tank_auth->is_logged_in()) {
			$removed = $this->artists_model->remove_user_from_group($this->tank_auth->get_user_id(), $user_id, $group_id);
		    $data['encoded_data'] = json_encode($removed);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);
	}

	/*
	Current logged in user who is creator of group assigns ownership to another member of the group
	Params: Group id, user id
	Returns: boolean
	*/	
	function reassign ($group_id, $user_id)
	{
		if($this->tank_auth->is_logged_in()) {
			$removed = $this->artists_model->reassign_group($user_id, $group_id);
		    $data['encoded_data'] = json_encode($removed);
		} else {
			$data['encoded_data'] = json_encode(false); 
		}  
		$this->load->view('api/json',$data);
	}	
}