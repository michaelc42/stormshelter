<h2>All galleries loaded</h2>
<?php foreach ($galleries as $gallery) : ?>

	<?php echo $gallery->title; ?>
	<br />
	<?php echo $gallery->id; ?>
	<a href="<?php echo site_url().'galleries/'.$gallery->id; ?>">Hello</a>
<?php endforeach; ?>
