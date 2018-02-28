<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller
{
	public $class_name = 'productos';
	public $view_name = 'generic_view';
	
	function __construct()
	{
		parent::__construct();	
		$this->load->helper('url');	
		$this->load->model('access_control_model');	
		$this->load->model('Standard_model');			
		//$this->Login_model->access_control();
		$this->load->model('Productos_model');			
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
		$data['plural_name'] = 'Mantenedores / Productos';
		$data['class_name'] = $this->class_name;
		$data['table'] = $this->Productos_model->get_productos();
		$data['table'] = $this->Standard_model->bootstrapTable( $data['table'], array('ID','PRODUCTO','CATEGORÍA','U.M.','MARCA', 'BODEGA'), $table_options );
		$this->Standard_model->render_view($this->view_name.'/index',$data);
	}

	public function addform()
	{
		$form = array(
			'descripcion'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 50',
					'label'			=>	'*Descripción:'
				),
			'idCategoriaInsumo'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'*Categoría de Insumos:',			
					'required'		=>	TRUE,	
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idCategoriaInsumo',				
					'data'			=>	$this->Productos_model->dropdown_categoria_insumo()
				),		
			'idMarca'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'*Marca:',				
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idMarca',				
					'data'			=>	$this->Productos_model->dropdown_marca()
				),				
			'idBodega'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'*Bodega:',			
					'required'		=>	TRUE,	
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idBodega',				
					'data'			=>	$this->Productos_model->dropdown_bodegas()
				),	
			'idUnidadMedida'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'*Unidad de Medida',			
					'required'		=>	TRUE,	
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idUnidadMedida',				
					'data'			=>	$this->Productos_model->dropdown_unidad_medida()
				),					
		);
		$data['class_name'] = $this->class_name;
		$data['method_name'] = "recordadd";
		$data['tittle'] = "Nuevo Producto";
		$data['plural_name'] = 'Productos / Nuevo Producto';
		$data['form'] = $this->Standard_model->renderForm( $form );
		$this->Standard_model->render_view($this->view_name.'/add',$data);
	}
	public function delete( $id=NULL )
	{
		if ( $id != NULL )
		{
			$conditions = array( 'id'=>$id );
			$this->Standard_model->delete_data('M_Insumos', $conditions);
			$mesagge = array(
						"type"=>"info",
						"tittle"=>"Registro Eliminado.",
						"message"=>"El porducto se ha eliminado de la base de datos.",
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
			$conditions = array( 'descripcion'=>$this->input->post('descripcion') );
			$exist_data = $this->Standard_model->exist_data( 'M_Insumos', $conditions);
			if( $exist_data === TRUE )
			{
				$params = array( 
					"descripcion"		=> $this->input->post("descripcion"),
					"idCategoriaInsumo"	=> $this->input->post("idCategoriaInsumo"),
					"idMarca"			=> $this->input->post("idMarca"),
					"idBodega"			=> $this->input->post("idBodega"),
					"idUnidadMedida"	=> $this->input->post("idUnidadMedida"),
				);
				$this->Standard_model->add_data( 'M_Insumos', $params );
				$mesagge = array(
						"type"=>"success",
						"tittle"=>"Registro Ingresado.",
						"message"=>"El producto se ha ingresado a la base de datos.",
						"positionClass" => "toast-top-center"
					);
				$this->session->set_flashdata("message", $mesagge );	
			}
			else
			{
				$mesagge = array(
						"type"=>"warning",
						"tittle"=>"Error al agregar el registro.",
						"message"=>"El producto que intentas ingresar ya se encuentra en la base de datos.",
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
			$response = $this->Productos_model->get_detalle_insumo( $id );
			$form = array(
			'id'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'readonly'		=> "true",
					'placeholder'	=>	'Max. 50',
					'value'			=> $response->id,
					'label'			=>	'Producto:'
				),
			'descripcion'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'value'			=>	$response->insumo,
					'placeholder'	=>	'Max. 50',
					'label'			=>	'Descripción:'
				),
			'idCategoriaInsumo'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'selected'		=>	$response->categoria,
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'Categoría de Insumos:',			
					'required'		=>	TRUE,						
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idCategoriaInsumo',				
					'data'			=>	$this->Productos_model->dropdown_categoria_insumo()
				),		
			'idMarca'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'selected'		=>	$response->marca,
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'Marca',				
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idMarca',				
					'data'			=>	$this->Productos_model->dropdown_marca()
				),				
			'idBodega'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'selected'		=>	$response->bodega,
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'Bodega',			
					'required'		=>	TRUE,						
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idBodega',				
					'data'			=>	$this->Productos_model->dropdown_bodegas()
				),		
			'idUnidadMedida'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'*Unidad de Medida',	
					'selected'		=>	$response->idUnidadMedida,		
					'required'		=>	TRUE,	
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idUnidadMedida',				
					'data'			=>	$this->Productos_model->dropdown_unidad_medida()
				),					
			);
			$data['class_name'] = $this->class_name;
			$data['tittle'] = "Editando Producto";
			$data['method_name'] = "recordedit";
			$data['plural_name'] = 'Productos / Editando Producto';
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
				'descripcion'	=> $this->input->post('descripcion'),
				'idCategoriaInsumo'	=> $this->input->post('idCategoriaInsumo'),
				'idMarca'	=> $this->input->post('idMarca'),
				'idBodega'	=> $this->input->post('idBodega'),
				'idUnidadMedida'	=> $this->input->post('idUnidadMedida')
				);
			$this->Standard_model->update_data('M_Insumos', $conditions, $data);
			$mesagge = array(
						"type"=>"success",
						"tittle"=>"Registro Actualizado.",
						"message"=>"El producto ha sido actualizado correctamente en la base de datos.",
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