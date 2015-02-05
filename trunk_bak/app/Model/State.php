<?php
App::uses('AppModel', 'Model');
/**
 * State Model
 *
 * @property Country $Country
 * @property City $City
 */
class State extends AppModel {
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
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
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
		'City' => array(
			'className' => 'City',
			'foreignKey' => 'state_id',
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
	
	var $validate	= array(
		'name'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter state name'
			)
		),
		'code'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter state code'
			)
		)
	);

}
