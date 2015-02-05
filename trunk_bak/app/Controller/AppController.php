<?php
session_start();

App::uses('Controller', 'Controller');
App::uses('Sanitize', 'Utility');	//Used for sanitizing the data

class AppController extends Controller {
	
	public $helpers		= array("Form","Html","Session","Facebook.Facebook");
	public $uses		= array("Admin","Accountdetail","Account","Breadcrumb");
	public $components	= array("Session","Cookie","Email","Image","RequestHandler","Auth" => array(
			'loginAction' => array(
						'controller' => 'pages',
						'action' => 'index'
					),
			'authError' => 'Did you really think you are allowed to see that?',
			'authenticate' => array(
				'Form' => array(
					'userModel' => 'User',
					'fields' => array(
						'username' => 'username',
						'password' => 'password'
					)
				)
			),		
			'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
		),'Facebook.Connect' => array('model' => 'User'));
	
/* public array variable to be used in admin panel for searching conditions */
	public $conditions		= array();
/* public array variable to be used to get ids of records to be deleted */	
	public $delarr			= array();
/* public array variable to be used to get ids of records to be updated */	
	public $updatearr		= array();
/* public variable to be used to get image name while uploading for edit profile,add/edit post etc */	
	public $imagename		= '';
/* public variable to be used to upload dir name while uploading for edit profile,add/edit post etc */	
	public $uploaddir		= '';
/* public array variable to be used to get user information while logging in */	
	public $loginedUserInfo	= array();
/* Public variable used for email functionality */
	public $value		= array();
	public $mailBody	= '';
	public $from		= '';
	public $subject		= '';
	public $template	= '';
	public $content		= '';
	public $userdomain  = '';
	public $initial		= 0;
	public $viewcourse	= 10;
/* Public variable used for Authorize user info */
	public $profileid	= '';
	public $paymentprofileid	= '';
	public $shippingprofileid	= '';
	public $dummycount =0;

/*
 * @function name	: beforefilter
 * @purpose			: used to check if user is logged in as admin or site user
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd Jan 2013
 * @description		: NA
*/
	function beforefilter(){
		//if (!empty($this->params->base) && $this->params->base == "/IOT1337/trunk") {
			if(!defined('SITE_LINK')) {
				define("SITE_LINK", "http://".$_SERVER['SERVER_NAME'].$this->params->base."/");
				define("FILE_LINK", "http://".$_SERVER['SERVER_NAME'].$this->params->base."/");
			}
			
		/*} else { 
			if(!defined('SITE_LINK')) {
				define("SITE_LINK","http://".$_SERVER['HTTP_HOST']."/");
				define("FILE_LINK","http://".$_SERVER['HTTP_HOST']."/");
			}
		}*/
		

		//PHP 5.3
		if ($this->params['controller'] == 'admins' || $this->params['prefix'] == 'admin') {
			$this->Auth->allow();
			$this->layout="admin";
		} elseif( isset($this->params['plugin']) && $this->params['plugin'] == 'blog') {
			$this->layout="frontend";
			$this->Auth->allow();
		} else { 
			$this->configuration();
			if ($this->Cookie->read('Auth.User') && !$this->Session->read("Auth.User.id")) {
				$this->redirect("/login");
			}
			if($this->Session->read("quizquestions") && $this->params['action'] != 'viewquiz' && $this->params['action'] != 'editquizquestion' && $this->params['action'] != 'deletequizquestion') {
				$this->Session->delete("quizquestions");
				$this->Session->delete("currentqst");
				$this->Session->delete("answerquiz");
			}
			$this->getstaticpage();
			if (!$this->Session->read("Auth.User.Userdetail")) {
				$this->getuserdetail();
			}
			if($this->Session->read("Auth.User.loginfrom") == 'Twitter' && !$this->Session->read("Auth.User.Userdetail.email") && $this->params['action'] != 'edit_profile_account' && $this->params['action'] != 'logout' && $this->params['action'] != 'dashboard') {
				$this->Session->setFlash("You need to set email first to continue with 1337 Institute Of Technology.<br/>**Note: You will not be able to edit this email in future so please make sure to enter a valid email address which you use frequently.");
				$this->redirect("/account");
			}
			if($this->Session->read("Auth.User.loginfrom") == 'Twitter' && !$this->Session->read("Auth.User.Userdetail.email") && $this->params['action'] == 'edit_profile_account') {
				$this->Session->setFlash("You need to set email first to continue with 1337 Institute Of Technology.<br/>**Note: You will not be able to edit this email in future so please make sure to enter a valid email address which you use frequently.");
			}
			if ($this->params['controller'] == 'pages' || $this->params['action'] == 'login') {
				$this->layout="frontend";
			} else { 
				$this->layout="frontend";
			}
		}
	}
/* end of function */
	
/*
 * @function name	: encryptpass
 * @purpose			: encrypt a password for admin for custom login check
 * @arguments		: Following are the arguments to be passed:
	 password to encrypt as $password
	 encryption method as $method 
	 $crop to define if encrypted password will be croped or not if true then croped otherwise not
	 $start and $stop will define starting and ending point of croping
 * @return			: encrypted password
 * @created by		: shivam sharma
 * @created on		: 3rd Jan 2013
 * @description		: while encrypting password,password has been encrypted then croped and then again encrypted to make it more secure because even in md5 encryption if a user is setting some random password like 123456 etc can be decrypted using some online tools
*/
	function encryptpass($password,$method = 'md5',$crop = true,$start = 4, $end = 10){
		if($crop){
			$password = $method(substr($method($password),$start,$end));
		}else{
			$password = $method($password);
		}
		return $password;
	}
/* end of function */


/*
 * @function name	: checklogin
 * @purpose			: redirect to dashboard if user is already login and trying to access login page or forgotpassword page
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd Jan 2013
 * @description		: NA
*/
	function checklogin($action = array()) {
		if ($this->params['controller'] == 'admins' || (isset($this->params['prefix']) && $this->params['prefix'] == 'admin')) {
			$currentAction = $this->params['action'];
			if (!in_array($currentAction,$action)) {
				if($this->Session->read('admin.Admin')) {
					
				} else {
					$this->redirect("/admin");
				}
			}
		} 
	}
/* end of function */


/*
 * @function name	: sendmail
 * @purpose			: sending email for various actions
 * @arguments		: Following are the arguments to be passed:
	 * from		: contain email address from which email is sending
	 * Subject	: Subject of Email
	 * to		: Email address to whom the email is sending
	 * body		: content of email
	 * template : if defining a html template for sending email else false.
	 * values	: to be given in email template like username etc.	 
 * @return			: true if email sending successfull else return false.
 * @created by		: shivam sharma
 * @created on		: 10th Jan 2013
 * @description		: NA
*/
	function sendmail($to,$template = 'email',$fromname = '1337 Institute of Technology') {
		App::uses('CakeEmail', 'Network/Email');
		if(isset($this->params->base) && !empty($this->params->base)) {
			$email = new CakeEmail("gmail");
		} else {
			$email = new CakeEmail();
		}
		if(filter_var($to, FILTER_VALIDATE_EMAIL)) {
			$email->from(array($this->from => $fromname));
			$email->to($to);
			$email->subject($this->subject);
			$headers[]  = 'MIME-Version: 1.0';
			$headers[]  = 'Content-type: text/html; charset=iso-8859-1';
			$email->addHeaders($headers);
			$email->emailFormat('both');
			if (empty($template)) {
				try {
					$email->send($this->mailBody);
					return true;
				} catch (Exception $e) {
					$e->getMessage();
					return false;
				}
			} else {
				
				if(!empty($this->mailBody)) {
					$email->viewVars(array("mail"=>$this->mailBody));
				}
				$email->template($template,'default');
				try {
					$email->send();
					return true;
				} catch (Exception $e) {
					$e->getMessage();
					return false;
				}
			}
		} else {
			return false;
		}
	}
/* end of function */

/*
 * @function name	: getmaildata
 * @purpose			: getting email data for various purposes
 * @arguments		: Following are the arguments to be passed:
	 * id		: id of email templates from cmsemail table
 * @return			: NONE
 * @created by		: shivam sharma
 * @created on		: 10th June 2013
 * @description		: function will assign value to global variables like mailbody,from, subject which will be used while sending email
*/
	
