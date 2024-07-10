<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Emailtemplate_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
		$this->load->database(); 
	}

		function getEmailTemplateByMailType($type='') {  
		$this->db->select('*');
		$this->db->from('mail_template');
		$this->db->where('mailTypeData',$type);
		$query = $this->db->get();
		if($query->num_rows()>0):
			return $query->row_array();
		else:
			return false;
		endif;
	}

    /***********************************************************************
	** Function name : sendOrderMailToUser
	** Developed By : Ritu Mishra
	** Purpose  : This function used for order success mail to user
	** Date : 
	************************************************************************/
	function sendOrderMailToUser($email="",$username="",$orderid="") { 
       	    $fromMail  		= 	'sales@liquorjunction4.com';
			$siteFullName	=	'Liquor Junction';
			$toMail  		= 	$email;
			$subject 		= 	"Order Successfull mail";
			//$sitefullurl	= 	base_url();
			
			#.............................. message section ............................#
			$MHtml 			= 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>'.$siteFullName.'</title>
								</head>
								<body>
								    <p>Hi '.$username.',</p>
									<p>your order has been received. Your order id : '.$orderid.'</p>
																	 <p>Thanks, <br />
								</p>
								</body>
								</html>';
			//echo $MHtml; die;
			$this->email->from($fromMail,$siteFullName);
			$this->email->to($toMail); 
			$this->email->subject($subject);
			$this->email->set_mailtype('html');
			$this->email->message($MHtml);	
			$this->email->send();
			//echo $this->email->print_debugger();exit;
	}
	
	 /***********************************************************************
	** Function name : UserSignUpmailtoadmin
	** Developed By : Ritu Mishra
	** Purpose  : This function used for order success mail to user
	** Date : 
	************************************************************************/
	function UserSignUpmailtoadmin($name="",$email="") { 
       	    $fromMail  		= 	'sales@liquorjunction4.com';
			$siteFullName	=	'Liquor Junction';
			$toMail  		= 	'sales@liquorjunction4.com';
			$subject 		= 	"New User Registration";
			//$sitefullurl	= 	base_url();
			
			#.............................. message section ............................#
				$MHtml		=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>'.$sitefullname.'</title>
								</head>
								<body><p>Hello,</p>
								 <p>There is a new registration, details of the same as follows.</p>
								 <table border="0" style="width:100%">
								  <tr>
									<td width="35%">Name:</td>
									<td width="5%">&nbsp;</td>
									<td width="60%">'.$name.'</td>
								  </tr>
								  <tr>
									<td width="35%">Email:</td>
									<td width="5%">&nbsp;</td>
									<td width="60%">'.$email.'</td>
								  </tr>
								</table>
								 <p>Thanks, <br />
								</p>
								</body>
								</html>';
							
			//echo $MHtml; die;
			$this->email->from($fromMail,$siteFullName);
			$this->email->to($toMail); 
			$this->email->subject($subject);
			$this->email->set_mailtype('html');
			$this->email->message($MHtml);	
			$this->email->send();
			//echo $this->email->print_debugger();exit;
	}
	
	
	 /***********************************************************************
	** Function name : sendOrderMailToUser
	** Developed By : Ritu Mishra
	** Purpose  : This function used for order success mail to user
	** Date : 
	************************************************************************/
	function sendOrderMailToAdmin($username="",$orderid="") { 
       	    $fromMail  		= 	'sales@liquorjunction4.com';
			$siteFullName	=	'Liquor Junction';
			$toMail  		= 	'ritu.mishra@algosoft.co';
			$subject 		= 	"Order Successfull mail";
			//$sitefullurl	= 	base_url();
			
			#.............................. message section ............................#
			$MHtml 			= 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>'.$siteFullName.'</title>
								</head>
								<body>
								    <p>Hi '.$result['admin_name'].',</p>
									<p>your order has been received. Your order id : '.$orderid.'.</p>
																	 <p>Thanks, <br />
								</p>
								</body>
								</html>';
			//echo $MHtml; die;
			$this->email->from($fromMail,$siteFullName);
			$this->email->to($toMail); 
			$this->email->subject($subject);
			$this->email->set_mailtype('html');
			$this->email->message($MHtml);	
			$this->email->send();
			//echo $this->email->print_debugger();exit;
	}
	
	
		 /***********************************************************************
	** Function name : forgotpassword_mail_to_user
	** Developed By : Ritu Mishra
	** Purpose  : This function used for forgot password mail to user
	** Date : 
	************************************************************************/
	function forgotpassword_mail_to_user($email="",$username="",$otp="") { 
	    
       	    $fromMail  		= 	'sales@liquorjunction4.com';
			$siteFullName	=	'Liquor Junction';
			$toMail  		= 	$email;
			$subject 		= 	"Forgot Password Mail";
			//$sitefullurl	= 	base_url();
			
			#.............................. message section ............................#
			$MHtml 			= 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>'.$siteFullName.'</title>
								</head>
								<body>
								    <p>Hi '.$username.',</p>
									<p> Your otp is : '.$otp.'.</p>
																	 <p>Thanks, <br />
								</p>
								</body>
								</html>';
			//echo $MHtml; die;
			$this->email->from($fromMail,$siteFullName);
			$this->email->to($toMail); 
			$this->email->subject($subject);
			$this->email->set_mailtype('html');
			$this->email->message($MHtml);	
			$this->email->send();
			//echo $this->email->print_debugger();exit;
	}
	
		 /***********************************************************************
	** Function name : forgotpassword_mail_to_user
	** Developed By : Ritu Mishra
	** Purpose  : This function used for forgot password mail to user
	** Date : 
	************************************************************************/
	function resetpassword_mail_to_user($email="",$name="") { 
       	    $fromMail  		= 	'sales@liquorjunction4.com';
			$siteFullName	=	'Liquor Junction';
			$toMail  		= 	$email;
			$subject 		= 	"Reset Password Mail";
			//$sitefullurl	= 	base_url();
			
			#.............................. message section ............................#
			$MHtml 			= 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>'.$siteFullName.'</title>
								</head>
								<body>
								    <p>Hi '.$name.',</p>
									<p> Your password have been changed successfully.</p>
																	 <p>Thanks, <br />
								</p>
								</body>
								</html>';
			//echo $MHtml; die;
			$this->email->from($fromMail,$siteFullName);
			$this->email->to($toMail); 
			$this->email->subject($subject);
			$this->email->set_mailtype('html');
			$this->email->message($MHtml);	
			$this->email->send();
			//echo $this->email->print_debugger();exit;
	}
}	