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
		//echo 'Test';
		//print_r($this->session->all_userdata());
		$query = $this->db->get_where('galleries', array( 'title'=>'Mike',));
		print_r($query);
	}
	
	function login()
	{		
		$data = FALSE;
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'required');		
		$this->form_validation->set_rules('password', 'Password', 'required');
	
		//If user is not logged in and did not fill out the form correctly echo validation errors
		if(!($this->session->userdata('logged_in')) && $this->form_validation->run() === FALSE)
		{
			$data['errors'] = validation_errors();
		}
		else //else check to see if the username and pw are correct
		{
			$this->load->model('Login_model');
			//if name and pw are incorrect function returns an error message
			$ret = $this->Login_model->checkLogin($this->input->post('username'), $this->input->post('password'));
			
			if ( $ret === TRUE )
			{
				$this->Login_model->startSession($this->input->post('username'));
			}
			else
			{
				$data['errors'] = $ret;
			}
		}		
		$this->load->view('login_view', $data);
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
		
		if ($data['galleries'] === FALSE)
		{
			$data['errors'] = 'Sorry, no galleries found.';
		}
		
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
		
		$data['errors'] = FALSE;
		
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('gallery-name', 'Gallery Title', 'required');
		
		$title = $this->input->post('gallery-name');
		$description = $this->input->post('gallery-description');
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['errors'] = validation_errors();
		}
		else
		{
			$this->load->model('Gallery_model');
			$ret = $this->Gallery_model->addGallery($title, $description);
			if ($ret === FALSE)
			{
				$data['errors'] = "Gallery already exists.";
			}
			else
			{
				$data['errors'] = FALSE;
			}
		}	
		
		$this->load->view('new_gallery_view', $data);
		
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
