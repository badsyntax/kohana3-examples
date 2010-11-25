<nav>
	<ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="a">
		<li><a href="<?php echo URL::site('contact')?>">Contact</a></li>
		<li><a href="<?php echo URL::site('general')?>">General</a></li>

		<?php if (Auth::instance()->logged_in()) {?>
			
			<li><a href="<?php echo URL::site('auth/profile')?>">Profile</a></li>
			<li><a href="<?php echo URL::site('auth/signout')?>">Sign out</a></li>

		<?php } else {?>

			<li><a href="<?php echo URL::site('auth/service')?>">Sign in</a></li>
			<li><a href="<?php echo URL::site('auth/signup')?>">Sign up</a></li>
		<?php } ?>
	</ul>
</nav>
