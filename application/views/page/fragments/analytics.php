<?php
/*
asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet 
change the UA-XXXXX-X to be your site's ID
*/?>
<script>
	var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
	(function(d, t) {
		var g = d.createElement(t),
		s = d.getElementsByTagName(t)[0];
		g.async = true;
		g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g, s);
	})(document, 'script');
</script>
