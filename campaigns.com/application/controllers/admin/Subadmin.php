<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subadmin extends CI_Controller {

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
	 * * Function name : Subadmin
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for Subadmin
	 * * Date : 25 JUNE 2022
	 * * **********************************************************************/
	public function index()
	{	
		$this->admin_model->authCheck('view_data');
		$this->admin_model->getPermissionType($data); 
		$data['error'] 						= 	'';
		$data['activeMenu'] 				= 	'subadmin';
		$data['activeSubMenu'] 				= 	'users';
		
		if($this->input->get('searchValue')):
			$sValue							=	$this->input->get('searchValue');
			$whereCon['like']			 	= 	"(ftable.admin_title LIKE '%".$sValue."%'
												  OR ftable.admin_first_name LIKE '%".$sValue."%'
												  OR ftable.admin_last_name LIKE '%".$sValue."%'
												  OR ftable.admin_email LIKE '%".$sValue."%'
												  OR ftable.admin_phone LIKE '%".$sValue."%')";
			$data['searchField'] 			= 	$sField;
			$data['searchValue'] 			= 	$sValue;
		else:
			$whereCon['like']		 		= 	"";
			$data['searchField'] 			= 	'';
			$data['searchValue'] 			= 	'';
		endif;
				
		$whereCon['where']		 			= 	"ftable.admin_type = 'Sub Admin'";		
		$shortField 						= 	"ftable.admin_id ASC";
		
		$baseUrl 							= 	getCurrentControllerPath('index');
		$this->session->set_userdata('siteAdminILCADMData',currentFullUrl());
		$qStringdata						=	explode('?',currentFullUrl());
		$suffix								= 	$qStringdata[1]?'?'.$qStringdata[1]:'';
		$tblName 							= 	'admin as ftable';
		$con 								= 	'';
		$totalRows 							= 	$this->common_model->getData('count',$tblName,$whereCon,$shortField,'0','0');
		
		if($this->input->get('showLength') == 'All'):
			$perPage	 					= 	$totalRows;
			$data['perpage'] 				= 	$this->input->get('showLength');  
		elseif($this->input->get('showLength')):
			$perPage	 					= 	$this->input->get('showLength'); 
			$data['perpage'] 				= 	$this->input->get('showLength'); 
		else:
			$perPage	 					= 	SHOW_NO_OF_DATA;
			$data['perpage'] 				= 	SHOW_NO_OF_DATA; 
		endif;
		$uriSegment 						= 	getUrlSegment();
	    $data['PAGINATION']					=	adminPagination($baseUrl,$suffix,$totalRows,$perPage,$uriSegment);

       if ($this->uri->segment(getUrlSegment())):
           $page = $this->uri->segment(getUrlSegment());
       else:
           $page = 0;
       endif;
		
		$data['forAction'] 					= 	$baseUrl; 
		if($totalRows):
			$first							=	(int)($page)+1;
			$data['first']					=	$first;
			
			if($data['perpage'] == 'All'):
				$pageData 					=	$totalRows;
			else:
				$pageData 					=	$data['perpage'];
			endif;
			
			$last							=	((int)($page)+$pageData)>$totalRows?$totalRows:((int)($page)+$pageData);
			$data['noOfContent']			=	'Showing '.$first.'-'.$last.' of '.$totalRows.' items';
		else:
			$data['first']					=	1;
			$data['noOfContent']			=	'';
		endif;
		
		$data['ALLDATA'] 					= 	$this->common_model->getData('multiple',$tblName,$whereCon,$shortField,$perPage,$page); 

		$this->layouts->set_title('Manage Sub-admin Details');
		$this->layouts->admin_view('subadmin/subadmin/index',array(),$data);
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : addeditdata
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for add edit data
	 * * Date : 25 JUNE 2022
	 * * **********************************************************************/
	public function addeditdata($editId='')
	{		
		$data['error'] 						= 	'';
		$data['activeMenu'] 				= 	'subadmin';
		$data['activeSubMenu'] 				= 	'subadmin';
		
		if($editId):
			$this->admin_model->authCheck('edit_data');
			$data['EDITDATA']		=	$this->common_model->getDataByParticularField('admin','admin_id',(int)$editId);
			$data['MODULEDATA']		=	$this->admin_model->getModulePermission((int)$editId);
		else:
			$this->admin_model->authCheck('add_data');
		endif;
		$data['Modirectory'] 		= 	$this->admin_model->getModule(); 

		if($this->input->post('SaveChanges')):
			$error					=	'NO';
			$this->form_validation->set_rules('department_id', 'Department', 'trim|required');
			$this->form_validation->set_rules('designation_id', 'Designation', 'trim|required');
			$this->form_validation->set_rules('admin_title', 'Title', 'trim|required|max_length[64]');
			$this->form_validation->set_rules('admin_first_name', 'First Name', 'trim|required|max_length[128]');
			$this->form_validation->set_rules('admin_middle_name', 'Middle Name', 'trim|max_length[128]');
			$this->form_validation->set_rules('admin_last_name', 'Last Name', 'trim|required|max_length[128]');
			$this->form_validation->set_rules('admin_email', 'E-Mail', 'trim|required|valid_email|max_length[64]|is_unique[admin.admin_email.admin_id]');			
			$this->form_validation->set_rules('admin_phone', 'Mobile number', 'trim|required|min_length[10]|max_length[15]|is_unique[admin.admin_phone.admin_id]');
			$testmobile		=	str_replace(' ','',$this->input->post('admin_phone'));
			if($this->input->post('admin_phone') && !preg_match('/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i',$testmobile)):
				if(!preg_match("/^((\+){0,1}91(\s){0,1}(\-){0,1}(\s){0,1})?([0-9]{10})$/",$testmobile)):
				//if(!preg_match("/^[0-9\-\(\)\/\+\s]*$/",$testmobile)):
					$error						=	'YES';
					$data['mobileerror'] 		= 	'Please Eneter Correct Number';
				endif;
			endif;
			if($this->input->post('CurrentDataID')):
				if($this->input->post('password')):
					$this->form_validation->set_rules('password', 'lang:Password', 'trim|required|min_length[6]|max_length[25]');
					$this->form_validation->set_rules('conf_password', 'lang:Confirm Password', 'trim|required|min_length[6]|matches[password]');
				endif;
			else:
				$this->form_validation->set_rules('password', 'lang:Password', 'trim|required|min_length[6]|max_length[25]');
				$this->form_validation->set_rules('conf_password', 'lang:Confirm Password', 'trim|required|min_length[6]|matches[password]');
			endif;
			$this->form_validation->set_rules('admin_address', 'Address', 'trim|max_length[512]');
			$this->form_validation->set_rules('admin_city', 'City', 'trim');
			$this->form_validation->set_rules('admin_state', 'State', 'trim');
			$this->form_validation->set_rules('admin_pincode', 'Zipcode', 'trim');

			$pererror							=	'YES';
			if($data['Modirectory'] <> ""): 
			 	foreach($data['Modirectory'] as $MODinfo): 
					if($this->input->post('mainmodule_'.$MODinfo['module_id'])):
						$pererror				=	'NO';
					endif;
				endforeach;
				if($pererror == 'YES'):
					$error						=	'YES';
					$data['PERERROR'] 			= 	'Please give at least one module permission.';
				endif;
			endif;
			
			if($this->form_validation->run() && $error == 'NO'): 

				$param['admin_title']			= 	addslashes($this->input->post('admin_title'));
				$param['admin_first_name']		= 	addslashes($this->input->post('admin_first_name'));
				$param['admin_middle_name']		= 	addslashes($this->input->post('admin_middle_name'));
				$param['admin_last_name']		= 	addslashes($this->input->post('admin_last_name'));
				$param['admin_email']			= 	addslashes($this->input->post('admin_email'));
				$param['admin_phone']			= 	(int)($this->input->post('admin_phone'));
				if($this->input->post('password')):
					$curpassword				=	html_escape(addslashes($this->input->post('password')));
					$param['admin_password']	=	$this->admin_model->encriptPassword($curpassword);
					$param['admin_password_otp']=	'';
				endif;
				$param['admin_address']			= 	addslashes($this->input->post('admin_address'));
				$param['admin_city']			= 	addslashes($this->input->post('admin_city'));
				$param['admin_state']			= 	addslashes($this->input->post('admin_state'));
				$param['admin_pincode']			= 	(int)($this->input->post('admin_pincode'));

				$departmentData					=	explode('_____',$this->input->post('department_id'));
				$param['department_id']			= 	(int)$departmentData[0];

				$DEPparam['department_used']	=	'Y';
				$this->common_model->editData('admin_department',$DEPparam,'department_id',(int)$param['department_id']);

				$designationData				=	explode('_____',$this->input->post('designation_id'));
				$param['designation_id']		= 	(int)$designationData[0];

				$DEGparam['designation_used']	=	'Y';
				$this->common_model->editData('admin_designation',$DEGparam,'designation_id',(int)$param['designation_id']);
				
				if($this->input->post('CurrentDataID') ==''):
					$param['admin_type']		=	'Sub Admin';
					$param['creation_ip']		=	currentIp();
					$param['creation_date']		=	(int)$this->timezone->utc_time();//currentDateTime();
					$param['created_by']		=	(int)$this->session->userdata('ILCADM_ADMIN_ID');
					$param['status']			=	'A'; 
					$alastInsertId				=	$this->common_model->addData('admin',$param);
					$this->session->set_flashdata('alert_success',lang('addsuccess'));
					$adminId					=	$param['admin_id'];
				else:
					$adminId						=	$this->input->post('CurrentDataID');
					$param['update_ip']			=	currentIp();
					$param['update_date']		=	(int)$this->timezone->utc_time();//currentDateTime();
					$param['updated_by']		=	(int)$this->session->userdata('ILCADM_ADMIN_ID');  
					$this->common_model->editData('admin',$param,'admin_id',(int)$adminId);
					$this->session->set_flashdata('alert_success',lang('updatesuccess'));
				endif;

				if($data['Modirectory'] <> "" && $adminId): 
					$this->admin_model->deletePermissionData($adminId);
					foreach($data['Modirectory'] as $MODinfo):
						$mainmodperids		=	'';
						$mmc 				= 	$MODinfo['module_id']; 
						if($this->input->post('mainmodule_'.$mmc)):
							$MMParams['module_id']			=	$MODinfo['module_id'];
							$MMParams['module_name']		=	$MODinfo['module_name'];
							$MMParams['module_display_name']=	$MODinfo['module_display_name'];
							$MMParams['module_orders']		=	$MODinfo['module_orders'];
							$MMParams['module_icone']		=	$MODinfo['module_icone'];
							$MMParams['child_data']			=	$MODinfo['child_data'];
							$MMParams['admin_id']			=	$adminId;
							
							if($this->input->post('mainmodule_view_data_'.$mmc)):
								$MMParams['view_data']		=	'Y';
							else:
								$MMParams['view_data']		=	'N';
							endif;
							if($this->input->post('mainmodule_add_data_'.$mmc)):
								$MMParams['add_data']		=	'Y';
							else:
								$MMParams['add_data']		=	'N';
							endif;
							if($this->input->post('mainmodule_edit_data_'.$mmc)):
								$MMParams['edit_data']		=	'Y';
							else:
								$MMParams['edit_data']		=	'N';
							endif;
							if($this->input->post('mainmodule_delete_data_'.$mmc)):
								$MMParams['delete_data']	=	'Y';
							else:
								$MMParams['delete_data']	=	'N';
							endif;
							
							$MMlastInsertId					=	$this->common_model->addData('admin_module_permission',$MMParams);
							$mainModuleId					=	$MMlastInsertId;
						endif;
						
						if($MODinfo['child_data'] == 'Y' && $mainModuleId):
							$childdata 						= 	$this->admin_model->getModuleChild($MODinfo['module_id']);
							if($childdata <> ""): 
								foreach($childdata as $CDinfo):	
									 $cmc 					= 	$CDinfo['child_module_id'];
									if($this->input->post('childmodule_'.$mmc.'_'.$cmc)):
										$UMMUparam['child_data']		=	'Y';
										$UMMUwhere['module_id']			=	$mainModuleId;
										$this->common_model->editDataByMultipleCondition('admin_module_permission',$UMMUparam,$UMMUwhere);
									
										$CMParams['module_permission_id']	=	$mainModuleId;
										$CMParams['module_id']				=	$CDinfo['child_module_id'];
										$CMParams['module_name']			=	$CDinfo['module_name'];
										$CMParams['module_display_name']	=	$CDinfo['module_display_name'];
										$CMParams['module_orders']			=	$CDinfo['module_orders'];
										$CMParams['admin_id']				=	$adminId;
										
										if($this->input->post('childmodule_view_data_'.$mmc.'_'.$cmc)):
											$CMParams['view_data']			=	'Y';
										else:
											$CMParams['view_data']			=	'N';
										endif;
										if($this->input->post('childmodule_add_data_'.$mmc.'_'.$cmc)):
											$CMParams['add_data']			=	'Y';
										else:
											$CMParams['add_data']			=	'N';
										endif;
										if($this->input->post('childmodule_edit_data_'.$mmc.'_'.$cmc)):
											$CMParams['edit_data']			=	'Y';
										else:
											$CMParams['edit_data']			=	'N';
										endif;
										if($this->input->post('childmodule_delete_data_'.$mmc.'_'.$cmc)):
											$CMParams['delete_data']		=	'Y';
										else:
											$CMParams['delete_data']		=	'N';
										endif;
											
										$CMlastInsertId					=	$this->common_model->addData('admin_module_child_permission',$CMParams);
									endif;
								endforeach;
							endif;
						endif;
					endforeach;
				endif;
				
				redirect(correctLink('siteAdminILCADMData',getCurrentControllerPath('index')));
			endif;
		endif;
		
		$this->layouts->set_title('Edit Sub-admin Details');
		$this->layouts->admin_view('subadmin/subadmin/addeditdata',array(),$data);
	}	// END OF FUNCTION	
	
	/***********************************************************************
	** Function name : changestatus
	** Developed By : Manoj Kumar
	** Purpose  : This function used for change status
	** Date : 25 JUNE 2022
	************************************************************************/
	function changestatus($changeStatusId='',$statusType='')
	{  
		$this->admin_model->authCheck('edit_data');
		$param['status']		=	$statusType;
		$this->common_model->editData('admin',$param,'admin_id',(int)$changeStatusId);
		$this->session->set_flashdata('alert_success',lang('statussuccess'));
		
		redirect(correctLink('siteAdminILCADMData',getCurrentControllerPath('index')));
	}
}