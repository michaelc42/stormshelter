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
	
	/*
	 * Get all galleries for pagination.
	 */
	function getGalleries($limit = NULL, $offset = NULL)
	{
		$query = $this->db->get('galleries', $limit, $offset);
		
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
	
	/*
	 * This function is used to retrieve the data for the dropdown list
	 * on the 'Add a Photo' page.
	 */
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
				
				//worked with 0777
				//should work with 0755
				chmod($url, 0705);
				chmod($url.'/thumbs', 0705);
				
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
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '2048';
		$config['max_width'] = '4096';
		$config['max_height'] = '4096';
			
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
		
		$this->createThumb($path, $file['full_path'], $file['file_name']);
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
	
	function update_gallery( $id, $front_image )
	{
		$data = array(
			'front_image' => $front_image,
		);
		
		$this->db->where( 'id', $id );
		if ( $this->db->update( 'galleries', $data ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function createThumb($path, $file, $filename)
	{
		$size = getimagesize( $file );
	
		$config['source_image'] = $file;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 220;
		$config['height'] = 200;
		$config['new_image'] = $this->galleryPath.'/'.$path.'/thumbs';
		$this->load->library('image_lib');
		$this->image_lib->initialize($config); 
		
		
		//if height > width
		if ( $size[1] > $size[0] )
		{
			$config['master_dim'] = 'width';
			$config['height'] = 200;
			$config['width'] = 220;
			$config['maintain_ratio'] = TRUE;
			$this->image_lib->clear();
			//print_r($config);
			$this->image_lib->initialize( $config );
			if ( ! $this->image_lib->resize() )
			{
				echo $this->image_lib->display_errors();
			}
		}
		elseif ( ! $this->image_lib->resize() )
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
			return $query->row();
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
		
		$filename = $ret->title;
		
		$thumb = $this->get_thumb( $filename );
		
		//get directory of gallery
		$ret = $this->doesGalleryExist( $ret->gallery_id );
		
		if ( $ret === FALSE )
		{
			return 'Gallery in which the photo is in does not exist.';
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
	
	/*
	 * Function used to create the filename for the thumbnails
	 * image01 becomes image01_thumb.jpg for example
	 */
	function get_thumb( $pic )
	{
		$pieces = explode('.', $pic);
		$pieces[0] .= '_thumb.';
		return $thumb = $pieces[0] . $pieces[1];
	}
	
	/*
	 * Function used when deleting a gallery.  Deletes all the files and
	 * folders that were created with the directory.
	 */
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
