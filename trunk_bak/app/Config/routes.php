<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/join-our-faculty', array('controller' => 'pages', 'action' => 'join'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect('/admin', array('controller' => 'admins', 'action' => 'login'));
	Router::connect('/admin/dashboard', array('controller' => 'admins', 'action' => 'dashboard'));
	Router::connect('/admin/forgotpassword', array('controller' => 'admins', 'action' => 'forgotpassword'));
	Router::connect('/admin/changepassword', array('controller' => 'admins', 'action' => 'changepassword'));
	Router::connect('/admin/confirmation/*', array('controller' => 'admins', 'action' => 'confirmation'));
	Router::connect('/admin/configurations/*', array('controller' => 'admins', 'action' => 'configurations'));
	Router::connect('/admin/editprofile', array('controller' => 'admins', 'action' => 'editprofile'));
	Router::connect('/admin/newsletter', array('controller' => 'admins', 'action' => 'newsletter'));
	Router::connect('/admin/logout', array('controller' => 'admins', 'action' => 'logout'));
	
	
	
	Router::connect('/login/*', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/signup', array('controller' => 'users', 'action' => 'signup'));
	Router::connect('/dashboard', array('controller' => 'users', 'action' => 'dashboard'));
	Router::connect('/forgotpassword', array('controller' => 'users', 'action' => 'forgotpassword'));
	Router::connect('/changepassword', array('controller' => 'users', 'action' => 'changepassword'));
	Router::connect('/profile/*', array('controller' => 'users', 'action' => 'viewprofile'));
	Router::connect('/follow/*', array('controller' => 'users', 'action' => 'follow'));
	Router::connect('/unfollow/*', array('controller' => 'users', 'action' => 'unfollow'));
	
	Router::connect('/editprofile/*', array('controller' => 'userdetails', 'action' => 'edit_profile'));
	Router::connect('/profilepic/*', array('controller' => 'userdetails', 'action' => 'edit_profile_photo'));
	Router::connect('/account/*', array('controller' => 'userdetails', 'action' => 'edit_profile_account'));
	Router::connect('/paypal-account/*', array('controller' => 'userdetails', 'action' => 'premium_instructor'));
	Router::connect('/privacy/*', array('controller' => 'userdetails', 'action' => 'edit_profile_privacy'));
	Router::connect('/notifications/*', array('controller' => 'userdetails', 'action' => 'edit_profile_notification'));
	Router::connect('/deleteaccount/*', array('controller' => 'userdetails', 'action' => 'edit_profile_dangerzone'));
		
	Router::connect('/deleteprofile/*', array('controller' => 'users', 'action' => 'deleteprofile'));
	Router::connect('/sendmessage/*', array('controller' => 'messages', 'action' => 'send'));
	Router::connect('/compose/*', array('controller' => 'messages', 'action' => 'composemessage'));
	Router::connect('/inbox/*', array('controller' => 'messages', 'action' => 'inbox'));
	Router::connect('/sent-message/*', array('controller' => 'messages', 'action' => 'sentmessage'));
	Router::connect('/trash/*', array('controller' => 'messages', 'action' => 'trashmessage'));
	Router::connect('/movetrash/*', array('controller' => 'messages', 'action' => 'movetrash'));
	Router::connect('/removemessage/*', array('controller' => 'messages', 'action' => 'removemessage'));
	Router::connect('/message/*', array('controller' => 'messages', 'action' => 'viewmessages'));
	Router::connect('/course-manage/create', array('controller' => 'courses', 'action' => 'add'));
	Router::connect('/course-manage/edit-course/*', array('controller' => 'courses', 'action' => 'edit'));
	Router::connect('/course-manage/basic/*', array('controller' => 'courses', 'action' => 'basic'));
	Router::connect('/course-manage/introduction/*', array('controller' => 'courses', 'action' => 'basic'));
	Router::connect('/course-manage/details/*', array('controller' => 'courses', 'action' => 'details'));
	Router::connect('/course-manage/cover-image/*', array('controller' => 'courses', 'action' => 'coverimage'));
	Router::connect('/course-manage/promo-video/*', array('controller' => 'courses', 'action' => 'promovideo'));
	Router::connect('/course-manage/details/*', array('controller' => 'courses', 'action' => 'details'));
	Router::connect('/course-manage/course-summary/*', array('controller' => 'courses', 'action' => 'details'));
	Router::connect('/course-manage/privacy/*', array('controller' => 'courses', 'action' => 'privacy'));
	Router::connect('/course-manage/price/*', array('controller' => 'courses', 'action' => 'price'));
	Router::connect('/course-manage/instructors/*', array('controller' => 'courses', 'action' => 'instructors'));
	Router::connect('/course-manage/delete-course/*', array('controller' => 'courses', 'action' => 'dangerzone'));
	Router::connect('/course-manage/delete-instructor/*', array('controller' => 'courses', 'action' => 'deleteinstructor'));
	Router::connect('/course-manage/delete-courses/*', array('controller' => 'courses', 'action' => 'deletecourse'));
	Router::connect('/course-manage/edit-curriculum/*', array('controller' => 'courses', 'action' => 'editcurriculum'));
	Router::connect('/course-manage/syllabus/*', array('controller' => 'courses', 'action' => 'editcurriculum'));
	Router::connect('/course-manage/guidelines/*', array('controller' => 'courses', 'action' => 'gettingstarted'));
	Router::connect('/course-manage/price/*', array('controller' => 'courses', 'action' => 'pricecoupons'));
	Router::connect('/course-manage/session/*', array('controller' => 'courses', 'action' => 'livesession'));
	Router::connect('/course-manage/publish/*', array('controller' => 'courses', 'action' => 'publish'));
	Router::connect('/course-manage/unpublish/*', array('controller' => 'courses', 'action' => 'unpublish'));
	Router::connect('/mycourses/*', array('controller' => 'courses', 'action' => 'relatedcourses','t'));
	Router::connect('/view-courses/*', array('controller' => 'courses', 'action' => 'search'));
	Router::connect('/takecourse/*', array('controller' => 'courses', 'action' => 'takecourse'));
	Router::connect('/c/*', array('controller' => 'courses', 'action' => 'view'));
	Router::connect('/g/*', array('controller' => 'courses', 'action' => 'redirecttoview','g'));
	Router::connect('/i/*', array('controller' => 'courses', 'action' => 'redirecttoview','i'));
	Router::connect('/s/*', array('controller' => 'courses', 'action' => 'redirecttoview','s'));
	Router::connect('/v/*', array('controller' => 'courses', 'action' => 'viewlecture'));
	Router::connect('/q/*', array('controller' => 'courses', 'action' => 'viewquiz'));
	Router::connect('/ipnhandler/*', array('controller' => 'courses', 'action' => 'ipnhandler'));
	Router::connect('/ipnhandler', array('controller' => 'courses', 'action' => 'ipnhandler'));
	Router::connect('/ipnhandler.php', array('controller' => 'courses', 'action' => 'ipnhandler'));
	//Router::connect('/mywishlist', array('controller' => 'courses', 'action' => 'relatedcourses','w'));
	//Router::connect('/wishlist/*', array('controller' => 'courses', 'action' => 'userrelatedcourses'));
	Router::connect('/mylearnings', array('controller' => 'courses', 'action' => 'relatedcourses','l'));
	Router::connect('/learnings/*', array('controller' => 'courses', 'action' => 'userrelatedcourses'));
	Router::connect('/myenrolled', array('controller' => 'courses', 'action' => 'relatedcourses','l'));
	Router::connect('/enrolled/*', array('controller' => 'courses', 'action' => 'userrelatedcourses'));
	Router::connect('/mycompleted', array('controller' => 'courses', 'action' => 'relatedcourses','c'));
	Router::connect('/viewratings/*', array('controller' => 'courses', 'action' => 'viewratings'));
	Router::connect('/viewrecents/*', array('controller' => 'courses', 'action' => 'viewrecent'));
	Router::connect('/viewallcourse/*', array('controller' => 'courses', 'action' => 'viewallcourse'));
	Router::connect('/login_with_twitter', array('controller' => 'users', 'action' => 'loginwith','Twitter'));
	Router::connect('/successfuly-enrolled/*', array('controller' => 'courses', 'action' => 'successfullyenrolled'));
	Router::connect('/make-payment/*', array('controller' => 'courses', 'action' => 'makepayment'));
	Router::connect('/question/*', array('controller' => 'courses', 'action' => 'viewuserquestion'));
	
	Router::connect('/st/*', array('controller' => 'pages', 'action' => 'staticpages'));
	Router::connect('/site-map', array('controller' => 'pages', 'action' => 'sitemap'));
	Router::connect('/contact-us', array('controller' => 'pages', 'action' => 'contactus'));
	Router::connect('/support', array('controller' => 'pages', 'action' => 'support'));
	
	CakePlugin::routes('Blog'); // Load Blog plugin routes
	
/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
