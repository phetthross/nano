<?php
class Productos_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');		
	}
	function get_detalle_insumo( $id )
	{
		return $this->db->query(
			"
			select
				insumo.id as id
				,insumo.descripcion as insumo
				,um.sigla	
			    ,marca.id AS marca
			    ,um.id idUnidadMedida
				,categoria.id as categoria
			    ,bodega.id AS bodega
			from M_Insumos insumo
			inner join M_Marcas marca on marca.id = insumo.idMarca
			inner join M_Bodegas bodega on bodega.id = insumo.idBodega
			inner join M_CategoriaInsumos categoria on categoria.id = insumo.idCategoriaInsumo
			inner join M_UnidadMedida um on um.id = insumo.idUnidadMedida
			where insumo.id = {$id}
			"
			)->row();
	}
	function get_productos()
	{
		$query = $this->db->query("
			select
				insumo.id as id
				,insumo.descripcion as insumo	
				,categoria.descripcion as categoria
				,um.sigla	
			    ,marca.descripcion AS marca
			    ,bodega.descripcion AS bodega
			from M_Insumos insumo
			inner join M_Marcas marca on marca.id = insumo.idMarca
			inner join M_Bodegas bodega on bodega.id = insumo.idBodega
			inner join M_UnidadMedida um on um.id = insumo.idUnidadMedida
			inner join M_CategoriaInsumos categoria on categoria.id = insumo.idCategoriaInsumo
				")->result_array();
		$index = -1;
		
		return $query;
	}
	function dropdown_categoria_insumo()
	{
		return $this->db->query("
			select id, descripcion from M_CategoriaInsumos
		")->result_array();
	}
	function dropdown_unidad_medida()
	{
		return $this->db->query("
			select id, descripcion from M_UnidadMedida
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