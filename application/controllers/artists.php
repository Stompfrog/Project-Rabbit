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
	    
	    include_once(APPPATH.'classes/Gallery.php');
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
			case ($this->uri->segment(3) && ($this->uri->segment(3) == 'images')):
				if (!is_numeric ($this->uri->segment(2)))
					$this->images($this->artists_model->get_user_id_from_username($this->uri->segment(2)));
				else
					$this->images($this->uri->segment(2));
				break;				
			case (($this->uri->segment(3) && ($this->uri->segment(3) == 'image')) && $this->uri->segment(4)):
				if (!is_numeric ($this->uri->segment(2)))
					$this->image($this->artists_model->get_user_id_from_username($this->uri->segment(2), $this->uri->segment(4)));
				else
					$this->image($this->uri->segment(2), $this->uri->segment(4));
				break;
			case ($this->uri->segment(3) && ($this->uri->segment(3) == 'gallery') && ($this->uri->segment(4))):
				if (!is_numeric ($this->uri->segment(2)))
					$this->gallery($this->artists_model->get_user_id_from_username($this->uri->segment(2)), $this->uri->segment(4));
				else
					$this->gallery($this->uri->segment(2), $this->uri->segment(4));
				break;
			case (!is_numeric ($this->uri->segment(2))):
				$this->get_user($this->artists_model->get_user_id_from_username($this->uri->segment(2)));
				break;
			case (is_numeric ($this->uri->segment(2))):
				$this->get_user($this->uri->segment(2));
				break;
			default:
				$this->page_not_found();
				break;
		}
	}
	
	function index()
	{
	    //used for pagination, page, offset
	    $params = $this->input->get(NULL, TRUE);
	    
	    $url = base_url() . 'index.php/artists/';
	    $page = (isset($params['page'])) ? $params['page'] : 1;
	    $offset = (isset($params['offset'])) ? $params['offset'] : 5;
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
	    
	    $data['galleries'] = $this->artists_model->get_galleries($user_id);
	    
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
	
	function gallery ($user_id, $gallery_id) 
	{
		$data = array();
		$gallery = false;
		
	    $data['user'] = $this->artists_model->get_user($user_id);
	    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
	    $data['friends'] = $this->artists_model->get_friends($user_id);
	    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		
		if (is_numeric ($gallery_id) && $this->profiles_model->valid_gallery($gallery_id, $user_id) ) {
			$gallery = $gallery_id;
		}
		
		if ($gallery) {
			$data['gallery'] = $this->profiles_model->get_gallery($user_id, $gallery);			
		} else {
			$data['error'] = 'Oops, there has been a problem';
		}

	    $this->load->view('templates/header');
	    $this->load->view('gallery/gallery',$data);
	    $this->load->view('templates/footer');
	}
	
	function image ($user_id, $image_id)
	{
		$data = array();
		
	    $data['user'] = $this->artists_model->get_user($user_id);
	    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
	    $data['friends'] = $this->artists_model->get_friends($user_id);
	    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		
		$data['image'] = $this->profiles_model->get_user_image($user_id, $image_id);			

	    $this->load->view('templates/header');
	    $this->load->view('images/image',$data);
	    $this->load->view('templates/footer');
		
	}
	
	function images ($user_id)
	{
		$data = array();
		
	    $data['user'] = $this->artists_model->get_user($user_id);
	    $data['total_friends'] = $this->artists_model->get_total_friends($user_id);
	    $data['friends'] = $this->artists_model->get_friends($user_id);
	    $data['pending_friends'] = $this->artists_model->get_pending_friends($user_id);
		
		$data['images'] = $this->profiles_model->get_images($user_id);			

	    $this->load->view('templates/header');
	    $this->load->view('gallery/images',$data);
	    $this->load->view('templates/footer');
	}
	
	function page_not_found()
	{
		//404 error
	}
        
}

/* End of file artists.php */
/* Location: ./application/controllers/artists.php */