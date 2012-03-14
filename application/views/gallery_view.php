<html>

<body>
<h2>Click on a gallery to view</h2>
	<?php if ($errors === FALSE): ?>
		<?php foreach ($galleries as $gallery): ?>
		<?php echo $gallery; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	
		
					
<div class="grid_16 errors">
	<?php echo $errors; ?>
</div>

</body>

</html>
