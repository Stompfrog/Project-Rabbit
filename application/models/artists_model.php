<?php 
class Artists_model extends CI_Model {

    var $title   = '';
    var $content = '';
    var $date    = '';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function get_user_data($user_id)
	{
		// Query the database to get the users details
		$this->load->database();
		$user = $this->db->query("SELECT * FROM user_profiles WHERE user_id = ?",array($user_id));
		if ($user->num_rows() > 0)
		{
			return $user->row_array();
		}
		else
		{
			return false;		
		}
	}
	
/*
	function latest_mugs($limit){
		// Get the latest people to sign up
		$this->load->database();
		if($limit==0){
			return $this->db->query("SELECT user_name, user_start_date FROM tea_table ORDER BY user_start_date DESC");
		}
		else
		{
			return $this->db->query("SELECT user_name, user_start_date FROM tea_table ORDER BY user_start_date DESC LIMIT ".$limit);
		}
	}

*/    
}
