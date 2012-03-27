
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
<script type="text/Javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>images/tornado-cropped64.png">

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/text.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/960.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/gallery.css" />
</head>

<body class="container_16">

<body>
	<?php if ( !$errors ) : ?>
	<div id="pictures" class="grid_16">
		<h2><?php echo $ret[0]->title; ?></h2>
		<?php foreach ($pics as $pic): ?>
			<?php
			$pieces = explode('.', $pic->title);
			$pieces[0] .= '_thumb.';
			$thumb = $pieces[0] . $pieces[1];
			?>
			
			<!-- <a href="http://localhost/stormshelter/uploads/<?php echo $ret[0]->directory_name.'/'.$pic->title ?>"/> -->
			<a href="<?php echo site_url().'user/photo/'.$pic->id ?>"/>
				<img src="<?php echo site_url().'uploads/'.$ret[0]->directory_name?>/thumbs/<?php echo $thumb ?>" class="grid_4 alpha" />
			</a>
		<?php endforeach; ?>
		
		<div id="pagination" class="grid_16">
			<?php echo $this->pagination->create_links(); ?>
		</div>
	</div> <!--End div pictures -->
	<?php endif; ?>
						
<div class="grid_16 errors">
	<?php echo $errors; ?>
</div>

</body>

</html>
