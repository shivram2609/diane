<?php
App::uses('AppController', 'Controller');
/**
 * CourseGoals Controller
 *
 * @property CourseGoal $CourseGoal
 */
class CourseGoalsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CourseGoal->recursive = 0;
		$this->set('courseGoals', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CourseGoal->id = $id;
		if (!$this->CourseGoal->exists()) {
			throw new NotFoundException(__('Invalid course goal'));
		}
		$this->set('courseGoal', $this->CourseGoal->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CourseGoal->create();
			if ($this->CourseGoal->save($this->request->data)) {
				$this->Session->setFlash(__('The course goal has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course goal could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CourseGoal->Course->find('list');
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
		$this->CourseGoal->id = $id;
		if (!$this->CourseGoal->exists()) {
			throw new NotFoundException(__('Invalid course goal'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseGoal->save($this->request->data)) {
				$this->Session->setFlash(__('The course goal has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course goal could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseGoal->read(null, $id);
		}
		$courses = $this->CourseGoal->Course->find('list');
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
		$this->CourseGoal->id = $id;
		if (!$this->CourseGoal->exists()) {
			throw new NotFoundException(__('Invalid course goal'));
		}
		if ($this->CourseGoal->delete()) {
			$this->Session->setFlash(__('Course goal deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course goal was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CourseGoal->recursive = 0;
		$this->set('courseGoals', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->CourseGoal->id = $id;
		if (!$this->CourseGoal->exists()) {
			throw new NotFoundException(__('Invalid course goal'));
		}
		$this->set('courseGoal', $this->CourseGoal->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CourseGoal->create();
			if ($this->CourseGoal->save($this->request->data)) {
				$this->Session->setFlash(__('The course goal has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course goal could not be saved. Please, try again.'));
			}
		}
		$courses = $this->CourseGoal->Course->find('list');
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
		$this->CourseGoal->id = $id;
		if (!$this->CourseGoal->exists()) {
			throw new NotFoundException(__('Invalid course goal'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseGoal->save($this->request->data)) {
				$this->Session->setFlash(__('The course goal has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course goal could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CourseGoal->read(null, $id);
		}
		$courses = $this->CourseGoal->Course->find('list');
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
		$this->CourseGoal->id = $id;
		if (!$this->CourseGoal->exists()) {
			throw new NotFoundException(__('Invalid course goal'));
		}
		if ($this->CourseGoal->delete()) {
			$this->Session->setFlash(__('Course goal deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course goal was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
