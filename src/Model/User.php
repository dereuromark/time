<?php

namespace App\Model;

use App\Model\AppModel;

class User extends AppModel {

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