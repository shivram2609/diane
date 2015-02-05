<?php
App::uses('AppModel', 'Model');
/**
 * Course Model
 *
 * @property User $User
 * @property Category $Category
 * @property Language $Language
 * @property InstructionLevel $InstructionLevel
 * @property CourseAudience $CourseAudience
 * @property CourseGoal $CourseGoal
 * @property CourseInstructor $CourseInstructor
 * @property CourseInvitee $CourseInvitee
 * @property CoursePassword $CoursePassword
 * @property CourseRequirement $CourseRequirement
 */
class Course extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';

	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	var $validate = array(
		'title'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter title'
			)
		),
		'coverimage'=>array(
			'checkimage'=>array(
				"rule"=> 'checkimage',
				"message" => 'Please supply a valid image.',
			)
		),
		'checkvideo'=>array(
			'checkvideo'=>array(
				"rule"=> 'checkvideo',
				"message" => 'Please supply a valid video.',
			)
		),
		'price'=>array(
			'decimal'=>array(
				'rule'=> array('decimal', 2),
				'message'=>'Please enter valid price'
			),
			'checkbudget'=>array(
				'rule'=>'checkbudget',
				'message'=>'Please enter price greater than 0'
			)
		)
	);
	
	

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)/*,
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)*/,
		'Language' => array(
			'className' => 'Language',
			'foreignKey' => 'language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InstructionLevel' => array(
			'className' => 'InstructionLevel',
			'foreignKey' => 'instruction_level_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CourseAudience' => array(
			'className' => 'CourseAudience',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CourseGoal' => array(
			'className' => 'CourseGoal',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CourseInstructor' => array(
			'className' => 'CourseInstructor',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CourseInvitee' => array(
			'className' => 'CourseInvitee',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CoursePassword' => array(
			'className' => 'CoursePassword',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CourseRequirement' => array(
			'className' => 'CourseRequirement',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CourseSection' => array(
			'className' => 'CourseSection',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CourseLecture' => array(
			'className' => 'CourseLecture',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserLearningCourse' => array(
			'className' => 'UserLearningCourse',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserWishlistCourse' => array(
			'className' => 'UserWishlistCourse',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserViewCourse' => array(
			'className' => 'UserViewCourse',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CourseReview' => array(
			'className' => 'CourseReview',
			'foreignKey' => 'user_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserWishlistCourse' => array(
			'className' => 'UserWishlistCourse',
			'foreignKey' => 'course_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	function checkimage() {
		$image = $this->data['Course']['coverimage']['name'];
		if (!empty($image)) {
			$img = explode(".",$image);
			$ext = strtolower($img[count($img)-1]);
			if (!in_array($ext,array("jpg","jpeg","png","gif"))) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
	function checkvideo() {
		$image = $this->data['Course']['promovideo']['name'];
		if (!empty($image)) {
			$img = explode(".",$image);
			$ext = strtolower($img[count($img)-1]);
			if (!in_array($ext,array("mp4","flv","mov","mp3"))) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
	
	function checkbudget() {
		$price = ($this->data['Course']['price']*1);
		
		if($this->data['Course']['pricetype'] == 'Free') {
			return true;
		} else {	
			if (empty($price)) {
				return false;
			} else {
				return true;
			}
		}	
	}
	
	function checkquiz($quizid,$userid,$flag = true) {
		$sql = "select user.id,course.id from users user join courses course on user.id = course.user_id join course_sections on course.id = course_sections.course_id join course_quizzes on course_sections.id = course_quizzes.course_section_id where course_quizzes.id = ".$quizid." and user.id = ".$userid;
		$val = $this->query($sql);
		if($flag) {
			if (!empty($val)) {
				return true;
			} else {
				return false;
			}
		} else {
			if (!empty($val)) {
				return $val[0]['course']['id'];
			} else {
				return 0;
			}
		}
	}
	
	function getquizquestions($courseid = NULL,$quizid = NULL) {
		$sql = "select cqq.* from course_quiz_questions  cqq INNER JOIN course_quizzes cq ON cqq.course_quiz_id = cq.id INNER JOIN course_sections cs ON cq.course_section_id = cs.id INNER JOIN courses course ON cs.course_id = course.id where course.id =".$courseid;
		if (!empty($quizid)) {
			$sql .=" and cqq.course_quiz_id=".$quizid;
		}
		$res = $this->query($sql);
		$finalarr = array();
		if(!empty($res)) {
			foreach ($res as $key=>$val) {
				$finalarr[$val['cqq']['course_quiz_id']][] = $val['cqq'];
			}
		}
		return $finalarr;
	}
	
	function dellecquiz($lecid = NULL) {
		$sql = "update course_quizzes set course_lecture_id = 0 where course_lecture_id = ".$lecid;
		$this->query($sql);
	}

}
