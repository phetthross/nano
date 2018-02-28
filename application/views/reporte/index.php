<?php echo $header; ?>
<div class="row">
<?php if ($this->session->flashdata('message')){ echo $this->session->flashdata('message'); }?>
    <div class="col-xs-12">
        <center><h1><?php echo $plural_name; ?></h1></center>
    </div>

    <!-- /.col-lg-6 -->
   
</div>
	

<?php echo $table; ?><script type="text/javascript">
$(document).ready(function(){
    $('#tabla').DataTable();
});
</script>	
<br><br><br><br>
<?php echo $footer; ?>