<?php
App::uses('AppModel', 'Model');
/**
 * Admin Model
 *
 * @property Admindetail $Admindetail
 * @property User $User
 */
class Admin extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Admindetail' => array(
			'className' => 'Admindetail',
			'foreignKey' => 'admin_id',
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
		
	);
	
	var $validate	= array(
		'username'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter username'
			),
			'email'=>array(
				'rule'=>'email',
				'message'=>'Please enter valid email'
			),
			'isUnique'=>array(
			'rule'    => 'isUnique',
            'message' => 'Email already exists'
            )
		),
		'password'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter password'
			),
			'minlength'=>array(
				'rule'=>array('minlength',5),
				'message'=>'Password size min 5 chracters'
			)
		),
		'confirm password'=>array(
			'rule'=>'confirmpassword',
			'message'=>'Password and Cofirm password do not match'
		),
		'domain'=>array(
			'rule'=>'notempty',
			'message'=>'Please enter domain'
		)
	);
	
	function confirmpassword() {
		$value = $_REQUEST['data']['Admin']['confirm password'];
		if ($value == $_REQUEST['data']['Admin']['password']) {
		  return true;
		} else {
		  return false;
		}
	}
}
