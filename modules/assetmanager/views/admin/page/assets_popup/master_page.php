<!doctype html>
<html lang="en" class="no-js admin <?php echo Kohana::$environment?> <?php echo str_replace('_', ' ', Request::instance()->controller)?> assetmanager popup" dir="ltr">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title ?></title>
	<?php echo implode("\n\t", array_map('HTML::style', $styles)), "\n"?>
	<?php echo implode("\n\t", array_map('HTML::script', $scripts)), "\n"?>
	<?php echo View::factory('page/fragments/analytics'), "\n"?>
</head>
	<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
	<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
	<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
	<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--> <body> <!--<![endif]-->
	<div id="content">	
		<?php echo Message::render('admin/message/popup') ?>
		<?php echo $content ?>
	</div>
	<script type="text/javascript">
	(function($){
		Admin.init({
			paths: <?php echo $paths?>,
			param: <?php echo $param?>,
			route: {
				controller: '<?php echo Request::instance()->controller?>',
				action: '<?php echo Request::instance()->action?>'
			}
		});			
	})(this.jQuery);
	</script>
	<!-- {execution_time} - {memory_usage} -->
</body>
</html>
