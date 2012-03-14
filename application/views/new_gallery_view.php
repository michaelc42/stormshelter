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
					
<div class="grid_16" id="">		
	<?php echo form_open('user/addGallery'); //add the path ?>
	<label>Gallery Title:</label>
	<br />
	<?php echo form_input($data); ?>
	<br />
	<label>Description:</label>
	<br />
	<?php echo form_textarea($data2); ?>
	<br />
	<?php echo form_submit('submit', 'Create New Gallery'); ?>
	<br />
	<?php echo form_close(); ?>
</div>
<div class="grid_16 errors">
	<p><?php echo $errors; ?></p>
</div>
