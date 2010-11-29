<nav>
	<div class="helper-right">
	
		<a href="<?php echo URL::site('auth/profile')?>">Profile</a>
		<a href="<?php echo URL::site('auth/signout')?>">Sign out</a>

		<?php if (Kohana::$environment === Kohana::DEVELOPMENT){?>

			<a href="#profiler">
				Profiler 
				<span class="plus">+</span>
				<span class="minus helper-hidden">&ndash;</span>
			</a>
		<?php }?>
	</div>

	<a href="<?php echo URL::site()?>">Home</a>
	<a href="<?php echo URL::site('admin')?>">Admin</a>
	<a href="<?php echo URL::site('admin/users')?>">Users</a>
	<a href="<?php echo URL::site('admin/roles')?>">Roles</a>
</nav>
