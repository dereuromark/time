<?php
App::uses('AppModel', 'Model');

class Payment extends AppModel {

	public $belongsTo = [
		'User' =>
			[
				'className' => 'User',
				'conditions' => '',
				'order' => '',
				'foreignKey' => 'user_id'
			]
	];

	public function statistics($userid) {
		$stats = $this->query(
			"SELECT sum(hours) as this_month_hours, sum(hours*rate) as this_month_amount FROM `payments` WHERE created > DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(now()) DAY) and user_id = $userid"
		);
		$return['this_month_hours'] = $stats[0][0]['this_month_hours'];
		$return['this_month_amount'] = $stats[0][0]['this_month_amount'];

		$stats = $this->query(
			"SELECT sum(hours) as last_month_hours, sum(hours*rate) as last_month_amount FROM `payments` WHERE created < DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE) DAY) AND created > DATE_SUB(DATE_SUB(CURRENT_DATE,INTERVAL 30 DAY), INTERVAL DAYOFMONTH(DATE_SUB(CURRENT_DATE,INTERVAL 30 DAY)) DAY) AND user_id = $userid"
		);
		$return['last_month_hours'] = $stats[0][0]['last_month_hours'];
		$return['last_month_amount'] = $stats[0][0]['last_month_amount'];

		$stats = $this->query(
			"SELECT sum(hours) as year_hours, sum(hours*rate) as year_amount FROM `payments` WHERE created > DATE_SUB(CURRENT_DATE, INTERVAL DAYOFYEAR(now()) DAY) and user_id = $userid"
		);
		$return['year_hours'] = $stats[0][0]['year_hours'];
		$return['year_amount'] = $stats[0][0]['year_amount'];

		$stats = $this->query(
			"SELECT sum(hours) as life_hours, sum(hours*rate) as life_amount FROM `payments` WHERE user_id = $userid"
		);
		$return['life_hours'] = $stats[0][0]['life_hours'];
		$return['life_amount'] = $stats[0][0]['life_amount'];

		return $return;
	}
}
