<?php
/*
* Get url segment for pagination
*/
if (!function_exists('getUrlSegment')) {
	function getUrlSegment(){
		/////////////   Localhost 		/////////////////
		if($_SERVER['SERVER_NAME']=='localhost'):
			$urlSegment	=	4;
		else:
			$urlSegment	=	4;
		endif;
		return $urlSegment;
	}
}

/*
* Get current base path
*/
if (!function_exists('getCurrentBasePath')) {
	function getCurrentBasePath(){
		return base_url();
	}
}

/*
* Get current base path
*/
if (!function_exists('getCurrentControllerPath')) {
	function getCurrentControllerPath($postfixUrl=''){
		$CI =& get_instance();
		$functionArray 				=	array('index','addeditdata','deletedata','changestatus','imageUpload','imageDelete','deleteContent','memberDelete','viewdata','changedatastatus','getdatabyajax'); 
		$baseUrl 					=	getCurrentBasePath();
		if(in_array($CI->uri->segment(3),$functionArray)):  
		    $baseUrl 				=	$baseUrl.$CI->uri->segment(1).'/'.$CI->uri->segment(2).'/'.$postfixUrl;
		elseif(in_array($CI->uri->segment(2),$functionArray)):	
			$baseUrl 				=	$baseUrl.$CI->uri->segment(1).'/'.$postfixUrl;
		else:		
			$baseUrl 				=	$baseUrl.$postfixUrl;
		endif; 
		return $baseUrl;
	}
}

/*
* Get current dashboard base path
*/
if (!function_exists('getCurrentDashboardPath')) {
	function getCurrentDashboardPath($postfixUrl=''){
		$CI =& get_instance();
		$baseUrl 					=	getCurrentBasePath();
		$baseUrl 					=	$baseUrl.$CI->uri->segment(1).'/'.$postfixUrl;
		return $baseUrl;
	}
}

/*
 * show status
 */
if (!function_exists('showStatus')) {
	function showStatus($text='') {
		$statusArray	=	array('A'=>'<label class="badge badge-light-success">'.lang('active').'</label>',
								  'I'=>'<label class="badge badge-light-danger">'.lang('inactive').'</label>',
								  'B'=>'<label class="badge badge-light-danger">'.lang('block').'</label>',
								  'D'=>'<label class="badge badge-light-danger">'.lang('deleted').'</label>',
								  'Y'=>'<label class="badge badge-light-success">'.lang('active').'</label>',
								  'N'=>'<label class="badge badge-light-danger">'.lang('inactive').'</label>',
								  'R'=>'<label class="badge badge-light-danger">'.lang('inactive').'</label>');
		return $statusArray[$text];
	}
}

/*
 * show payment status
 */
if (!function_exists('showPaymentStatus')) {
	function showPaymentStatus($text='') {
		$statusArray	=	array('N'=>'<label class="badge badge-light-danger">'.lang('pending').'</label>',
								  'Y'=>'<label class="badge badge-light-success">'.lang('released').'</label>'
								  );
		return $statusArray[$text];
	}
}

/*
 * show payment status
 */
if (!function_exists('showAcountVerifiedStatus')) {
	function showAcountVerifiedStatus($text='') {
		$statusArray	=	array('N'=>'<label class="badge badge-light-danger">'.lang('account_pending').'</label>',
								  'Y'=>'<label class="badge badge-light-success">'.lang('account_verified').'</label>'
								  );
		return $statusArray[$text];
	}
}

/*
 * show payment status
 */
if (!function_exists('showPropertyStatus')) {
	function showPropertyStatus($text='') {
		$statusArray	=	array('p'=>'<label class="badge badge-light-danger">'.lang('property_pending').'</label>',
								  'IV'=>'<label class="badge badge-light-success">'.lang('inspector_verify').'</label>',
								  'IR'=>'<label class="badge badge-light-success">'.lang('inspector_reject').'</label>',
								  'AV'=>'<label class="badge badge-light-success">'.lang('admin_verify').'</label>',
								  'AR'=>'<label class="badge badge-light-success">'.lang('admin_reject').'</label>'
								  );
		return $statusArray[$text];
	}
}

/*
 * show payment status
 */
