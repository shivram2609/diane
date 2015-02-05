<?php
App::uses('AppController', 'Controller');
/**
 * Cities Controller
 *
 * @property City $City
 */
class CitiesController extends AppController {


	public $conditions	= array();
	public $delarr		= array();
	public $updatearr	= array();
	public $paginate = array(
		'limit' => 25,
		'order' => array(
			'City.name' => 'asc'
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
		if(isset($this->data) && !empty($this->data['City']['searchval'])){
			$this->Session->write('searchval',$this->data['City']['searchval']);
			$this->conditions	= array("OR"=>array("City.name like"=>"%".$this->data['City']['searchval']."%","State.name like"=>"%".$this->data['City']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("City.name like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['City']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		$this->City->recursive = 0;
		$this->set('cities', $this->paginate($this->conditions));
	}


/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->City->create();
			if ($this->City->save($this->request->data)) {
				$this->Session->setFlash(__('The city has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The city could not be saved. Please, try again.'));
			}
		}
		$states = $this->City->State->find('list');
		$this->set(compact('states'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->City->id = $id;
		if (!$this->City->exists()) {
			throw new NotFoundException(__('Invalid city'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->City->save($this->request->data)) {
				$this->Session->setFlash(__('The city has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The city could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->City->read(null, $id);
		}
		$states = $this->City->State->find('list');
		$this->set(compact('states'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->City->id = $id;
		if (!$this->City->exists()) {
			throw new NotFoundException(__('Invalid city'));
		}
		if ($this->City->delete()) {
			$this->Session->setFlash(__('City deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('City was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
?>
