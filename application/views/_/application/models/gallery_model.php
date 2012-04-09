<?php

class Gallery_model extends CI_Model
{
	function getGalleries()
	{
		$query = $this->db->get('galleries');
		
		$galleries = array();
		
		foreach ($query->result() as $row)
		{
			$galleries[$row->directory_name] = $row->title;
		}
		
		return $galleries;
	}
	
	
	function addGallery($title, $description)
	{	
		echo $titleclean = preg_replace("/[^A-Za-z0-9]/","_",$title);
		
		$url = './uploads/'.$titleclean;
		
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
