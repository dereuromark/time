<div class="times">

<?php
if (!isset($startedTime)) {
	?>
	<h2 class="startbar-headline">Start Time</h2>
	<form action="<?php echo $html->url('/times/start'); ?>" method="post">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<?php echo $form->labelTag('Time/customer_id', 'Customer'); ?>
					<?php echo $html->link('+', '/customers/add/'); ?>
				</td>
				<td>
					<?php echo $form->labelTag('Time/task', 'Task/Project'); ?>
				</td>
				<td>
					<?php echo $form->labelTag('Time/note', 'Note'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<?php echo $html->selectTag(
						'Time/customer_id',
						$customers,
						$html->tagValue('Time/customer_id'),
						array(),
						array(),
						true
					); ?>
					<?php echo $html->tagErrorMsg('Time/customer_id', 'Please select the Customer.') ?>
				</td>
				<td>
					<?php echo $html->input('Time/task', array('size' => '20')); ?>
					<?php echo $html->tagErrorMsg('Time/task', 'Please enter the Task.'); ?>
				</td>
				<td>
					<?php echo $html->input('Time/note', array('size' => '20')); ?>
					<?php echo $html->tagErrorMsg('Time/note', 'Please enter the Note.'); ?>
				</td>
				<td>
					<?php echo $html->submit('Start', Array('class' => 'StartButton')); ?>
				</td>
			</tr>
		</table>
	</form>
<?php
} else {
	?>
	<h2 class="startbar-headline">Stop Time</h2>
	<form action="<?php echo $html->url('/times/stop'); ?>" method="post">
		<?php echo $html->hidden('Time/id') ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<?php echo $form->labelTag('Time/customer_id', 'Customer'); ?>
					<?php echo $html->link('+', '/customers/add/'); ?>
				</td>
				<td>
					<?php echo $form->labelTag('Time/task', 'Task/Project'); ?>
				</td>
				<td>
					<?php echo $form->labelTag('Time/note', 'Note'); ?>
				</td>
				<td>
					<?php echo $form->labelTag('Time/break', 'Pause'); ?>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>
					<?php echo $html->selectTag(
						'Time/customer_id',
						$customers,
						$html->tagValue('Time/customer_id'),
						array(),
						array(),
						true
					); ?>
					<?php echo $html->tagErrorMsg('Time/customer_id', 'Please select the Customer.') ?>
				</td>
				<td>
					<?php echo $html->input('Time/task', array('size' => '20')); ?>
					<?php echo $html->tagErrorMsg('Time/task', 'Please enter the Task.'); ?>
				</td>
				<td>
					<?php echo $html->input('Time/note', array('size' => '20')); ?>
					<?php echo $html->tagErrorMsg('Time/note', 'Please enter the Note.'); ?>
				</td>
				<td>
					<?php echo $html->input('Time/break', array('size' => '3')); ?>
					<?php echo $html->tagErrorMsg('Time/break', 'Pause in Stunden'); ?>
				</td>
				<td>
					<?php echo $html->submit('Stop', Array('class' => 'StopButton')); ?>
				</td>
			</tr>
		</table>
	</form>
<?php
}
?>




<table cellpadding="0" cellspacing="0">
	<tr>
		<th>Datum</th>
		<th>User</th>
		<th>Customer</th>
		<th>Task</th>
		<th>Note</th>
		<th>Start</th>
		<th>Stop</th>
		<th>P.</th>
		<th>Dauer</th>

		<th>Act</th>
	</tr>
	<?php foreach ($times as $time): ?>


		<tr class="<?php echo 'individualEntry' . $time['User']['id']; ?>">
			<td><?php echo substr($time['Time']['start'], 0, 10); ?></td>
			<td><?php echo $html->link($time['User']['name'], '/users/view/' . $time['User']['id']) ?></td>
			<td><?php echo $html->link($time['Customer']['name'], '/customers/view/' . $time['Customer']['id']) ?></td>
			<td><?php echo $time['Time']['task']; ?></td>
			<td><?php echo $time['Time']['note']; ?></td>
			<td><?php echo substr($time['Time']['start'], 10, 6); ?></td>
			<td><?php echo substr($time['Time']['stop'], 10, 6); ?></td>
			<td><?php echo $time['Time']['break']; ?></td>
			<?
			if ($time['Time']['stop'] == '0000-00-00 00:00:00') {
				$time['Time']['stop'] = date('Y-m-d H:i:s');
			}
			$time['Time']['startsec'] = mktime(
				substr($time['Time']['start'], 11, 2),
				substr($time['Time']['start'], 14, 2),
				substr($time['Time']['start'], 17, 2),
				substr($time['Time']['start'], 5, 2),
				substr($time['Time']['start'], 8, 2),
				substr($time['Time']['start'], 0, 2)
			);

			$time['Time']['stopsec'] = mktime(
				substr($time['Time']['stop'], 11, 2),
				substr($time['Time']['stop'], 14, 2),
				substr($time['Time']['stop'], 17, 2),
				substr($time['Time']['stop'], 5, 2),
				substr($time['Time']['stop'], 8, 2),
				substr($time['Time']['stop'], 0, 2)
			);
			$diff = ($time['Time']['stopsec'] - $time['Time']['startsec']) / 3600 - $time['Time']['break'];
			?>
			<td><?php echo round($diff, 2); ?></td>


			<td class="actions">
				<?php
				if (env('REMOTE_USER') == $time['User']['name']) {
					echo $html->link('ed', '/times/edit/' . $time['Time']['id']) . ' / ';
					echo $html->link(
						'x',
						'/times/delete/' . $time['Time']['id'],
						null,
						'Are you sure you want to delete id ' . $time['Time']['id']
					);
				}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>

<?php if ($groupid == 1) { ?>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>User</th>
			<th>akt. Monat</th>
			<th>vor. Monat</th>
			<th>Jahr</th>
			<th>letztes Jahr</th>
			<th>Stundenguthaben</th>
		</tr>
		<?php foreach ($statistics as $stat_user => $stat_value): ?>
			<tr>
				<td><?php echo $stat_user ?></td>
				<td><?php echo round($stat_value['Time']['this_month'], 2) ?></td>
				<td><?php echo round($stat_value['Time']['last_month'], 2) ?></td>
				<td><?php echo round($stat_value['Time']['year'], 2) ?></td>
				<td><?php echo round($stat_value['Time']['year_2009'], 2) ?></td>
				<td><?php echo round($stat_value['Time']['life'] - $stat_value['Payment']['life_hours'], 2) ?></td>
			</tr>
		<?php endforeach; ?>
	</table>


	<?
	foreach ($projectstatistics as $key => $stats) {
		foreach ($stats as $stat) {
			$stat_project[$stat['times']['customer_id']][$stat['times']['task']][$key] = round($stat[0]['sum'], 2);
		}
	}
	?>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>Customer</th>
			<th>Task</th>
			<th>akt. Monat</th>
			<th>vor. Monat</th>
			<th>Jahr</th>
			<th>Gesamt</th>
		</tr>
		<?php
		foreach ($stat_project as $cust_key => $stat_customer) {
			foreach ($stat_customer as $task_key => $stat_task) {

				if (!isset($stat_task['this_month'])) {
					$stat_task['this_month'] = '';
				}
				if (!isset($stat_task['last_month'])) {
					$stat_task['last_month'] = '';
				}
				if (!isset($stat_task['year'])) {
					$stat_task['year'] = '';
				}
				if (!isset($stat_task['life'])) {
					$stat_task['life'] = '';
				}
				?>
				<tr>
					<td><?php echo $customers[$cust_key] ?></td>
					<td><?php echo $task_key ?></td>
					<td><?php echo $stat_task['this_month'] ?></td>
					<td><?php echo $stat_task['last_month'] ?></td>
					<td><?php echo $stat_task['year'] ?></td>
					<td><?php echo $stat_task['life'] ?></td>
				</tr>
			<?php
			}
		}?>
	</table>

<?php } ?>

<table cellpadding="0" cellspacing="0">
	<tr>
		<th>Jahr</th>
		<th>Monat</th>
		<th>Stunden</th>
	</tr>
	<?php

	foreach ($monthly_stats as $stats) {

		?>
		<tr>
			<td><?php echo $stats[0]['year'] ?></td>
			<td><?php echo $stats[0]['month'] ?></td>
			<td><?php echo round($stats[0]['sum']); ?></td>
		</tr>
	<?php
	}
	?>
</table>

</div>