	function getmaildata($id = null) {
		$this->loadModel("Cmsemail");
		$cmsemail = $this->Cmsemail->find("first",array("conditions"=>array("Cmsemail.id"=>$id)));
		if (!empty($cmsemail)) {
			$this->mailBody = $cmsemail['Cmsemail']['mailcontent'];
			$this->from = $cmsemail['Cmsemail']['mailfrom'];
			$this->subject = $cmsemail['Cmsemail']['mailsubject'];
		}
	}
/* end of function */


/*
 * @function name	: adminbreadcrumb
 * @purpose			: to create bread crumb of admin module
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 4th jan 2013
 * @description		: NA
*/
	function adminbreadcrumb(){
		$breadcrumb = $this->Breadcrumb->find("all",array("conditions"=>array("controller"=>$this->params['controller'],"action"=>$this->params['action'])));
		if(!empty($breadcrumb)) {
			$this->set("breadcrumb",$breadcrumb);
		}
	}
/* end of function */


/*
 * @function name	: bulkactions
 * @purpose			: to perform multiple change status and delete in admin panel
 * @arguments		: flag which will indicate some special cases like users controller in which conditions we need to send confimation emails to users
 * @return			: will return array containing user ids but only when flag will be set true
 * @created by		: shivam sharma
 * @created on		: 4th Jun 2013
 * @description		: NA
*/
	function bulkactions($flag = false) {
		/* code to change status and delete by checking data from page */
		$controller = is_array($this->data)?array_keys($this->data):'';
		$statuskey  = '';
		$controller = isset($controller[0])?$controller[0]:'';
		$allowedarr = array("Account","User");
		if (isset($this->data[$controller]) && !empty($this->data[$controller]['options']) && !empty($controller)) {
			foreach ($this->data['id'] as $key=>$val) {
				if ($val > 0) {
					$this->delarr[]	= $key;
					if ($flag) {
						$statuskey		= ($this->data[$controller]['options']);
						$this->updatearr[$controller][$key]	= array("id"=>$key,"approve"=>($this->data[$controller]['options']));
					} else {
						$statuskey		= ($this->data[$controller]['options'] == 'Active'?1:0);
						$this->updatearr[$controller][$key]	= array("id"=>$key,"status"=>($this->data[$controller]['options'] == 'Active'?1:0));
					}
				}
			}
			if (isset($this->data[$controller]['options']) && $this->data[$controller]['options'] == 'Delete') {
				if($flag == 1){
					if($this->unlinkDB($this->delarr)){
						$this->$controller->delete($this->delarr);
					}
				}
				else{
					$this->$controller->delete($this->delarr);
				}
				$statuskey = -1;
			} else {
				$this->$controller->saveAll($this->updatearr[$controller]);
			}
			if (empty($this->data['Admin']['searchval'])) {
				$this->data = array();
			}
		}
		if (in_array($controller,$allowedarr) && $statuskey > -1) {
			$arr['keys'] 	= $this->delarr;
			$arr['status']  = $statuskey;
			return $arr; 
		}
		if ($flag) {
			$arr['keys'] = $this->delarr;
			$arr['status']  = $statuskey;
			return $arr; 
		}
		/* end of code to change status and delete by checking data from page */
	}
/* end of function */


/*
 * @function name	: bulkactions
 * @purpose			: to perform multiple change status and delete in admin panel
 * @arguments		: flag which will indicate some special cases like users controller in which conditions we need to send confimation emails to users
 * @return			: will return array containing user ids but only when flag will be set true
 * @created by		: shivam sharma
 * @created on		: 4th Jun 2013
 * @description		: NA
*/
	function frontendbulkactions($flag = false) {
		/* code to change status and delete by checking data from page */
		$controller = is_array($this->data)?array_keys($this->data):'';
		$statuskey  = '';
		$controller = isset($controller[0])?$controller[0]:'';
		$allowedarr = array("Account","User");
		if (isset($this->data[$controller]) && !empty($this->data[$controller]['options']) && !empty($controller)) {
			
			foreach ($this->data['id'] as $key=>$val) {
				if ($val > 0) {
					$this->delarr[]	= $key;
					if($flag) {
						$optvalue = isset($this->data[$this->data[$controller]['options']][$val])?$this->data[$this->data[$controller]['options']][$val]:'';
						if ($this->data[$controller]['options'] == 'messagestatus' && $optvalue == 'Delete') {
							$optvalue = 'Read';
						}
						if ($controller == 'Campaign' && $this->data[$controller]['options'] == 'delete') {
							$optvalue = '1';
						}
						$this->updatearr[$controller][$key]	= array("id"=>$key,$this->data[$controller]['options']=>$optvalue);
					} else {
						$this->updatearr[$controller][$key]	= array("id"=>$key,"status"=>($this->data[$controller]['options'] == 'Active'?1:0));
					}
				}
			}
			if (isset($this->data[$controller]['options']) && $this->data[$controller]['options'] == 'Delete' && !$flag) {
				$this->$controller->delete($this->delarr);
				$statuskey = -1;
			} else {
				$this->$controller->saveAll($this->updatearr[$controller]);
			}
			if (empty($this->data['Admin']['searchval'])) {
				$this->data = array();
			}
		}
		/* end of code to change status and delete by checking data from page */
	}
/* end of function */


/*
 * @function name	: uploadimage
 * @purpose			: to upload image files for various functionalities like 
 * @arguments		: Following are the arguments to be passed:
		* file			: File array to be uploaded
		* userid		: id/type/domain of user uploading the image
		* size			: allowed file size by user
		* destination	: destination folder name in which the image will be uploaded
		* usertype		: admin or user
		* imagename		: name of image going to upload
		* height		: used to resize image height 
		* width			: used to resize image height 
		* allowed		: allowed type to upload
 * @return			: image name with full destination detail on server
 * @created by		: shivam sharma
 * @created on		: 16th jan 2013
 * @description		: NA
*/
	public function uploadimage($file, $userid = null, $size = null, $destination = null, $usertype=null, $imagetype = '', $imagename=null, $height = 200, $width = 200, $allowed = array("jpg","jpeg","png","gif")) {
		//Configure::write('debug',2); 
		//code to upload with resizesing image//
		if (!is_dir(WWW_ROOT."img/tmp")) {
			exec("mkdir ".WWW_ROOT."img/tmp");
			exec("chmod 777 tmp");
		}
		
		if(($file['error'] == 0) && (move_uploaded_file($file['tmp_name'],WWW_ROOT."img/tmp/".$file['name']))){
			$orgfile = explode(".",$file['name']);
			if (empty($imagename)) {
				$this->imagename .= strtotime(date("y-m-d h:i:s")).".".$orgfile[count($orgfile)-1];
			} else {
				$this->imagename = $imagename.".".$orgfile[count($orgfile)-1];
			}
			
			if (!empty($userid)) {
				if (!is_dir(WWW_ROOT."img/".$userid)) {
					exec("mkdir ".WWW_ROOT."img/".$userid);
					if (!empty($imagetype)) {
						exec("mkdir ".WWW_ROOT."img/".$userid."/".$imagetype);
					}
					exec("chmod -R 777 ".WWW_ROOT."img/".$userid);
				} else {
					if (!empty($imagetype) && !is_dir(WWW_ROOT."img/".$userid."/".$imagetype)) {
						exec("mkdir ".WWW_ROOT."img/".$userid."/".$imagetype);
					}
					exec("chmod -R 777 ".WWW_ROOT."img/".$userid);
				}
				if($usertype == 'admin' && !is_dir(WWW_ROOT."img/".$userid."/".$imagetype)) {
					exec("mkdir ".WWW_ROOT."img/".$userid."/".$imagetype);
					exec("chmod -R 777 ".WWW_ROOT."img/".$userid);
				}
				$imagetype .= empty($imagetype)?'':"/";
				$this->uploaddir = "/img/".$userid."/".$imagetype;
			} elseif(!empty($destination)) {
				$destArr = explode("/",$destination);
				$deststr = '';
				if(!empty($destArr)) {
					foreach($destArr as $key=>$val) {
						if (!empty($val)) {
							$deststr .= "/".$val;
							if(!is_dir(WWW_ROOT."img".$destination)) {
								exec("mkdir ".WWW_ROOT."img".$deststr);
								exec("chmod 777 ".WWW_ROOT."img".$deststr);
							}
						}
					}
				}
				if (!is_dir(WWW_ROOT."img/".$destination)) {
					exec("mkdir ".WWW_ROOT."img/".$destination);
					exec("chmod 777 ".WWW_ROOT."img/".$destination);
				}
				$this->uploaddir = "/img/".$destination."/";
				
			} else {
				$this->uploaddir = "/img/";
			}
			exec("chmod -R 777 ".WWW_ROOT."img/");
			/* Thumbs of Profile and Course */
			if($imagetype == 'profileimg/'){
				$this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.LargeProfileImagePrefix.$this->imagename,LargeProfileImage,LargeProfileImage);
				$this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.MediumProfileImagePrefix.$this->imagename,MediumProfileImage,MediumProfileImage);
				$this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.MediumSmallProfileImagePrefix.$this->imagename,MediumSmallProfileImage,MediumSmallProfileImage);
				$this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.SmallImageProfilePrefix.$this->imagename,SmallProfileImage,SmallProfileImage);
				$this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.ThumbImageProfilePrefix.$this->imagename,ThumbProfileImage,ThumbProfileImage);
			} elseif($imagetype == 'coverimg'){
				$this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.LargeCourseImagePrefix.$this->imagename,LargeCourseImageWidth,LargeCourseImageHeight);
				$this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.MediumCourseImagePrefix.$this->imagename,MediumCourseImageWidth,MediumCourseImageHeight);
				$this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.MediumSmallCourseImagePrefix.$this->imagename,MediumSmallCourseImageWidth,MediumSmallCourseImageHeight);
				$this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.SmallCourseImagePrefix.$this->imagename,SmallCourseImage,SmallCourseImage);
			}
			/* Thumbs of Profile and Course */
			if ($this->Image->resize(WWW_ROOT."/img/tmp/".$file['name'],WWW_ROOT.$this->uploaddir.$this->imagename,$height,$width)){
				unlink(WWW_ROOT."/img/tmp/".$file['name']);
				return true;
			} else {
				unlink(WWW_ROOT."/img/tmp/".$file['name']);
				return false;
			}
		}
		//end here//
	}
