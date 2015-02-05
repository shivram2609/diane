<?php
App::uses('AppModel', 'Model');
/**
 * UserCompleteCourseLecture Model
 *
 * @property User $User
 * @property Course $Course
 * @property Lecture $Lecture
 */
class UserCompleteCourseLecture extends AppModel {


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
			'foreignKey' => false,
			'conditions' => 'CourseLecture.id = UserCompleteCourseLecture.lecture_id',
			'fields' => '',
			'order' => ''
		)
	);
}
