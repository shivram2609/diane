<?php
App::uses('AppController', 'Controller');
/**
 * Countries Controller
 *
 * @property Country $Country
 */
class CountriesController extends AppController {

	
	public $conditions	= array();
	public $delarr		= array();
	public $updatearr	= array();
	public $paginate = array(
		'limit' => 25,
		'order' => array(
			'Country.name' => 'asc'
		)
	);
	
	function beforefilter() {
		parent::beforefilter();
		$allowed = array();
		$this->checklogin($allowed);
		$this->adminbreadcrumb();
	}
	
/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->bulkactions();
		/* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Country']['searchval'])){
			$this->Session->write('searchval',$this->data['Country']['searchval']);
			$this->conditions	= array("OR"=>array("name like"=>"%".$this->data['Country']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("name like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Country']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		$this->Country->recursive = 0;
		$this->set('countries', $this->paginate($this->conditions));
	}



/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Country->create();
			if ($this->Country->save($this->request->data)) {
				$this->Session->setFlash(__('The country has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The country could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Country->id = $id;
		if (!$this->Country->exists()) {
			throw new NotFoundException(__('Invalid country'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Country->save($this->request->data)) {
				$this->Session->setFlash(__('The country has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The country could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Country->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		die("here");
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Country->id = $id;
		if (!$this->Country->exists()) {
			throw new NotFoundException(__('Invalid country'));
		}
		if ($this->Country->delete()) {
			$this->Session->setFlash(__('Country deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Country was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
