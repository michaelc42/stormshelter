<div id="container" class="grid_16 alpha omega">
	<?php if ( !$errors ) : ?>
	<h2><?php echo $ret[0]->title; ?></h2>
	<p>Click image to edit details.</p>
	<?php echo form_open(current_url()); ?>
	<div id="pictures" class="grid_16 alpha">
		
		<?php foreach ($pics as $pic): ?>
			<div class="picture grid_4 alpha">
				<?php
				$pieces = explode('.', $pic->title);
				$pieces[0] .= '_thumb.';
				$thumb = $pieces[0] . $pieces[1];
				?>

				<a href="<?php echo site_url().'user/photo/'.$pic->id; ?>">
					<div class="image"
					style="background-image:url('<?php echo site_url()?>uploads/<?php echo $ret[0]->directory_name;?>/thumbs/<?php echo $thumb; ?>')">
					</div>
				</a>
				<br />
				<p>
					<?php echo form_radio( 'front_image', $pic->id, ( $pic->id == $front_image ) ? TRUE : FALSE ); ?>
					set default
				</p>
				<p>
					<a href="<?php echo site_url().'user/deletePhoto/'.$pic->id; ?>">delete</a>					
				</p>
			</div>
		<?php endforeach; ?>
	
		<p class="grid_16 alpha omega">
			<?php echo form_submit('submit', 'save'); ?>
		</p>
		
		<div id="pagination" class="grid_16">
			<p>
				<?php echo $this->pagination->create_links(); ?>
			</p>
		</div>
	</div> <!--End div pictures -->

	<?php echo form_close(); ?>
		
<?php else: ?>
						
<div class="grid_16 errors">
	<p>
		<?php echo $errors; ?>
	</p>
</div>
<?php endif; ?>
