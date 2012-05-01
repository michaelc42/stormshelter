<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** * Main_controller
 * @author Michael W. Casey 
 * @link www.f5stormrooms.com
 */
/*****************************************
 * This controller is the public access for
 * visitors.  All areas of the site that
 * are available to non-registered viewers
 * may be viewed
 *****************************************/ 
class Main_controller extends CI_Controller
{
	function test_gallery()
	{
		$this->load->view('test_view');
	}
	function index()
	{
		$data['errors'] = FALSE;
		$data['success'] = FALSE;
		$data['main_content'] = 'home_view';
		$data['css'] = 'style.css';
		$data['title'] = 'Home';
	
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
		$data['css'] = 'style.css';
		$data['title'] = 'Home';
		
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
	function galleries( $off = 0 )
	{	$limit = 4;
		$offset = $off;
		$data = array();
		$data['errors'] = NULL;
		$data['ret'] = NULL;
		$data['pics'] = NULL;
		
		$data['main_content'] = 'all_galleries_view';
		$data['css'] = 'admin_galleries.css';
		$data['title'] = 'Gallery';
		
		if( TRUE ) 
		{ 
			//load all galleries 
			$this->load->model('Gallery_model');
			
			$total_galleries = $this->Gallery_model->getGalleries();
			$limited_galleries = $this->Gallery_model->getGalleries( $limit, $offset );
			
			//$ret = $this->Gallery_model->getGalleries();
			
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
			$config['base_url'] = site_url('galleries');
			$config['total_rows'] = count($total_galleries);
			$config['per_page'] = $limit;
			//user controller needs uri_segment of 3 because 'url/user/galleries/offset'
			$config['uri_segment'] = 2;

			$this->pagination->initialize($config);
			
			$data['galleries'] = $limited_galleries;
			
			//$data['galleries'] = $ret;
			$this->load->view('includes/gallery-template', $data);
			
		}
	}
	
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
					$config['base_url'] = site_url('gallery').'/'.$ret[0]->id.'/';
					$config['total_rows'] = count($totalPics);
					$config['per_page'] = $limit;
					//user controller needs uri_segment of four because 'url/user/gall.../id/offset'
					$config['uri_segment'] = 3;
				
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
			
			
			$data['main_content'] = 'gallery_view';
			$data['css'] = 'gallery.css';
			$data['title'] = 'Gallery';
			$this->load->view('includes/gallery-template', $data);
	 }
	
	function photo($id = NULL)
	{
		$data['errors'] = NULL;
		$data['title'] = 'Photo';
		$data['main_content'] = 'photo_view';
		$data['css'] = 'style.css';
		
		//test
		$data['path'] = '';
		$data['picTitle'] = '';
		$data['picDesc'] = '';
		$data['picID'] = '';
		//test
		
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
				$data['picGallery'] = $pic->gallery_id;
				
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
		
		$this->load->view('includes/gallery-template', $data);
		
	}
	
	function product_info()
	{
		$data = NULL;
		$data['main_content'] = 'product_info_view';
		$data['active'] = 'product_info';
		$data['title'] = 'Product Information';
		$data['css'] = 'alt_style.css';
		$data['header_image'] = 'prod_info_banner.jpg';
		$this->load->view('includes/alt-template', $data);
	}
	
	function proven_by_science()
	{
		$data = NULL;
		$data['main_content'] = 'proven_by_science_view';
		$data['active'] = 'proven_by_science';
		$data['title'] = 'Proven By Science';
		$data['css'] = 'alt_style.css';
		$data['header_image'] = 'prod_info_banner.jpg';
		$this->load->view('includes/alt-template', $data);
	}
	
	function exceeding_standards()
	{
		$data = NULL;
		$data['main_content'] = 'exceeding_standards_view';
		$data['active'] = 'exceeding_standards';
		$data['title'] = 'Meeting and Exceeding Standards';
		$data['css'] = 'alt_style.css';
		$data['header_image'] = 'prod_info_banner.jpg';
		$this->load->view('includes/alt-template', $data);
	}
	
	function using_product()
	{
		$data = NULL;
		$data['main_content'] = 'using_product_view';
		$data['active'] = 'using_product';
		$data['title'] = 'Using the Product';
		$data['css'] = 'alt_style.css';
		$data['header_image'] = 'using_product_banner.jpg';
		$this->load->view('includes/alt-template', $data);
	}
	
	function frequently_asked_questions()
	{
		$data = NULL;
		$data['main_content'] = 'faqs_view';
		$data['active'] = 'faqs';
		$data['title'] = 'Frequently Asked Questions';
		$data['css'] = 'alt_style.css';
		$data['header_image'] = 'using_product_banner.jpg';
		$this->load->view('includes/alt-template', $data);
	}
	
	function architectural_details()
	{
		$data = NULL;
		$data['main_content'] = 'architectural_details_view';
		$data['active'] = 'architectural_details';
		$data['title'] = 'Architectural Details';
		$data['css'] = 'alt_style.css';
		$data['header_image'] = 'using_product_banner.jpg';
		$this->load->view('includes/alt-template', $data);
	}
	
	function build_locations()
	{
		$data['locations'] = FALSE;
		$data['main_content'] = 'build_locations_view';
		$data['active'] = 'build_locations';
		$data['title'] = 'Build Locations';
		$data['css'] = 'alt_style.css';
		$data['header_image'] = 'prod_info_banner.jpg';
		
		$data['errors'] = FALSE;
		$data['locations'] = FALSE;
		
		
		$query = $this->db->get('build_locations');
		
		if ( $query )
		{
			$data['locations'] = $query->result();
		}
		else
		{
			$data['errors'] = 'There was an error.';
		}
		
		$this->load->view('includes/alt-template', $data);
	}
	
	function bcrypt()
	{
		$password = 'michael1';
		$actualPassword = 'michael1';
		$this->load->library('PasswordHash');
		$pHash = new PasswordHash();
		
		echo $hashedPass = $pHash->HashPassword($actualPassword);
		echo '<br />';
		//check the user input unhased password with the hashed
		//password retrieved from the database
		$check = $pHash->CheckPassword($password, $hashedPass);
		
		if( $check )
		{
			echo 'Password Correct!';
		}
		else
		{
			echo 'Password Wrong!';
		}
	}
}

/* End of file main_controller.php */ 
/* Location: ./application/controllers/main_controller.php */
