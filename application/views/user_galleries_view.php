<div id="container" class="grid_16 alpha omega">

<h2>All galleries loaded</h2>

<div class="all_galleries grid_16 alpha omega">
<?php foreach ($galleries as $gallery) : ?>
	<div class="gallery grid_4 alpha">
		<h3><?php echo $gallery->title; ?></h3>
		<p>
			<a href="<?php echo site_url().'user/gallery/'.$gallery->id; ?>">
				<?php if ( $gallery->front_image ) : ?>
					<img src="<?php echo site_url().'uploads/'.$gallery->directory_name.'/thumbs/'.$gallery->front_image;?>" alt="image"/>
				<?php else: ?>					
					<img src="<?php echo site_url().'uploads/default_image.gif'; ?>" alt="image"/>
				<?php endif; ?>
			</a>
		</p>
		<p>
			<?php echo $gallery->description; ?>	
		</p>
		
		<p>
			
			<a href="<?php echo site_url().'user/addphoto/'.$gallery->directory_name; ?>">Add Photo</a>
			<a href="<?php echo site_url(); ?>user/confirmDelete/<?php echo $gallery->id; ?>">delete</a>
		</p>
	</div> 
<?php endforeach; ?>
</div> <!-- End All Galleries Div -->

<div id="pagination" class="grid_16">
	<p>
		<?php echo $this->pagination->create_links(); ?>
	</p>
</div>
