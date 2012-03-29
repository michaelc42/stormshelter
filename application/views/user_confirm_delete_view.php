<h3>Are you sure you want to delete this gallery?</h3>
<?php echo form_open(''); ?>
<a href="../deleteGallery/<?php echo $id; ?>"><?php echo form_button('confirm', 'Confirm'); ?></a>
<a href="../galleries"><?php echo form_button('cancel', 'Cancel'); ?></a>
<?php echo form_close(); ?>
