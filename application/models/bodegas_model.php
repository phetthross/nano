<?php
class bodegas_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');		
	}
	function get_detalle_bodega( $id )
	{
		return $this->db->query(
			"
			select * from M_bodegas where id = {$id}
			"
			)->row();
	}
	function get_bodegas()
	{
		$query = $this->db->query("
		select * from M_Bodegas
				")->result_array();
		$index = -1;
		
		return $query;
	}
	
}