if (!function_exists('showPaymentStatusSimple')) {
	function showPaymentStatusSimple($text='') {
		$statusArray	=	array('0'=>lang('initialize'),
								  '1'=>lang('success'),
								  '2'=>lang('cancel'),
								  '3'=>lang('error'),
								  '4'=>lang('refund'));
		return $statusArray[$text];
	}
}
/*
 * show Aprrove Status
 */
if (!function_exists('showApproveStatus')) {
	function showApproveStatus($text='') {
		$statusArray	=	array('A'=>'<label class="badge badge-light-success">'.lang('publish').'</label>',
								  'I'=>'<label class="badge badge-light-danger">'.lang('unpublish').'</label>',
								  'D'=>'<label class="badge badge-light-danger">'.lang('reject').'</label>');
		return $statusArray[$text];
	}
}

/*
 * show Aprrove Status
 */
if (!function_exists('showAccountActiveStatus')) {
	function showAccountActiveStatus($text='') {
		$statusArray	=	array('1'=>'<label class="badge badge-light-success">'.lang('login').'</label>',
								  '0'=>'<label class="badge badge-light-danger">'.lang('logout').'</label>');
		return $statusArray[$text];
	}
}

/*
* Generate admin Pagination
*/
if (!function_exists('adminPagination')) {
	function adminPagination($url='',$suffix='',$rowsCount='',$perPage='',$uriSegment='') {
		$ci = & get_instance();
		$ci->load->library('pagination');
		
		$config = array();
		$config["base_url"] 		= 	$url;
		$config['suffix'] 			= 	$suffix;
		$config["total_rows"] 		= 	$rowsCount;
		$config["per_page"] 		= 	$perPage;
		$config["uri_segment"] 		= 	$uriSegment;
		$config['full_tag_open'] 	= 	'<ul class="pagination">';
		$config['full_tag_close'] 	= 	'</ul>';
		$config['num_tag_open'] 	= 	'<li class="paginate_button page-item">';
		$config['num_tag_close'] 	= 	'</li>';
		$config['cur_tag_open'] 	= 	'<li class="paginate_button page-item active"><a href="javascript:void(0);" class="page-link">';
		$config['cur_tag_close'] 	= 	'</a></li>';
		
		$config['next_link'] 		= 	'Next';
		$config['next_tag_open'] 	= 	'<li class="paginate_button page-item next">';
		$config['next_tag_close'] 	= 	'</li>';
		$config['prev_tag_open'] 	= 	'<li class="paginate_button page-item previous">';
		$config['prev_link'] 		= 	'Previous';
		$config['prev_tag_close'] 	= 	'</li>';
		
		$config['first_link'] 		= 	'First';
		$config['first_tag_open'] 	= 	'<li class="paginate_button page-item previous">';
		$config['first_tag_close'] 	= 	'</li>';
		
		$config['last_link'] 		= 	'Last';
		$config['last_tag_open'] 	= 	'<li class="paginate_button page-item next">';
		$config['last_tag_close'] 	= 	'</li>';
		
		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}
}

if (!function_exists('sanitizedFieldName')) {
	function sanitizedFieldName($filename){
		$sanitized = preg_replace('/[^a-zA-Z0-9-_\.]/','', $filename);
		return $sanitized;
	}
}
	
/*
 * check Remote File
 */
if (!function_exists('checkRemoteFile')) {
	function checkRemoteFile($url='')
	{
		if($url):
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_NOBODY, 1);
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			if(curl_exec($ch)!==FALSE):
				return true;
			else:
				return false;
			endif;
		else:
			return false;
		endif;
	}
}	

/*
 * Show correct image
 */
if (!function_exists('showCorrectImage')) {
	function showCorrectImage($imageUrl='', $type = '',$showType='') {
		if(checkRemoteFile($imageUrl)): 
			if($type=='original'):
				$imageUrl = str_replace('/thumb','',$imageUrl);
			elseif($type):
				$imageUrl = str_replace('thumb',$type,$imageUrl);
			endif;
		else:	
			if($showType == 'profile'):
				if($type=='original'):
					$imageUrl = base_url().'assets/admin/image/image402x402.jpg';
				elseif($type=='thumb'):
					$imageUrl = base_url().'assets/admin/image/image213X213.jpg';
				endif;
			endif;
		endif;
		return trim($imageUrl);
	}
}
