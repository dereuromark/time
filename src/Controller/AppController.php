<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace App\Controller;

use Shim\Controller\Controller;
use Cake\Core\Plugin;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $curr_user = null;

	public $components = ['Flash'];

	public $helpers = [
		'Html' => ['className' => 'BootstrapUI.Html'],
		'Form' => ['className' => 'BootstrapUI.Form'],
		//'Flash' => ['className' => 'BootstrapUI.Flash'],
		'Paginator' => ['className' => 'BootstrapUI.Paginator']
	];

	public function initialize() {
		parent::initialize();
	}

	public function beforeFilter(Event $event) {
		if (!env("REMOTE_USER")) {
			throw new NotFoundException('No User auth');
		}

		$this->loadModel('Users');
		$this->curr_user = $this->Users->find()->where(['name' => env("REMOTE_USER")])->first();
		if (count($this->curr_user)) {
			$this->userid = $this->curr_user->id;
			$this->groupid = $this->curr_user->id;

			$this->set('curr_user', $this->curr_user);
			$this->set('userid', $this->userid);
			$this->set('groupid', $this->groupid);
		} else {
			// Create User if not present yet
			$array = [
				'name' => env("REMOTE_USER"),
				'group_id' => 0
			];
			$user = $this->Users->newEntity($array, ['validate' => false]);
			$this->Users->save($user);
			return $this->redirect(['controller' => 'times', 'action' => 'index']);
		}
	}
}
