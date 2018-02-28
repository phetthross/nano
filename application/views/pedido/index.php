<?php echo $header; ?>
<div class="row">
<?php if ($this->session->flashdata('message')){ echo $this->session->flashdata('message'); }?>
    <div class="col-xs-12">
        <h1><?php echo $plural_name; ?></h1>
    </div>

    <!-- /.col-lg-6 -->
    
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#tabla').DataTable();
});
</script>		

<?php echo $table; ?>
<br><br><br><br>
<?php echo $footer; ?>