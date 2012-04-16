<html>
<head>
<title>Upload Form</title>
</head>
<body>

<h3>Your file was successfully uploaded!</h3>

<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>

<p><?php echo anchor('index', 'Upload Another File!'); ?></p>

<p>
<?php if ( $errors ): ?>
<?php echo $errors; ?>
<?php endif; ?>

</p>

</body>
</html>
