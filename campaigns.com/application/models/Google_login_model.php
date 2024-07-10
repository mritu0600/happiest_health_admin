<?php
class Google_login_model extends CI_Model
{
 function Is_already_register($email)
 {
  $this->db->where('email', $email);
  $query = $this->db->get('registration_form');
  if($query->num_rows() > 0)
  {
   return true;
  }
  else
  {
   return false;
  }
 }

 function Update_user_data($data, $id)
 {
  $this->db->where('id', $id);
  $this->db->update('registration_form', $data);
 }

 function Insert_user_data($data)
 {
    //print_r($data);die;
  $this->db->insert('registration_form', $data);
  return $this->db->insert_id();
 }
}
?>