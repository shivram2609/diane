<?php
App::uses('AppModel', 'Model');
/**
 * City Model
 *
 * @property State $State
 */
class City extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $validate = array(
		"name"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>"Please enter city name"
			)
		),
		"code"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>"Please enter city code"
			),
			"isUnique"=>array(
				"rule"=>"isUnique",
				"message"=>"City code already exists"
			)
		)
	);
}
