		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><small><?php echo $plural_name; ?></small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                  
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12"><h1 class="m-t-none m-b"><?php echo $tittle; ?></h1>
                                <small>Por favor, complete la información solicitada. <strong>Los campos con el signo "*" son obligatorios.</strong></small>
                            <hr width="80%">
                                	<?php echo form_open($class_name.'/'.$method_name,array("class"=>"form-horizontal", "autocomplete"=>"off")); ?>		
		        						<?php echo $form; ?>      
                        <?php if( isset($dinamic) ){ echo $dinamic; }?>        
		        					<?php echo form_close(); ?>	
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        
<?php if($this->session->flashdata("error_form")){ ?>
<script>
toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": true,
  "preventDuplicates": true,
  "positionClass": "<?php echo $this->session->flashdata("error_form")["positionClass"]; ?>",
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
Command: toastr["<?php echo $this->session->flashdata("error_form")["type"]; ?>"]("<?php echo $this->session->flashdata("error_form")["message"];?>", "<?php echo $this->session->flashdata("error_form")["tittle"]?>")
</script>
<?php }?>	