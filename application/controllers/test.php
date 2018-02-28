<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class test extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Standard_model');
		$this->load->model('Prueba_model');
		$this->load->helper('url');
		$this->load->helper('form');	
		$this->load->library('session');	
		
	}

	function index()
	{
		echo "hola ñaño esto es el metod principal y por defecto";
	}
	function feo($rut=333)
	{
		echo "estas intentando buscar el rut: ".$rut."<br>";
		$response = $this->Prueba_model->get_usuarios($rut);
		echo "<pre>";
		print_r($response);
		echo "</pre>";
	}
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */