<p>
	<?php echo __('Hello, world!')?>
</p>

<?php if (Kohana::$environment === Kohana::PRODUCTION AND !Request::$is_mobile){?>
<p>
	This site is in '<em>production</em>' mode, meaning the stylesheet and javascript are
	minified and cached, and errors and exceptions are supressed. Global exception handling
	is done in the 'application/bootstap.php' file. Production errors are usually handled by
	the 'application/classes/controller/error.php' contoller.
</p>
<p>
	The <a href="https://github.com/azampagl/kohana-media">Media module</a> handles the caching of the media assets (css &amp; javascript). The module
	creates new caches based on filetime, so you don't have to worry about re-caching these files.
	View the source to see an example.
</p>
<?php } elseif (Kohana::$environment === Kohana::DEVELOPMENT AND !Request::$is_mobile){?>
<p>
	This site is in '<em>development</em>' mode, meaning the stylesheet and javascript are
	unminified and errors and exceptions are displayed to the user.
	The <a href="#profiler">profiler</a> has been enabled to help you debug the request.
</p>
<p>
	To change the site environment, you need to change the KOHANA_ENV environment variable in your
	web server's config. View the 'application/apache' vhost files for an example. Alternatively
	you can set the environment variable in the 'application/bootstrap.php' file.
</p>
<?php }?>
