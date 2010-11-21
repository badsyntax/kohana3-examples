<footer>
	<?php if (Kohana::$environment === Kohana::DEVELOPMENT){?>
		<div id="profiler">
			<div class="helper-right">
				Powered by <a href="http://kohanaframework.org/">KO3</a>
			</div>
			{execution_time} - {memory_usage} {cached}
		</div>
	<?php }?>
</footer>

