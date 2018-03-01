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
		$this->load->model('Standard_model');	
	}
	function dropdown_proveedor()
	{
		return $this->db->query("
			select id, concat(nombre,' ',paterno,' ',materno) descripcion from M_Usuarios
			")->result_array();
	}
	function ingresos( $idProducto )
	{
		//-----Query total ingresos
		return $this->db->query("
			select
				case when SUM(cantidad) is null then 0 else SUM(cantidad) end stock_actual
				,case when SUM(neto) is null then 0 else SUM(neto) end neto_actual
			from
				t_detallemovimiento dm
			inner join
				t_cabeceramovimiento cm on dm.idCabecera = cm.id
			where
				dm.idProducto = {$idProducto}
				and cm.idEstado = 1		
				and cm.idTipoMovimiento = 1	
			")->row();
		//-----
	}
	function egresos( $idProducto )
	{
		//-----Query total egresos
		return $this->db->query("
			select
				case when SUM(cantidad) is null then 0 else SUM(cantidad) end stock_actual
				,case when SUM(neto) is null then 0 else SUM(neto) end neto_actual
			from
				t_detallemovimiento dm
			inner join
				t_cabeceramovimiento cm on dm.idCabecera = cm.id
			where
				dm.idProducto = {$idProducto}
				and cm.idEstado = 1		
				and cm.idTipoMovimiento = 2
			")->row();
		//-----
	}
	function ingresar_pmp( $detalle )
	{
		$stock_actual = 0;
		$ingresos = $this->ingresos($detalle['idProducto'])->stock_actual;
		$ingreso_actual = $this->ingresos($detalle['idProducto'])->neto_actual;
		$egresos = $this->egresos($detalle['idProducto'])->stock_actual;
		$egreso_actual = $this->egresos($detalle['idProducto'])->neto_actual;
		$stock_actual = $ingresos - $egresos;
		$existencia_actual = $ingreso_actual + $egreso_actual;
		$params = array(
			'idTipoMovimiento'	=> 1,
			'idInsumo'			=> $detalle['idProducto'],
			'idCabecera'		=> $detalle['idCabecera'],
			'cantidad'			=> $detalle['cantidad'],
			'precioUnitario'	=> round( $detalle['neto'] / $detalle['cantidad']),
			'totalMovimiento'	=> $detalle['neto'],
			'stock'				=> $stock_actual,
			'pmp'				=> round( ($existencia_actual + $detalle['neto']) / ($stock_actual + $detalle['cantidad']) ),
			'totalExistencia'	=> $existencia_actual,
			);
		$this->Standard_model->add_data('t_registrapmp', $params);
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
				$this->ingresar_pmp($params);
				unset($params);
			}
			//------
			//------Registro de PMP
			//---
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
					,(select pmp from t_registrapmp where idInsumo=dm.idProducto order by fechaTransaccion desc limit 1) pmp			
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
			$response[$index]['pmp'] = '$'.number_format($value['pmp'], 0, '', '.');
		}
		return $response;
	}
	
	
	
}