/* end of function */


/*
 * @function name	: uploadvideo
 * @purpose			: to upload video files for various functionalities 
 * @arguments		: Following are the arguments to be passed:
		* file			: File array to be uploaded
		* userid		: id/type/domain of user uploading the image
		* destination	: destination folder name in which the image will be uploaded
 * @return			: file name with full destination detail on server
 * @created by		: shivam sharma
 * @created on		: 16th jan 2013
 * @description		: NA
*/
	function uploadvideos($file, $userid = null, $destination = null,$filename = NULL) {
		ini_set('max_execution_time', 0);
		$deststr = '';
		if (!empty($file)) {
			$orgfile = explode(".",$file['name']);
			if (!empty($filename)) {
				$this->imagename = $filename;
			} else {
				$this->imagename .= strtotime(date("y-m-d h:i:s")).".".$orgfile[count($orgfile)-1];
			}
			if (!is_dir(WWW_ROOT."/img/".$userid)) {
				exec("mkdir ".WWW_ROOT."img/".$userid);
				exec("chmod -R 777 ".WWW_ROOT."img/".$userid);
			}
			if (!empty($destination)) {
				$destArr = explode("/",$destination);
				if(!empty($destArr)) {
					foreach($destArr as $key=>$val) {
						if (!empty($val)) {
							$deststr .= "/".$val;
							if(!is_dir(WWW_ROOT."img".$destination)) {
								if(!is_dir(WWW_ROOT."img".$deststr)) {
									exec("mkdir ".WWW_ROOT."img".$deststr);
									exec("chmod 777 ".WWW_ROOT."img".$deststr);
								}
							}
						}
					}
				} else {
					exec("mkdir ".WWW_ROOT."img/".$userid."/".$destination);
				}
				exec("chmod -R 777 ".WWW_ROOT."img/".$userid);
			}
			$this->uploaddir = empty($destination)?WWW_ROOT."img/".$userid:WWW_ROOT."img".$userid."/".$destination."/";
			
			if(strtolower($orgfile[count($orgfile)-1]) != 'mp4') {
				exec(FFMPEG_PATH." -i ".escapeshellarg($file['tmp_name'])." -b 500k -vcodec libx264 -g 30 ".escapeshellarg($this->uploaddir.$this->imagename.".mp4").""); //encode video into mp4 format
				unlink($this->uploaddir.$this->imagename);
				$this->imagename = $this->imagename.".mp4";
			} else {
				move_uploaded_file($file['tmp_name'],$this->uploaddir.$this->imagename);
			}
			$target1 = WWW_ROOT."/img/".$userid."/".$destination."/".$this->imagename.".jpg"; 
			if (!is_dir(WWW_ROOT."/img/".$userid."/".$destination."/"."preview")) {
				exec("mkdir ".WWW_ROOT."/img/".$userid."/".$destination."/"."preview");
				exec("chmod -R 777 ".WWW_ROOT."/img/".$userid."/".$destination."/"."preview");
			}
			$time = '00:00:04';
			exec("/usr/bin/ffmpeg -i ".$this->uploaddir.$this->imagename." -an -ss " . $time . " -an -r 1 -s qcif -vframes 1 -y -s 571x342 ".$target1."");
			//$this->uploaddir = str_replace(WWW_ROOT,"",$this->uploaddir);
			$this->uploaddir.$this->imagename;
			//die;
			//return true;
			if (file_exists($this->uploaddir.$this->imagename)) {
				/*if (!is_dir(WWW_ROOT."/img/".$userid."/".$destination."/"."preview")) {
					exec("mkdir ".WWW_ROOT."/img/".$userid."/".$destination."/"."preview");
					exec("chmod -R 777 ".WWW_ROOT."/img/".$userid."/".$destination."/"."preview");
				}
				$time = '00:00:04';
				
				if(strtolower($orgfile[count($orgfile)-1]) != 'mp4') {
					exec(FFMPEG_PATH." -i ".escapeshellarg($this->uploaddir.$this->imagename)." -b 500k -vcodec libx264 -g 30 ".escapeshellarg($this->uploaddir.$this->imagename.".mp4").""); //encode video into mp4 format
					unlink($this->uploaddir.$this->imagename);
					$this->imagename = $this->imagename.".mp4";
				}
				$target1 = WWW_ROOT."/img/".$userid."/".$destination."/".$this->imagename.".jpg"; 
				exec("/usr/bin/ffmpeg -i ".$this->uploaddir.$this->imagename." -an -ss " . $time . " -an -r 1 -s qcif -vframes 1 -y -s 571x342 ".$target1.""); */
				$this->uploaddir = str_replace(WWW_ROOT,"",$this->uploaddir); 
				return true;
			} else {
				return false;
			}
		}
	}
/* end of function */


