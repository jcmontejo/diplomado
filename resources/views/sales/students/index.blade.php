@extends('layouts.adminLTESales')
@section('content')
    <div class="row">

        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Lista De Alumnos</h4>
                    <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                        <strong>Alumno Actualizado Correctamente.</strong>
                    </div>

                    <a href="#" class="btn btn-rounded btn-primary mb-3 float-right" id="createStudent"><i
                            class="fas fa-plus"></i> Agregar
                        Nuevo Alumno</a>
                    <div class="table-responsive">
                        <table class="table" id="students">
                            <thead>
                                <th>Acciones</th>
                                <th>Curp</th>
                                <th>Matricula</th>
                                <th>Nombre Alumno</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Genero</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Correo Electrónico</th>
                                <th>Profesión</th>
                                <th>Vendedor</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- data table end -->
    </div>
    @include('sales.students.modal-edit')
    @include('sales.students.modal-create')
    @include('sales.students.modal-adddocuments')
    @include('sales.students.modal-documents')
    @include('sales.students.modal-sale')
    @include('sales.students.modal-inscription')
    @include('sales.students.modal-seminario')
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            Charge();
            $('#modalDocuments').on('hidden.bs.modal', function() {
                $("#file-address").append("");
                $("#file-address").attr("href", "");
                $("#file-study").append("");
                $("#file-study").attr("href", "");
            });

            $('select[name="diplomat_id"]').on('change', function() {
                var diplomatID = $(this).val();
                if (diplomatID) {
                    $.ajax({
                        url: '/pagos/generaciones/' + diplomatID,
                        type: "GET",
                        dataType: "json",
                        beforeSend: function() {
                            $("#preloader").css("display", "block");
                        },
                        success: function(data) {
                            $("#preloader").css("display", "none");
                            $('select[name="generation_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="generation_id"]').append(
                                    '<option value="' + key +
                                    '">Generación: ' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="generation_id"]').empty();
                    $('select[name="student_id"]').empty();
                }
            });

            $('select[name="diplomat_id_N"]').on('change', function() {
                var diplomatID = $(this).val();
                if (diplomatID) {
                    $.ajax({
                        url: '/pagos/generaciones/' + diplomatID,
                        type: "GET",
                        dataType: "json",
                        beforeSend: function() {
                            $("#preloader").css("display", "block");
                        },
                        success: function(data) {
                            $("#preloader").css("display", "none");
                            $('select[name="generation_id_N"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="generation_id_N"]').append(
                                    '<option value="' + key +
                                    '">Generación: ' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="generation_id_N"]').empty();
                    $('select[name="student_id"]').empty();
                }
            });

            $('select[name="diplomat_id-alt"]').on('change', function() {
                var diplomatID = $(this).val();
                if (diplomatID) {
                    $.ajax({
                        url: '/pagos/generaciones/' + diplomatID,
                        type: "GET",
                        dataType: "json",
                        beforeSend: function() {
                            $("#preloader").css("display", "block");
                        },
                        success: function(data) {
                            $("#preloader").css("display", "none");
                            $('select[name="generation_id-alt"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="generation_id-alt"]').append(
                                    '<option value="' + key +
                                    '">Generación: ' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="generation_id-alt"]').empty();
                    $('select[name="student_id-alt"]').empty();
                }
            });

            $('select[name="old_data_id"]').on('click', function() {
                var diplomatID = $(this).val();
                if (diplomatID) {
                    $.ajax({
                        url: '/ventas/alumnos/buscar/generaciones/' + diplomatID,
                        type: "GET",
                        dataType: "json",
                        beforeSend: function() {
                            $("#preloader").css("display", "block");
                        },
                        success: function(data) {
                            $("#preloader").css("display", "none");
                            $('select[name="generation_id_old"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="generation_id_old"]').append(
                                    '<option value="' + key +
                                    '">Generación: ' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="generation_id_old"]').empty();
                    //$('select[name="old_data_id"]').empty();
                }
            });

            $('select[name="tipo_inscripcion"]').on('change', function() {
                var tipo = $(this).val();
                if (tipo == 1) {
                    $("#data-diplomat").css("display", "block");
                    $("#data-seminarios").css("display", "none");
                    $("#btn_diplomado").css("display", "block");
                    $("#btn_seminario").css("display", "none");
                }
                if (tipo == 2) {
                    $("#data-seminarios").css("display", "block");
                    $("#data-diplomat").css("display", "none");
                    $("#btn_seminario").css("display", "block");
                    $("#btn_diplomado").css("display", "none");
                }
            });

            $('select[name="professionSave"]').on('change', function() {
                var tipo = $(this).val();
                if (tipo == 10) {
                    $("#bandera_profesion").val(1);
                    $("#bloque-profesion-alt").css("display", "block");
                }else{
                    $("#bandera_profesion").val(0);
                    $("#bloque-profesion-alt").css("display", "none");
                }
            });
        });

        $('#status').on('change', function() {
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            if (valueSelected == 1) {
                $("#blockDiplomat").show();
            } else {
                $("#blockDiplomat").hide();
            }
        });

        function reload() {
            $('#students').each(function() {
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
                ajax: '/ventas/alumnos/datos',
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'curp',
                        name: 'curp'
                    },
                    {
                        data: 'enrollment',
                        name: 'enrollment'
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
                        data: 'sex',
                        name: 'sex'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'address',
                        name: 'address'
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
                        data: 'owner',
                        name: 'owner'
                    }
                ]
            });
        }

        $("#createStudent").click(function() {
            $('#message-error-inscription').css('display', 'none');
            $('#modalSale').modal('show');
        })

        $("#searchStudent").click(function() {
            var search = $("#search").val();
            var route = '/ventas/alumnos/buscar/' + search;
            if (search) {
                $.ajax({
                    url: route,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function() {
                        $("#preloader").css("display", "block");
                    },
                    success: function(res) {
                        if (res.status === 'ok') {
                            $("#preloader").css("display", "none");
                            toastr.success('CURP registrada, solo selecciona el diplomado.',
                                'Bien hecho!');
                            $("#curpStudent").val(res.data.curp);
                            $('#nameStudent').val(res.data.name);
                            $('#lastnameStudent').val(res.data.last_name);
                            $('#motherlastnameStudent').val(res.data.mother_last_name);
                            $('#facebookStudent').val(res.data.facebook);
                            $('#birthdateStudent').val(res.data.birthdate);
                            $('#sexStudent').val(res.data.sex);
                            $('#phoneStudent').val(res.data.phone);
                            $('#addressStudent').val(res.data.address);
                            $("#stateStudent").val(res.data.state);
                            $("#cityStudent").val(res.data.city);
                            $("#emailStudent").val(res.data.email);
                            $("#professionStudent").val(res.data.profession);
                            $("#idStudent").val(res.data.id);
                            $("#bandera").val(1);

                            if (res.inscriptions) {
                                $("#data-diplomat-old").css("display", "block");
                                $("#data-diplomat").css("display", "none");

                                $('select[name="old_data_id"]').empty();
                                $.each(res.inscriptions, function(key, value) {
                                    $('select[name="old_data_id"]').append(
                                        '<option value="' + value.id_inscription +
                                        '">Diplomado: ' + value.diplomat + ' Generación: ' +
                                        value.generation + ' Pagado: $' + (value
                                            .final_cost - value.total_debt) + ' Debe: $' +
                                        value.total_debt + ' </option>');
                                });
                            } else {
                                // $("#data-diplomat").css("display", "none");
                                // $("#data-diplomat-old").css("display", "block");
                            }
                        } else {
                            $("#preloader").css("display", "none");
                            toastr.error('CURP no registrada, completa el registro por favor.',
                                'Error!');
                            $("#data-diplomat-old").css("display", "none");
                            $("#data-diplomat").css("display", "block");
                            $("#curpStudent").val(search);
                            $('#nameStudent').val('');
                            $('#lastnameStudent').val('');
                            $('#motherlastnameStudent').val('');
                            $('#facebookStudent').val('');
                            $('#birthdateStudent').val('');
                            $('#sexStudent').val('');
                            $('#phoneStudent').val('');
                            $('#addressStudent').val('');
                            $("#stateStudent").val('');
                            $("#cityStudent").val('');
                            $("#emailStudent").val('');
                            $("#professionStudent").val('');
                            $("#bandera").val(0);
                        }
                    },
                    error: function(data) {
                        if (data.status === 400) {
                            $("#preloader").css("display", "none");
                            toastr.error('CURP no egistrada, completa el registro por favor.',
                                'Error!');
                            $("#curpStudent").val(search);
                            $("#data-diplomat-old").css("display", "none");
                            $("#data-diplomat").css("display", "block");
                        }
                    }
                });
            } else {
                toastr.error('Introduce la CURP en la caja de busqueda!', 'Error!');
            }
        });

        function Show(btn) {
            var route = "/ventas/alumnos/editar/" + btn.value;


            $.get(route, function(res) {
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

        $("#updateStudent").click(function() {
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
            var route = "/ventas/alumnos/actualizar/" + value;

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
                beforeSend: function() {
                    $("#preloader").css("display", "block");
                },
                success: function() {
                    $("#preloader").css("display", "none");
                    $("#modalEdit .close").click();
                    reload();
                    swal("Bien hecho!", "Has actualizado al alumno exitosamente!", "success");
                },
                error: function(data) {
                    if (data.status === 500) {
                        $("#preloader").css("display", "none");
                        swal("Error!", "Estas introduciendo una CURP incorrecta, favor de verificar.",
                            "error");
                    }
                    if (data.status === 400) {
                        $("#preloader").css("display", "none");
                        swal("Error!", "Ya existe un registro con la misma CURP.", "error");
                    }
                    $("#preloader").css("display", "none");
                    var response = JSON.parse(data.responseText);
                    var errorString = "<ul>";
                    $.each(response.errors, function(key, value) {
                        errorString += "<li>" + value + "</li>";
                    });

                    $("#error-edit").html(errorString);
                    $("#message-error-edit").fadeIn();
                }
            });
        });

        function Delete(btn) {
            var id = btn.value;
            var route = "/ventas/alumnos/eliminar/" + btn.value;
            swal({
                title: '¿Estás seguro?',
                text: "Será eliminado permanentemente!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, borralo!',
                showLoaderOnConfirm: true,

                preConfirm: function() {
                    return new Promise(function(resolve) {

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
                                swal('Eliminado!', response.message, response.status);
                            })
                            .fail(function() {
                                swal('Oops...', 'Algo salió mal con la petición!', 'error ');
                            });
                    });
                },
                allowOutsideClick: false
            });
        }

        function checkCurp(element) {
            var curp = $(element).val();
            $.ajax({
                type: "POST",
                url: '/ventas/alumnos/checkCurp',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    curp: curp
                },
                dataType: "json",
                success: function(res) {
                    if (res.exists) {
                        toastr.error(
                            'Esta CURP ya existe, verificalo!',
                            'Alerta');
                        $("#preloader").css("display", "block");
                        //$("#emailSave").addClass('is-invalid');
                        $("#curpSave").addClass('is-invalid');
                        $("#saveStudent").addClass('disabled');
                    } else {
                        $("#curpSave").removeClass('is-invalid');
                        $("#saveStudent").removeClass('disabled');
                        $("#preloader").css("display", "none");
                    }
                },
                error: function(jqXHR, exception) {}
            });
        }

        function inscriptionStudent(btn) {
            var route = "/ventas/alumnos/consultar/" + btn.value;

            $.get(route, function(res) {
                $("#nameInscription").val(res.name);
                $("#lastnameInscription").val(res.last_name);
                $("#motherlastnameInscription").val(res.mother_last_name);
                $("#id-student-alt").val(res.id);
            });
        }

        function inscriptionStudentSeminario(btn) {
            var route = "/ventas/alumnos/consultar/" + btn.value;

            $.get(route, function(res) {
                $("#id-student-seminario").val(res.id);
            });
        }

        $("#processInscription").click(function() {
            var student_id = $("#id-student-alt").val();
            var generation_id = $("#generation_id-alt").val();
            var discount = $("#discount-alt").val();
            var number_payments = $("#number_payments-alt").val();
            var first_payment = $("#first_payment-alt").val();
            var account = $("#accountDestination-alt").val();
            var payment_method = $("#payment_method-alt").val();
            var account_type = $("#account_type-alt").val();
            var comments = $("#comments-alt").val();
            var amount_of_payments = $("#amount_of_payments-alt").val();
            var periodicity = $("#periodicity-alt").val();
            var type_of_inscription = $("#type_of_inscription-alt").val();
            // Save Files

            var form_data = new FormData();
            // Rest of data
            form_data.append('generation_id', generation_id);
            form_data.append('student_id', student_id);
            form_data.append('discount', discount);
            form_data.append('number_payments', number_payments);
            form_data.append('first_payment', first_payment);
            form_data.append('account', account);
            form_data.append('payment_method', payment_method);
            form_data.append('account_type', account_type);
            form_data.append('comments', comments);
            form_data.append('amount_of_payments', amount_of_payments);
            form_data.append('periodicity', periodicity);
            form_data.append('type_of_inscription', type_of_inscription);

            // End
            var route = "/ventas/alumnos/procesar/inscripcion";


            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                data: form_data,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false,
                beforeSend: function() {
                    $("#preloader").css("display", "block");
                },
                success: function(res) {
                    if (res.exists) {
                        toastr.error('Este alumno ya se encuentra registrado!', 'Ooops!')
                        $("#preloader").css("display", "none");
                    } else {
                        $("#preloader").css("display", "none");
                        $('#nameInscription').val('');
                        $('#lastnameInscription').val('');
                        $('#motherlastnameInscription').val('');
                        $('#id-student-alt').val('');
                        $("#modalInscription .close").click();
                        $('#message-error-inscription').css('display', 'none');
                        reload();
                        toastr.success('Has re inscrito al alumno exitosamente!', 'Bien hecho!')
                    }
                },
                error: function(data) {
                    if (data.status === 400) {
                        $("#preloader").css("display", "none");
                        swal("Error!",
                            "Los datos del alumno estan incompletos, favor de completar todos los campos antes de inscribir.",
                            "error");
                    }
                    if (data.status === 406) {
                        $("#preloader").css("display", "none");
                        swal("Error!",
                            "Número de pago procesado anteriormente, seleccione otro número de pago.",
                            "error");
                    }
                    $("#modalInscription .close").click();
                    $("#preloader").css("display", "none");
                    var response = JSON.parse(data.responseText);
                    var errorString = "<ul>";
                    $.each(response.errors, function(key, value) {
                        errorString += "<li>" + value + "</li>";
                    });

                    $("#error-inscription").html(errorString);
                    $("#message-error-inscription").fadeIn();
                }
            });
        })

        $("#processInscriptionSeminario").click(function() {
            var student_id = $("#id-student-seminario").val();
            var seminario_id = $("#seminario_id_n").val();
            var grupo_id = $("#grupo_id_n").val();
            var descuento = $("#descuento_n").val();
            var numero_de_pagos = $("#numero_de_pagos_n").val();
            var monto_de_pagos = $("#monto_de_pagos_n").val();
            var primer_pago = $("#primer_pago_n").val();
            var cuenta_destino = $("#cuenta_destino_n").val();
            var tipo_cuota = $("#tipo_cuota_n").val();
            var metodo_de_pago = $("#metodo_de_pago_n").val();
            var route = "/ventas/alumnos/procesar/inscripcion/seminario";

            $.ajax({
                url: route,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                dataType: 'json',
                data: {
                    //Datos alumno
                    student_id: student_id,
                    //Datos seminario
                    seminario_id: seminario_id,
                    grupo_id: grupo_id,
                    descuento: descuento,
                    numero_de_pagos: numero_de_pagos,
                    monto_de_pagos: monto_de_pagos,
                    primer_pago: primer_pago,
                    cuenta_destino: cuenta_destino,
                    tipo_cuota: tipo_cuota,
                    metodo_de_pago: metodo_de_pago
                },
                beforeSend: function() {
                    $("#preloader").css("display", "block");
                },
                success: function() {
                    $("#preloader").css("display", "none");
                    $("#modalInscriptionSeminario .close").click();
                    $('#message-error-save-N').css('display', 'none');
                    reload();
                    Notiflix.Report.Success('Bien hecho', 'Has inscrito a un nuevo estudiante a un seminario.',
                        'Click');
                },
                error: function(data) {
                    var response = JSON.parse(data.responseText);
                    var errorString = "<ul>";
                    $.each(response.errors, function(key, value) {
                        errorString += "<li>" + value + "</li>";
                    });
                    $("#preloader").css("display", "none");
                    $("#error-save-N").html(errorString);
                    $("#message-error-save-N").fadeIn();
                }
            });
        })

        $("#btn_seminario").click(function() {
            let route = '{{ url('ventas/alumnos/procesar/nuevainscripcionseminario') }}';

            //checkCurp
            let crp = $("#curpStudent").val();
            let route_crp = "/ventas/alumnos/checkCurpTwo/" + crp;

             //BANDERA PROFESION
             var bandera = $("#bandera_profesion").val();
            //Datos alumno
            var curp = $("#curpStudent").val();
            var name = $("#nameStudent").val();
            var last_name = $("#lastnameStudent").val();
            var mother_last_name = $("#motherlastnameStudent").val();
            var facebook = $("#facebookStudent").val();
            var birthdate = $("#birthdateStudent").val();
            var sex = $("#sexStudent").val();
            var phone = $("#phoneStudent").val();
            var address = $("#addressStudent").val();
            var state = $("#stateStudent").val();
            var city = $("#cityStudent").val();
            var email = $("#emailStudent").val();
            if (bandera != 0) {
                    var profesion = $("#professionStudentAlt").val();
                } else {
                    var profession = $("#professionStudent").val();
                }

            //Datos seminario
            var seminario_id = $("#seminario_id").val();
            var grupo_id = $("#grupo_id").val();
            var descuento = $("#descuento").val();
            var numero_de_pagos = $("#numero_de_pagos").val();
            var monto_de_pagos = $("#monto_de_pagos").val();
            var primer_pago = $("#primer_pago").val();
            var cuenta_destino = $("#cuenta_destino").val();
            var tipo_cuota = $("#tipo_cuota").val();
            var metodo_de_pago = $("#metodo_de_pago").val();

            if (crp != "") {
                $.get(route_crp, function(res) {
                    if (res.exists != true) {
                        $.ajax({
                            url: route,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                //Datos alumno
                                curp: curp,
                                name: name,
                                last_name: last_name,
                                mother_last_name: mother_last_name,
                                facebook: facebook,
                                birthdate: birthdate,
                                sex: sex,
                                phone: phone,
                                address: address,
                                state: state,
                                city: city,
                                email: email,
                                profession: profession,
                                //Datos seminario
                                seminario_id: seminario_id,
                                grupo_id: grupo_id,
                                descuento: descuento,
                                numero_de_pagos: numero_de_pagos,
                                monto_de_pagos: monto_de_pagos,
                                primer_pago: primer_pago,
                                cuenta_destino: cuenta_destino,
                                tipo_cuota: tipo_cuota,
                                metodo_de_pago: metodo_de_pago
                            },
                            beforeSend: function() {
                                $("#preloader").css("display", "block");
                            },
                            success: function() {
                                $("#preloader").css("display", "none");
                                $("#modalSale .close").click();
                                $('#message-error-save-N').css('display', 'none');
                                reload();
                                Notiflix.Report.Success('Bien hecho',
                                    'Has guardado a un nuevo estudiante.', 'Click');
                            },
                            error: function(data) {
                                var response = JSON.parse(data.responseText);
                                var errorString = "<ul>";
                                $.each(response.errors, function(key, value) {
                                    errorString += "<li>" + value + "</li>";
                                });
                                $("#preloader").css("display", "none");
                                $("#error-save-N").html(errorString);
                                $("#message-error-save-N").fadeIn();
                            }
                        });
                    } else {
                        alert('La CURP: ' + res.crp + ' ya se encuentra registrada.');
                    }
                });
            } else {
                alert('Por favor llena el campo CURP.');
            }

        });

        $("#btn_diplomado").click(function() {
            let route_n = '{{ url('/ventas/alumnos/procesar/nuevainscripcion') }}';
            if (bandera == 1) {
                //Reinscripcion
                var student_id = $("#idStudent").val();
                var generation_re = $("#generation_id_old").val();
                var old_inscription = $("#old_data_id").val();
                var route = "/ventas/alumnos/procesar/reinscripcion";
                var check = "/ventas/revisar";

                $.ajax({
                    type: "POST",
                    url: '{{ url('/ventas/alumnos/revisar/') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        student_id: student_id,
                        generation_re: generation_re
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.exists) {
                            toastr.error(
                                'Este alumno ya se encuentra registrado en esta generación, verificalo!',
                                'Alerta');
                            //$("#saveSale").attr("disabled", true);
                        } else {
                            $.ajax({
                                url: route,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    student_id: student_id,
                                    generation_re: generation_re,
                                    old_inscription: old_inscription
                                },
                                beforeSend: function() {
                                    $("#preloader").css("display", "block");
                                },
                                success: function() {
                                    $("#preloader").css("display", "none");
                                    $("#modalSale .close").click();
                                    $('#message-error-save').css('display', 'none');
                                    Notiflix.Report.Success('Bien hecho',
                                        'Has guardado a un nuevo estudiante.', 'Click');
                                },
                                error: function(data) {
                                    var response = JSON.parse(data.responseText);
                                    var errorString = "<ul>";
                                    $.each(response.errors, function(key, value) {
                                        errorString += "<li>" + value + "</li>";
                                    });

                                    $("#error-save").html(errorString);
                                    $("#message-error-save").fadeIn();
                                }
                            });
                        }
                    },
                    error: function(jqXHR, exception) {}
                });
            } else {
                //BANDERA PROFESION
                var bandera_p = $("#bandera_profesion").val();
                //Datos alumno
                var curp = $("#curpStudent").val();
                var name = $("#nameStudent").val();
                var last_name = $("#lastnameStudent").val();
                var mother_last_name = $("#motherlastnameStudent").val();
                var facebook = $("#facebookStudent").val();
                var birthdate = $("#birthdateStudent").val();
                var sex = $("#sexStudent").val();
                var phone = $("#phoneStudent").val();
                var address = $("#addressStudent").val();
                var state = $("#stateStudent").val();
                var city = $("#cityStudent").val();
                var email = $("#emailStudent").val();
                if (bandera_p != 0) {
                    var profession = $("#professionStudentAlt").val();
                } else {
                    var profession = $("#professionStudent").val();
                }

                //Datos diplomado
                var generation_id = $("#generation_id_N").val();
                var discount = $("#discount_N").val();
                var number_payments = $("#number_payments_N").val();
                var amount_of_payments = $("#amount_of_payments_N").val();
                var first_payment = $("#first_payment_N").val();
                var periodicity = $("#periodicity_N").val();
                var account = $("#accountDestination_N").val();
                var account_type = $("#account_type_N").val();
                var payment_method = $("#payment_method_N").val();

                //checkCurp
                var crp = $("#curpStudent").val();
                var route_crp = "/ventas/alumnos/checkCurpTwo/" + crp;

                if (crp != "") {
                    $.get(route_crp, function(res) {
                        if (res.exists != true) {
                            $.ajax({
                                url: route_n,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    //Datos alumno
                                    curp: curp,
                                    name: name,
                                    last_name: last_name,
                                    mother_last_name: mother_last_name,
                                    facebook: facebook,
                                    birthdate: birthdate,
                                    sex: sex,
                                    phone: phone,
                                    address: address,
                                    state: state,
                                    city: city,
                                    email: email,
                                    profession: profession,
                                    //Datos diplomado
                                    generation_id: generation_id,
                                    discount: discount,
                                    number_payments: number_payments,
                                    amount_of_payments: amount_of_payments,
                                    first_payment: first_payment,
                                    periodicity: periodicity,
                                    account: account,
                                    account_type: account_type,
                                    payment_method: payment_method
                                },
                                beforeSend: function() {
                                    $("#preloader").css("display", "block");
                                },
                                success: function() {
                                    $("#preloader").css("display", "none");
                                    $("#modalSale .close").click();
                                    $('#message-error-save-N').css('display', 'none');
                                    reload();
                                    Notiflix.Report.Success('Bien hecho',
                                        'Has guardado a un nuevo estudiante.', 'Click');
                                },
                                error: function(data) {
                                    var response = JSON.parse(data.responseText);
                                    var errorString = "<ul>";
                                    $.each(response.errors, function(key, value) {
                                        errorString += "<li>" + value + "</li>";
                                    });
                                    $("#preloader").css("display", "none");
                                    $("#error-save-N").html(errorString);
                                    $("#message-error-save-N").fadeIn();
                                }
                            });
                        } else {
                            alert('La CURP: ' + res.crp + ' ya se encuentra registrada.');
                        }
                    });
                } else {
                    alert('Por favor llena el campo CURP.');
                }
            }
        });

    </script>
@endsection
