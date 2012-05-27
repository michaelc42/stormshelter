<!DOCTYPE html>

<html>
<?php header("Content-Type: text/html; charset= UTF-8"); ?>
<head>


<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>images/tornado-cropped64.png" />

<!--[if gte IE 8]>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/text.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/960.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/alt_style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/'.$css;?>"/>
<!--<![endif]-->


<script type="text/Javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/google.analytics.js"></script>

<title>F5 Stormrooms - <?php echo $title; ?></title>


</head>

<body class="container_16">
<div id="container" class="grid_14 prefix_1 suffix_1 alpha omega">
<div class="grid_14 alpha omega" id="main">
	<div class="grid_14 alpha omega">	
		<div class="grid_3 alpha" id="names">
			<h3 id="f5stormrooms-header">F5 Stormrooms</h3>
			<h4>
				DuPont&#8482; StormRoom&#8482; with Kevlar&#174;
			</h4>
		</div><!-- End names div -->
		<img id="header-image" src="<?php echo site_url('images/'.$header_image)?>" alt="Product Information"/>
	</div>
	<div class="grid_14 alpha omega" id="alt-nav">
		<ul>
			<li id="home-link">
				<ul>
					<li>
						<a href="<? echo site_url();?>">Home</a>
					</li>
				</ul>
			</li>
			<li id="prod-info-link">	
				<div class="menu">
					<ul>
						<li class="<?php echo ( $active == 'product_info' ? 'active' : '' ); ?>">
							<a href="<? echo site_url('product_info');?>">Product Info</a>
						</li>
						<li class="dropdown <?php echo ( $active == 'proven_by_science' ? 'active' : '' ); ?>">
							<a href="<? echo site_url('proven_by_science');?>">Proven by Science</a>
						</li>
						<li class="dropdown <?php echo ( $active == 'exceeding_standards' ? 'active' : ''); ?>">
							<a href="<? echo site_url('exceeding_standards');?>">Exceeding Standards</a>
						</li>
					</ul>
				</div>
			</li>
			
			<li id="using-prod-link">
				<div class="menu">
				<ul>
					<li class="<?php echo ( $active == 'using_product' ? 'active' : '' ); ?>">
						<a href="<? echo site_url('using_product');?>">Using the Product</a>
					</li>
					<li class="dropdown <?php echo ( $active == 'faqs' ? 'active' : '' ); ?>">
						<a href="<? echo site_url('frequently_asked_questions');?>">FAQs</a>
					</li>
					<li class="dropdown <?php echo ( $active == 'architectural_details' ? 'active' : ''); ?>">
						<a href="<? echo site_url('architectural_details');?>">Architectural Details</a>
					</li>
				</ul>
				</div>
			</li>
			<li id="galleries-link">
				<ul>
					<li class="<?php echo ( $active == 'galleries' ? 'active' : ''); ?>">
						<a href="<? echo site_url('galleries');?>">Gallery</a>	
					</li>
				</ul>
			</li>
			<li id="build-locations-link">
				<ul>
					<li class="<?php echo ( $active == 'build_locations' ? 'active' : ''); ?>">
						<a href="<? echo site_url('build_locations');?>">Build Locations</a>	
					</li>
				</ul>
			</li>
		</ul>
	</div><!-- end alt-nav div -->
	<div class="grid_14 alpha omega beta" id="info-section">
	<div class="grid_14 alpha omega beta justify">		
	<!--[if lte IE 7]>
	<h3>To view this website with full styling, please upgrade your browser.</h3>
	<![endif]-->
