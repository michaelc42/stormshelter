<?php

class Login_model extends CI_Model {
	/*
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
	*/
	/* This function uses phpass with bcrypt */
	public function checkLogin( $name, $pass )
	{
		$this->load->database();		
		$this->load->library('PasswordHash');
		$error = 'The username or password is incorrect.';
		
		$pHash = new PasswordHash();
				
		$query = $this->db->get_where('users', array('username'=>$name,));
		$row = $query->row();
		
		if ( $query->num_rows == 1 )
		{
			$check = $pHash->CheckPassword($pass, $row->password);
			if ( $check )
			{
				return TRUE;
			}
		}
		return $error;
		//check the user input unhased password with the hashed
		//password retrieved from the database
		
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
