<?php

defined('BASEPATH') OR exit('No direct script access allowed');
 
class Export extends CI_Controller {
    // construct
    public function __construct() {
        parent::__construct();
        // load model
       
        $this->load->model('export_model','front_model');
    }    
 
    public function index() {
        $data['export_list'] = $this->export->exportList();
        $this->load->view('export_excel_file', $data);
    }
 
    /* * *********************************************************************
	 * * Function name 	: orderlist_export
	 * * Developed By 	: Ritu Mishra
	 * * Purpose  		: This function for export order list
	 * * Date 			: 
	 * * **********************************************************************/
   public function summitusers_export() 
   {
        $fromdate 	=	$this->input->get('s_date');
        $todate 	=	$this->input->get('e_date');
        $campaignName 	=	$this->input->get('campaign_name');
        //print_r($campaignName);die;
        $newtimestamp = strtotime($todate.' + 1 days');
        $endDate =  date('Y-m-d', $newtimestamp);
        $fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $this->load->library('excel');
        if (!empty($campaignName)) {
            $where = " created_date BETWEEN '".$fromdate."' AND '".$endDate."' AND campaign_name = '".$campaignName."'";
        }else{
            $where = " created_date BETWEEN '".$fromdate."' AND '".$endDate."'";
        }
        //$where = "created_date BETWEEN '".$fromdate."' AND '".$endDate."'";
        $tbl = 'users';
        $listInfo = $this->export_model->getData($tbl,$where);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'S.No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Contact No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'City'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Campaign Name'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Submission Date'); 
        
        // set Row
        $rowCount = 2;
         $k=1;
        foreach ($listInfo as $list) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "$k");
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['email']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['mobile']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['city']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['campaign_name']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['created_date']);
            
            $rowCount++;
            $k++;
        }
        $filename = "Users Leads Details". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output'); 
    }
    
    
/* * *********************************************************************
	 * * Function name 	: userlist_export
	 * * Developed By 	: Ritu Mishra
	 * * Purpose  		: This function for export user list
	 * * Date 			: 29 Nov 2022
	 * * **********************************************************************/
    public function retirementlist_export() {
        
        //var_dump($this->session->userdata('last_query'));exit;
       
        //echo $query = $this->db->last_query();
        //exit;
        // create file name
        $fileName = 'data-'.time().'.xlsx';  
        // load excel library
        
        $this->load->library('excel');
        $where = "";
        $tbl = 'retirement';
        $listInfo = $this->export_model->getData($tbl,$where);
        //echo'<pre>';
        //print_r($listInfo);die;
        
        //var_dump($listInfo);exit;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'S.No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Selected Plan');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Person Age'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Service');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Pincode'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Retirement Age');  
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Post Retirement Plan');   
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Amount Saved');  
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Amount More Saved'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Watsapp No.');  
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Channel'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Employee code'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Investment Year');  
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'r');   
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 's');  
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Registered On'); 
        // set Row
        $rowCount = 2;
         $k=1;
        foreach ($listInfo as $list) {
           // print_r($userdetails);die;
           $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "$k");
           $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['selectedPlan']);
           $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['firstName']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['lastName']);
           $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['personAge']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['service']);
           $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['pinCode']);
           $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list['retirementAge']);
           $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $list['post_retirement_plan']);
           $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $list['retirementPromiseAmount']);
           $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $list['retirement_more_saved_amount']);
           $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $list['watsappNo']);
           $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $list['channel']);
           $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $list['empcode']);
           $objPHPExcel->getActiveSheet()->SetCellValue('o' . $rowCount, $list['investment_year']);
           $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, number_format($list['r'],2));
           $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, number_format($list['s'],2));
           $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $list['creation_date']);
            $rowCount++;
            $k++;
        }
        $filename = "Retirement Plan Details". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output'); 
    }   

    /* * *********************************************************************
	 * * Function name 	: userlist_export
	 * * Developed By 	: Ritu Mishra
	 * * Purpose  		: This function for export user list
	 * * Date 			: 29 Nov 2022
	 * * **********************************************************************/
    public function lifestyle_export() {
        $fileName = 'data-'.time().'.xlsx';  
        $this->load->library('excel');
        $where = "";
        $tbl = 'wealth';
        $listInfo = $this->export_model->getData($tbl,$where);
        //echo'<pre>';
        //print_r($listInfo);die;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'S.No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Selected Plan');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'First Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Last Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Person Age'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Service');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Pincode'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Wishlist');  
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Life Goal');   
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Amount Saved');  
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Amount More Saved'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Watsapp No.');  
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Channel');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Employee Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Investment Year');  
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'r');   
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 's');  
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Registered On'); 
        // set Row
        $rowCount = 2;
         $k=1;
        foreach ($listInfo as $list) {
           // print_r($userdetails);die;
           $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, "$k");
           $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['selectedPlan']);
           $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['firstName']);
           $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['lastName']);
           $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['personAge']);
           $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['service']);
           $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['pinCode']);
           $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list['wishlist']);
           $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $list['life_goal']);
           $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $list['wealth_saved']);
           $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $list['comming_year_saved']);
           $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $list['watsappNo']);
           $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $list['channel']);
           $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $list['empcode']);
           $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $list['investment_year']);
           $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, number_format($list['r'],2));
           $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, number_format($list['s'],2));
           $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $list['creation_date']);
            $rowCount++;
            $k++;
        }
        $filename = "Great Lifestyle Plan Details". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output'); 
    }   
}
?>