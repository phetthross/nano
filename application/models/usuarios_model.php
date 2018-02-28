<?php
class usuarios_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');		
	}
	function get_detalle_usuario( $id )
	{
		return $this->db->query(
			"
			select
				*
			from M_Usuarios u
			inner join M_TipoUsuarios tp on tp.id = u.idTipoUsuario
			where u.id = {$id}
			"
			)->row();
	}
	function get_password( $id )
	{
		return $this->db->query("select password from M_Usuarios where id = {$id}")->row();
	}
	function get_usuarios()
	{
		$query = $this->db->query("
		select
			u.id
			,upper(nombre) as nombre
			,upper(paterno) as paterno
			,upper(materno) as materno
			,upper(username) as username
			,upper(correo) as correo
			,telefono
			,celular
			,tp.descripcion
		from M_usuarios u
		inner join M_tipoUsuarios tp on tp.id = u.idTipoUsuario
				")->result_array();
		$index = -1;
		
		return $query;
	}
	function dropdown_tipo_usuario()
	{
		return $this->db->query("
			select id, descripcion from M_TipoUsuarios
		")->result_array();
	}
	function dropdown_marca()
	{
		return $this->db->query("
			select id, descripcion from M_Marcas
		")->result_array();
	}
	function dropdown_bodegas()
	{
		return $this->db->query("
			select id, descripcion from M_Bodegas
		")->result_array();
	}
	
}