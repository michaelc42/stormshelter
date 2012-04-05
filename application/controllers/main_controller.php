<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_controller extends CI_Controller
{
	function index()
	{
		$data['errors'] = FALSE;
		$data['success'] = FALSE;
		$data['main_content'] = 'home_view';
	
		$this->load->view('includes/template', $data);
	}
	
	public function message()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Name', 'required');		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('areacode', 'Area Code', 'required|numeric');
		$this->form_validation->set_rules('phone1', 'Phone', 'required|numeric');
		$this->form_validation->set_rules('phone2', 'Phone', 'required|numeric');
		$this->form_validation->set_rules('message', 'Message', 'required');
		$this->form_validation->set_rules('robotest', '', 'callback_robot_check');

		
		$data['errors'] = FALSE;
		$data['success'] = FALSE;
		
		if ($this->form_validation->run() == FALSE)
		{
			$data['errors'] = validation_errors();
			$data['main_content'] = 'home_view';		
			$this->load->view('includes/template', $data);
		}
		else
		{
			$this->load->model('Contact_form_model');
	
			if( 
				$this->Contact_form_model->sendMessage(
					$this->input->post('email'),
					$this->input->post('name'),
					$this->input->post('areacode').$this->input->post('phone1').$this->input->post('phone2'),
					$this->input->post('message')
				)				
			  )
			{
				$data['success'] = TRUE;
				$data['main_content'] = 'home_view'; //load success page
				$this->load->view('includes/template', $data);
			}
			else
			{
				$data['errors'] = 'Info could not be sent.  Please try again.';
				$data['main_content'] = 'home_view';
				$this->load->view('includes/template', $data);
			}
		}
	}
	
	/* Form validation callback function */
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
	
	function pageNotFound()
	{
		echo 'Page not found.';
	}
	
	/*
	 * Functions pertaining to the gallery 
	 */
	function galleries($gallery = NULL, $off = 0)
	{	$limit = 8;
		$offset = $off;
		$data = array();
		$data['errors'] = NULL;
		$data['ret'] = NULL;
		$data['pics'] = NULL;
		
		if( $gallery == NULL ) 
		{ 
			//load all galleries 
			$this->load->model('Gallery_model');
			$data['galleries'] = $this->Gallery_model->getGalleries();
			
			$this->load->view('all_galleries_view', $data);
			
		}
		else
		{
			$this->load->model('Gallery_model');
			//returns gallery data if gallery exists else false
			$ret = $this->Gallery_model->doesGalleryExist($gallery);
			if( $ret === FALSE )
			{
				$data['errors'] = 'Gallery not found.';
			}
			else
			{ 
				// get pictures
				//$this->load->view('gallery_view');
				//get all pictures that have a gallery_id of $ret->id
				$totalPics = $this->Gallery_model->getPictures($ret[0]->id, NULL, $offset);
				$pics = $this->Gallery_model->getPictures($ret[0]->id, $limit, $offset);
				
				if( $pics === FALSE )
				{
					$data['errors'] = 'This gallery contains no pictures.';
					echo 'This gallery contains no pictures';
				}
				else
				{		
					$this->load->library('pagination');
					$config['base_url'] = site_url().'galleries/'.$ret[0]->id.'/';//'http://localhost/stormshelter/galleries/'.$ret[0]->id.'/';
					$config['total_rows'] = count($totalPics);
					$config['per_page'] = $limit;
				
					$this->pagination->initialize($config);
					$data['pics'] = $pics;
					$data['ret'] = $ret;
				}
			}
			$this->load->view('gallery_view', $data);
		}
	}
	
	function photo($id = NULL)
	{
		$data['errors'] = NULL;
		if ( $id )
		{
			$this->load->model('Gallery_model');
			$pic = $this->Gallery_model->getPhoto($id);
			if( $pic )
			{	
				$gallery = $this->Gallery_model->getGalleryById( $pic[0]->gallery_id );
				
				$data['path'] = site_url().'uploads/'.$gallery[0]->title.'/'.$pic[0]->title;
				$data['picTitle'] = $pic[0]->title;
				$data['picDesc'] = $pic[0]->description;
				$data['picID'] = $pic[0]->id;
				
			}
			else
			{
				$data['errors'] = 'No photo found.';
			}
		}
		else
		{
			$data['errors'] = 'No ID given.';
		}
		
		$this->load->view('photo_view', $data);
		
	}
}

/* End of file main_controller.php */ 
/* Location: ./application/controllers/main_controller.php */
