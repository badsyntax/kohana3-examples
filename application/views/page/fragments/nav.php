<nav>
	<?php 
		$nav = Kohana::config('nav');
		$uri_segments = explode('/', Request::instance()->uri);

		foreach($nav['links'] as $url => $text) {
			$attributes = ($url === Request::instance()->uri OR $url === $uri_segments[0])
				? array('class' => 'selected') 
				: NULL;
			echo HTML::anchor($url, $text, $attributes);
		}
	?>
</nav>
