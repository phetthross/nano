<?php echo $header; ?>
<div id='formulario' style='width: 50%; margin: 0 auto; ' >
<?php if($this->session->flashdata('message')) { echo $this->session->flashdata('message'); }  ?>
<?php echo form_open($class_name.'/despacho',array("class"=>"form-horizontal")); ?>
 <br>
        <center><h2><strong>Nuevo Despacho</strong></h2></center>
        <br>
        <?php echo $form; ?> 
       
        <?php echo form_close(); ?>
		
</div>
<br><br><br><br>
<?php echo $footer; ?>