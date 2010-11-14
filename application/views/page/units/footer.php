<footer>
	<?php if (Kohana::$environment === Kohana::DEVELOPMENT and $_SERVER['HTTP_HOST'] !== 'm.dev.2do.me.uk'){?>
		<div id="application-profiler" style="display: none">
			{profiler}
			{execution_time}
		</div>
	<?php }?>
</footer>

