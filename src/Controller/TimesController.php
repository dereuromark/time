<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

class TimesController extends AppController {

	public $helpers = ['Html', 'Form'];

	public $modelClass = 'Times';

	public function index($count = 30) {
		if ($task = $this->request->query('task')) {
			$this->request->data['task'] = $task;
		}

		/* Wenn schon gestartet, dann Werte in Stop-Formular ausgeben */
		$conditions = "user_id = '" . $this->userid . "' AND stop IS null";
		$time = $this->Times->find()->where($conditions)->first();
		if ($time) {
			$this->set('startedTime', 1);
			//$this->request->data = $result;
		}
		$customers = $this->Times->Customers->find('list');
		$users = $this->Times->Users->find('list');

		if ($this->groupid == 1) {
			foreach ($users as $id => $username) {
				$statistics[$username]['Time'] = $this->Times->statistics($id);
				$statistics[$username]['Payment'] = $this->Times->Users->Payments->statistics($id);
			}
			$params = [
				'order' => 'start DESC',
				'limit' => intval($count)
			];
		} else {
			$params = [
				'conditions' => [
					'Time.user_id' => $this->userid
				],
				'order' => 'start DESC',
				'limit' => intval($count)
			];
			$statistics[$users[$this->userid]]['Time'] = $this->Times->statistics($this->userid);
			$statistics[$users[$this->userid]]['Payment'] = $this->Times->Users->Payments->statistics($this->userid);
		}

		$userId = $this->request->query('user_id');
		if ($userId) {
			$params['conditions']['Times.user_id'] = $userId;
		}

		$customerId = (int)$this->request->query('customer_id');
		if ($customerId) {
			$params['conditions']['Times.customer_id'] = $customerId;
			$this->set(
				'projectstatistics',
				$this->Times->projectstatistics($customerId)
			);
			$this->set('monthly_stats', $this->Times->monthly_stats($customerId));
		} else {
			$this->set('projectstatistics', $this->Times->projectstatistics('all'));
			$this->set('monthly_stats', $this->Times->monthly_stats('all'));
		}
		//$params['conditions']['Times.id'] = 1;
		$params['contain'][] = 'Users';
		$params['contain'][] = 'Customers';

		$times = $this->Times->find('all', $params);

		$this->set('customers', $customers->toArray());
		$this->set('users', $users->toArray());
		$this->set('times', $times->toArray());
		$this->set('statistics', $statistics);

		if (!$time) {
			$time = $this->Times->newEntity();
		}
		$this->set(compact('time'));
	}

	public function indexCustomer($customer = null, $count = 30) {
		//$this->Times->recursive = 0;
		/* Wenn schon gestartet, dann Werte in Stop-Formular ausgeben */
		$conditions = "Times.user_id = '" . $this->userid . "' AND Times.stop IS NULL";
		$result = $this->Times->find('first', ['conditions' => $conditions]);
		if ($result) {
			$this->set('startedTime', 1);
			$this->request->data = $result;
		}
		$this->set('customers', $this->Times->Customers->find('list'));

		if ($this->groupid == 1) {
			$this->set(
				'times',
				$this->Times->find(
					'all',
					[
						'conditions' => [
							'Customer.id' => $customer,
						],
						'order' => 'start DESC',
						'limit' => intval($count)
					]
				)
			);
		} else {
			$this->set(
				'times',
				$this->Times->find(
					'all',
					[
						'contain' => ['Customers'],
						'conditions' => [
							'Customers.id' => $customer,
							'Times.user_id' => $this->userid,
						],
						'order' => 'start DESC',
						'limit' => intval($count)
					]
				)
			);
		}

		$statistics = [];
		$statistics['Marco']['Time'] = $this->Times->statistics(1);
		$statistics['Markus']['Time'] = $this->Times->statistics(2);
		$statistics['Stephan']['Time'] = $this->Times->statistics(3);
		$statistics['David']['Time'] = $this->Times->statistics(4);

		$statistics['Marco']['Payment'] = $this->Times->Users->Payments->statistics(1);
		$statistics['Markus']['Payment'] = $this->Times->Users->Payments->statistics(2);
		$statistics['Stephan']['Payment'] = $this->Times->Users->Payments->statistics(3);
		$statistics['David']['Payment'] = $this->Times->Users->Payments->statistics(4);

		$this->set('projectstatistics', $this->Times->projectstatistics($customer));
		$this->set('monthly_stats', $this->Times->monthly_stats($customer));

		$this->set('statistics', $statistics);
	}

