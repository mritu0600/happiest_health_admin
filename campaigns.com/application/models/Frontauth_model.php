<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Frontauth_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
		$this->load->database(); 
	}

	/* * *********************************************************************
	 * * Function name : Authenticate
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for user Login Page
	 * * Date : 10 OCTOBER 2018
	 * * **********************************************************************/
	public function Authenticate($userPhone='')
	{
		$this->db->select('*');
		$this->db->from('users');
		if(is_numeric($userPhone)){
		    $this->db->where('user_phone',$userPhone);    
		}else{
		    $this->db->where('user_email',$userPhone);    
		}
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : getUserDataByMobile
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for get User Data By Mobile
	 * * Date : 10 OCTOBER 2018
	 * * **********************************************************************/
	public function getUserDataByMobile($userPhone='')
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_phone',$userPhone);
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : getUserDataByEmail
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for get User Data By Email
	 * * Date : 12 OCTOBER 2018
	 * * **********************************************************************/
	public function getUserDataByEmail($userEmail='')
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('user_email',$userEmail);
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : getUserDataByUserId
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for get User Data By User Id
	 * * Date : 12 OCTOBER 2018
	 * * **********************************************************************/
	public function getUserDataByUserId($userId='')
	{
       
		$this->db->select('*');
		$this->db->from('registration_form');
		$this->db->where('id',$userId);
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : encriptPassword
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for encript_password
	 * * Date : 16 AUGUST 2018
	 * * **********************************************************************/
	public function encriptPassword($password)
	{
		return $this->encrypt->encode($password, $this->config->item('encryption_key'));
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : decryptsPassword
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for encript_password
	 * * Date : 16 AUGUST 2018
	 * * **********************************************************************/
	public function decryptsPassword($password)
	{
		return $this->encrypt->decode($password,$this->config->item('encryption_key'));
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : checkOnlyUserLoginCookie
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for check Only User Login Cookie
	 * * Date : 12 OCTOBER 2018
	 * * **********************************************************************/
	public function checkOnlyUserLoginCookie()
	{  
		if($_COOKIE['NANNEY_KHAN_USER_PHONE']):
			
			$result		=	$this->Authenticate($_COOKIE['NANNEY_KHAN_USER_PHONE']);
			if($result): 
				if($result['status'] == 'A'):	

					$this->session->set_userdata(array(
											'NANNEY_KHAN_USER_LOGGED_IN'=>true,
											'NANNEY_KHAN_USER_ID'=>$result['user_id'],
											'NANNEY_KHAN_USER_TYPE'=>$result['user_type'],
											'NANNEY_KHAN_USER_BROWSE_TYPE'=>$result['browse_type'],
											'NANNEY_KHAN_USER_NAME'=>$result['user_name'],
											'NANNEY_KHAN_USER_EMAIL'=>$result['user_email'],
											'NANNEY_KHAN_USER_PHONE'=>$result['user_phone'],
											'NANNEY_KHAN_USER_IMAGE'=>$result['user_image'],
											'NANNEY_KHAN_USER_LAST_LOGIN'=>$result['user_last_login'].' ('.$result['user_last_login_ip'].')'));
					
					setcookie('NANNEY_KHAN_USER_PHONE',$result['user_phone'],time()+60*60*24*100,'/');
				endif;
			endif;
		endif;
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : checkUserLoginCookie
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for check User Login Cookie
	 * * Date : 10 OCTOBER 2018
	 * * **********************************************************************/
	public function checkUserLoginCookie()
	{  
		if($_COOKIE['NANNEY_KHAN_USER_PHONE']):
			
			$result		=	$this->Authenticate($_COOKIE['NANNEY_KHAN_USER_PHONE']);
			if($result): 
				if($result['status'] == 'A'):	

					$this->session->set_userdata(array(
											'NANNEY_KHAN_USER_LOGGED_IN'=>true,
											'NANNEY_KHAN_USER_ID'=>$result['user_id'],
											'NANNEY_KHAN_USER_TYPE'=>$result['user_type'],
											'NANNEY_KHAN_USER_BROWSE_TYPE'=>$result['browse_type'],
											'NANNEY_KHAN_USER_NAME'=>$result['user_name'],
											'NANNEY_KHAN_USER_EMAIL'=>$result['user_email'],
											'NANNEY_KHAN_USER_PHONE'=>$result['user_phone'],
											'NANNEY_KHAN_USER_IMAGE'=>$result['user_image'],
											'NANNEY_KHAN_USER_LAST_LOGIN'=>$result['user_last_login'].' ('.$result['user_last_login_ip'].')'));
					
					setcookie('NANNEY_KHAN_USER_PHONE',$result['user_phone'],time()+60*60*24*100,'/');
					
					if($_COOKIE['NANNEY_KHAN_USER_REFERENCE_PAGES']):
						redirect(base_url().$_COOKIE['NANNEY_KHAN_USER_REFERENCE_PAGES']);
					else:
						redirect($this->session->userdata('NANNEY_KHAN_FRONT_CURRENT_PATH').'user/my-account');
					endif;
				endif;
			endif;
		endif;
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : authCheck
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for auth Check
	 * * Date : 10 OCTOBER 2018
	 * * **********************************************************************/
	public function authCheck()
	{
		if($this->session->userdata('NANNEY_KHAN_USER_ID') == ""):
			setcookie('NANNEY_KHAN_USER_REFERENCE_PAGES',uri_string(),time()+60*60*24*5,'/');
			redirect(base_url());
		else:
			return true;
		endif;
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : Authenticateuseremail
	 * * Developed By : Ritu Mishra
	 * * Purpose  : This function used for get Otp By Email Address
	 * * Date : 20 April 2023
	 * * **********************************************************************/
	public function Authenticateuseremail($email='')
	{
		$this->db->select('*');
		$this->db->from('registration_form');
		
			$this->db->where('email',$email);    
		
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION


	
	/* * *********************************************************************
	 * * Function name : checkOTP
	 * * Developed By : Ritu Mishra
	 * * Purpose  : This function used for Admin otp
	 * * Date : 20 April 2023
	 * * **********************************************************************/
	public function checkOTP($userEmail='',$userOtp='')
	{
		
		$this->db->select('*');
		$this->db->from('registration_form');
		$this->db->where('email',$userEmail);
		$this->db->where('otp',$userOtp);
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION
}	