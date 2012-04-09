<?php 
	$data = array(
	  'name'        => 'username',
	  'id'          => 'username',
	  'value'       => set_value('username', 'username'),
	  'maxlength'   => '32',
	  'size'        => '32',
	  'style'       => 'width:100px',
	);
					
	$data2 = array(
		'name'        => 'password',
		'id'          => 'password',
		'value'       => 'password',
		'maxlength'   => '32',
		'size'        => '32',
		'style'       => 'width:100px',
	);
?>
<div class="grid_16" id="">		
	<?php echo form_open('test/login'); //add the path ?>
	<?php echo form_input($data); ?>
	<?php echo form_password($data2); ?>
	<?php echo form_submit('submit', 'Login'); ?>
	<?php echo form_close(); ?>
</div>
<div class="grid_16 errors">
	<p><?php echo $error = (!empty($errors)) ? $errors : ''; ?></p>
</div>

<?php if ($this->session->userdata('logged_in') == 1): ?>
<p><a href="<?php echo site_url(); ?>test/logout">logout</a></p>
<?php endif; ?>
