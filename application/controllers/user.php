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
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
	}

	function index()
	{
		$this->authorized();
		
		$galleries = array();
		$this->load->model('Gallery_model');
		
		$data['galleries'] = $this->Gallery_model->getGalleriesList();
		
		$this->load->view('upload_form', $data);
	}
	

	function do_upload()
	{
		$this->authorized();
		
		$path=$this->input->post('galleries');
		$file = $this->input->post('userfile');
		
		$config['upload_path'] = './uploads/'.$path.'/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '4000';
		$config['max_width']  = '1024';
		$config['max_height']  = '1024';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$this->load->model('Gallery_model');
			//when the picture upload is successful insert data into db
			$this->Gallery_model->insertPicture($path, $this->upload->data());

			$this->load->view('upload_success', $data);
		}
	}
	
	function admin()
	{
		$this->authorized();
		
		$this->load->view('admin_view');
	}
	
	/*
	function index()
	{
		//echo 'Test';
		//print_r($this->session->all_userdata());
		$query = $this->db->get_where('galleries', array( 'title'=>'Mike',));
		print_r($query);
	}
	*/
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
		$this->authorized();
		
		$data['errors'] = FALSE;
		
		$this->load->model('Gallery_model');
		
		$galleries = $this->Gallery_model->getGalleriesList();
	
		$data['galleries'] = $galleries;
		
		if ($data['galleries'] === FALSE)
		{
			$data['errors'] = 'Sorry, no galleries found.';
		}
		
		//load gallery
		$this->load->view('gallery_view', $data);
	}
	
	function addGallery()
	{
		$this->authorized();
		
		$data['errors'] = FALSE;
		$data['success'] = FALSE;
		
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
				$data['success'] = 'Gallery has been created.';
			}
		}	
		
		$this->load->view('new_gallery_view', $data);
		
	}
/*	
	function addPhoto()
	{
		$this->authorized();
		
		$gallery = $this->input->post('galleries');
		
		$picture = $this->input->post('picture');
		
		$this->load->model('Gallery_model');
		
		$data['galleries'] = $this->Gallery_model->getGalleries();
		
		//$this->Gallery_model->addPhoto($gallery, $picture);
		
		$config['upload_path'] = './uploads/' . $gallery;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '111100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
			
		$this->load->library('upload', $config);
		
		$this->upload->do_upload($picture);
		$this->upload->display_errors();
		$this->upload->data();	
		
		//load gallery
		$this->load->view('add_photo_view', $data);
	}
*/

	function authorized()
	{
		if ( $this->session->userdata('logged_in') === FALSE)
		{
			//redirect to login page
			echo 'Not authorized';
			break;
		}
	}
	
	function robot_check($robotest)
	{
		if($robotest)
		{
			$this->form_validation->set_message('robot_check', 'No bots allowed');
			$this->load->model('Logger_model');
			$this->Logger_model->ipLogger($this->input->ip_address());
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}
