<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @version		: 1.0
 * @created by	: shivam sharma
 */
class UsersController extends AppController {

	public $userstatus = '';
/*
 * @function name	: beforefilter
 * @purpose			: index page for site user
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: NA
*/
	function beforefilter() {
		if($this->params['action'] == 'login') {
			if ($this->Cookie->read('Auth.User') && !$this->Session->read("Auth.User.id")) {
				$this->login();
			}
		}
		if($this->params['action'] == 'logout') {
			$this->logout();
		}
		parent::beforefilter();
		$this->Auth->allow("login","logout","signup","newpassword","requestaccount","forgotpassword","getindustry","getstates","confirmregisteration","Captcha","choosetype","viewprofile","loginwith");
		$admin = $this->Session->read("admin");
		
		$this->checklogin();
	}
/* end of function */
	
	
/*
 * @function name	: index
 * @purpose			: index page for site user
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: NA
*/
	function index() {
		$this->layout = "frontend";
		$user = $this->Session->read("Auth.User.id");
		$this->set("index","1");
		if (empty($user) && $this->Cookie->read('Auth.User')) {
			$this->__login();
		}
	}
/* end of function */

	
	
/*
 * @function name	: login
 * @purpose			: to show login page for users
 * @arguments		: NA
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10th Jan 2013
 * @description		: NA
*/
	function login($url = NULL) {
		$this->set("title_for_layout","User Login");
		$this->layout = "frontend";
		$this->Connect->user();
		if (!empty($url)) {
			$url = implode("/",$this->params['pass']);
		}
		/*if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == SITE_LINK) {
			$this->Session->write("login",1);
		}*/
		if($this->Session->read("Auth.User.id")) {
			//$this->redirect("/dashboard");
		} else {
			if ((isset($this->data) && !empty($this->data)) || $this->Session->read("FB.Me.id")){
				$this->__login($url);
			} elseif ($this->Cookie->read('Auth.User')) {
				$user = $this->Session->read("Auth.User.id");
				if (empty($user)) {
					$this->__login($url);
				}
			}
		}
	}
	
/* end of function */


/*
 * @function name	: __login
 * @purpose			: to check user authentication
 * @arguments		: NA
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: it is a private function
*/
	function __login($url = NULL) {
		if (isset($this->data) && !empty($this->data)) {
			if ($this->Auth->login()) {
				$this->loginedUserInfo = $this->Auth->user();
				if (!empty($this->loginedUserInfo) && $this->loginedUserInfo['status'] == 0) {
					$this->Session->setFlash("Your account is not activated yet.");
					$this->Auth->logout();
					$this->redirect(array("action"=>"login"));
					exit;
				} 
			} else {
				$this->Session->setFlash("Invalid Email or Password.");
				$this->Auth->logout();
				$this->redirect(array("action"=>"login"));
				exit;
			}
		}
		if ($this->Session->read("FB.Me.id")) {
			$this->User->recursive = -1;
			$fbuser = $this->User->find("first",array("conditions"=>array("User.username"=>$this->Connect->user('email'))));
			if (empty($fbuser)) {
				$fbuser['User']['username']	= $this->Connect->user('email');
				$fbuser['User']['password']	= $this->Auth->password($this->Session->read("FB.Me.id"));
				$fbuser['User']['fbid']	= $this->Session->read("FB.Me.id");
				$fbuser['User']['loginfrom']	= 'FB';
				$fbuser['User']['status']	= 1;
				if ($this->User->save($fbuser,array("validates"=>false))) {
					$userdetail['Userdetail']['user_id'] = $this->User->getLastInsertId();
					$userdetail['Userdetail']['first_name'] = $this->Session->read("FB.Me.first_name");
					$userdetail['Userdetail']['last_name'] = $this->Session->read("FB.Me.last_name");
					$this->loadModel("Userdetail");
					$this->Userdetail->save($userdetail);
				}
			}
			$user['User']['username']	= $fbuser['User']['username'];
			$user['User']['password']	= $this->Session->read("FB.Me.id");
			$this->data = $user;
			$this->Auth->login();
			$this->loginedUserInfo = $this->Auth->user();
		}
	/* code to perform remeber me functinality " remember_login " */ 
		//condition to check if remember me checkbox is checked or not, if checked a cookie Auth.Member will be written
		if (isset($this->data['User']['remember_me']) && !empty($this->data['User']['remember_me'])  && !empty($this->loginedUserInfo)) {
			$cookie = array();
			$cookie['remembertoken'] = $this->encryptpass($this->data['User']['username'])."^".base64_encode($this->data['User']['password']);
			$data['User']['remembertoken'] = $this->encryptpass($this->data['User']['username']);
			$this->User->create();
			$this->User->id = $this->loginedUserInfo['id'];
			$this->User->save($data);
			$this->Cookie->write('Auth.User', $cookie,false, '+2 weeks');
		}
		//condition to check if cookie Auth.Member is set or not if set then automatically logged in
		if (empty($this->data)) {
			$cookie = $this->Cookie->read('Auth.User');
			if (!is_null($cookie)) {
				//if (!isset($cookie['remembertoken'])) {
					//$cookie1 = str_replace('\"','"',$cookie);
					//$cookie1 = json_decode($cookie1);
					//$cookie = explode("^",$cookie1->remembertoken);
					/*pr($cookie);
					echo "1";
				} else {
					echo "12";
					pr($cookie); */
					$cookie = explode("^",$cookie['remembertoken']);
				//}
				//pr($cookie);
				$this->User->recursive = 0;
				$user = $this->User->find("first",array("conditions"=>array("User.remembertoken"=>$cookie[0],"User.status"=>1),"fields"=>array("User.username","User.password")));
				//pr($user);
				$user['User']['password'] = base64_decode($cookie[1]);
				unset($user['User']['id']);
				$this->data = $user;
				
				if ($this->Auth->login()) {
					//die("here1");
					$this->loginedUserInfo=$this->Auth->user();
				//  Clear auth message, just in case we use it.
					$this->Session->delete('Message.auth');
				} 
				//die("here");
			} else {
				die("yay");
				$this->Auth->logout();
			}
		}
	/* end of code */
		if(empty($url)) {
			$this->redirect("/dashboard");
		} else {
		?>
			<script type="text/javascript">
			window.parent.location.href = '<?php echo SITE_LINK.$url; ?>';
			</script>
		<?php
		}
	}
/* end of function */

	
	function dashboard() {
		$this->layout= false;
		if ($this->Session->read("Auth.User.loginfrom") == 'Twitter') {
			$this->render("twitterredirect");
		} else {
			$this->set("title_for_layout","Dashboard");
			$this->render("dashboard");
		}
	}
	
