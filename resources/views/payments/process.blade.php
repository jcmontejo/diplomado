@extends('layouts.master')
@section('title')
Procesar Pago
@endsection
@section('header-1')
Procesar Pago
@endsection
@section('header-2')
Procesar Pago
@endsection
@section('content')
<div class="row">
    <!-- data table start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Recibir Nuevo Pago</h4>
                <div id="msj-success" class="alert alert-success alert-dismissible" role="alert" style="display:none">
                    <strong>Alumno Actualizado Correctamente.</strong>
                </div>
                <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                    <strong id="error-save"></strong>
                </div>
                <form id="form">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <input type="hidden" id="id">
                            <label for="exampleInputEmail1">Selecciona Diplomado</label>
                            <select name="diplomat_id" id="diplomat_id" class="form-control form-control-lg">
                                <option value="">--- Selecciona Diplomado ---</option>
                                @forelse ($diplomats as $diplomat)
                                <option value="{{$diplomat->id}}">{{$diplomat->name}}</option>
                                @empty
                                <option value="0">No hay diplomados registrados.</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Selecciona Generación</label>
                            <select name="generation_id" id="generation_id" class="form-control form-control-lg">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Selecciona Alumno</label>
                            <select name="student_id" id="student_id" class="form-control form-control-lg">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputPassword1">Fecha de Pago</label>
                            <input type="date" class="form-control form-control-lg" id="date">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="exampleInputPassword1">Observaciones</label>
                            <input type="text" class="form-control form-control-lg" id="observation">
                        </div>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table class="table">
                                        <thead style="background:#dce9f9;">
                                            <th>Tipo de Cuota</th>
                                            <th style="text-align:left">Monto $</th>
                                            <th style="text-align:left">Descuento $</th>
                                            <th style="text-align:left">Total $</th>
                                        </thead>
                                        <tbody id="invoice">
                                            <tr>
                                                <td width="40%">
                                                    <select name='fee_type' class='form-control form-control-lg'>
                                                        @forelse ($types as $type)
                                                        <option value="{{$type->id}}">{{$type->account_type}}</option>
                                                        @empty
                                                        <option>No hay tipos de cuotas registradas.</option>
                                                        @endforelse
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="amount form-control form-control-lg" name="amount"
                                                        value="0" required>
                                                </td>
                                                <td><input type="text" class="discount form-control form-control-lg"
                                                        name="discount" value="0" required>
                                                </td>
                                                <td>
                                                    <input type="text" class="sub_total form-control form-control-lg"
                                                        name="sub_total" value="0" readOnly="true" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="#" id="updateProfile" class="btn btn-info mt-4 pr-4 pl-4" name="updateProfile">Procesar
                            Pago</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- data table end -->
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('select[name="diplomat_id"]').on('change', function () {
            var diplomatID = $(this).val();
            if (diplomatID) {
                $.ajax({
                    url: '/pagos/generaciones/' + diplomatID,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        $("#preloader").css("display", "block");
                    },
                    success: function (data) {
                        $("#preloader").css("display","none");
                        $('select[name="generation_id"]').empty();
                        $.each(data, function (key, value) {
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

        $('select[name="generation_id"]').on('change', function () {
            var generationID = $(this).val();
            if (generationID) {
                $.ajax({
                    url: '/pagos/generaciones/alumnos/' + generationID,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function () {
                        $("#preloader").css("display", "block");
                    },
                    success: function (data) {
                        $("#preloader").css("display","none");
                        $('select[name="student_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="student_id"]').append('<option value="' +
                                key +
                                '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="student_id"]').empty();
            }
        });

        $(document).on('keyup', '.amount,.discount', function () {
            var amount = parseFloat($(this).closest("tr").find(".amount").val());
            var discount = parseFloat($(this).closest("tr").find(".discount").val());
            $(this).closest("tr").find(".sub_total").val(amount - discount);

            //Show Total Amount
            var total = 0;
            var sub_total = parseFloat($(this).find(".total").val());
            total += sub_total;

            $("#total").val(total);
        });
    });

</script>
@endsection
