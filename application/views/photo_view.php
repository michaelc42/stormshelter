<?php if ( $errors ) : ?>
	<?php echo $errors; ?>
<?php endif; ?>
<div id="photo">
	<h2><?php echo $picTitle ?></h2>
	<p><a href="<?php echo site_url('gallery/'.$picGallery);?>">Back</a></p>
	<p><img class="photo" src="<?php echo $path; ?>" alt="<?php echo $picDesc; ?>"/></p>
	<p><?php echo $picDesc; ?></p>
</div>
