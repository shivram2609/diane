<?php

/* Messages to display on pages as server side messages (Admin Section) */
	/* used in controller */
		define("PAGES_ADD_SUCC_MESS",'The page has been saved');
		define("PAGES_ADD_ERR_MESS",'The page could not be saved. Please, try again.');
		define("PAGES_UPD_SUCC_MESS",'The cms page has been saved');
		define("PAGES_UPD_ERR_MESS",'The cms page could not be saved. Please, try again.');
		define("PAGES_INV_ERR_MESS",'Invalid page');
		define("PAGES_DEL_SUCC_MESS",'Page deleted');
		define("PAGES_DEL_ERR_MESS",'Page was not deleted');
	/* end here */
	/* used in model */
		define("PAGE_NAME",'Please enter name of page');
		define("PAGE_NAME_EXISTS",'Same name page is already exist');
		define("PAGE_CONTENT",'Please enter content');
		define("PAGE_METATITLE",'Please enter metatitle');
		define("PAGE_SEOURL",'Please enter seourl');
		define("PAGE_METADESC",'Please enter metadescription');
		define("PAGE_METAKEY",'Please enter metakeyword');
	/* end here */
/* end here */


define("ADMIN_VALID_MESSAGE","Please enter valid Username & Password");

/* forgot password messages */
	define("INVALID_EMAIL_FORGOT_PASSWORD","Email doesn't exist. Please try again.");
	define("ALREADY_SENT_FORGOT_PASSWORD","Password has already been sent to your email id.");
	define("NEW_SENT_FORGOT_PASSWORD","New password has been sent to your Email Address.");
	define("FAIL_SENT_FORGOT_PASSWORD","Email sending failed. Plz <a href=''>try again</a>.");
/* end here */

/* change password messages */
	define("OLD_PASSWORD_ERROR","Current password is not correct");
	define("CHANGE_PASSWORD_MESSAGE","Password has been updated successfully");
	define("CONFIRM_PASSWORD_MESSAGE","New and confirm password do not match");
	define("CONFIRM_PASSWORD_ERROR","New and confirm password do not match");
/* end here */

	define("INDUSTRY_MESSAGE","Select industry");

?>