/*
 * @function name	: uploadvideofly
 * @purpose			: to upload video files for lectures only 
 * @arguments		: Following are the arguments to be passed:
		* file			: File array to be uploaded
		* name			: specify the name for file to be uploaded
		* destination	: destination folder name in which the image will be uploaded
 * @return			: file name with full destination detail on server
 * @created by		: shivam sharma
 * @created on		: 16th jan 2013
 * @description		: NA
*/
	function uploadvideofly($file,$name="lecturevideo",$image=true,$destination=NULL,$flag = False) {
		ini_set('max_execution_time', 0);
		ini_set('memory_limit','1024M');
		$userid = $this->Session->read("Auth.User.id");
		$destination = $userid."/Course".$this->Session->read("courseid")."/Section".$this->Session->read("sectionid")."/Lecture".$this->Session->read("lectureid");
		$deststr = '';
		/* code to create file name to be uploaded */
		$orgfile = explode(".",$file['name']);
		if ( empty($name) ) {
			$this->imagename .= strtotime(date("y-m-d h:i:s")).".".$orgfile[count($orgfile)-1];
		} else {
			$this->imagename = $name.strtotime(date("y-m-d h:i:s")).".".$orgfile[count($orgfile)-1];
			//$this->imagename = $name.".".$orgfile[count($orgfile)-1];
		}
		/* code to create file name to be uploaded end here */
		
		/* code to create destination folder */
		if (!is_dir(WWW_ROOT."/img/".$userid)) {
			exec("mkdir ".WWW_ROOT."img/".$userid);
			exec("chmod -R 777 ".WWW_ROOT."img/".$userid);
		}
		if (!empty($destination)) {
			$destArr = explode("/",$destination);
			if(!empty($destArr)) {
				foreach($destArr as $key=>$val) {
					if (!empty($val)) {
						$deststr .= "/".$val;
						if(!is_dir(WWW_ROOT."img".$destination)) {
							if(!is_dir(WWW_ROOT."img".$deststr)) {
								exec("mkdir ".WWW_ROOT."img".$deststr);
								exec("chmod 777 ".WWW_ROOT."img".$deststr);
							}
						}
					}
				}
			} else {
				exec("mkdir ".WWW_ROOT."img/".$userid."/".$destination);
			}
			exec("chmod -R 777 ".WWW_ROOT."img/".$userid);
		}
		/* code to create destination folder end here */
		$this->uploaddir = empty($destination)?WWW_ROOT."img/".$userid:WWW_ROOT."img/".$destination."/";
		//if (move_uploaded_file($file['tmp_name'],$this->uploaddir.$this->imagename)) {
		if (isset($file['tmp_name']) && !empty($file['tmp_name'])) {
			if($image) {
				if (!is_dir(WWW_ROOT."/img/".$destination."/"."preview")) {
					exec("mkdir ".WWW_ROOT."/img"."/".$destination."/"."preview");
					exec("chmod -R 777 ".WWW_ROOT."/img/".$destination."/"."preview");
				}
				$time = '00:00:04';
				if(file_exists($this->uploaddir.$this->imagename.".mp4")) {
					unlink($this->uploaddir.$this->imagename.".mp4");
					unlink($this->uploaddir.$this->imagename.".mp4.webm");
				}
				exec("rm ".$this->uploaddir."*");
				exec(FFMPEG_PATH . " -i " . escapeshellarg($file['tmp_name']) . " -b 500k -vcodec libx264 -g 30 " . escapeshellarg($this->uploaddir . $this->imagename . ".mp4") . " > /dev/null 2>/dev/null &"); //encode video into mp4 format
				//unlink($this->uploaddir.$this->imagename);
				$this->imagename = $this->imagename . ".mp4";
				exec(FFMPEG_PATH . " -i " . escapeshellarg($file['tmp_name']) . " -acodec libvorbis -b:a 64k -ac 2 -vcodec libvpx -b:v 200k -f webm -s 384x216 " . escapeshellarg($this->uploaddir . $this->imagename) . ".webm > /dev/null 2>/dev/null &"); //encode video into webm format
				$target1 = WWW_ROOT."/img/".$destination."/".$this->imagename.".jpg"; 
				exec("/usr/bin/ffmpeg -i ".$file['tmp_name']." -an -ss " . $time . " -an -r 1 -s qcif -vframes 1 -y -s 1000x1000 ".$target1."");
			} elseif($flag) {
				if(file_exists($this->uploaddir.$this->imagename.".mp3")) {
					unlink($this->uploaddir.$this->imagename.".mp3");
					unlink($this->uploaddir.$this->imagename.".mp3.ogg");
				}
				exec("rm ".$this->uploaddir."*");
				
			//	exec("rm ".$this->uploaddir." *");
			//echo rtrim(ltrim(strtolower($orgfile[count($orgfile)-1])));
			
				if(rtrim(ltrim(strtolower($orgfile[count($orgfile)-1]))) != 'mp3') {
					//echo FFMPEG_PATH." -itsoffset -1 -i ".escapeshellarg($file['tmp_name'])." -vcodec mjpeg -vframes 1 ".escapeshellarg($this->uploaddir.$this->imagename.".mp3")."";
					exec(FFMPEG_PATH." -itsoffset -1 -i ".escapeshellarg($file['tmp_name'])." -vcodec mjpeg -vframes 1 ".escapeshellarg($this->uploaddir.$this->imagename.".mp3").""); //encode audio into mp3 format
					$this->imagename = $this->imagename.".mp3";
				} else {
					if(move_uploaded_file($file['tmp_name'],$this->uploaddir.$this->imagename)) {
						//die("succ");
					} else {
						//die("fail");
					}
				}
				//echo "<br/>".FFMPEG_PATH." -i ".escapeshellarg($this->uploaddir.$this->imagename)." -acodec libvorbis ".escapeshellarg($this->uploaddir.$this->imagename.".ogg");
				exec(FFMPEG_PATH." -i ".escapeshellarg($this->uploaddir.$this->imagename)." -acodec libvorbis ".escapeshellarg($this->uploaddir.$this->imagename.".ogg")); //encode audio into ogg format
			} else {
				move_uploaded_file($file['tmp_name'],$this->uploaddir.$this->imagename);
			}
			
			$this->uploaddir = str_replace(WWW_ROOT,"",$this->uploaddir);
			$this->uploaddir.$this->imagename;
			return true;
		} else {
			return false;
		}
	}
/* end of function */


/*
 * @function name	: getoldfile
 * @purpose			: to get file name which was uploaded for any lecture in past
 * @arguments		: Following are the arguments to be passed:
		* lectureid		: File array to be uploaded
 * @return			: file name with full destination detail on server
 * @created by		: shivam sharma
 * @created on		: 16th jan 2013
 * @description		: NA
*/
	function getoldfile($lectureid = NULL) {
		$this->loadModel("CourseLecture");
		$this->CourseLecture->recursive = -1;
		$lecture = $this->CourseLecture->find("first",array("conditions"=>array("id"=>$lectureid),"fields"=>array("content_source")));
		return $lecture['CourseLecture']['content_source'];
	}
/* end of function */


/*
 * @function name	: copyfromlibrary
 * @purpose			: to copy a file from one folder to another
 * @arguments		: Following are the arguments to be passed:
		* source		: source of a file from which file will be copied
		* destination	: destination of a file to which file will be copied
		* userid		: id of logged user
		* video			: used as boolean which will defined if uploaded file is a video file
 * @return			: file name with full destination detail on server
 * @created by		: shivam sharma
 * @created on		: 16th august 2013
 * @description		: NA
*/
	function copyfromlibrary($source = NULL, $destination = NULL,$userid = NULL, $video = false) {
		if (!empty($destination)) {
			$destArr = explode("/",$destination);
			$deststr = '';
			if(!empty($destArr)) {
				foreach($destArr as $key=>$val) {
					if (!empty($val)) {
						$deststr .= "/".$val;
						if(!is_dir(WWW_ROOT."img".$destination)) {
							if(!is_dir(WWW_ROOT."img".$deststr)) {
								exec("mkdir ".WWW_ROOT."img".$deststr);
								exec("chmod 777 ".WWW_ROOT."img".$deststr);
							}
						}
					}
				}
			} else {
				exec("mkdir ".WWW_ROOT."img/".$userid."/".$destination);
			}
			exec("chmod -R 777 ".WWW_ROOT."img/".$userid);
		}
		$this->uploaddir = empty($destination)?WWW_ROOT."img/".$userid:WWW_ROOT."img/".$destination."/";
		$this->imagename = explode("/",$source);
		$this->imagename = $this->imagename[count($this->imagename)-1];
		if (file_exists(WWW_ROOT."img/".$destination."/".$this->imagename)) {
			$orgfile = explode(".",$this->imagename);
			$this->imagename = strtotime(date("y-m-d h:i:s")).".".$orgfile[count($orgfile)-1];
		}
		if (copy(WWW_ROOT.$source,WWW_ROOT."img/".$destination."/".$this->imagename)) {
			if($video) {
				if (!is_dir(WWW_ROOT."/img/".$destination."/"."preview")) {
					exec("mkdir ".WWW_ROOT."/img"."/".$destination."/"."preview");
					exec("chmod -R 777 ".WWW_ROOT."/img/".$destination."/"."preview");
				}
				$time = '00:00:04';
				$target1 = WWW_ROOT."/img/".$destination."/"."preview/".$this->imagename.".jpg"; 
				exec("/usr/bin/ffmpeg -i ".$this->uploaddir.$this->imagename." -an -ss " . $time . " -an -r 1 -s qcif -vframes 1 -y ".$target1."");
			}
			$this->uploaddir = str_replace(WWW_ROOT,"",$this->uploaddir);
			return true;
		} else {
			return false;
		}
	}
