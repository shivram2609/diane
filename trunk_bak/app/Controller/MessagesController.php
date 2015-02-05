<?php
App::uses('AppController', 'Controller');
/**
 * Messages Controller
 *
 * @property Message $Message
 */
class MessagesController extends AppController {

	function beforefilter() {
		parent::beforefilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Message->recursive = 0;
		$this->set('messages', $this->paginate());
	}
	
	function inbox() {
		$this->layout = "frontend";
		$this->frontendbulkactions(true);
		$this->paginate = array(
			"fields"=>"Message.id,Message.message_id,Message.sender_id,Message.reciever_id,Message.newmessage,Message.created,Message.recvdelstatus,Message.messagestatus,Message.userdelstatus,Sender.first_name,Sender.last_name,Reciever.first_name,Reciever.last_name,count(Message.message) as countmessage",
			"order" => array(
					"Message.created" => 'desc'
				),
			"group" => array (
					"Message.message_id"
			)
        );
        $this->Message->virtualFields = array(
			"newmessage"=>"select Messages.message from messages Messages where Messages.sender_id = Message.sender_id and Messages.reciever_id = Message.reciever_id order by Messages.created desc limit 1"
			//"countmessage"=>"select count(*) from messages Messages where Messages.sender_id = Message.sender_id and Messages.reciever_id = Message.reciever_id"
        );
        /* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Message']['searchval'])){
			$this->Session->write('searchval',$this->data['Message']['searchval']);
			$this->conditions	= array("OR"=>array("Message.subject like"=>"%".$this->data['Message']['searchval']."%","Message.message like"=>"%".$this->data['Message']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("Message.subject like"=>"%".$this->Session->read('searchval')."%","Message.message like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Message']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
        
		$this->conditions = array_merge($this->conditions,array("Message.recvdelstatus"=>"View","Message.messagestatus !="=>"Trash","Message.reciever_id "=>$this->Session->read("Auth.User.id")));
		$this->set('messages', $this->paginate($this->conditions));
		$this->set("type","inbox");
	}
	
	function sentmessage() {
		$this->layout = "frontend";
		$this->frontendbulkactions(true);
		//$this->Message->recursive = 0;
		$this->paginate = array(
			"fields"=>"Message.id,Message.message_id,Message.newmessage,Message.sender_id,Message.reciever_id,Message.created,Message.recvdelstatus,Message.messagestatus,Message.userdelstatus,Sender.first_name,Sender.last_name,Reciever.first_name,Reciever.last_name,count(Message.message) as countmessage",
			"order" => array(
					"Message.created" => 'desc'
				),
			"group" => array (
					"Message.message_id"
			)
        );
        $this->Message->virtualFields = array(
			"newmessage"=>"select Messages.message from messages Messages where Messages.sender_id = Message.sender_id and Messages.reciever_id = Message.reciever_id order by Messages.created desc limit 1"
			//"countmessage"=>"select count(*) from messages Messages where Messages.sender_id = Message.sender_id and Messages.reciever_id = Message.reciever_id"
        );
        
        /* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Message']['searchval'])){
			$this->Session->write('searchval',$this->data['Message']['searchval']);
			$this->conditions	= array("OR"=>array("Message.subject like"=>"%".$this->data['Message']['searchval']."%","Message.message like"=>"%".$this->data['Message']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("Message.subject like"=>"%".$this->Session->read('searchval')."%","Message.message like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Message']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		$this->Message->recursive = 0;
		$this->conditions = array_merge($this->conditions,array("Message.userdelstatus"=>"View","Message.sender_id "=>$this->Session->read("Auth.User.id")));
		$this->set('messages', $this->paginate($this->conditions));
		$this->Session->write("sentmessage",1);
		$this->set("type","sent");
		//$this->render("inbox");
		
	}

	function trashmessage() {
		$this->layout = "frontend";
		$this->frontendbulkactions(true);
		//$this->Message->recursive = 0;
		$this->paginate = array(
			"fields"=>"Message.id,Message.message_id,Message.newmessage,Message.created,Message.recvdelstatus,Message.messagestatus,Message.userdelstatus,Sender.first_name,Sender.last_name,Reciever.first_name,Reciever.last_name,count(Message.message) as countmessage",
			"order" => array(
					"Message.created" => 'desc'
				),
			"group" => array (
					"Message.message_id"
			)
        );
        $this->Message->virtualFields = array(
			"newmessage"=>"select Messages.message from messages Messages where Messages.sender_id = Message.sender_id and Messages.reciever_id = Message.reciever_id order by Messages.created desc limit 1"
			//"countmessage"=>"select count(*) from messages Messages where Messages.sender_id = Message.sender_id and Messages.reciever_id = Message.reciever_id"
        );
        
        /* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Message']['searchval'])){
			$this->Session->write('searchval',$this->data['Message']['searchval']);
			$this->conditions	= array("OR"=>array("Message.subject like"=>"%".$this->data['Message']['searchval']."%","Message.message like"=>"%".$this->data['Message']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("Message.subject like"=>"%".$this->Session->read('searchval')."%","Message.message like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Message']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		$this->Message->recursive = 0;
		$this->conditions = array_merge($this->conditions,array("Message.recvdelstatus"=>"View","Message.messagestatus"=>"Trash","Message.reciever_id"=>$this->Session->read("Auth.User.id")));
		$this->set('messages', $this->paginate($this->conditions));
		$this->set("type","trash");
		
	}
	
	function movetrash($id = NULL) {
		$this->validatetrashmessage($id);
		$this->Message->create();
		$messagesid = $this->Message->find("list",array("conditions"=>array("Message.message_id"=>$id,"Message.reciever_id"=>$this->Session->read("Auth.User.id")),"fields"=>array("Message.id")));
		foreach($messagesid as $key=>$val) {
			$updatemessage['Message'][$val] = array("id"=>$val,'messagestatus'=>'Trash');
		}
		if ($this->Message->saveAll($updatemessage['Message'])) {
			$this->Session->setFlash("Message moved to trash.", 'default', array("class"=>"success_message"));
		} else {
			$this->Session->setFlash("Message can not be moved to trash.");
		}
		$this->redirect(array("controller"=>"trash"));
	}
	
	function removemessage($id = NULL) {
		$this->validatetrashmessage($id);
		$this->Message->create();
		$messagesid = $this->Message->find("list",array("conditions"=>array("Message.message_id"=>$id,"Message.reciever_id"=>$this->Session->read("Auth.User.id")),"fields"=>array("Message.id")));
		foreach($messagesid as $key=>$val) {
			$updatemessage['Message'][$val] = array("id"=>$val,'recvdelstatus'=>'Delete');
		}
		if ($this->Message->saveAll($updatemessage['Message'])) {
			$this->Session->setFlash("Message has been deleted.", 'default', array("class"=>"success_message"));
		} else {
			$this->Session->setFlash("Message can not be deleted.");
		}
		$this->redirect(array("controller"=>"inbox"));
	}
	
	function viewmessages($id = NULL,$folder = NULL) {
		$this->layout = "frontend";
		$this->Message->recursive = 0;
		if (empty($folder)) {
		} elseif (strtolower($folder) == 'inbox') {
			$message = $this->Message->find("all",array("conditions"=>array("Message.message_id"=>$id,"Message.reciever_id"=>$this->Session->read("Auth.User.id")),"fields"=>array("Message.*,Sender.first_name,Sender.last_name,Reciever.first_name,Reciever.last_name,Reciever.user_id,Sender.user_id")));
			$this->set("trashstatus",1);
		} elseif (strtolower($folder) == 'sent') {
			$message = $this->Message->find("all",array("conditions"=>array("Message.message_id"=>$id,"Message.sender_id"=>$this->Session->read("Auth.User.id")),"fields"=>array("Message.*,Sender.first_name,Sender.last_name,Reciever.first_name,Reciever.last_name,Reciever.user_id,Sender.user_id")));
			$this->set("sentstatus",1);
		} elseif (strtolower($folder) == 'trash') {
			$message = $this->Message->find("all",array("conditions"=>array("Message.message_id"=>$id,"Message.reciever_id"=>$this->Session->read("Auth.User.id")),"fields"=>array("Message.*,Sender.first_name,Sender.last_name,Reciever.first_name,Reciever.last_name,Reciever.user_id,Sender.user_id")));
			$this->set("removestatus",1);
		}
		if (isset($this->data) && !empty($this->data)) {
			$messages['Message']['message'] = $this->data['Message']['message'];
			$messages['Message']['sender_id'] = $this->Session->read("Auth.User.id");
			$messages['Message']['reciever_id'] = $this->data['Message']['reciever_id'];
			$messages['Message']['message_id'] = $this->data['Message']['message_id'];
			$this->Message->save($messages);
			/* code to send email confirmation for signup */
			$sender			= $this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.first_name");
			$publishermail	= $this->useremail($this->Session->read("messageuserid"));
			$this->getmaildata(11);
			$mailmessage = str_replace("\n","<br/>",$messages['Message']['message']);
			$this->mailBody = str_replace("{SENDER}",$sender,$this->mailBody);
			$this->mailBody = str_replace("{MESSAGE}",$mailmessage,$this->mailBody);
			$this->sendmail($publishermail,NULL,$this->subject);
			/* code to send email confirmation for signup */
			$this->data = array();
		}
		
