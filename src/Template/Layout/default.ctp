<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $this->fetch('title'); ?></title>
	<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css('bootstrap.min');
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
	<style>
		body {
			padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
		}
	</style>
	<?php echo $this->Html->css('bootstrap.min'); ?>
	<?php echo $this->Html->css('individ'); ?>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<?php
	/*
	<!-- Le fav and touch icons -->
	<link rel="shortcut icon" href="../assets/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
	 */
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>
</head>

<body>
<div class="container">
	<div id="header">
		<h1>Time tracking</h1>
	</div>

	<?php echo $this->Flash->render(); ?>
	<?php echo $this->fetch('content'); ?>
</div>
<!-- /container -->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<?php echo $this->Html->script('jquery.min'); ?>
<?php echo $this->Html->script('bootstrap.min'); ?>
<?php
	echo $this->fetch('script');
?>
</body>
</html>
