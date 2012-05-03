<div id="container" class="grid_16 alpha omega">
<div class="galleries grid_16 alpha omega">
<?php foreach ($galleries as $gallery) : ?>
	<div class="gallery	 grid_4 alpha">
		<h3><?php echo $gallery->title; ?></h3>
		<a href="<?php echo site_url().'gallery/'.$gallery->id; ?>">
			<p>
				<div class="image"
					style="background-image: url(
					<?php if ( $gallery->front_image ) : ?>
						<?php echo site_url();?>uploads/<?php echo $gallery->directory_name;?>/thumbs/<?php echo $gallery->front_image;?>
					<?php else: ?>					
						<?php echo site_url();?>uploads/default_image.gif 
					<?php endif; ?>
					)">
				</div>
			</p>
		</a>
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
