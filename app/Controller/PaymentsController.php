<?php

class PaymentsController extends AppController {

	var $name = 'Payments';
	var $helpers = array('Html', 'Form');

	function beforeFilter() {
		parent::beforeFilter();
		if ($this->groupid != 1) {
			$this->flash('You are not allowed to use this function', '/times/index');
			exit(0);
		}
	}

	function index() {
		$this->Payment->recursive = 0;
		$this->set('Payments', $this->Payment->findAll());

		$statistics['Marco'] = $this->Payment->statistics(1);
		$statistics['Markus'] = $this->Payment->statistics(2);
		$statistics['Stefan'] = $this->Payment->statistics(3);
		$statistics['David'] = $this->Payment->statistics(4);

		$this->set('statistics', $statistics);
	}

	function view($id = null) {
		if (!$id) {
			$this->flash('Invalid id for Payment', '/payments/index');
		}
		$this->set('Payment', $this->Payment->read(null, $id));
	}

	function add() {
		if (empty($this->data)) {
			$this->set('Users', $this->Payment->User->find('list'));
			$this->render();
		} else {
			$this->cleanUpFields();
			if ($this->Payment->save($this->data)) {
				$this->flash('Payment saved.', '/times/index');
			} else {
			}
		}
	}
}

?>