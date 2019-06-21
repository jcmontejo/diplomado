<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Alumno</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div id='message-error-save' class="alert alert-danger alert-dismissible fade show" role='alert'
                        style="display: none">
                        <strong id="error-save"></strong>
                    </div>
                    <form id="formStudent" enctype="multipart/form-data">
                        <div class="form-row">
                             <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">CURP</label>
                                <input type="text" class="form-control form-control-lg" id="curpSave" placeholder="Introduce CURP del alumno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input type="text" class="form-control form-control-lg" id="nameSave" placeholder="Introduce nombre del alumno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Apellido Paterno</label>
                                <input type="text" class="form-control form-control-lg" id="lastnameSave" placeholder="Introduce apellido paterno">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Apellido Materno</label>
                                <input type="text" class="form-control form-control-lg" id="motherlastnameSave"
                                    placeholder="Introduce apellido materno">
                            </div>
                             <div class="form-group col-md-8">
                                <label for="exampleInputPassword1">Facebook</label>
                                <input type="text" class="form-control form-control-lg" id="facebookSave"
                                    placeholder="Introduce Facebook">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">¿En que diplomado esta interesado?</label>
                                {{-- <input type="text" class="form-control form-control-lg" id="interestedSave"
                                    placeholder="Introduce el o los diplomados en el que esta interesado"> --}}
                                    <select name="interestedSave" id="interestedSave" class="form-control">
                                        @forelse ($diplomats as $diplomat)
                                        <option value="{{$diplomat->name}}">{{$diplomat->name}}</option> 
                                        @empty
                                        <option value="null">No hay diplomados registrados</option>  
                                        @endforelse
                                    </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Fecha de Nacimiento</label>
                                <input type="date" class="form-control form-control-lg" id="birthdateSave" placeholder="Introduce fecha de nacimiento">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Genero</label>
                                <select name="sexSave" id="sexSave" class="form-control form-control-lg">
                                    <option value="H">Hombre</option>
                                    <option value="M">Mujer</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="exampleInputPassword1">Teléfono de Contacto</label>
                                <input type="text" class="form-control form-control-lg" id="phoneSave" placeholder="Introduce teléfono de contacto">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Dirección</label>
                                <input type="text" class="form-control form-control-lg" id="addressSave" placeholder="Introduce dirección de alumno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Estado</label>
                                <select name="stateSave" id="stateSave" class="form-control form-control-lg">

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Ciudad</label>
                                <select name="citySave" id="citySave" class="form-control form-control-lg">

                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Correo Electrónico</label>
                                <input type="email" class="form-control form-control-lg" id="emailSave" placeholder="EJ. maria@alumno.com">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Profesión</label>
                                <select name="professionSave" id="professionSave" class="form-control form-control-lg">
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
                            <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">SEMAFORO</label>
                                <select name="" id="statusSave" class="form-control form-control-lg">
                                  <option value="10">10%</option>
                                  <option value="20">20%</option>
                                  <option value="30">30%</option>
                                  <option value="40">40%</option>
                                  <option value="50">50%</option>
                                  <option value="60">60%</option>
                                  <option value="70">70%</option>
                                  <option value="80">80%</option>
                                  <option value="90">90%</option>
                                  <option value="100">100%</option>
                                  <option value="110">110%</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mt-4 pr-4 pl-4" data-dismiss="modal">Cerrar</button>
                <a href="#" id="saveStudent" class="btn btn-primary mt-4 pr-4 pl-4" name="saveDiplomat">Guardar</a>
            </div>
        </div>
    </div>
</div>
