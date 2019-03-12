<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Alumno</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
                    <div id='message-error-edit' class="alert alert-danger alert-dismissible fade show" role='alert' style="display: none">
                        <strong id="error-edit"></strong>
                    </div>
                    <form id="form">
                        <div class="form-row">
                             <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">CURP</label>
                                <input type="text" class="form-control form-control-lg" id="curp" placeholder="Introduce CURP del alumno">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="hidden" id="id">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control form-control-lg" id="name" placeholder="Introduce nombre de alumno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Apellido Paterno</label>
                                <input type="text" class="form-control form-control-lg" id="lastname" placeholder="Introduce apellido paterno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Apellido Materno</label>
                                <input type="text" class="form-control form-control-lg" id="motherlastname" placeholder="Introduce apellido materno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Fecha de Nacimiento</label>
                                <input type="date" class="form-control form-control-lg" id="birthdate" placeholder="Introduce fecha de nacimiento">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Genero</label>
                                 <select name="sex" id="sex" class="form-control form-control-lg">
                                    <option value="H">Hombre</option>
                                    <option value="M">Mujer</option>
                                </select>
                                {{-- <input type="text" class="form-control form-control-lg" id="sex" placeholder="H/M"> --}}
                            </div>

                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Teléfono de Contacto</label>
                                <input type="text" class="form-control form-control-lg" id="phone" placeholder="Introduce teléfono de contacto">
                            </div>
                            <div class="form-group col-md-8">
                                <label for="exampleInputPassword1">Facebook</label>
                                <input type="text" class="form-control form-control-lg" id="facebook" placeholder="Introduce teléfono de contacto">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">¿En que diplomado esta interesado?</label>
                                {{-- <input type="text" class="form-control form-control-lg" id="interestedSave"
                                    placeholder="Introduce el o los diplomados en el que esta interesado"> --}}
                                    <select name="interested" id="interested" class="form-control">
                                        @forelse ($diplomats as $diplomat)
                                        <option value="{{$diplomat->name}}">{{$diplomat->name}}</option> 
                                        @empty
                                        <option value="null">No hay diplomados registrados</option>  
                                        @endforelse
                                    </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Dirección</label>
                                <input type="text" class="form-control form-control-lg" id="address" placeholder="Introduce dirección de alumno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Estado</label>
                                <input type="text" name="state" id="state" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Ciudad</label>
                                <input type="text" name="city" id="city" class="form-control form-control-lg">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-lg" id="email" placeholder="EJ. maria@alumno.com">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Profesión</label>
                                <select name="profession" id="profession" class="form-control form-control-lg">
                                    <option value="null">--Selecciona una profesión--</option>
                                    <option>Lic. en psicología </option>
                                    <option>Estudiante de psicología </option>
                                    <option>Terapeuta (cualquier corriente de formación)</option>
                                    <option>Lic. en pedagogía</option>
                                    <option>Lic. educación preescolar</option>
                                    <option>Maestro/a o docente</option>
                                    <option>Lic. en administración educativa</option>
                                    <option>Terapeuta ocupacional</option>
                                    <option>Terapeuta físico</option>
                                    <option>Educación especial</option>
                                    <option>Médico en Rehabilitación</option>
                                    <option>Lic en desarrollo Humano</option>
                                    <option>Lic en trabajo social</option>
                                    <option>Lic. en educación física</option>
                                    <option>Abogado</option>
                                    <option>Sociólogo</option>
                                    <option>Maestra sombra</option>
                                    <option>Equinoterapeuta</option>
                                    <option>Psicoanalista</option>
                                    <option>Médico pediatra</option>
                                    <option>Médico Familiar</option>
                                    <option>Psiquiatra</option>
                                    <option>Paidopsiquiatra</option>
                                    <option>Neurólogo</option>
                                    <option>Neurólogo infantil</option>
                                    <option>Enfermera con especialidad psiquiátrica</option>
                                    <option>Trabajador social con especialidad psiquiátrica</option>
                                    <option>Médico general</option>
                                    <option>Enfermera general</option>
                                    <option>Otro</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="updateStudent" class="btn btn-primary mt-4 pr-4 pl-4" name="saveDiplomat">Actualizar</a>
            </div>
        </div>
    </div>
</div>
