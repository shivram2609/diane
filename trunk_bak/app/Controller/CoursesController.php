<?php
App::uses('AppController', 'Controller');
/**
 * Courses Controller
 *
 * @property Course $Course
 */
class CoursesController extends AppController {
	
	var $components = array("Paypal", "AdaptivePayment","PayChained","IpnHandler");
	var $typeofview = "";

/*
 * @function name	: beforefilter
 * @purpose			: used to check if user is logged in
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd June 2013
 * @description		: NA
*/
	function beforefilter() {
		parent::beforefilter();
		$this->checklogin();
		$this->Auth->allow("search","view","viewratings","viewrecent","viewallcourse","userrelatedcourses","ipnhandler","updatecoursecontent");
	}
/* end of function */


/*
 * @function name	: index
 * @purpose			: view all course added by logged in user or assigned as instructor for courses
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd June 2013
 * @description		: NA
*/
	public function index() {
		$this->layout = "frontend";
		$this->Course->recursive = -1;
		$this->loadModel("CourseInstructor");
		$courses = $this->CourseInstructor->find("list",array("conditions"=>array("CourseInstructor.user_id"=>$this->Session->read("Auth.User.id")),"fields"=>array("CourseInstructor.course_id")));
		$this->Course->virtualFields = array("name"=>"select concat(Userdetail.first_name,' ',Userdetail.last_name) as name from userdetails as Userdetail where Userdetail.user_id = Course.user_id");
		if( empty($courses) ) {
			$this->conditions = array("Course.user_id"=>$this->Session->read("Auth.User.id"));
		} else { 
			$this->conditions = array("OR"=>array("Course.user_id"=>$this->Session->read("Auth.User.id"),"Course.id in(".implode(",",$courses).")"));
		}
		$this->set('courses', $this->paginate($this->conditions));
	}
/* end of function */


/*
 * @function name	: view
 * @purpose			: view detail of a course in full
 * @arguments		: Following are the arguments to be passed:
			* id		: id of course
			* desc		: title of course which will be shown in url too. 
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd August 2013
 * @description		: NA
*/
	public function view($id = NULL, $desc = NULL) {
		$this->layout = "frontend";
		if($this->RequestHandler->isAjax()) {
			$this->loadModel("CourseReview");
			$this->CourseReview->recursive = -1;
			$coursereview = $this->CourseReview->find("first",array("conditions"=>array("CourseReview.user_id"=>$this->Session->read("Auth.User.id"),"CourseReview.course_id"=>$id)));
			if (!empty($coursereview)) {
				$this->CourseReview->id = $coursereview['CourseReview']['id'];
			}
			
			if(empty($this->request->data['CourseReview']['rating']) || empty($this->request->data['CourseReview']['review_text'])) {
				echo 1;
			} else {
				$userreview = $this->request->data;
				$userreview['CourseReview']['user_id'] = $this->Session->read("Auth.User.id");
				$userreview['CourseReview']['course_id'] = $id;
				$this->CourseReview->save($userreview);
				$this->Session->setFlash("Your ratings have been submitted.", 'default', array("class"=>"success_message"));
				echo SITE_LINK."c/".$id."/".$desc;
			}
			exit;
		} elseif (isset($this->data) && !empty($this->data)) {
			if (!empty($this->data['Course']['password'])) {
				$this->loadModel("CoursePassword");
				$this->CoursePassword->recursive = -1;
				$coursepass = $this->CoursePassword->find("first",array("conditions"=>array("CoursePassword.course_id"=>$id,"CoursePassword.password"=>$this->data['Course']['password'])));
				
				if(!empty($coursepass)) {
					$this->Session->write("CoursePassword.".$this->Session->read("Auth.User.id").".".$coursepass['CoursePassword']['course_id'],"1");
				} else {
					$this->Session->setFlash("Invalid password.");
				}
			}
		} //else {
			$this->captureviewcourse($id);
			$this->getmoreviewedcourses($id);
			$this->getcoursereviews($id);
			
			/* code to get course data like sections and lectures */
			$this->loadModel("CourseSection");
			$this->CourseSection->unbindModel(array("belongsTo"=>array("Course")));
			$courses = $this->CourseSection->find("all",array("conditions"=>array("CourseSection.course_id"=>$id)));
			$this->set("courses",$courses);
			/* code to get course data like sections and lectures end here */
			
			/* code to get course details */
			$this->Course->unbindModel(array("hasMany"=>array("CourseSection","CourseLecture","CourseInstructor","CourseInvitee","CoursePassword","UserLearningCourse","UserViewCourse","UserWishlistCourse","CourseReview"),"belongsTo"=>array("User","Language")));
			$completedlist = array();
			$completedcount = 0;
			if($this->Session->read("Auth.User.id")) {
				$this->Course->virtualFields = array("wishlist"=>"select count(*) from user_wishlist_courses UserWishlistCourse where UserWishlistCourse.course_id = Course.id and UserWishlistCourse.user_id = ".$this->Session->read("Auth.User.id"),
				"learning"=>"select learning.completed from user_learning_courses learning where learning.course_id = Course.id and learning.user_id = ".$this->Session->read("Auth.User.id"),
				"learningcount"=>"select count(*) from user_learning_courses learning where learning.course_id = Course.id and learning.user_id = ".$this->Session->read("Auth.User.id"));
				$this->loadModel("UserCompleteCourseLecture");
				$completedlist = $this->UserCompleteCourseLecture->find("list",array("conditions"=>array("UserCompleteCourseLecture.course_id"=>$id,"UserCompleteCourseLecture.user_id"=>$this->Session->read("Auth.User.id")),"fields"=>array("UserCompleteCourseLecture.lecture_id")));
			}
			$coursedetail = $this->Course->find("first",array("conditions"=>array("Course.id"=>$id,"Course.status"=>1)));
			/* code to get course details end here */
			if (!empty($coursedetail)) {
				if($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") == $coursedetail['Course']['user_id']) {
				
				} elseif($coursedetail['Course']['publishstatus'] == 'Unpublish') {
					$this->Session->setFlash("Course not found.");
					$this->redirect("/view-courses");
				}
				$mycourse = false;
				/* code to get user details */
				$this->loadModel("User");
				$this->User->recursive = 0;
				$user = $this->User->find("first",array("conditions"=>array("User.id"=>$coursedetail['Course']['user_id']),"fields"=>"Userdetail.*"));
				/* code to get user details end here*/
				
				/* code to get last review users */
				/* code to get last review users end here */
				$this->allcoursesbyuser($coursedetail['Course']['user_id']);
				$this->userlearningcourses($id);
				if ($this->takecourse($id,true) || ($this->Session->read("Auth.User.id") && $coursedetail['Course']['user_id'] == $this->Session->read("Auth.User.id")) ) {
					$this->set("mycourse",1);
					$mycourse = true;
				}
				if(($this->Session->read("Auth.User.id") && $coursedetail['Course']['user_id'] == $this->Session->read("Auth.User.id"))) {
					$this->set("instructor",1);
					$this->loadModel("CourseUserQuestion");
					if (($this->Session->read("typeofview") && $this->Session->read("typeofview") == 'i') || !$this->Session->read("typeofview")) {
						$this->CourseUserQuestion->virtualFields = array("firstname"=>"select Userdetail.first_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
						"lastname"=>"select Userdetail.last_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
						"lectureindex"=>"select lecture_index from course_lectures where course_lectures.id = CourseUserQuestion.course_lecture_id"
						); 
						$coursequestions = $this->CourseUserQuestion->find("all",array("conditions"=>array("CourseUserQuestion.course_id"=>$id),"order"=>"CourseUserQuestion.created desc"));
						$this->set("data",$coursequestions);
						$this->set("questionforme","1");
					} else {
						$this->CourseUserQuestion->virtualFields = array("firstname"=>"select Userdetail.first_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
						"lastname"=>"select Userdetail.last_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
						"lectureindex"=>"select lecture_index from course_lectures where course_lectures.id = CourseUserQuestion.course_lecture_id"
						); 
						$coursequestions = $this->CourseUserQuestion->find("all",array("conditions"=>array("CourseUserQuestion.course_id"=>$id,"CourseUserQuestion.user_id"=>$this->Session->read("Auth.User.id")),"order"=>"CourseUserQuestion.created desc"));
						$this->set("data",$coursequestions);
						$this->set("questionforme","2");
					}
				} else {
					$this->loadModel("CourseUserQuestion");
					$this->CourseUserQuestion->virtualFields = array("firstname"=>"select Userdetail.first_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
						"lastname"=>"select Userdetail.last_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
						"lectureindex"=>"select lecture_index from course_lectures where course_lectures.id = CourseUserQuestion.course_lecture_id"
						); 
						$coursequestions = $this->CourseUserQuestion->find("all",array("conditions"=>array("CourseUserQuestion.course_id"=>$id,"CourseUserQuestion.user_id"=>$this->Session->read("Auth.User.id")),"order"=>"CourseUserQuestion.created desc"));
						$this->set("data",$coursequestions);
						$this->set("questionforme","2");
				}
				
				$this->set("user",$user);
				$this->set("title_for_layout",$coursedetail['Course']['title']." by ".$user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']);
				$this->set("coursedetail",$coursedetail);
				$this->set("completedlist",$completedlist);
				$this->set("username",$user['Userdetail']['first_name'].' '.$user['Userdetail']['last_name']);
			} else {
				$this->Session->setFlash("Course not found.");
				$this->redirect("/view-courses");
			}
			if($this->Session->read("typeofview")) {
				$this->set("typeofview",$this->Session->read("typeofview"));
			} else {
				$this->set("typeofview","n");
			}
			
			if ($this->Session->read("Auth.User.id")) {
				$this->loadModel("CourseReview");
				$this->CourseReview->recursive = -1;
				$coursereviews = $this->CourseReview->find("first",array("conditions"=>array("CourseReview.user_id"=>$this->Session->read("Auth.User.id"),"CourseReview.course_id"=>$id)));
			}
			
			if (isset($coursereviews) && !empty($coursereviews)) {
				$this->set(compact('coursereviews'));
			}
			
			if ($coursedetail['Course']['user_id'] == $this->Session->read("Auth.User.id") && $this->Session->read("typeofview") && $this->Session->read("typeofview") == 'g') {
				$this->render("view");
			} elseif ($coursedetail['Course']['user_id'] == $this->Session->read("Auth.User.id") && $this->Session->read("typeofview") && $this->Session->read("typeofview") == 'i') {
				
				$this->render("viewcourseadmin");
			} elseif($mycourse) {
				$this->render("viewcourseadmin");
			} else {
				$this->render("view");
			}
			if($this->Session->read("typeofview")) {
				$this->set("typeofview",$this->Session->read("typeofview"));
				$this->Session->delete("typeofview");
			} else {
				$this->set("typeofview","n");
			}
		//}
	}
/* end of function */


	function redirecttoview($type= NULL, $id = NULL, $desc = NULL) {
		$this->Session->delete("typeofview");
		$this->Session->write("typeofview",$type);
		$this->redirect("/c/".$id."/".$desc);
	}

/*
 * @function name	: viewlecture
 * @purpose			: view detail of a course in full
 * @arguments		: Following are the arguments to be passed:
			* id		: id of lecture
			* desc		: title of lecture which will be shown in url too. 
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd August 2013
 * @description		: NA
*/
	function viewlecture($id = NULL, $desc = NULL) {
		//Configure::write('debug',2);
		$this->layout = "frontend";
		$this->loadModel("CourseLecture");
		/* code to add course notes, questions from view lecture page */
		if ($this->RequestHandler->isAjax()) {
			if(isset($this->request->data["Course"]["notes"]) && !empty($this->request->data["Course"]["notes"])) {
				$this->loadModel("CourseUserNote");
				$data['CourseUserNote'] = $this->request->data["Course"];
				$data['CourseUserNote']['user_id'] = $this->Session->read("Auth.User.id");
				$this->CourseUserNote->save($data);
				echo "1";
			} elseif(isset($this->request->data["Course"]["question"]) && !empty($this->request->data["Course"]["question"])) {
				$course = $this->Course->find("first",array("conditions"=>array("Course.id"=>$this->request->data["Course"]["course_id"]),"fields"=>array("Course.user_id","Course.id","Course.title")));
				$notification = $this->checknotification($course['Course']['user_id']);
				if ( !empty($notification) && isset($notification[0])) {
					/* code to send email for following a profile */
					$followerlink	= "<a href=".SITE_LINK."profile/".$this->Session->read("Auth.User.id")."/".$this->makeurl($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name")).">".ucwords($this->Session->read("Auth.User.Userdetail.first_name").' '.$this->Session->read("Auth.User.Userdetail.last_name"))."</a>";
					$courselink	= "<a href=".SITE_LINK."c/".$course['Course']['id']."/".$this->makeurl($course['Course']['title']).">".$course['Course']['title']."</a>";
					$this->getmaildata(15);
					$recemail = $this->useremail($course['Course']['user_id']);
					$recname = $this->username($course['Course']['user_id']);
					$this->mailBody = str_replace("{USER}",ucwords($recname),$this->mailBody);
					$this->mailBody = str_replace("{ASKEDBY}",$followerlink,$this->mailBody);
					$this->mailBody = str_replace("{COURSE}",$courselink,$this->mailBody);
					$this->mailBody = str_replace("{QUESTION}",strip_tags(nl2br($this->request->data["Course"]["question"]),"<p>,<br/>,<span>"),$this->mailBody);
					$this->sendmail($recemail);
					/* code to send email confirmation for signup */
				}
				$this->loadModel("CourseUserQuestion");
				$data['CourseUserQuestion'] = $this->request->data["Course"];
				$data['CourseUserQuestion']['user_id'] = $this->Session->read("Auth.User.id");
				$this->CourseUserQuestion->save($data);
				echo "2";
			} else {
				echo "3";
			}
			exit;
		}
		/* code to add course notes, questions from view lecture page end here */
		$this->CourseLecture->recursive = 1;
		$this->CourseLecture->bindModel(array("hasMany"=>array("CourseSuppliment"=>array("className"=>"CourseSuppliment","foreignKey"=>"course_lecture_id"))));
		$this->CourseLecture->virtualFields = array("prev"=>"select CourseLectures.id from course_lectures CourseLectures where CourseLectures.id < ".$id." and CourseLectures.course_id = CourseLecture.course_id order by CourseLectures.id desc limit 1"
		,"next"=>"select CourseLecturess.id from course_lectures CourseLecturess where CourseLecturess.id > ".$id." and CourseLecturess.course_id = CourseLecture.course_id limit 1",
		"markcomplete"=>"select count(*) from user_complete_course_lectures uccl where uccl.lecture_id =".$id." and uccl.user_id = ".$this->Session->read("Auth.User.id")
		);
		$lecture = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.id"=>$id)));
		$this->loadModel("UserLearningCourse");
		$userlearning = $this->UserLearningCourse->find("count",array("conditions"=>array("UserLearningCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserLearningCourse.course_id"=>$lecture['Course']['id'])));
		$this->set("title_for_layout",ucwords($lecture['CourseLecture']['heading']));
		
		if($this->Session->read("Auth.User.id") != $lecture['Course']['user_id'] && empty($userlearning)) {
			$this->Session->setFlash("You are not authorized to view this course.");
			$this->redirect("/view-courses");
		}
		if(empty($lecture)) {
			$this->Session->setFlash("Invalid lecture.");
			$this->redirect("/view-courses");
		}
		if($lecture['CourseLecture']['content_type'] == 'M') {
			$this->loadModel("CourseMashup");
			$coursemashup = $this->CourseMashup->find("first",array("conditions"=>array("CourseMashup.course_lecture_id"=>$lecture['CourseLecture']['id'])));
			$this->set("mashdata",$coursemashup);
		}
		
		$this->set("sections",$lecture);
		/* code to get course data like sections and lectures */
		$this->loadModel("CourseSection");
		$this->CourseSection->unbindModel(array("belongsTo"=>array("Course")));
		$courses = $this->CourseSection->find("all",array("conditions"=>array("CourseSection.course_id"=>$lecture['Course']['id'])));
		$this->set("courses",$courses);
		/* code to get course data like sections and lectures end here */
		
		$this->loadModel("CourseUserQuestion");
		$this->CourseUserQuestion->virtualFields = array("firstname"=>"select Userdetail.first_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
		"lastname"=>"select Userdetail.last_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
		"lectureindex"=>"select lecture_index from course_lectures where course_lectures.id = CourseUserQuestion.course_lecture_id",
		"course"=>"select title from courses where courses.id = ".$lecture['Course']['id']
		); 
		
		if($this->Session->read("Auth.User.id") && $this->Session->read("Auth.User.id") == $lecture['Course']['user_id']) { 
			$coursequestions = $this->CourseUserQuestion->find("all",array("conditions"=>array("CourseUserQuestion.course_id"=>$lecture['Course']['id']),"order"=>"CourseUserQuestion.created desc"));
		} else {
			$this->set("asked",1);
			$coursequestions = $this->CourseUserQuestion->find("all",array("conditions"=>array("CourseUserQuestion.user_id"=>$this->Session->read("Auth.User.id"),"CourseUserQuestion.course_id"=>$lecture['Course']['id']),"order"=>"CourseUserQuestion.created desc"));
		}
		//$coursequestions = $this->CourseUserQuestion->find("all",array("conditions"=>array("CourseUserQuestion.course_id"=>$this->request->data['Course']['course_id']),"order"=>"CourseUserQuestion.created desc"));
		$this->set(compact('coursequestions'));
		
	}
/* end of function */	


/*
 * @function name	: addwishlist
 * @purpose			: adding a course to wishlist
 * @arguments		: Following are the arguments to be passed:
			* courseid	: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd August 2013
 * @description		: NA
*/
	function addwishlist($courseid = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("UserWishlistCourse");
			$this->UserWishlistCourse->recursive = -1;
			$wishlist = $this->UserWishlistCourse->find("first",array("conditions"=>array("UserWishlistCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserWishlistCourse.course_id"=>$this->request->data['courseid']),"fields"=>array("UserWishlistCourse.id")));
			if (empty($wishlist)) {
				$wishdata['UserWishlistCourse']['user_id'] 		= $this->Session->read("Auth.User.id");
				$wishdata['UserWishlistCourse']['course_id']	= $this->request->data['courseid'];
				$this->UserWishlistCourse->save($wishdata);
				echo "1";
			} else {
				$this->UserWishlistCourse->create();
				$this->UserWishlistCourse->id = $wishlist['UserWishlistCourse']['id'];
				$this->UserWishlistCourse->delete();
				echo "2";
			}
		}
		$this->render(false);
	}
/* end of function */


/*
 * @function name	: markcomplete
 * @purpose			: marking a course as completed
 * @arguments		: Following are the arguments to be passed:
		* courseid		: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd August 2013
 * @description		: NA
*/	
	function markcomplete($courseid = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("UserLearningCourse");
			$this->UserLearningCourse->recursive = -1;
			$wishlist = $this->UserLearningCourse->find("first",array("conditions"=>array("UserLearningCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserLearningCourse.course_id"=>$this->request->data['courseid']),"fields"=>array("UserLearningCourse.id","UserLearningCourse.completed")));
			if (!empty($wishlist)) {
				$this->UserLearningCourse->id = $wishlist['UserLearningCourse']['id'];
				if($wishlist['UserLearningCourse']['completed'] == 0) {
					$wishdata['UserLearningCourse']['completed'] 	= 1;
					$res = 1;
				} else {
					$wishdata['UserLearningCourse']['completed'] 	= 0;
					$res = 0;
				}
				$this->UserLearningCourse->save($wishdata);
				echo $res;
			} 
		}
		$this->render(false);
	}
/* end of function */


/*
 * @function name	: marklecturecomplete
 * @purpose			: marking a lecture as completed
 * @arguments		: Following are the arguments to be passed:
		* courseid		: id of course
		* lectureid		: id of lecture
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd August 2013
 * @description		: NA
*/	
	function marklecturecomplete($courseid = NULL,$lectureid = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("UserCompleteCourseLecture");
			$this->loadModel("CourseLecture");
			$this->UserCompleteCourseLecture->recursive = -1;
			$userlecture = $this->UserCompleteCourseLecture->find("first",array("conditions"=>array("UserCompleteCourseLecture.user_id"=>$this->Session->read("Auth.User.id"),"UserCompleteCourseLecture.course_id"=>$this->request->data['courseid'],"UserCompleteCourseLecture.lecture_id"=>$this->request->data['lectureid']),"fields"=>array("UserCompleteCourseLecture.id")));
			if (!empty($userlecture)) {
				$this->UserCompleteCourseLecture->id = $userlecture['UserCompleteCourseLecture']['id'];
				$this->UserCompleteCourseLecture->delete();
				$result = 1;
			} else {
				$this->UserCompleteCourseLecture->create();
				$userlecdata['UserCompleteCourseLecture']['user_id'] = $this->Session->read("Auth.User.id");
				$userlecdata['UserCompleteCourseLecture']['course_id'] = $this->request->data['courseid'];
				$userlecdata['UserCompleteCourseLecture']['lecture_id'] = $this->request->data['lectureid'];
				$this->UserCompleteCourseLecture->save($userlecdata);
				$result = 2;
			} 
			$courselectures = $this->CourseLecture->find("count",array("conditions"=>array("Course.id"=>$this->request->data['courseid'])));
			$userlecture = $this->UserCompleteCourseLecture->find("count",array("conditions"=>array("UserCompleteCourseLecture.user_id"=>$this->Session->read("Auth.User.id"),"UserCompleteCourseLecture.course_id"=>$this->request->data['courseid'])));
			$this->loadModel("UserLearningCourse");
			$this->UserLearningCourse->recursive = -1;
			$wishlist = $this->UserLearningCourse->find("first",array("conditions"=>array("UserLearningCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserLearningCourse.course_id"=>$this->request->data['courseid']),"fields"=>array("UserLearningCourse.id","UserLearningCourse.completed")));
			if (!empty($wishlist)) {
				$this->UserLearningCourse->create();
				$this->UserLearningCourse->id = $wishlist['UserLearningCourse']['id'];
				if($courselectures == $userlecture) {
					$wishdata['UserLearningCourse']['completed'] 	= 1;
					$res = 1;
				} else {
					$wishdata['UserLearningCourse']['completed'] 	= 0;
					$res = 0;
				}
				$this->UserLearningCourse->save($wishdata);
				//echo $res;
			}
		}
		echo $result;
		$this->render(false);
	}
