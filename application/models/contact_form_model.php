<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_form_model extends CI_Model {

	protected $adminEmail = 'f5stormrooms@yahoo.com';

	public function sendMessage($fromEmail, $fromName, $fromPhone, $message)
	{
		//finish the message
		$message = 'Contact Details:'.'<br />'.$message.'<br />'.$fromName.'<br />'.$fromEmail.'<br />'.$fromPhone;

		$this->load->library('email');		
		
		/*
		$config['protocol'] = "smtp";
		$config['smtp_host'] = "ssl://smtp.gmail.com";
		$config['smtp_port'] = "465";
		$config['smtp_user'] = $this->adminEmail;//also valid for Google Apps Accounts
		$config['smtp_pass'] = "";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";

		$config['validate'] = "TRUE";
		$config['newline'] = "\r\n";
		*/		

		$mailConfig['protocol'] = "smtp";
		$mailConfig['smtp_host'] = "relay-hosting.secureserver.net";
		$mailConfig['smtp_user'] = "admin@f5stormrooms.com";
		$mailConfig['smtp_pass'] = "";
		$mailConfig['smtp_port'] = "25";
		$mailConfig['mailtype'] = "html";
		$mailConfig['validate'] = "TRUE";

		$this->email->initialize($mailConfig);        
				
		$this->email->from("admin@f5stormrooms.com");
		$this->email->to($this->adminEmail);
		$this->email->subject("A new contact from F5 Stormrooms...");
		$this->email->message($message); //Your cool html5 ;P
		$this->email->set_alt_message(strip_tags($message)); //Only text
				
		if ( ! $this->email->send())
		{
			show_error($this->email->print_debugger());
			return FALSE;
		} else {
			return TRUE;        
		} 
	}
}
