<?php
App::uses('AppModel', 'Model');
/**
 * Country Model
 *
 * @property State $State
 */
class Country extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'country_id',
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
		"name"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>"Please enter country name"
			),
			"isUnique"=>array(
				"rule"=>"isUnique",
				"message"=>"Country name already exists"
			)
		),
		"code"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>"Please enter country code"
			),
			"isUnique"=>array(
				"rule"=>"isUnique",
				"message"=>"Country code already exists"
			)
		)
	);
}
