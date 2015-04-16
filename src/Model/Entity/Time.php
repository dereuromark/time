<?php
namespace App\Model\Entity;

use App\Model\Entity\AppEntity;

class Time extends AppEntity {

	public static function tasks($value = null) {
		$tasks = ['marketing' => 'Marketing',
			'kundenkontakt' => 'Kundenkontakt',
			'entwicklung' => 'Entwicklung',
			'server' => 'Server/Infra.',
			'organisation' => 'Organisation/Personal',
			'product_m' => 'ProduktM.',
			'business_dev' => 'BusinessDev'
		];
		return parent::enum($value, $tasks);
	}

}
