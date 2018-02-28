<?php
class Inicio extends CI_Controller
{
	public $class_name = 'Inicio';
	
	function __construct()
	{
		parent::__construct();	
		$this->load->helper('url');		
		$this->load->library('session');
		//$this->load->model('access_control_model');
		$this->load->model('Standard_model');			
	}
	function index()
	{
		$data['class_name'] = $this->class_name;
		$data = $this->Standard_model->load_header_footer();
		//$this->Standard_model->send_mail();
		
		//$this->Standard_model->pdfDownload($data);
		$this->load->view( $this->class_name.'/index',$data);
	}	
}