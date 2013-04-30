<?php

class Resize_Image {

    var $image_to_resize;
    var $new_width;
    var $new_height;
    var $ratio;
    var $new_image_name;
    var $save_folder;


    function resize() {
        
        if(!file_exists($this->image_to_resize))
            exit("File ".$this->image_to_resize." does not exist.");

        $info = GetImageSize($this->image_to_resize);

        if(empty($info))
            exit("The file ".$this->image_to_resize." doesn't seem to be an image.");

        $width = $info[0];
        $height = $info[1];
        $mime = $info['mime'];

        /* Keep Aspect Ratio? Improved, thanks to Larry*/
        if($this->ratio) {
            
            // if preserving the ratio, only new width or new height
            // is used in the computation. if both are set, use width
            if (isset($this->new_width)) {
                $factor = (float)$this->new_width / (float)$width;
                $this->new_height = $factor * $height;
            }
            else if (isset($this->new_height)) {
                $factor = (float)$this->new_height / (float)$height;
                $this->new_width = $factor * $width;
            }
            else {
                exit("neither new height or new width has been set");
            }
        }

        // What sort of image?
        $type = substr(strrchr($mime, '/'), 1);

        $image_create_func = 'ImageCreateFromJPEG';
        $image_save_func = 'ImageJPEG';
        $new_image_ext = 'jpg';

        // New Image
        $image_c = ImageCreateTrueColor($this->new_width, $this->new_height);

        $new_image = $image_create_func($this->image_to_resize);

        ImageCopyResampled($image_c, $new_image, 0, 0, 0, 0, $this->new_width, $this->new_height, $width, $height);

        if($this->save_folder) {
            if($this->new_image_name)
                $new_name = $this->new_image_name.'.'.$new_image_ext;
            else
                $new_name = $this->new_thumb_name( basename($this->image_to_resize) ).'_resized.'.$new_image_ext;
            $save_path = $this->save_folder.$new_name;
		}
		else {
            //These two lines taken from above.
            $new_name = $this->new_image_name.'.'.$new_image_ext;
            $save_path = $this->save_folder.$new_name;
            
            /* Show the image without saving it to a folder */
            //header("Content-Type: ".$mime);
            //$image_save_func($image_c);
            //$save_path = '';
		}

	    $process = $image_save_func($image_c, $save_path);

		return array('result' => $process, 'new_file_path' => $save_path);

	}

	function new_thumb_name($filename) {
        $string = trim($filename);
        $string = strtolower($string);
        $string = trim(ereg_replace("[^ A-Za-z0-9_]", " ", $string));
        $string = ereg_replace("[ tnr]+", "_", $string);
        $string = str_replace(" ", '_', $string);
        $string = ereg_replace("[ _]+", "_", $string);

        return $string;
	}
}
?>