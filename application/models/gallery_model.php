<?php
/** Gallery_model
 * @author Michael W. Casey 
 * @link www.f5stormrooms.com
 */

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
		
		if ($query->num_rows() >0)
		{
			return $query->result();
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
	
	function getGalleryById( $id )
	{
		return $this->db->get_where('galleries', array('id'=>$id,))->result();
	}
	
	/* Returns a result if gallery exists */
	function doesGalleryExist($id)
	{
		$query = $this->db->get_where('galleries', array('id'=>$id,));
		
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
				//make the thumbnail directory
				mkdir($url . '/thumbs');
				$data = array(
				   'directory_name' => $titleclean,
				   'title' => $title,
				   'description' => $description,
				);
				chmod($url, 0777);
				chmod($url.'/thumbs', 0777);
				
				$this->db->insert('galleries', $data);
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
	function deleteGallery ( $id, $dir )
	{
		//delete everything in the gallery database
		$this->db->where('gallery_id', $id)->delete('pictures');
		$this->db->where('id', $id)->delete('galleries');
		
		//Use this function to delete any objects within the folders and delete
		//the directories
		$this->rrmdir( './uploads/'.$dir.'/thumbs/');
		$this->rrmdir( './uploads/'.$dir);
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
		$config['max_height'] = '1024';
			
		$this->load->library('upload', $config);
		
		$this->upload->do_upload($picture);
		$this->upload->display_errors();
		$this->upload->data();
	}
	
	function insertPicture($path, $file, $desc)
	{
		$ret = $this->getGallery($path);
		
		$ret = $ret->row();
		
		$data = array(
		   'gallery_id' => $ret->id,
		   'title' =>  $file['file_name'],
		   'description' => $desc,
		   
		);

		$this->db->insert('pictures', $data);
		
		$this->createThumb($path, $file['full_path']);
	}
	
	function updatePicture( $id, $gallery_id, $title, $desc )
	{
		$data = array(
			'id' => $id,
			'gallery_id' => $gallery_id,
			'title' => $title,
			'description' => $desc,
		);
		
		$this->db->where('id', $id);
		if ( $this->db->update('pictures', $data) )
		{ 
			return TRUE;
		}
		else
		{
			return FALSE;	
		}
	}
	
	function createThumb($path, $file)
	{
		$config['source_image'] = $file;//'./uploads/'.$path.'/'.$file['file_name'].'/';
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 200;
		$config['height'] = 200;
		$config['new_image'] = $this->galleryPath.'/'.$path.'/thumbs';//'./uploads/'.$path.'/thumbs/tb_'.$file['file_name'].'/';

		$this->load->library('image_lib');
		$this->image_lib->initialize($config); 
		if ( ! $this->image_lib->resize())
		{
			echo $this->image_lib->display_errors();
		}
	}
	
	//retrieves all photos in a gallery
	function getPictures($id, $limit, $offset)
	{	
		$query = $this->db->get_where('pictures', array('gallery_id'=>$id,), $limit, $offset);
		
		if( $query->num_rows() > 0 )
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	//Retrieves a single photo
	function getPhoto($id)
	{
		$query = $this->db->get_where('pictures', array('id' => $id,));
		if( $query->num_rows() == 1 )
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	function deletePhoto( $id )
	{
		$ret = $this->getPhoto( $id );
		
		//get galleryid
		if ( $ret === FALSE )
		{
			return 'Picture not in database.';
		}
		
		$filename = $ret[0]->title;
		
		$pieces = explode('.', $filename);
		$pieces[0] .= '_thumb.';
		$thumb = $pieces[0] . $pieces[1];
		
		//get directory of gallery
		$ret = $this->doesGalleryExist( $ret[0]->gallery_id );
		
		if ( $ret === FALSE )
		{
			return 'Gallery does not exist.';
		}
		
		//delete picture in file system
		if ( file_exists( './uploads/'.$ret[0]->directory_name.'/'.$filename ) &&
			 file_exists( './uploads/'.$ret[0]->directory_name.'/thumbs/'.$thumb ) )
		{
			if ( unlink( './uploads/'.$ret[0]->directory_name.'/'.$filename ) === FALSE ||
				 unlink( './uploads/'.$ret[0]->directory_name.'/thumbs/'.$thumb ) === FALSE )
			{
				return 'Picture could not be deleted from file system.';
			}
		}
		else
		{
			return 'Picture not found in file system.';
		}
		
		//delete picture in database
		if ( $this->db->where('id', $id)->delete('pictures') === FALSE )
		{
			return 'Picture could not be removed from the database.';
		}
		
	}
	
	function rrmdir($dir) 
	{
		if (is_dir($dir)) 
		{
			$objects = scandir($dir);
			foreach ($objects as $object) 
			{
				if ($object != "." && $object != "..") 
				{
					if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			}
		reset($objects);
		rmdir($dir);
		}
	}
}

/* End of file gallery_model.php */ 
/* Location: ./application/models/gallery_model.php */
