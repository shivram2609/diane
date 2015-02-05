<?php
App::uses('AppController', 'Controller');
/**
 * Admindetails Controller
 *
 * @property Admindetail $Admindetail
 */
class AdmindetailsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Admindetail->recursive = 0;
		$this->set('admindetails', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Admindetail->id = $id;
		if (!$this->Admindetail->exists()) {
			throw new NotFoundException(__('Invalid admindetail'));
		}
		$this->set('admindetail', $this->Admindetail->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Admindetail->create();
			if ($this->Admindetail->save($this->request->data)) {
				$this->Session->setFlash(__('The admindetail has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The admindetail could not be saved. Please, try again.'));
			}
		}
		$admins = $this->Admindetail->Admin->find('list');
		$this->set(compact('admins'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Admindetail->id = $id;
		if (!$this->Admindetail->exists()) {
			throw new NotFoundException(__('Invalid admindetail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Admindetail->save($this->request->data)) {
				$this->Session->setFlash(__('The admindetail has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The admindetail could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Admindetail->read(null, $id);
		}
		$admins = $this->Admindetail->Admin->find('list');
		$this->set(compact('admins'));
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
		$this->Admindetail->id = $id;
		if (!$this->Admindetail->exists()) {
			throw new NotFoundException(__('Invalid admindetail'));
		}
		if ($this->Admindetail->delete()) {
			$this->Session->setFlash(__('Admindetail deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Admindetail was not deleted.'), 'default', array("class"=>"success_message"));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Admindetail->recursive = 0;
		$this->set('admindetails', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Admindetail->id = $id;
		if (!$this->Admindetail->exists()) {
			throw new NotFoundException(__('Invalid admindetail'));
		}
		$this->set('admindetail', $this->Admindetail->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Admindetail->create();
			if ($this->Admindetail->save($this->request->data)) {
				$this->Session->setFlash(__('The admindetail has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The admindetail could not be saved. Please, try again.'));
			}
		}
		$admins = $this->Admindetail->Admin->find('list');
		$this->set(compact('admins'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Admindetail->id = $id;
		if (!$this->Admindetail->exists()) {
			throw new NotFoundException(__('Invalid admindetail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Admindetail->save($this->request->data)) {
				$this->Session->setFlash(__('The admindetail has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The admindetail could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Admindetail->read(null, $id);
		}
		$admins = $this->Admindetail->Admin->find('list');
		$this->set(compact('admins'));
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
		$this->Admindetail->id = $id;
		if (!$this->Admindetail->exists()) {
			throw new NotFoundException(__('Invalid admindetail'));
		}
		if ($this->Admindetail->delete()) {
			$this->Session->setFlash(__('Admindetail deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Admindetail was not deleted.'));
		$this->redirect(array('action' => 'index'));
	}
}
