<?php
App::uses('AppController', 'Controller');
/**
 * CourseRequirements Controller
 *
 * @property CourseRequirement $CourseRequirement
 */
class CourseRequirementsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CourseRequirement->recursive = 0;
		$this->set('courseRequirements', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CourseRequirement->id = $id;
		if (!$this->CourseRequirement->exists()) {
			throw new NotFoundException(__('Invalid course requirement'));
		}
		$this->set('courseRequirement', $this->CourseRequirement->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CourseRequirement->create();
			if ($this->CourseRequirement->save($this->request->data)) {
				$this->Session->setFlash(__('The course requirement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course requirement could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CourseRequirement->Course->find('list');
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
		$this->CourseRequirement->id = $id;
		if (!$this->CourseRequirement->exists()) {
			throw new NotFoundException(__('Invalid course requirement'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseRequirement->save($this->request->data)) {
				$this->Session->setFlash(__('The course requirement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course requirement could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseRequirement->read(null, $id);
		}
		$courses = $this->CourseRequirement->Course->find('list');
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
		$this->CourseRequirement->id = $id;
		if (!$this->CourseRequirement->exists()) {
			throw new NotFoundException(__('Invalid course requirement'));
		}
		if ($this->CourseRequirement->delete()) {
			$this->Session->setFlash(__('Course requirement deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course requirement was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CourseRequirement->recursive = 0;
		$this->set('courseRequirements', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->CourseRequirement->id = $id;
		if (!$this->CourseRequirement->exists()) {
			throw new NotFoundException(__('Invalid course requirement'));
		}
		$this->set('courseRequirement', $this->CourseRequirement->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CourseRequirement->create();
			if ($this->CourseRequirement->save($this->request->data)) {
				$this->Session->setFlash(__('The course requirement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course requirement could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CourseRequirement->Course->find('list');
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
		$this->CourseRequirement->id = $id;
		if (!$this->CourseRequirement->exists()) {
			throw new NotFoundException(__('Invalid course requirement'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseRequirement->save($this->request->data)) {
				$this->Session->setFlash(__('The course requirement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course requirement could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseRequirement->read(null, $id);
		}
		$courses = $this->CourseRequirement->Course->find('list');
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
		$this->CourseRequirement->id = $id;
		if (!$this->CourseRequirement->exists()) {
			throw new NotFoundException(__('Invalid course requirement'));
		}
		if ($this->CourseRequirement->delete()) {
			$this->Session->setFlash(__('Course requirement deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course requirement was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