	function choosetype() {
		if (isset($this->data) && !empty($this->data)) {
			$this->User->create();
			$this->User->id = $this->Session->read("Auth.User.id");
			if ($this->User->save($this->data)) {
				$this->Session->write("Auth.User.type",$this->data['User']['type']);
				$this->redirect("/dashboard");
			}
		}
	}
	
/*
 * @function name	: logout
 * @purpose			: to logout from user panel
 * @arguments		: NA
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: NA
*/
	function logout() {
		//if($this->Session->read("Auth")) {
			if($this->Session->read("Auth.User.loginfrom") == 'Twitter') {
				$this->logoutwith();
			}
			$this->Auth->logout();
			$this->Cookie->destroy();
			$this->Session->delete("Auth.User.Userdetail");
			$this->Session->delete("Auth.User");
			$this->Session->delete("FB");
			$this->Session->delete("Profile");
			$this->Session->delete("campaigns");
			$this->Session->delete("CoursePassword");
			$this->redirect("/");
			
		//} 
	}
/* end of function */


/*
 * @function name	: signup
 * @purpose			: to register new user account
 * @arguments		: NA
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd May 2013
 * @description		: This function is responsible to create new user account with sending confirmation email to registering user with that this function will perform the check of rejected domain by site admin. If there is a company with same domain the new user will be pooled in company's existing account otherwise new company will be added with new user account.
*/	
	function signup() {
		$this->layout = "frontend";
		$accountstatus = '';
		$this->set("title_for_layout","User Signup");
		if (isset($this->data) && !empty($this->data)) {
			$this->loadModel("Userdetail");
			$this->User->set($this->data);
			$this->Userdetail->set($this->data);
			$errflag = 0;
			if ($this->User->validates()) {
				$errflag += 1;
			}
			if($this->Userdetail->validates())	{
				$errflag += 1;
			}
			if ($errflag == 2) {
				$user = $this->data;
				$user['User']['password'] = $this->Auth->password($user['User']['password']);
				$user['User']['passwordstatus'] = $passwordstatus = $this->encryptpass($user['User']['username']);
				if ($this->User->save($user,array('validate' => false))) {
					$userdetails	=	$this->data;
					$userdetails['Userdetail']['user_id'] = $this->User->getLastInsertId();
					$this->Userdetail->save($userdetails);
					/* code to send email confirmation for signup */
					$user 			= $userdetails['Userdetail']['first_name'];
					$confirmlink	= "<a href=".SITE_LINK."users/confirmregisteration/".$passwordstatus.">Click Here</a>";
					$this->getmaildata(1);
					$this->mailBody = str_replace("{USER}",$user,$this->mailBody);
					$this->mailBody = str_replace("{LINK}",$confirmlink,$this->mailBody);
					$this->sendmail($this->data['User']['username']);
					/* code to send email confirmation for signup */
					$this->Session->setFlash("Your registration with 1337 Institute of Technology has been successful and a confirmation email has been sent to your registered email address.", 'default', array("class"=>"success_message"));
					$this->redirect(array("action"=>"login"));
				}
			}
		}
	}
/* end of function */


