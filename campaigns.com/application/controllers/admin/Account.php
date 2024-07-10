<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function  __construct() 
	{ 
		parent:: __construct();
		//error_reporting(E_ALL ^ E_NOTICE);  
		error_reporting(0); 
		$this->load->model(array('admin_model','emailtemplate_model','sms_model','notification_model'));
		$this->lang->load('statictext', 'admin');
		$this->load->helper('common');
	} 

	/* * *********************************************************************
	 * * Function name : maindashboard
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for main dashboard
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function maindashboard()
	{	
		$this->admin_model->authCheck();
		$data['error'] 						= 	'';
		$data['activeMenu'] 				= 	'';
		$data['activeSubMenu'] 				= 	'';

		
	    $where['where'] 		=	"status = 'A'";
		$tbl 					=	'users as ftable';
		$data['summit_users'] 		= 	$this->common_model->getData('multiple',$tbl,$where);
		
		/*$where2['where'] 		=	['status' => 'A'];
		$tbl2 					=	'retirement as ftable';
		$data['retirement'] 	    = 	$this->common_model->getData('multiple',$tbl2,$where2);

		$where3['where'] 		=	"status = 'A'";
	    $tbl3 					=	'wealth as ftable';
	    $data['lifestyle'] 	    = 	$this->common_model->getData('multiple', $tbl3,$where3);*/


		
		$this->layouts->set_title('Dashboard');
		//$this->layouts->admin_view('account/maindashboard',array(),$data);
		$this->layouts->admin_view('account/maindashboard',array(),$data, 'maindashboard');
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : profile
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for admin profile
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function profile()
	{	
		$this->admin_model->authCheck();
		$data['error'] 						= 	'';
		$data['activeMenu'] 				= 	'';
		$data['activeSubMenu'] 				= 	'';
		
		$whereCon['where']			 		= 	"ftable.admin_id = '".$this->session->userdata('ILCADM_ADMIN_ID')."'";		
		$shortField 						= 	"ftable.admin_id ASC";
		
		$this->load->library('pagination');
		$config['base_url'] 				= 	$this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').$this->router->fetch_class().'/profile';
		$tblName 							= 	'admin as ftable';
		$con 								= 	'';
		$config['total_rows'] 				= 	$this->common_model->getData('count',$tblName,$whereCon,$shortField,'0','0');
		$config['per_page']	 				= 	10;
		$config['uri_segment'] 				= 	getUrlSegment();
       $this->pagination->initialize($config);

       if ($this->uri->segment(getUrlSegment())):
           $page = $this->uri->segment(getUrlSegment());
       else:
           $page = 0;
       endif;
		
		$data['ADMINDATA'] 					= 	$this->common_model->getData('single',$tblName,$whereCon,$shortField,$config['per_page'],$page); 

		$this->layouts->set_title('Profile');
		$this->layouts->admin_view('account/profile',array(),$data);
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : editprofile
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for admin editprofile
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function editprofile($editId='')
	{	
		$this->admin_model->authCheck();
		$data['error'] 						= 	'';
		$data['activeMenu'] 				= 	'';
		$data['activeSubMenu'] 				= 	'';
		
		$data['profileuserdata']			=	$this->common_model->getDataByParticularField('admin','admin_id',$editId); 
		if($data['profileuserdata'] == ''):
			redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'maindashboard');
		endif;
		
		if($this->input->post('SaveChanges')):
			$error							=	'NO';
			$this->form_validation->set_rules('admin_title', 'Title', 'trim|required|max_length[64]');
			$this->form_validation->set_rules('admin_first_name', 'First Name', 'trim|required|max_length[64]');
			$this->form_validation->set_rules('admin_middle_name', 'Middle Name', 'trim|max_length[64]');
			$this->form_validation->set_rules('admin_last_name', 'Last Name', 'trim|required|max_length[64]');
			$this->form_validation->set_rules('admin_email', 'E-Mail', 'trim|required|valid_email|max_length[64]|is_unique[admin.admin_email.admin_id]');			
			$this->form_validation->set_rules('admin_phone', 'Mobile number', 'trim|required|min_length[10]|max_length[15]|is_unique[admin.admin_phone.admin_id]');
			$testmobile		=	str_replace(' ','',$this->input->post('admin_phone'));
			if($this->input->post('admin_phone') && !preg_match('/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i',$testmobile)):
				if(!preg_match("/^((\+){0,1}91(\s){0,1}(\-){0,1}(\s){0,1})?([0-9]{10})$/",$testmobile)):
					$error						=	'YES';
					$data['mobileerror'] 		= 	'Please Eneter Correct Number';
				endif;
			endif;
			$this->form_validation->set_rules('admin_address', 'Address', 'trim|max_length[512]');
			$this->form_validation->set_rules('admin_city', 'City', 'trim');
			$this->form_validation->set_rules('admin_state', 'State', 'trim');
			$this->form_validation->set_rules('admin_pincode', 'Zipcode', 'trim');
			
			if($this->form_validation->run() && $error == 'NO'):
			 
				$param['admin_title']				= 	addslashes($this->input->post('admin_title'));
				$param['admin_first_name']			= 	addslashes($this->input->post('admin_first_name'));
				$param['admin_middle_name']			= 	addslashes($this->input->post('admin_middle_name'));
				$param['admin_last_name']			= 	addslashes($this->input->post('admin_last_name'));
				$param['admin_email']				= 	addslashes($this->input->post('admin_email'));
				$param['admin_phone']				= 	(int)($this->input->post('admin_phone'));
				$param['admin_address']				= 	addslashes($this->input->post('admin_address'));
				$param['admin_city']				= 	addslashes($this->input->post('admin_city'));
				$param['admin_state']				= 	addslashes($this->input->post('admin_state'));
				$param['admin_pincode']				= 	(int)$this->input->post('admin_pincode');

				$param['update_ip']					=	currentIp();
				$param['update_date']				=	(int)$this->timezone->utc_time();//currentDateTime();
				$param['updated_by']				=	(int)$this->session->userdata('ILCADM_ADMIN_ID');
				$this->common_model->editData('admin',$param,'admin_id',(int)$this->input->post('CurrentDataID'));
				
				$result								=	$this->admin_model->Authenticate($param['admin_email']);
				if($result):
					$this->session->set_userdata(array('ILCADM_ADMIN_TITLE'			=>	$result['admin_title'],
													   'ILCADM_ADMIN_FIRST_NAME'	=>	$result['admin_first_name'],
													   'ILCADM_ADMIN_MIDDLE_NAME'	=>	$result['admin_middle_name'],
													   'ILCADM_ADMIN_LAST_NAME'		=>	$result['admin_last_name'],
													   'ILCADM_ADMIN_EMAIL'			=>	$result['admin_email'],
													   'ILCADM_ADMIN_MOBILE'		=>	$result['admin_phone'],
													   'ILCADM_ADMIN_ADDRESS'		=>	$result['admin_address'],
													   'ILCADM_ADMIN_CITY'			=>	$result['admin_city'],
													   'ILCADM_ADMIN_STATE'			=>	$result['admin_state'],
													   'ILCADM_ADMIN_ZIPCODE'		=>	$result['admin_pincode']));
											
					$this->session->set_flashdata('alert_success',lang('updatesuccess'));
					redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'profile');
				endif;
			endif;
		endif;
		
		$this->layouts->set_title('Edit Profile');
		$this->layouts->admin_view('account/editprofile',array(),$data);
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : changepassword
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for change password
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function changepassword($editId='')
	{	
		$this->admin_model->authCheck();
		$data['error'] 						= 	'';
		$data['activeMenu'] 				= 	'';
		$data['activeSubMenu'] 				= 	'';
		
		$data['EDITDATA']					=	$this->common_model->getDataByParticularField('admin','admin_id',(int)$editId);  
		if($data['EDITDATA'] == ''):
			redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'maindashboard');
		endif; 
		$data['OLDPASSWORD']				=	$this->admin_model->decryptsPassword($data['EDITDATA']['admin_password']);

		if($this->input->post('SaveChanges')):
			$error					=	'NO';
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim');
			$this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|min_length[6]|matches[old_password]');
			$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[25]');
			$this->form_validation->set_rules('conf_password', 'Confirm Password', 'trim|required|min_length[6]|matches[new_password]');
			
			if($this->form_validation->run() && $error == 'NO'):  
				$param['admin_password_otp']		=	(int)'4321';//(int)generateRandomString(4,'n');
				$this->common_model->editData('admin',$param,'admin_id',(int)$data['EDITDATA']['admin_id']);

				$this->sms_model->sendChangePasswordOtpSmsToUser($data['EDITDATA']['admin_phone'],$param['admin_password_otp']);

				$this->session->set_userdata(array('otpType'=>'Change Password','otpAdminId'=>$data['EDITDATA']['admin_id'],'otpAdminMobile'=>$data['EDITDATA']['admin_phone'],'changeNewPassword'=>$this->input->post('new_password')));

				$this->session->set_flashdata('alert_success',lang('sendotptomobile').$data['EDITDATA']['admin_phone']);
				redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'change-password-verify-otp');
			endif;
		endif;
		
		$this->layouts->set_title('Change password');
		$this->layouts->admin_view('account/changepassword',array(),$data);
	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : changepasswordverifyotp
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for change password verify otp
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function changepasswordverifyotp()
	{	
		$this->admin_model->authCheck();
		$data['error'] 						= 	'';
		$data['activeMenu'] 				= 	'';
		$data['activeSubMenu'] 				= 	'';

		/*-----------------------------------change password verify otp---------------*/
		if($this->input->post('SaveChanges')):	
			//Set rules
			$this->form_validation->set_rules('userOtp', 'otp', 'trim|required|min_length[4]|max_length[4]');
			
			if($this->form_validation->run()):	
				$result		=	$this->admin_model->checkOTP((int)$this->input->post('userOtp'));
				if($result): 
					$param['admin_password']		= 	$this->admin_model->encriptPassword(sessionData('changeNewPassword'));
					$param['update_ip']				=	currentIp();
					$param['update_date']			=	(int)$this->timezone->utc_time();//currentDateTime();
					$param['updated_by']			=	(int)sessionData('ILCADM_ADMIN_ID');
					$this->common_model->editData('admin',$param,'admin_id',(int)sessionData('ILCADM_ADMIN_ID'));

					$this->session->unset_userdata(array('otpType','otpAdminId','otpAdminMobile','changeNewPassword'));

					$this->session->set_flashdata('alert_success',lang('passwordchangesuccess'));
					redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'profile');
				else:
					$data['recovererror'] = lang('invalidotp');
				endif;
			endif;
		endif;
		
		$this->layouts->set_title('Change password - Verify OTP');
		$this->layouts->admin_view('account/changepasswordverifyotp',array(),$data);
	}	// END OF FUNCTION
}