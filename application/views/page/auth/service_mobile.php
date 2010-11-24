<h4>Choose the service you'd like to sign in with:</h4>

<form method="get" action="<?php echo URL::site('auth/openid_try') ?>">

	<a rel="external" href="<?php echo URL::site('auth/openid_try') ?>?openid_identity=https://www.google.com/accounts/o8/id" data-role="button">Google</a>

	<a rel="external" href="<?php echo URL::site('auth/openid_try') ?>?openid_identity=https://me.yahoo.com" data-role="button">Yahoo</a>

	<a rel="external" href="<?php echo URL::site('auth/oauth_twitter') ?>" data-role="button">Twitter</a>
	
	<a rel="external" href="<?php echo URL::site('auth/oauth_twitter') ?>" data-role="button">OpenID</a>

	<a href="<?php echo URL::site('auth/signin') ?>" data-role="button">Site login</a>
</form>

