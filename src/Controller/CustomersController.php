<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class CustomersController extends AppController {

	public $helpers = ['Html', 'Form'];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		if ($this->groupid != 1) {
			return $this->flash('You are not allowed to use this function', '/times/index');
		}
	}

	public function index() {
		$this->Customer->recursive = 0;
		$this->set('Customers', $this->Customer->find('all'));
	}

	public function view($id = null) {
		if (!$id) {
			return $this->flash('Invalid id for Customer', '/Customers/index');
		}
		$this->set('Customer', $this->Customer->findById($id));
	}

	public function add() {
		if (empty($this->request->data)) {
			$this->render();
		} else {
			$this->cleanUpFields();
			if ($this->Customer->save($this->request->data)) {
				return $this->flash('Customer saved.', '/Customers/index');
			} else {
			}
		}
	}

	public function edit($id = null) {
		if (empty($this->request->data)) {
			if (!$id) {
				return $this->flash('Invalid id for Customer', '/Customers/index');
			}
			$this->request->data = $this->Customer->findById($id);
		} else {
			$this->cleanUpFields();
			if ($this->Customer->save($this->request->data)) {
				return $this->flash('Customer saved.', '/Customers/index');
			} else {
			}
		}
	}

	public function delete($id = null) {
		if (!$id) {
			return $this->flash('Invalid id for Customer', '/Customers/index');
		}
		if ($this->Customer->delete($id)) {
			return $this->flash('Customer deleted: id ' . $id . '.', '/Customers/index');
		}
	}

}
