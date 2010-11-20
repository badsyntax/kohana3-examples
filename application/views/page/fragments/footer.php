<footer>
	<?php if (Kohana::$environment === Kohana::DEVELOPMENT){?>
		<div id="profiler">
			{execution_time} - {memory_usage} {cached}
		</div>
	<?php }?>
</footer>

