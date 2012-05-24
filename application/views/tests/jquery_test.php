<!DOCTYPE html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
<script type="text/Javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="" />

<link rel="stylesheet" type="text/css" href="<?php echo site_url();?>css/reset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url();?>css/text.css" />
<link rel="stylesheet" type="text/css" href="<?php echo site_url();?>css/960.css" />

<title>jQuery Tests</title>

<script>
	
	$(document).ready(function() {
		
	
		$('a.lightbox').click(function(e)
		{
			//hide scrollbars!
			$('body').css('overflow-y', 'hidden');
			
			$('<div id="overlay"></div>')
				.css('top', $(document).scrollTop())
				.css('opacity', '0')
				.animate({'opacity': '0.5'}, 'slow')
				.appendTo('body');
				
			$('<div id="lightbox"></div>')
				.hide()
				.appendTo('body');
				
			$('<img>')
				.attr('src', $(this).attr('href'))
				.load(function() 
				{
					positionLightboxImage();
				})
				.click(function()
				{
					removeLightbox();
				})
				.appendTo('#lightbox');
			
			return false;
			
		});
		
		function positionLightboxImage()
		{
			var top = ($(window).height() - $('#lightbox').height()) / 2;
			var left = ($(window).width() - $('#lightbox').width()) / 2;
			
			$('#lightbox')
				.css({
					'top': top + $(document).scrollTop(),
					'left': left
				})
				.fadeIn();
		}
		
		function removeLightbox()
		{
			$('#overlay, #lightbox')
				.fadeOut('slow', function()
				{
					$(this).remove();
					$('body').css('overflow-y', 'auto'); //show scrollbars!
				});
		}
	
	
	});

</script>

<style>
#overlay {
	position:fixed;
	top:0;
	left:0;
	height: 100%;
	width: 100%;
	background: black url(<?php echo site_url('images/252.gif');?>) no-repeat scroll center center;
}

#lightbox{
	position: fixed;
}

#container{
	height: 2000px;
}

</style>

</head>

<body>

<div id="container">
	
<h1>jQuery Test</h1>

<a href="<?php echo site_url('images/prod_info_banner.jpg');?>" class="lightbox">Pic</a>

</div><!-- End container div -->
</body>

</html>
