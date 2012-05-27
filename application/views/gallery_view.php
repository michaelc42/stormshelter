<p><a href="<?php echo site_url('galleries');?>">Back to Galleries</a></p>
	<?php if ( !$errors ) : ?>
	<div id="pictures" class="grid_14 alpha omega">
		<h2><?php echo $ret[0]->title; ?></h2>
		<?php foreach ($pics as $pic): ?>
		<div class="picture grid_4 alpha">	
			<a href="<?php echo site_url().'photo/'.$pic->id; ?>">
				<div class="image"
				style="background-image:url('<?php echo site_url()?>uploads/<?php echo $ret[0]->directory_name;?>/thumbs/<?php echo $pic->thumb; ?>')">
				</div>
			</a>
			<p class="description"><?php echo (strlen( $pic->description ) > 70 ) ? substr( $pic->description, 0, 70 ).'...' : $pic->description;?></p>
		</div><!-- end PICTURE div -->
		<?php endforeach; ?>
		
		<div id="pagination" class="grid_14 alpha">
			<?php echo $this->pagination->create_links(); ?>
		</div><!-- end PAGINATION div -->
	
	<?php endif; ?>
	</div><!-- end PICTURES div -->
		
						
<div class="grid_16 errors">
	<?php echo $errors; ?>
</div>
