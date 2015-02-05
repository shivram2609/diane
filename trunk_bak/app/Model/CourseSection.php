<?php
App::uses('AppModel', 'Model');
/**
 * CourseSection Model
 *
 * @property Course $Course
 * @property CourseLecture $CourseLecture
 */
class CourseSection extends AppModel {


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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'CourseLecture' => array(
			'className' => 'CourseLecture',
			'foreignKey' => 'course_section_id',
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
		'CourseQuiz' => array(
			'className' => 'CourseQuiz',
			'foreignKey' => 'course_section_id',
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
	
	function updatesectionindex($index,$courseid) {
		$sql = "update course_sections set section_index = (section_index-1) where course_id = ".$courseid." and section_index >".$index;
		$this->query($sql);
	}
	
}
