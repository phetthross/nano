<?php
class marcas_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');		
	}
	function get_detalle_marca( $id )
	{
		return $this->db->query(
			"
		select * from M_Marcas where id = {$id}
			"
			)->row();
	}
	function get_marcas()
	{
		$query = $this->db->query("
			select
				* from M_Marcas
				")->result_array();
		$index = -1;
		
		return $query;
	}
	
	
}