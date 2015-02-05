<?php
App::uses('AppController', 'Controller');
/**
 * CourseInvitees Controller
 *
 * @property CourseInvitee $CourseInvitee
 */
class CourseInviteesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->CourseInvitee->recursive = 0;
		$this->set('courseInvitees', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CourseInvitee->id = $id;
		if (!$this->CourseInvitee->exists()) {
			throw new NotFoundException(__('Invalid course invitee'));
		}
		$this->set('courseInvitee', $this->CourseInvitee->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CourseInvitee->create();
			if ($this->CourseInvitee->save($this->request->data)) {
				$this->flash(__('Courseinvitee saved.'), array('action' => 'index'));
			} else {
			}
		}
		$courses = $this->CourseInvitee->Course->find('list');
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
		$this->CourseInvitee->id = $id;
		if (!$this->CourseInvitee->exists()) {
			throw new NotFoundException(__('Invalid course invitee'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseInvitee->save($this->request->data)) {
				$this->flash(__('The course invitee has been saved.'), array('action' => 'index'));
			} else {
			}
		} else {
			$this->request->data = $this->CourseInvitee->read(null, $id);
		}
		$courses = $this->CourseInvitee->Course->find('list');
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
		$this->CourseInvitee->id = $id;
		if (!$this->CourseInvitee->exists()) {
			throw new NotFoundException(__('Invalid course invitee'));
		}
		if ($this->CourseInvitee->delete()) {
			$this->flash(__('Course invitee deleted'), array('action' => 'index'));
		}
		$this->flash(__('Course invitee was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->CourseInvitee->recursive = 0;
		$this->set('courseInvitees', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->CourseInvitee->id = $id;
		if (!$this->CourseInvitee->exists()) {
			throw new NotFoundException(__('Invalid course invitee'));
		}
		$this->set('courseInvitee', $this->CourseInvitee->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->CourseInvitee->create();
			if ($this->CourseInvitee->save($this->request->data)) {
				$this->flash(__('Courseinvitee saved.'), array('action' => 'index'));
			} else {
			}
		}
		$courses = $this->CourseInvitee->Course->find('list');
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
		$this->CourseInvitee->id = $id;
		if (!$this->CourseInvitee->exists()) {
			throw new NotFoundException(__('Invalid course invitee'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CourseInvitee->save($this->request->data)) {
				$this->flash(__('The course invitee has been saved.'), array('action' => 'index'));
			} else {
			}
		} else {
			$this->request->data = $this->CourseInvitee->read(null, $id);
		}
		$courses = $this->CourseInvitee->Course->find('list');
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
		$this->CourseInvitee->id = $id;
		if (!$this->CourseInvitee->exists()) {
			throw new NotFoundException(__('Invalid course invitee'));
		}
		if ($this->CourseInvitee->delete()) {
			$this->flash(__('Course invitee deleted'), array('action' => 'index'));
		}
		$this->flash(__('Course invitee was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
}
