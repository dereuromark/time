<div class="time">
	<h2>View Time</h2>

	<dl>
		<dt>Id</dt>
		<dd>&nbsp;<?php echo $time['id'] ?></dd>
		<dt>User</dt>
		<dd>&nbsp;<?php echo $html->link($time->user['name'], '/users/view/' . $time->user['id']) ?></dd>
		<dt>Start</dt>
		<dd>&nbsp;<?php echo $time['start'] ?></dd>
		<dt>Stop</dt>
		<dd>&nbsp;<?php echo $time['stop'] ?></dd>
		<dt>Break</dt>
		<dd>&nbsp;<?php echo $time['break'] ?></dd>
		<dt>Task</dt>
		<dd>&nbsp;<?php echo $time['task'] ?></dd>
		<dt>Customer</dt>
		<dd>&nbsp;<?php echo $html->link(
				$time->customer['name'],
				'/customers/view/' . $time->customer['id']
			) ?></dd>
		<dt>Note</dt>
		<dd>&nbsp;<?php echo $time['note'] ?></dd>
		<dt>Created</dt>
		<dd>&nbsp;<?php echo $time['created'] ?></dd>
		<dt>Modified</dt>
		<dd>&nbsp;<?php echo $time['modified'] ?></dd>
	</dl>

</div>
