<?php

class CustomersController extends AppController {

	var $name = 'Customers';
	var $helpers = array('Html', 'Form');

	function beforeFilter() {
		parent::beforeFilter();
		if ($this->groupid != 1) {
			$this->flash('You are not allowed to use this function', '/times/index');
		}
	}

	function index() {
		$this->Customer->recursive = 0;
		$this->set('Customers', $this->Customer->findAll());
	}

	function view($id = null) {
		if (!$id) {
			$this->flash('Invalid id for Customer', '/Customers/index');
		}
		$this->set('Customer', $this->Customer->read(null, $id));
	}

	function add() {
		if (empty($this->data)) {
			$this->render();
		} else {
			$this->cleanUpFields();
			if ($this->Customer->save($this->data)) {
				$this->flash('Customer saved.', '/Customers/index');
			} else {
			}
		}
	}

	function edit($id = null) {
		if (empty($this->data)) {
			if (!$id) {
				$this->flash('Invalid id for Customer', '/Customers/index');
			}
			$this->data = $this->Customer->read(null, $id);
		} else {
			$this->cleanUpFields();
			if ($this->Customer->save($this->data)) {
				$this->flash('Customer saved.', '/Customers/index');
			} else {
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->flash('Invalid id for Customer', '/Customers/index');
		}
		if ($this->Customer->del($id)) {
			$this->flash('Customer deleted: id ' . $id . '.', '/Customers/index');
		}
	}

}

?>