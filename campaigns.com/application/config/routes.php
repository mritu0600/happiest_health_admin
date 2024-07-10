<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
if(strpos($_SERVER['REQUEST_URI'],'api/')):
	###############################################################################################
	#################################		API FOR APP		  #####################################
	###############################################################################################
	///////////////////////////				USER			///////////////////////////////////////	
	$route['api/getStateList'] 								= 	'api/lowers/getStateList';	
	
else:
	###############################################################################################
	#################################		WEBSITE ADMIN	  #####################################
	###############################################################################################
	$route['default_controller'] 									= 'Home/index';
	$route['404_override'] 											= 	'';
	$route['translate_uri_dashes'] 									= 	FALSE;

	$curUrl						=	strpos($_SERVER['REQUEST_URI'],'/?')?explode('/?',$_SERVER['REQUEST_URI']):explode('?',$_SERVER['REQUEST_URI']); 
	$curUrl						=	explode('/',$curUrl[0]); //print_r($curUrl); die;
	if($_SERVER['SERVER_NAME']=='localhost'):	/////////////   Localhost 		/////////////////
		$firstSlug				=	isset($curUrl[3])?$curUrl[3]:''; 
		$secondSlug				=	isset($curUrl[4])?$curUrl[4]:'';
		$thirdSlug				=	isset($curUrl[5])?$curUrl[5]:'';
		$fourthlug				=	isset($curUrl[6])?$curUrl[6]:'';
	else: 	/////////////   SERVER		/////////////////	
		$firstSlug				=	isset($curUrl[1])?$curUrl[1]:'';
		$secondSlug				=	isset($curUrl[2])?$curUrl[2]:'';
		$thirdSlug				=	isset($curUrl[3])?$curUrl[3]:'';
		$fourthlug				=	isset($curUrl[4])?$curUrl[4]:'';
	endif;

	if(isset($firstSlug) && $firstSlug == 'admin'): 

		if($firstSlug == 'admin' && $secondSlug == ''):  
			$route['admin'] 											= 	'admin/login/index';
		elseif($secondSlug == 'login-verify-otp'):  
			$route['admin/login-verify-otp'] 							= 	'admin/login/loginverifyotp';
		elseif($secondSlug == 'resend-otp'):  	 
			$route['admin/resend-otp'] 									= 	'admin/login/resendotp';
		elseif($secondSlug == 'forgot-password'): 
			$route['admin/forgot-password'] 							= 	'admin/login/forgotpassword';
		elseif($secondSlug == 'password-recover'):  
			$route['admin/password-recover'] 							= 	'admin/login/passwordrecover';
		elseif($secondSlug == 'logout'):  
			$route['admin/logout'] 										= 	'admin/login/logout';
		elseif($secondSlug == 'maindashboard'):  
			$route['admin/maindashboard'] 								= 	'admin/account/maindashboard';
		elseif($secondSlug == 'dashboard'):  
			$route['admin/dashboard'] 									= 	'admin/account/maindashboard';
		elseif($secondSlug == 'profile'):  		
			$route['admin/profile'] 									= 	'admin/account/profile';
		elseif($secondSlug == 'editprofile'):  
			$route['admin/editprofile'] 								= 	'admin/account/editprofile';
			$route['admin/editprofile/(:any)'] 							= 	'admin/account/editprofile/$1';
		elseif($secondSlug == 'change-password'):  
			$route['admin/change-password'] 							= 	'admin/account/changepassword';
			$route['admin/change-password/(:any)'] 						= 	'admin/account/changepassword/$1';
		elseif($secondSlug == 'change-password-verify-otp'):  
			$route['admin/change-password-verify-otp'] 					= 	'admin/account/changepasswordverifyotp';
			elseif($secondSlug == 'get-subcategory'):  
				$route['admin/get-subcategory'] 					    = 	'admin/adminmanageproducts/getsubcategory';
				elseif($secondSlug == 'get-subsubcategory'):  
					$route['admin/get-subsubcategory'] 					= 	'admin/adminmanageproducts/getsubsubcategory';
		else:
			require_once(BASEPATH.'database/DB.php');
			$db 					=	& DB();

			$newCurUrl				=	explode('/admin/',$_SERVER['REQUEST_URI']); 
			if($_SERVER['SERVER_NAME']=='localhost'):	 
				$classFunction		=	isset($newCurUrl[1])?$newCurUrl[1]:'';
			else: 
				$classFunction		=	isset($newCurUrl[1])?$newCurUrl[1]:'';
			endif;  
			$classFunction			=	strpos($classFunction,'/?')?explode('/?',$classFunction):explode('?',$classFunction); 
			if($classFunction[0]):		
				$defaultClassArray	=	array('department','designation','subadmin');
				$classArray			=	explode('/',$classFunction[0]);
				if(isset($classArray[0])):	
					$classQuery 	= 	$db->select('module_id')->from('admin_module')->where("module_name = '".$classArray[0]."'")->get();
					$classData		= 	$classQuery->result();
					$subClassQuery 	= 	$db->select('child_module_id')->from('admin_module_child')->where("module_name = '".$classArray[0]."'")->get();
					$subClassData	= 	$subClassQuery->result();  
					if($classData):		
						$route[$classFunction[0]] 						= 	'admin/'.$classFunction[0]; 
					elseif($subClassData):	
						$route[$classFunction[0]] 						= 	'admin/'.$classFunction[0]; 
					elseif(in_array($classArray[0],$defaultClassArray)): 
						$route[$classFunction[0]] 						= 	'admin/'.$classFunction[0]; 
					endif;
				endif;
			endif;
		endif;
	else:	
		////////////////////	HOME	////////////////////
		$route['home'] 						= 	'home/index';
		$route['screen-2'] 						= 	'home/screen_2';
		$route['screen-3'] 						= 	'home/screen_3';
		$route['screen-4'] 						= 	'front/education/screen_4';
		$route['screen-5-new'] 						= 	'front/education/screen_5_new';
		$route['screen-6-new'] 						= 	'front/education/screen_6_new';
		$route['screen-7'] 						= 	'front/education/screen_7';
		$route['screen-7A'] 						= 	'front/education/screen_7A';
		$route['screen-8'] 						= 	'front/education/screen_8';
		$route['screen-9'] 						= 	'front/education/screen_9';
		//$route['insertdata'] 						= 	'front/education/insert';
		$route['screen-4-retirement'] 						= 	'front/retirement/screen_4_retirement';
		$route['screen-5-retirement'] 						= 	'front/retirement/screen_5_retirement';
		$route['screen-6-retirement'] 						= 	'front/retirement/screen_6_retirement';
		$route['screen-7-retirement'] 						= 	'front/retirement/screen_7_retirement';
		$route['screen-7A-retirement'] 						= 	'front/retirement/screen_7A_retirement';
		$route['screen-8-retirement'] 						= 	'front/retirement/screen_8_retirement';
		$route['screen-9-retirement'] 						= 	'front/retirement/screen_9_retirement';
		$route['screen-4-savings'] 						= 	'front/wealth/screen_4_savings';
		$route['screen-5-savings'] 						= 	'front/wealth/screen_5_savings';
		$route['screen-6-savings'] 						= 	'front/wealth/screen_6_savings';
		$route['screen-7A-savings'] 						= 	'front/wealth/screen_7A_savings';
		$route['screen-8-savings'] 						= 	'front/wealth/screen_8_savings';
		$route['screen-9-saving'] 						= 	'front/wealth/screen_9_saving';
	endif;
endif;
// echo '<pre>';  print_r($route); die;