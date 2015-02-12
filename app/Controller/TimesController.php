<?php

class TimesController extends AppController {

	var $name = 'Times';
	var $helpers = array('Html', 'Form');
	var $uses = array('Time', 'Payment', 'User');

	function index($count = 30) {

		$this->Time->recursive = 0;
		/* Wenn schon gestartet, dann Werte in Stop-Formular ausgeben */
		if ($this->Time->hasAny("Time.user_id = '" . $this->userid . "' AND Time.stop = '0000-00-00 00:00:00'")) {
			$this->set('startedTime', 1);
			$this->request->data = $this->Time->find(
				'first',
				array('conditions' => "Time.user_id = '" . $this->userid . "' AND Time.stop = '0000-00-00 00:00:00'")
			);
		}
		$customers = $this->Time->Customer->find('list');
		$users = $this->User->find('list');

		if ($this->groupid == 1) {
			foreach ($users as $id => $username) {
				$statistics[$username]['Time'] = $this->Time->statistics($id);
				$statistics[$username]['Payment'] = $this->Payment->statistics($id);
			}
			$params = array(
				'order' => 'start DESC',
				'limit' => intval($count)
			);
		} else {
			$params = array(
				'conditions' => array(
					'Time.user_id' => $this->userid
				),
				'order' => 'start DESC',
				'limit' => intval($count)
			);
			$statistics[$users[$this->userid]]['Time'] = $this->Time->statistics($this->userid);
			$statistics[$users[$this->userid]]['Payment'] = $this->Payment->statistics($this->userid);
		}

		if (isset($this->request->named['user_id'])) {
			$params['conditions']['Time.user_id'] = intval($this->request->named['user_id']);
		}

		if (isset($this->request->named['customer_id'])) {
			$params['conditions']['Time.customer_id'] = intval($this->request->named['customer_id']);
			$this->set(
				'projectstatistics',
				$this->Time->projectstatistics(intval($this->request->named['customer_id']))
			);
			$this->set('monthly_stats', $this->Time->monthly_stats(intval($this->request->named['customer_id'])));
		} else {
			$this->set('projectstatistics', $this->Time->projectstatistics('all'));
			$this->set('monthly_stats', $this->Time->monthly_stats('all'));
		}

		$times = $this->Time->find('all', $params);

		$this->set('customers', $customers);
		$this->set('users', $users);
		$this->set('times', $times);
		$this->set('statistics', $statistics);
	}

	function index_customer($customer, $count = 30) {
		$this->Time->recursive = 0;
		/* Wenn schon gestartet, dann Werte in Stop-Formular ausgeben */
		if ($this->Time->hasAny("Time.user_id = '" . $this->userid . "' AND Time.stop = '0000-00-00 00:00:00'")) {
			$this->set('startedTime', 1);
			$this->request->data = $this->Time->find(
				'first',
				array('conditions' => "User.id = '" . $this->userid . "' AND Time.stop = '0000-00-00 00:00:00'")
			);
		}
		$this->set('customers', $this->Time->Customer->find('list'));

		if ($this->groupid == 1) {
			$this->set(
				'times',
				$this->Time->find(
					'all',
					array(
						'conditions' => array(
							'Customer.id' => $customer,
						),
						'order' => 'start DESC',
						'limit' => intval($count)
					)
				)
			);
		} else {
			$this->set(
				'times',
				$this->Time->find(
					'all',
					array(
						'conditions' => array(
							'Customer.id' => $customer,
							'Time.user_id' => $this->userid,
						),
						'order' => 'start DESC',
						'limit' => intval($count)
					)
				)
			);
		}

		$statistics['Marco']['Time'] = $this->Time->statistics(1);
		$statistics['Markus']['Time'] = $this->Time->statistics(2);
		$statistics['Stefan']['Time'] = $this->Time->statistics(3);
		$statistics['David']['Time'] = $this->Time->statistics(4);

		$statistics['Marco']['Payment'] = $this->Payment->statistics(1);
		$statistics['Markus']['Payment'] = $this->Payment->statistics(2);
		$statistics['Stefan']['Payment'] = $this->Payment->statistics(3);
		$statistics['David']['Payment'] = $this->Payment->statistics(4);

		$this->set('projectstatistics', $this->Time->projectstatistics($customer));
		$this->set('monthly_stats', $this->Time->monthly_stats($customer));

		$this->set('statistics', $statistics);
	}

