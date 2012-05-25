<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Friends extends CI_Controller
{
	function __construct()
	{
	    parent::__construct();
	
	    $this->load->helper('url');
	    $this->load->helper('pagination');
	    $this->load->library('tank_auth');
	    $this->load->library('pagination');
	    $this->load->model('artists_model');
	    
	    include_once(APPPATH.'classes/Image.php');
	    include_once(APPPATH.'classes/User.php');
	}
	
	function index()
	{
		if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
			redirect('/auth/login/');
		} else {
			$user_id = $this->tank_auth->get_user_id();
			//used for pagination, page, offset
			$params = $this->input->get(NULL, TRUE);
			
		    $data['friends'] = $this->artists_model->get_friends($user_id);
			$data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
	
		    //pagination
		    $url = base_url() . 'index.php/admin/friends/';
		    $page = (isset($params['page'])) ? $params['page'] : 1;
		    $offset = (isset($params['offset'])) ? $params['offset'] : 1;
		    $pagination_config = array(
		            'url' => $url,
		            'total' => $this->artists_model->get_total_friends($user_id),
		            'page' => $page,
		            'offset' => $offset
		    );
		    $data['pagination'] = pagination($pagination_config);
		    //this displays the results
		    $data['friends_paginated'] = $this->artists_model->get_friends_paginated($user_id, $page, $offset);
		    
		    $this->load->view('templates/header');
		    $this->load->view('auth/friend_list',$data);
		    $this->load->view('templates/footer');
	    }
	}
}