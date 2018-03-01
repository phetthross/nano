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
	function ingresar_compra()
	{
			$detalle = array();	
			foreach ($_POST as $key => $elements)
			{
				if( strpos($key, '|') != FALSE )
				{
					$row = explode('|', $key);
					$detalle[$row[0]][$row[1]] = $elements;
				}
			}
			$index = 0;
			$errors = 0;
			foreach ($detalle as $key => $value)
			{
				$index++;
				$temp_descuento = "";
				if( $value['descuento'] == '' )
				{
					$temp_descuento = 0;
				}
				if( strpos($value['descuento'], '%') != FALSE OR strpos($value['descuento'], ',') != FALSE OR strpos($value['descuento'], '.') != FALSE)
				{
					$temp_descuento = str_replace(array('%',',','.'), '', $value['descuento']);
					echo $temp_descuento;
					if( is_numeric($temp_descuento) )
					{
						$detalle[$index]['bruto']	= $value['total'] - round( $value['total'] * ($temp_descuento / 100) );
					}
					else
					{
						$detalle[$index]['bruto']	= $value['total'];
						$errors++;
					}
				}
				else
				{
					if( is_numeric($temp_descuento) and $temp_descuento < $value['total'] )
					{
						$detalle[$index]['bruto']	= $value['total'] - $temp_descuento;
						$value['descuento'] = round(($value['descuento'] * 100) / $value['total']);
					}
					else
					{
						$detalle[$index]['bruto']	= $value['total'];
						$errors++;
					}
				}				
				$detalle[$index]['iva']		= round($detalle[$index]['bruto'] * 0.19);
				$detalle[$index]['neto']	= $detalle[$index]['iva'] + $detalle[$index]['bruto'];
				isset($temp_descuento);				
			}
			//------retorna al formulario en caso de haber detectado errores
			if( $errors > 0 OR count($detalle) == 0 )
			{
				$mesagge = array(
						"type"=>"error",
						"tittle"=>"Error al ingresar la compra.",
						"message"=>"El valor de descuento no es valido o no se han ingresado detalles para esta compra.",
						"positionClass" => "toast-top-full-width"
					);
				$this->session->set_flashdata("error_form", $mesagge );		
				redirect($this->class_name.'/addform');
			}
			
			//------Construcción de la cabecera
			$params = array(
				'idTipoMovimiento'	=> 1,									//1:compra
				'idUsuario'			=> $this->session->usuario['id'],
				'idProveedor'		=> $this->input->post('idProveedor'),
				'fechaCompra'		=> $this->input->post('fechaCompra'),
				'idEstado'			=> 1,									//1:activo, 2:inactivo, 3:anulado por devolucion, 4:merma
				'numeroFactura'		=> $this->input->post('ncompra'),
				'comentarios'		=> $this->input->post('comentarios')
				);
			$id_cabecera = $this->Standard_model->add_data('t_cabeceramovimiento', $params);
			unset($params);			
			//------
			//------Contruccion del detalle
			foreach ($detalle as $key => $value)
			{
				$params = array(
					'idCabecera'	=> $id_cabecera,
					'idProducto'	=> $value['idInsumo'],
					'cantidad'		=> $value['cantidad'],
					'bruto'			=> $value['bruto'],
					'iva'			=> $value['iva'],
					'neto'			=> $value['neto'],
					'descuento'		=> $value['descuento']
					);
				$this->Standard_model->add_data('t_detallemovimiento', $params);
				unset($params);
			}
			//------
	}
	function get_compras()
	{
		$response = $this->db->query(
			"
				select 
					i.id
					,i.descripcion
					,sum(dm.cantidad) cantidad
					,(sum(dm.neto)) total
					
					
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
		$index = -1;
		foreach ($response as $key => $value)
		{
			$index++;
			$response[$index]['total'] = '$'.number_format($value['total'], 0, '', '.');
			#$response[$index]['total'] = '$'.number_format($value['total'], 0, '', '.');
		}
		return $response;
	}
	
	
	
}