<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Layouts
{
	// hold CI intance 
	private $CI;
	//hold layout title
	private $layout_title = NULL;
	//hold layout discription
	private $layout_description = NULL;
	//hold layout keyword
	private $layout_keyword = NULL;
	
	public function __construct()
	{
		$this->CI = & get_instance();
	}

	public function admin_view($view_name, $layouts=array(), $params=array(),$viewtype='')
	{	
		$this->CI->load->library('parser');
		if(is_array($layouts) && count($layouts) >=1):
			foreach($layouts as $layout_key => $layout):
				$params[$layout_key] = $this->CI->parser->parse($layout, $params, true);
			endforeach;
		endif;
		
		$params['BASE_URL']				= 	base_url();
		$params['FULL_SITE_URL']		= 	$this->CI->session->userdata('ILCADM_ADMIN_CURRENT_PATH')?$this->CI->session->userdata('ILCADM_ADMIN_CURRENT_PATH'):getCurrentBasePath();
		
		$params['ASSET_URL']			= 	base_url().'assets/';
		$params['ASSET_INCLUDE_URL']	= 	base_url().'assets/admin/';

		$params['CURRENT_CLASS']		= 	$this->CI->router->fetch_class();
		$params['CURRENT_METHOD']		= 	$this->CI->router->fetch_method();
		
		$pagedata['title'] 				= 	$this->layout_title?$this->layout_title:'Login';
		$pagedata['description']		= 	$this->layout_description;
		$pagedata['keyword'] 			= 	$this->layout_keyword;
	    //echo 	$viewtype;exit;
		if($viewtype == 'onlyview'):
			$this->CI->parser->parse($view_name, $params);
		elseif($viewtype == 'login'):
			$pagedata['head'] 				= 	$this->CI->parser->parse("layouts/admin/login_head",$params,true);
			$pagedata['content']			= 	$this->CI->parser->parse('admin/'.$view_name,$params,true);
			$pagedata['footer_js'] 			= 	$this->CI->parser->parse("layouts/admin/login_footer_js",$params,true);
			$this->CI->parser->parse("layouts/admin_login", $pagedata);
		else:
		    //echo $view_name;exit;
			$pagedata['head'] 				= 	$this->CI->parser->parse("layouts/admin/head",$params,true);
			$pagedata['menu'] 				= 	$this->CI->parser->parse("layouts/admin/menu",$params,true);
			$pagedata['navigation'] 		= 	$this->CI->parser->parse("layouts/admin/navigation",$params,true);
			$pagedata['content']			= 	$this->CI->parser->parse('admin/'.$view_name,$params,true);
			$pagedata['footer'] 			= 	$this->CI->parser->parse("layouts/admin/footer",$params,true);
			$pagedata['footer_js'] 			= 	$this->CI->parser->parse("layouts/admin/footer_js",$params,true);
			$this->CI->parser->parse("layouts/admin", $pagedata);
		endif;
	}

	public function front_view($view_name, $layouts=array(), $params=array(),$viewtype='')
	{	
		$this->CI->load->library('parser');
		if(is_array($layouts) && count($layouts) >=1):
			foreach($layouts as $layout_key => $layout):
				$params[$layout_key] = $this->CI->parser->parse($layout, $params, true);
			endforeach;
		endif;
		
		$params['BASE_URL']				= 	base_url();
		$params['FRONT_URL']			= 	base_url().'front/';
		$params['ADMIN_URL']			= 	base_url().'admin/';
		$params['ASSET_ADMIN_URL']		= 	base_url().'assets/admin/';
		$params['ASSET_URL']			= 	base_url().'assets/';
		$params['ASSET_FRONT_URL']		= 	base_url().'assets/front/';
		$params['FRONT_SITE_URL']		= 	$this->CI->session->userdata('POSTPONEMENT_FRONT_CURRENT_PATH');
		$params['CURRENT_CLASS']		= 	$this->CI->router->fetch_class();
		$params['CURRENT_METHOD']		= 	$this->CI->router->fetch_method();
		
		$pagedata['title'] 				= 	$this->layout_title?$this->layout_title:'Postponement';
		$pagedata['description']		= 	$this->layout_description;
		$pagedata['keyword'] 			= 	$this->layout_keyword;
		
		if($viewtype == 'onlyview'):
			$this->CI->parser->parse('front/'.$view_name, $params);
		elseif($viewtype == 'login'):
			$pagedata['head'] 				= 	$this->CI->parser->parse("layouts/front/head",$params,true);
			$pagedata['menu']				=	'';
			$pagedata['content']			= 	$this->CI->parser->parse('front/'.$view_name,$params,true);
			$pagedata['footer_js'] 			= 	$this->CI->parser->parse("layouts/front/footer_js",$params,true);
			$this->CI->parser->parse("layouts/front", $pagedata);
		else:
			$pagedata['head'] 				= 	$this->CI->parser->parse("layouts/front/head",$params,true);
			$pagedata['menu']				=	'';
			$pagedata['navigation'] 		= 	$this->CI->parser->parse("layouts/front/navigation",$params,true);
			$pagedata['content']			= 	$this->CI->parser->parse('front/'.$view_name,$params,true);
			$pagedata['footer'] 			= 	$this->CI->parser->parse("layouts/front/footer",$params,true);
			$pagedata['footer_js'] 			= 	$this->CI->parser->parse("layouts/front/footer_js",$params,true);
			$this->CI->parser->parse("layouts/front", $pagedata);
		endif;
	}

	/**
     * Set page title
     *
     * @param $title
     */
    public function set_title($title)
	{
		$this->layout_title = $title;
		return $this;
	}
	
	/**
     * Set page description
     *
     * @param $description
     */
    public function set_description($description)
	{
		$this->layout_description = $description;
		return $this;
	}
	
	/**
     * Set page keyword
     *
     * @param $keyword
     */
    public function set_keyword($keyword)
	{
		$this->layout_keyword = $keyword;
		return $this;
	}
}