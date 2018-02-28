<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class eventos_model extends CI_Model
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

}

/* End of file eventos_model.php */
/* Location: ./application/models/eventos_model.php */