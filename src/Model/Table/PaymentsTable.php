<?php
namespace App\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\Collection\Collection;

class PaymentsTable extends AppTable {

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
		$conn = ConnectionManager::get('default');

		$stats = $conn->query(
			"SELECT sum(hours) as this_month_hours, sum(hours*rate) as this_month_amount FROM `payments` WHERE created > DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(now()) DAY) and user_id = $userid"
		);
		$collection = new Collection($stats);
		$collection = $collection->toArray();

		$return['this_month_hours'] = $collection[0]['this_month_hours'];
		$return['this_month_amount'] = $collection[0]['this_month_amount'];

		$stats = $conn->query(
			"SELECT sum(hours) as last_month_hours, sum(hours*rate) as last_month_amount FROM `payments` WHERE created < DATE_SUB(CURRENT_DATE, INTERVAL DAYOFMONTH(CURRENT_DATE) DAY) AND created > DATE_SUB(DATE_SUB(CURRENT_DATE,INTERVAL 30 DAY), INTERVAL DAYOFMONTH(DATE_SUB(CURRENT_DATE,INTERVAL 30 DAY)) DAY) AND user_id = $userid"
		);
		$collection = new Collection($stats);
		$collection = $collection->toArray();
		$return['last_month_hours'] = $collection[0]['last_month_hours'];
		$return['last_month_amount'] = $collection[0]['last_month_amount'];

		$stats = $conn->query(
			"SELECT sum(hours) as year_hours, sum(hours*rate) as year_amount FROM `payments` WHERE created > DATE_SUB(CURRENT_DATE, INTERVAL DAYOFYEAR(now()) DAY) and user_id = $userid"
		);
		$collection = new Collection($stats);
		$collection = $collection->toArray();
		$return['year_hours'] = $collection[0]['year_hours'];
		$return['year_amount'] = $collection[0]['year_amount'];

		$stats = $conn->query(
			"SELECT sum(hours) as life_hours, sum(hours*rate) as life_amount FROM `payments` WHERE user_id = $userid"
		);
		$collection = new Collection($stats);
		$collection = $collection->toArray();
		$return['life_hours'] = $collection[0]['life_hours'];
		$return['life_amount'] = $collection[0]['life_amount'];

		return $return;
	}
}
