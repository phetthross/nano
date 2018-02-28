<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recetas extends CI_Controller
{
	public $class_name = 'recetas';
	public $view_name = 'generic_view';
	
	function __construct()
	{
		parent::__construct();	
		$this->load->helper('url');	
		//$this->load->model('access_control_model');	
		$this->load->model('Standard_model');			
		//$this->Login_model->access_control();
		$this->load->model('Recetas_model');			
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
			'invisible_columns'	=>	array('id'),
			'custom'=>array(	
				'DETALLE'=>array(
					'method' => 'detalle',
					'icon'	 => 'fa fa-eye fa-lg',					
					),
				'EDITAR'=>array(
					'method' => 'editform',
					'icon'	 => 'fa fa-pencil-square-o fa-lg',					
					),				
				'ELIMINAR'=>array(
					'method' => 'delete',
					'icon'	 => 'fa fa-trash fa-lg',
					),
				)		
			);
		$data['plural_name'] = 'Recetas';
		$data['class_name'] = $this->class_name;
		$data['table'] = $this->Recetas_model->get_recetas();
		$data['table'] = $this->Standard_model->bootstrapTable( $data['table'], array('DESCRIPCIÓN', 'FECHA CREACIÓN'), $table_options );
		$this->Standard_model->render_view($this->view_name.'/index',$data);
	}	
	public function edit_detail($id=NUlL)
	{
		if ( $id != NULL )
		{
			$response = $this->Recetas_model->get_detalle_receta( $id );
			$form = array(
				'idInsumo'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'selected'		=>	$response->idInsumo,
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'Insumo:',			
					'required'		=>	TRUE,	
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idInsumo',				
					'data'			=>	$this->Recetas_model->get_dropdown_productos(),
				),
				'cantidad'	=>	array(
					'type'			=>	'input',		
					'maxlength'		=>	50,
					'required'		=>	'TRUE',
					'value'			=>	$response->cantidad,
					'placeholder'	=>	'Max. 50',
					'label'			=>	'Cantidad:'
				),
				'id'	=>	array(
					'type'			=>	'hidden',		
					'maxlength'		=>	50,
					'required'		=>	'TRUE',
					'value'			=>	$response->id,
					'placeholder'	=>	'Max. 50',
					'label'			=>	''
				),
			);
			$data['class_name'] = $this->class_name;
			$data['tittle'] = "Editando Detalle de Receta";
			$data['method_name'] = "record_edit_detail";
			$data['plural_name'] = 'Detalle Receta / Editando Detalle';
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
	public function air( $id=NULL )
	{
		if ( $id != NULL )
		{
			$form = array(
				'idRecetaCabecera'	=>	array(
					'type'			=>	'hidden',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'value'			=>	$id,
					'placeholder'	=>	'Max. 50',
					'label'			=>	'Descripción:'
				),
			);
			$dinamic_add = array(
				'id_table' => 'dinamic_table',
				'add_buttom_text' => 'añadir Insumo',
				'del_buttom_text' => 'Eliminar',
				'columns' => array(
					'idInsumo'	=>	array(
						'name'	=>	'idInsumo',					
						'type'	=>	'DropdownAutocomplete',
						'data'	=>	$this->Standard_model->generateDropdownAutoCompleteForJs($this->Recetas_model->get_dropdown_productos(), "Seleccione Insumo", "descripcion", "idInsumo", NULL, TRUE,  'owo')
					),
					'descripcion'	=>	array(
						'type'			=>	'text',			
						'maxlength'		=>	3,
						'name'			=>	'descripcion',
						'required'		=>	'TRUE', 
						'placeholder'	=>	'Cantidad',
					),			
				)
			);
			$data['dinamic'] = $this->Standard_model->renderForm($form,FALSE);
			$data['form'] = $this->Standard_model->dinamicAdd($dinamic_add,'owo');
			$data['class_name'] = $this->class_name;
			$data['tittle'] = "Agregando Elementos a <spna class='label label-success' style='font-size:15px;'>".$this->Recetas_model->get_nombre_receta($id).'</span>';
			$data['plural_name'] = 'Recetas / Editando Receta';	
			$data['method_name'] = "recorder";
			$this->Standard_model->render_view($this->view_name.'/add',$data);
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
		);
		$dinamic_add = array(
			'id_table' => 'dinamic_table',
			'add_buttom_text' => 'añadir Insumo',
			'del_buttom_text' => 'Eliminar',
			'columns' => array(
				'idInsumo'	=>	array(
					'name'	=>	'idInsumo',					
					'type'	=>	'DropdownAutocomplete',
					'data'	=>	$this->Standard_model->generateDropdownAutoCompleteForJs($this->Recetas_model->get_dropdown_productos(), "Seleccione Insumo", "descripcion", "idInsumo", NULL, TRUE,  'owo')
				),
				'descripcion'	=>	array(
					'type'			=>	'text',			
					'maxlength'		=>	3,
					'name'			=>	'descripcion',
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Cantidad',
				),			
			)
		);
		$data['class_name'] = $this->class_name;
		$data['method_name'] = "recordadd";
		$data['tittle'] = "Nueva Receta";
		$data['plural_name'] = 'Recetas / Nueva Receta';
		$data['form'] = $this->Standard_model->renderForm( $form, FALSE);
		$data['dinamic'] = $this->Standard_model->dinamicAdd($dinamic_add,'owo');
		$this->Standard_model->render_view($this->view_name.'/add',$data);
	}
	public function detalle($id=NULL)
	{
		if ( $id != NULL )
		{
			$table_options = array(
			'id'				=>	'id',
			'model'				=>	$this->class_name,	
			'id_table'  		=>  'table',
			'edit'				=>	FALSE,
			'delete'			=>	FALSE,		
			'invisible_columns'	=>	array('id'),
			'custom'=>array(	
				'EDITAR'=>array(
					'method' => 'edit_detail',
					'icon'	 => 'fa fa-pencil-square-o fa-lg',					
					),				
				'ELIMINAR'=>array(
					'method' => 'del_detail',
					'icon'	 => 'fa fa-trash fa-lg',
					),
				)		
			);
			$nombre_receta = $this->Recetas_model->get_nombre_receta( $id );
			$data['plural_name'] = 'Recetas / Detalle <span class="label label-success" style="font-size:15px;">'.$nombre_receta.'</span>';
			$data['class_name'] = $this->class_name;
			$data['addform'] = 'air/'.$id;
			$data['back'] = 'index';
			$data['table'] = $this->Recetas_model->get_detalle_recetas( $id );
			$data['table'] = $this->Standard_model->bootstrapTable( $data['table'], array('INSUMO', 'CANTIDAD'), $table_options );
			$this->Standard_model->render_view($this->view_name.'/index',$data);
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
			$response = $this->Recetas_model->get_receta( $id );
			$form = array(
			
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
			$data['tittle'] = "Editando Receta";
			$data['method_name'] = "recordedit";
			$data['plural_name'] = 'Recetas / Editando Nombre de Receta';
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
	public function recorder()
	{
		if (isset($_POST) AND count($_POST) > 0 )
		{			
			$productos = array();
			foreach ($_POST as $key => $elements)
			{
				if( strpos($key, '|') != FALSE )
				{
					$row = explode('|', $key);
					$productos[$row[0]][$row[1]] = $elements;
				}
			}
			foreach ($productos as $key => $value)
			{
				$params = array(
					'idInsumo'			=>	$value['idInsumo'],
					'idRecetaCabecera'	=>	$this->input->post('idRecetaCabecera'),
					'cantidad'			=>	$value['descripcion'],
					);
				$this->Standard_model->add_data('m_recetadetalle', $params);
				unset($params);
			}
			$mesagge = array(
						"type"=>"success",
						"tittle"=>"Registro Ingresado.",
						"message"=>"El nuevo detalle se ha ingresado a la base de datos.",
						"positionClass" => "toast-top-center"
					);
			$this->session->set_flashdata("message", $mesagge );	
			redirect($this->class_name.'/detalle/'.$this->input->post('idRecetaCabecera'), 'refresh');	
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
	public function record_edit_detail()
	{
		if (isset($_POST) AND count($_POST) > 0 )
		{
			$params = array(
				'idInsumo'	=>	$this->input->post('idInsumo'),
				'cantidad'	=>	$this->input->post('cantidad'),
				);
			$conditions = array( 'id'=>$this->input->post('id') );
			$this->Standard_model->update_data( 'm_recetadetalle', $conditions, $params );
			$mesagge = array(
						"type"=>"success",
						"tittle"=>"Registro Actualizado.",
						"message"=>"El pdetalle de la receta ha sido actualizado correctamente en la base de datos.",
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
	public function recordadd()
	{
		if (isset($_POST) AND count($_POST) > 0 )
		{
			$productos = array();
			foreach ($_POST as $key => $elements)
			{
				if( strpos($key, '|') != FALSE )
				{
					$row = explode('|', $key);
					$productos[$row[0]][$row[1]] = $elements;
				}
			}
			//insercion de cabecera
			$params = array(
					'descripcion'		=> $this->input->post('descripcion'),
					'activo'			=> 1
					);
			$id_cabecera = $this->Standard_model->add_data( 'm_recetacabecera', $params );
			unset($params);

			//insercion de detalle
			foreach ($productos as $key => $value)
			{
				$params = array(
					'idInsumo'			=>	$value['idInsumo'],
					'idRecetaCabecera'	=>	$id_cabecera,
					'cantidad'			=>	$value['descripcion'],
					);
				$this->Standard_model->add_data( 'm_recetadetalle', $params );
				unset($params);
			}
			$mesagge = array(
						"type"=>"success",
						"tittle"=>"Registro Ingresado.",
						"message"=>"La marca se ha ingresado a la base de datos.",
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
	public function delete( $id=NULL )
	{
		if ( $id != NULL )
		{
			$conditions = array( 'id'=>$id );
			$this->Standard_model->delete_data('m_recetacabecera', $conditions);
			unset($conditions);
			$conditions = array('idRecetaCabecera' => $id);
			$this->Standard_model->delete_data('m_recetadetalle', $conditions);
			$mesagge = array(
						"type"=>"info",
						"tittle"=>"Registro Eliminado.",
						"message"=>"La receta se ha eliminado de la base de datos.",
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
	public function del_detail( $id=NULL )
	{
		if ( $id != NULL )
		{
			$conditions = array('id' => $id);
			$response = $this->Recetas_model->get_id_delete( $id );
			$this->Standard_model->delete_data('m_recetadetalle', $conditions);
			$mesagge = array(
						"type"=>"info",
						"tittle"=>"Registro Eliminado.",
						"message"=>"El insumo de la receta ha sido eliminado de la base de datos.",
						"positionClass" => "toast-top-center"
					);
			$this->session->set_flashdata("message", $mesagge );
			redirect($this->class_name.'/detalle/'.$response, 'refresh');
		}	
		else
		{
			$message = 'Debe iniciar correctamente el proceso de creación de la categoría para acceder al sitio solicitado.';
			$this->Standard_model->flash_message('message_index','danger','fa fa-exclamation-triangle fa-lg', $message);
			redirect($this->class_name, 'refresh');	
		}
	}
	
}
?>