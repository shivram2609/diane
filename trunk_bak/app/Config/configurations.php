<?php
/* Database Configurations */
define("DB_HOST","localhost");
define("DB_USER","root"); //1337iot
define("DB_PASSWORD","ztech@44"); //HHsANLWAUwPQJ5Js
define("DB_NAME","1337IOT");
/* Database Configurations end */
/* Image and Pdf uploading path, urls and their size's */
	define("FFMPEG_PATH", '/usr/bin/ffmpeg'); //ffmpeg path
	define('ImageUploadingPath',WWW_ROOT.'img/'					); //Image uploading path
	define('MashupPdfUploadingPath',WWW_ROOT.'files/uploaded_pdf/'); //mashup pdf uploading path
	define('MashupVideoUploadingPath',WWW_ROOT.'files/mashup_videos/'); //mashup pdf uploading path
	define('MashupImageUploadingPath',WWW_ROOT.'img/mashup_images/'); //mashup images uploading path
	define('MashupImagesXmlUploadingPath',WWW_ROOT.'files/mashup_images_xml/'); //mashup images uploading path
	define('MashupXmlUploadingPath',WWW_ROOT.'files/mashup_xml/'); //mashup images uploading path
	$a=explode('/',$_SERVER['PHP_SELF']);	//get the full path and explode with the forward slash(/)
	$last_index='';
	foreach($a as $key=>$value){	//get the root directory
		if($value == 'app')break;
		$last_index .= $value.'/';	
	}
	$last_index = 'http://'.$_SERVER['SERVER_NAME'].$last_index;
 	define('ImageUrl',$last_index.'img/');	//image url
 	define('MashupPdfUrl',$last_index.'files/uploaded_pdf/');	//uploaded mashup pdf url
 	define('MashupVideoUrl',$last_index.'files/mashup_videos/');	//uploaded mashup pdf url
 	define('MashupImageUrl',ImageUrl.'mashup_images/');	//uploaded mashup images url
 	define('MashupImagesXmlUrl', $last_index.'files/mashup_images_xml/');	//uploaded mashup images url
 	define('MashupXmlUrl', $last_index.'files/mashup_xml/');	//uploaded mashup images url

 	define('LargeImagePrefix', 'large_'); //prefix of large size images
 	define('MediumImagePrefix', 'medium_'); //prefix of medium size images
 	define('MediumSmallImagePrefix', 'msmall_'); //prefix of medium small size images
 	define('SmallImagePrefix', 'small_'); //prefix of small size images
 	define('ThumbImagePrefix', 'thumb_'); //prefix of thumb size images

 	define('LargeImage',800); //large images size
 	define('MediumImage',400); //medium images size
 	define('MediumSmallImage',200); //medium small images size
 	define('SmallImage',100); //small images size
 	define('ThumbImage',50); //thumb images size
 	
	define('MashupVideoMaxSize', 209715200); //mashup max uploaded video size in bytes, default is 200 mb. 
	define('MashupPdfMaxSize', 10485760); //mashup max uploaded pdf size in bytes, default is 10 mb. 
	
		
	/* Profile Image */
	
	define('LargeProfileImagePrefix', 'largeProfile_'); //prefix of large size images
 	define('MediumProfileImagePrefix', 'mediumProfile_'); //prefix of medium size images
 	define('MediumSmallProfileImagePrefix', 'msmallProfile_'); //prefix of medium small size images
 	define('SmallImageProfilePrefix', 'smallProfile_'); //prefix of small size images
 	define('ThumbImageProfilePrefix', 'thumbProfile_'); //prefix of thumb size images

 	define('LargeProfileImage',210); //large images size
 	define('MediumProfileImage',168); //medium images size
 	define('MediumSmallProfileImage',108); //medium small images size
 	define('SmallProfileImage',90); //small images size
 	define('ThumbProfileImage',34); //thumb images size
	
	/* Course Image */
	
	define('LargeCourseImagePrefix', 'largeCourse_'); //prefix of large size images
 	define('MediumCourseImagePrefix', 'mediumCourse_'); //prefix of medium size images
 	define('MediumSmallCourseImagePrefix', 'msmallCourse_'); //prefix of medium small size images
 	define('SmallCourseImagePrefix', 'smallCourse_'); //prefix of medium small size images
 	
 	define('LargeCourseImageWidth',513); //large images size
 	define('LargeCourseImageHeight',211); //large images size
 	define('MediumCourseImageWidth',300); //medium small images size
 	define('MediumCourseImageHeight',232); //medium small images size
 	define('MediumSmallCourseImageWidth',250); //medium images size
 	define('MediumSmallCourseImageHeight',185); //medium images size
 	define('SmallCourseImage',112); //medium small images size

?>
