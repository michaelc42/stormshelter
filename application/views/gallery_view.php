<script	type="text/javascript">
	$(document).ready(function(){
		//Examples of how to assign the ColorBox event to elements
		$(".group1").colorbox({rel:'group1'});
		
		$(".picture").find("a").each(function(){
			$(this).attr("href", $(this).data("image-url"))
		});
		
		
	});
</script>

<p><a href="<?php echo site_url('galleries');?>">Back to Galleries</a></p>
	<?php if ( !$errors ) : ?>
	<div id="pictures" class="grid_14 alpha omega">	
		<h2><?php echo $ret[0]->title; ?></h2>
		<?php foreach ($pics as $pic): ?>
		<div class="picture grid_4 alpha ">		
			<a href="<?php echo site_url().'photo/'.$pic->id; ?>" class="group1"
					title="<?php echo $pic->description; ?>"
					data-image-url="<?php echo site_url().'uploads/'.$ret[0]->directory_name.'/'.$pic->title;?>">
				<img class="image"
					src="<?php echo site_url()?>uploads/<?php echo $ret[0]->directory_name;?>/thumbs/<?php echo $pic->thumb; ?>" />
			</a>
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
