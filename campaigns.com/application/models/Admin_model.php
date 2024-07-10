<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
		$this->load->database(); 
	}

	/* * *********************************************************************
	 * * Function name : Authenticate
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for imRD Admin Login Page
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function Authenticate($userEmail='')
	{
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('admin_email',$userEmail);
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
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function encriptPassword($password)
	{
		return $this->encrypt->encode($password, $this->config->item('encryption_key'));
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : decryptsPassword
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for encript_password
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function decryptsPassword($password)
	{	
		return $this->encrypt->decode($password, $this->config->item('encryption_key'));
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : authCheck
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for auth Check
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function authCheck($showType='')
	{  
		if($this->session->userdata('ILCADM_ADMIN_ID') == ""):
			setcookie('ILCADM__ADMIN_REFERENCE_PAGES',uri_string(),time()+60*60*24*5,'/');
			redirect(getCurrentBasePath().'admin/logout');
		else:
			$this->db->select('*');
			$this->db->from('admin_login_log');
			$this->db->where('admin_id',$this->session->userdata('ILCADM_ADMIN_ID'));
			$this->db->where("login_status = 'Login'");
			$this->db->where('admin_token',$_COOKIE['ILCADM_ADMIN_LOGIN_TOKEN']);
			$query		=	$this->db->get();
			$result   	= 	$query->row_array();
			if($result):
				if($showType==''):
					return true;
				elseif($this->checkPermission($showType)):  
					return true;
				else:		
					$this->session->set_flashdata('alert_warning',lang('accessdenied'));
					redirect($this->session->userdata('ILCADM_ADMIN_CURRENT_PATH').'dashboard');
				endif;
			else:
				$this->session->set_flashdata('alert_warning',lang('loginanothersystem'));
				setcookie('ILCADM_ADMIN_REFERENCE_PAGES',uri_string(),time()+60*60*24*5,'/');
				redirect(getCurrentBasePath().'admin/logout');
			endif;
		endif;
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : checkPermission
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for check Permission
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function checkPermission($showType='')
	{  
		$returnType 			=	0;
		if($this->session->userdata('ILCADM_ADMIN_TYPE') == 'Super Admin'):
			$returnType 		=	1;
		elseif($this->session->userdata('ILCADM_ADMIN_TYPE') == 'Sub Admin'): 
			$this->db->select($showType);
			$this->db->from('admin_module_permission');
			$this->db->where('module_name',$this->router->fetch_class());
			$this->db->where('admin_id',$this->session->userdata('ILCADM_ADMIN_ID'));
			$this->db->where("child_data = 'N'");
			$query	=	$this->db->get();
			if($query->num_rows() > 0):		
				$mdata				=	$query->row_array();
				if($mdata[$showType] == 'Y'):
					$returnType 	=	1;
				endif;
			else:		
				$this->db->select($showType);
				$this->db->from('admin_module_child_permission');
				$this->db->where('module_name',$this->router->fetch_class());
				$this->db->where('admin_id',$this->session->userdata('ILCADM_ADMIN_ID'));
				$cquery	=	$this->db->get();
				if($cquery->num_rows() > 0):	
					$cmdata			=	$cquery->row_array();
					if($cmdata[$showType] == 'Y'):
						$returnType =	1;
					endif;
				endif;	
			endif;
		endif;
		return $returnType==1?true:false;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getPermissionType
	** Developed By: Manoj Kumar
	** Purpose: This function used for get permission type
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getPermissionType(&$data)	
	{  
		if($this->session->userdata('ILCADM_ADMIN_TYPE') == 'Super Admin'):
			$data['view_data']		=	'Y';
			$data['add_data']		=	'Y';
			$data['edit_data']		=	'Y';
			$data['delete_data']	=	'Y';
		elseif($this->session->userdata('ILCADM_ADMIN_TYPE') == 'Sub Admin'):
			$data['view_data']		=	'N';
			$data['add_data']		=	'N';
			$data['edit_data']		=	'N';
			$data['delete_data']	=	'N';

			$this->db->select('view_data,add_data,edit_data,delete_data');
			$this->db->from('admin_module_permission');
			$this->db->where('module_name',$this->router->fetch_class());
			$this->db->where('admin_id',$this->session->userdata('ILCADM_ADMIN_ID'));
			$this->db->where("child_data = 'N'");
			$query	=	$this->db->get();
			if($query->num_rows() > 0):	
				$mdata						=	$query->row_array();
				$data['view_data']			=	$mdata['view_data'];
				$data['add_data']			=	$mdata['add_data'];
				$data['edit_data']			=	$mdata['edit_data'];
				$data['delete_data']		=	$mdata['delete_data'];
			else:	
				$this->db->select('view_data,add_data,edit_data,delete_data');
				$this->db->from('admin_module_child_permission');
				$this->db->where('module_name',$this->router->fetch_class());
				$this->db->where('admin_id',$this->session->userdata('ILCADM_ADMIN_ID'));
				$cquery	=	$this->db->get();
				if($cquery->num_rows() > 0):	
					$cmdata					=	$cquery->row_array();
					$data['view_data']		=	$cmdata['view_data'];
					$data['add_data']		=	$cmdata['add_data'];
					$data['edit_data']		=	$cmdata['edit_data'];
					$data['delete_data']	=	$cmdata['delete_data'];
				endif;	
			endif;
		endif;
	}

	/***********************************************************************
	** Function name: getMenuModule
	** Developed By: Manoj Kumar
	** Purpose: This function used for getMenuModule
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getMenuModule()	
	{  
		$returnArray 		=	array();
		if($this->session->userdata('ILCADM_ADMIN_TYPE') == 'Super Admin'):
			$this->db->select('module_id,module_name,module_display_name,module_icone,child_data');
			$this->db->from('admin_module');
			$this->db->order_by("module_orders ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0):
				return $query->result_array();
			else:
				return false;
			endif;
		elseif($this->session->userdata('ILCADM_ADMIN_TYPE') == 'Sub Admin'): 
			$this->db->select('module_permission_id,module_id,module_name,module_display_name,module_icone,child_data');
			$this->db->from('admin_module_permission');
			$this->db->where('admin_id',$this->session->userdata('ILCADM_ADMIN_ID'));
			$this->db->group_start();
			$this->db->where("view_data = 'Y'");
			$this->db->where("child_data = 'N'");
			$this->db->or_where("view_data = 'N'");
			$this->db->or_where("child_data = 'Y'");
			$this->db->group_end();
			$this->db->order_by("module_orders ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0):
				return $query->result_array();
			else:
				return false;
			endif;
		endif;
	}

	/* * *********************************************************************
	 * * Function name : getMenuChildModule  
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This is get menu child module
	 * * Date : 21 DECEMBER 2018
	 * * **********************************************************************/
	function getMenuChildModule($miduleId='')
	{ 	
		if($this->session->userdata('ILCADM_ADMIN_TYPE') == 'Super Admin'):
			$this->db->select('child_module_id,module_name,module_display_name');
			$this->db->from('admin_module_child');
			$this->db->where("module_id",$miduleId);
			$this->db->order_by("module_orders ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0):
				return $query->result_array();
			else:
				return false;
			endif;
		elseif($this->session->userdata('ILCADM_ADMIN_TYPE') == 'Sub Admin'): 
			$this->db->select('module_child_permission_id,module_name,module_display_name');
			$this->db->from('admin_module_child_permission');
			$this->db->where("permission_id",$miduleId);
			$this->db->where('admin_id',$this->session->userdata('ILCADM_ADMIN_ID'));
			$this->db->where("view_data = 'Y'");
			$this->db->order_by("module_orders ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0):
				return $query->result_array();
			else:
				return false;
			endif;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getModule
	** Developed By: Manoj Kumar
	** Purpose: This function used for get Module
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getModule()	
	{  
		$this->db->select('*');
		$this->db->from('admin_module');
		$this->db->order_by("module_orders ASC");
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->result_array();
		else:
			return false;
		endif;
	}

	/***********************************************************************
	** Function name : getModuleChild
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get module child
	** Date : 23 JUNE 2022
	************************************************************************/
	function getModuleChild($miduleId='')
	{
		$this->db->select('*');
		$this->db->from('admin_module_child');
		$this->db->where('module_id',$miduleId);
		$this->db->order_by("module_orders ASC");
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->result_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getModulePermission
	** Developed By: Manoj Kumar
	** Purpose: This function used for get Module Permission
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getModulePermission($adminId='')	
	{  
		$selecarray				=	array();
		$this->db->select('*');
		$this->db->from('admin_module_permission');
		$this->db->where('admin_id',$adminId);
		$this->db->order_by("module_orders ASC");
		$query	=	$this->db->get();
		if($query->num_rows() >0):	
			$data	=	$query->result_array();
			foreach($data as $info):	
				$selecarray['mainmodule_'.$info['module_id']]							=	'Y';
				if($info['child_data'] == 'N'):
					if($info['view_data'] == 'Y'):
						$selecarray['mainmodule_view_data_'.$info['module_id']]			=	'Y';
					endif;
					if($info['add_data'] == 'Y'):
						$selecarray['mainmodule_add_data_'.$info['module_id']]			=	'Y';
					endif;
					if($info['edit_data'] == 'Y'):
						$selecarray['mainmodule_edit_data_'.$info['module_id']]			=	'Y';
					endif;
					if($info['delete_data'] == 'Y'):
						$selecarray['mainmodule_delete_data_'.$info['module_id']]		=	'Y';
					endif; 
				else:
					$this->db->select('*');
					$this->db->from('admin_module_child_permission');
					$this->db->where('module_permission_id',$info['module_permission_id']);
					$this->db->where('admin_id',$adminId);
					$this->db->order_by("module_orders ASC");
					$query1	=	$this->db->get();
					if($query1->num_rows() >0):
						$data1	=	$query1->result_array();
						foreach($data1 as $info1):
							$selecarray['childmodule_'.$info['module_id'].'_'.$info1['module_id']]						=	'Y';
							if($info1['view_data'] == 'Y'):
								$selecarray['childmodule_view_data_'.$info['module_id'].'_'.$info1['module_id']]		=	'Y';
							endif;
							if($info1['add_data'] == 'Y'):
								$selecarray['childmodule_add_data_'.$info['module_id'].'_'.$info1['module_id']]			=	'Y';
							endif;
							if($info1['edit_data'] == 'Y'):
								$selecarray['childmodule_edit_data_'.$info['module_id'].'_'.$info1['module_id']]		=	'Y';
							endif;
							if($info1['delete_data'] == 'Y'):
								$selecarray['childmodule_delete_data_'.$info['module_id'].'_'.$info1['module_id']]		=	'Y';
							endif;
						endforeach;
					endif;
				endif;
			endforeach;
		endif;
		return $selecarray;
	}

	/* * *********************************************************************
	 * * Function name : checkOTP
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for Admin otp
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	public function checkOTP($userOtp='')
	{
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('admin_password_otp',$userOtp);
		$query	=	$this->db->get();
		if($query->num_rows() >0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getDepartment
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Department
	** Date : 23 JUNE 2022
	************************************************************************/
	function getDepartment($departmentId='')
	{
		$html			=	'<option value="">Select Department</option>';
		$this->db->select('*');
		$this->db->from('admin_department');
		$this->db->where("status = 'A'");
		$this->db->order_by("department_name ASC");
		$query	=	$this->db->get();
		$result = 	$query->result_array();
		if($result):	
			foreach($result as $info):
				if($info['department_id'] == $departmentId):  $select ='selected="selected"'; else: $select =''; endif;
				$html		.=	'<option value="'.$info['department_id'].'_____'.stripslashes($info['department_name']).'" '.$select.'>'.stripslashes($info['department_name']).'</option>';
			endforeach;
		endif;
		return $html;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getDesignation
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Designation
	** Date : 23 JUNE 2022
	************************************************************************/
	function getDesignation($designationId='')
	{
		$html			=	'<option value="">Select Designation</option>';
		$this->db->select('*');
		$this->db->from('admin_designation');
		$this->db->where("status = 'A'");
		$this->db->order_by("designation_name ASC");
		$query	=	$this->db->get();
		$result = 	$query->result_array();
		if($result):	
			foreach($result as $info):
				if($info['designation_id'] == $designationId):  $select ='selected="selected"'; else: $select =''; endif;
				$html		.=	'<option value="'.$info['designation_id'].'_____'.stripslashes($info['designation_name']).'" '.$select.'>'.stripslashes($info['designation_name']).'</option>';
			endforeach;
		endif;
		return $html;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getTableAllData
	** Developed By: Manoj Kumar
	** Purpose: This function used for get Module
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getTableAllData($tableName='')	
	{  
		$query = $this->db->query($query);
		$result = $query->result_array();
		if($result):
			return $result;
		else:	
			return false;
		endif;
	}

	/***********************************************************************
	** Function name : deletePermissionData
	** Developed By : Manoj Kumar
	** Purpose  : This function used for delete permission data
	** Date : 25 JUNE 2022
	************************************************************************/
	function deletePermissionData($adminId='')
	{
		$this->db->delete('admin_module_permission', array('admin_id' => $adminId));
		$this->db->delete('admin_module_child_permission', array('admin_id' => $adminId));
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : getLowerTyps
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get Lower Typs
	** Date : 25 JUNE 2022
	************************************************************************/
	function getLowerTyps($lowertypeid='')
	{
		$html			=	'<option value="">Select Lower Types</option>';
		$this->db->select('*');
		$this->db->from('types_of_lawyers');
		$this->db->where("status = 'A'");
		$this->db->order_by("lower_type_name ASC");
		$query	=	$this->db->get();
		$result = 	$query->result_array();
		if($result):	
			foreach($result as $info):
				if($info['lower_type_id'] == $lowertypeid):  $select ='selected="selected"'; else: $select =''; endif;
				$html		.=	'<option value="'.$info['lower_type_id'].'_____'.stripslashes($info['lower_type_name']).'" '.$select.'>'.stripslashes($info['lower_type_name']).'</option>';
			endforeach;
		endif;
		return $html;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getState
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get state
	** Date : 25 JUNE 2022
	************************************************************************/
	function getState($lowertstateid='')
	{
		$html			=	'<option value="">Select State</option>';
		$this->db->select('*');
		$this->db->from('state');
		$this->db->where("status = 'A'");
		$this->db->order_by("state_title ASC");
		$query	=	$this->db->get();
		$result = 	$query->result_array();
		if($result):	
			foreach($result as $info):
				if($info['state_id'] == $lowertstateid):  $select ='selected="selected"'; else: $select =''; endif;
				$html		.=	'<option value="'.$info['state_id'].'" '.$select.'>'.stripslashes($info['state_title']).'</option>';
			endforeach;
		endif;
		return $html;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : getCity
	** Developed By : Manoj Kumar
	** Purpose  : This function used for get City
	** Date : 25 JUNE 2022
	************************************************************************/
	function getCity($lowertstateid='',$lowertcityid='')
	{
		$html			=	'<option value="">Select City</option>';
		$this->db->select('*');
		$this->db->from('city');
		$this->db->where("state_id",$lowertstateid);
		$this->db->where("status = 'A'");
		$this->db->order_by("city_name ASC");
		$query	=	$this->db->get();
		$result = 	$query->result_array();
		if($result):	
			foreach($result as $info):
				if($info['city_id'] == $lowertcityid):  $select ='selected="selected"'; else: $select =''; endif;
				$html		.=	'<option value="'.$info['city_id'].'" '.$select.'>'.stripslashes($info['city_name']).'</option>';
			endforeach;
		endif;
		return $html;
	}	// END OF FUNCTION
}