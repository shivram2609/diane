<?php
App::uses('AppModel', 'Model');
/**
 * Cmsemail Model
 *
 */
class Cmsemail extends AppModel {
	var $validate = array(
		"mailfrom"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>"Please enter mail from"
			),
			"email"=>array(
				"rule"=>"email",
				"message"=>"Please enter valid email"
			)
		),
		"mailsubject"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>"Please enter mail subject"
			)
		),
		"mailcontent"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>"Please enter mail content"
			)
		)
	);
}
