<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
 */
class Order extends AppModel {
	public $belongsTo = array(
		'Buyer' => array(
			'className' => 'Userdetail',
			'foreignKey' => false,
			'conditions' => 'Buyer.user_id = Order.buyer_id',
			'fields' => array('Buyer.first_name','Buyer.last_name','Buyer.id'),
			'order' => ''
		),
		'Seller' => array(
			'className' => 'Userdetail',
			'foreignKey' => false,
			'conditions' => 'Seller.user_id = Order.seller_id',
			'fields' => array('Seller.first_name','Seller.last_name','Seller.id'),
			'order' => ''
		),
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => array('Course.title','Course.id'),
			'order' => ''
		)
	);
}
