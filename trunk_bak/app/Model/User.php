<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Bookmark $Bookmark
 * @property Testimonial $Testimonial
 * @property Userdetail $Userdetail
 */
class User extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Follower' => array(
			'className' => 'Follower',
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
		'Course' => array(
			'className' => 'Course',
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
		'UserCompleteCourseLecture' => array(
			'className' => 'UserCompleteCourseLecture',
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
		'CourseInstructor' => array(
			'className' => 'CourseInstructor',
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
		'CourseUserNote' => array(
			'className' => 'CourseUserNote',
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
		'CourseUserQuestion' => array(
			'className' => 'CourseUserQuestion',
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
		'CourseUserQuestionAnswer' => array(
			'className' => 'CourseUserQuestionAnswer',
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
		'Follower' => array(
			'className' => 'Follower',
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
		'Follower1' => array(
			'className' => 'Follower',
			'foreignKey' => false,
			'dependent' => true,
			'conditions' => 'User.id = Follower1.follower_id',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
		'Userdetail' => array(
			'className' => 'Userdetail',
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
		)
	);

	var $validate = array(
		'username'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter username.'
			),
			'email'=>array(
				'rule'=>'email',
				'message'=>'Please enter valid email.'
			),
			'isUnique'=>array(
				'rule'=>'isUnique',
				'message'=>'This email is already registered.'
			)
		),
		'currentpassword'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter old password.'
			),
			'checkoldpassword'=>array(
				'rule'=>'checkoldpassword',
				'message'=>'Current password is not correct.'
			)
		),
		'password'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter password.'
			),
			'minlength'=>array(
				'rule'=>array('minlength',5),
				'message'=>'Password size min 5 chracters.'
			),
			'maxlength'=>array(
				'rule'=>array('maxlength',50),
				'message'=>'Password size max 15 chracters.'
			)
		),
		'confirmpassword'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter confirm password.'
			),
			'confirmpassword'=>array(
				'rule'=>'confirmpassword',
				'message'=>'Password and Confirm password do not match'
			)
		),
		'type'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter user type'
			)
		),
		'captcha'=>array(
			'matchcaptcha'=>array(
				'rule' => array('matchCaptcha'),
				'message'=>'Failed validating human check.'
			),
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Failed validating human check.'
			)
		),
		'cardnumber' => array(
			'cc'=>array(
				'rule' => array('cc', array('visa', 'maestro'), false, null),
				'message' => 'The credit card number you supplied was invalid.'
			),
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter card number.'
			)
		),
		'cardtype'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter card type'
			)
		),
		'month'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter month.'
			),
			'checkdate'=>array(
				'rule'=>'checkdate',
				'message'=>'Please enter valid date.'
			)
		)
	);
	
	function confirmpassword() {
		$value = $this->data['User']['confirmpassword'];
		if ($value == $this->data['User']['password']) {
		  return true;
		} else {
		  return false;
		}
	}
	
	function checkoldpassword() {
		$value = $this->data['User']['currentpassword'];
		$value = $this->data['User']['id'];
		$this->recursive = -1;
		$user = $this->find("first",array("conditions"=>array("User.id"=>$this->data['User']['id'],"User.password"=>$this->data['User']['currentpassword'])));
		if (empty($user)) {
			return false;
		} else {
			return true;
		}
	}
	
	function matchCaptcha($inputValue)	{
		return true; //return true or false after comparing submitted value with set value of captcha
	}

	function setCaptcha($value)	{
		$this->captcha = $value; //setting captcha value
	}

	function getCaptcha()	{
		return $this->captcha; //getting captcha value
	}
}
