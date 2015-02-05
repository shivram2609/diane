<?php
App::uses('AppModel', 'Model');
/**
 * Backupdb Model
 *
 */
class Backupdb extends AppModel {
	var $validate = array(
		'filename'=>array(
			'notempty'=>array(
				'rule'=>'notempty',
				'message'=>'Please enter filename'
			)
		)
	);


}