/* end of function */


/*
 * @function name	: getaddress
 * @purpose			: to get detail of address according to Zip code used while adding post
 * @arguments		: Following are the arguments to be passed:
		* zip			: zip code from which adress will be searched
		* address		: to be returned
 * @return			: adress containing zip and other information like city,state,country
 * @created by		: shivam sharma
 * @created on		: 20th jan 2013
 * @description		: NA
*/
	function getaddress($zip,$address=null)	{
		
		$curl_handle=curl_init();
		$address=urlencode($zip);
		$url="http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=false";
		curl_setopt($curl_handle,CURLOPT_URL,$url);
		curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
		$data = curl_exec($curl_handle);
		curl_close($curl_handle);
		$data =  json_decode($data);
		if(!empty($data) && $data->status == 'OK' )
		{
			$lat= $data->results[0]->geometry->location->lat;
			$long  = $data->results[0]->geometry->location->lng;
		}
		try {
			if(isset($data->results[0]->formatted_address)) {
				$address = $data->results[0]->formatted_address;
			} else {
				$address = '';
			}
		} catch(Exception $e) {
			$address = 1;
		}
		return $address;
	}
/* end of function */

	
/*
 * @function name	: getuserdetail
 * @purpose			: to get detail of logged in user
 * @arguments		: Following are the arguments to be passed:
		* id			: id of logged in user
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 20th june 2013
 * @description		: this function will fetch detail from userdetail table and append it with auth session
*/	
	function getuserdetail($id = null,$model = NULL) {
		if ($this->Session->read("Auth.User.id")) {
			$id = $this->Session->read("Auth.User.id");
		}
		if(!empty($id)) {
			$this->loadModel("Userdetail");
			$this->Userdetail->recursive = 0;
			$userdetail = $this->Userdetail->find("all",array("conditions"=>array("Userdetail.user_id"=>$id),"recursive"=>"-1"));
			if ($this->Session->read("Auth.User.userdetail")) {
				$this->Session->delete("Auth.User.userdetail");
			}
			$this->Session->write("Auth.User.userdetail",$userdetail[0]['Userdetail']);
			$this->Session->write("Auth.User.Userdetail",$userdetail[0]['Userdetail']);
		}
	}
/* end of function */	


/*
 * @function name	: checknotification
 * @purpose			: to get detail of notification of a logged in user
 * @arguments		: Following are the arguments to be passed:
		* id			: id of logged in user
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 20th june 2013
 * @description		: this function will fetch detail from userdetail table and append it with auth session
*/	
	function checknotification($id = null) {
		$notifications = array();
		if(!empty($id)) { 
			$this->loadModel("Userdetail");
			$this->Userdetail->recursive = -1;
			$notifications = $this->Userdetail->find("first",array("conditions"=>array("Userdetail.user_id"=>$id)));
			$notifications = unserialize($notifications['Userdetail']['notification']);
		}
		return $notifications;
	}
/* end of function */	


/*
 * @function name	: username
 * @purpose			: to get name of logged in user
 * @arguments		: Following are the arguments to be passed:
		* id			: id of logged in user
 * @return			: name of logged in user
 * @created by		: shivam sharma
 * @created on		: 20th june 2013
 * @description		: NA
*/		
	function username($id) {
		$this->loadModel("Userdetail");
		$this->Userdetail->recursive = -1;
		$userdetail = $this->Userdetail->find("first",array("conditions"=>array("Userdetail.user_id"=>$id),"fields"=>array("Userdetail.first_name","Userdetail.last_name")));
		return ($userdetail['Userdetail']['first_name'].' '.$userdetail['Userdetail']['last_name']);
	}
/* end of function */

/*
 * @function name	: username
 * @purpose			: to get name of logged in user
 * @arguments		: Following are the arguments to be passed:
		* id			: id of logged in user
 * @return			: name of logged in user
 * @created by		: shivam sharma
 * @created on		: 20th june 2013
 * @description		: NA
*/		
	function course($id,$flag = false) {
		$this->loadModel("Course");
		$this->Course->recursive = -1;
		$coursedetail = $this->Course->find("first",array("conditions"=>array("Course.id"=>$id),"fields"=>array("Course.title","Course.user_id")));
		if ($flag) {
			return ($coursedetail['Course']['user_id']);
		} else {
			return ($coursedetail['Course']['title']);
		}
	}
/* end of function */


/*
 * @function name	: useremail
 * @purpose			: to get email of logged in user
 * @arguments		: Following are the arguments to be passed:
		* id			: id of logged in user
 * @return			: email of logged in user
 * @created by		: shivam sharma
 * @created on		: 20th june 2013
 * @description		: it contain two scenerios in first a normal user who is singup via fb or site will have email details in user table as username and while signup using twitter have email details in userdetails table.
*/	
	function useremail($id = null) {
		$this->loadModel("User");
		$this->User->recursive = 0;
		$userdetail = $this->User->find("first",array("conditions"=>array("User.id"=>$id),"fields"=>array("User.username","User.loginfrom","Userdetail.email")));
		if ($userdetail['User']['loginfrom'] == 'Twitter') {
			return ($userdetail['Userdetail']['email']);
		} else {
			return ($userdetail['User']['username']);
		}
	}
/* end of function */


/*
 * @function name	: createinvoice
 * @purpose			: to get create an invoice number for every transaction
 * @arguments		: Following are the arguments to be passed:
		* userid		: id of logged in user
 * @return			: invoice number
 * @created by		: shivam sharma
 * @created on		: 20th june 2013
 * @description		: NA
*/
	function createinvoice($userid = NULL) {
		$this->loadModel("Order");
		if(empty($userid)) {
			$orderid = $this->Order->find("count",array("conditions"=>array("Order.buyer_id"=>$this->Session->read("Auth.User.id"))));
			$invoice = "1337IOT/".date("Y-m-d")."/".$this->Session->read("Auth.User.id")."/".($orderid+1);
		} else { 
			$orderid = $this->Order->find("count",array("conditions"=>array("Order.buyer_id"=>$userid)));
			$invoice = "1337IOT/".date("Y-m-d")."/".$userid."/".($orderid+1);
		}
		
		return $invoice;
	}
/* end of function */


/*
 * @function name	: makeurl
 * @purpose			: to get a seo friendly url
 * @arguments		: Following are the arguments to be passed:
		* str		: string to parse as url
 * @return			: string
 * @created by		: shivam sharma
 * @created on		: 20th june 2013
 * @description		: it will remove spaces from string and replace it with "-"
*/
	function makeurl($str = NULL) {
		if(!empty($str)) {
			$str = strtolower(str_replace(' ','-',substr(strip_tags($str),0,80)));
		}
		return $str;
	}
/* end of function */


