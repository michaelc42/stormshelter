<h2>All galleries loaded</h2>

<?php foreach ($galleries as $gallery) : ?>
	<div class="gallery">
		<h3><?php echo $gallery->title; ?></h3>
		<p>
			<a href="<?php echo site_url().'gallery/'.$gallery->id; ?>">
				<?php if ( $gallery->front_image ) : ?>
					<img src="<?php echo site_url().'uploads/'.$gallery->directory_name.'/thumbs/'.$gallery->front_image;?>" />
				<?php else: ?>					
					<img src="<?php echo site_url().'uploads/default_image.gif'; ?>" />
				<?php endif; ?>
			</a>
		</p>
		<p>
			<?php echo $gallery->description; ?>	
		</p>
	</div> 
<?php endforeach; ?>
