<?php
App::uses('AppModel', 'Model');
/**
 * CourseQuiz Model
 *
 * @property CourseQuizQuestion $CourseQuizQuestion
 */
class CourseQuiz extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CourseQuizQuestion' => array(
			'className' => 'CourseQuizQuestion',
			'foreignKey' => 'course_quiz_id',
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
