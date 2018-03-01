<?php
class Login extends CI_Controller
{
	public $class_name = 'Login';
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Standard_model');
		$this->load->helper('url');
		$this->load->helper('form');	
		$this->load->library('session');	
		
	}
	private function check_password( $password_db )
	{
		if ( password_verify($this->input->post('password'), $password_db ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function index()
	{
		// Consulta si este metyodo ah recibido variables post desde el navegador
		if (isset($_POST) AND count($_POST) > 0)
		{
			$username =  $this->input->post('username');
			$password =  $this->input->post('password');
			$response = $this->db->query("select  u.id, u.rut, u.nombre, u.paterno, u.materno, tp.descripcion, u.password from M_Usuarios u inner join M_TipoUsuarios tp on tp.id = idTipoUsuario where username = '{$username}' or correo = '{$username}' ")->row();
			if ( count($response) > 0 )
			{
				$usuario = array(
					'id' => $response->id,
					'rut' => $response->rut,
					'nombre'	=>	ucwords( $response->nombre ),
					'paterno'	=>	ucwords( $response->paterno ),
					'materno'	=>	ucwords( $response->materno ),
					'nivel'		=>	ucwords( strtolower($response->descripcion) ),
					);
				$this->session->usuario = $usuario;		
				$response_check = $this->check_password( $response->password );
				if ( $response_check === TRUE )
				{
					$mesagge = array(
						"type"=>"info",
						"tittle"=>"Bienvenido",
						"message"=>"Bienvenid@ ".$usuario["nombre"].' '.$usuario["paterno"].' '.$usuario["materno"],
						"positionClass" => "toast-top-full-width",
					);
					$this->session->set_flashdata("welcome", $mesagge);
					redirect(site_url('inicio'),'refresh');	
				}
				else
				{
					$mesagge = array(
						"type"=>"error",
						"tittle"=>"Error en el Inicio de Sesión.",
						"message"=>"Las credenciales ingresadas no son validas.",
						"positionClass" => "toast-top-center"
					);
					$this->session->set_flashdata("message", $mesagge);
				}				
			}	
			else
			{
				$mesagge = array(
					"type"=>"error",
					"tittle"=>"Error en el Inicio de Sesión.",
					"message"=>"Las credenciales ingresadas no son validas.",
					"positionClass" => "toast-top-center"
				);
				$this->session->set_flashdata("message", $mesagge);

			}						
		}		
		else
		{
			$this->session->unset_userdata('menu');
			$this->session->unset_userdata('usuario');
			
			//redirect(site_url('login'),'refresh');		
		}
		$data['class_name'] = $this->class_name;
		$data = $this->Standard_model->load_header_footer();		
		$this->load->view( $this->class_name.'/index',$data);
	}
	function logout()
	{

	}
}