<?php
App::uses('AppController', 'Controller');
/**
 * CourseInstructors Controller
 *
 * @property CourseInstructor $CourseInstructor
 */
class CourseInstructorsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CourseInstructor->recursive = 0;
		$this->set('courseInstructors', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CourseInstructor->id = $id;
		if (!$this->CourseInstructor->exists()) {
			throw new NotFoundException(__('Invalid course instructor'));
		}
		$this->set('courseInstructor', $this->CourseInstructor->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CourseInstructor->create();
			if ($this->CourseInstructor->save($this->request->data)) {
				$this->Session->setFlash(__('The course instructor has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course instructor could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CourseInstructor->Course->find('list');
		$users = $this->CourseInstructor->User->find('list');
		$this->set(compact('courses', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CourseInstructor->id = $id;
		if (!$this->CourseInstructor->exists()) {
			throw new NotFoundException(__('Invalid course instructor'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseInstructor->save($this->request->data)) {
				$this->Session->setFlash(__('The course instructor has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course instructor could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseInstructor->read(null, $id);
		}
		$courses = $this->CourseInstructor->Course->find('list');
		$users = $this->CourseInstructor->User->find('list');
		$this->set(compact('courses', 'users'));
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
		$this->CourseInstructor->id = $id;
		if (!$this->CourseInstructor->exists()) {
			throw new NotFoundException(__('Invalid course instructor'));
		}
		if ($this->CourseInstructor->delete()) {
			$this->Session->setFlash(__('Course instructor deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course instructor was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CourseInstructor->recursive = 0;
		$this->set('courseInstructors', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->CourseInstructor->id = $id;
		if (!$this->CourseInstructor->exists()) {
			throw new NotFoundException(__('Invalid course instructor'));
		}
		$this->set('courseInstructor', $this->CourseInstructor->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CourseInstructor->create();
			if ($this->CourseInstructor->save($this->request->data)) {
				$this->Session->setFlash(__('The course instructor has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course instructor could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CourseInstructor->Course->find('list');
		$users = $this->CourseInstructor->User->find('list');
		$this->set(compact('courses', 'users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->CourseInstructor->id = $id;
		if (!$this->CourseInstructor->exists()) {
			throw new NotFoundException(__('Invalid course instructor'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseInstructor->save($this->request->data)) {
				$this->Session->setFlash(__('The course instructor has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course instructor could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseInstructor->read(null, $id);
		}
		$courses = $this->CourseInstructor->Course->find('list');
		$users = $this->CourseInstructor->User->find('list');
		$this->set(compact('courses', 'users'));
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
		$this->CourseInstructor->id = $id;
		if (!$this->CourseInstructor->exists()) {
			throw new NotFoundException(__('Invalid course instructor'));
		}
		if ($this->CourseInstructor->delete()) {
			$this->Session->setFlash(__('Course instructor deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course instructor was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