/*
 * @function name	: configuration
 * @purpose			: to make default variables as global variable which will be used throu-out the site
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th june 2013
 * @description		: it will define some global variables specified by "default_header" from configurations table
*/	
	function configuration() { 
		$this->loadModel("Configuration");
		$configurations = $this->Configuration->find("all");
		$str = "";
		foreach($configurations as $key=>$val) {
			if(!defined($val['Configuration']['default_header'])) {
				//$str .= "define('".$val['Configuration']['default_header']."','".$val['Configuration']['value']."');".'\n';
				$str .= 'define("'.$val['Configuration']['default_header'].'","'.$val['Configuration']['value'].'");'."\n";
			}
		}
		if(!empty($str)) {
			$str .= "define('RETURN_URL','http://".$_SERVER['SERVER_NAME'].$this->params->base."/');\n";
			$str .= "define('CENCEL_URL','http://".$_SERVER['SERVER_NAME'].$this->params->base."/');\n";
			$str = "<?php \n".$str."?>";
			$file = WWW_ROOT."custom/config.php";
			if(file_exists($file)) {
				unlink($file);
			}
			file_put_contents($file, $str, FILE_APPEND | LOCK_EX);
		}
	}
/* end of function */


/*
 * @function name	: getcoursedetails
 * @purpose			: to get details of course goals, course requirements, course audience for a specific course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th june 2013
 * @description		: it will get details for course goals, course requirements, course audience for a specific course and set them to make a variable
*/
	function getcoursedetails($id = NULL) {
		$this->loadModel("CourseGoal");
		$this->loadModel("CourseRequirement");
		$this->loadModel("CourseAudience");
		$viewcoursegoals = $this->CourseGoal->find("first",array("conditions"=>array("CourseGoal.course_id"=>$id),"fields"=>array("CourseGoal.id","CourseGoal.title")));
		$viewcourseaudience = $this->CourseAudience->find("first",array("conditions"=>array("CourseAudience.course_id"=>$id),"fields"=>array("CourseAudience.id","CourseAudience.title")));
		$viewcourserequirement = $this->CourseRequirement->find("first",array("conditions"=>array("CourseRequirement.course_id"=>$id),"fields"=>array("CourseRequirement.id","CourseRequirement.title")));
		$this->set(compact("viewcoursegoals","viewcourseaudience","viewcourserequirement"));
	}
/* end of function */

	
/*
 * @function name	: getusercommission
 * @purpose			: to get commission detail which will be distributed for between course instructors
 * @arguments		: Following are the arguments to be passed:
		* course_id			: id of course default null
		* id				: id of instructor / user default null
		* flag				: boolean to define if commission is calculated for all instructors or a particular instructor default false
 * @return			: commission array
 * @created by		: shivam sharma
 * @created on		: 15th june 2013
 * @description		: it will get details for commissions for site, course creater and every instructor who are assigned as instructor by course creater
*/	
	function getusercommission($course_id = NULL, $id = NULL, $flag=true) {
		if ($flag) {
			$coursedistributedcommission = $this->CourseInstructor->find("first",array("conditions"=>array("CourseInstructor.course_id"=>$course_id,"CourseInstructor.user_id <>"=>$this->Session->read("Auth.User.id")),"fields"=>"Sum(commission) as distributed_commission"));
			$commission = (100-(SITE_COMMISSION))-$coursedistributedcommission[0]['distributed_commission'];
		} else {
			$coursedistributedcommission = $this->CourseInstructor->find("first",array("conditions"=>array("CourseInstructor.course_id"=>$course_id,"CourseInstructor.user_id "=>$id),"fields"=>"Sum(commission) as distributed_commission"));
			$commission = $coursedistributedcommission[0]['distributed_commission'];
		}
		return $commission;
	}
/* end of function */


/*
 * @function name	: getallusercommission
 * @purpose			: to get commission detail which will be distributed for between course instructors
 * @arguments		: Following are the arguments to be passed:
		* course_id			: id of course default null
 * @return			: commission array
 * @created by		: shivam sharma
 * @created on		: 15th june 2013
 * @description		: it will get details for commissions for site, course creater and every instructor who are assigned as instructor by course creater
*/	
	function getallusercommission($course_id = NULL) {
		$this->Course->recursive = -1;
		$this->loadModel("CourseInstructor");
		$coursedetail = $this->Course->find("first",array("conditions"=>array("Course.id"=>$course_id)));
		$this->CourseInstructor->recursive = -1;
		$price = $coursedetail['Course']['price'];
		$sitecomm = (($price)*(SITE_COMMISSION))/100; 
		$price -= $sitecomm;
		$coursedistributedcommission = $this->CourseInstructor->find("all",array("conditions"=>array("CourseInstructor.course_id"=>$course_id)));
		$finalcommission = array();
		foreach ($coursedistributedcommission as $key=>$val) {
			if($val['CourseInstructor']['user_id'] != $coursedetail['Course']['user_id']) {
				$paypalemail = $this->getpaypalemail($val['CourseInstructor']['user_id']);
				if(!empty($paypalemail)) {
					$commission = ($coursedetail['Course']['price']*$val['CourseInstructor']['commission'])/100;
					$price -= $commission;
					$finalcommission[$paypalemail] = array("userid"=>$val['CourseInstructor']['user_id'],"amount"=>number_format($commission,"2",".",""),"paypalemail"=>$paypalemail,"email"=>$this->useremail($val['CourseInstructor']['user_id']),"status"=>"false");
				}
			}
		}
		$paypalemail = $this->getpaypalemail($coursedetail['Course']['user_id']);
		$finalcommission[$paypalemail] = array("userid"=>$coursedetail['Course']['user_id'],"amount"=>number_format($coursedetail['Course']['price'],"2",".",""),"paypalemail"=>$paypalemail,"email"=>$this->useremail($coursedetail['Course']['user_id']),"status"=>"true");
		if(API_MODE == 'sandbox') {
			$finalcommission[PAYPAL_DEVELOPER_EMAIL] = array("userid"=>"","amount"=>number_format($sitecomm,"2",".",""),"paypalemail"=>'1337institute-facilitator@gmail.com',"email"=>"1337institute-facilitator@gmail.com","status"=>"false");
		} else {
			$finalcommission[PAYPAL_DEVELOPER_EMAIL] = array("userid"=>"","amount"=>number_format($sitecomm,"2",".",""),"paypalemail"=>PAYPAL_DEVELOPER_EMAIL,"email"=>PAYPAL_DEVELOPER_EMAIL,"status"=>"false");
		}
		return $finalcommission;
	}
/* end of function */


/*
 * @function name	: captureviewcourse
 * @purpose			: to capture user view for a particular course
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course default null
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th june 2013
 * @description		: it will capture the user reviewal of a course and will save it in database for futher use.it will not let the count increased greater than 10 for any course.
*/
	function getpaypalemail($userid = NULL) {
		if (!empty($userid)) {
			$this->loadModel("Userdetail");
			$this->Userdetail->recursive = -1;
			$userpaypal = $this->Userdetail->find("first",array("conditions"=>array("Userdetail.user_id"=>$userid),"fields"=>array("Userdetail.paypalaccount")));
			return $userpaypal['Userdetail']['paypalaccount'];
		}
	}
/* end of function */

	
/*
 * @function name	: captureviewcourse
 * @purpose			: to capture user view for a particular course
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course default null
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th june 2013
 * @description		: it will capture the user reviewal of a course and will save it in database for futher use.it will not let the count increased greater than 10 for any course.
*/	
	function captureviewcourse($courseid = NULL) {
		if ($this->Session->read("Auth.User.id")) {
			$this->loadModel("UserViewCourse");
			$this->UserViewCourse->recursive = -1;
			/* code to check if course id is not empty */
			if (!empty($courseid)) {
				/* code to check if logged user has an entry in table already */
				$usercourseview = $this->UserViewCourse->find("first",array("conditions"=>array("UserViewCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserViewCourse.course_id"=>$courseid),"fields"=>"UserViewCourse.id"));
				/* code ned */
				/* code to check count of a particular course in view table */
				$usercourseviewcount = $this->UserViewCourse->find("count",array("conditions"=>array("UserViewCourse.course_id"=>$courseid),"fields"=>"UserViewCourse.id"));
				/* code to check count of a particular course in view table end here */
				/* if user has not any entry for course and count is less than $this->viewcourse the below code will insert a new entry in view table*/
				if (empty($usercourseview)) {
					if ($usercourseviewcount  == $this->viewcourse) {
						$firstcourseview = $this->UserViewCourse->find("first",array("conditions"=>array("UserViewCourse.course_id"=>$courseid),"fields"=>"UserViewCourse.id"));
						$this->UserViewCourse->create();
						$this->UserViewCourse->id = $firstcourseview['UserViewCourse']['id'];
						$this->UserViewCourse->delete();
					}
					$userview['UserViewCourse']['course_id']	= $courseid;
					$userview['UserViewCourse']['user_id'] 		= $this->Session->read("Auth.User.id");
					$this->UserViewCourse->create();
					$this->UserViewCourse->save($userview);
				}
				/* end here */
			}
			/* code to check if course id is not empty end here */
		}
	}
