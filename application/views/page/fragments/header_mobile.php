<header data-role="header"<?php echo !Request::instance()->uri ? ' data-nobackbtn="true"' : ''?>>
	<h1><?php echo $title?></h1>
	<?php if (!!Request::instance()->uri){?>
	<a href="<?php echo URL::base()?>" rel="external" data-icon="gear" data-theme="a" class="ui-btn-right">Home</a>
	<?php }?>
</header>