	public function start() {
		$this->request->allowMethod('post');

		/* Check if entry already exists */
		$conditions = "Times.user_id = '" . $this->userid . "' AND Times.stop IS null";
		$result = $this->Times->find('first', ['conditions' => $conditions]);
		if ($result) {
			$this->Flash->error('Du arbeitest doch schon');
			return $this->redirect('/times/index');
		}

		$time = $this->Times->newEntity();
		$this->request->data['user_id'] = $this->userid;
		$this->request->data['start'] = new \Cake\I18n\Time();
		$this->request->data['break'] = 0;

		$entity = $this->Times->patchEntity($time, $this->request->data);
		if ($this->Times->save($entity)) {
			$this->Flash->success('Started, Wohoo!');
			return $this->redirect('/times/index');
		} else {
			$this->Flash->error('Please correct errors below.');
			//$this->set('users', $this->Times->Users->find('list'));
			//$this->set('customers', $this->Times->Customers->find('list'));
			return $this->redirect('/times/index');
		}
		//$this->set(compact('time'));
	}

	public function stop() {
		$time = $this->Times->find(
			'first',
			[
				'conditions' => "Times.user_id = '" . $this->userid . "' AND Times.stop IS NULL",
				'fields' => ['id']
			]
		);
		if (!$time) {
			throw new NotFoundException();
		}

		$this->request->data['stop'] = new \Cake\I18n\Time();
		$time = $this->Times->patchEntity($time, $this->request->data);
		if ($this->Times->save($time)) {
			$this->Flash->success('Stopped, Wohoo!');
			return $this->redirect('/times/index');
		} else {
			$this->Flash->error('Please correct errors below.');
			//$this->set('users', $this->Times->User->find('list'));
			//$this->set('customers', $this->Times->Customers->find('list'));
			return $this->redirect('/times/index');
		}
	}

	public function edit($id = null) {
		$time = $this->Times->find('first', [
			'conditions' =>
				"Times.id = $id AND Times.user_id = $this->userid AND Times.start > DATE_SUB(CURRENT_DATE, INTERVAL 4 DAY) "
		]);
		if (!$time) {
			$this->Flash->error('Entry too old or inexistent');
			return $this->redirect('/times/index');
		}

		if ($this->request->is(['post', 'put'])) {
			// Only own ids
			$this->request->data['id'] = $id;
			$this->request->data['user_id'] = $this->userid;

			$start = \Cake\I18n\Time::parseDateTime($this->request->data['start']);
			if ($start->addDays(5)->timestamp < time()) {
				$this->Flash->error('Entry gets too old');
				return $this->redirect('/times/index');
			}
			$time = $this->Times->patchEntity($time, $this->request->data);

			if ($this->Times->save($time)) {
				$this->Flash->success('The Time has been saved');
				return $this->redirect('/times/index');
			}
			$this->Flash->error('Please correct errors below.');
		}

		$this->set('customers', $this->Times->Customers->find('list'));
		$this->set(compact('time'));
	}

	public function delete($id = null) {
		if (!$id || !($record = $this->Times->find('first', ['conditions' => "Times.id = $id AND Times.user_id = $this->userid"]))) {
			$this->Flash->error('Invalid id for Time');
			return $this->redirect('/times/index');
		}
		if ($this->Times->delete($record)) {
			$this->Flash->success('The Time deleted: id ' . $id);
			return $this->redirect('/times/index');
		}
	}

	public function export($count = 100, $user = null) {
		$this->layout = 'plain';
		//$this->Times->recursive = 0;
		/* Wenn schon gestartet, dann Werte in Stop-Formular ausgeben */
		$conditions = "Times.user_id = '" . $this->userid . "' AND Times.stop IS NULL";
		$time = $this->Times->find('first', ['conditions' => $conditions]);
		if ($time) {
			$this->set('startedTime', 1);
			$this->request->data = $time;
		}
		$this->set('customers', $this->Times->Customers->find('list'));

		if ($this->groupid == 1 && !$user) {
			$this->set('times', $this->Times->find('all', ['order' => 'start DESC']));
		} elseif ($this->groupid == 1 && $user) {
			$this->set('times', $this->Times->find('all', ['conditions' => "Times.user_id = $user", 'order' => 'start DESC']));
		} else {
			$this->set(
				'times',
				$this->Times->find('all', ['conditions' => "Times.user_id = $this->userid", 'order' => 'start DESC'])
			);
		}
	}

	public function export_customer($customer) {
		$this->layout = 'plain';
		//$this->Times->recursive = 0;

		$this->set('times', $this->Times->find('all', ['conditions' => "Customer.id = $customer", 'order' => 'start DESC']));
	}
}
