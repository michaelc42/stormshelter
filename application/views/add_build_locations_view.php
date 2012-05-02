<h4>Hello!</h4>
<?php echo form_open( 'user/add_build_locations' ); ?>
<?php echo form_label( 'Enter City, State: ','location');?>
<?php echo form_input( array('name'=>'location','value'=>'','maxlength'=>'50','size'=>'20',) ); ?>
<?php echo form_submit('submit', 'Submit');?>

<div id="locations">
	<table>
		<th>Current Locations</th>
		<?php foreach ( $locations as $value ): ?>
			<tr id="<?php echo $value->id;?>">
				<td>
					<?php echo $value->name; ?>
				</td>
				<td>
					<a href="delete_location/<?php echo $value->id;?>">delete</a>
					<a style="display:none" href="edit_location/<?php echo $value->id;?>">edit</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<?php if( $errors ): ?>
<p><?php echo $errors;?></p>
<?php endif; ?>

<?php if( $success ): ?>
<p><?php echo $success;?></p>
<?php endif; ?>


