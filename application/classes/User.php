<?php

	if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * User
	 *
	 *
	 * @package		
	 * @author		
	 * @license
	 * @version		1.0
	 */

	// ------------------------------------------------------------------------
	// To do:
	// get all and add groups
	// get all galleries, galleries get the images, and add galleries

	class User
	{
		protected $id;
		protected $username;
		protected $created;
		protected $last_login;
		protected $website;
		protected $first_name;
		protected $last_name;
		protected $avatar_filename;
		protected $status;
		protected $about_me;
		protected $sex;
		protected $lat;
		protected $lon;
		protected $object;

		public function __construct($properties)
		{
			$this->object =& get_instance();
	
			$this->id = $properties['id'];
			$this->username = $properties['username'];
			$this->created = $properties['created'];
			$this->last_login = $properties['last_login'];
			$this->website = $properties['website'];
			$this->first_name = $properties['first_name'];
			$this->last_name = $properties['last_name'];
			$this->avatar_filename = $properties['avatar_filename'];
			$this->status = $properties['status'];
			$this->about_me = $properties['about_me'];
			$this->sex = $properties['sex'];
			$this->lat = $properties['lat'];
			$this->lon = $properties['lon'];			
		}

		public function get_id()
		{
			return $this->id;
		}

		public function get_username()
		{
			return $this->username;
		}

		public function get_about_me()
		{
			return $this->about_me;
		}

		public function get_member_since()
		{
			return $this->created;
			//for "member since dd/mm/yyyy"
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
		
		public function get_lat()
		{
			return $this->lat;
		}
		
		public function get_lon()
		{
			return $this->lon;
		}

		public function get_avatar($attributes = '')
		{
			return '<img src="' . base_url() . $this->object->config->item('thumb_path') . $properties['avatar_filename'] . '" alt="' . $this->get_name() . '" ' . $attributes .  ' />';
		}
		
		public function get_large_avatar($attributes = '')
		{
			return '<img src="' . base_url() . $this->object->config->item('image_path') . $properties['avatar_filename'] . '" alt="' . $this->get_name() . '" ' . $attributes .  ' />';
		}
	}
?>

















