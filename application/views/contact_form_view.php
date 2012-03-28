<div id="contact-form" class="grid_3 alpha" >
	<div id="contact-info" class="grid_3 alpha">
		<h5>Contact Us</h5>
		<strong>F5 Stormrooms</strong><br />
		Eureka, IL 61616<br />
		Phone: (877)436-8559<br />
		Fax: (877)436-8559<br />
		<a href="mailto:f5stormrooms@yahoo.com">f5stormrooms@yahoo.com</a><br />
	</div>
		<h5>Contact Form</h5>
			<?php 
				$emailData = array(
				  'name'        => 'email',
				  'id'          => 'email',
				  'value'       => ($success == TRUE) ? '' : set_value('email'),
				  'maxlength'   => '32',
				  'size'        => '32',
				  'style'       => 'width:140px',
				);
				
				$nameData = array(
				  'name'        => 'name',
				  'id'          => 'name',
				  'value'       => ($success == TRUE) ? '' : set_value('name'),
				  'maxlength'   => '32',
				  'size'        => '32',
				  'style'       => 'width:140px',
				);
				
				$phoneData1 = array(
				  'name'        => 'areacode',
				  'id'          => 'areacode',
				  'value'       => ($success == TRUE) ? '' : set_value('areacode'),
				  'maxlength'   => '3',
				  'size'        => '3',
				  'style'       => 'width:30px',
				);
				$phoneData2 = array(
				  'name'        => 'phone1',
				  'id'          => 'phone1',
				  'value'       => ($success == TRUE) ? '' : set_value('phone1'),
				  'maxlength'   => '3',
				  'size'        => '3',
				  'style'       => 'width:30px',
				);
				
				$phoneData3 = array(
				  'name'        => 'phone2',
				  'id'          => 'phone2',
				  'value'       => ($success == TRUE) ? '' : set_value('phone2'),
				  'maxlength'   => '4',
				  'size'        => '4',
				  'style'       => 'width:40px',
				);
				
				$messageData = array(
				  'name'        => 'message',
				  'id'          => 'message',
				  'value'       => ($success == TRUE) ? '' : set_value('message'),
				  'rows'		=> '5',
				  'cols'		=> '64',
				  'style'       => 'width:140px',
				); 	
					
			?>
			<?php echo form_open('message#contact-form'); //add the path ?>
			<p>Name:</p>
			<p><?php echo form_input($nameData); ?></p>
			<p>Email:</p>
			<p><?php echo form_input($emailData); ?></p>
			<p>Phone:</p>
			<p>
				(<?php echo form_input($phoneData1); ?>)
				<?php echo form_input($phoneData2); ?>-
				<?php echo form_input($phoneData3); ?>
			</p>
			<p>Message:</p>
			<p><?php echo form_textarea($messageData); ?></p>
			<p id="honeypot"><input type="hidden" name="robotest" value="" /></p><!--Honey-->
			<p><?php echo form_submit('submit', 'submit'); ?></p>
			<?php echo form_close(); ?>
			<?php if ($errors) : ?>
			<div class="errors">
				<?php echo $errors; ?>
			</div>	
			<?php elseif ($success) : ?>
				<p class="success">Your message has been sent.</p>
			<?php endif; ?>
		
	</div>
