<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class marcas extends CI_Controller
{
	public $class_name = 'marcas';
	public $view_name = 'generic_view';
	
	function __construct()
	{
		parent::__construct();	
		$this->load->helper('url');	
		$this->load->model('access_control_model');	
		$this->load->model('Standard_model');			
		//$this->Login_model->access_control();
		$this->load->model('marcas_model');			
	}
	public function index()
	{
		$table_options = array(
			'id'				=>	'id',
			'model'				=>	$this->class_name,	
			'id_table'  		=>  'table',
			'edit'				=>	FALSE,
			'delete'			=>	FALSE,		
			'custom'=>array(	
				'Editar'=>array(
					'method' => 'editform',
					'icon'	 => 'fa fa-pencil-square-o fa-lg',					
					),				
				'Eliminar'=>array(
					'method' => 'delete',
					'icon'	 => 'fa fa-trash fa-lg',
					),
				)		
			);
		$data['plural_name'] = 'Mantenedores / Marcas';
		$data['class_name'] = $this->class_name;
		$data['table'] = $this->marcas_model->get_marcas();
		$data['table'] = $this->Standard_model->bootstrapTable( $data['table'], array('ID','NOMBRE', 'DESCRIPCIÓN'), $table_options );
		$this->Standard_model->render_view($this->view_name.'/index',$data);
	}

	public function addform()
	{
		$form = array(
			'nombre'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	200,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 200',
					'label'			=>	'Nombre:'
				),
			'descripcion'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	200,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 200',
					'label'			=>	'Descripción:'
				)			
		);
		$data['class_name'] = $this->class_name;
		$data['method_name'] = "recordadd";
		$data['tittle'] = "Nueva Marca";
		$data['plural_name'] = 'Marcas / Nueva Marca';
		$data['form'] = $this->Standard_model->renderForm( $form );
		$this->Standard_model->render_view($this->view_name.'/add',$data);
	}
	public function delete( $id=NULL )
	{
		if ( $id != NULL )
		{
			$conditions = array( 'id'=>$id );
			$this->Standard_model->delete_data('M_marcas', $conditions);
			$mesagge = array(
						"type"=>"info",
						"tittle"=>"Registro Eliminado.",
						"message"=>"La marca se ha eliminado de la base de datos.",
						"positionClass" => "toast-top-center"
					);
			$this->session->set_flashdata("message", $mesagge );
			redirect($this->class_name, 'refresh');
		}	
		else
		{
			$message = 'Debe iniciar correctamente el proceso de creación de la categoría para acceder al sitio solicitado.';
			$this->Standard_model->flash_message('message_index','danger','fa fa-exclamation-triangle fa-lg', $message);
			redirect($this->class_name, 'refresh');	
		}
	}
	public function recordadd()
	{
		if (isset($_POST) AND count($_POST) > 0 )
		{
			//print_r($_POST);
			//exit(0);
			//validar que el dato no exista
			$conditions = array( 'nombre'=>$this->input->post('nombre') );
			$exist_data = $this->Standard_model->exist_data( 'M_Marcas', $conditions);
			if( $exist_data === TRUE )
			{
				$params = array( 
					"nombre" => $this->input->post("nombre"),
					"descripcion" => $this->input->post("descripcion")
				);
				$this->Standard_model->add_data( 'M_Marcas', $params );
				$mesagge = array(
						"type"=>"success",
						"tittle"=>"Registro Ingresado.",
						"message"=>"La marca se ha ingresado a la base de datos.",
						"positionClass" => "toast-top-center"
					);
				$this->session->set_flashdata("message", $mesagge );	
			}
			else
			{
				$mesagge = array(
						"type"=>"warning",
						"tittle"=>"Error al agregar el registro.",
						"message"=>"La marca que intentas ingresar ya se encuentra en la base de datos.",
						"positionClass" => "toast-top-center"
					);
				$this->session->set_flashdata("error_form", $mesagge );
				redirect($this->class_name.'/addform', 'refresh');			
			}
			
			redirect($this->class_name, 'refresh');
		}	
		else
		{
			$mesagge = array(
						"type"=>"warning",
						"tittle"=>"Error de Acceso.",
						"message"=>"Debe acceder correctamente para acceder al sitio solicitado.",
						"positionClass" => "toast-top-full-width"
					);
			$this->session->set_flashdata("message", $mesagge );
			redirect($this->class_name, 'refresh');	
		}
	}

	public function editform( $id=NULL )
	{
		if ( $id != NULL )
		{
			$conditions = array( 'id'=>$id );
			$response = $this->marcas_model->get_detalle_marca( $id );
			$form = array(
			'id'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'readonly'		=> "true",
					'placeholder'	=>	'Max. 50',
					'value'			=> $response->id,
					'label'			=>	'Producto:'
				),
			'nombre'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	200,
					'required'		=>	'TRUE', 
					'value'			=>	$response->nombre,
					'placeholder'	=>	'Max. 200',
					'label'			=>	'Nombre:'
				),		
			'descripcion'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	200,
					'required'		=>	'TRUE', 
					'value'			=>	$response->descripcion,
					'placeholder'	=>	'Max. 200',
					'label'			=>	'Descripción:'
				),		
			);
			$data['class_name'] = $this->class_name;
			$data['tittle'] = "Editando Tipo de Producto";
			$data['method_name'] = "recordedit";
			$data['plural_name'] = 'Tipo de Producto / Editando Tipo de Producto';
			$data['form'] = $this->Standard_model->renderForm( $form );
			$this->Standard_model->render_view($this->view_name.'/edit',$data);
		}	
		else
		{
			$mesagge = array(
						"type"=>"warning",
						"tittle"=>"Error de Acceso.",
						"message"=>"Debe acceder correctamente para acceder al sitio solicitado.",
						"positionClass" => "toast-top-full-width"
					);
			$this->session->set_flashdata("message", $mesagge );
			redirect($this->class_name, 'refresh');	
		}
	}
	public function recordedit()
	{
		if (isset($_POST) AND count($_POST) > 0 )
		{
			//validar que el dato no exista
			
			$conditions = array( 'id' => $this->input->post('id') );
			$data = array(
				'nombre'	=> $this->input->post('nombre'),
				'descripcion'	=> $this->input->post('descripcion'),
				);
			$this->Standard_model->update_data('M_marcas', $conditions, $data);
			$mesagge = array(
						"type"=>"success",
						"tittle"=>"Registro Actualizado.",
						"message"=>"La marca ha sido actualizada correctamente en la base de datos.",
						"positionClass" => "toast-top-center"
					);
			$this->session->set_flashdata("message", $mesagge );		
			redirect($this->class_name, 'refresh');
		}	
		else
		{
			$mesagge = array(
						"type"=>"warning",
						"tittle"=>"Error de Acceso.",
						"message"=>"Debe acceder correctamente para acceder al sitio solicitado.",
						"positionClass" => "toast-top-full-width"
					);
			$this->session->set_flashdata("message", $mesagge );
			redirect($this->class_name, 'refresh');	
		}
	}

}