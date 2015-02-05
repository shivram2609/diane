<?php
App::uses('AppController', 'Controller');
/**
 * Userdetails Controller
 *
 * @property Userdetail $Userdetail
 */
class UserdetailsController extends AppController {
	var $components = array("AuthorizeCmi");
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Userdetail->recursive = 0;
		$this->set('userdetails', $this->paginate());
	}
	
	function beforefilter() {
		parent::beforefilter();
		$this->checklogin();
		$this->adminbreadcrumb();
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Userdetail->id = $id;
		if (!$this->Userdetail->exists()) {
			throw new NotFoundException(__('Invalid userdetail'));
		}
		$this->set('userdetail', $this->Userdetail->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Userdetail->create();
			if ($this->Userdetail->save($this->request->data)) {
				$this->Session->setFlash(__('The userdetail has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The userdetail could not be saved. Please, try again.'));
			}
		}
		$users = $this->Userdetail->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit_profile_account($id = null) {
		$this->layout = "frontend";
		$this->set("title_for_layout",$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"));
		$id = $this->Session->read("Auth.User.id");
		$this->loadModel("Country");
		$this->loadModel("State");
		$this->loadModel("User");
		if (isset($this->data) && !empty($this->data) ) {
			if (isset($this->data['Userdetail']['email'])) {
				$this->Userdetail->id = $this->Session->read("Auth.User.Userdetail.id");
				$useremail['Userdetail']['email'] = $this->data['Userdetail']['email'];
				if ($this->Userdetail->save($useremail)) {
					$this->Session->write("Auth.User.Userdetail.email",$useremail);
					$this->Session->setFlash("Your email has been updated.", 'default', array("class"=>"success_message"));
					$this->redirect("/account");
				}
			} else {
				$data = $this->data;
				$data['User']['currentpassword'] = (!empty($data['User']['currentpassword'])?$this->Auth->password($data['User']['currentpassword']):'');
				$data['User']['password'] = (!empty($data['User']['password'])?$this->Auth->password($data['User']['password']):'');
				$data['User']['confirmpassword'] = (!empty($data['User']['confirmpassword'])?$this->Auth->password($data['User']['confirmpassword']):'');
				$this->User->set($data);
				if ($this->User->validates()) {
					$this->User->create();
					$this->User->id = $this->Session->read("Auth.User.id");
					if($this->User->save($data, array('validate' => false))) {
						$this->Session->setFlash("Password has been updated successfully.", 'default', array("class"=>"success_message"));
						//$this->redirect("changepassword");
					} else {
						$this->Session->setFlash("Password can not updated successfully, Please try again.");
					}
				} 		
			}
		}
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.username","User.loginfrom","User.status","User.created","Userdetail.id","Userdetail.user_id","Userdetail.paypalaccount","Userdetail.state_id","Userdetail.country_id","Userdetail.email","Userdetail.first_name","Userdetail.last_name","Userdetail.about","Userdetail.phone","Userdetail.city","Userdetail.heading","Userdetail.image","User.newsletter","User.profiletype","State.name","Country.name")),array("recursive"=>0));
		$this->set("content_for_title",$user[0]["Userdetail"]["first_name"]." ".$user[0]["Userdetail"]["first_name"]);
		$this->data = $user[0];
		/* to create dropdown for countries */
		$this->Country->recursive = -1;
		$this->set("country",$this->Country->find("list",array("conditions"=>array("Country.status"=>1),"fields"=>array("Country.id","Country.name"))));
		/* end here */
		/* to create dropdown for countries */
		$this->State->recursive = -1;
		$this->set("state",$this->State->find("list",array("conditions"=>array("State.status"=>1,"State.country_id"=>$user[0]["Userdetail"]["country_id"]),"fields"=>array("State.id","State.name"))));
		/* end here */
		
	}
	
	
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function premium_instructor($id = null) {
		$this->layout = "frontend";
		$this->set("title_for_layout",$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"));
		$id = $this->Session->read("Auth.User.id");
		$this->loadModel("User");
		if (isset($this->data) && !empty($this->data) ) {
			if (isset($this->data['Userdetail']['paypalaccount'])) {
				$this->Userdetail->id = $this->Session->read("Auth.User.Userdetail.id");
				$useremail['Userdetail']['paypalaccount'] = $this->data['Userdetail']['paypalaccount'];
				if ($this->Userdetail->save($useremail)) {
					$this->Session->write("Auth.User.Userdetail.paypalaccount",$useremail);
					$this->Session->setFlash("Your paypal email has been updated.", 'default', array("class"=>"success_message"));
					$this->redirect("/paypal-account");
				}
			} 
		}
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.username","User.loginfrom","User.status","User.created","Userdetail.id","Userdetail.user_id","Userdetail.paypalaccount","Userdetail.state_id","Userdetail.country_id","Userdetail.email","Userdetail.first_name","Userdetail.last_name","Userdetail.about","Userdetail.phone","Userdetail.city","Userdetail.heading","Userdetail.image","User.newsletter","User.profiletype","State.name","Country.name")),array("recursive"=>0));
		$this->set("content_for_title",$user[0]["Userdetail"]["first_name"]." ".$user[0]["Userdetail"]["first_name"]);
		$this->data = $user[0];
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
		$this->Userdetail->id = $id;
		if (!$this->Userdetail->exists()) {
			throw new NotFoundException(__('Invalid userdetail'));
		}
		if ($this->Userdetail->delete()) {
			$this->Session->setFlash(__('Userdetail deleted.', 'default', array("class"=>"success_message")));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Userdetail was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Userdetail->recursive = 0;
		$this->set('userdetails', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Userdetail->id = $id;
		if (!$this->Userdetail->exists()) {
			throw new NotFoundException(__('Invalid userdetail'));
		}
		$this->set('userdetail', $this->Userdetail->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Userdetail->create();
			if ($this->Userdetail->save($this->request->data)) {
				$this->Session->setFlash(__('The userdetail has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The userdetail could not be saved. Please, try again.'));
			}
		}
		$users = $this->Userdetail->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Userdetail->id = $id;
		if (!$this->Userdetail->exists()) {
			throw new NotFoundException(__('Invalid userdetail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Userdetail->save($this->request->data)) {
				$this->Session->setFlash(__('The userdetail has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The userdetail could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Userdetail->read(null, $id);
		}
		$users = $this->Userdetail->User->find('list');
		$this->set(compact('users'));
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
		$this->Userdetail->id = $id;
		if (!$this->Userdetail->exists()) {
			throw new NotFoundException(__('Invalid userdetail.'));
		}
		if ($this->Userdetail->delete()) {
			$this->Session->setFlash(__('Userdetail deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Userdetail was not deleted.'));
		$this->redirect(array('action' => 'index'));
	}
	
/**
 * edit_profile method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit_profile(){
		$this->layout='frontend';
		$this->set("title_for_layout",$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"));
		$id = $this->Session->read("Auth.User.id");
		$this->loadModel("User");
		// fetch languages
		$this->loadModel("Language");
		$languages = $this->Language->find('list', array('field'=>'title', 'conditions'=>'Language.status=1','order'=>'Language.title'));
		$this->set('languages', $languages);
		// save user details
		if(isset($this->data) && !empty($this->data)){
			$this->Userdetail->set($this->data);
			
			if($this->Userdetail->validates()){
				// find user detail id with user_id
				$userdetail = $this->Userdetail->find('first', array('fields' => array('Userdetail.id'), 'conditions' => 'Userdetail.user_id='.$id));
				$this->request->data['Userdetail']['id'] = $userdetail['Userdetail']['id'];
				$this->request->data = $this->data;
				
				if($this->Userdetail->save($this->request->data)){
					$this->getuserdetail();
					$this->Session->setFlash(__('Profile has been updated.'), 'default', array("class"=>"success_message"));
				}
			}
		}
		
		// fetch user details
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.username","User.loginfrom","User.status","User.created","Userdetail.id","Userdetail.user_id","Userdetail.paypalaccount","Userdetail.state_id","Userdetail.country_id","Userdetail.first_name","Userdetail.last_name","Userdetail.about","Userdetail.phone","Userdetail.city","Userdetail.image","Userdetail.designation","Userdetail.webLink","Userdetail.fbLink","Userdetail.twitterLink","Userdetail.gplusLink","Userdetail.heading","Userdetail.biography","Userdetail.language","User.newsletter","User.profiletype","State.name","Country.name")),array("recursive"=>0));
		$this->set("content_for_title",$user[0]["Userdetail"]["first_name"]." ".$user[0]["Userdetail"]["first_name"]);
		$this->data = $user[0];
		
	}
	
	
	

/**
 * edit_profile_photo method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */

	
	public function edit_profile_photo($id=null){
		$this->layout = "frontend";
		$this->set("title_for_layout",$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"));
		$id = $this->Session->read("Auth.User.id");
		$this->loadModel("Country");
		$this->loadModel("State");
		$this->loadModel("User");
		
		if (isset($this->data) && !empty($this->data)) {
			if(!empty($this->data['Userdetail']['image']['name'])){
				$count = 0;
				$userid = $id;
				$userdetails['Userdetail'] = $this->data['Userdetail'];
				$userdetails['Userdetail']['image'] = $userdetails['Userdetail']['image']['name'];
				$this->Userdetail->set($userdetails);
				if ($this->Userdetail->validates()) {
					$count++;
				}
				if($count == 1) {
					if (isset($this->data['Userdetail']['image']) && !empty($this->data['Userdetail']['image']['name'])) {
						$userdetails['Userdetail']['image'] = ($this->uploadimage($this->data['Userdetail']['image'],$userid,NULL,NULL,NULL,"profileimg","profile",210,210))?$this->uploaddir.$this->imagename:'';
					} else {
						unset($userdetails['Userdetail']['image']);
					}
					$this->Userdetail->create();
					$this->Userdetail->id = $userdetails['Userdetail']['id'];
					$this->Userdetail->save($userdetails, array('validate' => false));
					$this->User->id = $userid;
					$this->User->save($this->data);
					$countinds = 0;
					$this->getuserdetail();
					$this->Session->setFlash("Profile photo has been updated successfully.", 'default', array("class"=>"success_message"));
				}		
			} else{
				$this->Session->setFlash("Please select a photo to upload.");
			}
		}
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.username","User.loginfrom","User.status","User.created","Userdetail.id","Userdetail.user_id","Userdetail.paypalaccount","Userdetail.state_id","Userdetail.country_id","Userdetail.first_name","Userdetail.last_name","Userdetail.about","Userdetail.phone","Userdetail.city","Userdetail.heading","Userdetail.image","User.newsletter","User.profiletype","State.name","Country.name")),array("recursive"=>0));
		$this->Session->write("Auth.User.Userdetail.image", $user[0]["Userdetail"]["image"]);
		$this->set("content_for_title",$user[0]["Userdetail"]["first_name"]." ".$user[0]["Userdetail"]["first_name"]);
		$this->data = $user[0];
		/* to create dropdown for countries */
		$this->Country->recursive = -1;
		$this->set("country",$this->Country->find("list",array("conditions"=>array("Country.status"=>1),"fields"=>array("Country.id","Country.name"))));
		/* end here */
		/* to create dropdown for countries */
		$this->State->recursive = -1;
		$this->set("state",$this->State->find("list",array("conditions"=>array("State.status"=>1,"State.country_id"=>$user[0]["Userdetail"]["country_id"]),"fields"=>array("State.id","State.name"))));
		/* end here */
		
		
	}

/**
 * edit_profile_privacy method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */	
	
	public function edit_profile_privacy(){
		$this->layout='frontend';
		$this->set("title_for_layout",$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"));
		$id = $this->Session->read("Auth.User.id");
		$this->loadModel("User");
		//echo $id;
		// save privacy settings
		if ($this->request->is('put')) {
			if($this->Userdetail->updateAll(array('Userdetail.privacy'=> "'".serialize($this->request->data['Userdetail'])."'"),array('Userdetail.user_id'=>$id))){
				$this->Session->setFlash('Your privacy settings has been updated.', 'default', array("class"=>"success_message"));
			}
		}
		
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.username","User.loginfrom","User.status","User.created","Userdetail.id","Userdetail.user_id","Userdetail.paypalaccount","Userdetail.state_id","Userdetail.country_id","Userdetail.first_name","Userdetail.last_name","Userdetail.about","Userdetail.phone","Userdetail.city","Userdetail.heading","Userdetail.image","User.newsletter","User.profiletype","State.name","Country.name","Userdetail.privacy")),array("recursive"=>0));
		$this->set("content_for_title",$user[0]["Userdetail"]["first_name"]." ".$user[0]["Userdetail"]["first_name"]);
		$this->data = $user[0];
		
		
		
	}

/**
 * edit_profile_notification method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */	
	
	public function edit_profile_notification(){
		$this->layout='frontend';
		$this->set("title_for_layout",$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"));
		$id = $this->Session->read("Auth.User.id");
		// for user's information in left panel
		$this->loadModel("User");
		$this->loadModel("Usernotification");
		$this->loadModel("Notification");
		
		
		// save notification settings
		if ($this->request->is('put') && isset($this->request->data['Userdetail'])) {
			//find userdetail id as per user_id
			$userdetail = $this->Userdetail->find('first', array('fields' => array('Userdetail.id'), 'conditions' => 'Userdetail.user_id='.$id));
			
			$this->request->data['Userdetail']['id'] = $userdetail['Userdetail']['id'];
			
			if(!isset($this->request->data['Userdetail']['dontSendNotification'])){
				$this->request->data['Userdetail']['notification'] = serialize($this->request->data['Userdetail']['notifications']);
			} else{
				$this->request->data['Userdetail']['notification'] = '';
			}
			
			if($this->Userdetail->save($this->request->data['Userdetail'])) {
				$this->getuserdetail();
				$this->Session->setFlash("Notification settings has been saved.", 'default', array("class"=>"success_message"));
			} else {
				$this->Session->setFlash("Notification settings couldn't be saved.");
			}
		}
		
		// fetch user details for view
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.username","User.loginfrom","User.status","User.created","Userdetail.id","Userdetail.user_id","Userdetail.paypalaccount","Userdetail.state_id","Userdetail.country_id","Userdetail.first_name","Userdetail.last_name","Userdetail.about","Userdetail.phone","Userdetail.city","Userdetail.heading","Userdetail.image","Userdetail.notification","User.newsletter","User.profiletype","State.name","Country.name")),array("recursive"=>0));
		$this->set("content_for_title",$user[0]["Userdetail"]["first_name"]." ".$user[0]["Userdetail"]["first_name"]);
		$this->data = $user[0];
		$this->set('notifi', unserialize($this->data['Userdetail']['notification']));
		// display user profile notification
		
		$notifications = $this->Notification->find('all',array('conditions'=>array('Notification.enable'=>1)));
		$this->set('notifications' , $notifications);
		
		
	}

/**
 * edit_profile_dangerzone method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */	
	
	public function edit_profile_dangerzone(){
		$this->layout='frontend';
		$this->set("title_for_layout",$this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"));
		$id = $this->Session->read("Auth.User.id");
		$this->loadModel("User");
		// delete account with all the dependants
		if ($this->request->is('put') || $this->request->is('post')) {
			if ($this->User->delete($id)) {
				if(is_dir(WWW_ROOT."img/".$id)) {
					exec("rm -rf ".WWW_ROOT."img/".$id);
				}
			}
			$this->Session->delete("Auth.User.id");
			$this->Session->setFlash("Your account has been permanently deleted.", 'default', array("class"=>"success_message"));
			$this->redirect('/');
		}
		// fetch user details
	
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.username","User.loginfrom","User.status","User.created","Userdetail.id","Userdetail.user_id","Userdetail.paypalaccount","Userdetail.state_id","Userdetail.country_id","Userdetail.first_name","Userdetail.last_name","Userdetail.about","Userdetail.phone","Userdetail.city","Userdetail.heading","Userdetail.image","User.newsletter","User.profiletype","State.name","Country.name")),array("recursive"=>0));
		$this->set("content_for_title",$user[0]["Userdetail"]["first_name"]." ".$user[0]["Userdetail"]["first_name"]);
		$this->data = $user[0];

	}

}
