<div class="row">
	<div class="well span6">

		<?php
		$abteilungen = [
			'marketing' => 'Marketing',
			'kundenkontakt' => 'Kundenkontakt',
			'entwicklung' => 'Entwicklung',
			'server' => 'Server/Infra.',
			'organisation' => 'Organisation/Personal',
			'product_m' => 'ProduktM.',
			'business_dev' => 'BusinessDev'
		];

		echo $this->Form->create(
			'Time',
			[
				'url' => [
					'action' => 'edit',
					$this->request->data['Time']['id']
				],
				'method' => 'post',
				'class' => 'form-horizontal'
			]
		); ?>
		<legend>Edit Time</legend>

		<?php echo $this->Form->input('start', ['type' => 'text']); ?>
		<?php echo $this->Form->input('stop', ['type' => 'text']); ?>

		<?php echo $this->Form->input('break', ['label' => 'Pause']); ?>


		<?php echo $this->Form->input('customer_id', ['type' => 'hidden', 'value' => 37]); ?>
		<?php echo $this->Form->input(
			'task',
			['label' => 'Aufgabenbereich', 'options' => $abteilungen, 'type' => 'select']
		); ?>
		<?php echo $this->Form->input('note', ['label' => 'Notiz']); ?>

		<?php echo $this->Form->input('id', ['type' => 'hidden']); ?>
		<?php echo $this->Form->input('user_id', ['type' => 'hidden']); ?>

		<?php echo $this->Form->end(
			[
				'label' => 'Speichern',
				'div' => false,
				'class' => 'btn btn-success pull-right',
			]
		);    ?>

	</div>
</div>