<html>

<body>
<h2>Add Photo to Gallery</h2>
<?php
	$data3 = array(
		'name' => 'picture',
		'id' => 'picture',
		'value' => 'What',
		'maxlength' => '100',
		'size' => '4000',
		'style' => 'width: 50%',
	);
?>	
	
<?php echo form_open_multipart('user/addPhoto'); ?>
<?php echo form_dropdown('galleries', $galleries); ?>


<?php echo form_upload('picture');//, $data3); ?>
<?php echo form_submit('submit', 'Upload'); ?>
<?php form_close(); ?>
	
<a href="addgallery"><p>Create a new gallery.</p></a>

					
<div class="grid_16 errors">
	<?php //echo $errors['error']; ?>
</div>

</body>

</html>
