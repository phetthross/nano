<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>CONTROL DE STOCK</title>
	<link href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
        <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<link href="<?php echo base_url("assets/bootstrap/css/font-awesome.min.css"); ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/images/logo.jpg"); ?>" />
    <script src="<?php echo base_url("assets/bootstrap/js/jquery-3.1.1.min.js"); ?>"></script>

    <script src="<?php echo base_url("assets/bootstrap/js/dataTables.bootstrap.min.js"); ?>"></script>  
    <link href="<?php echo base_url("assets/bootstrap/css/animate.css"); ?>" rel="stylesheet" type="text/css" />
     
    <script src="<?php echo base_url("assets/bootstrap/js/toastr.min.js"); ?>"></script>
    <link href="<?php echo base_url("assets/bootstrap/css/toastr.min.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("assets/bootstrap/css/style.css"); ?>" rel="stylesheet" type="text/css" />  
<link rel="shortcut icon" href="logo.ico" />
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

            </div>

               <img  class="img-circle" src="<?php echo base_url("assets/images/logo.jpg"); ?>" style="height:250px; width: 250px;">

            <h3>Bienvenido a Amar Té</h3>
            
            <br>
           <?php echo form_open('login/index',array("class"=>"m-t", "role"=>"form")); ?>
                <div class="form-group">
                    <input id="username" name="username" type="username" class="form-control" placeholder="username/mail account" required="">
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Ingresar</button>

                <a href="#"><small>¿Olvido su contraseña?</small></a>
                                
            <?php echo form_close(); ?>
        </div>
    </div>
    <script>


<?php if($this->session->flashdata("message")){ ?>

toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": true,
  "preventDuplicates": true,
  "positionClass": "<?php echo $this->session->flashdata("message")["positionClass"]; ?>",
  "onclick": null,
  "showDuration": "400",
  "hideDuration": "1000",
  "timeOut": "7000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
Command: toastr["<?php echo $this->session->flashdata("message")["type"]; ?>"]("<?php echo $this->session->flashdata("message")["message"];?>", "<?php echo $this->session->flashdata("message")["tittle"]?>")
<?php }?>
    </script>
    <!-- Mainly scripts -->


</body>

<?php //echo $footer; ?>