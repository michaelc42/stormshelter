<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/google.analytics.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>images/tornado-cropped64.png" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/text.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/960.css" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/'.$css;?>"/>

<title>F5 Stormrooms - <?php echo $title; ?></title>


</head>

<body class="container_16">
	

<div class="grid_16 alpha" id="admin-header">
	<a class= "grid_4 alpha" id="logo-link" href="http://www.f5stormrooms.com/">
		<img id="main-logo" class="" src="<?php echo base_url();?>images/logo3.png" alt="F5 Stormrooms Logo"/>
	</a>
	
	<div class="grid_12 alpha omega" id="admin-menu">
		<a class="grid_2 alpha" href="<?php echo site_url('user/galleries'); ?>">
			Galleries
		</a>
		<a class="grid_2 alpha" href="<?php echo site_url('user/addGallery'); ?>">
			New Gallery
		</a>
		
		<a class="grid_2 alpha" href="<?php echo site_url('user/add_photo'); ?>">
			Add Photo
		</a>
		
		<a class="grid_2 alpha" href="<?php echo site_url('user/add_build_locations'); ?>">
			Add Location
		</a>
		
		<a class="grid_2 alpha suffix_2" href="<?php echo site_url('user/logout'); ?>">
			Logout
		</a>
	</div>
</div>
