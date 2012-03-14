<?php if (!($this->session->userdata('logged_in'))): ?>
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
	<?php echo form_open('user/login'); //add the path ?>
	<?php echo form_input($data); ?>
	<?php echo form_password($data2); ?>
	<?php echo form_submit('submit', 'Login'); ?>
	<?php echo form_close(); ?>
</div>
<div class="grid_16 errors">
	<p><?php echo $error = (!empty($errors)) ? $errors : ''; ?></p>
</div>
<?php endif; ?>

<?php if ($this->session->userdata('logged_in') == 1): ?>
<p><?php echo $this->session->userdata('username'); ?> <a href="<?php echo site_url(); ?>user/logout">logout</a></p>
<?php endif; ?>
