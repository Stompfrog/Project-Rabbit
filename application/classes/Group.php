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
		protected $title;
		protected $join_date;
		protected $description;
		protected $images;
		
		public function __construct($properties)
		{
			$this->object =& get_instance();
			$this->id = $properties['id'];
			$this->user_id = $properties['user_id'];
			$this->title = $properties['title'];
			$this->join_date = $properties['join_date'];
			$this->description = $properties['description'];
			if (isset($properties['images']))
				$this->images = $properties['images'];
		}

		public function get_id()
		{
			return $this->id;
		}
		
		public function get_join_date ()
		{
		
		}
		
		public function get_title()
		{
			return $this->title;
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