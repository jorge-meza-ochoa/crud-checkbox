<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Css -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- Css Datatable -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

<!-- Css FontAwesome -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- JS Datatable -->

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

	<title>Consulta 1</title>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<br>
        <button class="btn-delete btn btn-danger"><i class="fa fa-trash"></i>Eliminar</button>
				<button class="btn-agregar btn btn-primary"><i class="fa fa-plus"></i>Agregar</button>
				<br><br>
				<div class="table-responsive">
					<table id="consulta" class="table table-hover table-border">
						<thead>
							<tr class="table-success">
                <td><input type="checkbox" name="checktodos" value=""></td>
								<td>Nombres</td>
								<td>Apellidos</td>
								<td>Imagen</td>
                <td>Acciones</td>
								
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>



<form id="subir_archivo"  enctype="multipart/form-data">
<div class="modal" id="modal-agregar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<input type="hidden" name="id" class="id">
      	<input type="hidden" name="accion" class="accion">
        <div class="row">
        	<div class="col-md-6">
        		<div class="form-group">
        			<label for="">Nombres</label>
        			<input type="text" name="nombre" class="nombre form-control" required>
        		</div>
        	</div>
        	<div class="col-md-6">
        		<div class="form-group">
        			<label for="">Apellidos</label>
        			<input type="text" name="apellido" class="apellido form-control" required>
        		</div>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-12">
        		<div class="form-group">
        			<label for="">Imagen</label>
        			<input type="file" name="imagen" class="form-control"   required>
        		</div>
        	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button  class="btn btn-primary btn-submit">Save changes</button>
      </div>
    </div>
  </div>
</div>
</form>


</body>
</html>



<script>
	
function loadData(){

$(document).ready(function(){
	$("#consulta").dataTable({
		"destroy" :true,
		"bAutoWidth" : false,
		"deferRender" :true,
		"sAjaxSource" : "../source/consulta.php?op=1",
		"aoColumns" : [
       {mData : null , render : function(data){
        radios = '<input type="checkbox"  name="checked[]" value="'+data.id+'">';
     return radios;
       }},
       {mData : "nombres"},
       {mData : "apellidos"},
       {mData : null,render :  function(data){
    imagen = '<img src="../uploads/'+data.imagen+'" width="50px" height="50px" >';
    return imagen;
       }},
       {mData : null , render : function(data){
        accion = '<button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>';
        return accion;
       }}
		]
	});
});

}

loadData();

$(document).on("click",".btn-agregar",function(){
	$("#subir_archivo")[0].reset();
  $(".accion").val("agregar");
	$(".modal-title").html('<i class="fa fa-user text-primary"> Agregar</i>');
	$(".btn-submit").html("Agregar");
	$("#modal-agregar").modal("show");
});



$(document).ready(function(){
 
  //marcar todos los Checkbox
  $("input[name=checktodos]").change(function(){
    $('input[type=checkbox]').each( function() {      
      if($("input[name=checktodos]:checked").length == 1){
        this.checked = true;
      } else {
        this.checked = false;
      }
    });
  });
 
});


$(document).on('click', '.btn-delete', function () {

//ejecutar checkbox
$("input[type=checkbox]:checked").each(function(){
        //cada elemento seleccionado
        id = $(this).val();
        $.ajax({
          url : "../source/consulta.php?op=3",
          type : "POST",
          data : {"id":id},
         success : function(data){
        swal({
  title: "Buen Trabajo",
  type:  "success",
  text:  "Se elimino los registros seleccionados",
  timer: 3000,
  showConfirmButton: false
});

loadData();
         }
        });
    });

});




//subir archivos

$(document).on('submit','#subir_archivo',function (e){
parametros = $(this).serialize();

$.ajax({

url:"../source/consulta.php?op=2",
type:"POST",
data:new FormData(this),
contentType: false,
cache: false,
processData:false,
success:function(data){

$('#modal-agregar').modal('hide');

swal({
  title: "Buen Trabajo",
  type:  "success",
  text:  "Archivo Subido",
  timer: 3000,
  showConfirmButton: false
});

loadData();

}


});


e.preventDefault();
});




</script>
