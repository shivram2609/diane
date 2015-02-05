<?php
App::uses('AppController', 'Controller');
/**
 * Backupdbs Controller
 *
 * @property Backupdb $Backupdb
 */
class BackupdbsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Backupdb->recursive = 0;
		$this->set('backupdbs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Backupdb->id = $id;
		if (!$this->Backupdb->exists()) {
			throw new NotFoundException(__('Invalid backupdb'));
		}
		$this->set('backupdb', $this->Backupdb->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Backupdb->create();
			if ($this->Backupdb->save($this->request->data)) {
				$this->Session->setFlash(__('The backupdb has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The backupdb could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Backupdb->id = $id;
		if (!$this->Backupdb->exists()) {
			throw new NotFoundException(__('Invalid backupdb'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Backupdb->save($this->request->data)) {
				$this->Session->setFlash(__('The backupdb has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The backupdb could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Backupdb->read(null, $id);
		}
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
		$this->Backupdb->id = $id;
		if (!$this->Backupdb->exists()) {
			throw new NotFoundException(__('Invalid backupdb'));
		}
		if ($this->Backupdb->delete()) {
			$this->Session->setFlash(__('Backupdb deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Backupdb was not deleted.'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->bulkactions(true);
		/* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Backupdb']['searchval'])){
			$this->Session->write('searchval',$this->data['Backupdb']['searchval']);
			$this->conditions	= array("OR"=>array("Backupdb.filename like"=>"%".$this->data['Backupdb']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("Backupdb.filename like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Category']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		
		
		$this->Backupdb->recursive = 0;
		$this->set('backupdbs', $this->paginate($this->conditions));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Backupdb->id = $id;
		if (!$this->Backupdb->exists()) {
			throw new NotFoundException(__('Invalid backupdb'));
		}
		$this->set('backupdb', $this->Backupdb->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
			$this->Backupdb->create();
			$filename = DB_NAME.date("Y-m-d-H-i-s").'.sql';
			$this->request->data['Backupdb']['filename'] = $filename;

			$dumpstring = 'mysqldump --single-transaction --user ' . DB_USER . ' --password=' . DB_PASSWORD . ' ' . DB_NAME;
			// execute the command and get output of exported db
			$output = shell_exec($dumpstring);
			// save the output in a sql file
			if($f = @fopen('backupdb/'.$filename, "a")){
				fwrite($f, $output);
				fclose($f);
				if ($this->Backupdb->save($this->request->data)) {
					$this->Session->setFlash(__('The Database Backup has been saved.'), 'default', array("class"=>"success_message"));
				} else {
					$this->Session->setFlash(__('Database Backup could not be saved. Please, try again.'));
				}
			} else{
				$this->Session->setFlash(__('Database Backup could not be saved. Please check Folder Permission.'));
			}
			$this->redirect(array('action' => 'index'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Backupdb->id = $id;
		if (!$this->Backupdb->exists()) {
			throw new NotFoundException(__('Invalid backupdb'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Backupdb->save($this->request->data)) {
				$this->Session->setFlash(__('The backupdb has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The backupdb could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Backupdb->read(null, $id);
		}
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null, $filename = null) {
		/*if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}*/
		$this->Backupdb->id = $id;
		if (!$this->Backupdb->exists()) {
			throw new NotFoundException(__('Invalid backupdb'));
		}
		if ($this->Backupdb->delete()) {
			if(@unlink(WWW_ROOT.'backupdb/'.$filename)){
				$this->Session->setFlash(__('Backup '.$filename.' deleted.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else{
				$this->Session->setFlash(__('Database Backup'.$filename.' doesn\'t exists.'));
				$this->redirect(array('action' => 'index'));
			}
		} else{
			$this->Session->setFlash(__($filename.' could not be deleted.'));
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function admin_download($file = null){
		 $this->autoRender = false;
		$file = WWW_ROOT.'backupdb/'.$file;
		
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
		
	}
	
}
