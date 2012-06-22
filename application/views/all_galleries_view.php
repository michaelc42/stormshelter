<div id="container" class="grid_14 alpha omega">
<div class="galleries grid_14 alpha omega">
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
		<div class="colorbox" style="display:">
			<?php foreach ( $all_images as $image ) : ?>
				<?php if ( $image->gallery_id == $gallery->id ): ?>
					
					<a class="<?php echo $gallery->id; ?>" rel="<?php $gallery->id; ?>" href="<?php echo site_url();?>uploads/<?php echo $gallery->directory_name.'/'.$image->title;?>">HELP</a>
					
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
		<p>
			<?php echo $gallery->description; ?>	
		</p>
	</div> 
<?php endforeach; ?>
</div>

<div id="pagination" class="grid_14 alpha">
	<p>
		<?php echo $this->pagination->create_links(); ?>
	</p>
</div>

<script type="text/javascript">
	$(document).ready(function(){
	
		var id = 0,
			$gallery = $("a[class=59]").colorbox();
		$(".gallery a").click(function(e){
			e.preventDefault();
			$gallery.eq(0).click();
		});
	
	});	
	/*
	$(".gallery").on('click', function(e){
		
		var pics = $(this).children(".colorbox").children("a"),
			id = pics.attr("class"),
			$gallery = $("a."+id).colorbox({
				rel: id,
				maxWidth: 800,
				maxHeight: 600,
			});
		
		console.log( $gallery.eq(0).click() );
		e.preventDefault();
	*/
	//$(".58").colorbox({rel:'58'});
	
	//$(".gallery").on('click', function(e){
		//var id = 58;
		//e.preventDefault();
		//console.log(id);
		//console.log( $("."+id).colorbox({rel: id}) );
	//});
	
	//Examples of how to assign the ColorBox event to elements
	//$(".group1").colorbox({rel:'group1'});
	
</script>
