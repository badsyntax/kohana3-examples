<nav>
	<?php 
		$nav = Kohana::config('nav');

		foreach($nav['links'] as $url => $text) {

			$attributes = $url === Request::instance()->uri 
				? array('class' => 'selected') 
				: NULL;

			echo HTML::anchor($url, $text, $attributes);
		}
	?>
</nav>
