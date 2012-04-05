<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php //echo $error;?>

<h2>Upload a Photo</h2>

<p>
<?php echo form_open_multipart('user/do_upload');?>

Photo: <input type="file" name="userfile" size="20" />

Gallery: <?php echo form_dropdown('galleries', $galleries, $selected); ?>

</p>
<p>
	<?php echo form_textarea('description'); ?>
</p>
<p>
<input type="submit" value="upload" />
</p>
</form>


</body>
</html>