	function confirmregisteration($id = null) {
		$this->layout = "frontend";
		$this->User->recursive = -1;
		if (!empty($id)) {
			$user = $this->User->find("first",array("conditions"=>array("User.passwordstatus"=>$id)));
		}
		if (empty($user)) {
			$this->Session->setFlash("Invalid User.");
		} elseif($user['User']['status'] == 1) {
			$this->Session->setFlash("Account is already activated.");
		} else {
			$this->User->create();
			$this->User->id = $user['User']['id'];
			$updateuser['User']['status'] = 1;
			$updateuser['User']['passwordstatus'] = 0;
			$this->User->save($updateuser);
			$this->Session->setFlash("Congrats, your account is activated.", 'default', array("class"=>"success_message"));
		}
		//$this->redirect(array("action"=>"login"));
	}

	function captcha()	{
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
			$this->Captcha = $this->Components->load('Captcha', array(
				'width' => 150,
				'height' => 50,
				'theme' => 'default', //possible values : default, random ; No value means 'default'
			)); //load it
			}
		$this->Captcha->create();
	} 
	
/*
 * @function name	: newpassword
 * @purpose			: to set password after registration of user
 * @arguments		: token will be given with aet password url.
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15rd Jan 2013
 * @description		: This function is responsible set new password for newly registered user. User can set password only once.
*/	
	function newpassword($token) {
		$this->layout = "frontend";
		$this->User->recursive = 0;
		$user = $this->User->find("first",array("conditions"=>array("User.remembertoken"=>$token)));
		if (isset($this->data) && !empty($this->data)) {
			$this->User->create();
			$this->User->id = $this->data['User']['id'];
			$data['User']['password'] 		= $this->Auth->password($this->data['User']['password'],$this->data['User']['username']);
			$data['User']['confirmpassword']= $this->Auth->password($this->data['User']['confirmpassword'], $this->data['User']['username']);
			$data['User']['status'] 		= 1;
			if ($this->User->save($data)) {
				$this->Cookie->destroy();
				$this->Session->destroy();
				$this->Session->setFlash("Your account is successfully confirmed.", 'default', array("class"=>"success_message"));
				$this->redirect("/login");
			}
		} elseif (!empty($user)) {
			if (!empty($user['User']['password'])) {
				$this->Session->setFlash("You have already set your password.");
				$this->redirect("/login");
			} else {
				$this->data = $user;
			}
		} else {
			$this->Session->setFlash("Invalid link.");
			$this->redirect("/login");
		}
	}