/* end of function */


/*
 * @function name	: add
 * @purpose			: adding a new course
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd july 2013
 * @description		: NA
*/
	public function add() {
		$this->layout = "frontend";
		if ($this->request->is('post')) {
			$this->Course->create();
			$data = $this->request->data;
			$data['Course']['user_id'] = $this->Session->read("Auth.User.id");
			if ($this->Course->save($data)) {
				$this->loadModel("CourseInstructor");
				$courseinstructor['CourseInstructor']['course_id']		= $this->Course->getLastInsertId();
				$courseinstructor['CourseInstructor']['user_id']		= $this->Session->read("Auth.User.id");
				$courseinstructor['CourseInstructor']['editpermission'] = 1;
				$this->CourseInstructor->save($courseinstructor);
				//$this->Session->setFlash(__('The course has been saved'));
				  
				$this->loadModel("CourseSection");
				$coursesection['CourseSection']['course_id']	= $courseinstructor['CourseInstructor']['course_id'];
				$coursesection['CourseSection']['heading'] 		= "A New Module";
				$coursesection['CourseSection']['section_index'] = 1;
				$this->CourseSection->save($coursesection);
				
				/*$this->loadModel("CourseLecture");
				$courselecture['CourseLecture']['course_id']	= $courseinstructor['CourseInstructor']['course_id'];
				$courselecture['CourseLecture']['course_section_id']	= $this->CourseSection->getLastInsertId();
				$courselecture['CourseLecture']['heading']		= "My First Lecture";
				$courselecture['CourseLecture']['lecture_index']= 1;
				$this->CourseLecture->save($courselecture);*/
				$this->redirect('/course-manage/guidelines/'.$this->Course->getLastInsertId());
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please, try again.'));
			}
		}
	}
/* end of function */


/*
 * @function name	: basic
 * @purpose			: view.edit and update of basic details of a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd july 2013
 * @description		: NA
*/	
	function basic($id = NULL) {
		$this->layout = "frontend";
		if (isset($this->data) && !empty($this->data)) {
			$this->Course->create();
			$this->Course->id = $id;
			$data = $this->data;
			if (!empty($data['Course']['lincence_logo']['name'])) { 
				$data['Course']['lincence_logo'] = ($this->uploadimage($this->data['Course']['lincence_logo'], NULL,NULL,$this->Session->read("Auth.User.id")."/Course/".$id."/coverimage",NULL,"lincenceimg","lincenceimage",80, 20))?($this->uploaddir.$this->imagename):'';
			} else {
				unset($data['Course']['lincence_logo']);
			}
			if(!empty($data['Course']['category_id'])) {
				//$data['Course']['category_id'] = implode(",",$data['Course']['category_id']);
				$data['Course']['category_id'] = $data['Course']['category_id'];
			} else {
				$data['Course']['category_id'] = -1;
			}
			if ($this->Course->save($data)) {
				$this->Session->setFlash("Basic detail has been updated.", 'default', array("class"=>"success_message"));
				$this->redirect('/course-manage/basic/'.$id);
			}
		}
		$this->validatecourse($id,-1);
		$this->loadModel("Category");
		$categories = $this->Category->find('list', array("conditions"=>"Category.status=1","order"=>"Category.sort,Category.title"));
		$languages = $this->Course->Language->find('list', array("conditions"=>"Language.status=1","order"=>"Language.title"));
		// for Coursesleft element
		
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id","designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.user_id","Course.title","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.id"=>$id)));
		$this->set("title_for_layout","Introduction - ".$userdetails['Course']['title']);
		$this->set(compact('categories', 'languages','userdetails'));
	}
/* end of function */


/*
 * @function name	: details
 * @purpose			: view,edit and update of details of a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd july 2013
 * @description		: NA
*/	
	function details($id = NULL) {
		$this->layout = "frontend";
		if (isset($this->data) && !empty($this->data)) {
			if(!empty($this->data['CourseGoal']['title'])) {
				$this->loadModel("CourseGoal");
				$this->CourseGoal->recursive = -1;
				$coursegoals = $this->CourseGoal->find("first",array("conditions"=>array("CourseGoal.course_id"=>$id)));
				if (empty($coursegoals)) {
					$coursegoal['CourseGoal']['course_id'] = $id;
				} else {
					$this->CourseGoal->id = $coursegoals['CourseGoal']['id'];
				}
				$coursegoal['CourseGoal']['title'] = serialize($this->data['CourseGoal']['title']);
				$this->CourseGoal->save($coursegoal);
			}
			if(!empty($this->data['CourseAudience']['title'])) {
				$this->loadModel("CourseAudience");
				$this->CourseAudience->recursive = -1;
				$courseaudiences = $this->CourseAudience->find("first",array("conditions"=>array("CourseAudience.course_id"=>$id)));
				if (empty($coursegoals)) {
					$courseaudience['CourseAudience']['course_id'] = $id;
				} else {
					$this->CourseAudience->id = $courseaudiences['CourseAudience']['id'];
				}
				$courseaudience['CourseAudience']['title'] = serialize($this->data['CourseAudience']['title']);
				$this->CourseAudience->save($courseaudience);
			}
			if(!empty($this->data['CourseRequirement']['title'])) {
				$this->loadModel("CourseRequirement");
				$this->CourseRequirement->recursive = -1;
				$courserequirements = $this->CourseRequirement->find("first",array("conditions"=>array("CourseRequirement.course_id"=>$id)));
				if (empty($courserequirements)) {
					$courserequirement['CourseRequirement']['course_id'] = $id;
				} else {
					$this->CourseRequirement->id = $courserequirements['CourseRequirement']['id'];
				}
				$courserequirement['CourseRequirement']['title'] = serialize($this->data['CourseRequirement']['title']);
				$this->CourseRequirement->save($courserequirement);
			}
			$this->Course->create();
			$this->Course->id = $id;
			if ($this->Course->save($this->data)) {
				$this->Session->setFlash("Details have been updated.", 'default', array("class"=>"success_message"));
				$this->redirect('/course-manage/details/'.$id);
			}
		}
		$this->validatecourse($id,-1);
		$this->getcoursedetails($id);
		$this->loadModel("InstructionLevel");
		$instlevel = $this->InstructionLevel->find("list",array("fields"=>array("InstructionLevel.id","InstructionLevel.title")));
		// for Coursesleft element
		
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id", "designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.title","Course.user_id","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.id"=>$id)));
		$this->set("title_for_layout","Course Summary - ".$userdetails['Course']['title']);
		$this->set(compact('userdetails','instlevel'));
	}
/* end of function */


/*
 * @function name	: coverimage
 * @purpose			: view,edit and update of coverimage of a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd july 2013
 * @description		: NA
*/	
	function coverimage($id) {
		$this->layout = "frontend";
		if (isset($this->data) && !empty($this->data['Course']['coverimage']['name'])) {
			$coursedata['Course']['coverimage'] = $this->data['Course']['coverimage'];
			$this->Course->set($coursedata);
			if ($this->Course->validates()) {
				$course['Course']['coverimage'] = ($this->uploadimage($this->data['Course']['coverimage'], NULL,NULL,$this->Session->read("Auth.User.id")."/Course/".$id."/coverimage",NULL,"coverimg","coverimage",213, 213))?($this->uploaddir.$this->imagename):'';
				if(!empty($course['Course']['coverimage'])) {
					$this->Course->create();
					$this->Course->id = $id;
					if ($this->Course->save($course, array('validate' => false))) {
						$this->Session->setFlash(__('Image has been uploaded.'), 'default', array("class"=>"success_message"));
						$this->redirect('/course-manage/cover-image/'.$id);
					}
				}
			}
		}
		$this->validatecourse($id,-1);
		// for Coursesleft element
		
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id","designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.title","Course.user_id","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.id"=>$id)));
		$this->set("title_for_layout","Cover Image - ".$userdetails['Course']['title']);
		$this->set(compact('userdetails','instlevel'));
	}
/* end of function */


/*
 * @function name	: promovideo
 * @purpose			: view,edit and update of promovideo of a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd july 2013
 * @description		: NA
*/	
	function promovideo($id) {
		$this->layout = "frontend";
		if (isset($this->data)) {
			
			if(!empty($this->data['Course']['promovideo']['name'])) {
				$coursedata['Course']['promovideo'] = $this->data['Course']['promovideo'];
				$this->Course->set($coursedata);
				if ($this->Course->validates()) {
					
					$course['Course']['promovideo'] = ($this->uploadvideos($this->data['Course']['promovideo'],NULL,$this->Session->read("Auth.User.id")."/Course/".$id."/coverimage",$this->data['Course']['promovideo']['name']))?($this->uploaddir.$this->imagename):'';
					if(!empty($course['Course']['promovideo'])) {
						$this->Course->create();
						$this->Course->id = $id;
						
						if ($this->Course->save($course, array('validate' => false))) {
							$this->Session->setFlash(__('Promo video has been uploaded.'), 'default', array("class"=>"success_message"));
							$this->redirect('/course-manage/promo-video/'.$id);
						}
					}
				}
			} elseif(!empty($this->data['Course']['promovideo1'])) {
				$coursedata['Course']['promovideo'] = $this->data['Course']['promovideo1'];
					if(!empty($coursedata['Course']['promovideo'])) {
						$this->Course->create();
						$this->Course->id = $id;
						
						if ($this->Course->save($coursedata, array('validate' => false))) {
							$this->Session->setFlash(__('Promo video has been uploaded.'), 'default', array("class"=>"success_message"));
							$this->redirect('/course-manage/promo-video/'.$id);
						}
					}
				
			}
		}
		$this->validatecourse($id,-1);
		// for Coursesleft element
		
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id","designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.title","Course.user_id","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.id"=>$id)));
		$this->set("title_for_layout","Promo Video - ".$userdetails['Course']['title']);
		$this->set(compact('userdetails'));
	}
/* end of function */


/*
 * @function name	: privacy
 * @purpose			: view,edit and update of privacy setting of a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd july 2013
 * @description		: NA
*/
	function privacy($id) {
		$this->layout = "frontend";
		$this->loadModel("CoursePassword");
		if (isset($this->data) && !empty($this->data)) {
			$coursendata = $this->data;
			$coursendata['Course']['visibility'] = ($coursendata['Course']['privacy_type'] == 3) ? 'Public':'Private';
			$this->Course->id = $id;
			$this->Course->save($coursendata);
			$this->CoursePassword->recursive = -1;
			$coursepassword = $this->CoursePassword->find("first",array("course_id"=>$id));
			$coursepwddetail = $this->data;
			if(isset($this->data['CoursePassword']['password']) && !empty($this->data['CoursePassword']['password'])) {
				$coursepwddetail['CoursePassword']['password'] = $this->data['CoursePassword']['password'];
			} else {
				$coursepwddetail['CoursePassword']['password'] = '';
			}
			
			if (!empty($coursepassword)) {
				$this->CoursePassword->id = $coursepassword['CoursePassword']['id'];
			}
			$coursepwddetail['CoursePassword']['course_id'] = $id;
			//$coursepwddetail['CoursePassword']['password'] = $this->encryptpass($this->data['CoursePassword']['password']);
			$this->CoursePassword->save($coursepwddetail);
			$this->Session->setFlash(__('Privacy settings has been updated.'), 'default', array("class"=>"success_message"));
			$this->redirect('/course-manage/privacy/'.$id);
		}
		$coursepassword = $this->CoursePassword->find("first",array("course_id"=>$id));
		if (!empty($coursepassword)) {
			$this->set("password",$coursepassword['CoursePassword']['password']);
		} else {
			$this->set("password",'');
		}
		$this->validatecourse($id,-1,NULL,false);
		// for Coursesleft element
		
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id","designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.user_id","Course.title","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.id"=>$id)));
		$this->set("title_for_layout","Privacy - ".$userdetails['Course']['title']);
		$this->set(compact('userdetails'));
	}
/* end of function */


/*
 * @function name	: instructors
 * @purpose			: view,add,edit and update of instructors for a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 3rd july 2013
 * @description		: NA
*/	
	function instructors($id) {
		$this->layout = "frontend";
		$this->loadModel('CourseInstructor');
		$this->CourseInstructor->virtualFields = array(
			'username' => 'select Concat(Userdetail.first_name) as username from userdetails as Userdetail INNER JOIN course_instructors as CourseInstructors ON Userdetail.user_id = CourseInstructors.user_id where CourseInstructors.user_id = CourseInstructor.user_id limit 1'
		);
		if (isset($this->data) && !empty($this->data)) {
			$errflag = true;
			$instcommission = 0;
			foreach($this->data['commission'] as $key=>$val) {
				if($val<=0) {
					$errflag = false;
				}
				if(isset($this->data['visible']) && array_key_exists($key,$this->data['visible'])) {
					$instcommission += $val;
				}
			}
			
			
			if (!$errflag) {
				$this->Session->setFlash(__('Revenue can not be 0 or less than 0 for any instructor.'));
				$this->redirect("/course-manage/instructors/".$id);
			}
			$admincommission = $this->getusercommission($id);
			$totalcommission = (array_sum($this->data['commission']))+SITE_COMMISSION;
			$instcommission += SITE_COMMISSION;
			
			if(isset($this->data['editpermission'])) {
				$this->CourseInstructor->create();
				$courseinst = array();
				foreach($this->data['editpermission'] as $key=>$val) {
					$courseinst['CourseInstructor'][$key] = array("id"=>$key,"visible"=>isset($this->data['visible'][$key])?$this->data['visible'][$key]:'',"editpermission"=>$this->data['editpermission'][$key],"commission"=>$this->data['commission'][$key]);
				}
				$this->CourseInstructor->saveAll($courseinst['CourseInstructor']);
			}
			
			if ( $totalcommission == 100) {
				if(!empty($this->data['CourseInstructor']['user_id'])) {
					if($instcommission+INSTRUCTOR_COMMISSION > 100) {
						$this->Session->setFlash(__('Total revenue can not be greater than 100%.'));
					} else {
						$this->CourseInstructor->create();
						$courseinstructorval = $this->CourseInstructor->find("first",array("conditions"=>array("CourseInstructor.course_id"=>$id,"CourseInstructor.user_id"=>$this->data['CourseInstructor']['user_id'])));
						if(empty($courseinstructorval)) {
							$courseinstructor = $this->data;
							$courseinstructor['CourseInstructor']['course_id'] = $id;
							$courseinstructor['CourseInstructor']['commission'] = INSTRUCTOR_COMMISSION;
							$this->CourseInstructor->save($courseinstructor);
							$this->Session->setFlash(__('Course instructors has been modified.'), 'default', array("class"=>"success_message"));
						} else {
							$this->Session->setFlash(__('This user is already an instructor for this course.'));
						}
					}
				} elseif(empty($this->data['CourseInstructor']['user_id']) && !empty($this->data['Course']['instructors'])) {
					$this->Session->setFlash(__('Course instructors must be a user of 1337 Institute Of Technology.'));
				}
				
			} else {
				$this->Session->setFlash(__('Total revenue must be 100%.'));
			}
			$this->redirect("/course-manage/instructors/".$id);
		}
		$this->CourseInstructor->recursive = 0;
		$this->CourseInstructor->bindModel(array("belongsTo"=>array("Userdetail"=>array("className"=>"Userdetail","foreignKey"=>false,"conditions"=>"CourseInstructor.user_id = Userdetail.user_id","fields"=>array("Userdetail.first_name","Userdetail.last_name","Userdetail.paypalaccount")))));
		$this->CourseInstructor->unBindModel(array("belongsTo"=>array("Course","User")));
		$courseinstructors = $this->CourseInstructor->find("all",array("conditions"=>array("CourseInstructor.course_id"=>$id,"CourseInstructor.user_id <>"=>$this->Session->read("Auth.User.id"))));
		$this->CourseInstructor->bindModel(array("belongsTo"=>array("Userdetail"=>array("className"=>"Userdetail","foreignKey"=>false,"conditions"=>"CourseInstructor.user_id = Userdetail.user_id","fields"=>array("Userdetail.first_name","Userdetail.last_name","Userdetail.paypalaccount")))));
		$this->CourseInstructor->unBindModel(array("belongsTo"=>array("Course","User")));
		$courseownerid = $this->CourseInstructor->find("first",array("conditions"=>array("CourseInstructor.course_id"=>$id,"CourseInstructor.user_id "=>$this->Session->read("Auth.User.id"))));
		// for Coursesleft element
		$this->loadModel('Course');
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id",	"designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.title","Course.user_id","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.id"=>$id)));
		$this->set("userdetails",$userdetails);
		$this->set("title_for_layout","Manage Instructors - ".$userdetails['Course']['title']);
		$this->set("courseinstructors",$courseinstructors);
		$this->set("courseownerid",$courseownerid['CourseInstructor']['id']);
		$this->set("usercommission",$this->getusercommission($id));
		$this->validatecourse($id,-1,NULL,false);
	}
/* end of function */


/*
 * @function name	: deleteinstructor
 * @purpose			: delete of instructors for a course
 * @arguments		: Following are the arguments to be passed:
		* instructorid		: id of instructor
		* courseid			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 8th july 2013
 * @description		: NA
*/	
	function deleteinstructor($instructorid,$courseid) {
		$this->validatecourse($courseid,-1);
		$this->loadModel("CourseInstructor");
		$this->CourseInstructor->id = $instructorid;
		$this->CourseInstructor->delete();
		$this->Session->setFlash(__('Instructor has been deleted.'), 'default', array("class"=>"success_message"));
		$this->redirect('/course-manage/instructors/'.$courseid);
	}
