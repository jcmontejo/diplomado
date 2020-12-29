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
                                <th>Fecha</th>
                                <th>Fuente</th>
                                <th>Concepto</th>
                                <th>Clasificación</th>
                                <th>Monto</th>
                                <th>Referencia</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="7" style="text-align:left">Total:</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admon.expenses.create')
    @include('admon.expenses.edit')
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
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total over this page
                pageTotal = api
                    .column(4, {
                        page: 'current'
                    })
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Update footer
                $(api.column(4).footer()).html(
                    '$' + pageTotal + ' ( $' + total + ' total)'
                );
            },
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            lengthChange: true,
            processing: true,
            serverSide: true,
            ajax: "{{url('/admon/CATegresos/datos')}}",
            columns: [{
                data: 'date',
                name: 'date'
            },
            {
                data: 'account',
                name: 'account'
            },
            {
                data: 'concept',
                name: 'concept'
            },
            {
                data: 'clasification',
                name: 'clasification'
            },
            {
                data: 'amount',
                name: 'amount'
            },
            {
                data: 'reference',
                name: 'reference'
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
    var route = '{{url('/admon/CATegresos/editar')}}/' + id;
    Notiflix.Loading.Dots('Procesando...');
    $.get(route, function (data) {
        Notiflix.Loading.Remove();
        $("#txtDateEdit").val(data.cat.date);
        $("#txtConceptEdit").val(data.cat.concept);
        $("#txtAmountEdit").val(data.cat.amount);
        $("#txtAccountEdit").val(data.cat.account_id).change();
        $("#txtReferenceEdit").val(data.cat.cat_reference).change();
        $("#txtClasificationEdit").val(data.cat.cat_clasification).change();
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
    var date = $("#txtDate").val();
    var amount = $("#txtAmount").val();
    var concept = $("#txtConcept").val();
    var account_id = $("#txtAccount").val();
    var cat_reference = $("#txtReference").val();
    var cat_clasification = $("#txtClasification").val();

    var route = "/admon/CATegresos/guardar";

    var form = $("#form-cat");

    $.ajax({
        url: route,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        dataType: 'json',
        data: {
            date: date,
            amount: amount,
            concept: concept,
            account_id: account_id,
            cat_reference: cat_reference,
            cat_clasification: cat_clasification
        },
        beforeSend: function () {
            Notiflix.Loading.Dots('Procesando...');
        },
        success: function () {
            Notiflix.Loading.Remove();
            $('#message-error-save').css('display', 'none');
            Notiflix.Report.Success('Bien hecho', 'Has guardado un nuevo egreso.', 'Click' ); 
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
   var date = $("#txtDateEdit").val();
   var amount = $("#txtAmountEdit").val();
   var concept = $("#txtConceptEdit").val();
   var account_id = $("#txtAccountEdit").val();
   var cat_reference = $("#txtReferenceEdit").val();
   var cat_clasification = $("#txtClasificationEdit").val();

   var route = "/admon/CATegresos/actualizar/" + id;


   $.ajax({
    url: route,
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'PUT',
    dataType: 'json',
    data: {
        date: date,
        amount: amount,
        concept: concept,
        account_id: account_id,
        cat_reference: cat_reference,
        cat_clasification: cat_clasification
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
    var route = "/admon/CATegresos/eliminar/" + id;
    Notiflix.Confirm.Show(
        'Cat Gastos', 
        '¿Esta seguro de eliminar este gasto?',
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
