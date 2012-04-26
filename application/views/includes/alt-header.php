<!DOCTYPE html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
<script type="text/Javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>images/tornado-cropped64.png" />

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/text.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/960.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/'.$css;?>"/>

<title>F5 Stormrooms - <?php echo $title; ?></title>


</head>

<body class="container_16">
<div id="container" class="grid_14 prefix_1 suffix_1 alpha omega">
<div class="grid_14 alpha omega" id="main">
	<div class="grid_3 alpha" id="names">
		<h3 id="f5stormrooms-header">F5 Stormrooms</h3>
		<h4>
			DuPont&#8482; StormRoom&#8482; with Kevlar&#174;
		</h4>
	</div><!-- End names div -->
	<img id="header-image" src="<?php echo site_url('images/'.$header_image)?>" alt="Product Information"/>
	<div class="grid_14 alpha" id="alt-nav">	
		<ul>
			
			<li>
				<ul id="home-link">
					<li class="<?php echo ( $active == 'home' ? 'active' : '' ); ?>">
						<a href="<?php echo site_url(); ?>">
							Home
						</a>
					</li>
				</ul>
			</li>
			<li>
				<div id="product-info-item">
					<ul>
						<li class="<?php echo ( $active == 'product_info' ? 'active' : '' ); ?>">
							<a href="product_info">Product Info</a>
						</li>
							<li class="dropdown <?php echo ( $active == 'proven_by_science' ? 'active' : '' ); ?>">
								<a href="proven_by_science">Proven by Science</a>
							</li>
							<li class="dropdown <?php echo ( $active == 'exceeding_standards' ? 'active' : ''); ?>">
								<a href="exceeding_standards">Exceeding Standards</a>
							</li>
						</ul>
				</div>
			</li>
			<li>
				<div id="using-product-item">
					<ul>
						<li  class="<?php echo ( $active == 'using_product' ? 'active' : '' ); ?>">
							<a href="using_product">Using the Product</a>
						</li>
						<li class="dropdown <?php echo ( $active == 'faqs' ? 'active' : '' ); ?>">
							<a href="frequently_asked_questions">FAQs</a>
						</li>
						<li class="dropdown <?php echo ( $active == 'architectural_details' ? 'active' : ''); ?>">
							<a href="architectural_details">Architectural Details</a>
						</li>
					</ul>
				</div>
			</li>
			<li>
				<div id="gallery-item">
					<ul>
						<li><a href="galleries">Gallery</a></li>
					</ul>
				</div>
			</li>
		</ul>
	</div> <!--Close alt-nav-->
	<div class="grid_14 alpha omega beta" id="info-section">
	<div class="grid_14 alpha omega beta justify">
