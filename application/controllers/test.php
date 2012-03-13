<?php

class Test extends CI_Controller
{
    public function index()
    {
        echo 'Hello World';
        
		print_r($this->session->all_userdata());
		
		$this->load->view('upload_form', array('error' => ' ' ));
    }
    
   	public function login()
	{	
		$errors = FALSE;
		
		$this->load->library('encrypt');
		//validate form		
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			//load wrong password view.
			
			$data['errors'] = validation_errors();	
			$this->load->view('login_view', $data);
			return;
			
		}

		//get post data from login form
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		//hash password is 40 chars long
		$passwordhashed = $this->encrypt->sha1($password);
				
		//use a model to check to make sure the user is authorized
		$this->load->model('Login_model');
		//checkLogin returns error msg if no match is found
		$login = $this->Login_model->checkLogin($username, $passwordhashed);
		
		//start new session if user login is correct
		if ($login === TRUE){
			$session = $this->Login_model
				->startSession($username);
			redirect('test/index');
		}
		else
		{
			//load wrong password view.
			$data['errors'] = $login;	
			$this->load->view('login_view', $data);
		}
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		print_r($this->session->all_userdata());
		redirect('test/');
	}
	
	
	//slated for removal
	function do_upload()
	{
		
		$query = $this->db->get('galleries');
		
		$galleries = array();
		
		foreach ($query->result() as $row)
		{
			$galleries[$row->directory_name] = $row->title;
		}
		
		$data['galleries'] = $galleries;
		
		echo $directory = $this->input->post('galleries');
		
		$config['upload_path'] = './uploads/'.$directory;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$data['errors'] = $error = array('error' => $this->upload->display_errors());

			$this->load->view('upload_form', $data);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('upload_success', $data);
		}
	}
	
	function gallery()
	{
		$query = $this->db->get('galleries');
		
		$galleries = array();
		
		foreach ($query->result() as $row)
		{
			$galleries[$row->directory_name] = $row->title;
		}
		
		$data['galleries'] = $galleries;
		
		$directory = $this->input->post('galleries');
		
		echo $config['upload_path'] = './uploads/'.$directory;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '4000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$data['errors'] = $error;
			
			$this->load->view('gallery_view', $data);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$this->load->view('gallery_view', $data);
		}
	
	}
	
	function addPhoto()
	{
		
	}
	
	function new_gallery()
	{
		$this->load->view('new_gallery_view');
	}
	
	function create_gallery()
	{
		$title = $this->input->post('gallery-name');
		$description = $this->input->post('gallery-description');
		
		echo $titleclean = preg_replace("/[^A-Za-z0-9]/","_",$title);
		
		$url = './uploads/'.$titleclean;
		
		if(mkdir($url, 777))
		{
			$data = array(
			   'directory_name' => $titleclean,
			   'title' => $title,
			   'description' => $description,
			);
			echo 'Success!';
			$this->db->insert('galleries', $data);
			//redirect('test/gallery');
		}
		else
		{
			echo 'Failure';
		}
		
	}

}
