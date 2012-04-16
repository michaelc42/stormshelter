<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** * User
 * @author Michael W. Casey 
 * @link www.f5stormrooms.com
 */
/*****************************************
 * This controller limits access to
 * all specialized site activies
 * user must be logged in and authorized.
 *****************************************/ 
class User extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		
		//delete after debugging
		//$this->output->enable_profiler(TRUE);
	}

	function index()
	{
		$this->admin();
	}
	
	//new code
	function add_photo( $selected = NULL )
	{
		$this->authorized();
		
		//$galleries = array();
		$this->load->model('Gallery_model');
		
		$data['galleries'] = $this->Gallery_model->getGalleriesList();
		$data['selected'] = $selected;
		$data['main_content'] = 'upload_form';
		$data['title'] = 'Add a Photo';
		$data['css'] = 'style.css';
		$data['errors'] = FALSE;
		
		$path = $this->input->post('galleries');
		$file = $this->input->post('userfile');
		$desc = $this->input->post('description');

		//Upload settings
		$config['upload_path'] = './uploads/'.$path.'/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '4000';
		$config['max_width']  = '2048';
		$config['max_height']  = '2048';
		
		
		$this->load->library('upload', $config);
		
		if ( ! $this->upload->do_upload() )
		{	
			//test code, delete and uncomment previous line to revert	
			$data['errors'] = $this->upload->display_errors();//array('error' => $this->upload->display_errors());
			
		}
		else
		{
			$data['upload_data'] = $this->upload->data();
			//when the picture upload is successful insert data into db
			$this->Gallery_model->insertPicture($path, $this->upload->data(), $desc);
			
			//$data['main_content'] = 'upload_success_view';		
					
			//$this->load->view('includes/admin-template', $data);
		}	
		//end test code
		
		/*
		if ( $this->form_validation->run() === FALSE )
		{
			$data['errors'] = validation_errors();
		}
		elseif ( $this->input->post('galleries') === TRUE &&
				 $this->input->post('userfile') === TRUE &&
				 $this->input->post('description') === TRUE )
		{				
			$path = $this->input->post('galleries');
			$file = $this->input->post('userfile');
			$desc = $this->input->post('description');
	
			//Upload settings
			$config['upload_path'] = './uploads/'.$path.'/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '4000';
			$config['max_width']  = '2048';
			$config['max_height']  = '2048';

			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload() )
			{	
				//test code, delete and uncomment previous line to revert	
				$data['errors'] = $this->upload->display_errors();//array('error' => $this->upload->display_errors());
				
			}
			else
			{
				$data['upload_data'] = $this->upload->data();
				//when the picture upload is successful insert data into db
				$this->Gallery_model->insertPicture($path, $this->upload->data(), $desc);
				$data['success'] = 1;				
				
				//$data['main_content'] = 'upload_success_view';		
						
				//$this->load->view('includes/admin-template', $data);
			}
		}
		*/
		
		$this->load->view('includes/admin-template', $data);	
	}
	//end new code
	
	/*
	function addPhoto( $selected = NULL )
	{
		$this->authorized();
		
		$galleries = array();
		$this->load->model('Gallery_model');
		
		$data['galleries'] = $this->Gallery_model->getGalleriesList();
		$data['selected'] = $selected;
		$data['main_content'] = 'upload_form';
		$data['title'] = 'Add a Photo';
		$data['css'] = 'style.css';
		
		$this->load->view('includes/admin-template', $data);
	}
	

	function do_upload()
	{
		$this->authorized();
		
		$data['css'] = 'style.css';
		$data['title'] = 'Uploading';
		
		$path = $this->input->post('galleries');
		$file = $this->input->post('userfile');
		$desc = $this->input->post('description');
		
		$config['upload_path'] = './uploads/'.$path.'/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '4000';
		$config['max_width']  = '2048';
		$config['max_height']  = '2048';

		$this->load->library('upload', $config);


		//Form Validation
		$this->load->library('form_validation');	
		$this->form_validation->set_rules('userfile', 'File', 'required');		
		$this->form_validation->set_rules('galleries', 'Gallery', 'required');
		
		if (  !( $this->form_validation->run() ) )
		{
			$data['errors'] = validation_errors();
		}
		//new code ^

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			//$this->load->view('upload_form', $error);
			
			//test code, delete and uncomment previous line to revert	
			$data['error'] = $error;
			//$data['main_content'] = 'upload_success'; //upload_form
			//$this->load->view('includes/admin-template', $data);
		}
		else
		{
			$data['upload_data'] = $this->upload->data();
			$this->load->model('Gallery_model');
			//when the picture upload is successful insert data into db
			$this->Gallery_model->insertPicture($path, $this->upload->data(), $desc);
		
			//$data['main_content'] = 'upload_success';
			
			//$this->load->view('includes/admin-template', $data);
		}
		
		//new code
		$data['main_content'] = 'upload_success';
		
		$this->load->view('includes/admin-template', $data);
	}
	*/
	
	function admin()
	{
		$this->authorized();
	
		$data['main_content'] = 'admin_view';
		$data['title'] = 'Admin Panel';
		$data['css'] = 'style.css';
		
		$this->load->view('includes/admin-template', $data);
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
				//redirect to admin page if user is validated
				redirect(site_url('user/admin'));
			}
			else
			{
				$data['errors'] = $ret;
			}
		}		
		$data['main_content'] = 'login_view';
		$data['title'] = 'Login';
		$data['css'] = 'style.css';
		
		$this->load->view('includes/admin-template', $data);
	}
	
	function logout()
	{
		if ( $this->authorized() )
		{
			$this->session->sess_destroy();
			echo 'Session Destroyed';
			redirect( site_url() );
			return;
		}
		else
		{
			echo 'Not logged in';
		}
	}
	
	/* 
	 * If no galleryid is given, load all galleries
	 * else load the gallery with the id, and the offset it is given 
	 */
	function galleries($off = 0)//($gallery = NULL, $off = 0)
	{	
		$this->authorized();
		
		$limit = 4;
		$offset = $off;
		//$data = array();		
		
		//next two lines test line
		//template variables
		$data['css'] = 'admin_gallery.css';
		$data['main_content'] = 'user_galleries_view';
		$data['title'] = 'Galleries';
		
		$data['errors'] = NULL;
		$data['ret'] = NULL;
		$data['pics'] = NULL;
		$data['front_image'] = NULL;
		
		if( TRUE )//$gallery == NULL ) 
		{ 
			//load all galleries 
			$this->load->model('Gallery_model');
			//go through each gallery and replace the front_image(s) with the url to the thumbnails
			$total_galleries = $this->Gallery_model->getGalleries();
			$limited_galleries = $this->Gallery_model->getGalleries($limit, $offset);
			
			foreach( $limited_galleries as $gallery )
			{
				$pic = $this->Gallery_model->getPhoto( $gallery->front_image );
				
				if( $pic ) 
				{ 
					$thumb = $this->Gallery_model->get_thumb( $pic->title );
					
					$gallery->front_image = $thumb; 
				}
			}
			
			$this->load->library('pagination');
			$config['base_url'] = site_url('user/galleries');
			$config['total_rows'] = count($total_galleries);
			$config['per_page'] = $limit;
			//user controller needs uri_segment of 3 because 'url/user/galleries/offset'
			$config['uri_segment'] = 3;

			$this->pagination->initialize($config);
			
			$data['galleries'] = $limited_galleries;
			
			$this->load->view('includes/admin-template', $data);
			
		}
	}
	
	
	/*
	 * Load a single gallery.
	 */
	 function gallery( $gallery, $off = NULL )
	 {
		 
		$limit = 8;
		$offset = $off;
		$data['errors'] = NULL;
		 
		 $this->load->model('Gallery_model');
			//returns gallery data if gallery exists, else false
			$ret = $this->Gallery_model->doesGalleryExist($gallery);
			if( $ret === FALSE )
			{
				$data['errors'] = 'Gallery not found.';
				//show_404();
				//return;
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
					//run this if there are pictures for the gallery
					$this->load->library('pagination');
					$config['base_url'] = site_url('user/gallery').'/'.$ret[0]->id.'/';
					$config['total_rows'] = count($totalPics);
					$config['per_page'] = $limit;
					//user controller needs uri_segment of four because 'url/user/gall.../id/offset'
					$config['uri_segment'] = 4;
				
					$this->pagination->initialize($config);
					$data['pics'] = $pics;
					$data['ret'] = $ret;
					$data['front_image'] = $ret[0]->front_image;
					
					//if checkbox input exists update the gallery with the front image
					if ( $this->input->post('front_image') )
					{
						//update table and input the id for the front_picture
						if ( $this->Gallery_model->update_gallery( $gallery, $this->input->post('front_image')) == FALSE )
						{
							$data['errors'] = 'Could not set front image.';
						}
						else
						{
							$data['front_image'] = $this->input->post('front_image');
						}
					}
					
				}
			}
			
			
			$data['main_content'] = 'user_gallery_view';
			$data['css'] = 'admin-gallery.css';
			$data['title'] = 'Gallery';
			$this->load->view('includes/admin-template', $data);
	 }
	 
	
	function photo( $id = NULL )
	{
		$this->authorized();
		
		// Prime Variables
		$data['errors'] = NULL;
		
		$data['path'] = '';
		$data['picTitle'] = '';
		$data['picDesc'] = '';
		$data['picID'] = '';
		
		if ( $id )
		{
			$this->load->model('Gallery_model');
			$pic = $this->Gallery_model->getPhoto($id);
			if( $pic )
			{	
				$gallery = $this->Gallery_model->getGalleryById( $pic->gallery_id );
				
				$data['path'] = site_url().'uploads/'.$gallery[0]->directory_name.'/'.$pic->title;
				$data['picTitle'] = $pic->title;
				$data['picDesc'] = $pic->description;
				$data['picID'] = $pic->id;
				$data['saved'] = 0;
				
				$titleInput = $this->input->post('title');
				$descInput = $this->input->post('description');
				
				if ( $descInput != NULL  ) { $data['saved'] = 1; }
				
				//update info if it changed
				if ( is_string( $descInput ) && $pic->description != $descInput )
				{
					if ( $this->Gallery_model->updatePicture( 
						$pic->id,
						$pic->gallery_id,
						$pic->title,
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
		
		$data['main_content'] = 'user_photo_view';
		$data['css'] = 'style.css';
		$data['title'] = 'Photo';
		$this->load->view('includes/admin-template', $data);
		
	}

	function addGallery()
	{
		$this->authorized();
		
		$data['errors'] = FALSE;
		$data['success'] = FALSE;
		$data['css'] = 'style.css';
		$data['title'] = 'Add New Gallery';
		$data['main_content'] = 'new_gallery_view';
		
		
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
		
		$this->load->view('includes/admin-template', $data);
		
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
		$data['id'] = $id;
		
		//$data['main_content'] =
		//$data['css'] = 'style.css'; 
		//$data['title'] = 'Delete Photo';
		
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
		
		//$this->load->view('includes/admin-template', $data);
		
	}

	function authorized()
	{
		if ( $this->session->userdata('logged_in') === FALSE)
		{
			//redirect to login page
			echo 'Not authorized';
			break;
		}
		else
		{
			return TRUE;
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

/* End of file user.php */ 
/* Location: ./application/controllers/user.php */
