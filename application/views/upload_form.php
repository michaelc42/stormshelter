<div id="container" class="grid_16 alpha omega">

<?php //echo $error;?>

<h2>Upload a Photo</h2>


<?php echo form_open_multipart('user/do_upload');?>
	<p>
	Photo: <input type="file" name="userfile" size="20" />
	</p>
	<p>
	Gallery: <?php echo form_dropdown('galleries', $galleries, $selected); ?>
	</p>
<p>
	<?php echo form_textarea('description'); ?>
</p>
<p>
<input type="submit" value="upload" />
</p>
</form>
