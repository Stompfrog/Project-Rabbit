<?php
	
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	/**
	 * User
	 *
	 *
	 * @package             
	 * @author              
	 * @license
	 * @version             1.0
	 */
	
	// ------------------------------------------------------------------------
	// To do:
	// get all and add groups
	// get all galleries, galleries get the images, and add galleries
	
	class User
	{
		protected $id;
		protected $username;
		protected $email;
		protected $created;
		protected $last_login;
		protected $website;
		protected $first_name;
		protected $last_name;
		protected $avatar_filename;
		protected $status;
		protected $about_me;
		protected $sex;
		protected $addresses;
		protected $object;
		protected $interests;
		protected $groups;
		
		public function __construct($properties)
		{
			$this->object =& get_instance();
			
			$this->id = $properties['id'];
			$this->username = $properties['username'];
			$this->email = $properties['email'];
			$this->created = $properties['created'];
			$this->last_login = $properties['last_login'];
			$this->website = $properties['website'];
			$this->first_name = $properties['first_name'];
			$this->last_name = $properties['last_name'];
			$this->avatar_filename = $properties['avatar_filename'];
			$this->status = $properties['status'];
			$this->about_me = $properties['about_me'];
			$this->sex = $properties['sex'];
			$this->addresses = $properties['addresses'];
			$this->interests = $properties['interests']; 
			if (isset($properties['groups']))
				$this->groups = $properties['groups'];  
		}
		
		public function get_id()
		{
			return $this->id;
		}
		
		public function get_username()
		{
			return $this->username;
		}
		
		public function get_email()
		{
			return $this->email;
		}
		
		public function get_about_me()
		{
			return $this->about_me;
		}
		
		public function get_status()
		{
			return $this->status;
		}
		
		// You can pass optional date format string to this method, defaults to "26th February, 1983"
		public function get_member_since($format = "dS F, Y")
		{
			$oDate = new DateTime($this->created);
			$sDate = $oDate->format($format);
			return $sDate;
		}
		
		public function get_last_login()
		{
			return $this->last_login;
		}
		
		public function get_website()
		{
			return $this->website;
		}
		
		public function get_name()
		{
			return $this->first_name . ' ' . $this->last_name;
		}

		public function get_addresses ()
		{
			if (sizeof($this->addresses) > 0) {
				$address_string = '';
				foreach($this->addresses as $address)
					$address_string .= $address->get_vcard();
				return $address_string;
			}
			return false;
		}
	
		public function get_interests()
		{
			return $this->interests;
		}
		
		public function get_interests_list()
		{
			$int_str = '';
			if($this->interests && count($this->interests) > 0)
			{
				$int_str .= '<ul>';
				foreach ($this->interests as $interest) {
					$int_str .= '<li>' . $interest . "</li>\n";
				}
				$int_str .= '</ul>';
			}
			return $int_str;
		}       
		
		public function get_avatar($attributes = '')
		{
			if ($this->avatar_filename != '') {
				return '<img src="' . base_url() . $this->object->config->item('thumb_path') . $this->avatar_filename . '" alt="' . $this->get_name() . '" ' . $attributes .  ' />';
			} else {
				return false;
			}
		}
		
		public function get_large_avatar($attributes = '')
		{
			if ($this->avatar_filename != '') {
				return '<img src="' . base_url() . $this->object->config->item('image_path') . $this->avatar_filename . '" alt="' . $this->get_name() . '" ' . $attributes .  ' />';
			} else {
				return false;
			}
		}
		
		public function get_groups ()
		{
			if (isset($this->groups))
				return $this->groups;
			else return false;
		}
	}
?>