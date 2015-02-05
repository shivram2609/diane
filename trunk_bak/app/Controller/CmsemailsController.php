<?php
App::uses('AppController', 'Controller');
/**
 * Cmsemails Controller
 *
 * @property Cmsemail $Cmsemail
 */
class CmsemailsController extends AppController {

	
	public $paginate = array(
		'limit' => 25,
		'order' => array(
			'Cmsemail.mailsubject' => 'asc'
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
		$this->set("title_for_layout",EMAIL_INDEX_TITLE);
		$this->bulkactions();
		/* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Cmsemail']['searchval'])){
			$this->Session->write('searchval',$this->data['Cmsemail']['searchval']);
			$this->conditions	= array("OR"=>array("Cmsemail.mailsubject like"=>"%".$this->data['Cmsemail']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("Cmsemail.mailsubject like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Cmsemail']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		$this->Cmsemail->recursive = 0;
		$this->set('cmsemails', $this->paginate($this->conditions));
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Cmsemail->id = $id;
		if (!$this->Cmsemail->exists()) {
			throw new NotFoundException(__('Invalid cmsemail'));
		}
		$this->set('cmsemail', $this->Cmsemail->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		$this->set("title_for_layout",EMAIL_ADD_TITLE);
		if ($this->request->is('post')) {
			$this->Cmsemail->create();
			if ($this->Cmsemail->save($this->request->data)) {
				$this->Session->setFlash(__('The cmsemail has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cmsemail could not be saved. Please, try again.'));
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
		$this->set("title_for_layout",EMAIL_EDIT_TITLE);
		$this->Cmsemail->id = $id;
		if (!$this->Cmsemail->exists()) {
			throw new NotFoundException(__('Invalid cmsemail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Cmsemail->save($this->request->data)) {
				$this->Session->setFlash(__('The cmsemail has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cmsemail could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Cmsemail->read(null, $id);
		}
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
		$this->Cmsemail->id = $id;
		if (!$this->Cmsemail->exists()) {
			throw new NotFoundException(__('Invalid cmsemail'));
		}
		if ($this->Cmsemail->delete()) {
			$this->Session->setFlash(__('Cmsemail deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Cmsemail was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
