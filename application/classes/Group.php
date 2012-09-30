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
		protected $is_creator;
		protected $is_admin;
		protected $is_member;
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
			if (isset($properties['created_date']))
				$this->created_date = $properties['created_date'];
			if (isset($properties['images']))
				$this->images = $properties['images'];
			if (isset($properties['is_creator']))	
				$this->is_creator = $properties['is_creator'];
			if (isset($properties['is_admin']))	
				$this->is_admin = $properties['is_admin'];
			if (isset($properties['is_member']))	
				$this->is_member = $properties['is_member'];
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

		public function is_creator ()
		{
			return $this->is_creator;
		}
		
		public function get_group_members ()
		{
			return $this->group_members;
		}
		
		public function is_admin ()
		{
			return $this->is_admin;
		}
	
		public function is_member ()
		{
			return $this->is_member;
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

		public function get_admin_url()
		{
			return base_url() . 'index.php/admin/groups/group/' . $this->id . '/';
		}

		public function get_url()
		{
			return base_url() . 'index.php/groups/group/' . $this->id . '/';
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