<?php

namespace App\Controller;

use App\Controller\AppController;

class PaymentsController extends AppController {


	public $helpers = ['Html', 'Form'];

	public function beforeFilter() {
		parent::beforeFilter();
		if ($this->groupid != 1) {
			return $this->flash('You are not allowed to use this function', '/times/index');
			exit(0);
		}
	}

	public function index() {
		$this->Payment->recursive = 0;
		$this->set('Payments', $this->Payment->find('all'));

		$statistics['Marco'] = $this->Payment->statistics(1);
		$statistics['Markus'] = $this->Payment->statistics(2);
		$statistics['Stefan'] = $this->Payment->statistics(3);
		$statistics['David'] = $this->Payment->statistics(4);

		$this->set('statistics', $statistics);
	}

	public function view($id = null) {
		if (!$id) {
			return $this->flash('Invalid id for Payment', '/payments/index');
		}
		$this->set('Payment', $this->Payment->findById($id));
	}

	public function add() {
		if (empty($this->request->data)) {
			$this->set('Users', $this->Payment->User->find('list'));
			$this->render();
		} else {
			$this->cleanUpFields();
			if ($this->Payment->save($this->request->data)) {
				return $this->flash('Payment saved.', '/times/index');
			} else {
			}
		}
	}
}

?>