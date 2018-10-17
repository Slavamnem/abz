<?php
class Image{
    // Function saves all uploaded photos
	public static function saveImages(&$params){
		foreach($_FILES as $key => $image){
            if($image != "none" and $image['errors'] == 0 and $image['size'] > 0){
                $params[$key] = Image::imageUpload(['name' => 'foto', 'value' => $image]);
            }
        }
	}
	public static function imageUpload($pole){
        if(isset($pole['value'])){
            if($pole['value']['name'] != ''){
                $file = $pole['value'];
                // folder where we will save photos
                define('UPLOAD_FILE', "../img/");
                // valid file extensions
                $valid_formats = array("jpg", "png", "gif","jpeg");
                $foto_name = $pole['value']['name']; 
                $size = $pole['value']['size'] ; 
                if(strlen($foto_name)){
                    // break into name and extension
                    list($txt, $ext) = explode(".", $foto_name); 
                    if(in_array($ext, $valid_formats)){    
                        // Limit file size
                        if($size < (10000 * 1024)){ 
                            $actual_image_name = basename($pole['value']['name']);
                            $tmp = $pole['value']['tmp_name'];
                            if(move_uploaded_file($tmp, UPLOAD_FILE . $actual_image_name)){ 
                                return $pole['value']['name'];
                            }
                        }
                    }
                }
            }
        }
    }
}
?>