<?php
App::uses('AppModel', 'Model');
/**
 * CourseQuizQuestionOption Model
 *
 * @property CourseQuizQuestion $CourseQuizQuestion
 */
class CourseQuizQuestionOption extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CourseQuizQuestion' => array(
			'className' => 'CourseQuizQuestion',
			'foreignKey' => 'course_quiz_question_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