/* end of function */


/*
 * @function name	: price
 * @purpose			: add,edit,update price settings for course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 8th july 2013
 * @description		: NA
*/		
	function price($id) {
		$this->layout = "frontend";
		if (isset($this->data) && !empty($this->data)) {
			if (isset($this->data['Userdetail']['paypalaccount'])) {
				$this->loadModel("Userdetail");
				$this->Userdetail->id = $this->Session->read("Auth.User.Userdetail.id");
				$useremail['Userdetail']['paypalaccount'] = $this->data['Userdetail']['paypalaccount'];
				if ($this->Userdetail->save($useremail)) {
					$this->Session->write("Auth.User.Userdetail.paypalaccount",$useremail);
					$this->Session->setFlash("Your paypal email has been updated.", 'default', array("class"=>"success_message"));
					//$this->redirect("/paypal-account");
				} else {
					$this->Session->setFlash("Your paypal email can not be updated.");
				}
			} else {
				$this->Course->id = $id;
				$courseprice = $this->data;
				
				if(isset($this->data['Course']['pricetype']) && $this->data['Course']['pricetype'] == 'Paid' ) {
					$courseprice['Course']['price'] = number_format($this->data['Course']['price'],"2",".","");
				} elseif(isset($this->data['Course']['pricetype']) && $this->data['Course']['pricetype'] == 'Free') {
					$courseprice['Course']['price'] = '0.00';
				}
				if($this->Course->save($courseprice)){
					$this->Session->setFlash(__('Price option has been updated.'), 'default', array("class"=>"success_message"));
				} else{
					$this->Course->set($courseprice);
					if ($this->Course->validates()) {
						// it validated logic
					} else {
						// didn't validate logic
						$errors = $this->Course->validationErrors;
						$this->Session->setFlash(__($errors['price'][0]));
					}

				}
			}
		}
		$userid = $this->validatecourse($id,-1,NULL,false);
		$this->set("paypal",$this->getpaypalemail($userid));
		// for Coursesleft element
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id","designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.user_id","Course.title","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.user_id"=>$this->Session->read("Auth.User.id"), "Course.id"=>$id)));
		$this->set("title_for_layout","Price - ".$userdetails['Course']['title']);
		$this->set(compact('userdetails'));
	}
/* end of function */


/*
 * @function name	: dangerzone
 * @purpose			: view settings to publish,unpublish and deletion of a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 8th july 2013
 * @description		: NA
*/	
	function dangerzone($id) {
		$this->layout = "frontend";
		if (isset($this->data) && !empty($this->data)) {
			
		}
		$this->validatecourse($id,-1,NULL,false);
		// for Coursesleft element
		
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id","designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.title","Course.user_id","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.id"=>$id)));
		$this->set("title_for_layout","Delete Course - ".$userdetails['Course']['title']);
		$this->set(compact('userdetails'));
	}
/* end of function */


/*
 * @function name	: deletecourse
 * @purpose			: deletion of a course
 * @arguments		: Following are the arguments to be passed:
		* courseid		: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 8th july 2013
 * @description		: NA
*/
	function deletecourse($courseid) {
		$this->validatecourse($courseid,-1,NULL,false);
		$this->Course->create();
		$this->Course->id = $courseid;
		if ($this->Course->delete($courseid)) {
			if (is_dir(WWW_ROOT."img/".$this->Session->read("Auth.User.id")."/Course".$courseid)) {
				exec("rm -rf ".WWW_ROOT."img/".$this->Session->read("Auth.User.id")."/Course".$courseid);
			}
			$this->Session->setFlash('Course has been deleted.', 'default', array("class"=>"success_message"));
			$this->redirect("/mycourses");
		}
	}
/* end of function */


/*
 * @function name	: editcurriculum
 * @purpose			: view,edit and update for curriculum of a course
 * @arguments		: Following are the arguments to be passed:
		* courseid		: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10th july 2013
 * @description		: NA
*/
	function editcurriculum($id = NULL) {
		//Configure::write('debug',0);
		$this->layout = "frontend";
		//if ($this->RequestHandler->isAjax()) { 
			if(!empty($this->request->data['Course']['lecturetextid']) && isset($this->request->data['Course']['text'][$this->request->data['Course']['lecturetextid']])) {
				//pr($this->request->data);
				//die;
				$this->loadModel("CourseLecture");
				$this->CourseLecture->create();
				$this->CourseLecture->id = $this->request->data['Course']['lecturetextid'];
				$courselecture['CourseLecture']['content'] = $this->request->data['Course']['text'][$this->request->data['Course']['lecturetextid']];
				$courselecture['CourseLecture']['content_type'] = 'T';
				$this->CourseLecture->save($courselecture);
				echo "1";
				exit;
			}
		//}
		$this->validatecourse($id,-1);
		$this->loadModel("CourseLecture");
		$this->CourseLecture->recursive =-1;
		$this->CourseLecture->virtualFields = array(
		"total_lec"=>"select count(*) from course_lectures CLS where CLS.course_id = ".$id,
		"incomplete_lec"=>"select count(*) from course_lectures CLSs where CLSs.content_type IS NULL and CLSs.course_id = ".$id
		);
		$courselec = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.course_id"=>$id),"fields"=>array("CourseLecture.total_lec","CourseLecture.incomplete_lec")));
		$this->loadModel("CourseSection");
		$this->CourseSection->unbindModel(array("belongsTo"=>array("Course")));
		$coursesection = $this->CourseSection->find("all",array("conditions"=>array("CourseSection.course_id"=>$id)));
		$this->set("coursesection",$coursesection);
		$this->Session->write("editCourseId", $id);
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id", "designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.user_id","Course.title","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.user_id"=>$this->Session->read("Auth.User.id"), "Course.id"=>$id)));
		$this->set("title_for_layout","Syllabus - ".$userdetails['Course']['title']);
		$this->set(compact('userdetails'));
		$this->set("courselec",$courselec);
		$this->set("coursequestions",$this->Course->getquizquestions($id));
	}
/* end of function */


/*
 * @function name	: editcurriculumajax
 * @purpose			: view,edit and update for curriculum of a course
 * @arguments		: Following are the arguments to be passed:
		* courseid		: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10th july 2013
 * @description		: NA
*/
	function editcurriculumajax($id = NULL) {
		$this->layout = null;
		if ($this->RequestHandler->isAjax()) { 
			if(isset($this->request->data["courseid"])) {
				$id = $this->request->data["courseid"];
			} else {
				$this->loadModel("CourseLecture");
				$ids = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.id"=>$this->request->data["lectureid"])));
				$id  = $ids['CourseLecture']['course_id'];
			}
			$this->validatecourse($id,-1);
			$this->loadModel("CourseLecture");
			$this->CourseLecture->recursive = -1;
			$this->CourseLecture->virtualFields = array(
			"total_lec"=>"select count(*) from course_lectures CLS where CLS.course_id = ".$id,
			"incomplete_lec"=>"select count(*) from course_lectures CLSs where CLSs.content_type IS NULL and CLSs.course_id = ".$id
			);
			$courselec = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.course_id"=>$id),"fields"=>array("CourseLecture.total_lec","CourseLecture.incomplete_lec")));
			$this->loadModel("CourseSection");
			$this->CourseSection->unbindModel(array("belongsTo"=>array("Course")));
			$coursesection = $this->CourseSection->find("all",array("conditions"=>array("CourseSection.course_id"=>$id)));
			$this->set("coursesection",$coursesection);
			$this->Session->write("editCourseId", $id);
			$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
			$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id", "designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id");
			$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.user_id","Course.title","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.user_id"=>$this->Session->read("Auth.User.id"), "Course.id"=>$id)));
			$this->set(compact('userdetails'));
			$this->set("courselec",$courselec);
			$this->set("coursequestions",$this->Course->getquizquestions($id));
		}
	}
/* end of function */


/** 
 * Method used for uploading the pdf files for while creating mashup video. And after uploading it will convert pdf document into images. 
 * 
 * @access public
 * @return json
 * @createdBy Arjun
 * @createdOn 31 july 2013
 */ 
	public function uploadMashupPdf() {
		if (!empty($this->request->data['Course']['mashupPdf'])) {
			$this->autoRender = false;
			$this->Upload = $this->Components->load('Upload');
			list($key, $value) = each($this->request->data['Course']['mashupPdf']);
			$sFileName = basename(strtolower($this->request->data['Course']['mashupPdf'][$key]['name']), ".pdf");
			$sFileName = preg_replace("/[^A-Za-z0-9_-]/", "", $sFileName).".pdf";
			$this->request->data['Course']['mashupPdf'][$key]['name'] = $sFileName;
			$sFileType = $this->request->data['Course']['mashupPdf'][$key]['type'];
			$fileOK = $this->Upload->uploadFiles(MashupPdfUploadingPath, $this->request->data['Course']['mashupPdf'][$key], array('text/html','application/pdf','application/x-msword','application/x-unknown'), MashupPdfMaxSize);   //upload image
			//upload image
			if(empty($fileOK['errors'][0])) {
				echo '{"error" : "false","fileName" : "'.$fileOK['new_filename'][0].'","fileType" : "'.$sFileType.'"}';
			} else {
				echo '{"error" : "'.$fileOK['errors'][0].'"}';
			}		
		} else {
			$this->Session->setFlash(__('Data is empty.'));
			$this->redirect("/");
		}
	}	

	public function numberOfPagesInPdf($pdfWithPath) {
		if (!$fp = @fopen($pdfWithPath,"r")) {
				echo 'failed opening file '.$pdfWithPath;
		} else {
			$max=0;
			while(!feof($fp)) {
				$line = fgets($fp,255);
				if (preg_match('/\/Count [0-9]+/', $line, $matches)){
						preg_match('/[0-9]+/',$matches[0], $matches2);
						if ($max<$matches2[0]) $max=$matches2[0];
				}
			}
			fclose($fp);
			if ($max == 0) {
				$max = exec("/usr/bin/pdfinfo ".$pdfWithPath." | grep Pages: | awk '{print $2}'");
			}
			
			return $max;
			//echo 'There '.($max<2?'is ':'are ').$max.' page'.($max<2?'':'s').' in '. $pdfWithPath.'.';	
		}
		return false;
	}


/** 
 * Method used for uploading the pdf files for while creating mashup video. And after uploading it will convert pdf document into images. 
 * 
 * @access public
 * @return json
 * @createdBy Arjun
 * @createdOn 31 july 2013
 */ 
	public function generateImagesFromPdf() {
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$sFileName = $_REQUEST['fileName'];
			if(!empty($sFileName) && file_exists(MashupPdfUploadingPath.$sFileName)) {
				$filesArray[0]['filePath'] = MashupPdfUploadingPath.$sFileName;
				$pdfWithPath = MashupPdfUploadingPath.$sFileName;
				$totalCount = $this->numberOfPagesInPdf($pdfWithPath);
				if($totalCount) {
					$imageSizes = array(LargeImagePrefix => LargeImage);
					foreach($imageSizes as $key=>$size) {
						//add the desired extension to the thumbnail
						$imageName = MashupImageUploadingPath.$key.str_replace('.pdf','',$sFileName).".jpg";
						//execute imageMagick's 'convert', setting the color space to RGB and size to 200px wide
						//exec("convert -thumbnail '{$size}' -density 300 -background white -alpha remove \"{$pdfWithPath}\" {$imageName}");
						//exec("convert \"{$pdfWithPath}\" -density 300 -background white -alpha remove {$size} {$imageName}");
						exec("convert \"{$pdfWithPath}\" -colorspace RGB -density 300 -background white -alpha remove {$size} {$imageName}");
					}		 
					$sFileName = str_replace('.pdf','',$sFileName);
					for($i=0; $i<$totalCount; $i++) {
						$filesArray[$i+1]['fileUrl'] = MashupImageUrl.LargeImagePrefix."{$sFileName}-{$i}.jpg";
						$filesArray[$i+1]['fileName'] = "{$sFileName}-{$i}.jpg";
					}
					$imagesXml = $this->generateImagesXml($filesArray, str_replace('.pdf','',$sFileName));
					echo '{"error" : "false","imagesXml" : "'.$imagesXml.'"}';
				} else {
					echo '{"error" : "An error occured, Please try again."}';
				}
			} else {
				echo '{"error" : "file is empty or not exist"}';
			}		
		} else {
			$this->redirect("/");
		}
	}

	public function generateMashupXml() {
		if ($this->RequestHandler->isAjax()) {
			$this->autoRender = false;
			$mData = $_POST['data'];
            $this->aasort($mData, '1');
			$videoName = $_POST['videoName'];
			$docName = $_POST['docName'];
			if(!empty($mData)) {
				$mashupXml = $this->createMashupXml($mData, str_replace('.pdf','',$docName));
				$this->Session->write('mashupXml',$mashupXml);
				$this->Session->write('mashupVideo',$videoName);
				$this->Session->write('mashupDoc',$docName);
				echo '{"error" : "false","mashupXml" : "'.$mashupXml.'"}';
			} else {
				//echo '{"error" : "Data is empty"}';
				echo '{"error" : "You need to select atleast one slide below to create mashup."}';
			}		
		} else {
			$this->redirect("/");
		}
	}

	public function createMashup() {
		$this->loadModel("CourseMashup");
		$this->loadModel("CourseLecture");
		$data['CourseMashup']['xml'] = $this->Session->read('mashupXml');
		$data['CourseMashup']['video'] = $this->Session->read('mashupVideo');
		$data['CourseMashup']['doc'] = $this->Session->read('mashupDoc');
		$data['CourseMashup']['course_id'] = $this->Session->read('editCourseId');
		$data['CourseMashup']['course_lecture_id'] = $this->Session->read('lectureidmash');
		$this->Session->delete('lectureidmash');
		unset($_SESSION['lectureidmash']);
		$this->CourseLecture->create();
		$this->CourseLecture->id = $data['CourseMashup']['course_lecture_id'];
		$datap['CourseLecture']['content_type'] = 'M';
		$this->CourseLecture->save($datap);
		$this->CourseMashup->create();
		$mashup = $this->CourseMashup->find("first",array("CourseMashup.course_lecture_id"=>$data['CourseMashup']['course_lecture_id']));
		if (!empty($mashup['CourseMashup'])) {
			$this->CourseMashup->create();
			//$this->CourseMashup->id = $mashup['CourseMashup']['id'];
		}
		if($this->CourseMashup->save($data)) {
			$this->Session->setFlash(__('Mashup has been saved.'), 'default', array("class"=>"success_message"));
			$this->redirect("/course-manage/edit-curriculum/".$data['CourseMashup']['course_id']);
		} else {
			$this->Session->setFlash(__('An error occured, Please try again.'));
			$this->redirect("/course-manage/edit-curriculum/".$data['CourseMashup']['course_id']);
		}
	}

	public function mashupVideoPlayer() {
		$this->layout = false;
		$mashupVideo = $_POST['mashupVideo'];
		$uniqueId = $_POST['uniqueId'];
		if(empty($mashupVideo)) {
			die('Video not found');		
		}
		$this->set('uniqueId', $uniqueId);
		$this->set('mashupVideo',MashupVideoUrl.$mashupVideo);
	}

	public function mashupDocPreviewer() {
		$this->layout = false;
		$docXml = $_POST['docXml'];
		$uniqueId = $_POST['uniqueId'];
		if(empty($docXml)) {
			die('Doc xml not found');		
		}
		$this->set('uniqueId', $uniqueId);
		$this->set('mashupDoc', $docXml);
	}

	public function mashupPreview() {
		$this->layout = "frontend";
		$mashupXml = $this->Session->read('mashupXml');
		$mashupVideo = $this->Session->read('mashupVideo');
		if(empty($mashupXml) || empty($mashupVideo)) {
			$this->Session->setFlash(__('An error occurred.'));
			$this->redirect("/");
		}
		$this->set('mashupVideo',MashupVideoUrl.$mashupVideo);
		$this->set('mashupXml',$mashupXml);
	}

	public function createMashupXml($filesArray, $fileName) {
        $xml = new DOMDocument("1.0");
        $root = $xml->createElement("images");
        $xml->appendChild($root);
        foreach ($filesArray as $val) {
            $source = $xml->createElement("source");
            $sourceText = $xml->createTextNode(MashupImageUrl . LargeImagePrefix . $val[0]);
            $source->appendChild($sourceText);

            $name = $xml->createElement("name");
            $nameText = $xml->createTextNode($val[0]);
            $name->appendChild($nameText);

            $start = $xml->createElement("start");
            $startText = $xml->createTextNode($val[1]);
            $start->appendChild($startText);

            $end = $xml->createElement("end");
            $endText = $xml->createTextNode($val[2]);
            $end->appendChild($endText);

            $image = $xml->createElement("image");
            $image->appendChild($source);
            $image->appendChild($name);
            $image->appendChild($start);
            $image->appendChild($end);

            $root->appendChild($image);
        }
		$xml->formatOutput = true;
		$xml->save(MashupXmlUploadingPath."{$fileName}.xml") or die("Error");		
		return MashupXmlUrl."{$fileName}.xml";
	}	

	
	public function generateImagesXml($filesArray, $fileName) {
		$xml = new DOMDocument("1.0");
		$root = $xml->createElement("images");
		$xml->appendChild($root);
		unset($filesArray[0]);
		foreach($filesArray as $val) {
			$source   = $xml->createElement("source");
			$sourceText = $xml->createTextNode($val['fileUrl']);
			$source->appendChild($sourceText);

			$name   = $xml->createElement("name");
			$nameText = $xml->createTextNode($val['fileName']);
			$name->appendChild($nameText);

			$image = $xml->createElement("image");
			$image->appendChild($source);
			$image->appendChild($name);
			$root->appendChild($image);
		}
		$xml->formatOutput = true;
		$xml->save(MashupImagesXmlUploadingPath."{$fileName}.xml") or die("Error");		
		return MashupImagesXmlUrl."{$fileName}.xml";
	}	

/** 
 * Method used for uploading video files while creating mashup video. After uploading file it will convert video into mp4 format. 
 * 
 * @access public
 * @return json
 * @createdBy Arjun
 * @createdOn 02 aug 2013
 */ 
	public function uploadMashupVideo() {
		if (!empty($this->request->data['Course']['mashupVideo'])) {
			$this->autoRender = false;
			$this->Upload = $this->Components->load('Upload');
			list($key, $value) = each($this->request->data['Course']['mashupVideo']);
			$sFileName = $this->request->data['Course']['mashupVideo'][$key]['name'];
			$sFileType = $this->request->data['Course']['mashupVideo'][$key]['type'];
			$fileOK = $this->Upload->uploadVideos(MashupVideoUploadingPath, $this->request->data['Course']['mashupVideo'][$key]);   //upload image
			if(empty($fileOK['errors'])) {
				echo '{"error" : "false", "fileUrl" : "'.MashupVideoUrl.$fileOK['filenameExt'][0].'","fileName" : "'.$fileOK['filename'][0].'"}';
			} else {
				echo '{"error" : "'.$fileOK['errors'].'"}';
			}
		} else {
			$this->Session->setFlash(__('Data is empty.'));
			$this->redirect("/");
		}
	}

/** 
 * Method used for uploading video files while creating mashup video. After uploading file it will convert video into mp4 format. 
 * 
 * @access public
 * @return json
 * @createdBy Arjun
 * @createdOn 02 aug 2013
 */ 
	public function mashupMaker($videoName, $uniqueId = NULL) {
		//if (!$this->RequestHandler->isAjax()) {
			//$this->redirect("/");
		//} 
		$this->layout = false;
		$this->Session->write("lectureidmash",'');
		unset($_SESSION['lectureidmash']);
		$this->Session->delete('lectureidmash');
		$this->Session->write("lectureidmash",$uniqueId);
		$this->set('uniqueId',$uniqueId);
		$this->set('videoUrl', MashupVideoUrl.$videoName);
	}


