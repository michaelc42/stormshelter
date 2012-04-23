<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'/>
		<title>ColorBox Examples</title>
		<style>
			body{font:12px/1.2 Verdana, sans-serif; padding:0 10px;}
			a:link, a:visited{text-decoration:none; color:#416CE5; border-bottom:1px solid #416CE5;}
			h2{font-size:13px; margin:15px 0 0 0;}
			.hidden{
				display: none;
			}
		</style>
		<link rel="stylesheet" href="<?php echo site_url('css/colorbox.css');?>" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script src="<?php echo site_url('js/jquery.colorbox.js');?>"></script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				$(".group1").colorbox({rel:'group1'});
				$(".group2").colorbox({rel:'group2', transition:"fade"});
				$(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
				$(".group4").colorbox({rel:'group4', slideshow:true});
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:425, innerHeight:344});
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
	</head>
	<body>
		<h1>ColorBox Demonstration</h1>
		
		<h2>Elastic Transition</h2>
		<p>
			<a class="group1" href="<?php echo site_url('uploads/test/animals-q-g-450-343-6.jpg');?>" title="Me and my grandfather on the Ohoopee.">
			</a>
		</p>
		<p><a class="group1" href="<?php echo site_url('uploads/test/animals-q-g-450-343-6.jpg');?>" title="On the Ohoopee as a child">Grouped Photo 2</a></p>
		<p><a class="group1" href="<?php echo site_url('uploads/test/animals-q-g-450-343-6.jpg');?>" title="On the Ohoopee as an adult">Grouped Photo 3</a></p>
		<p><a class="group1" href="<?php echo site_url('uploads/test/animals-q-g-450-343-6.jpg');?>" title="Pig">Grouped Photo 3</a></p>
	</body>
</html>
