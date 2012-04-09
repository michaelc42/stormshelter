<html>
<head>
<title>Upload Form</title>
</head>
<body>

<a href="new_gallery"><p>Create a new gallery.</p></a>

<?php
	$data3 = array(
		'name' => 'picture',
		'id' => 'picture',
		'value' => '',
		'maxlength' => '100',
		'size' => '4000',
		'style' => 'width: 50%',
	);
?>	
	
<?php echo form_open_multipart('test/do_upload'); ?>
<?php echo form_dropdown('Galleries', $galleries); ?>
<?php echo form_upload('picture', $data3); ?>
<?php echo form_submit('submit', 'Upload'); ?>
<?php form_close(); ?>
	
	
					
<div class="grid_16 errors">
	<p><?php print_r( $errors); ?></p>
</div>

</body>
</html>
