<?php
namespace App\Model\Table;

class TimesTable extends AppTable {

	public $belongsTo = [
		'User' => [
			'className' => 'User',
			'conditions' => '',
			'order' => '',
			'foreignKey' => 'user_id'
		],
		'Customer' => [
			'className' => 'Customer',
			'conditions' => '',
			'order' => '',
			'foreignKey' => 'customer_id'
		]
	];

	public function statistics($userid) {
		$heute = getdate();
		$query = $this->find()->where("start >= '" . $heute['year'] . '-' . sprintf("%02s", $heute['mon']) . '-01 00:00:00' . "' AND
		user_id = $userid AND
		stop IS NOT NULL");

		$sum = $query->func()->sum('((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break)');
		$query->select(['this_month' => $sum]);

		/*
		$stats = $this->query(
			"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as this_month FROM `times`
						WHERE
						start >= '" . $heute['year'] . '-' . sprintf("%02s", $heute['mon']) . '-01 00:00:00' . "' AND
			user_id = $userid AND
			stop IS NOT NULL"
		);
		*/
		$stats = $query->toArray();
		$return['this_month'] = $stats[0]['this_month'];

		$query = $this->find()->where("start < '" . $heute['year'] . '-' . sprintf("%02s", $heute['mon']) . '-01 00:00:00' . "' AND
			start >=  '" . $heute['year'] . '-' . (sprintf("%02s", $heute['mon']) - 1) . '-01 00:00:00' . "' AND
			user_id = $userid");
		$query->select(['last_month' => $sum]);
		/*
		$stats = $this->query(
			"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as last_month FROM `times`
						WHERE
						start < '" . $heute['year'] . '-' . sprintf("%02s", $heute['mon']) . '-01 00:00:00' . "' AND
			start >=  '" . $heute['year'] . '-' . (sprintf("%02s", $heute['mon']) - 1) . '-01 00:00:00' . "' AND
			user_id = $userid"
		);
		*/
		$stats = $query->toArray();
		$return['last_month'] = $stats[0]['last_month'];

		$query = $this->find()->where("start < '" . ($heute['year'] - 1) . "-12-31 23:59:59' AND
		start > '" . ($heute['year'] - 1) . "-01-01 00:00:00' AND
		user_id = $userid");
		$query->select(['last_year' => $sum]);
		/*
		$stats = $this->query(
			"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as last_year FROM `times`
						WHERE
						start < '" . ($heute['year'] - 1) . "-12-31 23:59:59' AND
			start > '" . ($heute['year'] - 1) . "-01-01 00:00:00' AND
			user_id = $userid"
		);
		*/
		$stats = $query->toArray();
		$return['last_year'] = $stats[0]['last_year'];

		$query = $this->find()->where("start >= '" . $heute['year'] . '-01-01 00:00:00' . "' and
			user_id = $userid AND
			stop IS NOT NULL");
		$query->select(['last_year' => $sum]);
		/*
		$stats = $this->query(
			"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as year FROM `times`
						WHERE
						start >= '" . $heute['year'] . '-01-01 00:00:00' . "' and
			user_id = $userid AND
			stop IS NOT NULL"
		);
		*/
		$stats = $query->toArray();
		$return['year'] = $stats[0]['year'];

		$query = $this->find()->where("user_id = $userid AND stop IS NOT NULL");
		$query->select(['life' => $sum]);
		/*
		$stats = $this->query(
			"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as life FROM `times`
			WHERE
			user_id = $userid AND
			stop IS NOT NULL"
		);
		*/
		$stats = $query->toArray();
		$return['life'] = $stats[0]['life'];

		return $return;
	}

	public function projectstatistics($data) {

		if ($data === 'all') {
			$heute = getdate();
			$stats['this_month'] = $this->query(
				"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`, customer_id FROM `times` Where
								start >= '" . $heute['year'] . '-' . sprintf("%02s", $heute['mon']) . '-01 00:00:00' . "' and
				stop IS NOT NULL
				GROUP BY customer_id order by start desc, customer_id desc"
			);
			$stats['last_month'] = $this->query(
				"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`, customer_id FROM `times` Where
								start <  '" . $heute['year'] . '-' . sprintf("%02s", $heute['mon']) . '-01 00:00:00' . "' AND
				start >= '" . $heute['year'] . '-' . (sprintf("%02s", $heute['mon']) - 1) . '-01 00:00:00' . "' AND
				stop IS NOT NULL
				GROUP BY customer_id order by start desc, customer_id desc"
			);
			$stats['year'] = $this->query(
				"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`, customer_id FROM `times` Where
								start >= '" . $heute['year'] . '-01-01 00:00:00' . "' and
				stop IS NOT NULL
				GROUP BY customer_id order by start desc, customer_id desc "
			);
			$stats['life'] = $this->query(
				"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`, customer_id FROM `times` Where
								stop IS NOT NULL
								GROUP BY customer_id order by start desc, customer_id desc "
			);

			return $stats;
		}
		if (is_numeric($data)) {
			$heute = getdate();
			$stats['this_month'] = $this->query(
				"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`, customer_id, task FROM `times` Where customer_id = $data and
				start >= '" . $heute['year'] . '-' . sprintf("%02s", $heute['mon']) . '-01 00:00:00' . "' and
				stop IS NOT NULL
				GROUP BY task, customer_id order by start desc, customer_id desc, task asc "
			);
			$stats['last_month'] = $this->query(
				"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`, customer_id, task FROM `times` Where  customer_id = $data and
				start <  '" . $heute['year'] . '-' . sprintf("%02s", $heute['mon']) . '-01 00:00:00' . "' AND
				start >= '" . $heute['year'] . '-' . (sprintf("%02s", $heute['mon']) - 1) . '-01 00:00:00' . "' AND
				stop IS NOT NULL
				GROUP BY task, customer_id order by start desc, customer_id desc, task asc "
			);
			$stats['year'] = $this->query(
				"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`, customer_id, task FROM `times` Where   customer_id = $data and
				start >= '" . $heute['year'] . '-01-01 00:00:00' . "' and
				stop IS NOT NULL
				GROUP BY task, customer_id order by start desc, customer_id desc, task asc "
			);
			$stats['life'] = $this->query(
				"SELECT sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`, customer_id, task FROM `times` Where  customer_id = $data and
				stop IS NOT NULL
				GROUP BY task, customer_id order by start desc, customer_id desc, task asc "
			);

			return $stats;
		}
	}

	public function monthly_stats($data) {
		if ($data === 'all') {
			$stats = $this->query(
				"SELECT
								sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`,
								month(start) as month,
								year(start) as year
								FROM `times` WHERE stop IS NOT NULL
								GROUP BY year, month order by start desc, month desc "
			);
		} elseif (is_numeric($data)) {
			$stats = $this->query(
				"SELECT
				sum((UNIX_TIMESTAMP(stop)-UNIX_TIMESTAMP(start))/3600-break) as `sum`,
				month(start) as month,
				year(start) as year
				FROM `times` Where customer_id = $data AND stop IS NOT NULL
				GROUP BY year, month order by start desc "
			);

		}
		return $stats;

	}
}
