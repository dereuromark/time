<?php

class User extends AppModel {
	var $name = 'User';

	var $displayField = 'name';

	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'conditions' => '',
			'order' => '',
			'foreignKey' => 'group_id'
		)
	);

	var $hasMany = array(
		'Payment' => array(
			'className' => 'Payment',
			'conditions' => '',
			'order' => '',
			'foreignKey' => 'user_id'
		)
	);
}