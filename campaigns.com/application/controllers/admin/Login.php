<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function  __construct() 
	{ 
		parent:: __construct();
		//error_reporting(E_ALL ^ E_NOTICE);  
		error_reporting(0);  
		$this->load->model(array('admin_model','emailtemplate_model','notification_model'));
		$this->lang->load('statictext', 'admin');
		$this->load->helper('common');
	} 
	
	/* * *********************************************************************
	 * * Function name : login
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function for login
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function index()
	{	
		if($this->session->userdata('ILCADM_ADMIN_ID')) redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'maindashboard');
		$data['error'] 						= 	'';
		/*-----------------------------------Login ---------------*/
		if($this->input->post('loginFormSubmit')):	
			//Set rules
			$this->form_validation->set_rules('userEmail', 'email', 'trim|required');
			$this->form_validation->set_rules('userPassword', 'password', 'trim|required');
			
			if($this->form_validation->run()):	
				$result		=	$this->admin_model->Authenticate($this->input->post('userEmail')); 
				if($result): 
					if($this->admin_model->decryptsPassword($result['admin_password']) != $this->input->post('userPassword')):
						$data['error'] = lang('invalidpassword');	
					elseif($result['status'] != 'A'):	
						$data['error'] = lang('accountblock');	
					else:	
						$loginParam['admin_id']				=	(int)$result['admin_id'];
						$loginParam['admin_token']			=	generateToken();
						$loginParam['login_status']			=	'Login';
						$loginParam['login_datetime']		=	(int)$this->timezone->utc_time();//currentDateTime();
						$loginParam['login_ip']				=	currentIp();
						$logininsertId						=	$this->common_model->addData('admin_login_log',$loginParam);
					
						$currentPath 		=	getCurrentBasePath().'admin/';
						$this->session->set_userdata(array(
						'ILCADM_ADMIN_LOGGED_IN'		=>	true,
						'ILCADM_ADMIN_ID'				=>	$result['admin_id'],
						'ILCADM_ADMIN_TITLE'			=>	$result['admin_title'],
						'ILCADM_ADMIN_FIRST_NAME'		=>	$result['admin_first_name'],
						'ILCADM_ADMIN_MIDDLE_NAME'		=>	$result['admin_middle_name'],
						'ILCADM_ADMIN_LAST_NAME'		=>	$result['admin_last_name'],
						'ILCADM_ADMIN_EMAIL'			=>	$result['admin_email'],
						'ILCADM_ADMIN_MOBILE'			=>	$result['admin_phone'],
						'ILCADM_ADMIN_IMAGE'			=>	$result['admin_image'],
						'ILCADM_ADMIN_ADDRESS'			=>	$result['admin_address'],
						'ILCADM_ADMIN_CITY'				=>	$result['admin_city'],
						'ILCADM_ADMIN_STATE'			=>	$result['admin_state'],
						'ILCADM_ADMIN_COUNTRY'			=>	$result['admin_country'],
						'ILCADM_ADMIN_ZIPCODE'			=>	$result['admin_pincode'],
						'ILCADM_ADMIN_TYPE'				=>	$result['admin_type'],
						'ILCADM_ADMIN_CURRENT_PATH'		=>	$currentPath,
						'ILCADM_ADMIN_USER_TYPE'		=>	'',
						'ILCADM_ADMIN_LAST_LOGIN'		=>	$result['last_login_date'].' ('.$result['last_login_ip'].')'));
					
							setcookie('ILCADM_ADMIN_LOGIN_TOKEN',$loginParam['admin_token'],time()+60*60*24*100,'/');
					
							if($_COOKIE['ILCADM_ADMIN_REFERENCE_PAGES']):
								redirect(base_url().$_COOKIE['ILCADM_ADMIN_REFERENCE_PAGES']);
							else:
							redirect($currentPath.'maindashboard');
							endif;
				endif;
				else:
					$data['error'] = lang('invalidlogindetails');
				endif;			
			endif;
		endif;
		
		$this->layouts->set_title('Login');
		$this->layouts->admin_view('account/login',array(),$data,'login');
	}

	/* * *********************************************************************
	 * * Function name : loginverifyotp
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for admin password recover
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	//spublic function loginverifyotp()
	// {	
	// 	if($this->session->userdata('ILCADM_ADMIN_ID')) redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'maindashboard');
	// 	$data['error'] 						= 	'';
	// 	$data['recovererror'] 				=	''; 

	// 	/*-----------------------------------recover password ---------------*/
	// 	if($this->input->post('otpVerificationFormSubmit')):	
	// 		//Set rules
	// 		$this->form_validation->set_rules('userOtp', 'otp', 'trim|required|min_length[4]|max_length[4]');
			
	// 		if($this->form_validation->run()):	
	// 			$result		=	$this->admin_model->checkOTP($this->input->post('userOtp'));
	// 			if($result): 
	// 				$this->session->unset_userdata(array('otpType','otpAdminId','otpAdminMobile'));

	// 				$param['last_login_ip']				=	currentIp();
	// 				$param['last_login_date']			=	(int)$this->timezone->utc_time();//currentDateTime();
	// 				$param['admin_password_otp']		=	'';
	// 				$this->common_model->editData('admin',$param,'admin_id',$result['admin_id']);

	// 				############	LOGOUT IN PRIVIOUS SYSTEM 	#######
	// 				/*
	// 				$logoutParam['admin_token']			=	'';
	// 				$logoutParam['login_status']		=	'Logout';
	// 				$logoutParam['logout_datetime']		=	(int)$this->timezone->utc_time();//currentDateTime();
	// 				$logoutParam['logout_ip']			=	currentIp();

	// 				$logoutuWhere['login_status']		=	'Login';
	// 				$logoutuWhere['admin_id']			=	(int)$result['admin_id'];
	// 				$this->common_model->editDataByMultipleCondition('ILCADM_admin_login_log',$logoutParam,$logoutuWhere);	
	// 				*/
	// 				############	LOGIN IN NEW SYSTEM 	############
	// 				$loginParam['admin_id']				=	(int)$result['admin_id'];
	// 				$loginParam['admin_token']			=	generateToken();
	// 				$loginParam['login_status']			=	'Login';
	// 				$loginParam['login_datetime']		=	(int)$this->timezone->utc_time();//currentDateTime();
	// 				$loginParam['login_ip']				=	currentIp();
	// 				$logininsertId						=	$this->common_model->addData('admin_login_log',$loginParam);

	// 				$currentPath 		=	getCurrentBasePath().'admin/';
	// 				$this->session->set_userdata(array(
	// 									'ILCADM_ADMIN_LOGGED_IN'		=>	true,
	// 									'ILCADM_ADMIN_ID'				=>	$result['admin_id'],
	// 									'ILCADM_ADMIN_TITLE'			=>	$result['admin_title'],
	// 									'ILCADM_ADMIN_FIRST_NAME'		=>	$result['admin_first_name'],
	// 									'ILCADM_ADMIN_MIDDLE_NAME'		=>	$result['admin_middle_name'],
	// 									'ILCADM_ADMIN_LAST_NAME'		=>	$result['admin_last_name'],
	// 									'ILCADM_ADMIN_EMAIL'			=>	$result['admin_email'],
	// 									'ILCADM_ADMIN_MOBILE'			=>	$result['admin_phone'],
	// 									'ILCADM_ADMIN_IMAGE'			=>	$result['admin_image'],
	// 									'ILCADM_ADMIN_ADDRESS'			=>	$result['admin_address'],
	// 									'ILCADM_ADMIN_CITY'				=>	$result['admin_city'],
	// 									'ILCADM_ADMIN_STATE'			=>	$result['admin_state'],
	// 									'ILCADM_ADMIN_COUNTRY'			=>	$result['admin_country'],
	// 									'ILCADM_ADMIN_ZIPCODE'			=>	$result['admin_pincode'],
	// 									'ILCADM_ADMIN_TYPE'				=>	$result['admin_type'],
	// 									'ILCADM_ADMIN_CURRENT_PATH'		=>	$currentPath,
	// 									'ILCADM_ADMIN_USER_TYPE'		=>	'',
	// 									'ILCADM_ADMIN_LAST_LOGIN'		=>	$result['last_login_date'].' ('.$result['last_login_ip'].')'));

	// 				setcookie('ILCADM_ADMIN_LOGIN_TOKEN',$loginParam['admin_token'],time()+60*60*24*100,'/');

	// 				if($_COOKIE['ILCADM_ADMIN_REFERENCE_PAGES']):
	// 					redirect(base_url().$_COOKIE['ILCADM_ADMIN_REFERENCE_PAGES']);
	// 				else:
	// 					redirect($currentPath.'maindashboard');
	// 				endif;
	// 			else:
	// 				$data['recovererror'] = lang('invalidotp');
	// 			endif;
	// 		endif;
	// 	endif;
		
	// 	$this->layouts->set_title('Password Recover');
	// 	$this->layouts->admin_view('account/loginverifyotp',array(),$data,'login');
	// }	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : resendotp
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for resend otp
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function resendotp()
	{	
		if(sessionData('otpType') && sessionData('otpAdminId') && sessionData('otpAdminMobile')):
			$param['admin_password_otp']	=	(int)'4321';//(int)generateRandomString(4,'n');
			$this->common_model->editData('admin',$param,'admin_id',(int)sessionData('otpAdminId'));

			if(sessionData('otpType') == 'Login'):
				$this->sms_model->sendLoginOtpSmsToUser(sessionData('otpAdminMobile'),$param['admin_password_otp']);
			elseif(sessionData('otpType') == 'Forgot Password'):
				$this->sms_model->sendForgotPasswordOtpSmsToUser(sessionData('otpAdminMobile'),$param['admin_password_otp']);
			elseif(sessionData('otpType') == 'Change Password'):
				$this->sms_model->sendChangePasswordOtpSmsToUser(sessionData('otpAdminMobile'),$param['admin_password_otp']);
			endif;

			$this->session->set_flashdata('alert_success',lang('sendotptomobile').sessionData('otpAdminMobile'));
		endif;
		redirect($_SERVER['HTTP_REFERER']);
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : forgotpassword
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for admin forgot password
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function forgotpassword()
	{	
		if($this->session->userdata('ILCADM_ADMIN_ID')) redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'maindashboard');
		$data['error'] 						= 	'';
		$data['forgoterror'] 				= 	'';

		/*-----------------------------------Forgot password ---------------*/
		if($this->input->post('recoverformSubmit')):	
			//Set rules
			$this->form_validation->set_rules('forgotEmail', 'Email', 'trim|required|min_length[5]|max_length[64]');
			
			if($this->form_validation->run()):	
				$result		=	$this->common_model->getDataByParticularField('admin','admin_email',$this->input->post('forgotEmail'));
				if($result):
					if($result['status'] != 'A'):	
						$data['forgoterror'] = lang('accountblock');	
					else:
						$param['admin_password_otp']		=	rand(1000, 9999);     //(int)'4321';//(int)generateRandomString(4,'n');
						$this->common_model->editData('admin',$param,'admin_id',(int)$result['admin_id']);

						//$this->sms_model->sendForgotPasswordOtpSmsToUser($result['admin_phone'],$param['admin_password_otp']);
						
						$message 	= "
    		            <html>
    		            <head>
    		            <title> The Divine Sparks | Forgot Admin Panel Password </title>
    		            </head>
    		            <body>
    		            <p>Use this OTP ".$param['admin_password_otp']." to reset your password.</p>
    		            </body>
    		            </html>
    		            ";
    		            $subject 	= " THE DIVINE SPARKS|Reset Admin Password OTP";
    				    $emailToUser = array(
    				    	'from_mail'			=>	MAIL_FROM_EMAIL,
    				    	'from_mail_name'	=>	MAIL_FROM_NAME,
    				    	'subject'			=>	$subject,
    				    	'to_mail'			=>	$result['admin_email'],
    				    	'to_mail_name'		=>	'Admin',
    				    	'html'				=>	$message,
    				    );
    				    $this->Emailsendgrid_model->sendForgotPassmailtoAdmin($emailToUser);

						$this->session->set_userdata(array('otpType'=>'Forgot Password','otpAdminId'=>$result['admin_id'],'otpAdminEmail'=>$result['admin_email']));

						$this->session->set_flashdata('alert_success',lang('sendotptoemail').$result['admin_email']);
						redirect(getCurrentBasePath().'admin/password-recover');
					endif;
				else:
					$data['forgoterror'] = lang('invalidemail');
				endif;
			endif;
		endif;
		
		$this->layouts->set_title('Forgot Password');
		$this->layouts->admin_view('account/forgotpassword',array(),$data,'login');
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : passwordrecover
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for admin password recover
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function passwordrecover()
	{	
		if($this->session->userdata('ILCADM_ADMIN_ID')) redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'maindashboard');
		$data['error'] 						= 	'';
		$data['recovererror'] 				= 	'';
		$data['forgotsuccess'] 				= 	'';

		/*-----------------------------------recover password ---------------*/
		if($this->input->post('passwordRecoverFormSubmit')):	
			//Set rules
			$this->form_validation->set_rules('userOtp', 'otp', 'trim|required|min_length[4]|max_length[4]');
			$this->form_validation->set_rules('userPassword', 'New password', 'trim|required|min_length[6]|max_length[25]');
			$this->form_validation->set_rules('userConfPassword', 'Confirm password', 'trim|required|min_length[6]|matches[userPassword]');
			
			if($this->form_validation->run()):	
				$result		=	$this->admin_model->checkOTP($this->input->post('userOtp'));
				if($result):
					$this->session->unset_userdata(array('otpType','otpAdminId','otpAdminEmail'));

					$param['admin_password']		=	$this->admin_model->encriptPassword($this->input->post('userPassword'));
					$param['admin_password_otp']	=	'';
					$this->common_model->editData('admin',$param,'admin_id',(int)$result['admin_id']);
							
					$this->session->set_flashdata('alert_success',lang('passrecoversuccess'));
					redirect(getCurrentBasePath().'admin/login');
				else:
					$data['recovererror'] = lang('invalidotp');
				endif;
			endif;
		endif;
		
		$this->layouts->set_title('Password Recover');
		$this->layouts->admin_view('account/passwordrecover',array(),$data,'login');
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : logout
	** Developed By : Manoj Kumar
	** Purpose  : This function used for logout
	** Date : 23 JUNE 2022
	************************************************************************/
	function logout()
	{
		
		$logoutParam['admin_token']			=	'';
		$logoutParam['login_status']		=	'Logout';
		$logoutParam['logout_datetime']		=	(int)$this->timezone->utc_time();//currentDateTime();
		$logoutParam['logout_ip']			=	currentIp();

		$logoutuWhere['login_status']		=	'Login';
		$logoutuWhere['admin_token']		=	$_COOKIE['ILCADM_ADMIN_LOGIN_TOKEN'];
		$logoutuWhere['admin_id']			=	(int)$this->session->userdata('ILCADM_ADMIN_ID');
		$this->common_model->editDataByMultipleCondition('admin_login_log',$logoutParam,$logoutuWhere);

		setcookie('ILCADM_ADMIN_LOGIN_TOKEN','',time()-60*60*24*100,'/');
		setcookie('ILCADM_ADMIN_REFERENCE_PAGES','',time()-60*60*24*100,'/');
		
		$this->session->unset_userdata(array('otpType','otpAdminId','otpAdminMobile','changeNewPassword'));
		$this->session->unset_userdata(array('ILCADM_ADMIN_LOGGED_IN',
											 'ILCADM_ADMIN_ID',
											 'ILCADM_ADMIN_TITLE',
											 'ILCADM_ADMIN_FIRST_NAME',
											 'ILCADM_ADMIN_MIDDLE_NAME',
											 'ILCADM_ADMIN_LAST_NAME',
											 'ILCADM_ADMIN_EMAIL',
											 'ILCADM_ADMIN_MOBILE',
											 'ILCADM_ADMIN_IMAGE',
											 'ILCADM_ADMIN_ADDRESS',
											 'ILCADM_ADMIN_CITY',
											 'ILCADM_ADMIN_STATE',
											 'ILCADM_ADMIN_COUNTRY',
											 'ILCADM_ADMIN_ZIPCODE',
											 'ILCADM_ADMIN_TYPE',
											 'ILCADM_ADMIN_CURRENT_PATH',
											 'ILCADM_ADMIN_USER_TYPE',
											 'ILCADM_ADMIN_LAST_LOGIN'));
		redirect(getCurrentBasePath().'admin/login');
		
	}	// END OF FUNCTION
}