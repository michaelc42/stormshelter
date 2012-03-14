<?php

class Gallery_model extends CI_Model
{
	function getGalleries()
	{
		$query = $this->db->get('galleries');
		
		$galleries = array();
		
		if ($query->num_rows() >0)
		{
			foreach ($query->result() as $row)
			{
				$galleries[$row->directory_name] = $row->title;
			}
		}
		else
		{
			//$galleries['errors'] = "Sorry, no galleries found.";
			return FALSE;
		}
		
		return $galleries;
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
}
