
<?php if ( $errors ) : ?>
	<?php echo $errors; ?>
<?php endif; ?>
<?php echo form_open(); ?>
Title: 
<br />
<?php echo form_input('title', $picTitle); ?>
<p><img src="<?php echo $path; ?>" /></p>
Description: 
<br />
<?php echo form_textarea('description', $picDesc); ?>
<br />
<?php echo form_submit('submit', 'save'); ?>
<?php echo form_close(); ?>
