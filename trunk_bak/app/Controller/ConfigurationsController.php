<?php
App::uses('AppController', 'Controller');
/**
 * Configurations Controller
 *
 * @property Configuration $Configuration
 */
class ConfigurationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Configuration->recursive = 0;
		$this->set('configurations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid configuration'));
		}
		$this->set('configuration', $this->Configuration->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Configuration->create();
			if ($this->Configuration->save($this->request->data)) {
				$this->Session->setFlash(__('The configuration has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The configuration could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid configuration'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Configuration->save($this->request->data)) {
				$this->Session->setFlash(__('The configuration has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The configuration could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Configuration->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid configuration'));
		}
		if ($this->Configuration->delete()) {
			$this->Session->setFlash(__('Configuration deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Configuration was not deleted.'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Configuration->recursive = 0;
		$this->set('configurations', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid configuration'));
		}
		$this->set('configuration', $this->Configuration->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Configuration->create();
			if ($this->Configuration->save($this->request->data)) {
				$this->Session->setFlash(__('The configuration has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The configuration could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid configuration'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Configuration->save($this->request->data)) {
				$this->Session->setFlash(__('The configuration has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The configuration could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Configuration->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Configuration->id = $id;
		if (!$this->Configuration->exists()) {
			throw new NotFoundException(__('Invalid configuration'));
		}
		if ($this->Configuration->delete()) {
			$this->Session->setFlash(__('Configuration deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Configuration was not deleted.'));
		$this->redirect(array('action' => 'index'));
	}
}
