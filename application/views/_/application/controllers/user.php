<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*****************************************
 * This controller limits access to
 * all specialized site activies
 * user must be logged in and authorized.
 *****************************************/ 
class User extends CI_Controller {
	/*function __contruct(){
		parent::__construct();

	}*/
	
	function index()
	{
		echo 'Test';
		print_r($this->session->all_userdata());
	}
	
	function login()
	{		
		//load libraries
		
		//test data
		$name = 'mike42';
		$pass = 'michael1';
		
		//end test data
		
		$this->load->model('Login_model');

		echo 'Login model loaded';
		
		$login = $this->Login_model->checkLogin($name, $pass);
		
		if ( $login === TRUE )
		{
			$this->Login_model->startSession($name);
			print_r($this->session->all_userdata());
			echo 'Session Started';
		}
		else
		{
			//output any errors checkLogin returned
			echo $login;
		}
	}
	
	function logout()
	{
		if ( $this->session->userdata('logged_in') === TRUE)
		{
			$this->session->sess_destroy();
			echo 'Session Destroyed';
			return;
		}
		echo 'Not logged in';
	}
	
	function galleries()
	{
		if ( $this->session->userdata('logged_in') === FALSE)
		{
			//redirect to login page
			echo 'Not authorized';
			return;
		}
		
		$this->load->model('Gallery_model');
		
		$data['galleries'] = $this->Gallery_model->getGalleries();
		
		//load gallery
		$this->load->view('gallery_view', $data);
	}
	
	function addGallery()
	{
		if ( $this->session->userdata('logged_in') === FALSE)
		{
			//redirect to login page
			echo 'Not authorized';
			return;
		}
		
		$title = $this->input->post('gallery-name');
		$description = $this->input->post('gallery-description');
		
		if ($title)
		{
			$this->load->model('Gallery_model');
		
			$return = $this->Gallery_model->addGallery($title, $description);
		}	
		
		$this->load->view('new_gallery_view');
		
	}
	
	function addPhoto()
	{
		if ( $this->session->userdata('logged_in') === FALSE)
		{
			//redirect to login page
			echo 'Not authorized';
			return;
		}
		
		$this->load->model('Gallery_model');
		
		$data['galleries'] = $this->Gallery_model->getGalleries();
		
		//load gallery
		$this->load->view('add_photo_view', $data);
	}
}