/* end of function */


/*
 * @function name	: getmoreviewedcourses
 * @purpose			: to get courses which were viewed by the users who viewed this particular course in past
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course default null
		* listing			: boolean which will be used to define return type of data
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 28th july 2013
 * @description		: it will get the details of courses last viewed by users
*/	
	function getmoreviewedcourses($courseid = NULL,$listing = false) {
		$this->loadModel("UserViewCourse");
		$this->UserViewCourse->recursive = 0;
		$usersview = $this->UserViewCourse->find("list",array("conditions"=>array("UserViewCourse.course_id"=>$courseid),"fields"=>array("UserViewCourse.user_id")));
		$usersview = implode(",",$usersview);
		$this->UserViewCourse->virtualFields = array("students"=>"select count(*) as countstudent from user_learning_courses as UserLearningCourse where UserLearningCourse.course_id = UserViewCourse.course_id",
		"review"=>"select avg(rating) rating from course_reviews CourseReview where CourseReview.course_id = UserViewCourse.course_id",
		"name"=>"select concat(Userdetail.first_name,' ',Userdetail.last_name) as name from userdetails as Userdetail where Userdetail.user_id = Course.user_id"
		);
		if (!empty($usersview)) {
			if ($listing) {
				$usersview = $this->UserViewCourse->find("all",array("conditions"=>array("UserViewCourse.user_id in (".$usersview.")"),"fields"=>array("distinct(UserViewCourse.course_id)","UserViewCourse.students","UserViewCourse.review","Course.id","Course.title","Course.summary","Course.subtitle","Course.price","Course.coverimage","UserViewCourse.name","Course.user_id"),"limit"=>$this->viewcourse));
			} else {
				$usersview = $this->UserViewCourse->find("all",array("conditions"=>array("UserViewCourse.user_id in (".$usersview.")"),"fields"=>array("distinct(UserViewCourse.course_id)","UserViewCourse.students","UserViewCourse.review","Course.id","Course.title","Course.subtitle","Course.price","Course.coverimage","UserViewCourse.name","Course.user_id"),"limit"=>"3"));
			}
		}
		$this->set("usersview",$usersview);
	}
/* end of function */


/*
 * @function name	: getcoursereviews
 * @purpose			: to get review for the course
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course default null
		* listing			: boolean which will be used to define return type of data
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 28th july 2013
 * @description		: it will get the details of courses last viewed by users
*/
	function getcoursereviews($courseid,$listing = false,$userid = NULL) {
		$this->loadModel("CourseReview");
		$this->CourseReview->bindModel(array("hasOne"=>array("Userdetail"=>array("className"=>"Userdetail","foreignKey"=>false,"conditions"=>"Userdetail.user_id = CourseReview.user_id"))));
		$this->CourseReview->unbindModel(array("belongsTo"=>array("User","Course")));
		$this->CourseReview->virtualFields = array(
		"avgrating"=>"select avg(rating) from course_reviews CourseReview where CourseReview.course_id =".$courseid
		);
		if($listing) {
			$this->paginate = array("fields"=>array("CourseReview.rating","CourseReview.avgrating","CourseReview.Created","CourseReview.review_text ","Userdetail.first_name","Userdetail.last_name","Userdetail.image","Userdetail.user_id"));
			$this->set("coursereviews",$this->paginate("CourseReview",array(array("CourseReview.course_id"=>$courseid))));
		} else {
			$coursereview = $this->CourseReview->find("all",array("conditions"=>array("CourseReview.course_id"=>$courseid),"fields"=>array("CourseReview.rating","CourseReview.avgrating","CourseReview.Created","CourseReview.review_text ","Userdetail.first_name","Userdetail.last_name","Userdetail.image","Userdetail.user_id"),"limit"=>"3"));
			$coursereviewcount = $this->CourseReview->find("count",array("conditions"=>array("CourseReview.course_id"=>$courseid)));
			$this->set("coursereview",$coursereview);
			$this->set("coursereviewcount",$coursereviewcount);
		}
	}
/* end of function */


/*
 * @function name	: allcoursesbyuser
 * @purpose			: to get all courses by a user
 * @arguments		: Following are the arguments to be passed:
		* userid			: id of user of a course
		* listing			: boolean which will be used to define return type of data
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 28th july 2013
 * @description		: NA
*/
	function allcoursesbyuser($userid = NULL, $listing = true) {
		$this->loadModel("Course");
		$this->Course->unbindModel(array("hasMany"=>array("CourseSection","CourseLecture","CourseInstructor","CourseInvitee","CoursePassword","UserLearningCourse","UserWishlistCourse","UserViewCourse","CourseReview","CourseAudience","CourseGoal","CourseRequirement"),"belongsTo"=>array("User","Language","Category","InstructionLevel")));
		$this->Course->virtualFields = array(
			"students"=>"select count(*) as countstudent from user_learning_courses as UserLearningCourse where UserLearningCourse.course_id = Course.id",
			"avgrating"=>"select avg(rating) from course_reviews CourseReview where CourseReview.course_id = Course.id",
			"name"=>"select concat(Userdetail.first_name,' ',Userdetail.last_name) as name from userdetails as Userdetail where Userdetail.user_id = Course.user_id"
		);
		if ($listing) {
			$usercourses = $this->Course->find("all",array("conditions"=>array("Course.user_id"=>$userid,"Course.publishstatus"=>"Publish"),"fields"=>array("Course.id","Course.title","Course.subtitle","Course.coverimage","Course.summary","Course.students","Course.avgrating","Course.price", "Course.name", "Course.user_id"),"order"=>"Course.students desc","limit"=>"2"));
			$usercoursescount = $this->Course->find("count",array("conditions"=>array("Course.user_id"=>$userid,"Course.publishstatus"=>"Publish")));
			$this->set("usercourses",$usercourses);
			$this->set("usercoursescount",$usercoursescount);
		} else {
			$this->paginate = array("fields"=>array("Course.id","Course.summary","Course.title","Course.subtitle","Course.coverimage","Course.students","Course.avgrating","Course.price", "Course.name", "Course.user_id"),"order"=>"Course.created desc");
			$this->set("usercourses",$this->paginate("Course",array(array("Course.user_id"=>$userid,"Course.publishstatus"=>"Publish"))));
		}
	}
/* end of function */


/*
 * @function name	: userlearningcourses
 * @purpose			: to get all users currently learning a course
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of a course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 28th july 2013
 * @description		: NA
*/	
	function userlearningcourses($courseid = NULL) {
		$this->loadModel("UserLearningCourse");
		$this->UserLearningCourse->create();
		$this->UserLearningCourse->unbindModel(array("belongsTo"=>array("User","Course")));
		$this->UserLearningCourse->bindModel(array("hasOne"=>array("Userdetail"=>array("className"=>"Userdetail","foreignKey"=>false,"conditions"=>"UserLearningCourse.user_id = Userdetail.id"))));
		$userlearningcourse = $this->UserLearningCourse->find("all",array("conditions"=>array("UserLearningCourse.course_id"=>$courseid),"fields"=>array("Userdetail.user_id","Userdetail.first_name","Userdetail.last_name","Userdetail.image"),"limit"=>14));
		$userlearningcoursecount = $this->UserLearningCourse->find("count",array("conditions"=>array("UserLearningCourse.course_id"=>$courseid)));
		$this->set("userlearningcourse",$userlearningcourse);
		$this->set("userlearningcoursecount",$userlearningcoursecount);
	}
