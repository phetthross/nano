<?php echo $header; ?>
<div id='formulario's >
<?php if($this->session->flashdata('message')) { echo $this->session->flashdata('message'); }  ?>
<?php echo form_open($class_name.'/add',array("class"=>"form-horizontal")); ?>
 <br>
        <center><h2><strong>Nuevo Color</strong></h2></center>
        <br>
        <?php echo $form; ?> 
       
        <?php echo form_close(); ?>
		
</div>
<br><br><br><br>
<?php echo $footer; ?>