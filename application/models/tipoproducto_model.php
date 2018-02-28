<?php
class tipoproducto_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');		
	}
	function get_detalle_categoria( $id )
	{
		return $this->db->query(
			"
		select * from M_CategoriaInsumos where id = {$id}
			"
			)->row();
	}
	function get_categorias()
	{
		$query = $this->db->query("
			select
				* from M_CategoriaInsumos
				")->result_array();
		$index = -1;
		
		return $query;
	}
	
	
}