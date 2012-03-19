<html>

<body>
	<?php if ($errors === FALSE): ?>
		<?php foreach ($pics as $pic): ?>
		<?php
		$pieces = explode('.', $pic->title);
		$pieces[0] .= '_thumb.';
		$thumb = $pieces[0] . $pieces[1];
		echo '<a href="http://localhost/stormshelter/uploads/'.$ret[0]->directory_name.'/'.$pic->title.'"/>
			<img src="http://localhost/stormshelter/uploads/'.$ret[0]->directory_name.'/thumbs/'.$thumb.'" /></a><br />';
		?>
		<?php endforeach; ?>
	<?php endif; ?>	
	
	<?php echo $this->pagination->create_links(); ?>	
					
<div class="grid_16 errors">
	<?php echo $errors; ?>
</div>

</body>

</html>
