<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generatelogs
{
	private $file,$prefix;

	public function __construct($parameter=array())
	{
		$this->file 	= 	FCPATH."./application/logs/".$parameter['type'].date("d_m_Y").'.txt';
		$this->prefix 	= 	date("D M d Y h.i A")." >> ";
		$this->CI 		= 	& get_instance();
	}

	public function putLog($type='',$text='') {
		
		$class			= 	$this->CI->router->fetch_class();
		$method			= 	$this->CI->router->fetch_method();
		$type 			=	$type.' - '.$class.' - '.$method.' >> ';
		/*if(file_exists($this->file)):
			fopen($this->file,'a');
		else:
			fopen($this->file,'w');
        endif;
        if(isset($this->prefix)):
            file_put_contents($this->file, $this->prefix.$type.$text."\r\n\r\n", FILE_APPEND);
        else:
        	$this->prefix 	= 	date("D M d 'y h.i A")." >> ";
            file_put_contents($this->file, $this->prefix.$type.$text."\r\n\r\n", FILE_APPEND);
        endif;*/
        
    	return true;
    }

    public function putLogFiles($type='',$text='') {
		
		$class			= 	$this->CI->router->fetch_class();
		$method			= 	$this->CI->router->fetch_method();
		$type 			=	$type.' - '.$class.' - '.$method.' >> ';
		/*if(file_exists($this->file)):
			fopen($this->file,'a');
		else:
			fopen($this->file,'w');
        endif;
        if(isset($this->prefix)):
            file_put_contents($this->file, $this->prefix.$type.$text."\r\n\r\n", FILE_APPEND);
        else:
        	$this->prefix 	= 	date("D M d 'y h.i A")." >> ";
            file_put_contents($this->file, $this->prefix.$type.$text."\r\n\r\n", FILE_APPEND);
        endif;*/
        
    	return true;
    }

    public function getLog() {
        $content = @file_get_contents($this->file);
        return $content;
    }

        function secondtotimedate($ss) {
	$s = $ss%60;
	$m = floor(($ss%3600)/60);
	$h = floor(($ss%86400)/3600);
	$d = floor(($ss%2592000)/86400);
	$M = floor($ss/2592000);

	if($d > 0):
	return "$d days, $h hours, $m minutes";
else:
	return "Bidding expired";
endif;
	}
	
}