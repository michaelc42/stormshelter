<h4>Hello!</h4>
<?php echo form_open( 'user/add_build_locations' ); ?>
<?php echo form_label( 'Enter City, State: ','location');?>
<?php echo form_input( array('name'=>'location','value'=>'','maxlength'=>'50','size'=>'20',) ); ?>
<?php echo form_submit('submit', 'Submit');?>

<?php if( $errors ): ?>
<p><?php echo $errors;?></p>
<?php endif; ?>

<?php if( $success ): ?>
<p><?php echo $success;?></p>
<?php endif; ?>
