<nav>
	<div class="helper-right">
	
		<?php if (Auth::instance()->logged_in()) {?>
			
			<a href="<?php echo URL::site('user/profile')?>">Profile</a>
			<a href="<?php echo URL::site('user/signout')?>">Sign out</a>

		<?php } else {?>

			<a href="<?php echo URL::site('user/signin')?>">Sign in</a>
			<a href="<?php echo URL::site('user/signup')?>">Sign up</a>
		<?php } ?>

		<?php if (Kohana::$environment === Kohana::DEVELOPMENT){?>

			<a href="#profiler">
				Profiler 
				<span class="plus">+</span>
				<span class="minus helper-hidden">&ndash;</span>
			</a>
		<?php }?>
	</div>

	<a href="<?php echo URL::site()?>">Home</a>
	<a href="<?php echo URL::site('contact')?>">Contact</a>
	<a href="<?php echo URL::site('general')?>">General</a>
	<a href="<?php echo str_replace('://', 'http://mobile.', URL::base(TRUE, ''))?>">Mobile</a>
	<a href="<?php echo URL::site('admin')?>">Admin</a>
</nav>
