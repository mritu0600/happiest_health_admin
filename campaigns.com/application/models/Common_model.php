<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model
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

	/***********************************************************************
	** Function Name returnIntegerEncryptValue
	** Developed By : Manoj Kumar
	** Input Parameters 
	** 1. inputInteger = The integer value which need to encrypted
	** 2. returnLength = THe number of digit which need to be return from functon.
	** Function Process :- The function will take integr input and multiply it with current unixtimestamp.
	** The new value will be encrypt using md5 which return 32 bit string, The encrypt string convert to ASCII
	** value and then the desire lenght sub string will be return by function.
	** Date : 23 JUNE 2022
	************************************************************************/
	public function returnIntegerEncryptValue($inputInteger, $returnLength = 16)
	{
		$returnEncryptInterValue = '';
		$lenghtCounter = 0;
		$currentTimeStamp = $this->microseconds();//$this->milliseconds();//time();
		$vauleToBeEncrypted = $inputInteger * $currentTimeStamp;
		$encryptedString = md5($vauleToBeEncrypted);
		$encryptedStringCharArray = str_split($encryptedString);
		foreach($encryptedStringCharArray as $charValue):
			$asciiValue = ord($charValue);
			$asciiValueLength = strlen($asciiValue);
			$lenghtCounter = $lenghtCounter + $asciiValueLength;
			if($lenghtCounter < $returnLength):	
				$returnEncryptInterValue = $returnEncryptInterValue.$asciiValue;
				$returnEncryptInterValue.' rln '.strlen($returnEncryptInterValue);
			else:
				break;
			endif;
		endforeach;
		$remaingNumberOfDigits = $returnLength - strlen($returnEncryptInterValue);
		if($remaingNumberOfDigits > 0):
			for($remaingDigitsCounter = 0; $remaingDigitsCounter < $remaingNumberOfDigits; $remaingDigitsCounter++):
				$returnEncryptInterValue = $returnEncryptInterValue .rand ( 0 , 9);
			endfor;
		endif;
		return $returnEncryptInterValue;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : addData
	** Developed By : Manoj Kumar
	** Purpose  : This function used for add data
	** Date : 23 JUNE 2022
	************************************************************************/
	public function addData($tableName='',$param=array())
	{
		$this->db->insert($tableName,$param);
		return $this->db->insert_id();
	}	// END OF FUNCTION
	
	/* * *********************************************************************
	 * * Function name : editData
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for edit data
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	function editData($tableName='',$param='',$fieldName='',$fieldValue='')
	{ 
		$this->db->where($fieldName,$fieldValue);
		$this->db->update($tableName,$param);
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : editDataByMultipleCondition
	** Developed By : Manoj Kumar
	** Purpose  : This function used for edit data by multiple condition
	** Date : 23 JUNE 2022
	************************************************************************/
	function editDataByMultipleCondition($tableName='',$param=array(),$whereCondition=array())
	{
		$this->db->where($whereCondition);
		$this->db->update($tableName,$param);
		return true;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : editMultipleDataByMultipleCondition
	** Developed By : Manoj Kumar
	** Purpose  : This function used for edit data by multiple condition
	** Date : 23 JUNE 2022
	************************************************************************/
	function editMultipleDataByMultipleCondition($tableName='',$param=array(),$whereCondition=array())
	{
		$this->db->where($whereCondition);
		$this->db->update($tableName,$param);
		return true;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : editMultipleDataByMultipleCondition
	** Developed By : Manoj Kumar
	** Purpose  : This function used for edit data by multiple condition
	** Date : 23 JUNE 2022
	************************************************************************/
	function editMultipleDataBySingleCondition($tableName='',$param='',$fieldName='',$fieldValue='')
	{ 
		$this->db->where($fieldName,$fieldValue);
		$this->db->update($tableName,$param);
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : deleteData
	** Developed By : Manoj Kumar
	** Purpose  : This function used for delete data
	** Date : 23 JUNE 2022
	************************************************************************/
	function deleteData($tableName='',$fieldName='',$fieldValue='')
	{
		$this->db->delete($tableName,array($fieldName=>$fieldValue));
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : deleteParticularData
	** Developed By : Manoj Kumar
	** Purpose  : This function used for delete particular data
	** Date : 23 JUNE 2022
	************************************************************************/
	function deleteParticularData($tableName='',$fieldName='',$fieldValue='')
	{ 
		$this->db->delete($tableName,array($fieldName=>$fieldValue));
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name : deleteByMultipleCondition
	** Developed By : Manoj Kumar
	** Purpose  : This function used for delete by multiple condition
	** Date : 23 JUNE 2022
	************************************************************************/
	function deleteByMultipleCondition($tableName='',$whereCondition=array())
	{
		$this->db->delete($tableName,$whereCondition);
		return true;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name: getDataByParticularField
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by encryptId
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getDataByParticularField($tableName='',$fieldName='',$fieldValue='')
	{  
		$this->db->select('*');
		$this->db->from($tableName);	
		$this->db->where($fieldName,$fieldValue);
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getSingleDataByParticularField
	** Developed By: Manoj Kumar
	** Purpose: This function used for get Single Data By Particular Field
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getSingleDataByParticularField($fields=array(),$tableName='',$fieldName='',$fieldValue='')
	{  
		if(empty($fields)): $fields 	=	'*'; endif; 
		$this->db->select($fields);
		$this->db->from($tableName);	
		$this->db->where($fieldName,$fieldValue);
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name: getDataByQuery
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by query
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getData($action='',$tbl_name='',$wcon='',$shortField='',$num_page='',$cnt='',$distinct="")
	{  
		$this->db->select('ftable.*');
		$this->db->from($tbl_name);
		if($distinct!=""){
			//print_r($distinct);die;
			$this->db->group_by('title');
		}
		if($wcon['where']):		$this->db->where($wcon['where']);	 		endif;
		if($wcon['like']):  	$this->db->where($wcon['like']); 			endif;
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
	** Function name: getFieldInArray
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by condition
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getFieldInArray($field='',$tbl_name='',$wcon='')
	{  
		$this->db->select($field);
		$this->db->from($tbl_name);
		if($wcon['where']):	$this->db->where($wcon['where']);	 	endif;
		if($wcon['like']):  $this->db->where($wcon['like']); 		endif;
		$query = $this->db->get();
		if($query->num_rows() > 0):
			$result = $query->result_array();
			foreach($result as $info):
				array_push($returnarray,$info[$field]);
			endforeach;
		endif;
		return $returnarray;
	}	// END OF FUNCTION
	
	/***********************************************************************
	** Function name: getLastOrderByFields
	** Developed By: Manoj Kumar
	** Purpose: This function used for get Last Order By Fields
	** Date : 23 JUNE 2022
	************************************************************************/ 
	public function getLastOrderByFields($field='',$tbl_name='',$fieldName='',$fieldValue='')
	{  
		$this->db->select($field);
		$this->db->from($tbl_name);
		if(isset($fieldName) && isset($fieldValue)):
			$this->db->where($fieldName,$fieldValue);
		endif;
		$this->db->order_by($field.' DESC');
		$query = $this->db->get();
		if($query->num_rows() > 0):
			$result = $query->row_array();
			return $result[$field];
		else:
			return 0;
		endif;

	}	// END OF FUNCTION

	/* * *********************************************************************
	 * * Function name : setAttributeInUse
	 * * Developed By : Manoj Kumar
	 * * Purpose  : This function used for set Attribute In Use
	 * * Date : 23 JUNE 2022
	 * * **********************************************************************/
	function setAttributeInUse($tableName='',$param='',$fieldName='',$fieldValue='')
	{ 
		$paramarray[$param]	=	'Y';
		$this->db->where($fieldName,$fieldValue);
		$this->db->update($tableName,$paramarray);
		return true;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getPaticularFieldByFields
	** Developed By: Manoj Kumar
	** Purpose: This function used for get Paticular Field By Fields
	** Date : 23 JUNE 2022
	************************************************************************/ 
	public function getPaticularFieldByFields($field='',$tbl_name='',$fieldName='',$fieldValue='')
	{  
		$this->db->select($field);
		$this->db->from($tbl_name);
		if(isset($fieldName) && isset($fieldValue)):
			$this->db->where($fieldName,$fieldValue);
		endif;
		$query = $this->db->get();
		if($query->num_rows() > 0):
			$result = $query->row_array();
			return $result[$field];
		else:
			return 0;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getParticularFieldByMultipleCondition
	** Developed By: Manoj Kumar
	** Purpose: This function used for get Particular Field By Multiple Condition
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getParticularFieldByMultipleCondition($fields=array(),$tableName='',$wcon='')
	{  
		if(empty($fields)): $fields 	=	'*'; endif; 
		$this->db->select($fields);
		$this->db->from($tableName);
		if($wcon['where']):	$this->db->where($wcon['where']);	 	endif;
		if($wcon['like']):  $this->db->where($wcon['like']); 		endif;
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->row_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getDataByNewQuery
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by query
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getDataByNewQuery($fields=array(),$action='',$tbl_name='',$wcon='',$shortField='',$num_page='',$cnt='')
	{  
		if(empty($fields)): $fields 	=	'*'; endif; 
		$this->mongo_db->select($fields);	
		if(isset($wcon['where']) && $wcon['where'])	$this->mongo_db->where($wcon['where']);	
		if(isset($wcon['where_ne']) && $wcon['where_ne'])	$this->mongo_db->where_ne($wcon['where_ne'][0],$wcon['where_ne'][1]);	
		if(isset($wcon['where_or']) && $wcon['where_or'])	$this->mongo_db->where_or($wcon['where_or']);	
		if(isset($wcon['where_between']) && $wcon['where_between'])	$this->mongo_db->where_between($wcon['where_between'][0],$wcon['where_between'][1],$wcon['where_between'][2]);	
		if(isset($wcon['like']) && $wcon['like']):	
			$this->mongo_db->like($wcon['like'][0],$wcon['like'][1],'i',TRUE,TRUE);
		endif;
		if(isset($wcon['where_in']) && $wcon['where_in']):	
			foreach($wcon['where_in'] as $whereInData):
				$this->mongo_db->where_in($whereInData[0],$whereInData[1]);
			endforeach;
		endif;
		if(isset($wcon['where_gte']) && $wcon['where_gte']):	
			foreach($wcon['where_gte'] as $whereGteData):
				$this->mongo_db->where_gte($whereGteData[0],$whereGteData[1]);
			endforeach;
		endif;
		if($shortField)				$this->mongo_db->order_by($shortField);				
		if($num_page):				
			$this->mongo_db->limit($num_page);
			$this->mongo_db->offset($cnt);						
		endif;
		if($action == 'count'):	
			return $this->mongo_db->count($tbl_name);
		elseif($action == 'single'):	
			$result = $this->mongo_db->find_one($tbl_name);
			if($result):
				return json_decode(json_encode($result),true);
			else:
				return false;
			endif;
		elseif($action == 'multiple'):	
			$result = $this->mongo_db->get($tbl_name);
			if($result):	
				return json_decode(json_encode($result),true);
			else:		
				return false;
			endif;
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name: getMultipleDataByParticularField
	** Developed By: Ashish
	** Purpose: This function used for getMultipleDataByParticularField
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getMultipleDataByParticularField($tableName='',$fieldName='',$fieldValue='')
	{  
		$this->db->select('*');
		$this->db->from($tableName);
		if(isset($fieldName) && isset($fieldValue)):
			$this->db->where($fieldName,$fieldValue);
		endif;
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->result_array();
		else:
			return false;
		endif;
	}	// END OF FUNCTION

	/***********************************************************************
	** Function name : delete_image_by_image_name
	** Developed By : Ashish UMrao
	** Purpose  : This function used for delete image by image name
	** Date : 23 JUNE 2022
	************************************************************************/
	function delete_image_by_image_name($tableName='',$fieldName='',$fieldValue='')
	{	
		$this->db->delete($tableName,array($fieldName=>$fieldValue));
		return true;
	}

	/***********************************************************************
	** Function name: getDataByQuery
	** Developed By: Manoj Kumar
	** Purpose: This function used for get data by query
	** Date : 23 JUNE 2022
	************************************************************************/
	public function getDataByQuery($action='',$query='',$from='')
	{  
		$query = $this->db->query($query);
		if($from == 'procedure'):
			mysqli_next_result( $this->db->conn_id);
		endif;
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
	** Function name 	: getParticularFieldData
	** Developed By 	: Afsar Ali
	** Purpose 			: This function used for get particular fields data
	** Date 			: 28 JUNE 2022
	************************************************************************/
	public function getParticularFieldData($action='',$fileds='',$tbl_name='',$wcon='',$shortField='',$num_page='',$cnt='')
	{  
		if(empty($fileds)){$this->db->select('ftable.*');}else{$this->db->select($fileds);}
		$this->db->from($tbl_name);
		if($wcon['where']):		$this->db->where($wcon['where']);	 		endif;
		if($wcon['like']):  	$this->db->where($wcon['like']); 			endif;
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

public function select_all($table, $where, $queries = []){
   
	$select = '*';
	if(isset($queries['select'])){
	$select = $queries['select']; 
	}
 
	$this->db->select($select);
 
	if(isset($queries['joins'])){
	 foreach($queries['joins'] as $join){
	  $this->db->join($join['table'], $join['condition'], $join['joinType']);   
	 }
	}
 
	if($where){
	$this->db->where($where); 
	}
 
	if(isset($queries['where_in']) && !empty($queries['where_in'])){
	$this->db->where_in($queries['where_in'][0], $queries['where_in'][1]); 
	}
 
	if(isset($queries['like']) && !empty($queries['like'])){
	$this->db->where($queries['like']); 
	}
 
	if(isset($queries['limit'])){
	$this->db->limit($queries['limit'][1], $queries['limit'][0]);
	}
	
	if(isset($queries['order'])){
		$this->db->order_by($queries['order'][0], $queries['order'][1]);
	}
 
	if(isset($queries['group'])){
	$this->db->group_by($queries['group']);
	}
 
	$query = $this->db->from($table)->get();
	$data = $query->result();
	$rows = $query->num_rows();
 
	$return = [];
	if(isset($queries['return'])){
	 $return = $queries['return'];
	}
 
	if($return == 'both'){
	 $return = [
		 'data'  => $data,
		 'rows'  => $rows
	 ];
	}elseif($return == 'rows'){
	 $return = $rows;
	}else{
	 $return = $data;
	}
	return $return;
  }


  	/***********************************************************************
	** Function name 	: deleteDataTable
	** Developed By 	: Sumit Bedwal
	** Purpose  		: This function used for Delete contact Records
	** Date 			: 04 AUG 2022
	************************************************************************/
	public function deleteDataTable($table, $id){
		$this->db->where('id', $id);
		$delete = $this->db->delete($table);
		if($delete){
			return true;
		}else{
			return false;
		}
	}

////////////////*******************************New app model code*****************************************///////////////////////////

public function select_one_only($table,$where){
    $this->db->from($table);
    $this->db->where($where);
    $q = $this->db->get();
    /*print_r($this->db->last_query()); die();*/
    return $q->row_array();
}
public function update($table, $where, $data){
    $this->db->where($where);
    $this->db->update($table, $data);
    //if($this->db->affected_rows()){ return true; }else{ return false; }
    return true;
}

/***********************************************************************
** Function name    : insert_one
** Developed By     : Afsar Ali
** Purpose          : This function used for get data by query
** Date             : 18 JILY 2022
************************************************************************/
public function insert_one($table, $data){
  $this->db->insert($table, $data);
  if($this->db->affected_rows()){
    return $this->db->insert_id();
  }else{
    return false;
  }
}   // END OF FUNCTION

/***********************************************************************
** Function name    : getHomeSesstionData
** Developed By     : Manoj Kumar
** Purpose          : This function used for get data by query
** Date             : 23 JUNE 2022
************************************************************************/
public function getHomeSesstionData()
{
    $this->db->select('id,name,image,price,description,created_at');
    $this->db->where('is_active = 1');
    $this->db->from('services');
    $retult = $this->db->get();
    return $retult->result_array();

}   // END OF FUNCTION

/***********************************************************************
** Function name    : getUserNextCode
** Developed By     : Afsar Ali
** Purpose          : This function used for get data by query
** Date             : 20 JULY 2022
************************************************************************/
public function select_one($table, $where, $queries = []){

   $select = '*';
   if(isset($queries['select'])){
   $select = $queries['select'];
   }

   $this->db->select($select);

   if(isset($queries['joins'])){
    foreach($queries['joins'] as $join){
     $this->db->join($join['table'], $join['condition'], $join['joinType']);
    }
   }

   if($where){
   $this->db->where($where);
   }

   if(isset($queries['like']) && !empty($queries['like'])){
   $this->db->where($queries['like']);
   }
   if(isset($queries['order'])){
   $this->db->order_by($queries['order'][0], $queries['order'][1]);
   }
   if(isset($queries['limit'])){
   $this->db->limit($queries['limit'][1], $queries['limit'][0]);
   }

   if(isset($queries['group'])){
   $this->db->group_by($queries['group']);
   }

   $query = $this->db->from($table)->get();
   $data = $query->row_array();
   $rows = $query->num_rows();

   $return = [];
   if(isset($queries['return'])){
    $return = $queries['return'];
   }

   if($return == 'both' && $data && $rows){
    $return = [
        'data'  => $data,
        'rows'  => $rows
    ];
   }elseif($return == 'rows' && $rows){
    $return = $rows;
   }elseif($data){
    $return = $data;
   }
   return $return;
 }


    /***********************************************************************
    ** Function name    : getOrderList
    ** Developed By     : Afsar Ali
    ** Purpose          : This function used for get order list
    ** Date             : 29 JUNE 2022
    ************************************************************************/
       // END OF FUNCTION


/***********************************************************************
    ** Function name    : subscriptionCheck
    ** Developed By     : Afsar Ali
    ** Purpose          : This function used for check subscription
    ** Date             : 26 JULY 2022
    ************************************************************************/
    public function subscriptionCheck($course_id, $user_id){
        $result = false;
        $where = ['user_id' => $user_id];
        $orderData = $this->db->select('*')->from('orders')->where($where)->get()->result_array();
        foreach ($orderData as $key => $value) {
            $wcon = [   'order_id'      => $value['id'],
                        'course_id'    => $course_id ];
            $this->db->from('order_details');
            $this->db->where($wcon);
            $q = $this->db->get();
            $data = $q->row_array();
            if(!empty($data)){
                $expdata = strtotime($data['course_expiry_date']);
                $today = strtotime(date('Y-m-d'));
                if($expdata > $today | $today == $expdata){
                    $result = true;
                }
            }
        }
        return $result;
    }
    
	public function getDataExcel($action='',$tbl_name='',$wcon='',$shortField='',$num_page='',$cnt='')
	{  
		$this->db->select('ftable.*');
		$this->db->from($tbl_name);
		//var_dump($wcon);die;
		/*if(!empty($wcon)){
			if($wcon['campaignName']){
				$this->db->where('campaign_name', $wcon['campaignName']);
			}

			if($wcon['from_date'] && $wcon['to_date']){
				$where = "created_date BETWEEN '".$wcon['from_date']."' AND '".$wcon['to_date']."'";
				//$this->db->where('created_date >=', $wcon['from_date']);
				$this->db->where($where);
			}

			
		}*/

		if (!empty($wcon)) {
			// Check if campaignName exists and is not empty
			if (!empty($wcon['campaignName'])) {
				$this->db->where('campaign_name', $wcon['campaignName']);
			}

			// Check if both from_date and to_date exist and are not empty
			if (!empty($wcon['from_date']) && !empty($wcon['to_date'])) {
				// Construct the where clause for the date range
				//echo $wcon['to_date'];die;
				//echo $fromDate  = date('Y-m-d H:i:s', strtotime($wcon['from_date']));die;
				$newtimestamp = strtotime($wcon['to_date'].' + 1 days');
				$endDate =  date('Y-m-d', $newtimestamp);
				$this->db->where("created_date BETWEEN '".date('Y-m-d H:i:s', strtotime($wcon['from_date']))."' AND '".$endDate."'");
			}
		}
		//if($wcon['where']):		$this->db->where($wcon['where']);	 		endif;
		if($wcon['like']):  	$this->db->where($wcon['like']); 			endif;
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

	}	
}	