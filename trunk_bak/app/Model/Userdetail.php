<?php
App::uses('AppModel', 'Model');
/**
 * Userdetail Model
 *
 * @property User $User
 */
class Userdetail extends AppModel {


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
		'State' => array(
			'className' => 'State',
			'foreignKey' => 'state_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	var $validate = array(
		'first_name'=>array(
			'rule'=>'notempty',
			'message'=>'Please enter first name'
		),
		'last_name'=>array(
			'rule'=>'notempty',
			'message'=>'Please enter last name'
		),
		'country_id'=>array(
			'rule'=>'notempty',
			'message'=>'Please select country'
		),
		'state_id'=>array(
			'rule'=>'notempty',
			'message'=>'Please enter state'
		),
		'city'=>array(
			'rule'=>'notempty',
			'message'=>'Please enter city'
		),
		'image' => array(
			'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
			'message' => 'Please supply a valid image.',
			'allowEmpty'=>true
		),
		'cardnumber' => array(
			'cc'=>array(
				'rule' => array('cc', array('visa', 'maestro'), false, null),
				'message' => 'The credit card number you supplied was invalid.'
			),
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter card number'
			)
		),
		'cardtype'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter card type'
			)
		),
		'month'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter month'
			),
			'checkdate'=>array(
				'rule'=>'checkdate',
				'message'=>'Please enter valid date'
			)
		),
		'email'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter email'
			),
			'email'=>array(
				'rule'=>'email',
				'message'=>'Please enter valid email'
			)
		),
		'paypalaccount'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter paypal email'
			),
			'email'=>array(
				'rule'=>'email',
				'message'=>'Please enter valid paypal email'
			)
		)
	);
	function checkdate() {
		$curdate = date("m");
		$curyear = (date("Y"))*1;
		$month = ($this->data['Userdetail']['month'])*1;
		$curmonth = (date("m"))*1;
		$year = ($this->data['Userdetail']['year'])*1;
		if($year < $curyear) {
			return false;
		}
		if($year == $curyear && $month < $curmonth){
			return false;
		}
		else {
			return true;
		}
	}
}
