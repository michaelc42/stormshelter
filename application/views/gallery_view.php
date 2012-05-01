<p><a href="<?php echo site_url('galleries');?>">Back to Galleries</a></p>
	<?php if ( !$errors ) : ?>
	<div id="pictures" class="grid_16 alpha omega">
		<h2><?php echo $ret[0]->title; ?></h2>
		<?php foreach ($pics as $pic): ?>
		<div class="picture grid_4 alpha">
			<?php
			$pieces = explode('.', $pic->title);
			$pieces[0] .= '_thumb.';
			$thumb = $pieces[0] . $pieces[1];
			?>
			<a href="<?php echo site_url().'photo/'.$pic->id ?>/#photo">
				<img src="<?php echo site_url().'uploads/'.$ret[0]->directory_name?>/thumbs/<?php echo $thumb ?>" class="grid_4 alpha" alt="image" />
			</a>
		</div><!-- end PICTURE div -->
		<?php endforeach; ?>
		
		<div id="pagination" class="grid_16 alpha">
			<?php echo $this->pagination->create_links(); ?>
		</div><!-- end PAGINATION div -->
	
	<?php endif; ?>
	</div><!-- end PICTURES div -->
		
						
<div class="grid_16 errors">
	<?php echo $errors; ?>
</div>
