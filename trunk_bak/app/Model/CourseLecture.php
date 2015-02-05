<?php
App::uses('AppModel', 'Model');
/**
 * CourseLecture Model
 *
 * @property Course $Course
 * @property CourseSection $CourseSection
 */
class CourseLecture extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CourseSection' => array(
			'className' => 'CourseSection',
			'foreignKey' => 'course_section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'CourseQuiz' => array(
			'className' => 'CourseQuiz',
			'foreignKey' => 'course_lecture_id',
			'dependent' => false,
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
			'foreignKey' => 'course_lecture_id',
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
			'foreignKey' => 'lecture_id',
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
	
	function updatelectureindex($index,$courseid) {
		$sql = "update course_lectures set lecture_index = (lecture_index-1) where course_section_id = ".$courseid." and lecture_index >".$index;
		$this->query($sql);
	}
}