/* end of function */


/*
 * @function name	: admin_index
 * @purpose			: to show listing of users for admin of site
 * @arguments		: Following arguments have been passed:
			* status	: status of users listed like 'Apprroved','Rejected'
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: NA
*/	
	public function admin_index($type=NULL) {
		$this->bulkactions();
		/* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['User']['searchval'])){
			$this->Session->write('searchval',$this->data['User']['searchval']);
			$this->conditions	= array("OR"=>array("User.username like"=>"%".$this->data['User']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("User.username like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['User']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		$this->User->recursive = 0;
		$this->set('users', $this->paginate($this->conditions));
	}
/* end of function */

	
/*
 * @function name	: confirmuser
 * @purpose			: to aprove or disapprove the user from user panel
 * @arguments		: This function require following arguments:
			* id		: user id
			* opt		: status of user
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: This function is responsible to approve and disapprove a user from manager user.
*/
	function confirmuser($id,$opt) {
		$this->layout = "frontend";
		$admin = $this->Session->read("admin");
		$this->User->id = $id;
		
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		} else {
			$this->User->recursive = 0;
			$user = $this->User->find("first",array("conditions"=>array("User.id"=>$id,"User.account_id"=>$this->Session->read("Auth.User.account_id"))));
			$status = ($opt==1)?'Approved and a notification has been sent to user on email '.$user['User']['username']:'Rejected and a notification has been sent to user on email '.$user['User']['username'];
			$status1 = ($opt==1)?'Approved':'Rejected';
			if ($this->sendpasswordmail($user,$opt)) {
				$this->User->create();
				$this->User->id = $user['User']['id'];
				$userdata['User']['remembertoken'] = $this->encryptpass($user['User']['username']);
				$userdata['User']['approved'] = ($opt==1)?"A":"N";
				$this->User->save($userdata);
				$this->Session->setFlash("The user account has been ".$status.".", 'default', array("class"=>"success_message"));
			} else {
				$this->Session->setFlash("The user account can not be ".$status1.", please try again.");
			}
		}
		
		$this->redirect("/viewusers",(($opt==1)?"N":"A"));
	}
/* end of function */	

/*
 * @function name	: admin_delete
 * @purpose			: to delete user profile from admin panel
 * @arguments		: This function require following arguments:
			* id		: user id
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: NA
*/
	public function admin_delete($id = null) {
		$this->validateuser($id);
		$this->User->id = $id;
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted.', 'default', array("class"=>"success_message")));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted.'));
		$this->redirect(array('action' => 'index'));
	}
/* end of function */

/*
 * @function name	: admin_view
 * @purpose			: to view user profile from admin panel
 * @arguments		: This function require following arguments:
			* id		: user id
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: NA
*/
	public function admin_view($id = null) {
		$this->validateuser($id);
		$this->loadmodel("Userdetail");
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.username","User.type","User.status","User.created","Userdetail.first_name","Userdetail.last_name","Userdetail.about","Userdetail.city","Userdetail.image","State.name","Country.name")),array("recursive"=>0));
		$this->set("user",$user[0]);
		$this->loadmodel("Userindustry");
		$this->Userindustry->recursive = 1;
		$industries = $this->Userindustry->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("Industry.heading")));
		$this->set("industries",$industries);
		$this->loadmodel("Usermediaoutlet");
		$this->Usermediaoutlet->recursive = 0;
		$mediaoutlets = $this->Usermediaoutlet->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("Usermediaoutlet.mediaval","Mediaoutlet.heading")));
		$this->set("mediaoutlets",$mediaoutlets);
	}
