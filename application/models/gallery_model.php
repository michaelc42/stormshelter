<?php

class Gallery_model extends CI_Model
{
	var $galleryPath;
	
	function __construct()
	{
		parent::__construct();
		$this->galleryPath = realpath(APPPATH . '../uploads');
	}
	function getGalleries()
	{
		$query = $this->db->get('galleries');
		
		//$galleries = array();
		
		if ($query->num_rows() >0)
		{
			return $query->result();
			/*foreach ($query->result() as $row)
			{
				$galleries[$row->directory_name] = $row->title;//array(, $row->id);
			}
			*/
		}
		else
		{
			return FALSE;
		}
		
		//return $galleries;
	}
	
	function getGalleriesList()
	{
		$query = $this->getGalleries();
		if( $query )
		{	
			$galleries = array();
			
			foreach ($query as $row)
			{
				$galleries[$row->directory_name] = $row->title;//array(, $row->id);
			}
			return $galleries;
		}
	}
	
	/* Use this function to get an indivual gallery info.
	 * Usful for getting the gallery id
	 * Found by using unique path name
	 */
	function getGallery($path)
	{
		return $this->db->get_where('galleries', array('directory_name'=>$path,));
	}
	
	/* Returns a result if gallery exists */
	function doesGalleryExist($name)
	{
		$query = $this->db->get_where('galleries', array('title'=>$name,));
		
		if( $query->num_rows() == 1 )
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	
	function addGallery($title, $description)
	{	
		$titleclean = preg_replace("/[^A-Za-z0-9]/","_",$title);
		
		$url = './uploads/'.$titleclean;
		//$exists = $this->galleryExists($title);//make sure gallery does not exists
		
		if($this->galleryExists($title) === TRUE)
		{
			return FALSE;
		}
		else
		{
			if(mkdir($url))
			{
				$data = array(
				   'directory_name' => $titleclean,
				   'title' => $title,
				   'description' => $description,
				);
				chmod($url, 0777);
				
				$this->db->insert('galleries', $data);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
	/* Returns TRUE or FALSE if Gallery exists */
	function galleryExists($name)
	{
		$query = $this->db->get_where('galleries', array( 'title'=>$name,));
		if( $query->num_rows() > 0)
		{
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function addPhoto($gallery, $picture)
	{
		$config['upload_path'] = './uploads/' . $gallery;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '111100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
			
		$this->load->library('upload', $config);
		
		$this->upload->do_upload($picture);
		$this->upload->display_errors();
		$this->upload->data();
	}
	
	function insertPicture($path, $file)
	{
		$ret = $this->getGallery($path);
		
		$ret = $ret->row();
		
		$data = array(
		   'gallery_id' => $ret->id,
		   'title' =>  $file['file_name'],
		   
		);

		$this->db->insert('pictures', $data);
		
		$this->createThumb($path, $file['full_path']);
	}
	
	function createThumb($path, $file)
	{
		echo $config['source_image'] = $file;//'./uploads/'.$path.'/'.$file['file_name'].'/';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 200;
		$config['height'] = 200;
		echo $config['new_image'] = $this->galleryPath.'/'.$path.'/thumbs';//'./uploads/'.$path.'/thumbs/tb_'.$file['file_name'].'/';

		$this->load->library('image_lib');
		$this->image_lib->initialize($config); 
		if ( ! $this->image_lib->resize())
		{
			echo $this->image_lib->display_errors();
		}
	}
	
	function getPictures($id)
	{	
		$query = $this->db->get_where('pictures', array('gallery_id'=>$id,));
		
		if( $query->num_rows() > 0 )
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
}
