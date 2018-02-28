<?php
class Recetas_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');		
	}
	public function get_id_delete( $id )
	{
		return $this->db->query(" select idRecetaCabecera from m_recetadetalle where id={$id} ")->row_array()['idRecetaCabecera'];
	}
	public function get_recetas()
	{
		$response =  $this->db->query('select id, descripcion, fechaTransaccion from m_recetacabecera')->result_array();
		$index = -1;
		foreach ($response as $key => $value)
		{
			$index++;
			$response[$index]['fechaTransaccion'] = date('d-m-Y H:i',strtotime($value['fechaTransaccion']));
		}
		return $response;
	}
	public function get_dropdown_productos()
	{
		return $this->db->query('select id, descripcion from m_insumos')->result_array();
	}
	public function get_nombre_receta($id)
	{
		return $this->db->query("select descripcion from m_recetacabecera where id = {$id} ")->row_array()['descripcion'];
	}
	public function get_detalle_recetas($id)
	{
		return $this->db->query("SELECT d.id, i.descripcion, d.cantidad FROM  m_recetadetalle d inner join m_recetacabecera c on d.idRecetaCabecera = c.id inner join m_insumos i on i.id = d.idInsumo where idRecetaCabecera = {$id}")->result_array();
	}
	public function get_detalle_receta( $id )
	{
		return $this->db->query("select * from m_recetadetalle where id={$id}")->row();
	}
	public function get_receta($id)
	{
		return $this->db->query("select * from m_recetacabecera where id = {$id}")->row();
	}
}
?>