/* end of function */


	public function viewprofile($id = Null,$profile= Null) {
		
		$this->layout = "frontend";
		$this->loadmodel("Userdetail");
		$this->Userdetail->virtualFields = array(
			"wishlist"=>"Select count(*) from user_wishlist_courses as Wishlistcourse where Wishlistcourse.user_id = Userdetail.user_id",
			"learning"=>"Select count(*) from user_learning_courses as Learningcourse where Learningcourse.user_id = Userdetail.user_id and Learningcourse.completed = 0",
			"completed"=>"Select count(*) from user_learning_courses as Learningcourse where Learningcourse.user_id = Userdetail.user_id and Learningcourse.completed = 1",
			"countcourse"=>"Select count(*) from courses as Course where Course.user_id = Userdetail.user_id"
		);
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.id","User.username","User.loginfrom","User.status","User.created","User.profiletype","Userdetail.first_name","Userdetail.user_id","Userdetail.last_name","Userdetail.paypalaccount","Userdetail.about","Userdetail.city","Userdetail.phone","Userdetail.image","Userdetail.wishlist","Userdetail.learning","Userdetail.completed","Userdetail.countcourse","State.name","Country.name","Userdetail.biography","Userdetail.privacy")),array("recursive"=>0));
		
		// count followers
		$this->loadModel('Follower');
		if($this->Session->read('Auth.User.id')){
			if($this->Session->read('Auth.User.id') == $id){
				$this->Follower->virtualFields = array(
					"Followers"=>"select count(*) from followers where user_id=".$this->Session->read('Auth.User.id'),
					"Following"=>"select count(*) from followers where follower_id=".$this->Session->read('Auth.User.id')
				);
				$follower = $this->Follower->find('first', array('fields'=>array('Follower.Followers', 'Follower.Following')));
			} else{
				$this->Follower->virtualFields = array(
					"Followers"=>"select count(*) from followers where user_id=".$id,
					"Following"=>"select count(*) from followers where follower_id=".$id,
					"Followed" => "select id from followers where follower_id=".$this->Session->read('Auth.User.id')." and user_id =".$id." Limit 1"
				);
				$follower = $this->Follower->find('first', array('fields'=>array('Follower.Followers', 'Follower.Following','Follower.Followed')));
			}
			$this->set('follower', $follower);
		} else {
			$this->Follower->virtualFields = array(
				"Followers"=>"select count(*) from followers where user_id=".$id,
				"Following"=>"select count(*) from followers where follower_id=".$id
			);
				$follower = $this->Follower->find('first', array('fields'=>array('Follower.Followers', 'Follower.Following')));
			$this->set('follower', $follower);
		}
		$privacy = unserialize($user[0]['Userdetail']['privacy']);
		$this->set(compact("privacy"));
		
		if(!empty($user[0])) {
			$this->set("title_for_layout",$user[0]["Userdetail"]["first_name"].' '.$user[0]["Userdetail"]["last_name"]);
			$this->set("user",$user[0]);
		} else { 
			$this->Session->setFlash("Invalid User.");
			$this->redirect("/dashboard");
		}
	}
/*
 * @function name	: forgotpassword
 * @purpose			: to generate and send a random password to user who is requesting for forgot password
 * @arguments		: NA
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: NA
*/
	function forgotpassword() {
		$this->layout = "frontend";
		$this->set("title_for_layout","Forgot Password");
		if(isset($this->data) && !empty($this->data)){
			$this->loadModel("Userdetail");
			$arr = $this->User->Userdetail->find("first",array("conditions"=>array("username"=>$this->data['User']['username'],"loginfrom"=>'Site')));
			if(empty($arr)){
				$this->Session->setFlash(INVALID_EMAIL_FORGOT_PASSWORD);
			} else {
				if($arr['User']['status'] == 1) {
					$arr['User']['passwordstatus'] = 1;
					$new_password = rand(100000, 999999);
					$arr['User']['password'] = $this->Auth->password($new_password);
					/* code to send email confirmation for signup */
					$user	= $arr['Userdetail']['first_name'].' '.$arr['Userdetail']['last_name'];
					$this->getmaildata(2);
					$this->mailBody = str_replace("{USER}",$user,$this->mailBody);
					$this->mailBody = str_replace("{PASSWORD}",$new_password,$this->mailBody);
					$flag = $this->sendmail($arr['User']['username']);
					/* code to send email confirmation for signup */
					
					if ($flag) {
						$this->Session->setFlash(NEW_SENT_FORGOT_PASSWORD, 'default', array("class"=>"success_message"));
						$this->User->save($arr);
					}
					else {
						$this->Session->setFlash(FAIL_SENT_FORGOT_PASSWORD);
					}
				} else {
					$this->Session->setFlash("This account has not been activated yet.");
				}
			}
			$this->redirect("/forgotpassword");
		}
	}
