<?php
$abteilungen = array(
	'marketing' => 'Marketing',
	'kundenkontakt' => 'Kundenkontakt',
	'entwicklung' => 'Entwicklung',
	'server' => 'Server/Infra.',
	'organisation' => 'Organisation/Personal',
	'product_m' => 'ProduktM.',
	'business_dev' => 'BusinessDev'
);

if (!isset($startedTime)) {
	?>
	<h3 class="startbar-headline">Start Time</h3>
	<?php echo $this->Form->create('Time', array('action' => 'start', 'method' => 'post', 'class' => 'form-inline')); ?>
	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Form->input(
		'customer_id',
		array('type' => 'hidden', 'value' => 37, 'class' => 'input-medium')
	); ?>
	<?php echo $this->Form->input(
		'task',
		array(
			'type' => 'select',
			'label' => false,
			'empty' => 'Choose Team',
			'div' => false,
			'options' => $abteilungen,
			'class' => 'input-small'
		)
	); ?>
	<?php echo $this->Form->input(
		'note',
		array('label' => false, 'div' => false, 'placeholder' => 'Tätigkeit', 'size' => '20', 'class' => 'input-medium')
	); ?>
	<?php echo $this->Form->input(
		'break',
		array('label' => false, 'div' => false, 'placeholder' => 'Pause', 'size' => '3', 'class' => 'input-small')
	); ?>

	<?php echo $this->Form->end(
		array(
			'label' => 'Start',
			'class' => 'btn btn-success',
			'div' => false,
		)
	);    ?>
<?php
} else {
	?>
	<h3 class="startbar-headline">Stop Time</h3>
	<?php echo $this->Form->create('Time', array('action' => 'stop', 'method' => 'post', 'class' => 'form-inline')); ?>

	<?php echo $this->Form->input('id'); ?>
	<?php echo $this->Form->input(
		'customer_id',
		array('type' => 'hidden', 'value' => 37, 'class' => 'input-medium')
	); ?>
	<?php echo $this->Form->input(
		'task',
		array(
			'type' => 'select',
			'label' => false,
			'empty' => 'Choose Team',
			'div' => false,
			'options' => $abteilungen,
			'class' => 'input-small'
		)
	); ?>
	<?php echo $this->Form->input(
		'note',
		array('label' => false, 'div' => false, 'placeholder' => 'Tätigkeit', 'size' => '20', 'class' => 'input-medium')
	); ?>
	<?php echo $this->Form->input(
		'break',
		array('label' => false, 'div' => false, 'placeholder' => 'Pause', 'size' => '3', 'class' => 'input-small')
	); ?>

	<?php echo $this->Form->end(
		array(
			'label' => 'Stop',
			'class' => 'btn btn-danger',
			'div' => false,
		)
	);    ?>
<?php
}
?>

<div class="row">
	<div class="span10">
		<table id="timetable" class=" table table-striped table-bordered table-condensed">
			<thead>
			<tr>
				<th>Datum</th>
				<th>User</th>
				<th>Start</th>
				<th>Stop</th>
				<th>P.</th>
				<th>Dauer</th>

				<th style="width:60px">Act</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($times as $time): ?>

				<tr class="<?php echo 'individualEntry' . $time['User']['id']; ?>">
					<td><?php echo substr($time['Time']['start'], 0, 10); ?></td>
					<td><?php echo $this->Html->link(
							$time['User']['name'],
							'/times/index/user_id:' . $time['User']['id']
						) ?></td>
					<td><?php echo substr($time['Time']['start'], 10, 6); ?></td>
					<td><?php echo substr($time['Time']['stop'], 10, 6); ?></td>
					<td><?php echo $time['Time']['break']; ?></td>
					<?php
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


					<td class="actions right"><?php
						if ($userid == $time['User']['id'] && strtotime($time['Time']['start']) - strtotime(
								'-4 days'
							) > 0
						) {
							echo $this->Html->link(
									'<i class="icon-pencil"></i>',
									'/times/edit/' . $time['Time']['id'],
									array('class' => 'btn btn-mini', 'escape' => false)
								) . ' ';
							echo $this->Html->link(
								'<i class="icon-remove"></i>',
								'/times/delete/' . $time['Time']['id'],
								array('class' => 'btn btn-mini', 'escape' => false),
								'Are you sure you want to delete id ' . $time['Time']['id']
							);
						}
						?>
					</td>
				</tr>
				<tr class="border <?php echo 'individualEntry' . $time['User']['id']; ?>">
					<td colspan=7><?php echo $this->Html->link(
							$time['Customer']['name'],
							'/times/index/customer_id:' . $time['Customer']['id']
						); ?>
						| <?php if (!empty($time['Time']['task'])) {
							echo '<b>' . $time['Time']['task'] . ': </b>';
						} ?> <?php echo substr(
							$time['Time']['note'],
							0,
							60
						);
						if (strlen($time['Time']['note']) > 60) {
							echo '...';
						} ?>
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
			if (empty($stat['times']['task'])) {
				$stat['times']['task'] = ' ';
			}

			$stat_project[$stat['times']['customer_id']][$stat['times']['task']][$key] = round($stat[0]['sum'], 2);

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
										'/times/index/customer_id:' . $cust_key
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
