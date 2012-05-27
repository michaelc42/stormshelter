<div id="container" class="grid_14 alpha omega">

<h2>Galleries</h2>

<div class="all_galleries grid_14 alpha omega">
<?php foreach ($galleries as $gallery) : ?>
	<div class="gallery grid_4 alpha">
		<h3><?php echo $gallery->title; ?></h3>			
		<a href="<?php echo site_url().'user/gallery/'.$gallery->id; ?>">
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
			<a href="<?php echo site_url().'user/addphoto/'.$gallery->directory_name; ?>">Add Photo</a>
			<a href="<?php echo site_url(); ?>user/confirmDelete/<?php echo $gallery->id; ?>">delete</a>
		</p>
		
		<p class="desc">
			<?php echo $gallery->description; ?>	
		</p>
	</div> 
<?php endforeach; ?>
</div> <!-- End All Galleries Div -->

<div id="pagination" class="grid_14">
	<p>
		<?php echo $this->pagination->create_links(); ?>
	</p>
</div>
