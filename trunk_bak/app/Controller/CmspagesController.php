<?php
App::uses('AppController', 'Controller');
/**
 * Cmspages Controller
 *
 * @property Cmspage $Cmspage
 */
class CmspagesController extends AppController {

	public $paginate = array(
		'limit' => 25,
		'order' => array(
			'Cmspage.name' => 'asc'
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
		$this->set("title_for_layout",PAGES_INDEX_TITLE);
		$this->bulkactions();
		/* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Cmspage']['searchval'])){
			$this->Session->write('searchval',$this->data['Cmspage']['searchval']);
			$this->conditions	= array("OR"=>array("Cmspage.name like"=>"%".$this->data['Cmspage']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("Cmspage.name like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Cmspage']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		$this->set('cmspages', $this->paginate($this->conditions));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		$this->set("title_for_layout",PAGES_ADD_TITLE);
		if ($this->request->is('post')) {
			$this->Cmspage->create();
			if ($this->Cmspage->save($this->request->data)) {
				$this->Session->setFlash(__(PAGES_ADD_SUCC_MESS), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(PAGES_ADD_ERR_MESS));
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
		$this->set("title_for_layout",PAGES_EDIT_TITLE);
		$this->Cmspage->id = $id;
		if (!$this->Cmspage->exists()) {
			throw new NotFoundException(__('Invalid cms page'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Cmspage->save($this->request->data)) {
				$this->Session->setFlash(__(PAGES_UPD_SUCC_MESS), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__(PAGES_UPD_ERR_MESS));
			}
		} else {
			$this->request->data = $this->Cmspage->read(null, $id);
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
		$this->Cmspage->id = $id;
		if (!$this->Cmspage->exists()) {
			throw new NotFoundException(__(PAGES_INV_ERR_MESS));
		}
		if ($this->Cmspage->delete()) {
			$this->Session->setFlash(__(PAGES_DEL_SUCC_MESS), 'default', array("class"=>"success_message"));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__(PAGES_DEL_ERR_MESS));
		$this->redirect(array('action' => 'index'));
	}
}
