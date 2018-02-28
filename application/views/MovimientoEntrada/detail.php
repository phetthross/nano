<?php echo $header; ?>
<div class="row">
    <div class="col-xs-10">
        <center><h1>Resumen</h1></center>
    </div>
    <!-- /.col-lg-6 -->
    <div class="col-xs-2" align="right">
    <!-- Button trigger modal -->
		<br><br><a href="<?php echo site_url($class_name)?>"> <button type="button" class="btn btn-primary btn-md btn-block"><i class="fa fa-caret-square-o-left fa-lg" aria-hidden="true"></i> Volver</button></a>
    </div>

<?php echo $table; ?>
<div class="row">
    <div class="col-xs-10">
        <center><h1>Detalle</h1></center>
    </div>
    <!-- /.col-lg-6 -->
    
</div>	

<?php echo $table_detail; ?>

<?php echo $footer; ?>