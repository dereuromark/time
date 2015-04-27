<?php

if (empty($startedTime)) {
	?>
	<h3 class="startbar-headline">Start Time</h3>
	<?php echo $this->Form->create($time, ['action' => 'start', 'method' => 'post', 'class' => 'form-inline']); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Form->input(
		'customer_id',
		['type' => 'hidden', 'value' => 37, 'class' => 'input-medium']
	); ?>
	<?php echo $this->Form->input(
		'task',
		[
			'type' => 'select',
			'label' => false,
			'empty' => 'Choose Team',
			'div' => false,
			'options' => $time->tasks(),
			'class' => 'input-small'
		]
	); ?>
	<?php echo $this->Form->input(
		'note',
		['label' => false, 'div' => false, 'placeholder' => __('Task'), 'size' => '20', 'class' => 'input-medium']
	); ?>
	<?php echo $this->Form->input(
		'break',
		['type' => 'text', 'label' => false, 'div' => false, 'placeholder' => __('Break'), 'size' => '3', 'class' => 'input-small']
	); ?>
	<?php
	echo $this->Form->input('Start', [
			'type' => 'Submit',
			'class' => 'btn btn-success',
			'label' => false
		]
	);
	?>
	<?php echo $this->Form->end();    ?>
<?php
} else {
	?>
	<h3 class="startbar-headline">Stop Time</h3>
	<?php echo $this->Form->create($time, ['action' => 'stop', 'method' => 'post', 'class' => 'form-inline']); ?>

	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Form->input(
		'customer_id',
		['type' => 'hidden', 'value' => 37, 'class' => 'input-medium']
	); ?>
	<?php echo $this->Form->input(
		'task',
		[
			'type' => 'select',
			'label' => false,
			'empty' => 'Choose Team',
			'div' => false,
			'options' => $time->tasks(),
			'class' => 'input-small'
		]
	); ?>
	<?php echo $this->Form->input(
		'note',
		['label' => false, 'div' => false, 'placeholder' => 'Tätigkeit', 'size' => '20', 'class' => 'input-medium']
	); ?>
	<?php echo $this->Form->input(
		'break',
		['type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Pause', 'size' => '3', 'class' => 'input-small']
	); ?>
	<?php
	echo $this->Form->input('Stop', [
			'type' => 'Submit',
			'class' => 'btn btn-danger',
			'label' => false,
		]
	);
	?>

	<?php echo $this->Form->end();    ?>
<?php
}
?>

<div class="row">
	<div class="span10">
		<table id="timetable" class="table table-striped table-bordered table-condensed">
			<thead>
			<tr>
				<th><?php echo __('Date');?></th>
				<th><?php echo __('User');?></th>
				<th><?php echo __('Start');?></th>
				<th><?php echo __('Stop');?></th>
				<th><?php echo __('Break');?></th>
				<th><?php echo __('Duration');?></th>

				<th style="width:60px"><?php echo __('Actions');?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($times as $time): ?>

				<tr class="<?php echo 'individualEntry' . $time->user['id']; ?>">
					<td><?php echo $this->Time->format($time['start'], 'YYYY-MM-dd'); ?>
					</td>
					<td><?php echo $this->Html->link(
							$time->user['name'],
							['controller' => 'times', 'action' => 'index', '?' => ['user_id' => $time->user['id']]]); ?></td>
					<td><?php echo $this->Time->format($time['start'], 'HH:mm'); ?></td>
					<td><?php echo $this->Time->format($time['stop'], 'HH:mm'); ?></td>
					<td><?php echo \Tools\Utility\Time::buildTime($time['break'] * HOUR); ?></td>
					<?php
					if ($time['stop']) {
						$diff = $time['stop']->diffInSeconds($time['start']) - 3600 * $time['break'];
					} else {
						$diff = 0;
					}
					?>
					<td><?php echo \Tools\Utility\Time::buildTime($diff); ?></td>


					<td class="actions right"><?php
						if ($userid == $time->user['id'] && $time['start'] && $time['start']->addDays(4)->timestamp > time()) {
							echo $this->Html->link(
									'<i class="glyphicon glyphicon-pencil"></i>',
									'/times/edit/' . $time['id'],
									['class' => 'btn btn-xs btn-default', 'escape' => false]
								) . ' ';
							echo $this->Html->link(
								'<i class="glyphicon glyphicon-remove"></i>',
								'/times/delete/' . $time['id'],
								['class' => 'btn btn-xs btn-default', 'escape' => false, 'confirm' => 'Are you sure you want to delete id ' . $time['id']]
							);
						}
						?>
					</td>
				</tr>
				<tr class="border <?php echo 'individualEntry' . $time->user['id']; ?>">
					<td colspan=7><?php echo $this->Html->link(
							$time->customer['name'],
							['controller' => 'Times', 'action' => 'index', '?' => ['customer_id' => $time->customer['id']]]
						); ?>
						| <?php if (!empty($time['task'])) {
							echo '<b>' . $time['task'] . ': </b>';
						} ?> <?php echo $this->Text->truncate(
							$time['note'],
							60
						);
						?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>


<div class="row">
	<div class="span10">
		<table class="table table-striped table-bordered table-condensed">
			<thead>
			<tr>
				<th>User</th>
				<th>curr. Month</th>
				<th>last Month</th>
				<th>Year</th>
				<th>last Year</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($statistics as $stat_user => $stat_value): ?>
				<tr>
					<td><?php echo $stat_user ?></td>
					<td><?php echo round($stat_value['Time']['this_month'], 2) ?></td>
					<td><?php echo round($stat_value['Time']['last_month'], 2) ?></td>
					<td><?php echo round($stat_value['Time']['year'], 2) ?></td>
					<td><?php echo round($stat_value['Time']['last_year'], 2) ?></td>
					<td><?php echo round($stat_value['Time']['life'] - $stat_value['Payment']['life_hours'], 2) ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<?php if ($groupid == 1) { ?>

	<?php
	foreach ($projectstatistics as $key => $stats) {
		foreach ($stats as $stat) {
			if (empty($stat['task'])) {
				$stat['task'] = ' ';
			}

			$stat_project[$stat['customer_id']][$stat['task']][$key] = round($stat[0]['sum'], 2);

		}
	}

	?>
	<div class="row">
		<div class="span7">
			<table class="table table-striped table-bordered table-condensed">
				<thead>
				<tr>
					<th>Customer</th>
					<th>Task</th>
					<th>akt. Monat</th>
					<th>vor. Monat</th>
					<th>Jahr</th>
					<th>Life</th>
				</tr>
				</thead>
				<tbody>
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
							<td><?php if (isset($customers[$cust_key])) {
									echo $this->Html->link(
										$customers[$cust_key],
										'/?customer_id=' . $cust_key
									);
								} ?>
							</td>
							<td><?php echo $task_key; ?></td>
							<td><?php echo round($stat_task['this_month']); ?></td>
							<td><?php echo round($stat_task['last_month']); ?></td>
							<td><?php echo round($stat_task['year']); ?></td>
							<td><?php echo round($stat_task['life']); ?></td>
						</tr>
					<?php
					}
				}
				?>
				</tbody>
			</table>
		</div>

		<div class="span3">
			<table class="table table-striped table-bordered table-condensed">
				<thead>
				<tr>
					<th>Jahr</th>
					<th>Monat</th>
					<th>Stunden</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($monthly_stats as $stats) { ?>
					<tr>
						<td><?php echo $stats[0]['year'] ?></td>
						<td><?php echo $stats[0]['month'] ?></td>
						<td><?php echo round($stats[0]['sum']); ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

<?php } ?>
