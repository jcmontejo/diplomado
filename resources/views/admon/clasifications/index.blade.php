@extends('layouts.adminLTEAdmon')
@section('title')
@section('content')
<div class="container-fluid">
    <!-- DataTales Example -->
    <div id="block-table" style="display: block;">
        <div class="card shadow-lg">
            <div class="card-header py-3">
                <button class="btn btn-rounded btn-primary mb-3 float-right" id="" onclick="newCat();"><i class="fas fa-plus"></i>
                Agregar Nuevo</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="cats" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Referencia</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admon.clasifications.create')
    @include('admon.clasifications.edit')
</div><!-- /.container-fluid -->
@endsection
@section('js')
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#cats').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#cats').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: "{{url('/admon/CATclasificaciones/datos')}}",
            columns: [{
                data: 'name',
                name: 'name'
            },
            {
                data: 'action',
                name: 'action'
            }
            ]
        });
    }

    function newCat() {
        $("#block-table").css("display", "none");
        $("#block-create").css("display", "block");
    }

    function editCat(id)
    {
      $("#id_cat").val(id);
      $("#block-table").css("display", "none");
      $("#block-edit").css("display", "block");
      getCat();
  }

  function getCat() {
    var id = $("#id_cat").val();
    var route = '{{url('/admon/CATclasificaciones/editar')}}/' + id;
    Notiflix.Loading.Dots('Procesando...');
    $.get(route, function (data) {
        Notiflix.Loading.Remove();
        $("#txtNameEdit").val(data.cat.name);
    });
}

function cancel() {
    document.getElementById("form-cat").reset();
    $("#block-table").css("display", "block");
    $("#block-create").css("display", "none");
    $("#block-edit").css("display", "none");
    $('#message-error-save').css('display', 'none');
}

function storeCat() {
    var name = $("#txName").val();

    var route = "/admon/CATclasificaciones/guardar";

    var form = $("#form-cat");

    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'json',
        data: {
            name: name
        },
        beforeSend: function () {
            Notiflix.Loading.Dots('Procesando...');
        },
        success: function () {
            Notiflix.Loading.Remove();
            $('#message-error-save').css('display', 'none');
            Notiflix.Report.Success('Bien hecho', 'Has guardado una nueva clasificación.', 'Click' ); 
            reload();
            document.getElementById("form-cat").reset();
            $("#block-table").css("display", "block");
            $("#block-create").css("display", "none");
        },
        error: function (data) {
            Notiflix.Loading.Remove();
            Notiflix.Report.Failure('Algo salió mal','Revisa tu información','Cerrar');
            var response = JSON.parse(data.responseText);
            var errorString = "<ul>";
            $.each(response.errors, function (key, value) {
                errorString += "<li>" + value + "</li>";
            });
            $("#error-save").html(errorString);
            $("#message-error-save").fadeIn();
        }
    });
}

function updateCat() {
   var id = $("#id_cat").val();
   var name = $("#txtNameEdit").val();

   var route = "/admon/CATclasificaciones/actualizar/" + id;


   $.ajax({
    url: route,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'PUT',
    dataType: 'json',
    data: {
        name: name
    },
    beforeSend: function () {
        Notiflix.Loading.Dots('Procesando...');
    },
    success: function () {
        Notiflix.Loading.Remove();
        $('#message-error-save').css('display', 'none');
        Notiflix.Report.Success('Bien hecho', 'Has actualizado correctamente.', 'Cerrar' ); 
        reload();
        cancel();

    },
    error: function (data) {
        Notiflix.Loading.Remove();
        Notiflix.Report.Failure('Algo salió mal','Revisa tu información','Cerrar');
        var response = JSON.parse(data.responseText);
        var errorString = "<ul>";
        $.each(response.errors, function (key, value) {
            errorString += "<li>" + value + "</li>";
        });
        $("#error-save").html(errorString);
        $("#message-error-save").fadeIn();
    }
});
}

function DeleteCat(btn) {
    var id = btn.value;
    var route = "/admon/CATclasificaciones/eliminar/" + id;
    Notiflix.Confirm.Show(
        'Cat Clasificaciones', 
        '¿Esta seguro de eliminar esta clasificación?',
        'Si',
        'No',
        function(){
            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                dataType: 'json',
                data: {
                    id: id
                },
            })
            .done(function (response) {
                reload();
                Notiflix.Report.Success('Bien hecho', 'Has eliminado un registro.',
                    'Click');
            })
            .fail(function () {
                Notiflix.Report.Failure('Oooops!', 'Algo salio mal con la petición.',
                    'Click');
            });
        },
              function(){ // No button callback
                Notiflix.Notify.Warning('Petición cancelada.');
            } 
            ); 
}

</script>
@endsection
