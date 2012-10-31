<?php

	if (!defined('BASEPATH')) exit('No direct script access allowed');

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

	class Image
	{
		protected $id;
		protected $title;
		protected $description;
		protected $alt;
		protected $large_path;
		protected $thumb_path;
		protected $object;

		public function __construct($properties)
		{
			$this->object =& get_instance();
			$this->id = $properties['id'];
			$this->title = $properties['title'];
			$this->description = $properties['description'];
			$this->alt = $properties['alt'];
			$this->large_path = base_url() . $this->object->config->item('image_path') . $properties['file_name'];
			$this->thumb_path = base_url() . $this->object->config->item('thumb_path') . $properties['file_name'];
		}

		public function get_id()
		{
			return $this->id;
		}

		public function get_title()
		{
			return $this->title;
		}

		public function get_alt()
		{
			return $this->alt;
		}

		public function get_description()
		{
			return $this->description;
		}

		public function get_large_path()
		{
			return $this->large_path;
		}

		public function get_thumb_path()
		{
			return $this->thumb_path;
		}

		public function get_large_image($attributes = '')
		{
			$size_array = getimagesize($this->get_large_path());
			return '<img src="' . $this->get_large_path() . '" alt="' . $this->get_alt() . '" ' . $size_array[3] . ' ' . $attributes .  ' />';
		}

		public function get_thumb_image($attributes = '')
		{
			return '<img src="' . $this->get_thumb_path() . '" alt="' . $this->get_alt() . '" ' . $attributes .  ' />';
		}

		public function get_sized_image($attributes = '')
		{
			return '<img src="' . $this->get_large_path() . '" alt="' . $this->get_alt() . '" ' . $attributes .  ' />';
		}

		public function get_image_link($link_attributes = '', $image_attributes = '')
		{
			return '<a href="' . $this->get_large_path() . '" title="' . $this->get_title() . '" ' . $link_attributes . '>' . $this->get_thumb_image($image_attributes) . '</a>';
		}
	}
?>