/*
 * @function name	: chnagesectionheading
 * @purpose			: to change heading of section
 * @arguments		: Following are the arguments to be passed:
		* coursesection		: id of course section
		* heading			: heading to be updated
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10th july 2013
 * @description		: NA
*/
	function chnagesectionheading($coursesection = NULL, $heading = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("CourseSection");
			$this->CourseSection->create();
			$this->CourseSection->id = $this->request->data['courseid'];
			$course['CourseSection']['heading'] = $this->request->data['heading'];
			if ($this->CourseSection->save($course)) {
				echo "1";
			} else {
				echo "2";
			}
		}
		$this->render(false);
	}
/* end of function */	


/*
 * @function name	: chnagelectureheading
 * @purpose			: to change heading of section
 * @arguments		: Following are the arguments to be passed:
		* courselecture		: id of course lecture
		* heading			: heading to be updated
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10th july 2013
 * @description		: NA
*/
	function chnagelectureheading($courselecture = NULL, $heading = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("CourseLecture");
			$this->CourseLecture->create();
			$this->CourseLecture->id = $this->request->data['lectureid'];
			$course['CourseLecture']['heading'] = $this->request->data['heading'];
			$course['CourseLecture']['course_description'] = $this->request->data['desc'];
			if ($this->CourseLecture->save($course)) {
				echo "1";
			} else {
				echo "2";
			}
		}
		$this->render(false);
	}
/* end of function */	


/*
 * @function name	: deletesection
 * @purpose			: to delete a section
 * @arguments		: Following are the arguments to be passed:
		* coursesection		: id of course section
		* index				: section index which will be updated for every other section when current section will be deleted
		* courseid			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10th july 2013
 * @description		: NA
*/	
	function deletesection($coursesection = NULL,$index= NULL,$courseid =NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("CourseSection");
			$this->CourseSection->create();
			$this->CourseSection->id = $this->request->data['sectionid'];
			$this->CourseSection->updatesectionindex($this->request->data['index'],$this->request->data['courseid']);
			if ($this->CourseSection->delete()) {
				if(is_dir(WWW_ROOT."img/".$this->Session->read("Auth.User.id")."/Course".$this->request->data['courseid']."/Section".$this->request->data['sectionid'])) {
					exec("rm -rf ".WWW_ROOT."img/".$this->Session->read("Auth.User.id")."/Course".$this->request->data['courseid']."/Section".$this->request->data['sectionid']);
				}
				$this->CourseSection->unbindModel(array("belongsTo"=>array("Course")));
				$coursesection = $this->CourseSection->find("all",array("conditions"=>array("CourseSection.course_id"=>$this->request->data['courseid'])));
				$this->set("coursesection",$coursesection);
			} else {
				echo "2";
			}
		}
		$this->render("addsection");
	}
/* end of function */	


/*
 * @function name	: deletelecture
 * @purpose			: to delete a lecture
 * @arguments		: Following are the arguments to be passed:
		* coursesection		: id of course section
		* index				: section index which will be updated for every other section when current section will be deleted
		* courseid			: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 10th july 2013
 * @description		: NA
*/	
	function deletelecture($coursesection = NULL,$index= NULL,$courseid =NULL) {
		if ($this->RequestHandler->isAjax()) {
			pr($this->request->data);
			
			$this->loadModel("CourseLecture");
			$this->loadModel("CourseSection");				
			$max1 = $this->CourseSection->find("first",array("conditions"=>array("CourseSection.course_id"=>$this->request->data['courseid']),"fields"=>"max(CourseSection.id) as maxsection"));
			$max1 = $max1[0]['maxsection'];
			$this->CourseLecture->create();
			$this->CourseLecture->id = $this->request->data['sectionid'];
			$this->CourseLecture->updatelectureindex($this->request->data['index'],$max1);
			$secid = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.id"=>$this->request->data['sectionid']),"fields"=>array("CourseLecture.course_section_id")));
			if ($this->CourseLecture->delete()) {
				if(is_dir(WWW_ROOT."img/".$this->Session->read("Auth.User.id")."/Course".$this->request->data['courseid']."/Section".$secid['CourseLecture']['course_section_id']."/Lecture".$this->request->data['sectionid'])) {
					exec("rm -rf ".WWW_ROOT."img/".$this->Session->read("Auth.User.id")."/Course".$this->request->data['courseid']."/Section".$secid['CourseLecture']['course_section_id']."/Lecture".$this->request->data['sectionid']);
				}
				$this->Course->dellecquiz($this->request->data['sectionid']);
				$this->CourseSection->unbindModel(array("belongsTo"=>array("Course")));
				$coursesection = $this->CourseSection->find("all",array("conditions"=>array("CourseSection.course_id"=>$this->request->data['courseid'])));
				$this->set("coursesection",$coursesection);
			} else {
				echo "2";
			}
		}
		$this->render("addsection");
	}
/* end of function */	


/*
 * @function name	: addsection
 * @purpose			: to add a new section in course
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course
		* heading			: heading for section
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/
	function addsection($courseid = NULL,$heading = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("CourseSection");
			$this->CourseSection->create();
			$max = $this->CourseSection->find("first",array("conditions"=>array("CourseSection.course_id"=>$this->request->data['id']),"fields"=>"count(CourseSection.section_index) as maxsection"));
			$max = $max[0]['maxsection'];
			$coursesection['CourseSection']['course_id']	= $this->request->data['id'];
			$coursesection['CourseSection']['heading'] 		= 'A new Module';
			$coursesection['CourseSection']['section_index']= ($max+1);
			if ($this->CourseSection->save($coursesection)) {
				$this->loadModel("CourseLecture");
				$this->CourseLecture->create();
				$courselecture['CourseLecture']['course_id'] 	= $this->request->data['id'];
				$courselecture['CourseLecture']['course_section_id']	= $this->CourseSection->getLastInsertId();
				$courselecture['CourseLecture']['heading']		= "A New Lesson";
				$courselecture['CourseLecture']['lecture_index']= 1;
				//$this->CourseLecture->save($courselecture);
				$this->CourseSection->unbindModel(array("belongsTo"=>array("Course")));
				$coursesection = $this->CourseSection->find("all",array("conditions"=>array("CourseSection.course_id"=>$this->request->data['id'])));
				$this->set("coursesection",$coursesection);
			} else {
				echo "2";
			}
		}
	}
/* end of function */	


/*
 * @function name	: addlecture
 * @purpose			: to add a new lecture in course section
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course
		* heading			: heading for lecture
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/
	function addlecture($courseid = NULL,$heading = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("CourseLecture");
			$this->loadModel("CourseSection");
			$this->CourseLecture->create();
			$this->CourseSection->create();
			if(!isset($this->request->data['sectionid'])) {
				$max1 = $this->CourseSection->find("first",array("conditions"=>array("CourseSection.course_id"=>$this->request->data['courseid']),"fields"=>"max(CourseSection.id) as maxsection"));
				$max1 = $max1[0]['maxsection'];
			} else {
				$max1 = $this->request->data['sectionid'];
			}
			$max = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.course_id"=>$this->request->data['courseid'],"CourseLecture.course_section_id"=>$max1),"fields"=>"count(CourseLecture.lecture_index) as maxlecture"));
			$max = $max[0]['maxlecture'];
			$coursesection['CourseLecture']['course_id']		= $this->request->data['courseid'];
			$coursesection['CourseLecture']['course_section_id']= $max1;
			$coursesection['CourseLecture']['heading'] 			= $this->request->data['heading'];
			$coursesection['CourseLecture']['lecture_index']	= ($max+1);
			
			if ($this->CourseLecture->save($coursesection)) {
				$this->CourseSection->unbindModel(array("belongsTo"=>array("Course")));
				$coursesection = $this->CourseSection->find("all",array("conditions"=>array("CourseSection.course_id"=>$this->request->data['courseid'])));
				$this->set("coursesection",$coursesection);
			} else {
				echo "2";
			}
		}
		$this->render("addsection");
	}
/* end of function */	


/*
 * @function name	: addquiz
 * @purpose			: to add a new quiz in course or section
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course
		* heading			: heading for quiz
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/	
	function addquiz($courseid = NULL,$heading = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("CourseQuiz");
			if(!isset($this->request->data['heading'])) {
				$this->loadModel("CourseSection");
				$this->loadModel("CourseLecture");
				$this->CourseQuiz->recursive = -1;
				$this->CourseSection->recursive = -1;
				$this->CourseLecture->recursive = -1;
				$this->CourseQuiz->create();
				$max1 = $this->CourseSection->find("first",array("conditions"=>array("CourseSection.course_id"=>$this->request->data['courseid']),"fields"=>"max(CourseSection.id) as maxsection"));
				$max1 = $max1[0]['maxsection'];
				$max = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.course_section_id"=>$max1),"fields"=>"max(CourseLecture.id) as maxlecture"));
				$max = $max[0]['maxlecture'];
				$coursesection['CourseQuiz']['course_section_id']= $max1;
				if(!empty($max)) {
					$coursesection['CourseQuiz']['course_lecture_id']= $max;
				}
			} else {
				$coursesection['CourseQuiz']['course_section_id'] = $this->request->data['sectionid'];
				if(!empty($this->request->data['lectureid'])) {
					$coursesection['CourseQuiz']['course_lecture_id'] = $this->request->data['lectureid'];
				}
			}
			$coursesection['CourseQuiz']['heading'] 			= $this->request->data['heading'];
			if ($this->CourseQuiz->save($coursesection)) {
				echo '1';
			} else {
				echo "2";
			}
		}
		$this->render(false);
	}
/* end of function */	


/*
 * @function name	: uploadvideofiles
 * @purpose			: to upload content for lectures
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: this is the main function which will be used to upload various content of diffrent type like video,audio or pdf for lectures as content of courses
*/	
	function uploadvideofiles() {
		if ($this->RequestHandler->isAjax()) {
			if ($this->Session->read("filetype") && $this->Session->read("lectureid")) {
				if ($this->Session->read("filetype") == 'video') {
					$contenttype = "V";
					$validarray = array("mp4","mov","wmv","flv","3gp","quicktime","avi","mpeg","x-wav");
				} elseif ($this->Session->read("filetype") == 'audio') {
					$contenttype = "A";
					$validarray = array("mp3","wav","wma","ra","ram","rm","ogg","m4a");
				} elseif ($this->Session->read("filetype") == 'presentation') {
					$contenttype = "P";
					$validarray = array("pdf","ppt","pptx","notebook");
				} elseif ($this->Session->read("filetype") == 'document') {
					$contenttype = "D";
					$validarray = array("pdf","doc","docx");
				} else {
					$contenttype = "T";
				}
			}
			$fileextension = explode(".",$_FILES['file']['name']);
			$fileextension = strtolower($fileextension[count($fileextension)-1]);
			$oldfile = $this->getoldfile($this->Session->read("lectureid"));
			if (!in_array($fileextension,$validarray)) {
				echo "1";
			} else {
				if($contenttype == 'V') {
					$file = $_FILES['file'];
					if($this->uploadvideofly($file)){
						$this->loadModel("CourseLecture");
						$this->CourseLecture->id = $this->Session->read("lectureid");
						$coursesection['CourseLecture']['content_source']	=  $this->uploaddir.$this->imagename;
						$coursesection['CourseLecture']['content_type']		=  $contenttype;
						$coursesection['CourseLecture']['content_title']	=  $_FILES['file']['name'];
						$coursesection['CourseLecture']['content_external_link']	=  'None';
						if ($this->CourseLecture->save($coursesection)) {
							if (!empty($oldfile) && $oldfile != $this->uploaddir.$this->imagename && file_exists($this->uploaddir.$this->imagename)) {
								unlink($oldfile);
								unlink($oldfile.".jpg");
							}
							echo "2";
							//echo $this->uploaddir.$this->imagename;
						}
					}
				}
				if($contenttype == 'A') {
					$file = $_FILES['file'];
					if($this->uploadvideofly($file,"lectureaudio",false,null,true)){
						$this->loadModel("CourseLecture");
						$this->CourseLecture->id = $this->Session->read("lectureid");
						$coursesection['CourseLecture']['content_source']	=  $this->uploaddir.$this->imagename;
						$coursesection['CourseLecture']['content_type']		=  $contenttype;
						$coursesection['CourseLecture']['content_title']	=  $_FILES['file']['name'];
						$coursesection['CourseLecture']['content_external_link']	=  'None';
						if ($this->CourseLecture->save($coursesection)) {
							if (!empty($oldfile) && $oldfile != $this->uploaddir.$this->imagename && file_exists($oldfile)) {
								unlink($oldfile);
							}
							echo "2";
							//echo $this->uploaddir.$this->imagename;
						}
					}
				}
				if($contenttype == 'D' || $contenttype == 'P') {
					$file = $_FILES['file'];
					if($this->uploadvideofly($file,"lecturedocs",false)){
						$this->loadModel("CourseLecture");
						$this->CourseLecture->id = $this->Session->read("lectureid");
						$coursesection['CourseLecture']['content_source']	=  $this->uploaddir.$this->imagename;
						$coursesection['CourseLecture']['content_type']		=  $contenttype;
						$coursesection['CourseLecture']['content_title']	=  $_FILES['file']['name'];
						$coursesection['CourseLecture']['content_external_link']	=  'None';
						if ($this->CourseLecture->save($coursesection)) {
							if (!empty($oldfile) && $oldfile != $this->uploaddir.$this->imagename) {
								unlink($oldfile);
							}
							//echo $this->uploaddir.$this->imagename;
							echo "2";
						}
					}
				}
			}
		}
		$this->render(false);
	}
/* end of function */	

	
	function uploadsupplimentary() {
		$imageExtensionArray = array('audio/mp4','image/gif','image/jpeg','image/bmp','image/pjpeg','image/png','audio/mpeg','audio/mpeg','audio/x-wav','audio/x-ms-wma','image/bmp','video/x-flv','video/mp4','video/wav','video/wmv','video/x-msvideo','video/quicktime','video/x-ms-wmv','video/3gpp','video/x-ms-asf','application/x-shockwave-flash','audio/x-ms-wma','video/mpeg','video/flv','video/mp2t','video/mts','application/pdf','application/msword','application/vnd.ms-excel','application/rtf','application/docx','application/log','application/tex','application/wpd','application/wps','application/odt','application/pages','application/log','application/xlr','application/docx','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/xlsx','application/vnd.oasis.opendocument.text','application/octet-stream','s/vnd.ms-powerpoint','application/pptx','application/pptm','application/ppt','application/potx','application/ppa','application/potm','application/ppam','application/ppsx','application/ppsm','text/plain','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/x-ms-flp','application/flp','application/vnd.flp','application/force-download','application/x-zip-compressed','text/html','application/zip','application/vnd.rn-realmedia','application/vnd.wordperfect','application/x-ms-dos-executable','application/epub+zip','image/tiff','audio/x-wav','image/tiff','audio/x-wav','audio/wav','video/avi','audio/x-m4a','video/x-m4v','audio/m4a','application/vnd.ms-powerpoint');
		if($this->RequestHandler->isAjax()) {
			$ext = explode(".",$_FILES['file']['name']);
			$ext = $ext[count($ext)-1];
			if (strtolower($ext) != 'notebook' && !in_array($_FILES['file']['type'],$imageExtensionArray)) {
				echo "9";
			} else {
				$file = $_FILES['file'];
				$this->loadModel("CourseSuppliment");
				if ($this->uploadvideofly($file,NULL,false)) {
					$coursesection['CourseSuppliment']['course_lecture_id']		=  $this->Session->read("lectureid");
					$coursesection['CourseSuppliment']['content_title']			=  $_FILES['file']['name'];
					$coursesection['CourseSuppliment']['content_source']		=  $this->uploaddir.$this->imagename;
					if ($this->CourseSuppliment->save($coursesection)) {
						echo "2";
					}
				} else {
					echo "3";
				}
			}
			die;
		}
	}


/*
 * @function name	: uploadextfile
 * @purpose			: to upload content for lectures but as external links like youtube or vimeo
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/
	function uploadextfile() {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel('CourseLecture');
			$id = explode("_",$this->request->data['ids']);
			$this->CourseLecture->id = $id[1];
			$coursesection['CourseLecture']['content_source']			=  $this->request->data['linkid'];
			$coursesection['CourseLecture']['content_type']				=  'V';
			$coursesection['CourseLecture']['content_external_link']	=  trim(ucfirst($this->request->data['linktype']));
			$coursesection['CourseLecture']['content_title']			=  html_entity_decode($this->request->data['linktitle']);
			if ($this->CourseLecture->save($coursesection)) {
				echo "2";
				$this->Session->setFlash("Lecture has been added.", 'default', array("class"=>"success_message"));
			}
		}
		$this->render(false);
	}
/* end of function */	


/*
 * @function name	: setlectureid
 * @purpose			: to determine which type of data is going to be uploaded for lecture
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/	
	function setlectureid() {
		if ($this->RequestHandler->isAjax()) {
			$this->Session->write("filetype",$this->request->data['filetype']);
			$this->Session->write("lectureid",$this->request->data['lectureid']);
			$this->Session->write("sectionid",$this->request->data['sectionid']);
			$this->Session->write("courseid",$this->request->data['courseid']);
		}
		$this->render(false);
	}
/* end of function */	


/*
 * @function name	: createquizform
 * @purpose			: to create a form from which a user can edit, update quiz description 
 * @arguments		: Following are the arguments to be passed:
		* qid			: id of quiz
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/
	function createquizform($qid = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->set("data",$this->request->data);
			$this->loadModel("CourseQuiz");
			$this->CourseQuiz->recursive = -1;
			$course = $this->CourseQuiz->find("first",array("conditions"=>array("CourseQuiz.id"=>$this->request->data['quizid']),"fields"=>array("CourseQuiz.content","CourseQuiz.heading")));
			$this->set("course",$course);
			$this->set("id",$this->request->data['quizid']);
			if(isset($this->request->data['quizcont'])) {
				$this->set("quizdesc","1");
			}
			$this->set("quizform","1");
		} 
	}
/* end of function */	


/*
 * @function name	: createaddquestionform
 * @purpose			: to create a form from which a user add new question 
 * @arguments		: Following are the arguments to be passed:
		* qid			: id of quiz
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/
	function createaddquestionform($qid = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->set("data",$this->request->data);
			$this->set("id",$this->request->data['quizid']);
			$this->set("addform","1");
		}
	}
/* end of function */	


/*
 * @function name	: viewquizquestions
 * @purpose			: to view added question 
 * @arguments		: Following are the arguments to be passed:
		* qid			: id of quiz
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/
	function viewquizquestions($qid = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->set("id",$this->request->data['quizid']);
			$this->loadModel("CourseQuizQuestion");
			$this->CourseQuizQuestion->unbindModel(array("belongsTo"=>array("CourseQuiz")));
			$questions = $this->CourseQuizQuestion->find("all",array("conditions"=>array("CourseQuizQuestion.course_quiz_id"=>$this->request->data['quizid'])));
			$this->set("questions",$questions);
		}
	}
/* end of function */	


