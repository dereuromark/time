<?php

namespace App\Model\Table;

class UsersTable extends AppTable {

	public $displayField = 'name';

	public $belongsTo = [
		'Group' => [
			'className' => 'Group',
			'conditions' => '',
			'order' => '',
			'foreignKey' => 'group_id'
		]
	];

	public $hasMany = [
		'Payment' => [
			'className' => 'Payment',
			'conditions' => '',
			'order' => '',
			'foreignKey' => 'user_id'
		]
	];
}
