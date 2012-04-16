<div id="container" class="grid_16 alpha omega">

<h2>Upload a Photo</h2>


<?php echo form_open_multipart('user/add_photo');?>
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

<p class="errors">
<?php if( $errors ): ?>
	<?php echo $errors['errors'] ; ?>
<?php elseif( $upload_data ): ?>
	<h3>Upload Successful!</h3>
	<ul>
	<?php foreach ($upload_data as $item => $value):?>
	<li><?php echo $item;?>: <?php echo $value;?></li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
</p>

</form>
