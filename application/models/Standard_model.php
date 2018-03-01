<?php
class Standard_model extends CI_Model
{
	public $show = '';
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('form');		
	}
	function print_array( $array )
	{
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
	function exist_data( $table_name, $conditions, $db_profile=NULL, $custom_message=NULL )
	{
		if ( $db_profile == NULL )
		{
			$response = $this->db->get_where( $table_name, $conditions )->row_array();
		}
		else
		{
			$profile = $this->load->database($db_profile, TRUE);
			$response = $profile->get_where( $table_name, $conditions )->row_array();
		}
		
		if ( count($response) > 0 )
		{
			if( $custom_message == NULL )
			{
				$message = 'El registro que intenta ingresar ya se encuentra en la base de datos.';
			}
			else
			{
				$message = $custom_message;
			}			
			$this->flash_message('message_form','danger','fa fa-exclamation-triangle fa-lg', $message);
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function custom_query( $query , $db_profile=NULL )
	{		
		if( $db_profile != NULL )
		{
			$profile = $this->load->database($db_profile, TRUE);
			return $profile->query( $query )->result_array();
		}
		else
		{
			return $this->db->query( $query )->result_array();	
		}
		
	}
	
	// Busca un registro en especifico
	function get_all( $table_name, $conditions, $db_profile=NULL, $custom_message=NULL )
	{
		if ( $db_profile == NULL )
		{
			$response = $this->db->get_where( $table_name, $conditions )->row_array();
		}
		else
		{
			$profile = $this->load->database($db_profile, TRUE);
			$response = $profile->get_where( $table_name, $conditions )->row_array();
		}
		if ( count($response) > 0 )
		{
			if ( $custom_message == NULL )
			{
				$custom_message = 'El registro que intenta ingresar ya se encuentra en la base de datos.';
			}
			$this->flash_message('message_form','danger','fa fa-exclamation-triangle fa-lg', $custom_message);
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	function get_data( $table_name, $conditions, $db_profile=NULL )
	{
		if ( $db_profile == NULL )
		{
			return $this->db->get_where( $table_name, $conditions )->row_array();
		}
		else
		{
			$profile = $this->load->database($db_profile, TRUE);
			return $profile->get_where( $table_name, $conditions )->row_array();
		}
		
	}
	
	function get_data_by_conditions ( $table_name, $conditions )
	{
		$this->db->select('*');
		$this->db->where( $conditions );		
		return $this->db->get( $table_name )->result_array();		
	}
		
	
	
	// Inserta un registro a la tabla
	function add_data( $table_name, $params, $db_profile=NULL )
	{
		if ( $db_profile == NULL )
		{
			if ($this->db->insert( $table_name, $params ))
			{
				$this->flash_message('message_index','success','fa fa-check-square fa-lg', 'Registro ingresado correctamente.');
				return $this->db->insert_id();	
			}
			else
			{
				$this->flash_message('message_index','danger','fa fa-exclamation-triangle fa-lg', 'Ha ocurrido un error mientra se intentaba ingresar el registro.');		
				return FALSE;
			}
		}
		else
		{
			$profile = $this->load->database($db_profile, TRUE);
			if ($profile->insert( $table_name, $params ))
			{
				$this->flash_message('message_index','success','fa fa-check-square fa-lg', 'Registro ingresado correctamente.');
				return $profile->insert_id();	
			}
			else
			{
				$this->flash_message('message_index','danger','fa fa-exclamation-triangle fa-lg', 'Ha ocurrido un error mientra se intentaba ingresar el registro.');		
				return FALSE;
			}
		}


		if ($this->db->insert( $table_name, $params ))
		{
			$this->flash_message('message_index','success','fa fa-check-square fa-lg', 'Registro ingresado correctamente.');
			return $this->db->insert_id();	
		}
		else
		{
			$this->flash_message('message_index','danger','fa fa-exclamation-triangle fa-lg', 'Ha ocurrido un error mientra se intentaba ingresar el registro.');		
			return FALSE;
		}
		
	}

	// Actualiza un registro en especifico
	function update_data( $table_name, $conditions, $params, $db_profile=NULL, $custom_message=NULL  )
	{
		if ($db_profile != NULL)
		{
			$profile = $this->load->database($db_profile, TRUE);
			$profile->where($conditions);
			$response = $profile->update( $table_name, $params );
			if ( $response )
			{
				$this->flash_message('message_index','success','fa fa-check-square fa-lg', 'Registro Actualizado correctamente.');			
				return TRUE;
			}
			else
			{
				$this->flash_message('message_index','danger','fa fa-exclamation-triangle fa-lg', 'Ha ocurrido un error mientra se intentaba actualizar el registro.');
				return FALSE;
			}
		}
		else
		{
			$this->db->where( $conditions );
			$response = $this->db->update( $table_name, $params );
			if ( $response )
			{
				$this->flash_message('message_index','success','fa fa-check-square fa-lg', 'Registro Actualizado correctamente.');			
				return TRUE;
			}
			else
			{
				$this->flash_message('message_index','danger','fa fa-exclamation-triangle fa-lg', 'Ha ocurrido un error mientra se intentaba actualizar el registro.');
				return FALSE;
			}
		}
		
	}

	function delete_data ( $table_name, $conditions, $db_profile=NULL )
	{
		if( $db_profile != NULL )
		{
			$profile = $this->load->database($db_profile, TRUE);
			$response = $profile->delete( $table_name, $conditions );
		}
		else
		{
			$response = $this->db->delete( $table_name, $conditions );
		}
		
		if ( $response )
		{
			$this->flash_message('message_index','info','fa fa-check-square fa-lg', 'El registro ha sido eliminado correctamente.');
		}
		else
		{
			$this->flash_message('message_index','danger','fa fa-exclamation-triangle fa-lg', 'Ha ocurrido un error mientras se intentaba eliminar el registro.');		
		}
	}

	//Elimina un registro en especifico
	function load_header_footer ()
	{
		// Carga de archivos css
		$data['header'] = $this->load->view('header', '', true);
		// Carga de archivois js
		$data['footer'] = $this->load->view('footer', '', true);

		return $data;
	}
	function render_view($route, $data)
	{
		$this->load->view('header');
		$this->load->view( $route, $data);
		$this->load->view('footer');
	}
	function flash_message($name, $type, $icon, $message)
	{
		switch ($type) {
			case 'success':
					$class = "<div class=\"alert alert-success\">";
				break;

			case 'warning':
					$class = "<div class=\"alert alert-warning\">";
				break;

			case 'danger':
					$class = "<div class=\"alert alert-danger\">";
				break;

			case 'info':
					$class = "<div class=\"alert alert-info\">";
				break;

			default:
					$class = "<div class=\"alert alert-success\">";
				break;
		}
		
		$this->session->set_flashdata($name, $class."<i class='".$icon."'></i> ".$message."</div>");
	}
	//
	// BOOSTRAP FUNCTIONS
	//	
	function bootstrapTable ( $data, $columns, $options )
	{
		$br = CHR(8);
		$table = "<div class=\"panel panel default\">\n";	
		if ( array_key_exists('new_page', $options) )
		{
			if ( $options['new_page'] == TRUE )
			{
				$new_page = " target='_blank' ";
			}			
		}
		else
		{
			$new_page = "";
		}	
		if (array_key_exists('id_table', $options) )
		{
			if ( $options['id_table'] != NULL )
			{
				$table .= "\t<div class='table-responsive'>\n\t\t<table id=\"".$options['id_table']."\" class=\"table table-striped table-bordered table-hover\" cellspacing=\"0\" width=\"100%\" style=\"line-height:1;\">\n";	
			}			
			else
			{
				$table .= "<div class='table-responsive'>\n\t\t<table class=\"table table-striped table-bordered table-hover\">";		
			}
		}
		else
		{
			$table .= "<div class='table-responsive'><table class=\"table table-striped table-bordered table-hover\">";
		}		
		$table .= "\t\t\t<thead>";	
		$table .= "\n\t\t\t\t<tr>";			
		$table .= "\n\t\t\t\t\t<th>\n\t\t\t\t\t\t<center>".implode("</center>\n\t\t\t\t\t\t</th>\n\t\t\t\t\t<th>\n\t\t\t\t\t\t<center>", array_values($columns))."</center>\n\t\t\t\t\t</th>";		
		

		if ( array_key_exists('custom', $options) )
		{
			$table .= "\n\t\t\t\t\t<th class='col-xs-1' align='center'>";
			$table .= "\n\t\t\t\t\t\t<center>OPCIONES</center>";				
			$table .= "\n\t\t\t\t\t</th>";		
		}	
		$hide_options = 0;
		$table .= "\n\t\t\t\t</tr>";		
		$table .= "\n\t\t\t</thead>";	
		$table .= "\n\t\t<tbody>";		
		foreach ($data as $row) 
		{
			$check_tr = 0;	
			$check_logic_conditions = 0;	
			if ( array_key_exists('success-row', $options) )
			{
				$check_logic_conditions++;
				if ( array_key_exists( 'hide_options', $options['success-row'] ) )
				{
					$hide_options++;
				}
				$row_type			= 'success';
				$row_operator		= $options['success-row']['operator'];
				$row_value			= $options['success-row']['value'];
				$row_column_name	= $options['success-row']['column_name'];
			}
			if ( array_key_exists('danger-row', $options) )
			{	
				$check_logic_conditions++;
				if ( array_key_exists( 'hide_options', $options['danger-row'] ) )
				{
					$hide_options++;
				}			
				$row_type			= 'danger';
				$row_operator		= $options['danger-row']['operator'];
				$row_value			= $options['danger-row']['value'];
				$row_column_name	= $options['danger-row']['column_name'];
			}
			if ( array_key_exists('warning-row', $options) )
			{
				$check_logic_conditions++;
				if ( array_key_exists( 'hide_options', $options['warning-row'] ) )
				{
					$hide_options++;
				}
				$row_type			= 'warning';
				$row_operator		= $options['warning-row']['operator'];
				$row_value			= $options['warning-row']['value'];
				$row_column_name	= $options['warning-row']['column_name'];
			}
			if ( array_key_exists('info-row', $options) )
			{
				$check_logic_conditions++;
				if ( array_key_exists( 'hide_options', $options['info-row'] ) )
				{
					$hide_options++;
				}
				$row_type			= 'info';
				$row_operator		= $options['info-row']['operator'];
				$row_value			= $options['info-row']['value'];
				$row_column_name	= $options['info-row']['column_name'];
			}
			if( $check_logic_conditions != 0 )
			{
				switch ($row_operator)
				{
					case '=':
						if ( $row[$row_column_name] == $row_value )
						{
							$table .= "\n\t\t\t<tr class='{$row_type}'>";
							$check_tr++;
						}	
					break;							
					case '<':
						if ( $row[$row_column_name] < $row_value )
						{
							$table .= "\n\t\t\t<tr class='{$row_type}'>";
							$check_tr++;
						}	
					break;
					case '>':
						if ( $row[$row_column_name] > $row_value )
						{
							$table .= "\n\t\t\t<tr class='{$row_type}'>";
							$check_tr++;
						}	
					break;
					case '<=':
						if ( $row[$row_column_name] <= $row_value )
						{
							$table .= "\n\t\t\t<tr class='{$row_type}'>";
							$check_tr++;
						}	
					break;
					case '>=':
						if ( $row[$row_column_name] >= $row_value )
						{
							$table .= "\n\t\t\t<tr class='{$row_type}'>";
							$check_tr++;
						}	
					break;
				}				
			}				
			if ( $check_tr == 0 )
			{
				$table .= "<tr>";	
			}	
			//limpieza de variables
			unset($row_type);
			unset($row_operator);
			unset($row_value);
			unset($row_column_name);				
			
			
			if ( array_key_exists('invisible_columns', $options) )
			{
				$visible_data = $row;
				if ( $options['invisible_columns'] != FALSE )
				{
					foreach ($options['invisible_columns'] as $value)
					{
						unset($visible_data[$value]);

					}
				}				
				if( array_key_exists('center_data', $options) )
				{
					if( $options['center_data'] == TRUE )
					{
						$table .= "\n<td><center>".implode("</center></td>\n<td><center>", array_values($visible_data))."</center></td>";	
					}
					else
					{
						$table .= "\n<td>".implode("</td>\n<td>", array_values($visible_data))."</td>";	
					}
				}
				else
				{
					$table .= "\n\t\t\t\t<td>".implode("</td>\n\t\t\t\t<td>", array_values($visible_data))."</td>";	
				}				
			}
			else
			{
				if( array_key_exists('center_data', $options) )
				{
					if( $options['center_data'] == TRUE )
					{
						$table .= "\n\t\t\t\t<td><center>".implode("</center></td><td><center>", array_values($row))."</center></td>";	
					}
					else
					{
						$table .= "\n\t\t\t\t<td>".implode("</td><td>", array_values($row))."</td>";	
					}
				}
				else
				{
					$table .= "\n\t\t\t\t<td>".implode("</td>\n\t\t\t\t<td>", array_values($row))."</td>";	
				}				
			}
			if ( $options['id'] != FALSE )
			{
				$id = $options['id'];
			}
			else
			{
				$id = 'id';
			}								
			if ( array_key_exists('custom', $options) )
			{
				$table .= "\n\t\t\t\t<td align='center'><center>";
				foreach ($options['custom'] as $key => $value)
				{
					//-------------------------------
					$visible_option = 0;
					if( array_key_exists('condition', $value) )
					{
						//
						switch ( $value['condition']['operator'] )
						{
							case '=':
								if ( $value['condition']['value1'] == $value['condition']['value2'] )
								{
									$visible_option++;
								}
							break;
						}
						//
					}
					if ( array_key_exists('conditions', $value) )
					{
						if ( array_key_exists('operator', $value['conditions']) )
						{
							switch ($value['conditions']['operator'])
							{
								case '=':
									if ( $row[$value['conditions']['column_name']] == $value['conditions']['value'] )
									{
										$visible_option++;
									}	
								break;
								
								case '<':
									if ( $row[$value['conditions']['column_name']] < $value['conditions']['value'] )
									{
										$visible_option++;
									}	
								break;

								case '>':
									if ( $row[$value['conditions']['column_name']] > $value['conditions']['value'] )
									{
										$visible_option++;
									}	
								break;

								case '<=':
									if ( $row[$value['conditions']['column_name']] <= $value['conditions']['value'] )
									{
										$visible_option++;
									}	
								break;

								case '>=':
									if ( $row[$value['conditions']['column_name']] >= $value['conditions']['value'] )
									{
										$visible_option++;
									}	
								break;

							}							
						}
						else
						{
							if ( $row[$value['conditions']['column_name']] >= $value['conditions']['value'] )
							{
								$visible_option++;
							}		
						}						
					}
					//-----------------------------------					
					if ( array_key_exists('second_value', $options) )
					{
						$allowed = array_values($options['second_value']);						
						$values = array_filter(
							$row,
							function($key) use ($allowed) {
								return in_array($key, $allowed);
							},
							ARRAY_FILTER_USE_KEY
						);	
						if (array_key_exists('encode_id', $options))
						{
							if ( ($visible_option == 0 AND $hide_options == 0) OR $check_tr == 0 ) 
							{
								$table .= "<a {$new_page} data-toggle=\"popover\" data-trigger=\"hover\" data-content=\"{$key}\" data-placement=\"left\" href='".site_url($options['model'].'/'.$value['method'].'/'.$this->encode_id(base64_encode($row[$id])).'/'.implode("/", base64_encode($values)))."' ><span class=\"".$value['icon']."\" aria-hidden=\"true\"></span></a>&nbsp;&nbsp;";
							}
						}
						else
						{
							if ( ($visible_option == 0 AND $hide_options == 0) OR $check_tr == 0 ) 
							{
								$table .= "<a {$new_page} data-toggle=\"popover\" data-trigger=\"hover\" data-content=\"{$key}\" data-placement=\"left\" href='".site_url($options['model'].'/'.$value['method'].'/'.$row[$id].'/'.implode("/", $values))."' ><span class=\"".$value['icon']."\" aria-hidden=\"true\"></span></a>&nbsp;&nbsp;";
							}
						}						
						
						unset($allowed);
						unset($values);
					}
					else
					{
						if (array_key_exists('encode_id', $options))
						{
							if ( ($visible_option == 0 AND $hide_options == 0) OR $check_tr == 0 ) 
							{
								$table .= "<a {$new_page} data-toggle=\"popover\" data-trigger=\"hover\" data-content=\"{$key}\" data-placement=\"left\" href='".site_url($options['model'].'/'.$value['method'].'/'.$this->encode_id(base64_encode($row[$id])))."' ><span class=\"".$value['icon']."\" aria-hidden=\"true\"></span></a>&nbsp;&nbsp;";
							}														
						}
						else
						{
							if ( ($visible_option == 0 AND $hide_options == 0) OR $check_tr == 0 ) 
							{
								$table .= "<a {$new_page} data-toggle=\"popover\" data-trigger=\"hover\" data-content=\"{$key}\" data-placement=\"left\" href='".site_url($options['model'].'/'.$value['method'].'/'.$row[$id])."' ><span class=\"".$value['icon']."\" aria-hidden=\"true\"></span></a>&nbsp;&nbsp;";
							}							
						}						
					}						
				}	
				$table .= "</td>";				
			}
			$table .= "\n</center></tr>";				 
		}			
		$table .= "\n</tbody>";	
		$table .= "\n</table>";
		$table .= "\n</div>";	
		$table .= "<script>
		$(document).ready(function(){
			$('[data-toggle=\"popover\"]').popover();
		});
		</script>";
		return $table;	
	}
	public function encode_id($data)
	{
		return str_replace(array('+','_','='), array('-','_',''), $data);
	}
	public function stringFTP( $params )
	{
		$config['hostname'] = $params['localhost'];
		$config['username'] = $params['admin'];
		$config['password'] = $params['password'];
		$config['debug'] = TRUE;
		return $config;
	}

	function createExportButtom($class_name, $options=NULL)
	{
		$class = strtolower($this->uri->segment(1));
		$method = strtolower($this->uri->segment(2));
		if ($options == NULL)
		{
			$options = array();
		}
		$check_option_dates = 0;
		$render = "";
		$period = FALSE;
		$date_range = FALSE;
		$render .= "<br>";
		if ( array_key_exists('custom_method', $options) )
		{
			$method_pdf = $options['custom_method']['pdf'];
			$method_csv = $options['custom_method']['csv'];			
		}
		else
		{
			$method_pdf = 'pdf';
			$method_csv = 'csv';				
		}
		if ( array_key_exists('period', $options) )
		{
			if ($options['period'] == TRUE )
			{
				$period = TRUE;
				$check_option_dates++;
			}
		}
		if ( array_key_exists('date_range', $options) )
		{
			if ($options['date_range'] == TRUE )
			{
				$date_range = TRUE;
				$check_option_dates++;
			}
		}
		
		// modal con rango de fechas
		if ( $date_range == TRUE )
		{
			$render .= "<div class=\"modal fade\" id=\"export_modal\"  role=\"dialog\" aria-labelledby=\"myModalLabel\">
						<div class=\"modal-dialog\" role=\"document\">
						    <div class=\"modal-content\">
						      <div class=\"modal-header\">
						        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
						        <h4 class=\"modal-title\" id=\"myModalLabel\"><center>Configurando archivo de Exportación</center></h4>
						      </div>
						      <div class=\"modal-body\">
						      <p align='justify'>Esta a punto de generar un archivo de exportación en formato <strong>PDF</strong>, para poder finalizar el proceso debe seleccionar un periodo contable y luego pulsar el boton generar para finalizar el proceso.</p>
						       "
						       ."<center><i style='color:#d43f3a;' class=\"fa fa-file-pdf-o fa-5x\" aria-hidden=\"true\"></i></center><br><br>"
						       .validation_errors()
						       .form_open($class_name.'/'.$method_pdf,array("class"=>"form-horizontal","target"=>"_blank"))
						       ."<input type='hidden' name='class' id='class' value='".$class."'>"
						       ."<input type='hidden' name='method' id='method' value='".$method."'>";
			if( array_key_exists('custom_pdf', $options) )
			{
				foreach ($options['custom_pdf'] as $key => $value)
				{
					$render .= "<div class='row'><div class='col-xs-4' align='left'><strong>".$value['label']."</strong></div><div class='col-xs-8'>";
					if ( $value['type'] == 'dropdownAutoComplete' )
					{
						$render .= $value['data']."</div></div><br>";
					}
				}
				
			}

						       $render .= "<div class='row'><div class='col-xs-4' align='left'><strong>Fecha Inicio</strong></div><div class='col-xs-8'>"
						       ."<div class=\"input-group date\" required=\"1\" id=\"date_ini\"><input name=\"date_ini\" type=\"text\" required=\"1\" value=\"{$this->input->post('fecha_ini')}\" class=\"form-control\" placeholder=\"Fecha Inicio\" required=\"1\" id=\"date_ini\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span></div></div></div><br>"
						       ."<script>$(function(){ $('#date_ini').datetimepicker({format: 'YYYY-MM-DD',locale: 'es',});})	</script>"


						       ."<div class='row'>
						       	<div class='col-xs-4' align='left' align='left'><strong>Fecha Fin</strong></div><div class='col-xs-8'>"
						       ."<div class=\"input-group date\" required=\"1\" id=\"date_end\"><input name=\"date_end\" type=\"text\" class=\"form-control\" value=\"{$this->input->post('fecha_fin')}\" placeholder=\"Fecha Fin\" required=\"1\" id=\"date_end\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span></div>"
						       ."<script>$(function(){ $('#date_end').datetimepicker({format: 'YYYY-MM-DD',locale: 'es'});})	</script>"
						       ."</div></div>"
						          ."<br>"
						       ."<div class='row'><div class='col-xs-4' align='left'><strong>Orientación de Pagina</strong></div><div class='col-xs-8'><select name=\"orientation\" aria-controls=\"cuentacontable\" id ='orientation' class=\"form-control\"><option value=\"vertical\">Vertical</option><option value=\"Landscape\">Horizontal</option></select></div></div>"
						       ."<br>"
						       ."<div class='row'><div class='col-xs-4' align='left'><strong>Visualización</strong></div><div class='col-xs-8'><select name=\"download\" aria-controls=\"cuentacontable\" id='download' class=\"form-control\"><option value=\"browser\">Navegador</option><option value=\"download\">Descarga Directa</option></select></div></div>"
						       ."<hr>"

						       ."<div class='row'>
						           <div class='col-xs-6'><button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-caret-square-o-left fa-lg\" aria-hidden=\"true\"></i> Cerrar</button></div>
						           <div class='col-xs-6'><button type=\"submit\" class=\"btn btn-danger btn-block\"><i class=\"fa fa-floppy-o fa-lg\" aria-hidden=\"true\"></i> Generar</button></div>
						         </div>"


						       .form_close()."
						      </div>
						    </div>
						  </div>
						</div>";			
		}
		
		if ( $date_range == TRUE )
		{
			$render .= "<div class=\"modal fade\" id=\"export_modal_csv\"  role=\"dialog\" aria-labelledby=\"myModalLabel\">
						  <div class=\"modal-dialog\" role=\"document\">
						    <div class=\"modal-content\">
						      <div class=\"modal-header\">
						        <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
						        <h4 class=\"modal-title\" id=\"myModalLabel\"><center>Configurando archivo de Exportación</center></h4>
						      </div>
						      <div class=\"modal-body\">
						      <p align='justify'>Esta a punto de generar un archivo de exportación en formato <strong>CSV</strong>, para poder finalizar el proceso debe seleccionar un periodo contable y luego pulsar el boton generar para finalizar el proceso.</p>
						       "
						       ."<center><i style ='color:#5cb85c;' class=\"fa fa-file-excel-o fa-5x\" aria-hidden=\"true\"></i></center><br><br>"
						       .validation_errors()
						       .form_open($class_name.'/'.$method_csv,array("class"=>"form-horizontal"))
						       ."<input type='hidden' name='class' id='class' value='".$class."'>"
						       ."<input type='hidden' name='method' id='method' value='".$method."'>";
			if( array_key_exists('custom_csv', $options) )
			{
				foreach ($options['custom_csv'] as $key => $value)
				{
					$render .= "<div class='row'><div class='col-xs-4' align='left'><strong>".$value['label']."</strong></div><div class='col-xs-8'>";
					if ( $value['type'] == 'dropdownAutoComplete' )
					{
						$render .= $value['data']."</div></div><br>";
					}
				}
				
			}
						       $render .= "<div class='row'><div class='col-xs-4' align='left'><strong>Fecha Inicio</strong></div><div class='col-xs-8'>"
						       ."<div class=\"input-group date\" required=\"1\" id=\"date_ini_csv\"><input name=\"date_ini_csv\" type=\"text\" required=\"1\" class=\"form-control\" placeholder=\"Fecha Inicio\" value=\"{$this->input->post('fecha_ini')} required=\"1\" id=\"date_ini_csv\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span></div></div></div><br>"
						       ."<script>$(function(){ $('#date_ini_csv').datetimepicker({format: 'YYYY-MM-DD',locale: 'es'});})	</script>"


						       ."<div class='row'>
						       	<div class='col-xs-4' align='left'><strong>Fecha Fin</strong></div><div class='col-xs-8'>"
						       ."<div class=\"input-group date\" required=\"1\" id=\"date_end_csv\"><input name=\"date_end_csv\" type=\"text\" class=\"form-control\" value=\"{$this->input->post('fecha_fin')}\" placeholder=\"Fecha Fin\" required=\"1\" id=\"date_end_csv\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span></div>"
						       ."<script>$(function(){ $('#date_end_csv').datetimepicker({format: 'YYYY-MM-DD',locale: 'es'});})	</script>"
						       ."</div></div>"
						       ."<hr>"

						       ."<div class='row'>
						           <div class='col-xs-6'><button type=\"button\" data-dismiss=\"modal\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-caret-square-o-left fa-lg\" aria-hidden=\"true\"></i> Cerrar</button></div>
						           <div class='col-xs-6'><button type=\"submit\" class=\"btn btn-danger btn-block\"><i class=\"fa fa-floppy-o fa-lg\" aria-hidden=\"true\"></i> Generar</button></div>
						         </div>"


						       .form_close()."
						      </div>
						    </div>
						  </div>
						</div>";			
		}
		$render .= "<div class='btn-group btn-block'>";
		$render .= "<button class='btn btn-warning btn-block dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span class=\"fa fa-floppy-o fa-lg\"></span> Exportar <span class='caret'></span></button>";
		$render .= "<ul class=\"dropdown-menu btn-block\">
            <li><p><strong><center>Seleccione Formato</center></strong></p></li>
            <li role='separator' class='divider'></li>";
		if ( $check_option_dates > 0 )
		{
			$render .= "<li><a data-target=\"#export_modal\" data-toggle=\"modal\" ><span class=\"fa fa-file-pdf-o fa-lg\"></span>&nbsp;&nbsp;&nbsp;PDF</a></li>";
		}
		
		if ( $check_option_dates == 0 )
		{
			$render .= "       
            <li><a href=\"".site_url($class_name."/pdf")."\"><span class=\"fa fa-file-pdf-o fa-lg\"></span>&nbsp;&nbsp;&nbsp;Archivo PDF</a></li>
            <li role='separator' class='divider'></li>";
		}    

		//csv
		if ( $check_option_dates > 0 )
		{
			if( array_key_exists('csv_off', $options))
			{
	
			}
			else
			{
				$render .= "<li><a data-target=\"#export_modal_csv\" data-toggle=\"modal\" ><span class=\"fa fa-file-excel-o fa-lg\"></span>&nbsp;&nbsp;&nbsp;CSV</a></li>";
			}
			
		}
		
		if ( $check_option_dates == 0 )
		{
			 $render .= "<li><a href=\"".site_url($class_name."/csv")."\"><span class=\"fa fa-file-excel-o fa-lg\"></span>&nbsp;&nbsp;&nbsp;Archivo CSV</a></li>
            <li role='separator' class='divider'></li>";
		}    
       

       $render .= "</ul>";
       $render .= "</div>";
        return $render;
	}
	function translate_human_month($number, $type='short')
	{
		$number = intval($number);
		$short = array(
			1	=> 'Ene',
			2	=> 'Feb',
			3	=> 'Mar',
			4	=> 'Abr',
			5	=> 'May',
			6	=> 'Jun',
			7	=> 'Jul',
			8	=> 'Ago',
			9	=> 'Sep',
			10	=> 'Oct',
			11	=> 'Nov',
			12	=> 'Dic'
			);
		$long = array(
			1	=> 'Enero',
			2	=> 'Febrero',
			3	=> 'Marzo',
			4	=> 'Abril',
			5	=> 'Mayo',
			6	=> 'Junio',
			7	=> 'Julio',
			8	=> 'Agosto',
			9	=> 'Septiembre',
			10	=> 'Octubre',
			11	=> 'Noviembre',
			12	=> 'Diciembre'
			);
		if ( $type == 'short' )
		{
			return $short[$number];
		}
		if ( $type == 'long' )
		{
			return $long[$number];
		}
		
	}
	function pdfCreate ($data, $options, $template)
	{
		$this->load->library('M_pdf');
		$title = "";
		if ( array_key_exists('header', $options) )
        {
        	if ( $options['header'] === TRUE )
        	{        		
        		$this->m_pdf->pdf->setHTMLHeader("<img src=\"".base_url("assets/images/pdf_header.jpg")."\" border=\"0\">");         		
        	}
        	else
        	{
        		$this->m_pdf->pdf->setHTMLHeader("<img src=\"".base_url("assets/images/".$options['header'])."\" border=\"0\">");   
        	}
        }    
		if ( array_key_exists('Landscape', $options) )
		{
			if ( $options['Landscape'] == TRUE )
        	{  
        		$title .= "<br>";
				$this->m_pdf->pdf->AddPage('L');
			}
		}
		$render = "";		
 		$model_name = $this->uri->segment(1);
        $pdfFilePath = $model_name." ".date("d-m-Y H:m:s").'.pdf';
         $this->m_pdf->pdf->setFooter("<table width='100%' style='font-size:12px;'><tr><td width='50%' text-align='left'>".$options['title']." ".date("d-m-Y H:m:s")."</td><td width='50%' text-align='right' align='right'>".'Pag. {PAGENO} de {nbpg}</td></tr></table>');
        $this->m_pdf->pdf->WriteHTML($template);
        $check_out = 0;
        if ( array_key_exists('browser', $options) )
        {
        	if ( $options['browser'] == TRUE )
        	{
        		$check_out++;
        		echo "<script>window.open('".site_url($this->uri->segment(1).'/pdf')."')</script>";
        		$this->m_pdf->pdf->Output();
        	}
        }
        if ( array_key_exists('download', $options) )
        {
        	if ($options['download'] == TRUE)
        	{
        		$check_out++;
        		$this->m_pdf->pdf->Output($pdfFilePath, "D");
        	}
        }
        if ( $check_out == 0 )
        {
        	$this->m_pdf->pdf->Output($pdfFilePath, "D");
        }
	}

	function pdfDownload( $data, $options )
	{
		$this->load->library('M_pdf');
		$title = "";
		if ( array_key_exists('header', $options) )
        {
        	if ( $options['header'] == TRUE )
        	{        		
        		$this->m_pdf->pdf->setHTMLHeader("<img src=\"".base_url("assets/images/pdf_header.jpg")."\" border=\"0\">");         		
        	}
        }    
		if ( array_key_exists('Landscape', $options) )
		{
			if ( $options['Landscape'] == TRUE )
        	{  
        		$title .= "<br>";
				$this->m_pdf->pdf->AddPage('L');
			}
		}
		 
        $this->m_pdf->pdf->setFooter("<table width='100%' style='font-size:12px;'><tr><td width='50%' text-align='left'>".$options['title']." ".date("d-m-Y H:m:s")."</td><td width='50%' text-align='right' align='right'>".'Pag. {PAGENO} de {nbpg}</td></tr></table>');
		$render = "";		
 		$model_name = $this->uri->segment(1);
        $pdfFilePath = $model_name." ".date("d-m-Y H:m:s").'.pdf';
 		
 		if ( array_key_exists('title', $options) )
 		{
 			$title .= "<p></p><h3 align='center' style='font:arial'>".$options['title']."</h3>";
 		}
 		else
 		{
 			$title .= "";
 		}           
        $table .= "<table style='width:100%; border: 1px solid #eeeeee; border-collapse:collapse; font:12px arial;'>";
        $table .= "<tr style='border: 1px solid #eeeeee; padding:6; background-color:#eeeeee;'>";
        if ( array_key_exists('columns', $options) )
        {
        	$table .= "<th style='border: 1px solid #ffffff; padding:6;'>".implode("</th><th style='border: 1px solid #ffffff; padding:6;'>", array_values($options['columns']))."</th>";
        }   
        $table .= "</tr>";


      	foreach ($data as $row)
      	{
      		$table .= "<tr style='border: 1px solid #eeeeee; padding:5;'>";
      		$table .= "<td style='border: 1px solid #eeeeee; padding:5;'>".implode("</td><td style='border: 1px solid #eeeeee; padding:5;'>", array_values($row))."</td>"; 
      		$table .= "</tr>";
      	}      	
      	$table .= "</table>";   
      	if(array_key_exists('aditional_data', $options))
      	{
      		$table .= $options['aditional_data'];
      	}   	
      	//generate the render value
      	$render = $title.$table; 		

      	//echo $table;
	      	 
        $this->m_pdf->pdf->WriteHTML("<body style=' font-family: arial; font-size:12pt;'>".$render); 
        //download it.
        $check_out = 0;
        if ( array_key_exists('browser', $options) )
        {
        	if ( $options['browser'] == TRUE )
        	{
        		$check_out++;
        		echo "<script>window.open('".site_url($this->uri->segment(1).'/pdf')."')</script>";
        		$this->m_pdf->pdf->Output();
        	}
        }
        if ( array_key_exists('download', $options) )
        {
        	if ($options['download'] == TRUE)
        	{
        		$check_out++;
        		$this->m_pdf->pdf->Output($pdfFilePath, "D");
        	}
        }
        if ( $check_out == 0 )
        {
        	$this->m_pdf->pdf->Output($pdfFilePath, "D");
        }
               
	}

	function to_csv( $data, $columns, $title = FALSE, $aditional_data = "", $delimiter = FALSE, $newline = "\n",  $enclosure = '"' )
	{
		$out = '';
		$this->load->helper('file');
		$this->load->helper('download');
		if ( $title != FALSE )
		{
			$out = $enclosure.$title.$enclosure.$newline;
		}
		if ( $delimiter == FALSE )
		{
			$delimiter = ';';
		}
		$model_name = $this->uri->segment(1);
		
		
		// First generate the headings from the table column names
		foreach ($columns as $name)
		{
			$out .= $enclosure.str_replace($enclosure, $enclosure.$enclosure, $name).$enclosure.$delimiter;
		}

		$out = substr($out, 0, -strlen($delimiter)).$newline;

		// Next blast through the result array and build out the rows
		foreach($data as $row)
		{
			$line = array();
			$out .= $enclosure;
			$line[] = implode($enclosure.$delimiter.$enclosure, $row).$enclosure.$newline;
			//$line[] = $enclosure.str_replace($enclosure, $enclosure.$enclosure, $data).$enclosure;
			$out .= implode($delimiter, $line);	
		}
		if( $aditional_data != "" )
		{
			$new_report = $out.$newline.$aditional_data;
		}
		else
		{
			$new_report = $out; 
		}
		
 		force_download($model_name." ".date("d-m-Y h:m:s").'.csv', "\xEF\xBB\xBF".$new_report);
	}

	public function generateDropDown($procedure, $dropDefault,$visible_column,$postName, $required=FALSE, $onChange=FALSE){
		$result=$procedure;
		
		$dataDrop= array();
		$dataDrop['']="Buscar ".$dropDefault;
		foreach($result AS $row){

			$dataDrop[$row['id']] = $row[$visible_column];
		}
		$detalles='id="'.$postName.'" class="form-control" ';
		if($required == TRUE)
		{
				$detalles .= ' required ';
		}
		if($onChange == TRUE)
		{
			$detalles .= ' onChange="this.form.submit()" ';
		}
		$search = "".form_dropdown($postName,$dataDrop," ",$detalles);
		
		return $search;
	}
	
	public function generateDropDownSelected($procedure, $dropDefault,$visible_column,$postName,$selected,$required=FALSE){
		$result=$procedure;
		
		$dataDrop= array();
		$dataDrop['']="Buscar ".$dropDefault;
		foreach($result AS $row){

			$dataDrop[$row['id']] = $row[$visible_column];
		}
		$detalles='id="'.$postName.'" class="form-control"';
		if($required == TRUE)
		{
				$detalles .= ' required ';
		}
		
		$search = "".form_dropdown($postName,$dataDrop,$selected,$detalles);
		
		return $search;
	}
	public function makeTextArea ( $options )
	{
		$text_box = "<textarea ";
		foreach ($options as $key => $value)
		{
			if ($key != 'value' or $key != 'label')
			{
				$text_box .= $key."=\"".$value."\"";	
			}			
		}
		if (array_key_exists('value', $options))
		{			
			 $text_box .= ">".$options['value']."</textarea>";
		}
		else
		{
			$text_box .= "></textarea>";
		}
		return $text_box; 
		
		//cols, rows, id, required(true/false), name
			
	}
	public function generateDropDownWithJS($procedure, $dropDefault,$visible_column,$postName,$required,$js_function, $js_value=NULL)
	{
		if ($js_value == NULL)
		{
			$js_value = "test";
		}
		$render = "";	
		if ($js_function != "")
		{
			//$js_function = $js_function.'('."\"'+test+'|".$postName.'\")';
			$js_function = $js_function.'(this)';
			$js = "onchange=\"{$js_function}\"";
		}
		else
		{
			$js = "";
		}
		if ( $required == TRUE )
		{
			$render .= "<select {$js} name=\"'+{$js_value}+'|".$postName."\" id=\"'+{$js_value}+'|".$postName."\" required class=\"form-control\">";
		}
		else
		{
			$render .= "<select {$js} name=\"'+{$js_value}+'|".$postName."\" id=\"'+{$js_value}+'|".$postName."\" class=\"form-control\">";
		}
		
		$render .= "<option value=\"\"  >".$dropDefault."</option>";
		
		foreach($procedure AS $row)
		{		
			$render .= "<option value=\"".$row['id']."\" class=\"form-control\">".$row[$visible_column]."</option>";		
		}		
		$render .= "</select>";				
		return $render;
	}
	public function generateDropDownForJS($procedure, $dropDefault,$visible_column,$postName,$required = NULL,$js_value=NULL)
	{
		if ($js_value == NULL)
		{
			$js_value = "test";
		}
		$render = "";	
		if ( $required == TRUE )
		{
			$render .= "<select name=\"'+{$js_value}+'|".$postName."\" id=\"'+{$js_value}+'|".$postName."\" required class=\"form-control\">";
		}
		else
		{
			$render .= "<select name=\"'+{$js_value}+'|".$postName."\" id=\"'+{$js_value}+'|".$postName."\" class=\"form-control\">";
		}
		
		$render .= "<option value=\"\"  >".$dropDefault."</option>";
		foreach($procedure AS $row)
		{		
			$render .= "<option value=\"".$row['id']."\" class=\"form-control\">".$row[$visible_column]."</option>";		
		}		
		$render .= "</select>";				
		return $render;
	}
	function dinamicAdd( $params, $js_value = NULL)
	{	
		if ($js_value == NULL)
		{
			$js_value = "test";
		}

		$id_table_js = $params['id_table'];

		$render = "";
		$ajax = "";
		$codigo = "";
		$render .= "<div class=\"alert alert-info\" role=\"alert\">Has clic en <strong>{$params['add_buttom_text']}</strong> para agregar una nueva fila al formulario.</div>";
		if (array_key_exists('code_bar', $params))
		{
			$render .= "<div class='row'><div class='col-xs-4'><button type=\"button\" class=\"btn btn-success btn-md btn-block\" id=\"add_row{$js_value}\" name=\"add_row{$js_value}\"  value=\"{$params['add_buttom_text']}\"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> ".$params['add_buttom_text']."</button></div>";
			$render .= "<div class='col-xs-4'><input type=\"text\" class=\"form-control\" id=\"cod_barra\" autofocus onkeypress=\"return pulsar(event)\" name=\"cod_barra\" placeholder=\"Ingrese codigo de barra\"></div><div class='col-xs-4'><button type='button' name='b_cod_barra' id='b_cod_barra' class=\"btn btn-warning btn-md btn-block\"  value='Buscar'><span class='glyphicon glyphicon-barcode' aria-hidden='true'></span> Buscar</button> </div></div><br>";
		}
		else
		{
			$render .= "<div class='row'><div class='col-xs-12'><button type=\"button\" class=\"btn btn-success btn-md btn-block\" id=\"add_row{$js_value}\" name=\"add_row{$js_value}\"  value=\"{$params['add_buttom_text']}\"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> ".$params['add_buttom_text']."</button><br></div>";
		}
		
		$render .="<div class='row'>";
		$render .="<div class='col-xs-12'>";
		$ini_table = "<table id=\"{$params['id_table']}\" name=\"{$params['id_table']}\" style=\"border: 0px solid black\">";
		$ini_table .= "</table>";
		$render .= "<table id=\"{$params['id_table']}\" name=\"{$params['id_table']}\" style=\"border: 0px solid black\">";
		$z = "";
		$table = "";
		$code_bar = "";
		$odc = "";
		$table .= "<tr id=\"'+".$js_value."+'{$id_table_js}\">";
		$code_bar .= "<tr id=\"".$js_value."{$id_table_js}\">";
		$table .= "<td>";
		$code_bar .= "<td>";
		$table .= "";
		$code_bar .= "";
		$table .= "</td>";
		$code_bar .= "</td>";
		foreach ($params['columns'] as $name_option => $options)
		{
			//echo $name_option;			
			$table .= "<td>";
			$code_bar .= "<td>";
			if ( $options['type'] == 'DropdownAutocomplete' )
			{
				if (array_key_exists('code_bar', $options))
				{
					if (array_key_exists('data_code_bar', $options))
					{		

						$ajax .= "[";
						foreach ($options['data_code_bar'] as $key => $value)
						{
							$ajax .= "{\"id\":\"".$value['id']."\", \"name\":\"".$value['Descripcion']."\",\"code\":\"".$value['CodigoBarra']."\"},";													
						}
						$ajax .= "];";	


						$code_bar .= "<input type=\"text\" id =\"'+".$js_value."+'|".$options['name']."\" name =\"'+{$js_value}+'|".$options['name']."\" hidden disabled value=\"'+".$js_value."+'\" >";
						$code_bar .= "<input type=\"text\"  class=\"form-control\"   value=\"'+v.name+'\" disabled class=\"fname\" />";
					}
				}
				else
				{
					$code_bar .= $options['data'];
		
				}
				$table .= $options['data'];
				//$code_bar .= $options['data'];
			}
			if ( $options['type'] == 'dropdown' )
			{			
				$table .= $options['data'];
				if (array_key_exists('code_bar', $options))
				{
					if (array_key_exists('data_code_bar', $options))
					{		

						$ajax .= "[";
						foreach ($options['data_code_bar'] as $key => $value)
						{
							$ajax .= "{\"id\":\"".$value['id']."\", \"name\":\"".$value['Descripcion']."\",\"code\":\"".$value['CodigoBarra']."\"},";													
						}
						$ajax .= "];";	


						$code_bar .= "<input type=\"text\" id =\"'+".$js_value."+'|".$options['name']."\" name =\"'+{$js_value}+'|".$options['name']."\" hidden disabled value=\"'+".$js_value."+'\" >";
						$code_bar .= "<input type=\"text\"  class=\"form-control\"   value=\"'+v.name+'\" disabled class=\"fname\" />";
					}
				}
				else
				{
					$code_bar .= $options['data'];
		
				}
								
			}
			if ( $options['type'] == 'text' )
			{		
				if (array_key_exists('value', $options))
				{
					$input_value = $options['value'];
				}
				else
				{
					$input_value = '';
				}	
				if (array_key_exists('required', $options))
				{
					if ($options['required'] == TRUE)
					{
						$required = "required";
					}
					else
					{
						$required = "";
					}
				}
				else
				{
					$required = "";
				}
				if (array_key_exists('placeholder', $options))
				{
					$table .= "<input type=\"text\" ".$required." value=\"{$input_value}\" class=\"form-control\" placeholder=\"".$options['placeholder']."\" id =\"'+".$js_value."+'|".$options['name']."\" name =\"'+".$js_value."+'|".$options['name']."\"  class=\"fname\" />";
					$code_bar .= "<input type=\"text\" ".$required." class=\"form-control\" placeholder=\"".$options['placeholder']."\" id =\"'+".$js_value."+'|".$options['name']."\" name =\"'+".$js_value."+'|".$options['name']."\"  class=\"fname\" />";
				}
				else
				{
					$table .= "<input type=\"text\" ".$required." class=\"form-control\" value=\"{$input_value}\" id =\"'+".$js_value."+'|".$options['name']."\" name =\"'+".$js_value."+'|".$options['name']."\"  class=\"fname\" />";
					$code_bar .= "<input type=\"text\" ".$required." value=\"{$input_value}\" class=\"form-control\" id =\"'+".$js_value."+'|".$options['name']."\" name =\"'+".$js_value."+'|".$options['name']."\"  class=\"fname\" />";
				}
				
			}
			if ( $options['type'] == 'date' )
			{			
				if (array_key_exists('required', $options))
				{
					if ($options['required'] == TRUE)
					{
						$required = "required";
					}
					else
					{
						$required = "";
					}
				}
				else
				{
					$required = "";
				}
				if (array_key_exists('placeholder', $options))
				{
					$table .= "<input type=\"text\" ".$required." class=\"form-control\" placeholder=\"".$options['placeholder']."\" id =\"'+".$js_value."+'-".$options['name']."\" name =\"'+".$js_value."+'&".$options['name']."\"  class=\"fname\" />";
					$code_bar .= "<input type=\"text\" ".$required." class=\"form-control\" placeholder=\"".$options['placeholder']."\" id =\"'+".$js_value."+'-".$options['name']."\" name =\"'+".$js_value."+'&".$options['name']."\"  class=\"fname\" />";
				}
				else
				{
					$table .= "<input type=\"text\" ".$required." class=\"form-control\" id =\"'+".$js_value."+'&".$options['name']."\" name =\"'+".$js_value."+'-".$options['name']."\"  class=\"fname\" />";
					$code_bar .= "<input type=\"text\" ".$required." class=\"form-control\" id =\"'+".$js_value."+'&".$options['name']."\" name =\"'+".$js_value."+'-".$options['name']."\"  class=\"fname\" />";
				}
				
			}
			if (array_key_exists('orden_de_compra', $options))
			{
				$odc .= "<td id =\"'+elementos[0]+'|{$id_table_js}td_fijo\">";
				$odc .= "<input type=\"text\"  disabled=\"true\" class=\"form-control\" id =\"'+elementos[0]+'|fijo\"  name =\"'+elementos[0]+'|fijo\"  value=\"3654\" class=\"fname\" />";
				$odc .= "</td>";
				$odc .= "<td id =\"'+elementos[0]+'|{$id_table_js}td_fijo_1\">";
				$odc .= "<input type=\"text\"  class=\"form-control\" placeholder=\"Numero OC\" id =\"'+elementos[0]+'|fijo_1\" name =\"'+elementos[0]+'|fijo_1\" class=\"fname\" />";
				$odc .= "</td>";
				$odc .= "<td id =\"'+elementos[0]+'|{$id_table_js}td_fijo_2\">";
				$odc .= "<input type=\"text\"  class=\"form-control\" placeholder=\"Tipo Compra \" id =\"'+elementos[0]+'|fijo_2\" name =\"'+elementos[0]+'|fijo_2\" class=\"fname\" />";
				$odc .= "</td>";
				$codigo .= "<td id =\"'+elementos[0]+'|{$id_table_js}td_codigo\">";
				$codigo .= "<input type=\"text\"  required=\"true\" placeholder=\"Codigo del Documento\" class=\"form-control\" id =\"'+elementos[0]+'|codigoOC\" name =\"'+elementos[0]+'|codigoOC\"  class=\"fname\" />";
				$codigo .= "</td>";
				
				$odc .= "<td id =\"'+elementos[0]+'|{$id_table_js}td_fijo_3\">";
				$odc .= "<input type=\"file\"  id =\"'+elementos[0]+'|file\"  name =\"'+elementos[0]+'|file\" class=\"fname\" />";
				$odc .= "</td>";
				$codigo .= "<td id =\"'+elementos[0]+'|{$id_table_js}td_fijo_3\">";
				$codigo .= "<input type=\"file\"  id =\"'+elementos[0]+'|file\"  name =\"'+elementos[0]+'|file\" class=\"fname\" />";
				$codigo .= "</td>";
				
				
			}
			// option date comming soon
			$table .= "</td>";
			$code_bar .= "</td>";
		}
		$table .= "<td id =\"'+".$js_value."+'|{$id_table_js}td_eliminar\">";
		$table .= "<input type=\"button\" id =\"'+".$js_value."+'|{$id_table_js}eliminar\" class =\"btn btn-danger btn-md\" value=\"{$params['del_buttom_text']}\" />";
		$table .= "</td>";
		$eliminar = "";
		$eliminar .= "<td id =\"'+elementos[0]+'|{$id_table_js}td_eliminar\">";
		$eliminar .= "<input type=\"button\" id =\"'+elementos[0]+'|{$id_table_js}eliminar\" class =\"btn btn-danger btn-md\" value=\"{$params['del_buttom_text']}\" />";
		$eliminar .= "</td>";

		$table .= "</tr>";
		$table .= "</table>";

		$code_bar .= "<td>";
		$code_bar .= "<input type=\"button\" class =\"btn btn-danger btn-md\" value=\"{$params['del_buttom_text']}\" />";
		$code_bar .= "</td>";
		$code_bar .= "</tr>";
		$code_bar .= "</table>";
		//

		//javascript

		$script = "<script> 
			var {$js_value}=0;

			$('#{$params['id_table']}').on('click', 'input[type=\"button\"]', function () {
			    $(this).closest('tr').remove();
			    
			})
			
			$('#add_row{$js_value}').click(function()
			{			    

			    {$js_value}++;
			    
			    
			    $('#{$params['id_table']}').append('".$table."');
			    $('#'+{$js_value}+'-'+'{$options['name']}').datetimepicker({format: 'YYYY-MM-DD',locale: 'es',});
			   
			";
		foreach ($params['columns'] as $name_option => $options)
		{
			if ( $options['type'] == 'DropdownAutocomplete' )
			{
	
				
				$script .=  "$('.".$options['name']."').select2();";
				
			}
		}
		$script .= "
			
			});
			function owojs(objeto)
			{

				var tipo_documento = objeto.value;

				var elementos = objeto.id;
				elementos = elementos.split('|');	
				//alert(elementos[0]);
						
				if ( tipo_documento == 9 )
				{
					
					if (document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo') != null )
					{
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo').remove();
				
						
					}
					if (document.getElementById(''+elementos[0]+'|{$id_table_js}eliminar') != null )
					{
						document.getElementById(''+elementos[0]+'|{$id_table_js}eliminar').remove();
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_eliminar').remove();
						
					}
					if (document.getElementById(''+elementos[0]+'|codigoOC') != null )
					{
						document.getElementById(''+elementos[0]+'|codigoOC').remove();
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_codigo').remove();
						
					}

					if (document.getElementById(''+elementos[0]+'|fijo') != null )
					{
						document.getElementById(''+elementos[0]+'|fijo').remove();						
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo').remove();												
					}	
					if (document.getElementById(''+elementos[0]+'|fijo_1') != null )
					{
						document.getElementById(''+elementos[0]+'|fijo_1').remove();						
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo_1').remove();												
					}	
					if (document.getElementById(''+elementos[0]+'|fijo_2') != null )
					{
						document.getElementById(''+elementos[0]+'|fijo_2').remove();	
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo_2').remove();							
					}
					if (document.getElementById(''+elementos[0]+'|file') != null )
					{
						document.getElementById(''+elementos[0]+'|file').remove();	
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo_3').remove();							
					}
					
						$('#'+elementos[0]+'{$id_table_js}').append('".$odc."');
						
					
					if (document.getElementById(''+elementos[0]+'|{$id_table_js}eliminar') == null )
					{
						$('#'+elementos[0]+'{$id_table_js}').append('".$eliminar."');
					}
					else
					{
						document.getElementById(''+elementos[0]+'|{$id_table_js}eliminar').remove();
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_eliminar').remove();
					}
				}
				else
				{	

					if (document.getElementById(''+elementos[0]+'|{$id_table_js}eliminar') != null )
					{

						document.getElementById(''+elementos[0]+'|{$id_table_js}eliminar').remove();
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_eliminar').remove();
						//alert('paso');
					}				
					//check input fijo
					if (document.getElementById(''+elementos[0]+'|fijo') != null )
					{
						document.getElementById(''+elementos[0]+'|fijo').remove();
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo').remove();								
					}
					if (document.getElementById(''+elementos[0]+'|fijo_1') != null )
					{
						document.getElementById(''+elementos[0]+'|fijo_1').remove();	
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo_1').remove();							
					}
					if (document.getElementById(''+elementos[0]+'|fijo_2') != null )
					{
						document.getElementById(''+elementos[0]+'|fijo_2').remove();	
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo_2').remove();							
					}
					if (document.getElementById(''+elementos[0]+'|file') != null )
					{
						document.getElementById(''+elementos[0]+'|file').remove();	
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_fijo_3').remove();							
					}
					
					//check onput codigo
					if (document.getElementById(''+elementos[0]+'|codigoOC') != null )
					{
						document.getElementById(''+elementos[0]+'|codigoOC').remove();
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_codigo').remove();											
					}
					
					
					$('#'+elementos[0]+'{$id_table_js}').append('".$codigo."');	
					
					
					if (document.getElementById(''+elementos[0]+'|{$id_table_js}eliminar') == null )
					{
						$('#'+elementos[0]+'{$id_table_js}').append('".$eliminar."');
					}
					else
					{
						document.getElementById(''+elementos[0]+'|{$id_table_js}eliminar').remove();
						document.getElementById(''+elementos[0]+'|{$id_table_js}td_eliminar').remove();
					}
					

					

				}
			}
			";
		if ($ajax != "")
		{

			$script .="
			function pulsar(e) {
				tecla = (document.all) ? e.KeyCode : e.which;
				return (tecla!=13);
			}
			$('#b_cod_barra').click(function()
			{	
				var flag = 0;
				var input = $('#cod_barra').val();	    
				var productos = ".$ajax.";
				$.each(productos,function(i, v){
			            if (v.code == input)
			            {
			            	{$js_value}++;
			            	flag = 1;
			                $('#{$params['id_table']}').append('".$code_bar."');
			                document.getElementById('cod_barra').value = '';
			                document.getElementById('cod_barra').focus();
			            }            
			        });
			    if (flag == 0)
			    {
			        alert(\"El codigo que acaba de utilizar no se encuentra ingresado en el sistema.\");
			        document.getElementById('cod_barra').value = '';
			        document.getElementById('cod_barra').focus();
			        return false;
			    }
			});
			function pulsar(e) {
				tecla = (document.all) ? e.KeyCode : e.which;
				return (tecla!=13);
			}
			$('#cod_barra').keydown(function(event)
			{
				var flag = 0;
				var input = $('#cod_barra').val();
		        var productos = ".$ajax.";
		        if (event.which == 13)
		        {
			        $.each(productos,function(i, v){
			            if (v.code == input)
			            {
			            	{$js_value}++;
			            	flag = 1;
			                $('#{$params['id_table']}').append('".$code_bar."');
			                document.getElementById('cod_barra').value = '';
			                document.getElementById('cod_barra').focus();
			            }            
			        });
			        if (flag == 0)
			        {
			        	
			        	document.getElementById('cod_barra').value = '';
			        	document.getElementById('cod_barra').focus();
			        	
			        }
			        
		    	}
		    			        
		    }); ";

			$script .="</script> ";
		}
		else
		{
			$script .= "</script>"; 
		}
		
		$render .= $ini_table;		
		$render .= $script;
		$render .= "<br>";
		if ( !array_key_exists('hide_buttons',$params) )
		{
			$render .= "<hr>";
			$render .= "<div class='row'>
				<a href='".site_url($this->uri->segment(1))."'><div class='col-xs-6'><button type=\"button\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-caret-square-o-left fa-lg\" aria-hidden=\"true\"></i> Volver</button></a></div>
				<div class='col-xs-6'><button type=\"submit\" class=\"btn btn-danger btn-block\"><i class=\"fa fa-floppy-o fa-lg\" aria-hidden=\"true\"></i> Grabar</button></div></div>";
					
		}
		

		return $render;
		
	}
	public function generateMultiSelectAutoComplete( $options )
	{

		$js_value = "";
		$render = "";
		//required
		if( array_key_exists('required', $options) )
		{
			if( $options['required'] == TRUE )
			{
				$render .= "<select required class=\"".$options['post_name']." form-control\" id=\"".$options['post_name']."\" name =\"".$options['post_name']."[]\"  multiple=\"multiple\">";
			}
			else
			{
				$render .= "<select class=\"".$options['post_name']." form-control\" id=\"".$options['post_name']."\" name =\"".$options['post_name']."[]\" multiple=\"multiple\" >";
			}
		}
		else
		{
			$render .= "<select class=\"".$options['post_name']." form-control\" id=\"".$options['post_name']."\" name =\"".$options['post_name']."[]\" multiple=\"multiple\">";
		}
		//placeholder
		if ( array_key_exists('placeholder', $options) )
		{
			$render .= "<option value=\"\"  >".$options['placeholder']."</option>";
		}	
		if ( array_key_exists('selected', $options ) )
		{
			if ( is_array($options['selected']) )
			{
				//la data es un array
				foreach( $options['data'] AS $row )
				{		
					if ( in_array($row['id'], $options['selected']) )
					{
						$render .= "<option selected value=\"".$row['id']."\">".$row[$options['visible_column']]."</option>";		
					}
					else
					{
						$render .= "<option value=\"".$row['id']."\">".$row[$options['visible_column']]."</option>";		
					}				
				}		
			}
			else
			{
				//la data es un valor unico
				foreach( $options['data'] AS $row )
				{		
					if ( $row['id'] == $options['selected'] )
					{
						$render .= "<option selected value=\"".$row['id']."\">".$row[$options['visible_column']]."</option>";		
					}
					else
					{
						$render .= "<option value=\"".$row['id']."\">".$row[$options['visible_column']]."</option>";		
					}				
				}		
			}
			
		}
		else
		{
			foreach($options['data'] AS $row)
			{		
				$render .= "<option value=\"".$row['id']."\">".$row[$options['visible_column']]."</option>";		
			}		
		}
		$render .= "</select>";	
		//js
		$render .= "<script>
			            $(document).ready(function()
			            {
			                $('#".$options['post_name']."').select2();
			            });         
			        </script>";	
		return $render;
	}
	public function generateDropDownAutoCompleteForJs($data, $placeholder=NULL,$visible_column,$postName,$selected = NULL, $required = FALSE, $js_value=NULL)
	{	
		if ($js_value == NULL)
		{

			$js_value = "test";
		}
		$render = "";	
		if ( $required == TRUE )
		{
			$render .= "<select required class=\"".$postName." form-control\" id=\"'+{$js_value}+'|".$postName."\" name =\"'+{$js_value}+'|".$postName."\">";
					
		}
		else
		{

			$render .= "<select class=\"".$postName."\" id=\"'+{$js_value}+'|".$postName."\" name =\"'+{$js_value}+'|".$postName."\">";
		}
		if ( $placeholder != NULL )
			{
				$render .= "<option value=\"\"  >".$placeholder."</option>";
			}	
		if ( $selected != NULL )
		{

			foreach($data AS $row)
			{		
				if ($row['id'] == $selected)
				{
					$render .= "<option selected value=\"".$row['id']."\">".$row[$visible_column]."</option>";		
				}
				else
				{
					$render .= "<option value=\"".$row['id']."\">".$row[$visible_column]."</option>";		
				}				
			}		
		}
		else
		{
			foreach($data AS $row)
			{		
				$render .= "<option value=\"".$row['id']."\">".$row[$visible_column]."</option>";		
			}		
		}
		$render .= "</select>";	
		
		
		//$render .= "<script>";
		/*
		$render .=	"            $(document).ready(function()";

		$render .= "     {";
		$render .= "$('.+{$js_value}+'|'+'{$postName}'+').select2()";
		$render .= "       });   ";
		*/
		//$render .= " </script>";			
		
		return $render;
	}
	public function generateDropDownAutoComplete($data, $placeholder=NULL,$visible_column,$postName,$selected = NULL, $required = FALSE, $on_submit = FALSE, $readonly=NULL)
	{	
		$level='';
		$flag=1;
		if ( $readonly != NULL )
		{
			$readonly = " readonly=true ";
		}
		else
		{
			$readonly = "";
		}
		$render = "";
		if ( $required == TRUE )
		{
			if ( $on_submit === TRUE )
			{				
				$on_submit = " onchange=\"this.form.submit()\" ";
			}
			else
			{
				$on_submit = "";
			}
			$render .= "<select required {$readonly} {$on_submit} class=\"".$postName."  form-control\" id=\"".$postName."\" name =\"".$postName."\" style=\"width: 80;\" >";					
		}
		else
		{

			$render .= "<select {$on_submit} {$readonly} class=\"".$postName." form-control\"  id=\"".$postName."\" name =\"".$postName."\">";
		}
		if ( $placeholder != NULL )
			{ 
				$render .= "<option value=\"\"  >".$placeholder."</option>";
			}	
		if ( $selected != NULL )
		{
			foreach($data AS $row)
			{		
				if(array_key_exists('level',$row))
				{
					$flag=1;
					if($level == '')
					{
						$level = $row['level'];
						$render .= "<optgroup label='".$row['level']."'>";
					}
					else if($level != $row['level'])
					{
						$level = $row['level'];
						$render .= "</optgroup><optgroup label='".$row['level']."'>";
					}
					if ($row['id'] == $selected)
					{
						$render .= "<option selected value=\"".$row['id']."\">".$row[$visible_column]."</option>";		
					}
					else
					{
						$render .= "<option value=\"".$row['id']."\">".$row[$visible_column]."</option>";		
					}		

				}
				else
				{
					if ($row['id'] == $selected)
					{
						$render .= "<option selected value=\"".$row['id']."\">".$row[$visible_column]."</option>";		
					}
					else
					{
						$render .= "<option value=\"".$row['id']."\">".$row[$visible_column]."</option>";		
					}		
				}						
			}		
		}
		else
		{
			foreach($data AS $row)
			{		
				if(array_key_exists('level',$row))
				{
					$flag=1;
					if($level == '')
					{
						$level = $row['level'];
						$render .= "<optgroup label='".$row['level']."'>";
					}
					else if($level != $row['level'])
					{
						$level = $row['level'];
						$render .= "</optgroup><optgroup label='".$row['level']."'>";
					}
					$render .= "<option value=\"".$row['id']."\">".$row[$visible_column]."</option>";
				}
				else
				{
					$render .= "<option value=\"".$row['id']."\">".$row[$visible_column]."</option>";			
				}
				
			}		
		}
		if($flag == 1)
		{
			$render .= "</optgroup>";
		}	
		$render .= "</select>";	
		
		$render .= "<script>
			            $(document).ready(function()
			            {
			                $('#".$postName."').select2();
			            });         
			        </script>";	
	
		return $render;
	}
	public function formValidation()
	{
		$validation_response = array();
		$array_validations = unserialize($this->input->post('FORM_VALIDATION'));
		//$this->print_array( $array_validations );
		$validation_message = "Se han detectado los siguientes errores en el formulario:<br><br><ul style='list-style-type:square'>";
		foreach ( $array_validations as $key => $value )
		{
			if( array_key_exists('condition', $value) )
			{
				switch ($value['condition']['operator'])
				{
					case 'unique':
						foreach ($value['condition']['conditions'] as  $column_name => $value_condition)
						{
							$value['condition']['conditions'][$column_name] = $this->input->post($value_condition);
						}
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						$response_data = $this->exist_data($value['condition']['table_name'], $value['condition']['conditions'], $value['condition']['conection']);
						//echo $response_data;exit(0);
						if( $response_data === TRUE )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case '=':	
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message'];	
						if( $this->input->post($key) == $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case '<':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( $this->input->post($key) < $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case '>':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( $this->input->post($key) > $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case '<=':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( $this->input->post($key) <= $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case '>=':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( $this->input->post($key) >= $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case '!=':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( $this->input->post($key) != $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case 'count =':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( count($this->input->post($key)) == $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case 'count !=':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( count($this->input->post($key)) != $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case 'count >':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( count($this->input->post($key)) > $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case 'count <':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( count($this->input->post($key)) < $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case 'count <=':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( count($this->input->post($key)) <= $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;

					case 'count >=':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( count($this->input->post($key)) >= $value['condition']['value'] )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;		

					case 'is true':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( $value['condition']['value'] === TRUE )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;			
					case 'is integer':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message'];	
						if( is_numeric($this->input->post($key)) )
						{
							$validation_response[$key]['valid'] = 1;
						}
						else
						{
							$validation_response[$key]['valid'] = 0;
						}						
					break;
					case 'is false':
						$validation_response[$key]['value'] = $this->input->post($value_condition);
						$validation_response[$key]['type_message'] = $value['type_message'];	
						$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message']	;	
						if( $value['condition']['value'] === FALSE )
						{
							$validation_response[$key]['valid'] = 1; 
						}
						else
						{
							$validation_response[$key]['valid'] = 0; 
						}
					break;				
				}
			}
			if( array_key_exists('type', $value) )
			{
				if( $value['type'] == 'integer' )
				{
					$validation_response[$key]['value'] = $this->input->post($value_condition);
					$validation_response[$key]['type_message'] = $value['type_message'];	
					$validation_response[$key]['message'] = "<i class='fa fa-exclamation-circle' aria-hidden='true'></i> ".$value['message'];	
					
					if( is_numeric($this->input->post($key)) )
					{
						$validation_response[$key]['valid'] = 1;
					}
					else
					{
						$validation_response[$key]['valid'] = 0;
					}
				}
			}			
			
			if( $validation_response[$key]['valid'] == 0 )
			{
				$validation_message .= "<li>".$value['message']."</li>";	
			}
			
		}
		//$this->print_array( $validation_response );
		$validation_message .= "</ul>";
		$this->flash_message('message_form','danger','fa fa-exclamation-triangle fa-lg', $validation_message);
		$this->session->set_flashdata('VALIDATION_RESPONSE', $validation_response);

	}
	public function renderForm($form, $disable_actions=TRUE)
	{ 
		$render = "";		
		
		foreach ( $form as $type=>$options )
		{
			$options_render = array();
			if ( array_key_exists('validation', $options) )
			{
				$options_render = $options;
				unset($options_render['validation']);
				$options_render = $options_render;
				$options_render['id'] = $type;
				$options_render['name'] = $type;
				$options_render['class'] = 'form-control';
				//construccion de array para la validacion
				if( array_key_exists('condition', $options['validation']) )
				{
					$FORM_VALIDATION[$type] = array(
						'type' => $options['validation']['type'],
						'condition' => $options['validation']['condition'],
						'type_message' => $options['validation']['type_message'],
						'message'	=> $options['validation']['message'],
						);
				}
				else
				{
						$FORM_VALIDATION[$type] = array(
						'type' => $options['validation']['type'],
						'type_message' => $options['validation']['type_message'],
						'message'	=> $options['validation']['message'],
						);
				}
				
			}
			else
			{
				$options['id'] = $type;
				$options['name'] = $type;
				$options['class'] = 'form-control';	
				$options_render = $options;
			}
			
			
				
			if ( $options['type'] == 'dropdown' )
			{	
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				if ( array_key_exists('required', $options) )
				{
					if ( $options['required'] == TRUE)
					{
						$render .= $this->generateDropDown( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'], TRUE );
					}
					else
					{
						$render .= $this->generateDropDown( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'] );	
					}
				}
				else
				{
					$render .= $this->generateDropDown( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'] );	
				}
				
				$render .= "</div>";
				$render .= "</div>";	
				$render .= "<br>";				
			}
			if ( $options['type'] == 'dropdownSelected' )
			{	
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= $this->generateDropDownSelected( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'], $options['selected'] );
				$render .= "</div>";
				$render .= "</div>";	
				$render .= "<br>";				
			}
			if ( $options['type'] == 'multiSelectAutoComplete' )
			{
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= $this->generateMultiSelectAutoComplete( $options['options'] );
				$render .= "</div>";
				$render .= "</div>";	
				$render .= "<br>";		
			}
			if ( $options['type'] == 'dropdownAutoComplete' )
			{	

				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				if ( array_key_exists('readonly', $options) )
				{
					$readonly = TRUE;
				}
				else
				{
					$readonly = NULL;
				}
				if ( array_key_exists('selected', $options) )
				{
					
					if ( array_key_exists('required', $options) )
					{
						if ( array_key_exists('on_submit', $options) )
						{

							$render .= $this->generateDropDownAutoComplete( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'], $options['selected'], TRUE, $options['on_submit'], $readonly);
						}
						else
						{

							$render .= $this->generateDropDownAutoComplete( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'], $options['selected'], TRUE, FALSE, $readonly);
						}						
					}
					else
					{

						if ( array_key_exists('on_submit', $options) )
						{
							$render .= $this->generateDropDownAutoComplete( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'], $options['selected'], FALSE, $options['on_submit']);
						}
						else
						{
							$render .= $this->generateDropDownAutoComplete( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'], $options['selected'] );
						}						
					}
				}
				else
				{
					if ( array_key_exists('required', $options) )
					{
						if ( array_key_exists('on_submit', $options) )
						{
							$render .= $this->generateDropDownAutoComplete( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'],NULL,TRUE, TRUE );
						}
						else
						{
							$render .= $this->generateDropDownAutoComplete( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'],NULL,TRUE );
						}						
					}
					else
					{
						if ( array_key_exists('on_submit', $options) )
						{
							$render .= $this->generateDropDownAutoComplete( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'],NULL,FALSE, TRUE);
						}
						else
						{
							$render .= $this->generateDropDownAutoComplete( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'],NULL,FALSE );
						}
						
					}
				}
				
				$render .= "</div>";
				$render .= "</div>";	
				$render .= "<br>";				
			}
			if ( $options['type'] == 'dropInput' )
			{	
				$inputOptions = array(
						'name' => $options['name'],
						'id'	=> $options['id'],
						'class'  => 'form-control',
						'required' => TRUE,
						'placeholder'	=> $options['placeholder']
						);
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8' style='display:flex; flex-direction:row;'>";
				$render .= "".$this->generateDropDown( $options['data'], $options['placeholder'], $options['visible_column'], $options['post_name'])."".form_input( $inputOptions )."";
				$render .= "</div>";
				$render .= "</div>";	
				$render .= "<br>";				
			}
			if ( $options['type'] == 'textarea' )	
			{
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				if ( $this->session->flashdata('VALIDATION_RESPONSE') )
				{
					if ( array_key_exists( $options_render['id'], $this->session->flashdata('VALIDATION_RESPONSE')) )
					{
						if( $this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['valid'] == 0 )
						{
							$render .= "<div class='col-xs-8 has-".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['type_message']."'>";
							$render .= "<span id= \"msj".$options_render['id']."\" class=\"help-block\">".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['message']."</span>";
							$options_render['aria-describedby'] = "msj".$options_render['id'];
						}
						else
						{
							$render .= "<div class='col-xs-8'>";
						}

					}
					else
					{
						$render .= "<div class='col-xs-8'>";
					}
				}
				else
				{
					$render .= "<div class='col-xs-8'>";
				}
				
				$render .= $this->makeTextArea( $options_render );
				$render .= "</div>";
				$render .= "</div>";	
				$render .= "<br>";
			}
			if ( $options['type'] == 'date' )	
			{
				
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options_render['label'];
				$render .= "</div>";
				if ( $this->session->flashdata('VALIDATION_RESPONSE') )
				{
					if ( array_key_exists( $options_render['id'], $this->session->flashdata('VALIDATION_RESPONSE')) )
					{
						if( $this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['valid'] == 0 )
						{
							$render .= "<div class='col-xs-8 has-".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['type_message']."'>";
							$render .= "<span id= \"msj".$options_render['id']."\" class=\"help-block\">".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['message']."</span>";
							$options_render['aria-describedby'] = "msj".$options_render['id'];
						}
						else
						{
							$render .= "<div class='col-xs-8'>";	
						}
					}
					else
					{
						$render .= "<div class='col-xs-8'>";	
					}
				}
				else
				{
					$render .= "<div class='col-xs-8'>";	
				}				
				$render .= "<div class=\"input-group date\" id=\"".$options_render['id']."\">";
				if( !isset($options_render['value']) )
				{
					$options_render['value'] = "";
				}
				if (array_key_exists('required', $options_render))
				{
					$render .= "<input required=\"1\" value=\"".$options_render['value']."\" name=\"".$options_render['name']."\" data-owo=\"date\" type=\"text\" class=\"form-control\" placeholder=\"".$options_render['placeholder']."\" id=\"".$options_render['id']."\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span></div>";	
				}
				else
				{
					$render .= "<input name=\"".$options_render['name']."\" value=\"".$options_render['value']."\" type=\"text\" data-owo=\"date\" class=\"form-control\" placeholder=\"".$options_render['placeholder']."\" id=\"".$options_render['id']."\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span></div>";	
				}
				
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";	
				$render .= "<script>$(function(){
					$('#".$options_render['id']."').datetimepicker({
						 format: 'YYYY-MM-DD',
						 locale: 'es',";
				if( array_key_exists('js_options', $options_render) )
				{
					foreach ($options_render['js_options'] as $key => $value)
					{
						$render .= $key.": ".$value.","	;
					}
				}				
				$render .= "});})	</script>";

			}
			if ( $options['type'] == 'dateSelected' )	
			{
				
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= "<div class=\"input-group date\" id=\"".$options['id']."\">";
				$render .= "<input name=\"".$options['name']."\" type=\"text\" class=\"form-control\" placeholder=\"".$options['placeholder']."\" id=\"".$options['id']."\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span></div>";
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";	
				$render .= "<script>$(function(){
					$('#".$options['id']."').datetimepicker({format: 'YYYY-MM-DD', locale: 'es',defaultDate:'".$options['date']."'});})	</script>";

			}
			if ( $options['type'] == 'datetime' )	
			{
				
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				if ( $this->session->flashdata('VALIDATION_RESPONSE') )
				{
					if ( array_key_exists( $options_render['id'], $this->session->flashdata('VALIDATION_RESPONSE')) )
					{
						if( $this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['valid'] == 0 )
						{
							$render .= "<div class='col-xs-8 has-".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['type_message']."'>";
							$render .= "<span id= \"msj".$options_render['id']."\" class=\"help-block\">".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['message']."</span>";
							$options_render['aria-describedby'] = "msj".$options_render['id'];
						}
						else
						{
							$render .= "<div class='col-xs-8'>";	
						}
					}
					else
					{
						$render .= "<div class='col-xs-8'>";	
					}
				}
				else
				{
					$render .= "<div class='col-xs-8'>";	
				}
				$render .= "<div class=\"input-group date\" id=\"".$options_render['id']."\">";
				$render .= "<input name=\"".$options_render['name']."\" type=\"text\" class=\"form-control\" placeholder=\"".$options_render['placeholder']."\" id=\"".$options_render['id']."\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span></div>";
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";	
				$render .= "<script>$(function(){
					$('#".$options_render['id']."').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss',locale: 'es'});})	</script>";

			}
			if ( $options['type'] == 'datetimeSelected' )	
			{
				
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= "<div class=\"input-group date\" id=\"".$options['id']."\">";
				$render .= "<input name=\"".$options['name']."\" type=\"text\" class=\"form-control\" placeholder=\"".$options['placeholder']."\" id=\"".$options['id']."\"><span class=\"input-group-addon\"><i class=\"glyphicon glyphicon-calendar\"></i></span></div>";
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";	
				$render .= "<script>$(function(){
					$('#".$options['id']."').datetimepicker({format: 'YYYY-MM-DD HH:mm:ss', locale: 'es', defaultDate:'".$options['date']."'});})	</script>";

			}
			if ( $options['type'] == 'password' )	
			{
				$options_render['type'] = "password";
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				if ( $this->session->flashdata('VALIDATION_RESPONSE') )
				{
					
					if ( array_key_exists( $options_render['id'], $this->session->flashdata('VALIDATION_RESPONSE')) )
					{
						//print_r($this->session->flashdata('VALIDATION_RESPONSE'));
						if( $this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['valid'] == 0 )
						{
							$render .= "<div class='col-xs-8 has-".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['type_message']."'>";
							$render .= "<span id= \"msj".$options_render['id']."\" class=\"help-block\">".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['message']."</span>";
							$options_render['aria-describedby'] = "msj".$options_render['id'];
						}	
						else
						{
							$render .= "<div class='col-xs-8'>";	
						}				
					}
					else
					{
						$render .= "<div class='col-xs-8'>";	
					}				
				}
				else
				{
					$render .= "<div class='col-xs-8'>";
				}				
				$render .= form_input( $options_render );
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";			
			}
			if ( $options['type'] == 'input' )	
			{
				
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				if ( $this->session->flashdata('VALIDATION_RESPONSE') )
				{
					
					if ( array_key_exists( $options_render['id'], $this->session->flashdata('VALIDATION_RESPONSE')) )
					{
						//print_r($this->session->flashdata('VALIDATION_RESPONSE'));
						if( $this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['valid'] == 0 )
						{
							$render .= "<div class='col-xs-8 has-".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['type_message']."'>";
							$render .= "<span id= \"msj".$options_render['id']."\" class=\"help-block\">".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['message']."</span>";
							$options_render['aria-describedby'] = "msj".$options_render['id'];
						}	
						else
						{
							$render .= "<div class='col-xs-8'>";	
						}				
					}
					else
					{
						$render .= "<div class='col-xs-8'>";	
					}				
				}
				else
				{
					$render .= "<div class='col-xs-8'>";
				}				
				$render .= form_input( $options_render );
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";			
			}
			if ( $options['type'] == 'email' )	
			{
				
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				if ( $this->session->flashdata('VALIDATION_RESPONSE') )
				{
					
					if ( array_key_exists( $options_render['id'], $this->session->flashdata('VALIDATION_RESPONSE')) )
					{
						//print_r($this->session->flashdata('VALIDATION_RESPONSE'));
						if( $this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['valid'] == 0 )
						{
							$render .= "<div class='col-xs-8 has-".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['type_message']."'>";
							$render .= "<span id= \"msj".$options_render['id']."\" class=\"help-block\">".$this->session->flashdata('VALIDATION_RESPONSE')[$options_render['id']]['message']."</span>";
							$options_render['aria-describedby'] = "msj".$options_render['id'];
						}	
						else
						{
							$render .= "<div class='col-xs-8'>";	
						}				
					}
					else
					{
						$render .= "<div class='col-xs-8'>";	
					}				
				}
				else
				{
					$render .= "<div class='col-xs-8'>";
				}				
				$render .= form_input( $options_render );
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";			
			}
			if ( $options['type'] == 'number' )	
			{
				
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= form_input( $options );
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";			
			}
			if ( $options['type'] == 'hidden' )	
			{				
				$options['type'] = "hidden";											
				$render .= form_input( $options );	
			}
			if ( $options['type'] == 'spanInput' )	
			{
				
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= "<div class='input-group'>";
				$render .= "<span class='input-group-addon'>".$options['addon']."</span>";
				$render .= form_input( $options );
				$render .= "</div>";
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";			
			}
			
			if ( $options['type'] == 'file' )	
			{
				
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= form_upload( $options );
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";			
			}
			
			if($options['type'] == 'binaryYesNo')
			{
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= "<p>".$options['label']."</p>";
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= "<select name='".$options['name']."' id='".$options['id']."' class='form-control'>";						
				$render .= "<option  value='1'>Sí</option>";
				$render .= "<option  value='0'>No</option>";					
				$render .= "</select>";
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";
			}
			if($options['type'] == 'binaryYesNoSelected')
			{
				$ddList = array(
								0	=>	'No',
								1	=>	'Sí'
							);
				$detalles='id="'.$options['id'].'" class="form-control"';
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= "<p>".$options['label']."</p>";
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= form_dropdown($options['name'],$ddList,$options['selected'],$detalles);
				$render .= "</div>";
				$render .= "</div>";
				$render .= "<br>";
			}
			if ( $options['type'] == 'checkbox' )	
			{
				$options['style'] ='height:20px';
				$render .= "<div class='row'>";
				$render .= "<div class='col-xs-4'>";
				$render .= $options['label'];
				$render .= "</div>";
				$render .= "<div class='col-xs-8'>";
				$render .= form_checkbox($options);
				$render .= "</div>";
				$render .= "</div>";	
				$render .= "<br>";
			}
			unset($options_render);
		}
		//$this->print_array($FORM_VALIDATION);
		
		if ($disable_actions == FALSE)
		{

		}
		else
		{
			$render .= "<hr>";
			$render .= "<div class='row'>
		<a href='".site_url($this->uri->segment(1))."'><div class='col-xs-6'><button type=\"button\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-caret-square-o-left fa-lg\" aria-hidden=\"true\"></i> Volver</button></a></div>
		<div class='col-xs-6'><button type=\"submit\" class=\"btn btn-danger btn-block\"><i class=\"fa fa-floppy-o fa-lg\" aria-hidden=\"true\"></i> Grabar</button></div></div>";
			//print_r($FORM_VALIDATION);
			if ( array_key_exists('validation', $options) )
			{
				$render .= form_input( array(
									'id'	=>	'FORM_VALIDATION',
									'name'	=>	'FORM_VALIDATION',
									'type'	=>	'hidden',
									'value'	=>	serialize($FORM_VALIDATION),
									)
								 );
			}
		}		
		return $render;		
	}
	public function getNameProfile( $id )
	{
		return $this->db->query('select name from profile where id='.$id.' ')->result_array();
	}
	public function renderProfile( $id )
	{
		$render = "";
		$classes = $this->db->query('select id, name from class order by id')->result_array();
		$methods = $this->db->query('select id, name from METHOD order by id')->result_array();
		$privileges = $this->getPrivileges($id);
		$render .= "<input type='hidden' id='profile' name='profile' value='".$id."'>"; 
		$render .= "<div class=\"panbel panel default\">";
		$render .= "<table class=\"table table-striped table-bordered table-hover\">";

		$render .= "<thead><tr>";
		$render .= "<th class='col-xs-6'><center>SITIO</center></th>";
		$cont = 0;
		$checked = "";
		foreach ( $methods as $method )
		{
			$render .= "<th class='col-xs-1'><center>".$method['name']."</th></center>";
		}
		$render .= "</tr></thead>";
		$render .= "<tbody>";
		$render .= "<tr>";
		
		foreach ($classes as $class)
		{
			$render .= "<tr>";
			$render .= "<th>".$class['name']."</th>";
			foreach ($methods as $method)
			{ 
				
				foreach ($privileges as $privilege)
				{			
					//print_r($privilege);
					//echo $privilege['class_name']." == ".$class['name']." AND ".$privilege['method_name']." == ".$method['name']."<br>";		
					if( $privilege['class_name'] == $class['name'] AND  $privilege['method_name'] == $method['name'] )
					{
						//echo "encontro la clase ".$class['class']." y el metodo ".$method['method']."<br>";
						
						$checked = "checked";
					}					
				}
				$cont++;
				$render .= "<th><center><input type='checkbox' name='".$class['id']."|".$method['id']."' id='".$class['id']."|".$method['id']."' name='".$cont."' value='1' $checked></center></th>";
				$checked = "";
			}
			$render .= "</tr>";
		}
		$render .= "</tr>";
		$render .= "</tbody>";
		$render .= "</table></div>";
		return $render;
	}
	public function getPrivileges( $id )
	{
		return  $this->db->query('
				select
					c.id class
					,c.name class_name
					,m.id method
					,m.name method_name
				from ACCESS_CONTROL ac
					inner join class c on c.id=ac.fk_class
					inner join method m on m.id=ac.fk_method
				where
					ac.fk_profile='.$id.'
					and access = 1
				order by m.id, c.id
				')->result_array();		

	}
	public function deleteProfile( $id )
	{
		$this->db->query('delete from access_control where fk_profile ='.$id.'');
	}

}





?>