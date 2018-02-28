
<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><small>Cuadro General</small></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                  
                        </div>
                    </div>
                    <div class="ibox-content">

<div class="row">
    <?php if(!isset($back)){ ?>
    <div class="col-xs-12 col-md-10">
        <h1><?php echo $plural_name; ?></h1>
    </div>
    <!-- /.col-lg-6 -->
   
    <div class="col-xs-5 col-md-2" align="right">
    
		<br><a href="<?php if(isset($addform)){echo site_url($class_name."/".$addform);}else{echo site_url($class_name."/addform");}   ?>"> <button type="button" class="btn btn-success btn-md btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo</button></a><br>
   
    </div>
    <?php } else { ?>
    <div class="col-xs-12 col-md-8">
        <h1><?php echo $plural_name; ?></h1>
    </div>
    <!-- /.col-lg-6 -->
   
    <div class="col-xs-5 col-md-2" align="right">

    <br><a href="<?php echo site_url($class_name."/".$back)?>"> <button type="button" class="btn btn-primary btn-md btn-block"><span class="fa fa-backward" aria-hidden="true"></span>
     Volver</button></a><br>
   
    </div>
    <div class="col-xs-5 col-md-2" align="right">

    <br><a href="<?php if(isset($addform)){echo site_url($class_name."/".$addform);}else{echo site_url($class_name."/addform");}   ?>"> <button type="button" class="btn btn-success btn-md btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nuevo</button></a><br>
   
    </div>

    <?php } ?>
</div>
	
<div class="ibox-content">
<?php echo $table; ?>
</div>
 <script>
        $(document).ready(function(){
            $('.table').DataTable({
                "language": {        
                  "zeroRecords": "<i class='fa fa-exclamation-triangle fa-5x' aria-hidden='true' ></i> <h4>No se encontraron resultados.</h4>",
                  "info": "<div class='alert alert-success'><i class='fa fa-info-circle fa-lg' aria-hidden='true'></i> Mostrando _PAGE_ de _PAGES_ paginas.</div>",
                  "infoFiltered": "<i class='fa fa-search fa-lg' aria-hidden='true'></i> Filtrando de un total de _MAX_ registros.",
                  "search": "Buscar",
                  "lenght": "test",
                  "lenghtMenu": [10,15,20,25]
                },
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script>
    <?php if($this->session->flashdata("message")){ ?>
<script>
toastr.options = {
  "closeButton": true,
  "debug": false,
  "progressBar": true,
  "preventDuplicates": true,
  "positionClass": "<?php echo $this->session->flashdata("message")["positionClass"]; ?>",
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
Command: toastr["<?php echo $this->session->flashdata("message")["type"]; ?>"]("<?php echo $this->session->flashdata("message")["message"];?>", "<?php echo $this->session->flashdata("message")["tittle"]?>")
</script>
<?php }?> 
</div></div>
<br><br><br><br>
