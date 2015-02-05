<?php
App::uses('AppModel', 'Model');
/**
 * Follower Model
 *
 * @property User $User
 * @property Follower $Follower
 */
class Follower extends AppModel {


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
		'Follow' => array(
			'className' => 'User',
			'foreignKey' => 'follower_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
