<div id="container" class="grid_16 alpha omega">
<div class="galleries grid_16 alpha omega">
<?php foreach ($galleries as $gallery) : ?>
	<div class="gallery	 grid_4 alpha">
		<h3><?php echo $gallery->title; ?></h3>
		<p>
			<a href="<?php echo site_url().'gallery/'.$gallery->id; ?>">
				<?php if ( $gallery->front_image ) : ?>
					<img src="<?php echo site_url().'uploads/'.$gallery->directory_name.'/thumbs/'.$gallery->front_image;?>" alt="image" />
				<?php else: ?>					
					<img src="<?php echo site_url().'uploads/default_image.gif'; ?>" alt="img"/>
				<?php endif; ?>
			</a>
		</p>
		<p>
			<?php echo $gallery->description; ?>	
		</p>
	</div> 
<?php endforeach; ?>
</div>

<div id="pagination" class="grid_16 alpha">
	<p>
		<?php echo $this->pagination->create_links(); ?>
	</p>
</div>
