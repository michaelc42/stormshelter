<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_form_model extends CI_Model {

	protected $adminEmail = 'admin@f5stormrooms.com';

	public function sendMessage($fromEmail, $fromName, $fromPhone, $message)
	{
		//finish the message
		$message = 'Contact Details:'.'<br />'.$message.'<br />'.$fromName.'<br />'.$fromEmail.'<br />'.$fromPhone;

		$this->load->library('email');		

		$config['protocol'] = "smtp";
		$config['smtp_host'] = "relay-hosting.secureserver.net";
		$config['smtp_port'] = "25";
		$config['smtp_user'] = $this->adminEmail;//also valid for Google Apps Accounts
		$config['smtp_pass'] = "temporary";
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";

		$config['validate'] = "TRUE";
		$config['newline'] = "\r\n";

		$this->email->initialize($config);        
				
		$this->email->from("admin@f5stormrooms.com");
		$this->email->to('f5stormrooms@yahoo.com');
		$this->email->subject("A new contact from F5 Stormrooms...");
		$this->email->message($message); //Your cool html5 ;P
		$this->email->set_alt_message(strip_tags($message)); //Only text
				
		if ( ! $this->email->send())
		{
			//show_error($this->email->print_debugger());
			return FALSE;
		} else {
			return TRUE;        
		} 
	}
}
