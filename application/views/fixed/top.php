<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="topNav">
		<div class="container">
			<div class="alignR">
				<div class="pull-left socialNw">
					<a href="#"><span class="icon-twitter"></span></a>
					<a href="#"><span class="icon-facebook"></span></a>
					<a href="#"><span class="icon-youtube"></span></a>
					<a href="#"><span class="icon-tumblr"></span></a>
				</div>
				<a class="active" href="<?=URL::base()?>"> <span class="icon-home"></span> Home</a> 
				<a href="<?=URL::base()?>user"><span class="icon-user"></span> My Account</a> 
				<a href="<?=URL::base()?>user/auth/join"><span class="icon-edit"></span> Free Register </a> 
				<a href="<?=URL::base()?>user/auth/login"><span class="icon-edit"></span> Login </a> 
				<a href="contact.html"><span class="icon-envelope"></span> Contact us</a>
				<a href="<?=URL::base()?>basket"><span class="icon-shopping-cart"></span> 
					<?php 
					if($quantity)
					{
						echo $quantity.' '.__('item(s)');
					} else {
						echo __('basket is empty');
					}?> - 
					<span class="badge badge-warning"> $
					<?php 
						if($total_amount){
							echo $total_amount;
						} else {
							echo '0';
						}
					?>
					</span>
				
				</a>
			</div>
		</div>
	</div>
</div>