<?php echo $header; ?>
<div id='formulario' style='width: 80%; margin: 0 auto; ' >
<?php if($this->session->flashdata('message')){  ?>
<?php echo $this->session->flashdata('message'); ?>
<?php }  ?>
<?php echo form_open($class_name.'/add',array("class"=>"form-horizontal")); ?>
 <br>
        <center><h2><strong>Ingreso de Productos a Bodega</strong></h2></center>
        <br>
        <?php echo $form; ?>
       <center><?php echo $dinamic_insert; ?> </center>
        <?php echo form_close(); ?>
		
</div>
<br><br><br><br>
<?php echo $footer; ?>