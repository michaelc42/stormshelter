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
		$("#button").click(function() {
			
		
			$('<p>This was added!</p>').fadeIn().appendTo('#addToMe');
		});
	});

</script>

</head>

<body>

<div id="container">
	
<h1>jQuery Test</h1>

<input type="button" id="button" value="Add" />
<p>This was here before.</p>
<div id="addToMe"></div>

</div><!-- End container div -->
</body>

</html>
