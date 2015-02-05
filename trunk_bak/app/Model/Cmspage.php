<?php
App::uses('AppModel', 'Model');
/**
 * Cmspage Model
 *
 */
class Cmspage extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	
	var $validate	=	array(
		"name"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>PAGE_NAME
			),
			"isUnique"=>array(
				"rule"=>"isUnique",
				"message"=>PAGE_NAME_EXISTS
			)
		),
		"content"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>PAGE_CONTENT
			)
		),
		"metatitle"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>PAGE_METATITLE
			)
		),
		"seourl"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>PAGE_SEOURL
			)
		),
		"metadesc"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>PAGE_METADESC
			)
		),
		"metakeyword"=>array(
			"notempty"=>array(
				"rule"=>"notempty",
				"message"=>PAGE_METAKEY 
			)
		)
	);
}
