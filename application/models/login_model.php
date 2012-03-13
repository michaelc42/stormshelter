<?php

class Login_model extends CI_Model {
	public function checkLogin($name, $pass) 
	{	
		$this->load->database();		

		$error = 'The username or password is incorrect.';
						
		$query = $this->db->get_where('users', array('username'=>$name, 'password'=>$this->encryptPass($pass)));
		
		if ($query->num_rows == 1)
		{
			return TRUE;
		}
		
		return $error;
	}
	
	public function encryptPass($password)
	{
		//load libraries
		$this->load->library('encrypt');
		
		//$pass = $this->encrypt->sha1($password);
		return $this->encrypt->sha1($password);
	}
	
	public function startSession($name)
	{
		//set session data with username and logged_in = TRUE
		$sessionData = array(
			'username' => $name,
			'logged_in'=> TRUE,
		);
		$this->session->set_userdata($sessionData);
	}
}
