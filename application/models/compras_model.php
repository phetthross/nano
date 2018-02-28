<?php
class compras_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');		
	}
	function dropdown_proveedor()
	{
		return $this->db->query("
			select id, concat(nombre,' ',paterno,' ',materno) descripcion from M_Usuarios
			")->result_array();
	}
	function get_compras()
	{
		return $this->db->query(
			"
				select 
					i.id
					,i.descripcion
					,sum(dm.cantidad) cantidad
					,sum(dm.neto) neto
					,(sum(dm.cantidad)*sum(dm.neto)) total
				from
	            	T_CabeceraMovimiento cm
				inner join 
	            	T_DetalleMovimiento dm on dm.idCabecera = cm.id
				inner join
	            	M_Insumos i on i.id = dm.idProducto
	            where 
	            	cm.idEstado = 1
				group by
	            	i.descripcion
	                ,i.id
			"
			)->result_array();
	}
	
	
	
}