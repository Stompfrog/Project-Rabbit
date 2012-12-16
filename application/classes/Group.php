<?php

	if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Group
	 *
	 *
	 * @package		
	 * @author		
	 * @license
	 * @version		1.0
	 */

	// ------------------------------------------------------------------------

	class Group
	{
		protected $id;
		protected $user_id;
		protected $created_date;
		protected $rights;
		protected $group_name;
		protected $join_date;
		protected $description;
		protected $images;
		protected $group_members;
		
		public function __construct($properties)
		{
			$this->object =& get_instance();
			$this->id = $properties['id'];
			$this->user_id = $properties['user_id'];
			$this->group_name = $properties['group_name'];
			$this->join_date = $properties['join_date'];
			$this->description = $properties['description'];
			$this->rights = $properties['rights'];
			if (isset($properties['created_date']))
				$this->created_date = $properties['created_date'];
			if (isset($properties['images']))
				$this->images = $properties['images'];
			if (isset($properties['group_members']))	
				$this->group_members = $properties['group_members'];
		}

		public function get_id()
		{
			return $this->id;
		}
		
		public function get_created_date($format = "dS F, Y")
		{
			$oDate = new DateTime($this->created_date);
			$sDate = $oDate->format($format);
			return $sDate;
		}

		public function get_rights()
		{
			return $this->rights;
		}

		public function is_creator ()
		{
			return $this->rights == 1;
		}
		
		public function get_group_members ()
		{
			return $this->group_members;
		}
		
		public function is_admin ()
		{
			return $this->rights <= 2;
		}
	
		public function is_member ()
		{
			return $this->rights <= 3;
		}
		
		public function has_requested ()
		{
			return $this->rights == 4;
		}
		
		public function is_invited ()
		{
			return $this->rights == 5;
		}
		
		public function is_blocked ()
		{
			return $this->rights == 6;
		}

		public function has_declined ()
		{
			return $this->rights == 7;
		}

		public function get_join_date ()
		{
			return $this->join_date;
		}
		
		public function get_group_name()
		{
			return $this->group_name;
		}
		
		public function get_user_id()
		{
			return $this->user_id;
		}

		public function get_description()
		{
			return $this->description;
		}

		public function get_url()
		{
			return site_url() . 'groups/group/' . $this->id . '/';
		}

		function get_thumb()
		{
			if (sizeof($this->images) == 0)
				return 'http://placehold.it/110x110';
			else
				return 'test';
		}
	}
?>