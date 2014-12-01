<?php namespace Jeffs;

class File 
{
	public $file_path = '';			// file's current location
	
	public $file_name = '';			// file's name	
	
	public $file_dest = '';			// files new destination ie. /folder/
	
	public $file_rename = null;		// if null, don't rename
	
	public $file_ext = '';			// file extension
	
	
	
	/*
	 * File Upload
	 *
	 */
	public function file_upload() 
	{
		// check if dir exists, if not, create one
		if (! file_exists($this->file_dest)) 
		{
			mkdir($this->file_dest, 0777, true);
		}
		
		// if is fine then upload
		if (move_uploaded_file($this->file_path, $this->file_dest . $this->file_name)) 
		{		
			if ($this->file_rename) 
			{
				$this->rename();
			}
			
			return true;
		} 
		else 
		{
			return false;
		}
	}
	

	/*
	 * File Extension
	 *
	 */
	public function file_extension() 
	{
		$this->file_ext = '.' . pathinfo($this->file_dest . $this->file_name, PATHINFO_EXTENSION);
	}

	
	/*
	 * Rename file
	 *
	 */
	public function rename() 
	{
		// Get file extension
		$this->file_extension();	
		
		
		// old and new name
		$old_name = $this->file_dest . $this->file_name;
		$new_name = $this->file_dest . $this->file_rename . $this->file_ext;
		
		
		// Rename file
		rename($old_name, $new_name);
		
		$this->file_name = $this->file_rename . $this->file_ext;
	}
	
	/*
	 * Remove file
	 *
	 */
	public function remove($file_path)
	{
		if (file_exists($file_path))
		{
			unlink($file_path);
		}
	}
}
?>