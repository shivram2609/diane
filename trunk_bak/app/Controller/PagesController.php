<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
 
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';
	
/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	
	function beforefilter() {
		parent::beforefilter();
		$this->Auth->allow();
	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function index() {
		$this->loadModel("Course");
		$this->Course->recursive = -1;
		$this->set("countcourse",$this->Course->find("count",array("conditions"=>array("Course.status"=>1,"Course.publishstatus"=>"Publish","Course.visibility"=>'Public'))));
		$this->set("title_for_layout","Welcome to 1337 Institute of Technology");
		$this->loadModel('Configuration');
		$slides = $this->Configuration->find('list',array('fields'=>array("default_header","value"),'conditions'=>array('Configuration.default_header LIKE'=>'%HOMEPAGE_BANNER_IMAGE%','Configuration.default_header NOT LIKE "%HOMEPAGE_BANNER_IMAGE_TEXT%" and Configuration.default_header NOT LIKE "%HOMEPAGE_BANNER_IMAGE_LINK%"')));
		$slide_text = $this->Configuration->find('list',array('fields'=>array("default_header","value"),'conditions'=>array('Configuration.default_header LIKE'=>'%HOMEPAGE_BANNER_IMAGE_TEXT%')));
		$slide_links = $this->Configuration->find('list',array('fields'=>array("default_header","value"),'conditions'=>array('Configuration.default_header LIKE'=>'%HOMEPAGE_BANNER_IMAGE_LINK%')));
		$this->set(compact(array('slides','slide_text','slide_links')));
	}
	
	public function join() {
		$this->set("title_for_layout","Join Our Faculty");
	}
	
/* Displays a static page 
 * @param slug of the page
 * @return page text
 */
	public function staticpages($slug){
		$this->layout = 'frontend';
		$this->loadModel('Cmspages');
		$pagesName = $this->Cmspages->find('all', array('fields'=>array('Cmspages.name', 'Cmspages.seourl'), 'conditions'=>array('Cmspages.showinleft'=>1, 'Cmspages.status'=>1)));
		$pageContent = $this->Cmspages->find('first', array('conditions'=>array('Cmspages.seourl'=>$slug)));
		$this->set("title_for_layout",$pageContent['Cmspages']['name']);
		$this->set(compact('pagesName','pageContent'));
	}
	
	public function sitemap() {
		$this->layout = 'frontend';
		$this->set("title_for_layout","Site Map");
		$this->loadModel("Category");
		$categories = $this->Category->find("list",array("conditions"=>array("Category.status"=>1),"fileds"=>array("Category.id","Category.title"),'order'=>'Category.sort,Category.title'));
		$this->set(compact("categories"));
		$this->loadModel('Cmspages');
		$pagesName = $this->Cmspages->find('all', array('fields'=>array('Cmspages.name', 'Cmspages.seourl'), 'conditions'=>array('Cmspages.showinleft'=>1, 'Cmspages.status'=>1)));
		$this->set(compact('pagesName'));
	}
	
	function contactus() {
		$this->layout = "frontend";
		$this->set("title_for_layout","Contact Us");
		if (isset($this->data) && !empty($this->data)) {
			$this->mailBody .= "Sender Name: ".nl2br(strip_tags($this->data['Page']['first_name']))."<br/>";
			if (!empty($this->data['Page']['company'])) {
				$this->mailBody = "Company Name: ".$this->data['Page']['company']."<br/>";
			}
			$this->mailBody .= "Sender Email: ".nl2br(strip_tags($this->data['Page']['email']))."<br/>";
			$this->mailBody .= "Sender Phone: ".nl2br(strip_tags($this->data['Page']['phone']))."<br/>";
			$this->mailBody .= "Type:".nl2br(strip_tags($this->data['Page']['type']))."<br/>";
			$this->mailBody .= "Message:<br/>".nl2br(strip_tags($this->data['Page']['message']));
			$this->from = $this->data['Page']['email'];
			$this->subject = "Contact Request regarding ".$this->data['Page']['type'];
			$this->to = CONTACT_MAIL;
			if(!empty($this->to) && !empty($this->from)) {
				$flag = $this->sendmail($this->to,NULL,nl2br(strip_tags($this->data['Page']['first_name'],"<p>,<br/>")));
			} else {
				$flag = false;
			}
			if ($flag) {
				$this->Session->setFlash("Your query has been submitted.", 'default', array("class"=>"success_message"));
				$this->redirect("/contact-us");
			} else {
				$this->Session->setFlash("Your query can not be submitted, please try again.");
			}
		}
		$this->render("contact-us");
	}
	function support() {
		$this->layout = "frontend";
		$this->set("title_for_layout","Support");
		if (isset($this->data) && !empty($this->data)) {
			$this->mailBody .= "Sender Name: ".nl2br(strip_tags($this->data['Page']['first_name']))."<br/>";
			if (!empty($this->data['Page']['company'])) {
				$this->mailBody = "Company Name: ".$this->data['Page']['company']."<br/>";
			}
			$this->mailBody .= "Sender Email: ".nl2br(strip_tags($this->data['Page']['email']))."<br/>";
			$this->mailBody .= "Sender Phone: ".nl2br(strip_tags($this->data['Page']['phone']))."<br/>";
			$this->mailBody .= "Type:".nl2br(strip_tags($this->data['Page']['type']))."<br/>";
			$this->mailBody .= "Message:<br/>".nl2br(strip_tags($this->data['Page']['message']));
			$this->from = $this->data['Page']['email'];
			$this->subject = "Support Request regarding ".$this->data['Page']['type'];
			$this->to = CONTACT_MAIL;
			if(!empty($this->to) && !empty($this->from)) {
				$flag = $this->sendmail($this->to,NULL,nl2br(strip_tags($this->data['Page']['first_name'],"<p>,<br/>")));
			} else {
				$flag = false;
			}
			if ($flag) {
				$this->Session->setFlash("Your query has been submitted.", 'default', array("class"=>"success_message"));
				$this->redirect("/support");
			} else {
				$this->Session->setFlash("Your query can not be submitted, please try again.");
			}
		}
		$this->render("contact-us");
	}
}
