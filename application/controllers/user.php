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

	function index( $selected = NULL)
	{
		$this->authorized();
		
		$galleries = array();
		$this->load->model('Gallery_model');
		
		$data['galleries'] = $this->Gallery_model->getGalleriesList();
		$data['selected'] = $selected;
		
		$this->load->view('upload_form', $data);
	}
	

	function do_upload()
	{
		$this->authorized();
		
		$path = $this->input->post('galleries');
		$file = $this->input->post('userfile');
		$desc = $this->input->post('description');
		
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
			$this->Gallery_model->insertPicture($path, $this->upload->data(), $desc);

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
	
	/*
	function galleries()
	{
		$this->authorized();
		
		$data['errors'] = FALSE;
		
		$this->load->model('Gallery_model');
		
		$galleries = $this->Gallery_model->getGalleries();
	
		$data['galleries'] = $galleries;
		
		if ($data['galleries'] === FALSE)
		{
			$data['errors'] = 'Sorry, no galleries found.';
		}
		
		//load gallery
		$this->load->view('user_galleries_view', $data);
	}
	*/
	
	/* 
	 * If no galleryid is given, load all galleries
	 * else load the gallery with the id, and the offset it is given 
	 */
	function galleries($gallery = NULL, $off = 0)
	{	
		$limit = 8;
		$offset = $off;
		//$data = array();
		$data['errors'] = NULL;
		$data['ret'] = NULL;
		$data['pics'] = NULL;
		
		if( $gallery == NULL ) 
		{ 
			//load all galleries 
			$this->load->model('Gallery_model');
			$data['galleries'] = $this->Gallery_model->getGalleries();
			
			$this->load->view('user_galleries_view', $data);
			
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
				//get all pictures that have a gallery_id of $ret->id
				$totalPics = $this->Gallery_model->getPictures($ret[0]->id, NULL, $offset);
				$pics = $this->Gallery_model->getPictures($ret[0]->id, $limit, $offset);
				
				if( $pics === FALSE )
				{
					$data['errors'] = 'This gallery contains no pictures.';
					//Pass gallery info anyways
					$data['ret'] = $ret;
				}
				else
				{		
					$this->load->library('pagination');
					$config['base_url'] = site_url('user/galleries').'/'.$ret[0]->id.'/';
					$config['total_rows'] = count($totalPics);
					$config['per_page'] = $limit;
					//user controller needs uri_segment of four because 'url/user/gall.../id/offset'
					$config['uri_segment'] = 4;
				
					$this->pagination->initialize($config);
					$data['pics'] = $pics;
					$data['ret'] = $ret;
				}
			}
			$this->load->view('user_gallery_view', $data);
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
				$data['saved'] = 0;
				
				$titleInput = $this->input->post('title');
				$descInput = $this->input->post('description');
				
				if ( $descInput != NULL  ) { $data['saved'] = 1; }
				
				//update info if it changed
				if ( is_string( $descInput ) && $pic[0]->description != $descInput )
				{
					if ( $this->Gallery_model->updatePicture( 
						$pic[0]->id,
						$pic[0]->gallery_id,
						$pic[0]->title,
						$descInput))
					{
						$data['picDesc'] = $descInput;
					}
					else
					{
						$data['errors'] = 'Data could not be updated';
					}
				}
				
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
		
		$this->load->view('user_photo_view', $data);
		
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
	
	function deleteGallery( $id = NULL )
	{
		$this->authorized();
		
		$data['errors'] = '';
	
		if ( $id )
		{
			$this->load->model('Gallery_model');
			
			if ( $ret = $this->Gallery_model->doesGalleryExist($id) )
			{
				if ( $this->Gallery_model->deleteGallery($id, $ret[0]->directory_name) )
				{
					$data['errors'] = 'Gallery could not be deleted.';
				}
			}
			else
			{
				$data['errors'] = 'Gallery does not exists';
			}
		}
		else
		{
			$data['errors'] = 'No gallery given.';
		}
		
		//$this->load->view('user_delete_confirm');
		$this->load->view('user_delete_gallery_view', $data);		
	}
	
	function confirmDelete($id)
	{
		$this->authorized();
		$data['id'] = $id;
		$this->load->view('user_confirm_delete_view', $data);
	}
	
	function deletePhoto($id = NULL)
	{
		$this->authorized();
		
		$data['errors'] = '';
		
		if( $id )
		{
			$this->load->model('Gallery_model');
			
			if ( $ret = $this->Gallery_model->deletePhoto( $id ) )
			{
				$data['errors'] = $ret;
			}
		}
		else
		{
			$data['errors'] = 'No ID given.';
		}
		
		echo 'You have deleted the photo with the id '.$id;
		
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
