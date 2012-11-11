<?php 
class Upload_model extends CI_Model {

	private $temp_path;
	private $img_path;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('artists_model');
        $this->load->library('tank_auth');
        //image paths
        //temp
        $this->temp_path = realpath(APPPATH . '../pb/tmp');
        //for image galleries etc
        $this->img_path = realpath(APPPATH . '../pb/img');        
    }
    
    /*
    	image upload, only 1 at a time.
    	upload image to temp directory
    	resize to 210 and create thumb of 110
    	generate unique names
    	add record to db
    */
    function img_upload () {
    	//override the default memory allocation
    	ini_set("memory_limit","50M");
    	//upload config
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'max_size' => 99000,
			'upload_path' => $this->temp_path
		);
		$this->load->library('upload', $config);
		//perform upload, if error, return message 
		if ( ! $this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());
			return $error;
		} //otherwise everything is good to go

		$image_data = $this->upload->data();
		
		//generate unique filename
		$filename = '';
		//$filename = $this->generate_filename ($this->img_path, $image_data['file_ext']);
		while (true) {
			$filename = uniqid(mt_rand(), true) . $image_data['file_ext'];
			if (!file_exists($this->img_path . '/' . $filename)) break;
		}
		
		//large image, resize to 800
		$config = array (
			'source_image' => $image_data['full_path'],
			'new_image' => $this->img_path . '/lg/' . $filename,
			'maintain_ratio' => true,
			'width' => 800,
			'height' => 800
		);
		//resize library
		$this->load->library('image_lib', $config);
		$this->image_lib->initialize($config);
		//create the image
		$this->image_lib->resize();
		
		//resize to 410, main image that will be viewed more tban large or thumb
		$med_config = array (
			'source_image' => $image_data['full_path'],
			'new_image' => $this->img_path . '/' . $filename,
			'maintain_ratio' => true,
			'width' => 410,
			'height' => 410
		);
		//resize library
		$this->load->library('image_lib', $config);
		//create the image
		$this->image_lib->initialize($med_config);
		$this->image_lib->resize();

		//resize config data
		$tn_config = array (
			'source_image' => $image_data['full_path'],
			'new_image' => $this->img_path . '/tn/' . $filename,
			'create_thumb' => true,
			'maintain_ratio' => false,
			'width' => 110,
			'height' => 110
		);
		//resize library
		$this->image_lib->initialize($tn_config);
		$this->image_lib->resize();

		//delete original
		unlink($image_data['full_path']);
		
		$this->artists_model->add_image($this->tank_auth->get_user_id(), $filename);
		
		return array('success' => '/pb/img/' . $filename, 
					'filename' => $filename);
    }
    
    function profile_img_upload () {
		$image_details = $this->img_upload();
		//update database
		return $this->artists_model->add_profile_image($this->tank_auth->get_user_id(), $image_details['filename']);
    }
    
    function generate_filename ($path, $ext)
    {
    	$filename = '';
		while (true) {
			$filename = uniqid(mt_rand(), true) . $ext;
			if (!file_exists($path . '/' . $filename)) break;
		}
		return $filename; 
    }
}


/*
class Uploader extends Controller {  
  function go() {  
    if(isset($_POST['go'])) {  
      // Create the config for upload library
      // (pretty self-explanatory)  
      $config['upload_path'] = './assets/upload/'; // NB! create this dir!  
      $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';  
      $config['max_size']  = '0';  
      $config['max_width']  = '0';  
      $config['max_height']  = '0';  
      // Load the upload library 
      $this->load->library('upload', $config);  
  
      // Create the config for image library  
      // (pretty self-explanatory)
      $configThumb = array();  
      $configThumb['image_library'] = 'gd2';  
      $configThumb['source_image'] = '';  
      $configThumb['create_thumb'] = TRUE;  
      $configThumb['maintain_ratio'] = TRUE;  
      // Set the height and width or thumbs 
      // Do not worry - CI is pretty smart in resizing
      // It will create the largest thumb that can fit in those dimensions
      // Thumbs will be saved in same upload dir but with a _thumb suffix  
      // e.g. 'image.jpg' thumb would be called 'image_thumb.jpg'
      $configThumb['width'] = 140;
      $configThumb['height'] = 210;  
      // Load the image library  
      $this->load->library('image_lib');  
  
      for($i = 1; $i < 6; $i++) {  
        // Handle the file upload  
        $upload = $this->upload->do_upload('image'.$i);  
        // File failed to upload - continue  
        if($upload === FALSE) continue;  
        // Get the data about the file 
        $data = $this->upload->data();  
  
        $uploadedFiles[$i] = $data;  
        // If the file is an image - create a thumbnail  
        if($data['is_image'] == 1) {  
          $configThumb['source_image'] = $data['full_path'];  
          $this->image_lib->initialize($configThumb);  
          $this->image_lib->resize();  
        }  
      }  
    }  
    // And display the form again  
    $this->load->view('upload_form');  
  }  
}
*/