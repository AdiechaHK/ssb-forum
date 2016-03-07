<?php
/**
* 
*/
class Template
{
	
	function __construct()
	{
		# code...
	}

	public static function guest($controller, $name, $data = array()) {
		$controller->load->view('include/page_start', $data);
		$controller->load->view('page/'. $name, $data);
		$controller->load->view('include/page_end', $data);
	}

	public static function user($controller, $name, $data = array()) {
		$controller->load->view('include/page_start', $data);
		$controller->load->view('include/header', $data);
		$controller->load->view('page/' . $name, $data);
		$controller->load->view('include/footer', $data);
		$controller->load->view('include/page_end', $data);
	}
}
?>