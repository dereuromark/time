<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class PaymentsController extends AppController {

	public $helpers = ['Html', 'Form'];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		if ($this->groupid != 1) {
			$this->Flash->message('You are not allowed to use this function'); return $this->redirect('/times/index');
		}
	}

	public function index() {
		$this->Payments->recursive = 0;
		$this->set('Payments', $this->Payments->find('all'));

		$statistics['Marco'] = $this->Payments->statistics(1);
		$statistics['Markus'] = $this->Payments->statistics(2);
		$statistics['Stefan'] = $this->Payments->statistics(3);
		$statistics['David'] = $this->Payments->statistics(4);

		$this->set('statistics', $statistics);
	}

	public function view($id = null) {
		if (!$id) {
			$this->Flash->message('Invalid id for Payment'); return $this->redirect('/payments/index');
		}
		$this->set('Payment', $this->Payments->findById($id));
	}

	public function add() {
		if (empty($this->request->data)) {
			$this->set('Users', $this->Payments->User->find('list'));
			$this->render();
		} else {
			$this->cleanUpFields();
			if ($this->Payments->save($entity)) {
				$this->Flash->message('Payment saved.'); return $this->redirect('/times/index');
			}
		}
	}
}
