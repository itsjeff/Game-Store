<?php namespace Jeffs;

class Image
{
	// Source Image
	public $image_src   = '';	
	public $image_type  = '';
	public $orig_height = 0;
	public $orig_width  = 0;
	
	// New Properties
	public $quality = 90;
	public $height  = 250;
	public $width   = 250;

	public $new_height  = 0;
	public $new_width   = 0;		
	public $x_axis      = 0;
	public $y_axis      = 0;
	
	public $crop = false;
	
	
	/*
	 * Resize Image
	 *
	 */
	public function resize($src_image, $dst_image) 
	{
		// Image source
		$this->image_src = $src_image;
		
		
		// Image properties
		$this->get_image_properties();
		
		
		// Image handler
		$resource = $this->image_handler();
		
		
		// Calculate new image dimensions 
		if ($this->orig_width > $this->orig_height) 
		{
			$new_width  = floor($this->orig_width * ($this->width / $this->orig_height));
			
			$new_height = $this->height;
		} 
		else 
		{
			$new_width  = $this->width;
			
			$new_height = floor($this->orig_height * ($this->height / $this->orig_width));
		}
		
		
		// Blank image
		$blank_image = imagecreatetruecolor($new_width, $new_height); 
		
		
		// Maintain png transparency
		if ($this->image_type == 'png')
		{
			imagealphablending($blank_image, FALSE);
			imagesavealpha($blank_image, TRUE);
		}
		
		
		imagecopyresampled($blank_image, $resource, 0, 0, $this->x_axis, $this->y_axis, $new_width, $new_height, $this->orig_width, $this->orig_height);
		
		
		// Save new image
		$this->image_save($blank_image, $dst_image);
	}
	

	/*
	 * Image Handler
	 *
	 */	
	protected function image_handler()
	{

		if ($this->image_type == 'gif') 
		{
			return imagecreatefromgif($this->image_src);
		} 
		else if ($this->image_type == 'jpg') 
		{
			return imagecreatefromjpeg($this->image_src);
		}
		else if ($this->image_type == 'png') 
		{
			return imagecreatefrompng($this->image_src);
		} 
	}

	
	/*
	 * Image Display
	 *
	 */	
	protected function image_save($blank_image, $dst_image)
	{
		if($this->image_type == 'gif') 
		{
			imagegif($blank_image, $dst_image);
		}
		else if ($this->image_type == 'jpg') 
		{
			imagejpeg($blank_image, $dst_image, $this->quality);
		}
		else if ($this->image_type == 'png') 
		{
			imagepng($blank_image, $dst_image);
		} 
	}
	

	/*
	 * Get image properties
	 *
	 */	
	protected function get_image_properties()
	{
		// Get Image Values
		$val = getimagesize($this->image_src);	
		
		
		// Image Properties
		$this->image_type  = pathinfo($this->image_src, PATHINFO_EXTENSION);
		$this->orig_width  = $val[0];
		$this->orig_height = $val[1];

	}
}
?>