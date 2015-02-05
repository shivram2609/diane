<?php
App::uses('AppModel', 'Model');
/**
 * Message Model
 *
 * @property Application $Application
 * @property Campaign $Campaign
 * @property User $User
 */
class Message extends AppModel {


/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Sender'=>array(
			'className'=>'Userdetail',
			'foreignKey'=>false,
			'conditions'=>'Sender.user_id = Message.sender_id',
			'fields'=>array('Sender.first_name','Sender.last_name','Sender.user_id')
		),
		'Reciever'=>array(
			'className'=>'Userdetail',
			'foreignKey'=>false,
			'conditions'=>'Reciever.user_id = Message.reciever_id',
			'fields'=>array('Reciever.first_name','Reciever.last_name','Reciever.user_id')
		)
	);
	
	var $validate = array(
		'message'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter message'
			)
		)
	);
}
