<?php
App::uses('AppModel', 'Model');
/**
 * CourseAudience Model
 *
 * @property Course $Course
 */
class CourseAudience extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'course_audience';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


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
}
