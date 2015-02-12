<?php
if (Configure::read('debug') > 1 || (defined('DEBUG_USER') && DEBUG_USER)) {
	?>
	<style>
		<!--
		.cake-sql-log, pre, #cakeDebug {
			background-color: #fff;
			color: #000
		}

		#cakeDebug a {
			color: #000
		}

		#cakeDebug a:hover {
			color: #900
		}

		#cakeDebug pre {
			margin: 10px;
			color: #000;
			text-align: left
		}

		#view-log {
			background-color: #fdd
		}

		#data-log {
			background-color: #ffd
		}

		#session-log {
			background-color: #dfd
		}

		#post-log {
			background-color: #ddf
		}

		.cake-sql-log, #view-log, #data-log, #session-log, #post-log, #constant-log {
			display: none;
		}

		-->
	</style>

	<script type="text/javascript">
		//Show Debuginfo and not
		function debugtoggle(area) {
			$(area).toggle();
		}
		//$().ready(function() {
		//	prettyPrint();
		//});
	</script>

	<div id="cakeDebug" style="<?php if (defined('DEBUG_USER') && DEBUG_USER && LIVE) {
		echo 'display:none';
	} ?>">

		<?php
		if (defined('DEBUG_USER') && DEBUG_USER) {
			$old_debug = Configure::read('debug');
			Configure::write('debug', 2);
		}
		?>
		<a onclick="debugtoggle('#view-log')">show View Vars</a><br/>
<pre id="view-log" class="prettyprint">
$this-&gt;viewVars = <?php ob_start();
	print_r($this->viewVars);
	echo htmlentities(ob_get_clean()); ?>
	$this-&gt;request = <?php ob_start();
	print_r($this->request);
	echo htmlentities(ob_get_clean()); ?>
</pre>

		<a onclick="debugtoggle('#data-log')">show Data Vars</a><br/>
<pre id="data-log" class="prettyprint">
$this-&gt;data = <?php ob_start();
	print_r($this->request->data);
	echo htmlentities(ob_get_clean()); ?>
</pre>

		<a onclick="debugtoggle('#session-log')">show Session Vars</a><br/>
<pre id="session-log" class="prettyprint">
<b>$_SESSION = </b><?php ob_start();
	print_r($_SESSION);
	echo htmlentities(ob_get_clean()); ?>
</pre>

		<a onclick="debugtoggle('#post-log')">show Post/Cookie</a><br/>
<pre id="post-log" class="prettyprint">
<b>$_POST = </b><?php ob_start();
	print_r($_POST);
	echo htmlentities(ob_get_clean()); ?>
	<b>$_COOKIE = </b><?php ob_start();
	print_r($_COOKIE);
	echo htmlentities(ob_get_clean()); ?>
</pre>

		<div><a onclick="debugtoggle('.cake-sql-log')">show SQL</a></div>
		<?php echo $this->element('sql_dump'); ?>

	</div>
	<?php
	if (defined('DEBUG_USER') && DEBUG_USER) {
		Configure::write('debug', $old_debug);
	}
	?>

<?php
}
?>