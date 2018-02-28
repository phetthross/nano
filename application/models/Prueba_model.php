<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prueba_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
	}
	function get_usuarios($rut)
	{
		echo "la query que estas haciendo es: select * from usuario where RUT={$rut}<br>";
		return $this->db->query("select * from usuario where RUT={$rut}")->result_array();
	}

	

}

/* End of file prueba_model.php */
/* Location: ./application/models/prueba_model.php */