/*
 * @function name	: addquestions
 * @purpose			: to add new question 
 * @arguments		: none
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/	
	function addquestions() {
		if ($this->RequestHandler->isAjax()) {
			if(!empty($this->request->data['CourseQuiz']['content'])) {
				$this->loadModel("CourseQuiz");
				$this->CourseQuiz->create();
				$this->CourseQuiz->id = $this->request->data['CourseQuiz']['id'];
				if($this->CourseQuiz->save($this->request->data['CourseQuiz'])) {
					echo 1;
					exit;
				}
			}
			if(isset($this->request->data['quizid']) && !empty($this->request->data['quizid'])) {
				$this->loadModel("CourseQuiz");
				$this->CourseQuiz->create();
				$this->CourseQuiz->id = $this->request->data['quizid'];
				$data['CourseQuiz'] = $this->request->data;
				if($this->CourseQuiz->save($data['CourseQuiz'])) {
					echo 1;
					exit;
				}
			}
			if(!empty($this->request->data['CourseQuizQuestion']['question'])) {
				if ($this->request->data['CourseQuizQuestion']['type'] == 'F') {
					$string = $this->getquestion($this->request->data['CourseQuizQuestion']['question']);
					if (empty($string['answer'])) {
						echo 2;
						exit;
					}
				}
				$this->loadModel("CourseQuizQuestion");
				$this->loadModel("CourseQuizQuestionOption");
				$this->CourseQuizQuestion->save($this->request->data['CourseQuizQuestion']);
				$qusetionid = $this->CourseQuizQuestion->getLastInsertId();
				$i = 0;
				if($this->request->data['CourseQuizQuestion']['type'] != 'F') {
					foreach ($this->request->data['CourseQuizQuestionOption']['options'] as $key=>$val) {
						$questionoptions['CourseQuizQuestionOption'][$key]['course_quiz_question_id'] = $qusetionid;
						$questionoptions['CourseQuizQuestionOption'][$key]['options'] = $val;
						if($this->request->data['CourseQuizQuestion']['type'] == 'B') {
							$questionoptions['CourseQuizQuestionOption'][$key]['answer'] = $val;
							if($i == 0) {
								$questionoptions['CourseQuizQuestionOption'][$key]['options'] = "True";
								++$i;
							} else {
								$questionoptions['CourseQuizQuestionOption'][$key]['options'] = "False";
							}
							
						} else {
							$questionoptions['CourseQuizQuestionOption'][$key]['answer'] = $this->request->data['CourseQuizQuestionOption']['answer'][$key];
						}
					}
					$this->CourseQuizQuestionOption->saveAll($questionoptions['CourseQuizQuestionOption']);
				}
				echo 1;
				die;
			}
		}
		$this->render(false);
	}
/* end of function */	


	function getquestion($string = NULL) {
		$str = explode("_",$string);
		$notallowed = array(",","&","and");
		$answer = array();
		$returnstring = array();
		foreach($str as $key =>$val) {
			if(!empty($val) && !in_array($val,$notallowed)) {
				$val1 = "_".$val."_";
				$val2 = "_".$val.".";
				if(strstr($string,$val1)) {
					$answer[] = $val;
					$string = str_replace($val1," __ ",$string);
				}
				if(strstr($string,$val2)) {
					$answer[] = $val;
					$string = str_replace($val2," __ ",$string);
				}
			}
		}
		$returnstring ['string'] = $string;
		$returnstring ['answer'] = $answer;
		return $returnstring;
	}

	function deletequiz($quizid = NULL) {
		if ($this->RequestHandler->isAjax()) {
			if(isset($this->request->data['quizid']) && !empty($this->request->data['quizid'])) {
				$this->loadModel("CourseQuiz");
				$this->CourseQuiz->create();
				$this->CourseQuiz->id = $this->request->data['quizid'];
				if($this->CourseQuiz->delete()) {
					echo 1;
				} else {
					echo 2;
				}
			}
		}
		exit;
	}
	

/*
 * @function name	: search
 * @purpose			: to serach a course according to a keyword by matching its title or subtitle
 * @arguments		: Following are the arguments to be passed:
		* keyword		: keyword to be searched
		* view			: define the view of listing
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/	
	function search($keyword = NULL, $view = 'List',$catid = NULL) {
		$this->layout = "frontend";	
		$this->loadModel("Category");
		$this->conditions = array();
		$this->conditions = array("Course.visibility"=>"Public","Course.status"=>1);
		$this->Course->order = 'Course.modified desc' ;
		/* code to remove hazardous code from keyword */
		$keyword = preg_replace('/[^a-zA-Z0-9 .-]/','',$keyword);
		if(!empty($keyword) && strtolower($keyword) != 'all') {
			//$category = $this->Category->find("first",array("conditions"=>array("LOWER(Replace(Category.title,' ','-'))"=>strtolower($keyword), "Category.status"=>1)));
			$catid = $this->params['pass']['1'];
			$category = $this->Category->find("first",array("conditions"=>array("Category.id"=>strtolower($catid), "Category.status"=>1)));
			if (!empty($category)) {
				$this->set("catid",$category['Category']['id']);
				if($category['Category']['id'] != 16) {
					$this->conditions = array_merge($this->conditions,array("Course.category_id like '%".$category['Category']['id']."%'"));
				}
				$this->set("header",$category['Category']['title']);
			} else { 
				$this->set("header",ucfirst($keyword));
			}
		} else {
			$this->set("catid","all");
			$this->set("header","All");
		}
		if (isset($this->data) && !empty($this->data)) {
			foreach($this->data['Course'] as $key=>$val) {
				$val = preg_replace('/[^a-zA-Z0-9 .-]/','',$val);
				if(!empty($val)) {
					if ($key == 'titles') {
						$this->conditions = array_merge($this->conditions,array("OR"=>array("Course.title like '%".$val."%'","Course.subtitle like '%".$val."%'","Course.keywords like '%".$val."%'","Course.summary like '%".$val."%'")));
						$this->set("catid","all");
						$this->set("header","All");
					} elseif ($key == 'viewPage') {
						$view = $this->data['Course']['viewPage']; // List / Grid
						continue;
					} elseif ($key == 'sort_option') {
						if($val == 'newest') {
							$this->Course->order = 'Course.created desc' ;
						} elseif($val == 'reviews') {
							$this->Course->order = 'Course.avgrating desc' ;
						} elseif($val == 'popular') {
							$this->Course->order = 'Course.students desc' ;
						} 
						continue;
					} else {
						$this->conditions = array_merge($this->conditions,array('Course.'.$key=>$val));
					}
				}
			}
			if(isset($this->params['named']['page']) && !empty($this->params['named']['page'])) {
				$this->Session->write("searchcond",$this->conditions);
				$this->redirect("/view-courses");
			}
		}
		
		if(isset($this->data) && empty($this->data)) {
			if(isset($this->params['named']['page']) && !empty($this->params['named']['page']) && $this->Session->read("searchcond")) {
				$this->conditions = $this->Session->read("searchcond");
			} elseif($this->Session->read("searchcond")) {
				//$this->conditions = $this->Session->read("searchcond");
			}
		}
		$this->Session->write("searchcond",$this->conditions);
		$this->Course->virtualFields = array(
		"students"=>"select count(*) from user_learning_courses CourseLearning where CourseLearning.course_id = Course.id",
		"avgrating"=>"select avg(CourseReview.rating) from course_reviews CourseReview where CourseReview.course_id = Course.id"
		);
		
		$this->conditions = array_merge($this->conditions,array("Course.publishstatus"=>"Publish"));
	//	pr($this->conditions);
		$this->Course->recursive = 0;
		$this->Course->bindModel(array("hasOne"=>array("Userdetail"=>array("className"=>"Userdetail","foreignKey"=>false,"conditions"=>"Course.user_id = Userdetail.user_id"))));
		$this->paginate = array(
			'conditions' => $this->conditions,
			'limit' => 10,
			'fields'=>'Course.*,Userdetail.user_id,Userdetail.first_name,Userdetail.last_name'
		);
		$this->set('courses', $this->paginate());
		$categories = $this->Category->find('list', array('conditions'=>'Category.status=1','order'=>'Category.sort,Category.title'));
		$languages = $this->Course->Language->find('list', array('conditions'=>'Language.status=1','order'=>'Language.title asc'));
		$this->set(compact('categories', 'languages', 'view'));
	}
/* end of function */	


/*
 * @function name	: publish
 * @purpose			: to publish a course
 * @arguments		: Following are the arguments to be passed:
		* courseid		: id of course to be published
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/	
	function publish($courseid = NULL) {
		$this->validatecourse($courseid,-1);
		if ($this->coursecount($courseid)) {
			$this->Course->id = $courseid;
			$course['Course']['publishstatus'] = 'Publish';
			if ($this->Course->save($course)) {
				$this->Session->setFlash("Course has been published.", 'default', array("class"=>"success_message"));
			} else {
				$this->Session->setFlash("Course can not be published.");
			}
		} else {
			$this->Session->setFlash("Atleast one lesson must be added before publishing the course");
		}
		$this->redirect($this->referer());
	}
/* end of function */	


/*
 * @function name	: unpublish
 * @purpose			: to unpublish a course
 * @arguments		: Following are the arguments to be passed:
		* courseid		: id of course to be unpublished
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/	
	function unpublish($courseid = NULL) {
		$this->validatecourse($courseid,-1);
		$this->Course->id = $courseid;
                $course = array();
		$course['Course']['publishstatus'] = 'Unpublish';
		if ($this->Course->save($course)) {
			$this->Session->setFlash("Course has been unpublished.", 'default', array("class"=>"success_message"));
		} else {
			$this->Session->setFlash("Course can not be unpublished.");
		}
		$this->redirect($this->referer());
	}
/* end of function */	


/*
 * @function name	: edit
 * @purpose			: to edit a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course to be edited
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: NA
*/
	public function edit($id = null) {
		$this->validatecourse($id,-1);
		$this->layout = "frontend";
	}
/* end of function */


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->bulkactions();
		/* code to perform search functionality */
		if(isset($this->data) && !empty($this->data['Course']['searchval'])){
			$this->Session->write('searchval',$this->data['Course']['searchval']);
			$this->conditions	= array("OR"=>array("Course.title like"=>"%".$this->data['Course']['searchval']."%"));
		}
		
		if(isset($this->params['named']['page'])){
			
			if($this->Session->read('searchval')){
				$this->conditions	= array("OR"=>array("Course.title like"=>"%".$this->Session->read('searchval')."%"));
				$this->data['Course']['searchval'] = $this->Session->read('searchval');
			}
		}elseif(empty($this->conditions)){
			$this->Session->delete('searchval');
		}
		/* end of code to perform search functionality */
		

		$this->Course->recursive = 0;
		$this->set('courses', $this->paginate($this->conditions));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		$this->set('course', $this->Course->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Course->create();
			if ($this->Course->save($this->request->data)) {
				$this->Session->setFlash(__('The course has been saved.'), 'default', array("class"=>"success_message"));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please, try again.'), 'default', array("class"=>"success_message"));
			}
		}
		$this->loadModel("Category");
		$categories = $this->Category->find('list', array('conditions'=>'Category.status=1'));
		$languages = $this->Course->Language->find('list', array('conditions'=>'Language.status=1'));
		$instructionLevels = $this->Course->InstructionLevel->find('list');
		$this->set(compact('categories', 'languages', 'instructionLevels'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Course->id = $id;
			$courseprice = $this->data;
			$this->loadModel('Userdetail');
			$this->Userdetail->recursive = -1;
			$data = $this->Userdetail->findByUserId($this->data['Userdetail']['user_id']);
			$data1['Userdetail']['paypalaccount'] = $this->data['Userdetail']['paypalaccount'];
			$this->Userdetail->id = $data['Userdetail']['id'];
			if($this->Userdetail->save($data1)) {
				
				if(isset($this->data['Course']['pricetype']) && $this->data['Course']['pricetype'] == 'Paid' ) {
					$courseprice['Course']['price'] = number_format($this->data['Course']['price'],"2",".","");
				} elseif(isset($this->data['Course']['pricetype']) && $this->data['Course']['pricetype'] == 'Free') {
					$courseprice['Course']['price'] = '0.00';
				}
				if ($this->Course->save($courseprice)) {
					$this->Session->setFlash(__('The course has been saved.'), 'default', array("class"=>"success_message"));
					$this->redirect(array("action"=>"index"));
				} else {
					$this->Session->setFlash(__('The course could not be saved. Please, try again.'));
				}
			} else {
				$this->Session->setFlash(__('The course could not be saved. Please, try again.'));
			}
			
			
		} else {
			$this->Course->recursive = -1;
			$this->request->data = $this->Course->read(null, $id);
		}
		if(isset($this->request->data['Course']['user_id'])) {
			$this->set("user_id",$this->request->data['Course']['user_id']);
			$this->set("paypal",$this->getpaypalemail($this->request->data['Course']['user_id']));
		} else {
			$this->set("user_id",$this->request->data['Userdetail']['user_id']);
			$this->set("paypal",$this->getpaypalemail($this->request->data['Userdetail']['user_id']));
		}
		$this->loadModel("Category");
		//$categories = $this->Category->find('list',array('conditions', array('conditions'=>'Category.status=1')));
		//$languages = $this->Course->Language->find('list',array('conditions'=>'Language.status=1'));
		//$instructionLevels = $this->Course->InstructionLevel->find('list');
		//$this->set(compact('categories', 'languages', 'instructionLevels'));
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
		$this->Course->id = $id;
		if (!$this->Course->exists()) {
			throw new NotFoundException(__('Invalid course'));
		}
		if ($this->Course->delete()) {
			$this->Session->setFlash(__('Course deleted.'), 'default', array("class"=>"success_message"));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Course was not deleted.'));
		$this->redirect(array('action' => 'index'));
	}


/*
 * @function name	: validatecourse
 * @purpose			: to edit a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course to be validated
		* recursive		: setting of course to be set by it
		* unbind		: list of model to be unbinded 
		* allow			: boolean argument to define if a user is allowed to see a particular page
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 15th july 2013
 * @description		: this function is basically perform a restriction to the course view from intruders, also identifies the instructors which are actualy not the creater of course but can acces some part of the course
*/	
	function validatecourse($id = NULL,$recursive = NULL,$unbind = array(),$allow = true) {
		if (!empty($recursive)) {
			$this->Course->recursive = $recursive;
		}
		if (!empty($unbind)) {
			$this->Course->unbindModel($unbind);
		}
		$this->loadModel("CourseInstructor");
		$this->CourseInstructor->recursive = -1;
		$coursinstructor = $this->CourseInstructor->find("first",array("conditions"=>array("CourseInstructor.course_id"=>$id,"CourseInstructor.user_id"=>$this->Session->read("Auth.User.id"))));
		if (empty($coursinstructor)) {
			$minecourse = $course = $this->Course->find("first",array("conditions"=>array("Course.id"=>$id,"Course.user_id"=>$this->Session->read("Auth.User.id"))));
		} else {
			$course = $this->Course->find("first",array("conditions"=>array("Course.id"=>$id)));
		}
		$this->set("usernames",$this->username($course['Course']['user_id']));
		
		if(!empty($minecourse)) {
			$this->request->data = $course;
		} elseif (empty($course) && empty($coursinstructor)) {
			//$this->Session->setFlash("Invalid Course");
			$this->redirect("/mycourses");
		} elseif($allow) {
			$this->request->data = $course;
		} elseif(!$allow && $course['Course']['user_id'] != $this->Session->read("Auth.User.id")) {
			$this->Session->setFlash("You are not authorized to view this page.");
			$this->redirect("/mycourses");
		} else {
			$this->request->data = $course;
			return $course['Course']['user_id'];
		}
	}
/* end of function */	


/*
 * @function name	: gettingstarted
 * @purpose			: to edit a course
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course to be validated
 * @return			: none
 * @created by		: sandeep kaur
 * @created on		: 25th july 2013
 * @description		: NA
*/
	public function gettingstarted($id=NULL){
		$this->validatecourse($id,-1);
		$this->layout='frontend';
		// for Coursesleft element
		
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array(
				"name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id",
				"designation"=>"select designation from userdetails Userdetail where Userdetail.user_id = Course.user_id"
				);
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.title","Course.user_id","Course.name","Course.publishstatus","Course.designation"),'conditions'=>array("Course.id"=>$id)));
		$this->set("title_for_layout","Course Guidelines - ".$userdetails['Course']['title']);
		$this->set(compact('userdetails'));
	}
/* end of function */


/**
 * liveSession method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function livesession(){
		$this->layout='frontend';
		// for Coursesleft element
		
		$this->Course->unBindModel(array("belongsTo"=>array("Category", "Language", "InstructionLevel"), "hasMany"=>array("CourseAudience", "CourseGoal", "CourseInstructor", "CourseInvitee", "CoursePassword", "CourseRequirement", "CourseSection", "CourseLecture", "UserLearningCourse", "UserWishlistCourse", "UserViewCourse", "CourseReview")));
		$this->Course->virtualFields = array("name"=>"select CONCAT(Userdetail.first_name,' ',Userdetail.last_name) from userdetails Userdetail where Userdetail.user_id = Course.user_id");
		$userdetails = $this->Course->find('first',array('fields'=>array("Course.id","Course.title","Course.name","Course.publishstatus"),'conditions'=>array("Course.user_id"=>$this->Session->read("Auth.User.id"))));
		
		$this->set(compact('categories', 'languages','userdetails'));
	}


/*
 * @function name	: viewlisting
 * @purpose			: to view question, notes on view lecture page
 * @arguments		: Following are the arguments to be passed:
		* id			: id of course to be validated
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 25th july 2013
 * @description		: NA
*/	
	function viewlisting($courseid = NULL, $type = NULL) {
		if($this->RequestHandler->isAjax()) {
			if ($this->request->data['type'] == 'notes') {
				$this->loadModel("CourseUserNote");
				$coursenotes = $this->CourseUserNote->find("all",array("conditions"=>array("CourseUserNote.user_id"=>$this->Session->read("Auth.User.id"),"CourseUserNote.course_section_id"=>$this->request->data['Course']['course_section_id']),"order"=>"CourseUserNote.created"));
				$this->set("data",$coursenotes);
			}
			if ($this->request->data['type'] == 'questions') {
				$this->loadModel("CourseUserQuestion");
				$this->CourseUserQuestion->virtualFields = array("firstname"=>"select Userdetail.first_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
				"lastname"=>"select Userdetail.last_name from userdetails Userdetail where Userdetail.user_id = CourseUserQuestion.user_id",
				"lectureindex"=>"select lecture_index from course_lectures where course_lectures.id = CourseUserQuestion.course_lecture_id"
				); 
				//$coursequestions = $this->CourseUserQuestion->find("all",array("conditions"=>array("CourseUserQuestion.user_id"=>$this->Session->read("Auth.User.id"),"CourseUserQuestion.course_id"=>$this->request->data['Course']['course_id']),"order"=>"CourseUserQuestion.created desc"));
				$coursequestions = $this->CourseUserQuestion->find("all",array("conditions"=>array("CourseUserQuestion.course_id"=>$this->request->data['Course']['course_id']),"order"=>"CourseUserQuestion.created desc"));
				$this->set("data",$coursequestions);
			}
			$this->set("type",$this->request->data['type']);
		}
	}
/* end of function */


/*
 * @function name	: takecourse
 * @purpose			: to take a course as learning
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course to be validated
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 25th july 2013
 * @description		: NA
*/	
	function takecourse($courseid = NULL,$flag = false) {
		$this->render = false;
		$this->Course->recursive = -1;
		$course = $this->Course->find("first",array("conditions"=>array("Course.id"=>$courseid,"Course.publishstatus"=>"Publish")));
		$this->loadModel("UserLearningCourse");
		$this->UserLearningCourse->recursive = -1;
		$usercourses = $this->UserLearningCourse->find("first",array("conditions"=>array("UserLearningCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserLearningCourse.course_id"=>$courseid)));
		if (!empty($usercourses) && $flag) {
			$this->set("usercourse",1);
			return true;
		} elseif(!$flag) {
			if (!empty($course)) {
				if ( empty($course['Course']['pricetype']) || trim(strtolower($course['Course']['pricetype'])) == 'free') {
					$usercourse['UserLearningCourse']['course_id'] = $courseid;
					$usercourse['UserLearningCourse']['user_id'] = $this->Session->read("Auth.User.id");
					$this->UserLearningCourse->create();
					$this->UserLearningCourse->save($usercourse);
					$this->markcoursetaken($courseid,$this->Session->read("Auth.User.id"));
					$this->redirect("/successfuly-enrolled/".$courseid);
				} elseif( trim(strtolower($course['Course']['pricetype'])) == 'paid' ) {
					$usercourse['UserLearningCourse']['course_id'] = $courseid;
					$usercourse['UserLearningCourse']['user_id'] = $this->Session->read("Auth.User.id");
					$this->redirect("/make-payment/".$courseid);
				}
			} else {
				$this->redirect("/c/".$courseid."/".str_replace(' ','-',strtolower($course['Course']['title'])));
			}
		}
	}
/* end of function */


/*
 * @function name	: markcoursetaken
 * @purpose			: to mark course as taken instead of wishlist
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course to be validated
		* userid			: id of user taking a course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 25th july 2013
 * @description		: NA
*/	
	private function markcoursetaken($courseid = NULL,$userid = NULL) {
		$this->loadModel("UserWishlistCourse");
		$this->UserWishlistCourse->recursive = -1;
		$wishlistcourse = $this->UserWishlistCourse->find("first",array("conditions"=>array("UserWishlistCourse.course_id"=>$courseid,"UserWishlistCourse.user_id"=>$userid)));
		if (!empty($wishlistcourse)) {
			$this->UserWishlistCourse->create();
			$this->UserWishlistCourse->id = $wishlistcourse['UserWishlistCourse']['id'];
			$this->UserWishlistCourse->delete();
		}
	}
/* end of function */


/*
 * @function name	: successfullyenrolled
 * @purpose			: to show confirmation page after enrolling
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id of course to be validated
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 25th july 2013
 * @description		: NA
*/	
	function successfullyenrolled($courseid = NULL) {
		$this->layout = "frontend";
		$this->Course->recursive = -1;
		$course = $this->Course->find("first",array("conditions"=>array("Course.id"=>$courseid,"Course.publishstatus"=>"Publish")));
		$this->loadModel("UserLearningCourse");
		$this->UserLearningCourse->recursive = -1;
		$usercourses = $this->UserLearningCourse->find("first",array("conditions"=>array("UserLearningCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserLearningCourse.course_id"=>$courseid)));
		if (!empty($course) && !empty($usercourses)) {
			$this->loadModel("CourseLecture");
			$courselec = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.course_id"=>$courseid)));
			$this->set("courselec",$courselec);
			$this->set("course",$course);
			$this->set("usercourses",$usercourses);
		} else {
			$this->redirect("/c/".$courseid."/".str_replace(' ','-',strtolower($course['Course']['title'])));
		}
	}
/* end of function */


/*
 * @function name	: relatedcourses
 * @purpose			: to wishlist, my courses, completed and learning courses
 * @arguments		: Following are the arguments to be passed:
		* type			: type to define which page will be displayed
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 25th july 2013
 * @description		: NA
*/	
	function relatedcourses($type = NULL) {
		$this->layout = "frontend";
		
		switch($type) {
			case "w" :
				$this->loadModel("UserWishlistCourse");
				$this->UserWishlistCourse->unbindModel(array("belongsTo"=>array("User")));
				$this->conditions = array("UserWishlistCourse.user_id"=>$this->Session->read("Auth.User.id"));
				$model = "UserWishlistCourse";
				$heading = 'My Wishlist';
			break;
			case "l" :
				$this->loadModel("UserLearningCourse");
				$this->UserLearningCourse->unbindModel(array("belongsTo"=>array("User")));
				$this->conditions = array("UserLearningCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserLearningCourse.completed"=>0);
				$model = "UserLearningCourse";
				$heading = 'Enrolled Courses';
			break;
			case "c" :
				$this->loadModel("UserLearningCourse");
				$this->UserLearningCourse->unbindModel(array("belongsTo"=>array("User")));
				$this->conditions = array("UserLearningCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserLearningCourse.completed"=>1);
				$model = "UserLearningCourse";
				$this->set("errmsg","You haven't completed any courses!");
				$heading = 'Completed Courses';
			break;
			case "t" :
				$this->loadModel("Course");
				$this->Course->unbindModel(array("belongsTo"=>array("User"), "hasMany"=>array("CourseAudience", "CourseGoal","CourseInstructor", "CourseInvitee", "CoursePassword","CourseRequirement","CourseSection","CourseLecture","UserLearningCourse","UserWishlistCourse","UserViewCourse","CourseReview")));
				$this->conditions = array("Course.user_id"=>$this->Session->read("Auth.User.id"));
				$model = "Course";
				$heading = 'Teaching Courses';
				$this->set("mycourse","1");
			break;
			default :
				$this->loadModel("Course");
				$this->Course->unbindModel(array("belongsTo"=>array("User"), "hasMany"=>array("CourseAudience", "CourseGoal","CourseInstructor", "CourseInvitee", "CoursePassword","CourseRequirement","CourseSection","CourseLecture","UserLearningCourse","UserWishlistCourse","UserViewCourse","CourseReview")));
				$this->conditions = array("Course.user_id"=>$type);
				$model = "Course";
				$heading = 'Teaching Courses';
				$this->set("mycourse","1");
			break;
		}
		$this->set("title_for_layout",$heading);
		if($model == 'UserLearningCourse') {
			$this->$model->virtualFields = array("name"=>"select concat(Userdetail.first_name,' ',Userdetail.last_name) as name from userdetails as Userdetail where Userdetail.user_id = Course.user_id",
			"completelecture"=>"select count(*) from user_complete_course_lectures where user_complete_course_lectures.course_id = Course.id and user_complete_course_lectures.user_id = ".$this->Session->read("Auth.User.id"),
			"totallecture"=>"select count(*) from course_lectures where course_lectures.course_id = Course.id",
			"totalstudents"=>"select count(*) from user_learning_courses ULC where ULC.course_id = Course.id",
			"avgrating"=>"select avg(rating) from course_reviews CRS where CRS.course_id = Course.id"
			);
			$this->paginate = array("limit"=>20,
				"fields"=>array("Course.title","Course.subtitle","Course.keywords","Course.coverimage","Course.promovideo","Course.summary","Course.id","Course.created","Course.modified","Course.pricetype","Course.price","Course.user_id",$model.".name",$model.".completelecture",$model.".totallecture",$model.".totalstudents",$model.".avgrating")				
			);
		} elseif($model != 'UserWishlistCourse') {
			$this->$model->virtualFields = array("name"=>"select concat(Userdetail.first_name,' ',Userdetail.last_name) as name from userdetails as Userdetail where Userdetail.user_id = Course.user_id",
			"totalstudents"=>"select count(*) from user_learning_courses ULC where ULC.course_id = Course.id",
			"avgrating"=>"select avg(rating) from course_reviews CRS where CRS.course_id = Course.id");
			$this->paginate = array("limit"=>20,
				"fields"=>array("Course.title","Course.subtitle","Course.keywords","Course.coverimage","Course.promovideo","Course.summary","Course.id","Course.created","Course.modified","Course.pricetype","Course.price","Course.user_id",$model.".name",$model.".totalstudents",$model.".avgrating")
			);
		} else {
			$this->$model->virtualFields = array("name"=>"select concat(Userdetail.first_name,' ',Userdetail.last_name) as name from userdetails as Userdetail where Userdetail.user_id = Course.user_id",
			"totalstudents"=>"select count(*) from user_learning_courses ULC where ULC.course_id = Course.id",
			"avgrating"=>"select avg(rating) from course_reviews CRS where CRS.course_id = Course.id"
			);
			$this->paginate = array("limit"=>20,
				"fields"=>array("Course.title","Course.subtitle","Course.keywords","Course.coverimage","Course.promovideo","Course.summary","Course.id","Course.created","Course.modified","Course.pricetype","Course.price","Course.user_id",$model.".name",$model.".totalstudents",$model.".avgrating")
			);
		}
		$this->set("url","mycourses");
		
		// get count of wishlist, teaching etc
		$this->loadmodel("Userdetail");
		
		$this->Userdetail->virtualFields = array(
			"wishlist"=>"Select count(*) from user_wishlist_courses as Wishlistcourse where Wishlistcourse.user_id = Userdetail.user_id",
			"learning"=>"Select count(*) from user_learning_courses as Learningcourse where Learningcourse.user_id = Userdetail.user_id and Learningcourse.completed = 0",
			"completed"=>"Select count(*) from user_learning_courses as Learningcourse where Learningcourse.user_id = Userdetail.user_id and Learningcourse.completed = 1",
			"countcourse"=>"Select count(*) from courses as Course where Course.user_id = Userdetail.user_id"
		);
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$this->Session->read("Auth.User.id")),"fields"=>array("Userdetail.wishlist","Userdetail.learning","Userdetail.completed","Userdetail.countcourse")),array("recursive"=>0));
		$this->set('user',$user[0]);
		
		$this->set("heading",$heading);
		$this->paginate = array("order"=>"Course.created desc");
		$this->set("courses",$this->paginate($model,$this->conditions));
	}
