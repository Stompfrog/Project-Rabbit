<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('tank_auth');
		$this->load->helper('pagination');
		
		$this->lang->load('tank_auth');

	    $this->load->model('artists_model');
		$this->load->model('upload_model');
		$this->load->model('tank_auth/profiles', 'profiles_model');
	}

	function index()
	{
		$data = array();
		//used for pagination, page, offset
	    $params = $this->input->get(NULL, TRUE);
	    $url = site_url() . 'groups/';
	    $page = (isset($params['page'])) ? $params['page'] : 1;
	    $offset = (isset($params['offset'])) ? $params['offset'] : 2;
	    
	    $pagination_config = array(
	            'url' => $url,
	            'total' => $this->artists_model->get_total_groups(),
	            'page' => $page,
	            'offset' => $offset
	    );
	    
	    $data['pagination'] = pagination($pagination_config);
	    
		$this->load->view('templates/header');

	    $groups = $this->artists_model->get_all_groups($page, $offset);
	    if ($groups)
			$data['groups'] = $groups;

		$this->load->view('groups/index', $data);
		$this->load->view('templates/footer');		
	}


	function render()
	{
		$this->load->view('templates/header');
		
		$data = array();
		
		if (is_numeric ($this->uri->segment(3)) && $this->artists_model->valid_group($this->uri->segment(3)) ) {
		    $group_id = $this->uri->segment(3);
		    $data['group'] = $this->artists_model->get_group($group_id);
				
		    $this->load->view('templates/header');
		    $this->load->view('groups/render', $data);
		    $this->load->view('templates/footer');			
		} else {
			redirect('/groups/');
		}
	}

}

/* End of file groups.php */
/* Location: ./application/controllers/groups.php */