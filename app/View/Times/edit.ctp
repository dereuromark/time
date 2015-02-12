<div class="row">
	<div class="well span6">

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

		echo $this->Form->create(
			'Time',
			array(
				'url' => array(
					'action' => 'edit',
					$this->request->data['Time']['id']
				),
				'method' => 'post',
				'class' => 'form-horizontal'
			)
		); ?>
		<legend>Edit Time</legend>

		<?php echo $this->Form->input('start', array('type' => 'text')); ?>
		<?php echo $this->Form->input('stop', array('type' => 'text')); ?>

		<?php echo $this->Form->input('break', array('label' => 'Pause')); ?>


		<?php echo $this->Form->input('customer_id', array('type' => 'hidden', 'value' => 37)); ?>
		<?php echo $this->Form->input(
			'task',
			array('label' => 'Aufgabenbereich', 'options' => $abteilungen, 'type' => 'select')
		); ?>
		<?php echo $this->Form->input('note', array('label' => 'Notiz')); ?>

		<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>
		<?php echo $this->Form->input('user_id', array('type' => 'hidden')); ?>

		<?php echo $this->Form->end(
			array(
				'label' => 'Speichern',
				'div' => false,
				'class' => 'btn btn-success pull-right',
			)
		);    ?>

	</div>
</div>