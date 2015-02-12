<div class="time">
	<h2>View Time</h2>

	<dl>
		<dt>Id</dt>
		<dd>&nbsp;<?php echo $time['Time']['id'] ?></dd>
		<dt>User</dt>
		<dd>&nbsp;<?php echo $html->link($time['User']['name'], '/users/view/' . $time['User']['id']) ?></dd>
		<dt>Start</dt>
		<dd>&nbsp;<?php echo $time['Time']['start'] ?></dd>
		<dt>Stop</dt>
		<dd>&nbsp;<?php echo $time['Time']['stop'] ?></dd>
		<dt>Break</dt>
		<dd>&nbsp;<?php echo $time['Time']['break'] ?></dd>
		<dt>Task</dt>
		<dd>&nbsp;<?php echo $time['Time']['task'] ?></dd>
		<dt>Customer</dt>
		<dd>&nbsp;<?php echo $html->link(
				$time['Customer']['name'],
				'/customers/view/' . $time['Customer']['id']
			) ?></dd>
		<dt>Note</dt>
		<dd>&nbsp;<?php echo $time['Time']['note'] ?></dd>
		<dt>Created</dt>
		<dd>&nbsp;<?php echo $time['Time']['created'] ?></dd>
		<dt>Modified</dt>
		<dd>&nbsp;<?php echo $time['Time']['modified'] ?></dd>
	</dl>

</div>
