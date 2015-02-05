<?php
App::uses('AppModel', 'Model');
/**
 * CourseQuizQuestion Model
 *
 * @property CourseQuiz $CourseQuiz
 */
class CourseQuizQuestion extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CourseQuiz' => array(
			'className' => 'CourseQuiz',
			'foreignKey' => 'course_quiz_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'CourseQuizQuestionOption'=>array(
			'className'=>'CourseQuizQuestionOption',
			'foreignKey'=>'course_quiz_question_id',
			'dependent'=>true
		)
	);
}
