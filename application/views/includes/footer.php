<div id="footer" class="grid_14 alpha">
	<div id="footer-content" class="grid_14 alpha">
		<p>						
			Copyright &#169; 2011 DuPont. All rights reserved. The DuPont Oval Logo, DuPont&#8482;, The miracles of science&#8482; and 
			all products denoted with &#174; or &#8482; are registered trademarks or trademarks of E. I. du Pont de Nemours and Company 
			or its affiliates. 
		</p>
		<p id="login">
			<?php if ($this->session->userdata('username')): ?>
				Logged in as <?php echo $this->session->userdata('username').' '; ?>
				<a href="<?php echo site_url(); ?>user/admin">admin</a> <a href="<?php echo site_url(); ?>user/logout">logout</a>
			<?php else: ?>
				<a href="<?php echo site_url(); ?>user/login">admin</a>
			<?php endif; ?>
		</p>
	</div>
</div>

</div> <!-- close div container -->

</body>

</html>
