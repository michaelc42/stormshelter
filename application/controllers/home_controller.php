<?php

class Home_controller extends CI_Controller
{
	public function index()
	{
		//this is the view to load in the template
		$data['main_content'] = 'home_view';
		$data['active_page'] = 'index';
		//data to pass to view
		$data['title'] = 'Home';
		
		$this->load->view('includes/template', $data);
	}
	
	public function portfolio()
	{
		//this is the view to load in the template
		$data['main_content'] = 'portfolio_view';
		$data['active_page'] = 'portfolio';
		//data to pass to view
		$data['title'] = 'Portfolio';	
		$this->load->view('includes/template', $data);
	}
	
	
	public function about()
	{
		//this is the view to load in the template
		$data['main_content'] = 'home_view';
		$data['active_page'] = 'about';
		//data to pass to view
		$data['title'] = 'About';	
		$this->load->view('includes/template', $data);
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
			$data['main_content'] = 'login_view';
			$data['active_page'] = '';
			//data to pass to view
			$data['title'] = 'Login';
			$data['errors'] = validation_errors();	
			$this->load->view('includes/template', $data);
			
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
			redirect('home_controller/index');
		}
		else
		{
			//load wrong password view.
			$data['main_content'] = 'login_view';
			$data['active_page'] = '';
			//data to pass to view
			$data['title'] = 'Login';
			$data['errors'] = $login;	
			$this->load->view('includes/template', $data);
		}
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		print_r($this->session->all_userdata());
		redirect('home_controller/');
	}
	
	public function user($username = NULL) {
		if(!$username)
		{
			redirect('home_controller/index');
		}
		
		//get user data
		$this->load->model('User_data_model');
		$userdata = $this->User_data_model->getUserData($username);
		
		if ($userdata) {
			//load view and pass data
			$data['main_content'] = 'profile_view';
			$data['title'] = 'Profile';
			$data['active_page'] = '';
			$data['userdata'] = $userdata;
			$this->load->view('includes/template', $data);
		}
		
		//ready data to pass to view
		
		//load view with data
	}
	
	public function subscribe() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
			//on validation insert email into db
			$this->load->model('Subscribe_model');		
			$this->Subscribe_model->subscribe($this->input->post('email'));			
			echo 'You have been added to out mailing list!';
		}
	
	}
	
	public function message()
	{
		$this->load->library('form_validation');
		$fromEmail = $this->input->post('email');
		$fromName = $this->input->post('name');
		$message = $this->input->post('message');
		
		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('message', 'Message', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
			$this->load->model('Message_model');
			$this->Message_model->sendMessage($fromEmail, $fromName, $message);
		}
	}
	
	public function calculator()
	{		
		$this->load->view('calculator');
	}
	
	public function calculate()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('length', 'Length', 'required|numeric');
		$this->form_validation->set_rules('width', 'Width', 'required|numeric');
		$this->form_validation->set_rules('height', 'Height', 'required|numeric');
		$this->form_validation->set_rules('location', 'location', 'required');
		
		$length = $this->input->post('length');
		$width = $this->input->post('width');
		$height = $this->input->post('height');
		$location = $this->input->post('location');
		
		$surfaceArea = 2*$length*$width + 2*$length*$height + 2*$height*$width;
		
		$this->load->model('Distance_calc_model');
		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
		else
		{
			echo 'The cost will be '.$cost = '$'.$this->Distance_calc_model->getTotalCost($location, $surfaceArea);
		}
	}
	
}
