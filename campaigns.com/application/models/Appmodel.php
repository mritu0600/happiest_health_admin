<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Appmodel extends CI_Model{


    public function __construct()
	{
		parent::__construct(); 
	}



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
   $data = $query->result_array();
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
** Function name    : getHomeSesstionData
** Developed By     : Afar Ali
** Purpose          : This function used for get data by query
** Date             : 23 JUNE 2022
************************************************************************/
public function getHomeMeditationData()
{
    $this->db->select('id,name,image,price,description,created_at');
    $this->db->where('is_active = 1');
    $this->db->from('services');
    $retult = $this->db->get();
    return $retult->result_array();

}   // END OF FUNCTION
/***********************************************************************
** Function name    : getHomeHealerData
** Developed By     : Afsar Ali
** Purpose          : This function used for get data by query
** Date             : 23 JUNE 2022
************************************************************************/
public function getHomeHealerData()
{
    $this->db->select('name,image_name,description');
    $this->db->where('status = "A"');
    $this->db->from('api_healer');
    $this->db->order_by('id ASC');
    $this->db->limit(1);
    $retult = $this->db->get();
    return $retult->row_array();

}   // END OF FUNCTION

/***********************************************************************
** Function name    : getAboutData
** Developed By     : Afsar Ali
** Purpose          : This function used for get data by query
** Date             : 18 JULY 2022
************************************************************************/
public function getAboutData()
{
    $this->db->select('*');
    //$this->db->where('status = "A"');
    $this->db->from('api_about_us');
    //$this->db->order_by('id ASC');
    $this->db->limit(1);
    $retult = $this->db->get();
    return $retult->row_array();

}   // END OF FUNCTION

/***********************************************************************
** Function name    : getModalitiesData
** Developed By     : Afsar Ali
** Purpose          : This function used for get data by query
** Date             : 18 JULY 2022
************************************************************************/
public function getModalitiesData()
{
    $this->db->select('*');
    //$this->db->where('status = "A"');
    $this->db->from('api_modalities');
    //$this->db->order_by('id ASC');
    $this->db->limit(1);
    $retult = $this->db->get();
    return $retult->row_array();

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
** Function name    : getUserNextCode
** Developed By     : Afsar Ali
** Purpose          : This function used for get data by query
** Date             : 18 JULY 2022
************************************************************************/
public function getUserNextCode(){

    $this->db->select('code');
    $this->db->order_by('id','desc');
    $query = $this->db->from('users')->get();
    $code = $query->row_array();

    $code_digit = explode('/', $code['code']);
    $newOrdID = 'TDS/C/'.++$code_digit[2];

    return $newOrdID;
}

public function getPrivacyData()
{
    $this->db->select('*');
    $this->db->where('pages = "1"');
    $this->db->from('pages');
    //$this->db->order_by('id ASC');
    $this->db->limit(1);
    $retult = $this->db->get();
    return $retult->row_array();


}

public function getRefundData()
{
    $this->db->select('*');
    $this->db->where('pages = "2"');
    $this->db->from('pages');
    //$this->db->order_by('id ASC');
    $this->db->limit(1);
    $retult = $this->db->get();
    return $retult->row_array();


}

public function getTermsData()
{
    $this->db->select('*');
    $this->db->where('pages = "3"');
    $this->db->from('pages');
    //$this->db->order_by('id ASC');
    $this->db->limit(1);
    $retult = $this->db->get();
    return $retult->row_array();


}

public function getDisclaimerData()
{
    $this->db->select('*');
    $this->db->where('pages = "4"');
    $this->db->from('pages');
    //$this->db->order_by('id ASC');
    $this->db->limit(1);
    $retult = $this->db->get();
    return $retult->row_array();
}

public function checkAppointmentSlot($date,$time){
    //echo $date.'  '.$time; die();
    $this->db->select('*');
    $this->db->where('date = "'.$date.'" AND time = "'.$time.'"');
    $this->db->from('block_date_time');
    $retult = $this->db->get();
    $count = $retult->num_rows();
    if($retult->num_rows() == '0'){
        $this->db->select('*');
        $this->db->where('date = "'.$date.'" AND time = "'.$time.'"');
        $this->db->from('api_appointments');
        $data = $this->db->get();
      	if($data->num_rows() == '0'){
                return 'Available';
            }else{
                return 'Taken';
            }
    }else{
        return 'Blocked';
    }

}


    /***********************************************************************
    ** Function name    : getOrderList
    ** Developed By     : Afsar Ali
    ** Purpose          : This function used for get order list
    ** Date             : 29 JUNE 2022
    ************************************************************************/
    function getOrderList($user_id)
    {
        $this->db->select('
            ord.id,
            ord.order_no,
            ord.user_id,
            ord.name,
            ord.email,
            ord.mobile,
            ord.payable_amount,
            ord.payment_gateway,
            ord.payment_status,
            ord.transaction_no,
            ord.created_at,

            ordDetails.order_id,
            ordDetails.type,
            ordDetails.package_id,
            ordDetails.course_id,
            ordDetails.service_id,
            ordDetails.package_id,
            ordDetails.course_id,
            ordDetails.course_expiry_date,

            cor.name as course_name,
            cor.price as course_price,

            ',);

        $this->db->from('orders as ord');
        $this->db->join('order_details as ordDetails','ord.id = ordDetails.order_id','LEFT');
        $this->db->join('courses as cor','ordDetails.course_id = cor.id','LEFT');
        $this->db->where("ordDetails.type = '3' AND ord.user_id = '".$user_id."'");
        $this->db->order_by("ord.id desc");
        $query  =   $this->db->get();
        if($query->num_rows() > 0):
            return $query->result_array();
        else:
            return false;
        endif;
    }   // END OF FUNCTION


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

  /***********************************************************************
    ** Function name    : getEventsList
    ** Developed By     : Afsar Ali
    ** Purpose          : This function used for check subscription
    ** Date             : 01 AUG 2022
    ************************************************************************/
    public function getEventsList(){

       $this->db->select('*');
       $this->db->where('date >=' ,date('Y-m-d'));
       $this->db->where('status = "A"');
       $query = $this->db->from('events')->get();
        $data = $query->result_array();

        return $data;
    }

}