		$this->set("message",$message);
		$this->set("id",$id);
	}
	
	function validateviewmessage($message = NULL,$id = NULL) {
		if ( empty($message)) {
			$this->loadModel("Application");
			$application = $this->Application->find("count",array("conditions"=>array("OR"=>array("Application.user_id"=>$this->Session->read("Auth.User.id"),"Campaign.user_id"=>$this->Session->read("Auth.User.id")),"Application.id"=>$id)));
			if (!empty($application)) {
				$this->redirect("/contactpublisher/".$id);
			} else {
				$this->Session->setFlash("You are not authorize to view this message.");
				$this->set("errflag",1);
			}
		} else {
			$this->set("message",$message);
			$this->Session->write("messageuser.".$this->Session->read("Auth.User.id"),($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name")));
			if ( $message[0]['Message']['reciever_id'] == $this->Session->read("Auth.User.id") ) {
				$this->Session->write("messageuser.".$message[0]['Message']['user_id'],($this->username($message[0]['Message']['user_id'])));
				$this->Session->write("messageuserid",($message[0]['Message']['user_id']));
			} else {
				$this->Session->write("messageuser.".$message[0]['Message']['reciever_id'],($this->username($message[0]['Message']['reciever_id'])));
				$this->Session->write("messageuserid",($message[0]['Message']['reciever_id']));
			}
		}
	}
	
	function validatetrashmessage( $id = NULL ) {
		$message = $this->Message->find("first",array("conditions"=>array("Message.message_id"=>$id,"Message.reciever_id"=>$this->Session->read("Auth.User.id")),"fields"=>array("Message.id")));
		if(empty($id) || empty($message)) {
			$this->Session->setFlash("Invalid Message.");
			$this->redirect(array("controller"=>"inbox"));
		}
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		$this->set('message', $this->Message->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
			}
		}
		$campaigns = $this->Message->Campaign->find('list');
		$users = $this->Message->User->find('list');
		$this->set(compact('campaigns', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Message->read(null, $id);
		}
		$campaigns = $this->Message->Campaign->find('list');
		$users = $this->Message->User->find('list');
		$this->set(compact('campaigns', 'users'));
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
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->Message->delete()) {
			$this->Session->setFlash(__('Message deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Message was not deleted.'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Message->recursive = 0;
		$this->set('messages', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		$this->set('message', $this->Message->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Message->create();
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
			}
		}
		$campaigns = $this->Message->Campaign->find('list');
		$users = $this->Message->User->find('list');
		$this->set(compact('campaigns', 'users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Message->save($this->request->data)) {
				$this->Session->setFlash(__('The message has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The message could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Message->read(null, $id);
		}
		$campaigns = $this->Message->Campaign->find('list');
		$users = $this->Message->User->find('list');
		$this->set(compact('campaigns', 'users'));
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
		$this->Message->id = $id;
		if (!$this->Message->exists()) {
			throw new NotFoundException(__('Invalid message'));
		}
		if ($this->Message->delete()) {
			$this->Session->setFlash(__('Message deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Message was not deleted.'));
		$this->redirect(array('action' => 'index'));
	}
	
	function sendmessage__($id= Null) {
		$this->loadModel("Campaign");
		$this->Campaign->recursive = -1;
		$campaign = $this->Campaign->find("first",array("conditions"=>array("Campaign.id"=>$id,"Campaign.user_id !="=>$this->Session->read("Auth.User.id"))));
		$this->set("campaign",$campaign);
		if (!$this->Session->read("errorcampaign")) {
			$this->validatecampaignmessage($id,$campaign);
		} else {
			$this->Session->delete("errorcampaign");
		}
	}
	
	
	
	function sendmessage($recieverid = NULL) { 
		if($this->RequestHandler->isAjax()) {
			if (isset($this->request->data) && !empty($this->request->data['Message']['Message']) && !empty($this->request->data['Message']['User']) && !empty($this->request->data['Message']['Userid']) && $this->Session->read("Auth.User.id")) {
				$message['Message']['message'] = $this->request->data['Message']['Message'];
				$message['Message']['reciever_id'] = $this->request->data['Message']['Userid'];
				$message['Message']['sender_id'] = $this->Session->read("Auth.User.id");
				$senderemail	= $this->useremail($this->request->data['Message']['Userid']);
				$sender			= $this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.first_name");
				$existmessage = $this->Message->find("first",array("conditions"=>array("Message.sender_id"=>$this->Session->read("Auth.User.id"),"Message.reciever_id"=>$this->request->data['Message']['Userid'],"Message.recvdelstatus <>"=>'Delete',"Message.messagestatus <>"=>'Trash')));
				if (!empty($existmessage)) {
					$message['Message']['message_id'] = $existmessage['Message']['message_id'];
					$this->Message->save($message);
				} else {
					$this->Message->save($message);
					$messagenew['Message']['message_id'] = $this->Message->getLastInsertId();
					$this->Message->create();
					$this->Message->id = $messagenew['Message']['message_id'];
					$this->Message->save($messagenew);
				}
				$notification = $this->checknotification($this->request->data['Message']['Userid']);
				if ( !empty($notification) && isset($notification[1])) {
					/* code to send email confirmation for signup */
					$this->getmaildata(11);
					$mailmessage = str_replace("\n","<br/>",$message['Message']['message']);
					$this->mailBody = str_replace("{SENDER}",$sender,$this->mailBody);
					$this->mailBody = str_replace("{MESSAGE}",$mailmessage,$this->mailBody);
					$this->sendmail($senderemail,NULL,$this->subject);
					/* code to send email confirmation for signup */
				}
				echo "1";
			} else {
				echo "2";
			}
		}
		$this->render(false);
	}
	
	
	
	
	function openmessagepopup($userid = NULL) {
		if($this->RequestHandler->isAjax()) {
			$userid = base64_decode($this->request->data['userid']);
			$this->loadModel("Userdetail");
			$userdetails = $this->Userdetail->find("first",array("conditions"=>array("Userdetail.user_id"=>$userid),"fields"=>array("User.username,User.id,Userdetail.first_name,Userdetail.last_name,Userdetail.image")));
			$this->set("userdetail",$userdetails);
		}
	}
	/* Compose Message */
	function composemessage(){
		$this->layout='frontend';
		$this->loadModel("Userdetail");
		//$userdetails = $this->Userdetail->find("first",array("conditions"=>array("Userdetail.user_id"=>$userid),"fields"=>array("User.username,User.id,Userdetail.first_name,Userdetail.last_name,Userdetail.image")));
		//$this->set("userdetail",$userdetails);
	}
	
}
