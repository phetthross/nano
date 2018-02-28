<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller
{
	public $class_name = 'usuarios';
	public $view_name = 'generic_view';
	
	function __construct()
	{
		parent::__construct();	
		$this->load->helper('url');	
		$this->load->model('access_control_model');	
		$this->load->model('Standard_model');			
		//$this->Login_model->access_control();
		$this->load->model('usuarios_model');			
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
		$data['plural_name'] = 'Usuarios';
		$data['class_name'] = $this->class_name;
		$data['table'] = $this->usuarios_model->get_usuarios();
		$data['table'] = $this->Standard_model->bootstrapTable( $data['table'], array('ID','NOMBRE','PATERNO','MATERNO','USERNAME', 'CORREO', 'TELEFONO', 'CELULAR', 'PERFIL'), $table_options );
		$this->Standard_model->render_view($this->view_name.'/index',$data);
	}

	public function addform()
	{
		$form = array(
			'idTipousuario'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'*Tipo de Usuario',			
					'required'		=>	TRUE,	
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idTipousuario',				
					'data'			=>	$this->usuarios_model->dropdown_tipo_usuario()
				),		
			'rut'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 50',
					'label'			=>	'*Rut:'
				),
			'dv'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	1,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'0-9, k',
					'label'			=>	'*Dígito Verificador:'
				),
			'nombre'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	40,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 40',
					'label'			=>	'*Nombre:'
				),
			'paterno'	=>	array(
					'type'			=>'input',			
					'maxlength'		=>	40,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 40',
					'label'			=>	'*Apellido Paterno:'
				),
			'materno'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	40,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 40',
					'label'			=>	'*Apellido Materno:'
				),
			
			'correo'	=>	array(
					'type'			=>	'email',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 50',
					'label'			=>	'*Correo:'
				),
			'telefono'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 50',
					'label'			=>	'Telefono:'
				),
			'celular'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 50',
					'label'			=>	'Celular:'
				),
			'username'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'autocomplete'	=>	'off',
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 50',
					'label'			=>	'Username:'
				),
			'password'	=>	array(
					'type'			=>	'password',			
					'maxlength'		=>	15,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 15',
					'label'			=>	'Password:'
				),
						
		);
		$data['class_name'] = $this->class_name;
		$data['method_name'] = "recordadd";
		$data['tittle'] = "Nuevo Usuario";
		$data['plural_name'] = 'Usuario / Nuevo Usuario';
		$data['form'] = $this->Standard_model->renderForm( $form );
		$this->Standard_model->render_view($this->view_name.'/add',$data);
	}
	public function delete( $id=NULL )
	{
		if ( $id != NULL )
		{
			$conditions = array( 'id'=>$id );
			$this->Standard_model->delete_data('M_Usuarios', $conditions);
			$mesagge = array(
						"type"=>"info",
						"tittle"=>"Registro Eliminado.",
						"message"=>"El usuario se ha eliminado de la base de datos.",
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
			$conditions = array( 'rut'=>$this->input->post('rut') );
			$exist_data = $this->Standard_model->exist_data( 'M_Usuarios', $conditions);
			if( $exist_data === TRUE )
			{
				$params = array( 
					"username"		=> $this->input->post("username"),
					"correo"		=> $this->input->post("correo"),
					"telefono"		=> $this->input->post("telefono"),
					"celular"		=> $this->input->post("celular"),
					"password"		=> password_hash($this->input->post('password'), PASSWORD_BCRYPT),
					"idTipousuario"	=> $this->input->post("idTipousuario"),
					"rut"			=> $this->input->post("rut"),
					"dv"			=> $this->input->post("dv"),
					"nombre"		=> $this->input->post("nombre"),
					"paterno"		=> $this->input->post("paterno"),
					"materno"		=> $this->input->post("materno")
				);
				$this->Standard_model->add_data( 'M_Usuarios', $params );
				$mesagge = array(
						"type"=>"success",
						"tittle"=>"Registro Ingresado.",
						"message"=>"El usuario se ha ingresado a la base de datos.",
						"positionClass" => "toast-top-center"
					);
				$this->session->set_flashdata("message", $mesagge );	
			}
			else
			{
				$mesagge = array(
						"type"=>"warning",
						"tittle"=>"Error al agregar el registro.",
						"message"=>"El usuario que intentas ingresar ya se encuentra en la base de datos.",
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
			$response = $this->usuarios_model->get_detalle_usuario( $id );
			$form = array(
			'id'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'readonly'		=> "true",
					'placeholder'	=>	'Max. 50',
					'value'			=> $response->id,
					'label'			=>	'Producto:'
				),
			'idTipousuario'	=>	array(
					'type'			=>	'dropdownAutoComplete',
					'placeholder'	=>	'Seleccione...',
					'label'			=>	'*Tipo de Usuario',			
					'required'		=>	TRUE,	
					'selected'		=>	$response->idTipoUsuario,
					'visible_column'=>	'descripcion',
					'post_name'		=>	'idTipousuario',				
					'data'			=>	$this->usuarios_model->dropdown_tipo_usuario()
				),		
			'rut'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 50',
					'value'			=> $response->rut,
					'label'			=>	'*Rut:'
				),
			'dv'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	1,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'0-9, k',
					'value'			=> $response->dv,
					'label'			=>	'*Dígito Verificador:'
				),
			'nombre'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	40,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 40',
					'value'			=> $response->nombre,
					'label'			=>	'*Nombre:'
				),
			'paterno'	=>	array(
					'type'			=>'input',			
					'maxlength'		=>	40,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 40',
					'value'			=> $response->paterno,
					'label'			=>	'*Apellido Paterno:'
				),
			'materno'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	40,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 40',
					'value'			=> $response->materno,
					'label'			=>	'*Apellido Materno:'
				),
			
			'correo'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'placeholder'	=>	'Max. 50',
					'value'			=> $response->correo,
					'label'			=>	'*Correo:'
				),
			'telefono'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'placeholder'	=>	'Max. 50',
					'value'			=> $response->telefono,
					'label'			=>	'*Telfono:'
				),
			'celular'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'value'			=> $response->celular,
					'placeholder'	=>	'Max. 50',
					'label'			=>	'Celular:'
				),
			'username'	=>	array(
					'type'			=>	'input',			
					'maxlength'		=>	50,
					'required'		=>	'TRUE', 
					'value'			=> $response->username,
					'placeholder'	=>	'Max. 50',
					'label'			=>	'Username:'
				),
			'password'	=>	array(
					'type'			=>	'password',			
					'maxlength'		=>	200,
					'required'		=>	'TRUE', 
					'value'			=> $response->password,
					'placeholder'	=>	'Max. 15',
					'label'			=>	'Password:'
				),
			);
			$data['class_name'] = $this->class_name;
			$data['tittle'] = "Editando Usuario";
			$data['method_name'] = "recordedit";
			$data['plural_name'] = 'Usuarios / Editando Usuario';
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
			$response_password = $this->usuarios_model->get_password( $this->input->post('id') );
			if( $response_password == $this->input->post('password') )
			{
				$data = array(
					"username"		=> $this->input->post("username"),
					"correo"		=> $this->input->post("correo"),
					"telefono"		=> $this->input->post("telefono"),
					"celular"		=> $this->input->post("celular"),
					"idTipousuario"	=> $this->input->post("idTipousuario"),
					"rut"			=> $this->input->post("rut"),
					"dv"			=> $this->input->post("dv"),
					"nombre"		=> $this->input->post("nombre"),
					"paterno"		=> $this->input->post("paterno"),
					"materno"		=> $this->input->post("materno")
				);
			}
			else
			{
				$data = array(
					"username"		=> $this->input->post("username"),
					"correo"		=> $this->input->post("correo"),
					"telefono"		=> $this->input->post("telefono"),
					"celular"		=> $this->input->post("celular"),
					"password"		=> password_hash($this->input->post('password'), PASSWORD_BCRYPT),
					"idTipousuario"	=> $this->input->post("idTipousuario"),
					"rut"			=> $this->input->post("rut"),
					"dv"			=> $this->input->post("dv"),
					"nombre"		=> $this->input->post("nombre"),
					"paterno"		=> $this->input->post("paterno"),
					"materno"		=> $this->input->post("materno")
				);
			}
			$conditions = array( 'id' => $this->input->post('id') );
			$this->Standard_model->update_data('M_Usuarios', $conditions, $data);
			$mesagge = array(
						"type"=>"success",
						"tittle"=>"Registro Actualizado.",
						"message"=>"El usuario ha sido actualizado correctamente en la base de datos.",
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