<h2>All galleries loaded</h2>

<?php foreach ($galleries as $gallery) : ?>
	<div class="gallery">
		<h3><?php echo $gallery->title; ?></h3>
		<p>
			<a href="<?php echo site_url().'user/galleries/'.$gallery->id; ?>">
				<?php if ( $gallery->front_image ) : ?>
					<img src="<?php echo site_url().'uploads/'.$gallery->title.'/thumbs/'.$gallery->front_image;?>" />
				<?php else: ?>					
					<img src="<?php echo site_url().'uploads/default_image.gif'; ?>" />
				<?php endif; ?>
			</a>
		</p>
		<p>
			<?php echo $gallery->description; ?>	
		</p>
		
		<p>
			
			<a href="<?php echo site_url().'user/index/'.$gallery->directory_name; ?>">Add Photo</a>
			<a href="confirmDelete/<?php echo $gallery->id; ?>">delete</a>
		</p>
	</div> 
<?php endforeach; ?>
