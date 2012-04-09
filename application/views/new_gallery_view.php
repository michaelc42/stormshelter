<div id="container" class="grid_16 alpha omega">
<h1>Create A New Gallery</h1>
<?php


$data = array(
	  'name'        => 'gallery-name',
	  'id'          => 'gallery-name',
	  'value'       => set_value('gallery-name', ''),
	  'maxlength'   => '32',
	  'size'        => '32',
	  'style'       => 'width:200px',
	);
	
	
$data2 = array(
	  'name'        => 'gallery-description',
	  'id'          => 'gallery-description',
	  'value'       => set_value('gallery-description', ''),
	  'rows'   		=> '10',
	  'cols'        => '10',
	  'style'       => 'width:200px',
	);
?>
					
<div class="grid_16 alpha" id="form">		
	<?php echo form_open('user/addGallery'); //add the path ?>
	<p>
		Gallery Title:
	</p>
	<p>
		<?php echo form_input($data); ?>
	</p>
	<p>
		Description:
	</p>
	<p>
		<?php echo form_textarea($data2); ?>
	</p>
	<p>
		<?php echo form_submit('submit', 'Create New Gallery'); ?>
	</p>
	<?php echo form_close(); ?>
</div>
<div class="grid_16 success">
	<p><?php echo ($success) ? $success : ''; ?></p>
</div>
<div class="grid_16 errors">
	<p><?php echo ($errors) ? $errors : ''; ?></p>
</div>
