<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('access_control_model');
		$this->load->library('grocery_CRUD');
	}
	
	public function index(){
		echo "hola";
		die();
	}
	public function codigo_barra()
	{
		$crud = new grocery_CRUD();
		//$crud->set_theme('flexigrid');
		$crud->set_language('spanish');
		$crud->set_table('producto');
		$crud->set_rules('cantidad', 'cantidad', 'numeric');
		$crud->set_rules('cantidad', 'cantidad', 'is_natural');
		//$crud->display_as('id_producto','PRODUCTO');
		//$crud->set_relation('id_producto', 'producto','nombre');
		$output = $crud->render();
		
		
		$this->_example_output($output);
	}
	
	public function codigo_barra_date()
	{
		if($this->input->post("fecha") !== "")
		{
			$fecha= $this->input->post("fecha");
			$crud = new grocery_CRUD();
			if ($fecha != "")
			{
				$crud->where("fecha between '".$fecha." 00:00:00.000' and '".$fecha." 23:59:00.000' ");	
			}	
			//$crud->set_theme('flexigrid');
			
			$crud->set_language('spanish');
			$crud->set_table('producto');
			$crud->set_rules('cantidad', 'cantidad', 'numeric');
			$crud->set_rules('cantidad', 'cantidad', 'is_natural');
			echo $fecha;
					
			//$crud->display_as('id_producto','PRODUCTO');
			//$crud->set_relation('id_producto', 'producto','nombre');
			//$crud->unset_list();
			$output = $crud->render();
			$this->_example_output($output);
		}
	
		
		
	}
	
	public function general(){
		$this->load->view('general.php');
	}
	function _example_output($output = null){
		$this->load->view('our_template.php', $output);
	}

}

