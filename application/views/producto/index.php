<?php echo $header; ?>
<div class="row">
<?php if ($this->session->flashdata('message')){ echo $this->session->flashdata('message'); }?>
    <div class="col-xs-9">
        <h1><?php echo $plural_name; ?></h1>
    </div>
    <!-- /.col-lg-6 -->
    <div class="col-xs-3" align="right">
    <!-- Button trigger modal -->
		<a href="<?php echo site_url($class_name."/add")?>"> <button type="button" class="btn btn-danger btn-md btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo</button></a>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#tabla').DataTable();
});
</script>	

<?php echo $table; ?>
<br><br><br><br>
<?php echo $footer; ?>