<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined('SHOW_NO_OF_DATA')      OR 	define('SHOW_NO_OF_DATA', 10); // show no of data in table
defined('SHOW_NO_OF_DATA_PRODUCT')      OR 	define('SHOW_NO_OF_DATA_PRODUCT', 5); // show no of data in table

/////////////////// Sendgrid Mail//////////////////


defined('ANDROID_APP_LINK') 			OR  define('ANDROID_APP_LINK', "https://play.google.com/store/apps/details?id=com.app.divinesparks");
defined('IOS_APP_LINK') 				OR  define('IOS_APP_LINK', "#");


defined('ANDRIOD_API_ACCESS_KEY')		OR 	define('ANDRIOD_API_ACCESS_KEY','');
defined('IOS_API_ACCESS_KEY')			OR 	define('IOS_API_ACCESS_KEY','');

defined('SMS_AUTH_KEY')     			OR 	define('SMS_AUTH_KEY','');
defined('SMS_SENDER')     				OR 	define('SMS_SENDER','IndianLegal');
defined('SMS_COUNTRY_CODE')     		OR 	define('SMS_COUNTRY_CODE','91');
defined('SMS_SEND_STATUS')     			OR 	define('SMS_SEND_STATUS','NO');

defined('CURRENT_DATE')					OR 	define('CURRENT_DATE',date('Y-m-d'));
defined('CURRENT_TIME')					OR 	define('CURRENT_TIME',time());

defined('MAX_LOGIN_ATTEMPT')     		OR 	define('MAX_LOGIN_ATTEMPT','3');
defined('LOGIN_REATTEMPT_TIME')     	OR 	define('LOGIN_REATTEMPT_TIME','86400');

defined('APIKEY')     					OR 	define('APIKEY',md5("IndianLegal".date('Y-m-d')));
defined('APIDATE')     					OR 	define('APIDATE',date('Y-m-d'));


defined('DEFAULT_TIMEZONE')     		OR 	define('DEFAULT_TIMEZONE','Asia/Kolkata');
defined('CURR_TIMEZONE')      	   		OR 	define('CURR_TIMEZONE', 'Asia/Kolkata'); // set default time zone
/////////////   Localhost 		/////////////////
if($_SERVER['SERVER_NAME']=='localhost'):
	defined('TIME_DIFFRENCE')			OR 	define('TIME_DIFFRENCE','0'); 
	defined('MAIN_URL')     			OR 	define('MAIN_URL','http://'.$_SERVER['HTTP_HOST'].'/postponement/');
	$fileBaseUrl 						=	'http://'.$_SERVER['HTTP_HOST'].'/postponement/';
	$fileFCPATH 						=	$_SERVER['DOCUMENT_ROOT'].'/postponement/';

	$baseUrlForWebview					=	'http://'.$_SERVER['HTTP_HOST'].'/postponement/';
	$baseUrlForCommonWeb				=	'http://'.$_SERVER['HTTP_HOST'].'/postponement/';
///////////// 	/////////////////	
else: 
	defined('TIME_DIFFRENCE')			OR 	define('TIME_DIFFRENCE','1800');
	defined('MAIN_URL')     			OR 	define('MAIN_URL','http://'.$_SERVER['HTTP_HOST'].'/');
	$fileBaseUrl 						=	'https://'.$_SERVER['HTTP_HOST'].'/';
	$fileFCPATH 						=	$_SERVER['DOCUMENT_ROOT'].'/postponement/';

	$baseUrlForWebview					=	'http://'.$_SERVER['HTTP_HOST'].'/';
	$baseUrlForCommonWeb				=	'http://'.$_SERVER['HTTP_HOST'].'/'; 
endif;

defined('DEFAULT_TIMEZONE')     		OR 	define('DEFAULT_TIMEZONE','Asia/Kolkata');
defined('CURR_TIMEZONE')      	   		OR 	define('CURR_TIMEZONE', 'Asia/Kolkata'); // set default time zone

defined('fileBaseUrl')     				OR 	define('fileBaseUrl',$fileBaseUrl);
defined('fileFCPATH')     				OR 	define('fileFCPATH',$fileFCPATH);

defined('baseUrlForWebview')     		OR 	define('baseUrlForWebview',$baseUrlForWebview);
defined('baseUrlForCommonWeb')     		OR 	define('baseUrlForCommonWeb',$baseUrlForCommonWeb);