/* end of function */


/*
 * @function name	: userrelatedcourses
 * @purpose			: to wishlist, my courses, completed and learning courses
 * @arguments		: Following are the arguments to be passed:
		* type			: type to define which page will be displayed
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 25th july 2013
 * @description		: NA
*/	
	function userrelatedcourses($type = NULL, $userid = NULL) {
		$this->layout = "frontend";
		switch($type) {
			case "w" :
				$this->loadModel("UserWishlistCourse");
				$this->UserWishlistCourse->unbindModel(array("belongsTo"=>array("User")));
				$this->conditions = array("UserWishlistCourse.user_id"=>$userid);
				$model = "UserWishlistCourse";
				$heading = 'Wishlist';
			break;
			case "l" :
				$this->loadModel("UserLearningCourse");
				$this->UserLearningCourse->unbindModel(array("belongsTo"=>array("User")));
				$this->conditions = array("UserLearningCourse.user_id"=>$userid,"UserLearningCourse.completed"=>0);
				$model = "UserLearningCourse";
				$heading = 'Learning Courses';
			break;
			case "c" :
				$this->loadModel("UserLearningCourse");
				$this->UserLearningCourse->unbindModel(array("belongsTo"=>array("User")));
				$this->conditions = array("UserLearningCourse.user_id"=>$userid,"UserLearningCourse.completed"=>1);
				$model = "UserLearningCourse";
				$this->set("errmsg","You haven't completed any courses!");
				$heading = 'Completed Courses';
			break;
			case "t" :
				$this->loadModel("Course");
				$this->Course->unbindModel(array("belongsTo"=>array("User"), "hasMany"=>array("CourseAudience", "CourseGoal","CourseInstructor", "CourseInvitee", "CoursePassword","CourseRequirement","CourseSection","CourseLecture","UserLearningCourse","UserWishlistCourse","UserViewCourse","CourseReview")));
				$this->conditions = array("Course.user_id"=>$userid);
				$model = "Course";
				$heading = 'Teaching Courses';
				$this->set("mycourse","1");
			break;
		}
		$this->set("title_for_layout",$heading);
		if($model == 'UserLearningCourse') {
			$this->$model->virtualFields = array("name"=>"select concat(Userdetail.first_name,' ',Userdetail.last_name) as name from userdetails as Userdetail where Userdetail.user_id = Course.user_id",
			"completelecture"=>"select count(*) from user_complete_course_lectures where user_complete_course_lectures.course_id = Course.id",
			"totallecture"=>"select count(*) from courses where courses.id = Course.id","totalstudents"=>"select count(*) from user_learning_courses ULC where ULC.course_id = Course.id",
			"avgrating"=>"select avg(rating) from course_reviews CRS where CRS.course_id = Course.id"
			);
			$this->paginate = array("limit"=>1,
				"fields"=>array("Course.title","Course.subtitle","Course.keywords","Course.coverimage","Course.promovideo","Course.summary","Course.id","Course.created","Course.modified","Course.pricetype","Course.price","Course.user_id",$model.".name",$model.".completelecture",$model.".totallecture",$model.".totalstudents",$model.".avgrating")				
			);
		} elseif($model != 'UserWishlistCourse') {
			$this->$model->virtualFields = array("name"=>"select concat(Userdetail.first_name,' ',Userdetail.last_name) as name from userdetails as Userdetail where Userdetail.user_id = Course.user_id",
			"totalstudents"=>"select count(*) from user_learning_courses ULC where ULC.course_id = Course.id",
			"avgrating"=>"select avg(rating) from course_reviews CRS where CRS.course_id = Course.id");
			$this->paginate = array("limit"=>1,
				"fields"=>array("Course.title","Course.subtitle","Course.keywords","Course.coverimage","Course.promovideo","Course.summary","Course.id","Course.created","Course.modified","Course.pricetype","Course.price","Course.user_id",$model.".name",$model.".totalstudents",$model.".avgrating")
			);
		} else {
			$this->$model->virtualFields = array("name"=>"select concat(Userdetail.first_name,' ',Userdetail.last_name) as name from userdetails as Userdetail where Userdetail.user_id = Course.user_id",
			"totalstudents"=>"select count(*) from user_learning_courses ULC where ULC.course_id = Course.id",
			"avgrating"=>"select avg(rating) from course_reviews CRS where CRS.course_id = Course.id"
			);
			$this->paginate = array("limit"=>1,
				"fields"=>array("Course.title","Course.subtitle","Course.keywords","Course.coverimage","Course.promovideo","Course.summary","Course.id","Course.created","Course.modified","Course.pricetype","Course.price","Course.user_id",$model.".name",$model.".totalstudents",$model.".avgrating")
			);
		}
		
		
		// get count of wishlist, teaching etc
		$this->loadmodel("Userdetail");
		
		$this->Userdetail->virtualFields = array(
			"wishlist"=>"Select count(*) from user_wishlist_courses as Wishlistcourse where Wishlistcourse.user_id = Userdetail.user_id",
			"learning"=>"Select count(*) from user_learning_courses as Learningcourse where Learningcourse.user_id = Userdetail.user_id and Learningcourse.completed = 0",
			"completed"=>"Select count(*) from user_learning_courses as Learningcourse where Learningcourse.user_id = Userdetail.user_id and Learningcourse.completed = 1",
			"countcourse"=>"Select count(*) from courses as Course where Course.user_id = Userdetail.user_id"
		);
		$user = $this->Userdetail->find("all",array("conditions"=>array("User.id"=>$userid),"fields"=>array("Userdetail.wishlist","Userdetail.learning","Userdetail.completed","Userdetail.countcourse","Userdetail.user_id")),array("recursive"=>0));
		$this->set('user',$user[0]);
		
		$this->set("heading",$heading);
		$this->set("courses",$this->paginate($model,$this->conditions));
		$this->set("others",1);
		$this->render('relatedcourses');
	}
/* end of function */


/*
 * @function name	: viewratings
 * @purpose			: to view all rating for a course
 * @arguments		: Following are the arguments to be passed:
		* courseid		: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 4th august 2013
 * @description		: NA
*/		
	function viewratings($courseid = NULL) {
		$this->layout = "frontend";
		if(!empty($courseid)) {
			$this->set("title_for_layout","Reviews for ".$this->course($courseid));
			$this->getcoursereviews($courseid,true);
		} else {
			$this->Session->setFlash("Invalid course");
		}
	}
/* end of function */


/*
 * @function name	: viewrecent
 * @purpose			: to view all recently viewed courses
 * @arguments		: Following are the arguments to be passed:
		* courseid		: id of course
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 4th august 2013
 * @description		: NA
*/			
	function viewrecent($courseid = NULL) {
		$this->layout = "frontend";
		$this->getmoreviewedcourses($courseid,true);
	}
/* end of function */


/*
 * @function name	: viewallcourse
 * @purpose			: to view all courses by a user
 * @arguments		: Following are the arguments to be passed:
		* userid		: id of user
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 4th august 2013
 * @description		: NA
*/			
	function viewallcourse($userid = NULL) {
		$this->layout = "frontend";
		$this->set("title_for_layout","All Courses By ".ucwords($this->username($userid)));
		$this->set("name",ucwords($this->username($userid)));
		if(!empty($userid)) {
			$this->allcoursesbyuser($userid,false);
		} else {
			$this->Session->setFlash("Invalid request.");
		}
	}
/* end of function */


/*
 * @function name	: getvideopreview
 * @purpose			: to add external video for a lecture
 * @arguments		: Following are the arguments to be passed:
		* link			: link to youtube/vimeo
		* lectid		: id of lecture to be uploaded
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 4th august 2013
 * @description		: NA
*/	
	function getvideopreview($link = NULL,$lectid = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$link = $this->request->data['link'];
			$res = $this->video_info($link);
			$linkid = $res['video_id'];
			$type = $res['video_type'];
			$title = $res['title'];
			/*if(strstr($link,'youtube')) {
				$linkid = explode("=",$this->request->data['link']);
				$linkid = $linkid[count($linkid)-1];
				$type	= "youtube";
			} else {
				$linkid = explode("/",$this->request->data['link']);
				$linkid = $linkid[count($linkid)-1];
				$type	= "vimeo";
			}*/
			$ids = explode("_",$this->request->data['lectid']);
			$this->set("linkid",$linkid);
			$this->set("videoid",$this->request->data['lectid']);
			$this->set("type",$type);
			$this->set("title",$title);
			$this->set("ids",$ids);
		}
	}
/* end of function */


/*
 * @function name	: getlibcontent
 * @purpose			: function to get content for library to display on add course content
 * @arguments		: Following are the arguments to be passed:
		* userid			: id of user who is updating lecture
		* lecturetype		: type of lecture to be uploaded
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 4th august 2013
 * @description		: NA
*/	
	function getlibcontent($userid = NULL, $lecturetype = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$userid = $this->request->data['userid'];
			$lecturetype = ucfirst($this->request->data['lecturetype']);
			$this->loadModel("CourseLecture");
			$this->CourseLecture->unbindModel(array("belongsTo"=>array("Course","CourseSection")));
			$this->CourseLecture->recursive = 0;
			$this->CourseLecture->create();
			if ($lecturetype != 'All') {
				$this->CourseLecture->bindModel(array("belongsTo"=>array("Course"=>array("className"=>"Course","foreignKey"=>"course_id"),"Courses"=>array("className"=>"Course","foreignKey"=>false,"conditions"=>"Course.user_id = Courses.user_id"))));
				$data = $this->CourseLecture->find("all",array("conditions"=>array("Course.user_id"=>$userid,"CourseLecture.content_type"=>$lecturetype),"fields"=>array("distinct(CourseLecture.id),CourseLecture.course_id,CourseLecture.content_source,CourseLecture.heading")));
			} else {
				$this->CourseLecture->bindModel(array("belongsTo"=>array("Course"=>array("className"=>"Course","foreignKey"=>"course_id"),"Courses"=>array("className"=>"Course","foreignKey"=>false,"conditions"=>"Course.user_id = Courses.user_id"))));
				$data = $this->CourseLecture->find("all",array("conditions"=>array("Course.user_id"=>$userid,"CourseLecture.content_type <>"=>'M'),"fields"=>array("distinct(CourseLecture.id),CourseLecture.course_id,CourseLecture.content_source,CourseLecture.heading")));
			}
			$this->set("data",$data);
			$this->set("type",$lecturetype);
			$this->set("lecid",$this->request->data['lectureid']);
		}
	}
/* end of function */