/* end of function */


/*
 * @function name	: unlinkDB
 * @purpose			: to remove the db files which were downloaded as backup
 * @arguments		: Following are the arguments to be passed:
		* ids			: ids of backup table records
 * @return			: none
 * @created by		: sandeep kaur
 * @created on		: 28th july 2013
 * @description		: NA
*/
	function unlinkDB($ids = null){
		foreach($ids as $id){
			$this->loadModel("Backupdb");
			$filename  = $this->Backupdb->find("first", array("fields"=>array("filename"), "conditions"=>array("id"=>$id)));
			$file = $filename['Backupdb']['filename'];
			if(file_exists(WWW_ROOT.'backupdb/'.$file)){
				unlink(WWW_ROOT.'/backupdb/'.$file);
			}
		}
		return true;
	}
/* end of function */


/*
 * @function name	: getstaticpage
 * @purpose			: to get content for static pages according to slugs
 * @arguments		: Following are the arguments to be passed:
		* slugs			: slug content in cmspages database
 * @return			: none
 * @created by		: sandeep kaur
 * @created on		: 28th july 2013
 * @description		: NA
*/
	public function getstaticpage($slug = null){
		$this->loadModel('Cmspages');
		$pages = $this->Cmspages->find('all', array('fields'=>array('Cmspages.name', 'Cmspages.seourl'), 'conditions'=>array('Cmspages.showinfooter'=>1,'Cmspages.status'=>1), 'order'=>'Cmspages.name'));
		$pageContent = $this->Cmspages->find('first', array('conditions'=>array('Cmspages.seourl'=>$slug)));
		$this->set("title_for_layout",$pageContent['Cmspages']['name']);
		$this->set(compact('pages','pageContent'));
	}
/* end of function */
	

/*
 * @function name	: getresult
 * @purpose			: to get result for the quiz a user has just appeared
 * @arguments		: Following are the arguments to be passed:
		* quizid		: id of quiz for which user has appeared
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 27th august 2013
 * @description		: NA
*/	
	public function getresult($quizid = NULL) {
		if ($this->Session->read("answerquiz.".$quizid)) {
			$i = 0;
			$marks = 0;
			foreach($this->Session->read("answerquiz.".$quizid) as $key=>$val) {
				$displayquestion = $this->getquestionss($key);
				$this->Session->write("answerquiz.".$quizid.".".$key.".displayquestion",$displayquestion);
				$i++;
				if(!empty($val['question'])) {
					$qst	= str_replace(" ","",strip_tags(strtolower($val['question'])));
					$answer = str_replace(" ","",strip_tags(strtolower($val['answer'])));
					if ($qst == $answer) {
						++$marks;
						$this->Session->write("answerquiz.".$quizid.".".$key.".answerflag",1);
					} else {
						$this->Session->write("answerquiz.".$quizid.".".$key.".answerflag",0);
					}
				} else {
					if(!empty($val['answer'])) {
						$answerarr[] = $val['answer'];
						$this->getquestionoption($val['answer'],$quizid,$key);
					}
				}
			}
			if(!empty($answerarr)) {
				$this->loadModel("CourseQuizQuestionOption");
				$answerlist = implode(",",$answerarr);
				$marks += $this->CourseQuizQuestionOption->find("count",array("conditions"=>array("CourseQuizQuestionOption.id in (".$answerlist.")","CourseQuizQuestionOption.answer"=>"1")));
			}
			$this->Session->write("result.".$quizid.".marks",$marks);
			$this->Session->write("result.".$quizid.".totalquestion",$i);
		}
	}
/* end of function */


/*
 * @function name	: getquestion
 * @purpose			: to get question description
 * @arguments		: Following are the arguments to be passed:
		* questionid	: id of a question default null
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 27th august 2013
 * @description		: NA
*/
	public function getquestionss($questionid = NULL) {
		$this->loadModel("CourseQuizQuestion");
		$this->CourseQuizQuestion->recursive = -1;
		$question = $this->CourseQuizQuestion->find("first",array("conditions"=>array("CourseQuizQuestion.id"=>$questionid)));
		return $question['CourseQuizQuestion']['question'];
	}
/* end of function */


/*
 * @function name	: getquestionoption
 * @purpose			: to get a particular option of question
 * @arguments		: Following are the arguments to be passed:
		* questionoptid	: id of a question default null
		* quizid		: id of a question default null
		* qstid			: id of a question default null
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 27th august 2013
 * @description		: it will get an option and will append to answer quiz with defining if question is correct and with question option description
*/
	public function getquestionoption($questionoptid = NULL,$quizid= NULL, $qstid = NULL) {
		$this->loadModel("CourseQuizQuestionOption");
		$this->CourseQuizQuestionOption->recursive = -1;
		$option = $this->CourseQuizQuestionOption->find("first",array("conditions"=>array("CourseQuizQuestionOption.id"=>$questionoptid),"fields"=>array("CourseQuizQuestionOption.options","CourseQuizQuestionOption.answer")));
		$this->Session->write("answerquiz.".$quizid.".".$qstid.".answerflag",$option['CourseQuizQuestionOption']['answer']);
		$this->Session->write("answerquiz.".$quizid.".".$qstid.".rawanswer",$option['CourseQuizQuestionOption']['options']);
	}
/* end of function */

    /*
     * @function name	: aasort
     * @purpose : to sort multidimensional array on the basis of passed argument key
     * @arguments		: Following are the arguments to be passed:
     * $array	: array refrence
     * $key		: key 
     * @return			: none
     * @created by		: Arjun Dhadwal
     * @created on		: 18th Oct 2013
     */

    public function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);
        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }
        asort($sorter);
        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }
        $array = $ret;
    }
    /* end of function */
	
	function coursecount($courseid = NULL) {
		$this->loadModel("CourseLecture");
		$count = $this->CourseLecture->find("count",array("conditions"=>array("CourseLecture.course_id"=>$courseid)));
		if ($count > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
	function abc() {
		error_reporting(1);
		echo $str = 'a:32:{s:19:"transaction_subject";s:0:"";s:12:"payment_date";s:25:"22:43:43 Feb 13, 2014 PST";s:8:"txn_type";s:10:"web_accept";s:9:"last_name";s:5:"sodhi";s:17:"residence_country";s:2:"US";s:9:"item_name";s:0:"";s:13:"payment_gross";s:5:"10.00";s:11:"mc_currency";s:3:"USD";s:8:"business";s:35:"1337institute-facilitator@gmail.com";s:12:"payment_type";s:7:"instant";s:22:"protection_eligibility";s:10:"Ineligible";s:11:"verify_sign";s:56:"A0BLbeMhaS0MRd4-2m9Ui20L6OPRApIjH7OVKOyf162dWYRRU0r1fg1O";s:12:"payer_status";s:8:"verified";s:8:"test_ipn";s:1:"1";s:3:"tax";s:4:"0.00";s:11:"payer_email";s:26:"varunjitsodhi@zapbuild.com";s:6:"txn_id";s:17:"722609392E117170D";s:8:"quantity";s:1:"0";s:14:"receiver_email";s:35:"1337institute-facilitator@gmail.com";s:10:"first_name";s:5:"varun";s:8:"payer_id";s:13:"SGGEDN2PYCYPU";s:11:"receiver_id";s:13:"8UQDL5B7U3U3L";s:11:"item_number";s:0:"";s:19:"payer_business_name";s:25:"varun sodhi\'s Test Store";s:14:"payment_status";s:9:"Completed";s:11:"payment_fee";s:4:"0.59";s:6:"mc_fee";s:4:"0.59";s:8:"mc_gross";s:5:"10.00";s:6:"custom";s:0:"";s:7:"charset";s:5:"UTF-8";s:14:"notify_version";s:3:"3.7";s:12:"ipn_track_id";s:13:"840b4cbb4467a";}';
		$arr = unserialize($str);
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
	}
	
}
?>
