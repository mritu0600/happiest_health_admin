<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
    class Export_model extends CI_Model {
 
        public function __construct()
        {
            $this->load->database();
        }
       
        public function getData($tbl,$where="") {
            $this->db->select('*');
            $this->db->from($tbl);
            if(!(empty($where))){
                $this->db->where($where);
            }
            $this->db->order_by('id DESC');
            $query = $this->db->get();
            
            return $query->result_array();
        }

      
    }
?>