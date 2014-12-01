<?php namespace Jeffs;

class Validate
{
	public $error      = array();	
	public $wrap_start = '<p class="error">';
	public $wrap_end   = '</p>';
	public $success    = false;
	
	
	/*
	 * Rules
	 *
	 */
	public function rules($rules = array())
	{
		if (count($_POST) > 0)
		{
			foreach ($rules as $key => $value)
			{
				$this->execute_rule($key, $value);
			}
		}
	}
	

	/*
	 * Check
	 *
	 */
	public function check()
	{
		if(count($this->error) > 0)
		{
			return false;
		}
		else
		{
			$this->success = true;
			
			return true;
		}
	}
	
	
	/*
	 * Execute rule - Required
	 *
	 */		
	protected function execute_rule($field, $rule)
	{
		$rules = explode('|', $rule);
		
		foreach ($rules as $rule)
		{
			if (count($this->error[$field]) < 1)
			{
				$this->$rule($field);
			}
		}
	}
	
	
	/*
	 * Show error message
	 *
	 */		
	public function show_error($field = null)
	{
		if (isset($_POST))
		{
			if (! empty($field))
			{
				return $this->wrap_start . $this->error[$field] . $this->wrap_end;
			}
			else
			{
				return $this->error;
			}
		}
	}
	
	/*
	 * Set error message by user
	 *
	 */		
	public function set_message($key, $message)
	{
		$this->error[$key] = $message;
	}
	
	
/* ------------------------------------------------------------------------------------------- */
	

	/*
	 * Rule - Required
	 *
	 */	
	protected function required($key)
	{
		if (trim($_POST[$key]) == '')
		{
			$this->error[$key] = ucwords($key) . ' field is required.';
		}
	}
	
	
	/*
	 * Rule - Valid email
	 *
	 */	
	protected function email($key)
	{
		if (! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $_POST[$key])) 
		{
			$this->error[$key] = ucwords($key) . ' field is not a valid email.';
		}
	}
	
	
	/*
	 * Rule - Numeric
	 *
	 */	
	protected function numeric($key)
	{
		if (! is_numeric($_POST[$key]))
		{
			$this->error[$key] = ucwords($key) . ' field is not a valid number.';
		}
	}
}
?>