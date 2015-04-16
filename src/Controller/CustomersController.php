<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class CustomersController extends AppController {

	public $helpers = ['Html', 'Form'];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		if ($this->groupid != 1) {
			$this->Flash->message('You are not allowed to use this function'); return $this->redirect('/times/index');
		}
	}

	public function index() {
		$this->Customers->recursive = 0;
		$this->set('Customers', $this->Customers->find('all'));
	}

	public function view($id = null) {
		if (!$id) {
			$this->Flash->message('Invalid id for Customer'); return $this->redirect('/Customers/index');
		}
		$this->set('Customer', $this->Customers->findById($id));
	}

	public function add() {
		if (empty($this->request->data)) {

		} else {
			$this->cleanUpFields();
			if ($this->Customers->save($entity)) {
				$this->Flash->message('Customer saved.'); return $this->redirect('/Customers/index');
			}
		}
	}

	public function edit($id = null) {
		if (empty($this->request->data)) {
			if (!$id) {
				$this->Flash->message('Invalid id for Customer'); return $this->redirect('/Customers/index');
			}
			$this->request->data = $this->Customers->findById($id);
		} else {
			$this->cleanUpFields();
			if ($this->Customers->save($entity)) {
				$this->Flash->message('Customer saved.'); return $this->redirect('/Customers/index');
			}
		}
	}

	public function delete($id = null) {
		//$this->request->allowMethod(['post', 'delete']);

		if (!$id) {
			$this->Flash->message('Invalid id for Customer'); return $this->redirect('/Customers/index');
		}
		if ($this->Customers->delete($customer)) {
			$this->Flash->message('Customer deleted: id ' . $id . '.'); return $this->redirect('/Customers/index');
		}
	}

}
