<?php
App::uses('AppModel', 'Model');
/**
 * CourseUserQuestion Model
 *
 * @property User $User
 * @property Course $Course
 * @property CourseLecture $CourseLecture
 * @property CourseUserQuestionAnswer $CourseUserQuestionAnswer
 */
class CourseUserQuestion extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
		),
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CourseLecture' => array(
			'className' => 'CourseLecture',
			'foreignKey' => 'course_lecture_id',
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
		'CourseUserQuestionAnswer' => array(
			'className' => 'CourseUserQuestionAnswer',
			'foreignKey' => 'course_user_question_id',
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

}
