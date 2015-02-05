<?php
App::uses('AppController', 'Controller');
/**
 * CoursePasswords Controller
 *
 * @property CoursePassword $CoursePassword
 */
class CoursePasswordsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CoursePassword->recursive = 0;
		$this->set('coursePasswords', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CoursePassword->id = $id;
		if (!$this->CoursePassword->exists()) {
			throw new NotFoundException(__('Invalid course password'));
		}
		$this->set('coursePassword', $this->CoursePassword->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CoursePassword->create();
			if ($this->CoursePassword->save($this->request->data)) {
				$this->Session->setFlash(__('The course password has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course password could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CoursePassword->Course->find('list');
		$this->set(compact('courses'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CoursePassword->id = $id;
		if (!$this->CoursePassword->exists()) {
			throw new NotFoundException(__('Invalid course password'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CoursePassword->save($this->request->data)) {
				$this->Session->setFlash(__('The course password has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course password could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CoursePassword->read(null, $id);
		}
		$courses = $this->CoursePassword->Course->find('list');
		$this->set(compact('courses'));
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
		$this->CoursePassword->id = $id;
		if (!$this->CoursePassword->exists()) {
			throw new NotFoundException(__('Invalid course password'));
		}
		if ($this->CoursePassword->delete()) {
			$this->Session->setFlash(__('Course password deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course password was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CoursePassword->recursive = 0;
		$this->set('coursePasswords', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->CoursePassword->id = $id;
		if (!$this->CoursePassword->exists()) {
			throw new NotFoundException(__('Invalid course password'));
		}
		$this->set('coursePassword', $this->CoursePassword->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CoursePassword->create();
			if ($this->CoursePassword->save($this->request->data)) {
				$this->Session->setFlash(__('The course password has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course password could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CoursePassword->Course->find('list');
		$this->set(compact('courses'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->CoursePassword->id = $id;
		if (!$this->CoursePassword->exists()) {
			throw new NotFoundException(__('Invalid course password'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CoursePassword->save($this->request->data)) {
				$this->Session->setFlash(__('The course password has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course password could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CoursePassword->read(null, $id);
		}
		$courses = $this->CoursePassword->Course->find('list');
		$this->set(compact('courses'));
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
		$this->CoursePassword->id = $id;
		if (!$this->CoursePassword->exists()) {
			throw new NotFoundException(__('Invalid course password'));
		}
		if ($this->CoursePassword->delete()) {
			$this->Session->setFlash(__('Course password deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course password was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
