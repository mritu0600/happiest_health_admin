<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminsummitusers extends CI_Controller {

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
	 * * Function name 	: index
	 * * Developed By 	: Sumit Bedwal
	 * * Purpose  		: This function used for Contact Info 
	 * * Date 			: 02 April 2023
	 * * **********************************************************************/
	public function index()
	{	
		
		$this->admin_model->authCheck('view_data');
		$this->admin_model->getPermissionType($data); 
		$data['error'] 						= 	'';
		$data['activeMenu'] 				= 	'adminsummitusers';
		$data['activeSubMenu'] 				= 	'adminsummitusers';
		
		if($this->input->get('searchValue')):
			$sValue							=	$this->input->get('searchValue');
			$whereCon['like']			 	= 	"(ftable.name LIKE '%".$sValue."%'
												OR ftable.email LIKE '%".$sValue."%'
												OR ftable.mobile LIKE '%".$sValue."%'
												OR ftable.city LIKE '%".$sValue."%'
												)";
			$data['searchField'] 			= 	$sField;
			$data['searchValue'] 			= 	$sValue;
		else:
			$whereCon['like']		 		= 	"";
			$data['searchField'] 			= 	'';
			$data['searchValue'] 			= 	'';
		endif;
		$fromdate 	=	$this->input->get('s_date');
		$todata 	=	$this->input->get('e_date');
		$campaignName 	=	$this->input->get('campaign_name');
		
		// if($this->input->get('s_date') && $this->input->get('e_date') ){
		// 	//echo $this->input->get('campaign_name');die;
		// 	$fromdate 	=	$this->input->get('s_date');
		// 	$todata 	=	$this->input->get('e_date');
		// 	$campaignName 	=	$this->input->get('campaign_name');
		// 	redirect(base_url('admin/export/summitusers_export/').$fromdate.'/'.$todata);
		// }


		$where = array();
		if(!empty($fromdate)){
			$where['from_date'] = $fromdate;
		}
		if(!empty($todata)){
			$where['to_date'] = $todata;
		}
		if(!empty($campaignName)){
			$where['campaignName'] = $campaignName;
		}
		
		$shortField 						= 	"ftable.id DESC";
		
		$baseUrl 							= 	getCurrentControllerPath('index');
		$this->session->set_userdata('userILCADMData',currentFullUrl());
		$qStringdata						=	explode('?',currentFullUrl());
		$suffix								= 	$qStringdata[1]?'?'.$qStringdata[1]:'';
		$tblName 							= 	'users as ftable';
		$con 								= 	'';
		//echo $tblName; die();
		$totalRows 							= 	$this->common_model->getDataExcel('count',$tblName,$where,$shortField,'0','0');
		
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
		
		$data['ALLDATA'] 					= 	$this->common_model->getDataExcel('multiple',$tblName,$where,$shortField,$perPage,$page); 
		//echo $this->db->last_query();die;
		//echo "<pre>"; print_r($data['ALLDATA']); die();
		$this->layouts->set_title('Manage Summit Users');
		$this->layouts->admin_view('summitusers/index',array(),$data);
	}	// END OF FUNCTION


	
	/***********************************************************************
	** Function name : changestatus
	** Developed By  : Sumit Bedwal
	** Purpose  	 : This function used to edit Contact Info
	** Date 		 : 02 April 2023
	************************************************************************/
	function changestatus($changeStatusId='',$statusType='')
	{  
		$this->admin_model->authCheck('edit_data');
		$param['status']		=	$statusType;
		$this->common_model->editData('users',$param,'id',(int)$changeStatusId);
		$this->session->set_flashdata('alert_success',lang('statussuccess'));
		
		redirect(correctLink('userILCADMData',getCurrentControllerPath('index')));
	}
	/***********************************************************************
	** Function name 	: deletedata
	** Developed By  : Sumit Bedwal
	** Purpose  	 : This function used to delete Contact Info
	** Date 		 : 02 April 2023
	************************************************************************/
	function deletedata($deleteId='')
	{  
		$this->admin_model->authCheck('delete_data');

		$this->common_model->deleteData('users','id',(int)$deleteId);
		$this->session->set_flashdata('alert_success',lang('deletesuccess'));
		
		redirect(correctLink('userILCADMData',getCurrentControllerPath('index')));
	}


	/***********************************************************************
	** Function name 	: deletedata
	** Developed By 	: Afsar Ali
	** Purpose  		: This function used for delete Records
	** Date 			: 27 JUNE 2022
	************************************************************************/
	public function deleterecords(){
		$array = $_POST['post_id'];
		$table = "users"; 
		foreach($array as $deleteId){
				if($deleteId != 'ckbCheckAll'){
						$delete = $this->common_model->deleteDataTable($table, $deleteId);   
				}
		}
		// echo $this->db->last_query();exit;
		echo true;
}

}