	function start() {
		/* Check if entry already exists */
		if ($this->Time->hasAny("Time.user_id = '" . $this->userid . "' AND Time.stop = '0000-00-00 00:00:00'")) {
			$this->flash('Du arbeitest doch schon', '/times/index');
			exit();
		}

		$this->request->data['Time']['user_id'] = $this->userid;
		$this->request->data['Time']['start'] = date('Y-m-d H:i:s');
		$this->request->data['Time']['break'] = 0;

		if ($this->Time->save($this->request->data)) {
			$this->Session->setFlash('Started, Wohoo!', 'message_ok');
			$this->redirect('/times/index');
		} else {
			$this->Session->setFlash('Please correct errors below.', 'message_error');
			$this->set('users', $this->Time->User->find('list'));
			$this->set('customers', $this->Time->Customer->find('list'));
			$this->redirect('/times/index');
		}
	}

	function stop() {
		$db_entry = $this->Time->find(
			'first',
			array(
				'conditions' => "Time.user_id = '" . $this->userid . "' AND Time.stop = '0000-00-00 00:00:00'",
				'fields' => Array('id')
			)
		);

		$this->request->data['Time'] = am($this->request->data['Time'], $db_entry['Time']);
		$this->request->data['Time']['stop'] = date('Y-m-d H:i:s');
		if ($this->Time->save($this->request->data)) {
			$this->Session->setFlash('Stopped, Wohoo!', 'message_ok');
			$this->redirect('/times/index');
		} else {
			$this->Session->setFlash('Please correct errors below.', 'message_error');
			$this->set('users', $this->Time->User->find('list'));
			$this->set('customers', $this->Time->Customer->find('list'));
			$this->redirect('/times/index');
		}
	}

	function edit($id = null) {
		if (empty($this->request->data)) {
			if (!$id || !$this->Time->hasAny("Time.id = $id AND Time.user_id = $this->userid")) {
				$this->Session->setFlash('Invalid id for Time', 'message_error');
				$this->redirect('/times/index');
				exit();
			}
			if (!$this->Time->hasAny("Time.id = $id AND Time.start > DATE_SUB(CURRENT_DATE, INTERVAL 4 DAY) ")) {
				$this->Session->setFlash('Entry too old', 'message_error');
				$this->redirect('/times/index');
				exit();
			}
			$this->request->data = $this->Time->find(
				'first',
				array('conditions' => "Time.id = $id AND Time.user_id = $this->userid")
			);

		} elseif ($this->Time->hasAny(
			"Time.id = $id AND Time.user_id = $this->userid AND Time.start > DATE_SUB(CURRENT_DATE, INTERVAL 4 DAY) "
		)
		) {
			// Only own ids
			$this->request->data['Time']['id'] = $id;
			$this->request->data['Time']['user_id'] = $this->userid;

			if (strtotime($this->request->data['Time']['start']) - strtotime('-5 days') < 0) {
				$this->Session->setFlash('Entry gets too old', 'message_error');
				$this->redirect('/times/index');
				exit();
			}
			if ($this->Time->save($this->request->data)) {
				$this->Session->setFlash('The Time has been saved', 'message_ok');
				$this->redirect('/times/index');
			} else {
				$this->Session->setFlash('Please correct errors below.', 'message_error');
			}
		}

		$this->set('customers', $this->Time->Customer->find('list'));
	}

	function delete($id = null) {
		if (!$id || !$this->Time->hasAny("Time.id = $id AND Time.user_id = $this->userid")) {
			$this->Session->setFlash('Invalid id for Time', 'message_error');
			$this->redirect('/times/index');
			exit();
		}
		if ($this->Time->hasAny("Time.id = $id AND Time.user_id = $this->userid") && $this->Time->delete($id)) {
			$this->Session->setFlash('The Time deleted: id ' . $id, 'message_ok');
			$this->redirect('/times/index');
		}
	}

	function export($count = 100, $user = null) {
		$this->layout = 'plain';
		$this->Time->recursive = 0;
		/* Wenn schon gestartet, dann Werte in Stop-Formular ausgeben */
		if ($this->Time->hasAny("Time.user_id = '" . $this->userid . "' AND Time.stop = '0000-00-00 00:00:00'")) {
			$this->set('startedTime', 1);
			$this->request->data = $this->Time->find(
				'first',
				array('conditions' => "Time.user_id = '" . $this->userid . "' AND Time.stop = '0000-00-00 00:00:00'")
			);
		}
		$this->set('customers', $this->Time->Customer->find('list'));

		if ($this->groupid == 1 && $user == null) {
			$this->set('times', $this->Time->findAll(null, null, 'start DESC', intval($count)));
		} elseif ($this->groupid == 1 && $user != null) {
			$this->set('times', $this->Time->findAll("Time.user_id = $user", null, 'start DESC', intval($count)));
		} else {
			$this->set(
				'times',
				$this->Time->findAll("Time.user_id = $this->userid", null, 'start DESC', intval($count))
			);
		}

	}

	function export_customer($customer) {
		$this->layout = 'plain';
		$this->Time->recursive = 0;

		$this->set('times', $this->Time->findAll("Customer.id = $customer", null, 'start DESC', intval($count)));
	}
}

?>