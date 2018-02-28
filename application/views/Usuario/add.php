<?php echo $header; ?>
<div id='formulario'  >
<?php if($this->session->flashdata('message')){  ?>
	<div class="alert alert-danger"><?php echo $this->session->flashdata('message'); ?></div>
<?php }  ?>
<?php echo form_open($class_name.'/add',array("class"=>"form-horizontal")); ?>
 <br>
        <center><h2><strong>Nuevo Producto</strong></h2></center>
        <br>
        <?php echo $form; ?> 
       
        <?php echo form_close(); ?>
		
</div>
<br><br><br><br>
<?php echo $footer; ?>