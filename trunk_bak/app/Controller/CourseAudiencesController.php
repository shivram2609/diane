<?php
App::uses('AppController', 'Controller');
/**
 * CourseAudiences Controller
 *
 * @property CourseAudience $CourseAudience
 */
class CourseAudiencesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CourseAudience->recursive = 0;
		$this->set('courseAudiences', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CourseAudience->id = $id;
		if (!$this->CourseAudience->exists()) {
			throw new NotFoundException(__('Invalid course audience'));
		}
		$this->set('courseAudience', $this->CourseAudience->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CourseAudience->create();
			if ($this->CourseAudience->save($this->request->data)) {
				$this->Session->setFlash(__('The course audience has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course audience could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CourseAudience->Course->find('list');
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
		$this->CourseAudience->id = $id;
		if (!$this->CourseAudience->exists()) {
			throw new NotFoundException(__('Invalid course audience'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseAudience->save($this->request->data)) {
				$this->Session->setFlash(__('The course audience has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course audience could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseAudience->read(null, $id);
		}
		$courses = $this->CourseAudience->Course->find('list');
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
		$this->CourseAudience->id = $id;
		if (!$this->CourseAudience->exists()) {
			throw new NotFoundException(__('Invalid course audience'));
		}
		if ($this->CourseAudience->delete()) {
			$this->Session->setFlash(__('Course audience deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course audience was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CourseAudience->recursive = 0;
		$this->set('courseAudiences', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->CourseAudience->id = $id;
		if (!$this->CourseAudience->exists()) {
			throw new NotFoundException(__('Invalid course audience'));
		}
		$this->set('courseAudience', $this->CourseAudience->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CourseAudience->create();
			if ($this->CourseAudience->save($this->request->data)) {
				$this->Session->setFlash(__('The course audience has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course audience could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CourseAudience->Course->find('list');
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
		$this->CourseAudience->id = $id;
		if (!$this->CourseAudience->exists()) {
			throw new NotFoundException(__('Invalid course audience'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseAudience->save($this->request->data)) {
				$this->Session->setFlash(__('The course audience has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course audience could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseAudience->read(null, $id);
		}
		$courses = $this->CourseAudience->Course->find('list');
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
		$this->CourseAudience->id = $id;
		if (!$this->CourseAudience->exists()) {
			throw new NotFoundException(__('Invalid course audience'));
		}
		if ($this->CourseAudience->delete()) {
			$this->Session->setFlash(__('Course audience deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course audience was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