/* end of function */


	function deleteprofile() {
		if ($this->Session->read("Auth.User.id")) {
			$this->User->create();
			$this->User->id = $this->Session->read("Auth.User.id");
			$this->User->delete();
		}
		$this->redirect(array("controller"=>"users","action"=>"logout"));
	}

/*
 * @function name	: changepassword
 * @purpose			: to perform change password functionality in user panel, also validate old password and confirm if new and confirm password match or not 
 * @arguments		: NA
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10rd Jan 2013
 * @description		: NA
*/
	function changepassword() {
		$this->layout = "frontend_dummy";
		$this->set("title_for_layout","Change Password");
		if(isset($this->data) && !empty($this->data)) {
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
					$this->redirect("changepassword");
				} else {
					$this->Session->setFlash("Password can not updated successfully, Please try again.");
				}
			}
		} 
	}
/* end of function */

	
	function validateuser($id = Null) {
		if ($this->Session->read("admin.Admin")) {
			$this->User->recursive = -1;
			$users = $this->User->find("first",array("conditions"=>array("User.id"=>$id)));
			if (empty($users)) {
				$this->Session->setFlash("Invalid User.");
				$this->redirect(array("action"=>"index"));
			}
		} else {
			$this->Session->setFlash("You are not autheticate to perform this action.");
			$this->redirect(array("action"=>"index"));
		}
	}
	
	
	function getusers($keyword = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$keyword = trim($this->request->data['keyword']);
			$this->User->recursive = 0;
			if(!empty($keyword)) {
				$searchusers = $this->User->find("all",array("conditions"=>array("(CONCAT(Userdetail.first_name,' ',Userdetail.last_name) like '".$keyword."%' OR Userdetail.first_name like '".$keyword."%')","User.username <>"=>$this->Session->read("Auth.User.username")),"fields"=>array("Userdetail.first_name","Userdetail.image","Userdetail.last_name","User.id"),"order"=>"Userdetail.first_name asc"));
				$this->set("users",$searchusers);
			}
		}
	}
/*
 * @function name	: follow
 * @purpose			: to follow any other user
 * @arguments		: user_id
 * @return			: none
 * @created by		: Sandeep Kaur
 * @created on		: 7 August 2013
 * @description		: NA
*/
	function follow($id = NULL){
		$this->loadModel('Follower');
		$this->Follower->create();
		$follower['Follower']['user_id'] = $id;
		$follower['Follower']['follower_id'] = $this->Session->read("Auth.User.id");
		
		// get username
		$this->loadModel('Userdetail');
		$username = $this->Userdetail->find('first', array('fields'=>array('first_name','last_name'), 'conditions'=>array('Userdetail.user_id'=>$id)));
		if(empty($username)) {
			$this->Session->setFlash("Invalid user profile.");
			$this->redirect("/");
		}
		if($this->Follower->save($follower)):
			$notification = $this->checknotification($id);
			if ( !empty($notification) && isset($notification[2])) {
				/* code to send email for following a profile */
				$followerlink	= "<a href=".SITE_LINK."profile/".$follower['Follower']['follower_id']."/".$this->makeurl($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name")).">".ucwords($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"))."</a>";
				$this->getmaildata(14);
				$recemail = $this->useremail($id);
				$this->mailBody = str_replace("{USER}",ucwords($username['Userdetail']['first_name']." ".$username['Userdetail']['last_name']),$this->mailBody);
				$this->mailBody = str_replace("{FOLLOWER}",$followerlink,$this->mailBody);
				$this->sendmail($recemail);
				/* code to send email confirmation for signup */
			}
			$this->Session->setFlash("You are following ".$username['Userdetail']['first_name']." ".$username['Userdetail']['last_name'].".", 'default', array("class"=>"success_message"));
		else:
			$this->Session->setFlash("Sorry you can't follow ".$username['Userdetail']['first_name']." ".$username['Userdetail']['last_name'].".");
		endif;
		$this->redirect($this->referer());
	}
