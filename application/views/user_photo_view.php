
<?php if ( $errors ) : ?>
	<p>
		<?php echo $errors; ?>
	</p>
<?php else: ?>
	<?php if ( $saved ) : ?>
		<p>Saved!</p>
	<?php endif; ?>
	<?php echo form_open(current_url()); ?>
	<p>
		Title: 
		<br />
		<?php echo $picTitle; ?>
	</p>
	<p>
		<img class="photo" src="<?php echo $path; ?>" />
	</p>
	<p>
		Description: 
		<br />

		<?php echo form_textarea('description', $picDesc); ?>
	</p>
	<p>
		<?php echo form_submit('submit', 'save'); ?>
	</p>
	<?php echo form_close(); ?>
<?php endif; ?>
