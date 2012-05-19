<?php

	if (!defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Address
	 *
	 *
	 * @package		
	 * @author		
	 * @license
	 * @version		1.0
	 */

	// ------------------------------------------------------------------------

	class Address
	{
		protected $id;
		protected $user_id;
		protected $is_venue;
		protected $address_type;
		protected $address_1;
		protected $address_2;
		protected $city;
		protected $postcode;
		protected $lat;
		protected $lon;
		
		public function __construct($properties)
		{
			$this->object =& get_instance();
			$this->id = $properties['id'];
			$this->user_id = $properties['user_id'];
			$this->is_venue = $properties['is_venue'];
			$this->address_type = $properties['address_type'];
			$this->address_1 = $properties['address_1'];
			$this->address_2 = $properties['address_2'];
			$this->city = $properties['city'];
			$this->postcode = $properties['postcode'];
			$this->lat = $properties['lat'];
			$this->lon = $properties['lon'];
		}

		public function get_id()
		{
			return $this->id;
		}

		public function get_vcard()
		{
			return '<div class="vcard">' .
					'<div class="adr">' .
					'	<div class="street-address">' . $this->address_1 . '</div>' .
					'	<span class="locality">' . $this->city . '</span>, ' .
					'	<span class="postal-code">' . $this->postcode . '</span>' .
					'</div>' .
				'</div>';
		}
		
		function get_map () {
			
		}

	}
?>