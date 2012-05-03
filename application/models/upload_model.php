<?php 
class Upload_model extends CI_Model {

	private $temp_path;
	private $img_path;
	private $profile_img_path;

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
        //profile images
        $this->profile_img_path = realpath(APPPATH . '../pb/prf');
    }
    
    /*
    	profile image upload, only 1 at a time.
    	upload image to temp directory
    	resize to 210 and create thumb of 60
    	generate unique names
    	add record to db
    */
    function profile_img_upload () {
    	//override the default memory allocation
    	ini_set("memory_limit","50M");
    	//upload config
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'max_size' => 10000,
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
		while (true) {
			$filename = uniqid(mt_rand(), true) . $image_data['file_ext'];
			if (!file_exists($this->profile_img_path . '/' . $filename)) break;
		}
		
		//resize to 210
		$config = array (
			'source_image' => $image_data['full_path'],
			'new_image' => $this->profile_img_path . '/' . $filename,
			'maintain_ratio' => true,
			'width' => 210,
			'height' => 210
		);
		//resize library
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();

		//resize config data
		$tn_config = array (
			'source_image' => $image_data['full_path'],
			'new_image' => $this->profile_img_path . '/tn/' . $filename,
			'create_thumb' => true,
			'maintain_ratio' => false,
			'width' => 60,
			'height' => 60
		);
		//resize library
		$this->image_lib->initialize($tn_config);
		$this->image_lib->resize();

		//delete original
		unlink($image_data['full_path']);
		
		//update database
		$this->artists_model->add_profile_image($this->tank_auth->get_user_id(), $filename);
		
		return array('success' => '/pb/prf/' . $filename);
    }

	/*
		upload image
		resize to large, medium, small
		remove uploaded image
		add image paths to users profile in db
	*/
    function do_upload()
    {
    	//override the default memory allocation
    	ini_set("memory_limit","50M");
    	//upload config
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'max_size' => 10000,
			'upload_path' => $this->img_path
		);
		//todo - rename file to /i/yyyy/mm/dd/username-image-rrrrrr.ext
		$this->load->library('upload', $config);
		//perform upload, if error, return message 
		if ( ! $this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}
		
		//if target folder exists
		//if(file_exists($dir) && is_dir($dir))
		//if folder doesn't exist, create one, then run this to clear document cache:
		//clearstatcache()
		
		//generate unique id. if for some reason filename exists, loop until it doesn't
		/*
		while (true) {
			$filename = uniqid(mt_rand(), true) . '.pdf';
			if (!file_exists(sys_get_temp_dir() . $filename)) break;
		}
		*/

		$image_data = $this->upload->data();
		//resize config data
		$config = array (
			'source_image' => $image_data['full_path'],
			'new_image' => $this->img_path,
			'maintain_ratio' => true,
			'width' => 110,
			'height' => 110
		);
		//resize library
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();
		
		return array('success' => $this->img_path);
    }
    
    function generate_filename ()
    {
    
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