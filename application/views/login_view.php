<?php if (!($this->session->userdata('logged_in'))): ?>

<div id="container" class="grid_16 alpha omega">
	


<div class="grid_16 alpha" id="admin-header">
	<a class= "grid_4 alpha" id="logo-link" href="http://www.f5stormrooms.com/">
		<img id="main-logo" class="" src="<?php echo base_url();?>images/logo3.png" alt="F5 Stormrooms Logo"/>
	</a>
	
	<div class="grid_12 alpha omega" id="admin-menu">
		<a class="grid_2 alpha" href="galleries">
			Galleries
		</a>
		<a class="grid_2 alpha" href="addGallery">
			New Gallery
		</a>
		
		<a class="grid_2 alpha" href="addphoto">
			Add Photo
		</a>
		
		<a class="grid_2 alpha suffix_4" href="logout">
			Logout
		</a>
	</div>
</div>

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
<div class="grid_16 alpha" id="login-form">			
	<?php echo form_open('user/login'); //add the path ?>
	<?php echo form_input($data); ?>
	<?php echo form_password($data2); ?>
	<?php echo form_submit('submit', 'Login'); ?>
	<?php echo form_close(); ?>
</div>
<div class="grid_16 errors alpha">
	<p><?php echo $error = (!empty($errors)) ? $errors : ''; ?></p>
</div>
<?php endif; ?>

<?php if ($this->session->userdata('logged_in') == 1): ?>
<p><?php echo $this->session->userdata('username'); ?> <a href="<?php echo site_url(); ?>user/logout">logout</a></p>
<?php endif; ?>
