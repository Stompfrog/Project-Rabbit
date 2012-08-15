<?php

	if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	include_once('Image.php');

	/**
	 * Image
	 *
	 *
	 * @package		
	 * @author		
	 * @license
	 * @version		1.0
	 */

	// ------------------------------------------------------------------------

	class Profile_Image extends Image
	{
		protected $profile_large_path;
		protected $profile_thumb_path;

		public function __construct($properties)
		{
			$this->object =& get_instance();
			parent::__construct($properties); 
			$this->profile_large_path = base_url() . $this->object->config->item('profile_image_path') . $properties['file_name'];
			$this->profile_thumb_path = base_url() . $this->object->config->item('profile_thumb_path') . $properties['file_name'];
		}

		public function get_profile_large_path()
		{
			return $this->profile_large_path;
		}

		public function get_profile_thumb_path()
		{
			return $this->profile_thumb_path;
		}

		public function get_profile_large_image($attributes = '')
		{
			$size_array = getimagesize($this->get_profile_large_path());
			return '<img src="' . $this->get_profile_large_path() . '" alt="' . $this->get_alt() . '" ' . $size_array[3] . ' ' . $attributes .  ' />';
		}

		public function get_profile_thumb_image($attributes = '')
		{
			return '<img src="' . $this->get_profile_thumb_path() . '" alt="' . $this->get_alt() . '" ' . $attributes .  ' />';
		}

	}
?>