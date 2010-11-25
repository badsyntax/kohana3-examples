<h4>Choose the service you'd like to sign in with:</h4>

<a href="<?php echo URL::site('openid/signin')?>?openid_identity=https://www.google.com/accounts/o8/id" data-role="button">Google</a>
<a href="<?php echo URL::site('openid/signin') ?>?openid_identity=https://me.yahoo.com" data-role="button">Yahoo</a>
<a href="<?php echo URL::site('oauth/twitter/signin') ?>" data-role="button" rel="external">Twitter</a>
<a href="<?php echo URL::site('openid/signin') ?>" data-role="button">OpenID</a>
<a href="<?php echo URL::site('auth/signin') ?>" data-role="button">Site login</a>
