<!doctype html>
<html lang="en" class="no-js mobile <?php echo Kohana::$environment?>" dir="ltr">
<head>
	<meta charset="utf-8" />
      	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title ?></title>
	<?php echo implode("\n\t", array_map('HTML::style', $styles)), "\n";?>
	<?php echo implode("\n\t", array_map('HTML::script', $scripts)), "\n" ?>
	<?php echo View::factory('page/fragments/analytics'), "\n"?>
</head>
<body>
	<div data-role="page">

		<?php echo View::factory('page/fragments/header_mobile', array('title' => $title)) ?>

		<div id="content" data-role="content">

			<?php echo $content?>

			<?php echo !Request::instance()->uri ? View::factory('page/fragments/nav_mobile') : '' ?>
		</div>

		<?php echo View::factory('page/fragments/footer_mobile') ?>
	</div>
	<!-- {execution_time} - {memory_usage} -->
</body>
</html>
