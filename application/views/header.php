<!DOCTYPE html>
<html lang="es">
<head>
	<title>VITAMINA ZAPATOS</title>
	<meta  charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="sistema de existencias">
	<meta name="author" content="SIC-IDIC">	

    
	<link href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url("assets/bootstrap/css/bootstrap-datetimepicker.min.css"); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url("assets/bootstrap/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/images/logo.jpg"); ?>" />
    <script src="<?php echo base_url("assets/bootstrap/js/jquery-3.1.1.min.js"); ?>"></script>
    <script src="<?php echo base_url("assets/bootstrap/js/moment.js"); ?>"></script>
    <script src="<?php echo base_url("assets/bootstrap/js/bootstrap-datetimepicker.min.js"); ?>"></script>

	<script src="<?php echo base_url("assets/bootstrap/js/dataTables.min.js"); ?>"></script>   
    <script src="<?php echo base_url("assets/bootstrap/js/dataTables.autoFill.min.js"); ?>"></script>
    <link href="<?php echo base_url("assets/bootstrap/css/dataTables.min.css"); ?>" rel="stylesheet" type="text/css" /> 
    <link href="<?php echo base_url("assets/bootstrap/css/toastr.min.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("assets/bootstrap/css/animate.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("assets/bootstrap/css/style.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("assets/bootstrap/css/select2.min.css"); ?>" rel="stylesheet" type="text/css" >
    <script src="<?php echo base_url("assets/bootstrap/js/toastr.min.js"); ?>"></script>
    
</head>

<div id="wrapper">

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu" style="">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?php echo base_url("/assets/images/creator.jpg"); ?>" style="width: 60px; height: 60px;">
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $this->session->usuario['nombre'].' '.$this->session->usuario['paterno'].' '.$this->session->usuario['materno']; ?></strong>
                             </span> <span class="text-muted text-xs block"><?php echo $this->session->usuario['nivel']; ?> <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element" align="center">
                    <img alt="image" class="img-circle" src="<?php echo base_url("/assets/images/logo.jpg"); ?>" style="width: 50px; height: 50px;">
                </div>
            </li>
             <li class="active">
                <a href="<?php echo site_url("inicio");?>"><i class="fa fa-diamond"></i> <span class="nav-label">Inicio</span></a>
            </li>
            
            <li>
                <a href="<?php echo site_url("recetas");?>"><i class="fa fa-cubes"></i> <span class="nav-label">Recetas</span></a>
            </li>
             <li>
                <a href="<?php echo site_url("compras");?>"><i class="fa fa-shopping-basket"></i> <span class="nav-label">Comprar</span></a>
            </li>
            <li>
                <a href="<?php echo site_url("ventas");?>"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Vender</span></a>
            </li>
            <li>
                <a href="<?php echo site_url("indicadores");?>"><i class="fa fa-pie-chart"></i> <span class="nav-label">Indicadores</span>  </a>
            </li>
             
            <li>
                <a href="<?php echo site_url("notificaciones");?>"><i class="fa fa-bell"></i> <span class="nav-label">Notificaciones </span><span class="label label-info pull-right">8</span></a>
            </li>
            <li class="">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">Mantenedores </span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse" style="height: 0px;">
                    <li><a href="<?php echo site_url("productos");?>">Productos</a></li>
                    <li><a href="<?php echo site_url("tipoproducto"); ?>">Tipos de Producto</a></li>
                    <li><a href="<?php echo site_url("bodegas"); ?>">Bodegas</a></li>
                    <li><a href="<?php echo site_url("marcas"); ?>">Marcas</a></li>
                    <li><a href="<?php echo site_url("usuarios"); ?>">Usuarios</a></li>
                    <li><a href="graph_rickshaw.html">Perfiles</a></li>
                    <li><a href="graph_chartjs.html">Chart.js</a></li>
                    <li><a href="graph_chartist.html">Chartist</a></li>
                    <li><a href="c3.html">c3 charts</a></li>
                    <li><a href="graph_peity.html">Peity Charts</a></li>
                    <li><a href="graph_sparkline.html">Sparkline Charts</a></li>
                </ul>
            </li>
            
        </ul>

    </div>
</nav>
<div id="page-wrapper" class="gray-bg" style="min-height: 664px;">
<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="Busar Elemento..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <span class="m-r-sm text-muted welcome-message">Sistema de Administración</span>
            </li>
            
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <a href="mailbox.html">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="profile.html">
                            <div>
                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                <span class="pull-right text-muted small">12 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="grid_options.html">
                            <div>
                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                <span class="pull-right text-muted small">4 minutes ago</span>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="text-center link-block">
                            <a href="notifications.html">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>


            <li>
                <a href="<?php echo site_url("login"); ?>">
                    <i class="fa fa-sign-out"></i> Desconectar
                </a>
            </li>
        </ul>

    </nav>
</div>


<!-- CONTENIDO-->
<div class="wrapper wrapper-content animated fadeInRight">
            