/*
 * @function name	: unfollow
 * @purpose			: to unfollow any other user who is followed already
 * @arguments		: user_id
 * @return			: none
 * @created by		: Sandeep Kaur
 * @created on		: 7 August 2013
 * @description		: NA
*/
	function unfollow($id = NULL){
		$this->loadModel('Follower');
		$unfollow = $this->Follower->find('first', array('fields'=>'Follower.id', 'conditions'=>array('Follower.user_id'=>$id, 'Follower.follower_id'=>$this->Session->read('Auth.User.id'))));
		$this->Follower->id = $unfollow['Follower']['id'];
		// get user name
		$this->loadModel('Userdetail');
		$username = $this->Userdetail->find('first', array('fields'=>array('first_name','last_name'), 'conditions'=>array('Userdetail.user_id'=>$id)));
		
		if($this->Follower->delete()):
			$this->Session->setFlash("You have unfollowed ".$username['Userdetail']['first_name']." ".$username['Userdetail']['last_name'].".", 'default', array("class"=>"success_message"));
		else:
			$this->Session->setFlash("Sorry you can't unfollow ".$username['Userdetail']['first_name']." ".$username['Userdetail']['last_name'].".");
		endif;
		$this->redirect($this->referer());
	}
	
	

	public function loginwith($provider) {
	    $this->autoRender = false;
		require_once( WWW_ROOT . 'hybridauth/Hybrid/Auth.php' );
		$hybridauth_config = array(
            "base_url" => 'http://' . $_SERVER['HTTP_HOST'] . $this->base . "/hybridauth/", // set hybridauth path
            "providers" => array(
                "Facebook" => array(
                    "enabled" => true,
                    "keys" => array("id" => "your_fb_api_key", "secret" => "fb_api_secret"),
                    "scope" => 'email',
                ),
                "Twitter" => array(
                    "enabled" => true,
                    "keys" => array("key" => TWITTER_API_ID, "secret" => TWITTER_SECRET_KEY)
                )
	// for another provider refer to hybridauth documentation
            )
        );
        try {
            // create an instance for Hybridauth with the configuration file path as parameter
            $hybridauth = new Hybrid_Auth($hybridauth_config);
			// try to authenticate the selected $provider
            $adapter = $hybridauth->authenticate($provider);
            // grab the user profile
            $user_profile = $adapter->getUserProfile();
            //login user using auth component
            if (!empty($user_profile)) {
                $user = $this->_findOrCreateUser($user_profile, $provider); // optional function if you combine with Auth component
                //unset($user['password']);
                $user['password'] = $user['username'];
                $this->request->data['User'] = $user;
                if ($this->Auth->login($this->request->data['User'])) {
					$this->getuserdetail();
					$this->redirect("/dashboard");
                    $this->Session->setFlash('You are successfully logged in.', 'default', array("class"=>"success_message"));
                } else {
                    $this->Session->setFlash('Failed to login.');
                }
            }
        } catch (Exception $e) {
            // Display the recived error
            switch ($e->getCode()) {
                case 0 : $error = "Unspecified error.";
                    break;
                case 1 : $error = "Hybriauth configuration error.";
                    break;
                case 2 : $error = "Provider not properly configured.";
                    break;
                case 3 : $error = "Unknown or disabled provider.";
                    break;
                case 4 : $error = "Missing provider application credentials.";
                    break;
                case 5 : $error = "Authentification failed. The user has canceled the authentication or the provider refused the connection.";
                    break;
                case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.";
                    $adapter->logout();
                    break;
                case 7 : $error = "User not connected to the provider.";
                    $adapter->logout();
                    break;
            }

            // well, basically you should not display this to the end user, just give him a hint and move on..
            $error .= "Original error message: " . $e->getMessage();
            $error .= "Trace: " . $e->getTraceAsString();
            $this->set('error', $error);
        }
        //die("here");
    }
	
	
	function logoutwith($provider = NULL) {
		$this->autoRender = false;
		require_once( WWW_ROOT . 'hybridauth/Hybrid/Auth.php' );
		$hybridauth_config = array(
            "base_url" => 'http://' . $_SERVER['HTTP_HOST'] . $this->base . "/hybridauth/", // set hybridauth path

            "providers" => array(
                "Facebook" => array(
                    "enabled" => true,
                    "keys" => array("id" => "your_fb_api_key", "secret" => "fb_api_secret"),
                    "scope" => 'email',
                ),
                "Twitter" => array(
                    "enabled" => true,
                    "keys" => array("key" => "CSpbRJK5eAEod91O7js5Gg", "secret" => "8KGhKpPzYRDX6FYkPVXTzvELN1D7pXtA78SYSnq44")
                )
	// for another provider refer to hybridauth documentation
            )
        );
        
         try {
            // create an instance for Hybridauth with the configuration file path as parameter
            $hybridauth = new Hybrid_Auth($hybridauth_config);
			// try to authenticate the selected $provider
            $adapter = $hybridauth->logoutAllProviders();
            // grab the user profile
            
        } catch (Exception $e) {
            // Display the recived error
            switch ($e->getCode()) {
                case 0 : $error = "Unspecified error.";
                    break;
                case 1 : $error = "Hybriauth configuration error.";
                    break;
                case 2 : $error = "Provider not properly configured.";
                    break;
                case 3 : $error = "Unknown or disabled provider.";
                    break;
                case 4 : $error = "Missing provider application credentials.";
                    break;
                case 5 : $error = "Authentification failed. The user has canceled the authentication or the provider refused the connection.";
                    break;
                case 6 : $error = "User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.";
                    $adapter->logout();
                    break;
                case 7 : $error = "User not connected to the provider.";
                    $adapter->logout();
                    break;
            }

            // well, basically you should not display this to the end user, just give him a hint and move on..
            $error .= "Original error message: " . $e->getMessage();
            $error .= "Trace: " . $e->getTraceAsString();
            $this->set('error', $error);
        }
	}

	// this is optional function to create user if not already in database. you can do anything with your hybridauth object
	private function _findOrCreateUser($user_profile = array(), $provider=null) {
        if (!empty($user_profile)) {
			$user = $this->User->find('first', array('conditions' => array('User.username' => $user_profile->identifier)));
			if (empty($user)) {
				$this->User->create();
				$userval['User']['username'] = $user_profile->identifier;
				$userval['User']['password'] = $this->Auth->password($user_profile->identifier);
				$userval['User']['loginfrom']= 'Twitter';
                if ($this->User->save($userval,array('validate' => false))) {
					$this->loadModel("Userdetail");
					$this->Userdetail->create();
					$userid = $this->User->getLastInsertId();
					$userdetail['Userdetail']['user_id'] = $userid;
					$userdetail['Userdetail']['first_name'] = $user_profile->firstName;
					if(!empty($user_profile->lastName)) {
						$userdetail['Userdetail']['last_name'] = $user_profile->lastName;
					}
					$this->Userdetail->save($userdetail);
                    $this->User->recursive = 0;
                    $user = $this->User->read(null, $userid);
                    return $user['User'];
                }
            } else {
				return $user['User'];
            }
        }
    }

}
