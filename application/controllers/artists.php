<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Artists extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();
	
	    $this->load->helper('url');
	    $this->load->helper('pagination');
	    $this->load->library('tank_auth');
	    $this->load->model('artists_model');
	    
	    include_once(APPPATH.'classes/Image.php');
	    include_once(APPPATH.'classes/User.php');
	}
	
	function _remap($method)
	{
		if ($method == 'index') {
		    // domain/artists/
		    $this->index();
		} else {
		    //need to move this logic in the get_user instead of having conditionals all over the place
		    if (!is_numeric ($this->uri->segment(2))) {
		    	$this->get_user($this->artists_model->get_user_id_from_username($this->uri->segment(2)));
		    } else {
		    	$this->get_user($this->uri->segment(2));
		    }
		}
	}
	
	function index()
	{
	    //used for pagination, page, offset
	    $params = $this->input->get(NULL, TRUE);
	    
	    $url = base_url() . 'index.php/artists/';
	    $page = (isset($params['page'])) ? $params['page'] : 1;
	    $offset = (isset($params['offset'])) ? $params['offset'] : 2;
	    $pagination_config = array(
	            'url' => $url,
	            'total' => $this->artists_model->get_total_artists(),
	            'page' => $page,
	            'offset' => $offset
	    );
	    $data['pagination'] = pagination($pagination_config);
	    //this displays the results
	    $data['artists'] = $this->artists_model->latest_artists_paginated($page, $offset);
	    
	    //latest artists
	    $data['latest'] = $this->artists_model->latest_artists();
	    $this->load->view('templates/header');
	    $this->load->view('artists/index',$data);
	    $this->load->view('templates/footer');
	}
	
	function get_user($user_id)
	{
	    $data['user'] = $this->artists_model->get_user($user_id);
	    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
	    $data['friends'] = $this->artists_model->get_friends($user_id);
	    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
	    
	    //if user is logged in
	    if ($this->tank_auth->is_logged_in()) {
			$data['already_friends'] = $this->artists_model->already_friends($this->tank_auth->get_user_id(), $user_id);
			$data['friend_requested'] = $this->artists_model->friend_requested($this->tank_auth->get_user_id(), $user_id);
			$data['friend_requested_reverse'] = $this->artists_model->friend_requested($user_id, $this->tank_auth->get_user_id());
	    }
	    
	    $this->load->view('templates/header');
	    $this->load->view('artists/render',$data);
	    $this->load->view('templates/footer');
	}
        
}

/* End of file artists.php */
/* Location: ./application/controllers/artists.php */