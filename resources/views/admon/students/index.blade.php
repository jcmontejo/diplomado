@extends('layouts.adminLTEAdmon')
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de alumnos registrados</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="students" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Curp</th>
                        <th>Nombre(s)</th>
                        <th>Apellido paterno</th>
                        <th>Apellido materno</th>
                        <th>Teléfono</th>
                        <th>Correo electrónico</th>
                        <th>Profesión</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
@include('admon.students.modal-edit')
@include('admon.students.modal-delete')
@endsection
@section('js')
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
        });
    });

</script>
<script>
    $(document).ready(function () {
        Charge();
    });

    function reload() {
        $('#students').each(function () {
            dt = $(this).dataTable();
            dt.fnDraw();
        })
    }

    function Charge() {
        $('#students').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            "aLengthMenu": [
                [25, 50, 75, -1],
                [25, 50, 75, "Todos"]
            ],
            "pageLength": 25,
            "dom": 'lBfrtip',
            "buttons": ['excel', 'pdf'],
            processing: true,
            serverSide: true,

            ajax: '/admon/alumnos/datos',
            columns: [{
                    data: 'curp',
                    name: 'curp'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'mother_last_name',
                    name: 'mother_last_name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'profession',
                    name: 'profession'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }

    function Show(btn) {
        var route = "/control-escolar/alumnos/editar/" + btn.value;


        $.get(route, function (res) {
            $("#curp").val(res.curp);
            $("#name").val(res.name);
            $("#lastname").val(res.last_name);
            $("#motherlastname").val(res.mother_last_name);
            $("#birthdate").val(res.birthdate);
            $("#sex").val(res.sex);
            $("#phone").val(res.phone);
            $("#facebook").val(res.facebook);
            $("#address").val(res.address);
            $("#state").val(res.state);
            $("#city").val(res.city);
            $("#email").val(res.email);
            $("#status").val(res.status);
            $("#profession").val(res.profession);
            $("#id").val(res.id);
        });
    }

    $("#updateStudent").click(function () {
        var value = $("#id").val();
        var curp = $("#curp").val();
        var name = $("#name").val();
        var last_name = $("#lastname").val();
        var mother_last_name = $("#motherlastname").val();
        var birthdate = $("#birthdate").val();
        var sex = $("#sex").val();
        var phone = $("#phone").val();
        var address = $("#address").val();
        var state = $("#state").val();
        var city = $("#city").val();
        var email = $("#email").val();
        var status = $("#status").val();
        var profession = $("#profession").val();
        var facebook = $('#facebook').val();
        var route = "/control-escolar/alumnos/actualizar/" + value;

        //checkPsd
        var psd = $("#psdMasterEdit").val();
        var route_psd = "/admon/consultar/contrasenia/" + psd;

        if (psd != "") {
            $.get(route_psd, function (res) {
                if (res.success == true) {
                    $.ajax({
                        url: route,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'PUT',
                        dataType: 'json',
                        data: {
                            curp: curp,
                            name: name,
                            last_name: last_name,
                            mother_last_name: mother_last_name,
                            birthdate: birthdate,
                            sex: sex,
                            phone: phone,
                            address: address,
                            state: state,
                            city: city,
                            email: email,
                            facebook: facebook,
                            profession: profession,
                            status: status
                        },
                        beforeSend: function () {
                            $("#preloader").css("display", "block");
                        },
                        success: function () {
                            $("#preloader").css("display", "none");
                            $("#modalEdit .close").click();
                            reload();
                            $("#psdMasterEdit").val("");
                            toastr.success('Has actualizado al alumno exitosamente!',
                                'Bien hecho!')
                        },
                        error: function (data) {
                            if (data.status === 500) {
                                $("#preloader").css("display", "none");
                                swal("Error!",
                                    "Estas introduciendo una CURP incorrecta, favor de verificar.",
                                    "error");
                            }
                            if (data.status === 400) {
                                $("#preloader").css("display", "none");
                                swal("Error!", "Ya existe un registro con la misma CURP.",
                                    "error");
                            }
                            $("#preloader").css("display", "none");
                            var response = JSON.parse(data.responseText);
                            var errorString = "<ul>";
                            $.each(response.errors, function (key, value) {
                                errorString += "<li>" + value + "</li>";
                            });

                            $("#error-edit").html(errorString);
                            $("#message-error-edit").fadeIn();
                        }
                    });
                } else {
                    alert('Clave maestra incorrecta.');
                }
            });
        } else {
            alert('Por favor llena el campo de clave maestra.');
        }
    });

    function Delete(btn) {
        var id = btn.value;
        var route = "/alumnos/eliminar/" + btn.value;
        swal({
            title: '¿Estás seguro?',
            text: "Será eliminado permanentementse!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, borralo!',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {

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
                            swal('Eliminado!', response.message, response.status);
                        })
                        .fail(function () {
                            swal('Oops...', 'Algo salió mal con la petición!', 'error ');
                        });
                });
            },
            allowOutsideClick: false
        });
    }

    function DeleteMod(btn) {
        $("#id-delete").val(btn);
    }

    $("#deleteAccount").click(function () {
        var id = $("#id-delete").val();
        var route = "/admon/alumnos/eliminar/";
        //checkPsd
        var psd = $("#psdMasterDelete").val();
        var route_psd = "/admon/consultar/contrasenia/" + psd;

        if (psd != "") {
            $.get(route_psd, function (res) {
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
                        beforeSend: function () {
                            $("#preloader").css("display", "block");
                        },
                        success: function () {
                            $("#preloader").css("display", "none");
                            $("#message-error-edit").fadeOut();
                            $("#modalDelete").modal('toggle');
                            reload();
                            $("#psdMasterDelete").val("");
                            toastr.success('Eliminado!', 'Bien hecho!')
                        },
                        error: function (data) {
                            $("#preloader").css("display", "none");
                            var response = JSON.parse(data.responseText);
                            var errorString = "<ul>";
                            $.each(response.errors, function (key, value) {
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

</script>
@endsection
