
<?php if ( $errors ) : ?>
	<?php echo $errors; ?>
<?php endif; ?>
<?php if ( $saved ) : ?>
	<p>Saved!</p>
<?php endif; ?>
<?php echo form_open(current_url()); ?>
Title: 
<br />
<?php echo $picTitle; ?>
<p><img src="<?php echo $path; ?>" /></p>
Description: 
<br />
<?php echo form_textarea('description', $picDesc); ?>
<br />
<?php echo form_submit('submit', 'save'); ?>
<?php echo form_close(); ?>
