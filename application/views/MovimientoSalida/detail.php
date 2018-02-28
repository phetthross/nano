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
</div>

<?php echo $table; ?>
<?php 
if ( $despacho != "")
{
    echo "<div class=\"row\">
    <div class=\"col-xs-10\">";
    echo " <center><h1>Datos de Despacho</h1></center>";
        echo "</div>
</div>";
    echo $despacho;

}
?>

<div class="row">
    <div class="col-xs-10">
        <center><h1>Detalle</h1></center>
    </div>
    <!-- /.col-lg-6 -->
    
</div>	

<?php echo $table_detail; ?>

<?php echo $footer; ?>