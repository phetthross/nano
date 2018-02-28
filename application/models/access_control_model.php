<?php 
class access_control_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->helper('form');	
		/*
		if (!$this->session->menu)
		{
			redirect(site_url('login'),'refresh');
		}
		*/
	}

}

?>