/*
 * @function name	: insertfromlibrary
 * @purpose			: function to get content for library to display on add course content
 * @arguments		: Following are the arguments to be passed:
		* lectureid			: id of lecture which is being updated
		* currentlecture	: the lecture from which content is being updated
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 4th august 2013
 * @description		: NA
*/
	function insertfromlibrary($lectureid = NULL, $currentlecture = NULL) {
		if ($this->RequestHandler->isAjax()) {
			$this->loadModel("CourseLecture");
			$this->CourseLecture->recursive = 0;
			$olddata = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.id"=>$this->request->data['lectureid'])));
			$newdata = $this->CourseLecture->find("first",array("conditions"=>array("CourseLecture.id"=>$this->request->data['curlec'])));
			$src = $newdata['Course']['user_id']."/Course".$newdata['Course']['id']."/Section".$newdata['CourseLecture']['course_section_id']."/Lecture".$newdata['CourseLecture']['id'];
			if ($this->request->data['value'] != 'All') {
				$this->CourseLecture->id = $this->request->data['curlec'];
				if ($olddata['CourseLecture']['content_type'] == 'V' && $olddata['CourseLecture']['content_external_link'] == 'None') {
					$this->copyfromlibrary($olddata['CourseLecture']['content_source'],$src,$olddata['Course']['user_id'],true);
					$courselecdata['CourseLecture']['content_source'] = str_replace(WWW_ROOT," ",$this->uploaddir.$this->imagename);
					$courselecdata['CourseLecture']['content_type'] = $olddata['CourseLecture']['content_type'];
				}
				if ($olddata['CourseLecture']['content_type'] == 'A') {
					$this->copyfromlibrary($olddata['CourseLecture']['content_source'],$src,$olddata['Course']['user_id']);
					$courselecdata['CourseLecture']['content_source'] = str_replace(WWW_ROOT," ",$this->uploaddir.$this->imagename);
					$courselecdata['CourseLecture']['content_type'] = $olddata['CourseLecture']['content_type'];
				}
				if ($olddata['CourseLecture']['content_type'] == 'P' || $olddata['CourseLecture']['content_type'] == 'D') {
					$this->copyfromlibrary($olddata['CourseLecture']['content_source'],$src,$olddata['Course']['user_id']);
					$courselecdata['CourseLecture']['content_source'] = str_replace(WWW_ROOT," ",$this->uploaddir.$this->imagename);
					$courselecdata['CourseLecture']['content_type'] = $olddata['CourseLecture']['content_type'];
				}
				if($olddata['CourseLecture']['content_external_link'] == 'Youtube' || $olddata['CourseLecture']['content_external_link'] == 'Vimeo') {
					$courselecdata['CourseLecture']['content_source'] = $olddata['CourseLecture']['content_source'];
					$courselecdata['CourseLecture']['content_external_link'] = $olddata['CourseLecture']['content_external_link'];
					$courselecdata['CourseLecture']['content_type'] = $olddata['CourseLecture']['content_type'];
				}
				if ($this->CourseLecture->save($courselecdata)) {
					echo "2";
				} else {
					echo "1";
				}
			} else {
				$this->loadModel('CourseSuppliment');
				if ($olddata['CourseLecture']['content_type'] == 'V' && $olddata['CourseLecture']['content_external_link'] == 'None') {
					$this->copyfromlibrary($olddata['CourseLecture']['content_source'],$src,$olddata['Course']['user_id'],true);
					$courselecdata['CourseSuppliment']['course_lecture_id'] = $newdata['CourseLecture']['id'];
					$courselecdata['CourseSuppliment']['content_title'] = $this->imagename;
					$courselecdata['CourseSuppliment']['content_source'] = str_replace(WWW_ROOT," ",$this->uploaddir.$this->imagename);
				}
				if ($olddata['CourseLecture']['content_type'] == 'A') {
					$courselecdata['CourseSuppliment']['course_lecture_id'] = $newdata['CourseLecture']['id'];
					$this->copyfromlibrary($olddata['CourseLecture']['content_source'],$src,$olddata['Course']['user_id']);
					$courselecdata['CourseSuppliment']['content_source'] = str_replace(WWW_ROOT," ",$this->uploaddir.$this->imagename);
					$courselecdata['CourseSuppliment']['content_title'] = $this->imagename;
				}
				if ($olddata['CourseLecture']['content_type'] == 'P' || $olddata['CourseLecture']['content_type'] == 'D') {
					$courselecdata['CourseSuppliment']['course_lecture_id'] = $newdata['CourseLecture']['id'];
					$this->copyfromlibrary($olddata['CourseLecture']['content_source'],$src,$olddata['Course']['user_id']);
					$courselecdata['CourseSuppliment']['content_source'] = str_replace(WWW_ROOT," ",$this->uploaddir.$this->imagename);
					$courselecdata['CourseSuppliment']['content_title'] = $this->imagename;
				}
				if($olddata['CourseLecture']['content_external_link'] == 'Youtube' || $olddata['CourseLecture']['content_external_link'] == 'Vimeo') {
					$courselecdata['CourseSuppliment']['course_lecture_id'] = $newdata['CourseLecture']['id'];
					//$courselecdata['CourseSuppliment']['content_source'] = $olddata['CourseLecture']['content_source'];
					$courselecdata['CourseSuppliment']['content_link'] = $olddata['CourseLecture']['content_external_link'];
					$courselecdata['CourseSuppliment']['content_title'] = 'External File';
				}
				if ($this->CourseSuppliment->save($courselecdata)) {
					echo "2";
				} else {
					echo "1";
				}
			}
		}
		$this->render(false);
	}
/* end of function */


	function addexternalupload() {
		if ($this->RequestHandler->isAjax()) {
			if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->request->data['link'])) {
				$this->loadModel('CourseSuppliment');
				$courselecdata['CourseSuppliment']['course_lecture_id'] = $this->request->data['lectureid'];
				$courselecdata['CourseSuppliment']['content_link'] = $this->request->data['link'];
				$courselecdata['CourseSuppliment']['content_title'] = 'External File';
				if ($this->CourseSuppliment->save($courselecdata)) {
					echo "1";
				} else {
					echo "2";
				}
			}
			else {
			  echo "3";
			}
		}
		$this->render(false);
	}
	

/*
 * @function name	: makepayment
 * @purpose			: function to make payment using paypal as direct payment
 * @arguments		: Following are the arguments to be passed:
		* courseid			: id course for which payment is going to initiate
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 4th august 2013
 * @description		: NA
*/
	function makepayment($courseid = NULL) {
		$this->layout = "frontend";
		$this->Course->recursive = -1;
		$course = $this->Course->find("first",array("conditions"=>array("Course.id"=>$courseid,"Course.publishstatus"=>"Publish")));
		
		/* course to check if user own a course or already taken course */
		$this->loadModel("UserLearningCourse");
		$this->UserLearningCourse->recursive = -1;
		$usercourses = $this->UserLearningCourse->find("first",array("conditions"=>array("UserLearningCourse.user_id"=>$this->Session->read("Auth.User.id"),"UserLearningCourse.course_id"=>$courseid)));
		if (!empty($course) && empty($usercourses)) {
			$this->set("course",$course);
			$this->set("usercourses",$usercourses);
			/* code to test the payment request here */
			$instructors = $this->getallusercommission($courseid);
			$this->PayChained->cancelurl = $this->PayChained->returnurl = SITE_LINK."c/".$courseid."/".str_replace(' ','-',strtolower($course['Course']['title']));
			$this->PayChained->notifyurl = SITE_LINK."ipnhandler/".$this->Session->read("Auth.User.id")."/".$courseid;
			$res = $this->PayChained->makepayment($instructors);
			//pr($res);
			//die;
			/* end here */
			if($res['Ack'] == 'Success' && $res['PaymentExecStatus'] == 'CREATED') {
				$this->redirect($res['RedirectURL']);
			} else {
				$this->Session->setFlash("You can not take this course currently, Please try again later.");
				//$this->Session->setFlash($res);
				$this->redirect("/c/".$courseid."/".str_replace(' ','-',strtolower($course['Course']['title'])));
			}
		} else {
			$this->redirect("/c/".$courseid."/".str_replace(' ','-',strtolower($course['Course']['title'])));
		}
		/* end here */
		$this->render(false);
	}
