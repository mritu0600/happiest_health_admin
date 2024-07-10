<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Front_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
	}

	function milliseconds() {
	    $mt = explode(' ', microtime());
	    return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
	}

	function microseconds() {
	    $mt = explode(' ', microtime());
	    return ((int)$mt[1]) * 1000000 + ((int)round($mt[0] * 1000000));
	}

	/* * *********************************************************************
	 * * Function name 	: check
	 * * Developed By 	: Afsar
	 * * Purpose  		: This function used for check user
	 * * Date 			: 01 JULY 2022
	 * * **********************************************************************/
	public function check($userEmail='')
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
	/***********************************************************************
	** Function name 	: getRegistrationType
	** Developed By 	: Afsar Ali
	** Purpose  		: This function used for get Designation
	** Date 			: 03 AUG 2022
	************************************************************************/
	function getRegistrationType($type='')
	{
		$html			=	'<option value="">Are you registering</option>';
		$this->db->select('*');
		$this->db->from('efl_registration_cat');
		$this->db->where("status = 'A'");
		$this->db->order_by("name ASC");
		$query	=	$this->db->get();
		$result = 	$query->result_array();
		if($result):	
			foreach($result as $info):
				if($info['id'] == $type):  $select ='selected="selected"'; else: $select =''; endif;
				$html		.=	'<option value="'.$info['id'].'_____'.stripslashes($info['name']).'" '.$select.'>'.stripslashes(ucfirst($info['name'])).'</option>';
			endforeach;
		endif;
		return $html;
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name 	: checkUserExist
	 * * Developed By 	: Ritu Mishra
	 * * Purpose  		: This function used for check existing email
	 * * Date 			: 01 JULY 2022
	 * * **********************************************************************/
	function checkUserExist($email='')
	{
		$this->db->select('*');
		$this->db->from('registration');
		if($email <> ""):
			$this->db->where("email = '".$email."'");
		else:
			$this->db->where("email = '".$email."'");
		endif;
		$query	=	$this->db->get();
		if($query->num_rows() > 0):
			return $query->row_array();
		else:
			return false;
		endif;
	}


	/***********************************************************************
	** Function name 	: getuserdata
	** Developed By 	: Ritu Mishra
	** Purpose  		: This function used for get sub category data for particular id
	** Date 			: 12 oct 2023
	************************************************************************/
	function getuserdata($id)
	{  
		
		$dataarray		=	array();
		$this->db->select('*');
		$this->db->from('registration');
		$this->db->where('id', $id);
		$query = $this->db->get();
		if($query->num_rows() > 0):
			$data	=	$query->row();
			return $data;
		else:
			return false;
		endif;
		
	}

	/***********************************************************************
	** Function name: getsearchgoalData
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by query
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getsearchgoalData($action='',$tbl_name='',$wcon='',$keyword,$shortField='',$num_page='',$cnt='')
	{  
		$this->db->select('ftable.*');
		$this->db->from($tbl_name);
		//if($wcon['where']):		$this->db->where($wcon['where']);	 		endif;
		//if($wcon['like']):  	$this->db->where($wcon['like']); 			endif;
		if(!empty($keyword)){
			$this->db->like('goal_name',$keyword);
		}
		else{
			$this->db->where($wcon['where']);
		}
		if($shortField):		$this->db->order_by($shortField);			endif;
		if($num_page):			$this->db->limit($num_page,$cnt);			endif;
		$query = $this->db->get();
		if($action == 'count'):	
			return $query->num_rows();
		elseif($action == 'single'):	
			if($query->num_rows() > 0):
				return $query->row_array();
			else:
				return false;
			endif;
		elseif($action == 'multiple'):	
			if($query->num_rows() > 0):
				return $query->result_array();
			else:
				return false;
			endif;
		else:
			return false;
		endif;
	}	// END OF FUNCTION



/***********************************************************************
	** Function name: getsearchgoalData
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by query
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getsearcheventData($action='',$tbl_name='',$wcon='',$keyword,$shortField='',$num_page='',$cnt='')
	{  
		$this->db->select('ftable.*');
		$this->db->from($tbl_name);
		//if($wcon['where']):		$this->db->where($wcon['where']);	 		endif;
		//if($wcon['like']):  	$this->db->where($wcon['like']); 			endif;
		if(!empty($keyword)){
			$this->db->like('title',$keyword);
		}
		else{
			$this->db->where($wcon['where']);
		}
		if($shortField):		$this->db->order_by($shortField);			endif;
		if($num_page):			$this->db->limit($num_page,$cnt);			endif;
		$query = $this->db->get();
		if($action == 'count'):	
			return $query->num_rows();
		elseif($action == 'single'):	
			if($query->num_rows() > 0):
				return $query->row_array();
			else:
				return false;
			endif;
		elseif($action == 'multiple'):	
			if($query->num_rows() > 0):
				return $query->result_array();
			else:
				return false;
			endif;
		else:
			return false;
		endif;
	}	// END OF FUNCTION
}	