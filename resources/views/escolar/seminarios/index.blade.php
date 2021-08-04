@extends('layouts.adminLTE')
@section('title')
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div id="block-table" style="display: block;">
            <div class="card shadow-lg">
                <div class="card-header py-3">
                    <button class="btn btn-rounded btn-primary mb-3 float-right" id="" onclick="newCat();"><i
                            class="fas fa-plus"></i>
                        Agregar Nuevo</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="cats" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
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
        @include('admon.grupos.create')
        @include('admon.grupos.edit')
        @include('admon.grupos.modal-delete')
    </div><!-- /.container-fluid -->
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            Charge();
        });

        function reload() {
            $('#cats').each(function() {
                dt = $(this).dataTable();
                dt.fnDraw();
            })
        }

        function Charge() {
            $('#cats').DataTable({
                lengthMenu: [
                    [25, 100, -1],
                    [25, 100, "Todos"]
                ],
                pageLength: 25,
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excel',
                    text: '<span class="fas fa-file-excel-o"></span> Exportar Excel',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied'
                        }
                    }
                }],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                lengthChange: true,
                processing: true,
                serverSide: true,
                ajax: "{{ url('/auxiliar/CATgrupos/datos') }}",
                columns: [{
                        data: 'nombre',
                        name: 'nombre'
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

        function editCat(id) {
            $("#id_cat").val(id);
            $("#block-table").css("display", "none");
            $("#block-edit").css("display", "block");
            getCat();
        }

        function getCat() {
            var id = $("#id_cat").val();
            var route = '{{ url('/admon/CATgrupos/editar') }}/' + id;
            Notiflix.Loading.Dots('Procesando...');
            $.get(route, function(data) {
                Notiflix.Loading.Remove();
                $("#txNombreEdit").val(data.cat.nombre);
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
            var nombre = $("#txNombre").val();

            var route = "/admon/CATgrupos/guardar";

            var form = $("#form-cat");

            //checkPsd
            var psd = $("#psdMaster").val();
            var route_psd = "/admon/consultar/contrasenia/" + psd;

            if (psd != "") {
                $.get(route_psd, function(res) {
                    if (res.success == true) {
                        $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                nombre: nombre
                            },
                            beforeSend: function() {
                                Notiflix.Loading.Dots('Procesando...');
                            },
                            success: function() {
                                Notiflix.Loading.Remove();
                                $('#message-error-save').css('display', 'none');
                                Notiflix.Report.Success('Bien hecho', 'Has guardado un nuevo grupo.',
                                    'Click');
                                reload();
                                document.getElementById("form-cat").reset();
                                $("#block-table").css("display", "block");
                                $("#block-create").css("display", "none");
                            },
                            error: function(data) {
                                Notiflix.Loading.Remove();
                                Notiflix.Report.Failure('Algo salió mal', 'Revisa tu información',
                                    'Cerrar');
                                var response = JSON.parse(data.responseText);
                                var errorString = "<ul>";
                                $.each(response.errors, function(key, value) {
                                    errorString += "<li>" + value + "</li>";
                                });
                                $("#error-save").html(errorString);
                                $("#message-error-save").fadeIn();
                            }
                        });
                    } else {
                        alert('Clave maestra incorrecta.');
                    }
                });

            } else {
                alert('Por favor llena el campo de clave maestra.');
            }
        }

        function updateCat() {
            var id = $("#id_cat").val();
            var nombre = $("#txNombreEdit").val();

            var route = "/admon/CATgrupos/actualizar/" + id;

            //checkPsd
            var psd = $("#psdMasterEdit").val();
            var route_psd = "/admon/consultar/contrasenia/" + psd;

            if (psd != "") {
                $.get(route_psd, function(res) {
                    if (res.success == true) {
                        $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'PUT',
                            dataType: 'json',
                            data: {
                                nombre: nombre
                            },
                            beforeSend: function() {
                                Notiflix.Loading.Dots('Procesando...');
                            },
                            success: function() {
                                Notiflix.Loading.Remove();
                                $('#message-error-save').css('display', 'none');
                                Notiflix.Report.Success('Bien hecho', 'Has actualizado correctamente.',
                                    'Cerrar');
                                reload();
                                cancel();

                            },
                            error: function(data) {
                                Notiflix.Loading.Remove();
                                Notiflix.Report.Failure('Algo salió mal', 'Revisa tu información',
                                    'Cerrar');
                                var response = JSON.parse(data.responseText);
                                var errorString = "<ul>";
                                $.each(response.errors, function(key, value) {
                                    errorString += "<li>" + value + "</li>";
                                });
                                $("#error-save").html(errorString);
                                $("#message-error-save").fadeIn();
                            }
                        });
                    } else {
                        alert('Clave maestra incorrecta.');
                    }
                });

            } else {
                alert('Por favor llena el campo de clave maestra.');
            }
        }

        function DeleteMod(btn) {
            $("#id-delete").val(btn);
        }

        $("#deleteRow").click(function() {
            var id = $("#id-delete").val();
            var route = "/admon/CATgrupos/eliminar/";
            //checkPsd
            var psd = $("#psdMasterDelete").val();
            var route_psd = "/admon/consultar/contrasenia/" + psd;

            if (psd != "") {
                $.get(route_psd, function(res) {
                    if (res.success == true) {
                        $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                            beforeSend: function() {
                                Notiflix.Loading.Dots('Procesando...');
                            },
                            success: function() {
                                Notiflix.Loading.Remove();
                                $("#message-error-edit").fadeOut();
                                $("#modalDelete").modal('toggle');
                                reload();
                                $("#psdMasterDelete").val("");
                                Notiflix.Notify.Success('Registro eliminado.');
                            },
                            error: function(data) {
                                Notiflix.Loading.Remove();
                                var response = JSON.parse(data.responseText);
                                var errorString = "<ul>";
                                $.each(response.errors, function(key, value) {
                                    errorString += "<li>" + value + "</li>";
                                });
                                $("#error-edit").html(errorString);
                                $("#message-error-edit").fadeIn();
                            }
                        })
                    } else {
                        alert('Clave maestra incorrecta.');
                    }
                });
            } else {
                alert('Por favor llena el campo de clave maestra.');
            }
        });

        function DeleteCat(btn) {
            var id = btn.value;
            var route = "/admon/CATgrupos/eliminar/" + id;
            Notiflix.Confirm.Show(
                'Cat Referencias',
                '¿Esta seguro de eliminar este registro?',
                'Si',
                'No',
                function() {
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
                        .done(function(response) {
                            reload();
                            Notiflix.Report.Success('Bien hecho', 'Has eliminado un registro.',
                                'Click');
                        })
                        .fail(function() {
                            Notiflix.Report.Failure('Oooops!', 'Algo salio mal con la petición.',
                                'Click');
                        });
                },
                function() { // No button callback
                    Notiflix.Notify.Warning('Petición cancelada.');
                }
            );
        }

    </script>
@endsection