/* end of function */
	
	function ipnhandler($userid = NULL, $courseid = NULL) {
		// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
		// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
		// Set this to 0 once you go live or don't require logging.
		define("DEBUG", 0);

		// Set to 0 once you're ready to go live
		if(API_MODE == 'sandbox') {
			define("USE_SANDBOX", 1);
		} else {
			define("USE_SANDBOX", 0);
		}


		define("LOG_FILE", WWW_ROOT."ipn.log");


		// Read POST data
		// reading posted data directly from $_POST causes serialization
		// issues with array data in POST. Reading raw POST data from input stream instead.
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) {
		$keyval = explode ('=', $keyval);
		if (count($keyval) == 2)
			$myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) {
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value) {
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
				$value = urlencode(stripslashes($value));
			} else {
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}

		// Post IPN data back to PayPal to validate the IPN data is genuine
		// Without this step anyone can fake IPN data

		if(USE_SANDBOX == true) {
			$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
		} else {
			$paypal_url = "https://www.paypal.com/cgi-bin/webscr";
		}

		$ch = curl_init($paypal_url);
		if ($ch == FALSE) {
			return FALSE;
		}

		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

		if(DEBUG == true) {
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
		}

		// CONFIG: Optional proxy configuration
		//curl_setopt($ch, CURLOPT_PROXY, $proxy);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

		// Set TCP timeout to 30 seconds
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

		// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
		// of the certificate as shown below. Ensure the file is readable by the webserver.
		// This is mandatory for some environments.

		//$cert = WWW_ROOT."cacert.pem";
		//curl_setopt($ch, CURLOPT_CAINFO, $cert);

		$res = curl_exec($ch);
		if (curl_errno($ch) != 0) // cURL error
		{
			if(DEBUG == true) {	
				error_log(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
			}
			curl_close($ch);
			exit;

		} else {
			// Log the entire HTTP response if debug is switched on.
			if(DEBUG == true) {
			error_log(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
			error_log(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);

			// Split response headers and payload
			list($headers, $res) = explode("\r\n\r\n", $res, 2);
			}
			curl_close($ch);
		}

		// Inspect IPN validation result and act accordingly

		if (strcmp ($res, "VERIFIED") == 0) {
			$this->loadModel("UserLearningCourse");
			/*$datas['Payment']['logs'] = serialize($raw_post_array);
			$this->Payment->create();
			$this->Payment->save($datas);*/
			$this->UserLearningCourse->recursive = -1;
			$usercourses = $this->UserLearningCourse->find("first",array("conditions"=>array("UserLearningCourse.user_id"=>$userid,"UserLearningCourse.course_id"=>$courseid)));
			$this->Course->recursive = -1;
			$course = $this->Course->find("first",array("conditions"=>array("Course.id"=>$courseid,"Course.publishstatus"=>"Publish")));
			if(empty($usercourses)) {
				$this->loadModel("Order");
				$order['Order']['buyer_id']		= $userid;
				$order['Order']['course_id']	= $courseid;
				$order['Order']['paymentref']	= $_POST['txn_id'];
				$order['Order']['paymentnote']	= 'Enrolled to a new course';
				$order['Order']['invoice']		= $this->createinvoice($this->Session->read("Auth.User.id"));
				$order['Order']['paymentstatus']= 1;
				$order['Order']['payment']		= $course['Course']['price'];
				$suborder = array();
				if ($this->Order->save($order)) {
					$orderid = $this->Order->getLastInsertId();
					$instructors = $this->getallusercommission($courseid);
					$i = 0;
					foreach($instructors as $responsekey=>$responseval) {
						if(!empty($responseval['userid'])) {
							$suborder[$i]['Order']['seller_id']	    = $responseval['userid'];
							$suborder[$i]['Order']['course_id']	    = $courseid;
							$suborder[$i]['Order']['order_id']		= $orderid;
							$suborder[$i]['Order']['paymentref']	= $_POST['txn_id'];
							$suborder[$i]['Order']['paymentnote']	= 'Enrollment fees for course ';
							//$suborder[$i]['Order']['invoice']		= $this->createinvoice($responseval['userid']);
							$suborder[$i]['Order']['paymentstatus'] = 1;
							$suborder[$i]['Order']['payment']		= $responseval['amount'];
							$i++;
						}
					}
					if(!empty($suborder)) {
						$this->Order->create();
						$this->Order->saveAll($suborder);
					}
					$userlearning['UserLearningCourse']['user_id']		= $userid;
					$userlearning['UserLearningCourse']['course_id']	= $courseid;
					$userlearning['UserLearningCourse']['completed']	= 0;
					$this->UserLearningCourse->create();
					$this->UserLearningCourse->save($userlearning);
					$this->markcoursetaken($courseid,$userid);
					/* code to send email for enrolling the course */
					$user 			= $this->username($userid);
					$useremail		= $this->useremail($userid);
					$instructor		= $this->username($course['Course']['user_id']);
					$instemail		= $this->useremail($course['Course']['user_id']);
					$courselink		= "<a href=".SITE_LINK."c/".$courseid."/".$this->makeurl($course['Course']['title']).">".$course['Course']['title']."</a>";
					$this->getmaildata(12);
					$this->mailBody = str_replace("{USER}",$user,$this->mailBody);
					$this->mailBody = str_replace("{COURSE}",$courselink,$this->mailBody);
					$this->sendmail($useremail);
					$this->getmaildata(13);
					$this->mailBody = str_replace("{USER}",$instructor,$this->mailBody);
					$this->mailBody = str_replace("{STUDENT}",$user,$this->mailBody);
					$this->mailBody = str_replace("{COURSE}",$courselink,$this->mailBody);
					$this->sendmail($instemail);
					/* code to send email for enrolling the course */
				}
			}
			
			
			
		// check whether the payment_status is Completed
		// check that txn_id has not been previously processed
		// check that receiver_email is your PayPal email
		// check that payment_amount/payment_currency are correct
		// process payment and mark item as paid.

		// assign posted variables to local variables
		//$item_name = $_POST['item_name'];
		//$item_number = $_POST['item_number'];
		//$payment_status = $_POST['payment_status'];
		//$payment_amount = $_POST['mc_gross'];
		//$payment_currency = $_POST['mc_currency'];
		//$txn_id = $_POST['txn_id'];
		//$receiver_email = $_POST['receiver_email'];
		//$payer_email = $_POST['payer_email'];
			
			//error_log(date('[Y-m-d H:i e] '). "Verifieds IPN: $str ". PHP_EOL, 3, LOG_FILE);
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Verified IPN: $req ". PHP_EOL, 3, LOG_FILE);
			}
			
		} else if (strcmp ($res, "INVALID") == 0) {
			// log for manual investigation
			// Add business logic here which deals with invalid IPN messages
			if(DEBUG == true) {
				error_log(date('[Y-m-d H:i e] '). "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
			}
		}
		die;
	}
	
	function processOrder($data = NULL) {
		$this->loadModel("Payment");
		$this->Payment->create();
		$data1['Payment']['logs'] = serialize($data);
		$this->Payment->save($data1);
	}

/*
 * @function name	: viewquiz
 * @purpose			: function to display quiz
 * @arguments		: Following are the arguments to be passed:
		* quizid		: id of quiz to be viewed
		* quizheading	: heading of quiz to be viewed
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 24th august 2013
 * @description		: NA
*/	
	function viewquiz($quizid = NULL, $quizheading = NULL, $type='N') {
		$this->loadModel("CourseQuizQuestion");
		$nextquestion = '';
		/*if (!$this->Session->read("quizquestions.".$quizid)) {
			$questions = $this->CourseQuizQuestion->find("list",array("conditions"=>array("CourseQuizQuestion.course_quiz_id"=>$quizid),"order"=>"rand()","fields"=>array("CourseQuizQuestion.id")));
			$this->Session->write("quizquestions.".$quizid,$questions);
		//} else {
			//$questions = $this->Session->read("quizquestions.".$quizid);
		//} */
		if ($this->RequestHandler->isAjax()) {
//pr($this->request->data);
			$this->set("courseid",$this->Course->checkquiz($this->request->data['quizid'],$this->Session->read("Auth.User.id"),false));
			if(isset($this->request->data['type']) && !empty($this->request->data['answer'])) {
				$this->Session->write("answerquiz.".$this->request->data['quizid'].".".$this->request->data['question'].".question",'');
				$this->Session->write("answerquiz.".$this->request->data['quizid'].".".$this->request->data['question'].".answer",$this->request->data['answer']);
			}
			if(isset($this->request->data['useranswer']) && !empty($this->request->data['useranswer'])) {
				$this->Session->write("answerquiz.".$this->request->data['quizid'].".".$this->request->data['question'].".question",$this->request->data['fanswer']);
				$this->Session->write("answerquiz.".$this->request->data['quizid'].".".$this->request->data['question'].".answer",$this->request->data['useranswer']);
				$this->Session->write("answerquiz.".$this->request->data['quizid'].".".$this->request->data['question'].".rawanswer",$this->request->data['rawans']);
			}
		//	pr($this->Session->read("answerquiz"));
			$questions = $this->Session->read("quizquestions.".$this->request->data['quizid']);
			if(!empty($questions)) {
				if((count($questions)-1) == $this->request->data['quizqstid']) {
					$this->set("lastqst",1);
				}
				//$currquestion	= array_shift(array_slice($questions,$this->request->data['quizqstid'],1));
				$arrkey = array_keys($questions);
				if(isset($arrkey[$this->request->data['quizqstid']])) {
					$currquestion	= $questions[$arrkey[$this->request->data['quizqstid']]];
				} else {
					$currquestion	= -1;
				}
				//pr($currquestion);
				$nextquestion	= $this->request->data['quizqstid']+1;
				$currquestion = $this->CourseQuizQuestion->find("all",array("conditions"=>array("CourseQuizQuestion.id"=>$currquestion),"fields"=>array("CourseQuizQuestion.*")));
				if(!empty($currquestion[0])) {
					$this->set("currquestion",$currquestion[0]);
					$this->set("currindex",$nextquestion);
				}
				if ($this->Course->checkquiz($this->request->data['quizid'],$this->Session->read("Auth.User.id"))) {
					$this->set("selfquiz",1);
				}
			}
			$this->set("type",$this->request->data['quiztype']);
			$this->Session->write("currentqst.".$this->request->data['quizid'],$this->request->data['quizqstid']);
			$this->set("quizid",$this->request->data['quizid']);
			if (isset($this->request->data['lastquestion'])) {
				$this->Session->delete("quizquestions");
				$this->Session->delete("currentqst");
				$this->getresult($this->request->data['quizid']);
				$this->render("viewresultajax");
			} else {
				$this->render("viewquizajax");
			}
		} else {
			$questions = $this->CourseQuizQuestion->find("list",array("conditions"=>array("CourseQuizQuestion.course_quiz_id"=>$quizid),"order"=>"rand()","fields"=>array("CourseQuizQuestion.id")));
			$this->Session->write("quizquestions.".$quizid,$questions);
			$this->Session->delete("result.".$quizid);
			$this->set("courseid",$this->Course->checkquiz($quizid,$this->Session->read("Auth.User.id"),false));
			if ($this->Course->checkquiz($quizid,$this->Session->read("Auth.User.id"))) {
				$this->set("selfquiz",1);
			}
			$this->layout = "frontend";
			if(!$this->Session->read("result")) {
				/*if($this->Session->read("currentqst.".$quizid)) {
					$arrkey = array_keys($questions);
					$currquestion	= $questions[$arrkey[$this->Session->read("currentqst.".$quizid)]];
					//$currquestion	= array_shift(array_slice($questions,$this->Session->read("currentqst.".$quizid),1));
					//$nextquestion	= $this->Session->read("currentqst.".$quizid);
					$nextquestion	= 0;
					$nextquestion	+= 1;
				} else { */
					$arrkey = array_keys($questions);
					$currquestion	= $questions[$arrkey[0]];
					//$currquestion	= array_shift(array_slice($questions,0,1));
					$nextquestion	= 1;
				//}
				if((count($questions)) <= $nextquestion) {
					$this->set("lastqst",1);
				}
				$currquestion = $this->CourseQuizQuestion->find("all",array("conditions"=>array("CourseQuizQuestion.course_quiz_id"=>$quizid,"CourseQuizQuestion.id"=>$currquestion),"fields"=>array("CourseQuizQuestion.*")));
				$this->set("currquestion",$currquestion[0]);
			}
		}
		$this->set("currindex",$nextquestion);
		$this->set("quizid",$quizid);
		if (!empty($type)) {
			$this->set("type",$type);
		}
		if($this->Session->read("result.".$quizid)) {
			$this->render("viewresult");
		}
		
	}
/* end of function */


/*
 * @function name	: editquizquestion
 * @purpose			: function to edit quiz question
 * @arguments		: Following are the arguments to be passed:
		* questionid	: id of question to be updated
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 26th august 2013
 * @description		: NA
*/	
	function editquizquestion($questionid = NULL) {
		$this->loadModel("CourseQuizQuestion");
		$this->loadModel("CourseQuizQuestionOption");
		if ($this->RequestHandler->isAjax()) {
			if(isset($this->request->data['question']) && !empty($this->request->data['question'])) {
				$key = array_keys($this->request->data['question']);
				$courseqst['CourseQuizQuestion']['question'] = $this->request->data['question'][$key[0]];
				$this->CourseQuizQuestion->id = $key[0];
				$this->CourseQuizQuestion->save($courseqst);
				if(isset($this->request->data['CourseQuizQuestionOption']['answer']) && !empty($this->request->data['CourseQuizQuestionOption']['answer'])) {
					foreach($this->request->data['CourseQuizQuestionOption']['answer'] as $answerkey=>$answerval) {
						$quizqstoption['CourseQuizQuestionOption'][$answerkey]['id'] = $answerkey;
						$quizqstoption['CourseQuizQuestionOption'][$answerkey]['answer'] = $answerval;
					}
					$this->CourseQuizQuestionOption->create();
					$this->CourseQuizQuestionOption->saveAll($quizqstoption['CourseQuizQuestionOption']);
				}
				if(isset($this->request->data['CourseQuizQuestionOption']['options']) && !empty($this->request->data['CourseQuizQuestionOption']['options'])) {
					foreach($this->request->data['CourseQuizQuestionOption']['options'] as $optionkey=>$optionval) {
						$quizoptoption['CourseQuizQuestionOption'][$optionkey]['id'] = $optionkey;
						$quizoptoption['CourseQuizQuestionOption'][$optionkey]['options'] = $optionval;
					}
					$this->CourseQuizQuestionOption->create();
					$this->CourseQuizQuestionOption->saveAll($quizoptoption['CourseQuizQuestionOption']);
				}
				
				exit;
			} else {
				$questionid = $this->request->data['questionid'];
				$currquestion = $this->CourseQuizQuestion->find("all",array("conditions"=>array("CourseQuizQuestion.id"=>$questionid),"fields"=>array("CourseQuizQuestion.*")));
				$this->set("currquestion",$currquestion[0]);
				$this->set("previd",$this->request->data['previd']);
			}
				$this->render("editquizquestion");
				
		}
	}
/* end of function */
/*
 * @function name	: editquizquestioninline
 * @purpose			: function to edit quiz question
 * @arguments		: Following are the arguments to be passed:
		* questionid	: id of question to be updated
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 26th august 2013
 * @description		: NA
*/	
	function editquizquestioninline($questionid = NULL) {
		$this->loadModel("CourseQuizQuestion");
		$this->loadModel("CourseQuizQuestionOption");
		if ($this->RequestHandler->isAjax()) {
			if(isset($this->request->data['question']) && !empty($this->request->data['question'])) {
				$key = array_keys($this->request->data['question']);
				$courseqst['CourseQuizQuestion']['question'] = $this->request->data['question'][$key[0]];
				$this->CourseQuizQuestion->id = $key[0];
				$this->CourseQuizQuestion->save($courseqst);
				if(isset($this->request->data['CourseQuizQuestionOption']['answer']) && !empty($this->request->data['CourseQuizQuestionOption']['answer'])) {
					foreach($this->request->data['CourseQuizQuestionOption']['answer'] as $answerkey=>$answerval) {
						$quizqstoption['CourseQuizQuestionOption'][$answerkey]['id'] = $answerkey;
						$quizqstoption['CourseQuizQuestionOption'][$answerkey]['answer'] = $answerval;
					}
					$this->CourseQuizQuestionOption->create();
					$this->CourseQuizQuestionOption->saveAll($quizqstoption['CourseQuizQuestionOption']);
				}
				if(isset($this->request->data['CourseQuizQuestionOption']['options']) && !empty($this->request->data['CourseQuizQuestionOption']['options'])) {
					foreach($this->request->data['CourseQuizQuestionOption']['options'] as $optionkey=>$optionval) {
						$quizoptoption['CourseQuizQuestionOption'][$optionkey]['id'] = $optionkey;
						$quizoptoption['CourseQuizQuestionOption'][$optionkey]['options'] = $optionval;
					}
					$this->CourseQuizQuestionOption->create();
					$this->CourseQuizQuestionOption->saveAll($quizoptoption['CourseQuizQuestionOption']);
				}
				
				exit;
			} else {
				$questionid = $this->request->data['questionid'];
				$currquestion = $this->CourseQuizQuestion->find("all",array("conditions"=>array("CourseQuizQuestion.id"=>$questionid),"fields"=>array("CourseQuizQuestion.*")));
				$this->set("currquestion",$currquestion[0]);
				//$this->set("previd",$this->request->data['previd']);
			}
				$this->render("editquizquestioninline");
				
		}
	}
/* end of function */


/*
 * @function name	: deletequizquestion
 * @purpose			: function to delete quiz question
 * @arguments		: Following are the arguments to be passed:
		* questionid	: id of question to be updated
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 26th august 2013
 * @description		: NA
*/	
	function deletequizquestion($questionid = NULL) {
		$this->loadModel("CourseQuizQuestion");
		if ($this->RequestHandler->isAjax()) {
			$questionid = explode("^",$this->request->data['quizqstid']);
			$this->CourseQuizQuestion->id = $questionid[0];
			if ($this->CourseQuizQuestion->delete()) {
				if(isset($questionid[1])) {
					$this->Session->delete('quizquestions.'.$this->request->data['quizid'].'.'.$questionid[0]);
					if($questionid[1] < count($this->Session->delete('quizquestions.'.$this->request->data['quizid']))) {
						$this->Session->write('currentqst.'.$questionid[0],$questionid[1]+1);
					} else {
						$this->Session->write('currentqst.'.$questionid[0],$questionid[1]-1);
					}
				}
				echo 1;
			} else {
				echo 2;
			}
		}
		$this->render(false);
	}
/* end of function */


/*
 * @function name	: viewuserquestions
 * @purpose			: function to view questiona and answers for a lecture
 * @arguments		: Following are the arguments to be passed:
		* questionid	: id of question asked
 * @return			: none
 * @created by		: shivam sharma
 * @created on		: 28th august 2013
 * @description		: NA
*/
	function viewuserquestion($questionid = NULL) {
		Configure::write('debug',0);
		$this->layout = "frontend";
		$this->loadModel("CourseUserQuestion");
		$this->loadModel("CourseUserQuestionAnswer");
		if(isset($this->data) && !empty($this->data)) {
			$answerdata = $this->data;
			$answerdata['CourseUserQuestionAnswer']['user_id'] = $this->Session->read("Auth.User.id");
			$answerdata['CourseUserQuestionAnswer']['course_user_question_id'] = $questionid;
			$this->CourseUserQuestionAnswer->create();
			if ($this->CourseUserQuestionAnswer->save($answerdata) ) {
				$this->Session->setFlash("Your answer has been submitted.", 'default', array("class"=>"success_message"));
				$this->redirect("/question/".$questionid);
			}
		}
		$this->paginate = array("order"=>"CourseUserQuestion.created desc","limit"=>"1000");
		$this->CourseUserQuestion->bindModel(array("hasMany"=>array("CourseUserQuestionAnswer"=>array("class"=>"CourseUserQuestionAnswer","foreignKey"=>"course_user_question_id")),
		"belongsTo"=>array("Userdetail"=>array("class"=>"Userdetail","foreignKey"=>false,"conditions"=>"CourseUserQuestion.user_id = Userdetail.user_id","fields"=>array("Userdetail.first_name","Userdetail.last_name")))
		));
		$this->CourseUserQuestionAnswer->virtualFields = array("username"=>"select concat(userdetail.first_name,' ',userdetail.last_name) from userdetails userdetail where userdetail.user_id = CourseUserQuestionAnswer.user_id");
		$this->CourseUserQuestion->recursive = 1; 
		$this->set("data",$this->paginate('CourseUserQuestion',array("CourseUserQuestion.id"=>$questionid)));
	}

/* end of function */

	function downlodfiles($fileid = NULL) {
		$this->loadModel("CourseSuppliment");
		$data = $this->CourseSuppliment->find("first",array("conditions"=>array("CourseSuppliment.id"=>$fileid)));
		if(!empty($data)) {
			$fullPath = $data['CourseSuppliment']['content_source'];
		}
		// Must be fresh start
		if( headers_sent() ) {
			die('Headers Sent');
		}
		// Required for some browsers
		if(ini_get('zlib.output_compression')) {
			ini_set('zlib.output_compression', 'Off');
		}
		// File Exists?
		if( file_exists($fullPath) ){
			// Parse Info / Get Extension
			$fsize = filesize($fullPath);
			$path_parts = pathinfo($fullPath);
			$ext = strtolower($path_parts["extension"]);
			// Determine Content Type
			switch ($ext) {
				case "pdf": $ctype="application/pdf"; break;
				case "exe": $ctype="application/octet-stream"; break;
				case "zip": $ctype="application/zip"; break;
				case "doc": $ctype="application/msword"; break;
				case "xls": $ctype="application/vnd.ms-excel"; break;
				case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
				case "gif": $ctype="image/gif"; break;
				case "png": $ctype="image/png"; break;
				case "jpeg":
				case "jpg": $ctype="image/jpg"; break;
				default: $ctype="application/force-download";
			}
			header("Pragma: public"); // required
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false); // required for certain browsers
			header("Content-Type: $ctype");
			header("Content-Disposition: attachment; filename=\"".basename($data['CourseSuppliment']['content_title'])."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".$fsize);
			ob_clean();
			flush();
			readfile( $fullPath );
		}
	}
	
	function removefile($fileid = NULL) {
		if($this->RequestHandler->isAjax()) {
			$this->loadModel("CourseSuppliment");
			$suppliment = $this->CourseSuppliment->find("first",array("conditions"=>array("CourseSuppliment.id"=>$this->request->data['id'])));
			if (!empty($suppliment)) {
				$this->CourseSuppliment->id = $suppliment['CourseSuppliment']['id'];
				$file = WWW_ROOT.$suppliment['CourseSuppliment']['content_source'];
				if ($this->CourseSuppliment->delete()) {
					if(file_exists($file)) {
						unlink($file);
						if(file_exists($file.".jpg")) {
							unlink($file.".jpg");
						}
					}
					echo "1";
				} else {
					echo "2";
				}
			} else {
				echo "3";
			}
			exit;
		}
	}
	
	function removeqst($qstid = NULL,$ansid = NULL) {
		if($this->RequestHandler->isAjax()) {
			$this->loadModel('CourseUserQuestion');
			$question = $this->CourseUserQuestion->find("first",array("conditions"=>array("CourseUserQuestion.id"=>$this->request->data['qstid'],"CourseUserQuestion.user_id"=>$this->Session->read("Auth.User.id"))));
			if (!empty($question)) {
				$this->CourseUserQuestion->create();
				$this->CourseUserQuestion->id = $question['CourseUserQuestion']['id'];
				if ($this->CourseUserQuestion->delete()) {
					echo "1";
				} else {
					echo "2";
				}
			} else {
				echo "3";
			}
			exit;
		}
	}
	
	public function create_pdf($courseid = NULL, $userid = NULL) {
		//Configure::write('debug',2);
		$this->layout = '/pdf/default';
		$this->loadModel("UserLearningCourse");
		$this->UserLearningCourse->recursive = -1;
		$userlearning = $this->UserLearningCourse->find("first",array("conditions"=>array("UserLearningCourse.user_id"=>$userid,"UserLearningCourse.course_id"=>$courseid,"UserLearningCourse.completed"=>1)));
		if (empty($userlearning)) {
			$this->Session->setFlash("Invalid request.");
			$this->redirect("/view-courses");
		} else {
			$username = ucwords($this->username($userid));
			$coursename = $this->course($courseid);
			$instructor = $this->username($this->course($courseid,true));
			$date = $userlearning['UserLearningCourse']['modified'];
			$this->set(compact("username","coursename","userid","instructor","date"));
		}
		$this->render('/Pdf/my_pdf_view');
	}
	
	function download($fullPath = NULL) {
			// Must be fresh start
			if( headers_sent() ) {
				die('Headers Sent');
			}
			// Required for some browsers
			if(ini_get('zlib.output_compression')) {
				ini_set('zlib.output_compression', 'Off');
			}
			$fullPath = WWW_ROOT."files/pdf/".$fullPath; 
			// File Exists?
			if( file_exists($fullPath) ){
				// Parse Info / Get Extension
				$fsize = filesize($fullPath);
				$path_parts = pathinfo($fullPath);
				$ext = strtolower($path_parts["extension"]);
				// Determine Content Type
				switch ($ext) {
					case "pdf": $ctype="application/pdf"; break;
					case "exe": $ctype="application/octet-stream"; break;
					case "zip": $ctype="application/zip"; break;
					case "doc": $ctype="application/msword"; break;
					case "xls": $ctype="application/vnd.ms-excel"; break;
					case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
					case "gif": $ctype="image/gif"; break;
					case "png": $ctype="image/png"; break;
					case "jpeg":
					case "jpg": $ctype="image/jpg"; break;
					default: $ctype="application/force-download";
				}
				header("Pragma: public"); // required
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false); // required for certain browsers
				header("Content-Type: $ctype");
				header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" );
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".$fsize);
				ob_clean();
				flush();
				readfile( $fullPath );
			}
	}
	
	function video_info($url = NULL) {
	 
		// Handle Youtube
		if (strpos(strtolower($url), "youtube.com")) {
			$url = parse_url($url);
			$vid = parse_str($url['query'], $output);
			$video_id = $output['v'];
			$data['video_type'] = 'youtube';
			$data['video_id'] = $video_id;
			$xml = simplexml_load_file("http://gdata.youtube.com/feeds/api/videos?q=$video_id");
			 
			foreach ($xml->entry as $entry) {
				// get nodes in media: namespace
				$media = $entry->children('http://search.yahoo.com/mrss/');
				// get video player URL
				$attrs = $media->group->player->attributes();
				$watch = $attrs['url'];
				// get video thumbnail
				$data['thumb_1'] = $media->group->thumbnail[0]->attributes(); // Thumbnail 1
				$data['thumb_2'] = $media->group->thumbnail[1]->attributes(); // Thumbnail 2
				$data['thumb_3'] = $media->group->thumbnail[2]->attributes(); // Thumbnail 3
				$data['thumb_large'] = $media->group->thumbnail[3]->attributes(); // Large thumbnail
				$data['tags'] = $media->group->keywords; // Video Tags
				$data['cat'] = $media->group->category; // Video category
				$attrs = $media->group->thumbnail[0]->attributes();
				$thumbnail = $attrs['url'];
				// get <yt:duration> node for video length
				$yt = $media->children('http://gdata.youtube.com/schemas/2007');
				$attrs = $yt->duration->attributes();
				$data['duration'] = $attrs['seconds'];
				// get <yt:stats> node for viewer statistics
				$yt = $entry->children('http://gdata.youtube.com/schemas/2007');
				$attrs = $yt->statistics->attributes();
				$data['views'] = $viewCount = $attrs['viewCount'];
				$data['title']=$entry->title;
				$data['info']=$entry->content;
				// get <gd:rating> node for video ratings
				$gd = $entry->children('http://schemas.google.com/g/2005');
				if ($gd->rating) {
					$attrs = $gd->rating->attributes();
					$data['rating'] = $attrs['average'];
				} else {
					$data['rating'] = 0;
				}
			} // End foreach
		} // End Youtube
		 
		// Handle Vimeo
		else if (strpos(strtolower($url), "vimeo.com")) {
			$video_id=explode('vimeo.com/', $url);
			$video_id=$video_id[1];
			$data['video_type'] = 'vimeo';
			$data['video_id'] = $video_id;
			$xml = simplexml_load_file("http://vimeo.com/api/v2/video/$video_id.xml");
			foreach ($xml->video as $video) {
				$data['id']=$video->id;
				$data['title']=$video->title;
				$data['info']=$video->description;
				$data['url']=$video->url;
				$data['upload_date']=$video->upload_date;
				$data['mobile_url']=$video->mobile_url;
				$data['thumb_small']=$video->thumbnail_small;
				$data['thumb_medium']=$video->thumbnail_medium;
				$data['thumb_large']=$video->thumbnail_large;
				$data['user_name']=$video->user_name;
				$data['urer_url']=$video->urer_url;
				$data['user_thumb_small']=$video->user_portrait_small;
				$data['user_thumb_medium']=$video->user_portrait_medium;
				$data['user_thumb_large']=$video->user_portrait_large;
				$data['user_thumb_huge']=$video->user_portrait_huge;
				$data['likes']=$video->stats_number_of_likes;
				$data['views']=$video->stats_number_of_plays;
				$data['comments']=$video->stats_number_of_comments;
				$data['duration']=$video->duration;
				$data['width']=$video->width;
				$data['height']=$video->height;
				$data['tags']=$video->tags;
			} // End foreach
		} // End Vimeo
		 
		// Set false if invalid URL
		else { $data = false; }
		 
		return $data;
	 
	}
	
	function removelogo($courseid = null) {
		$this->Course->create();
		$courselinc = $this->Course->find("first",array("conditions"=>array("Course.id"=>$courseid),"fields"=>array("Course.lincence_logo")));
		if(file_exists(WWW_ROOT.$courselinc['Course']['lincence_logo'])) {
			//echo(WWW_ROOT.$courselinc['Course']['lincence_logo']);
			//die;
			unlink(WWW_ROOT.$courselinc['Course']['lincence_logo']);
		}
		$this->Course->id = $courseid;
		$data['Course']['lincence_url']   = '';
		$data['Course']['lincence_logo'] = '';
		if ($this->Course->save($data)) {
			if(file_exists(WWW_ROOT.$courselinc['Course']['lincence_logo'])) {
				unlink(WWW_ROOT.$courselinc['Course']['lincence_logo']);
			}
		}
		$this->Session->setFlash("Lincense has been removed successfully", 'default', array("class"=>"success_message"));
		$this->redirect("/course-manage/introduction/".$courseid);
	}

	function updatecoursecontent($courseid = NULL) {
		$this->autoRender = false;
		if(!empty($courseid)) {
			$this->loadModel("CourseLecture");
			$this->CourseLecture->recursive = -1;
			$lectures = $this->CourseLecture->find("all",array("conditions"=>array("CourseLecture.course_id"=>$courseid)));
			$updatecontent = array();
			foreach($lectures as $key=>$val) {
					$content = $content1 = explode("/",$val['CourseLecture']['content_source']);
					unset($content[count($content)-1]);
					//$content[2] = 'Course'.$val['CourseLecture']['course_id'];
					$source_content = implode("/",$content);
					$content1[2] = 'Course'.$val['CourseLecture']['course_id']; 
					$content1[3] = 'Section'.$val['CourseLecture']['course_section_id'];
					$content1[4] = 'Lecture'.$val['CourseLecture']['id'];
		//                      unset($content1[count($content1)-1]);
					$target_content = implode("/",$content1);
					unset($content1[count($content1)-1]);
					$target_dir = implode("/",$content1);
					$destArr = $content1;
					$deststr = '';
					if(!empty($destArr)) {
							foreach($destArr as $key1=>$val1) {
									if (!empty($val1)) {
											$deststr .= "/".$val1;
											if(!is_dir(WWW_ROOT.$target_dir)) {
													$deststr = ltrim($deststr,"/");
													if(!is_dir(WWW_ROOT.$deststr)) {
															exec("mkdir ".WWW_ROOT.$deststr);

															exec("chmod 777 ".WWW_ROOT.$deststr);
													} else {

													}
											}
									}
							}
					}
					exec("cp ".WWW_ROOT.$source_content."/* ".WWW_ROOT.$target_dir."/");
					$updatecontent['CourseLecture'][$val['CourseLecture']['id']] = array('id'=>$val['CourseLecture']['id'],'content_source'=>$target_content);
			}
			$this->CourseLecture->create();
			echo "<pre>";
			print_r($updatecontent);
			echo "</pre>";
			$this->CourseLecture->saveAll($updatecontent['CourseLecture']);
		}
	}
	
}
