<?php namespace Jeffs;

use Jeffs\Database;

class Auth
{
	protected $db;
	protected $session_name = 'user_id';
	
	
	function __construct(Database $conn)
	{
		$this->db = $conn;
	}
	
	
	/*
	 * Login user
	 *
	 */
	public function login(array $user_data)
	{
		// Post data
		$email    = trim(htmlspecialchars($user_data['email']));
		$password = trim(htmlspecialchars($user_data['password']));
		
		// basic meh! encryption
		$encrypt  = sha1($password);
		
		
		// Select user data from "users" table
		$user = $this->db->table('users')->where('email', '=', $email)->first();
		
		
		// check if wer have a user row
		$is_user = $this->db->num_rows;
		
		
		// If user existed and user creditentials match, start user session
		if ($is_user > 0 && $encrypt === $user->password)
		{
			$_SESSION[$this->session_name] = $user->user_id;
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/*
	 * Logout user
	 *
	 */
	public function logout()
	{
		if ($this->check())
		{
			if (isset ($_COOKIE[session_name()])) 
			{
				setcookie(session_name(), '', time()-300, '/');
			}
			
			session_destroy();
			
			return true;
		}
	}
	
	
	/*
	 * Check if user is logged in
	 *
	 */	
	public function check()
	{
		return isset($_SESSION[$this->session_name]);
	}
	
	
	/*
	 * User data
	 *
	 */
	public function user()
	{
		$user_id = (int) $_SESSION[$this->session_name];
		
		$user = $this->db->table('users')->where('user_id', '=', $user_id)->first();
		
		return $user;
	}
}
?>