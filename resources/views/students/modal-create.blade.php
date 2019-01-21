<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Alumno</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-lg-6 col-ml-12">
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
                                <label for="exampleInputPassword1">¿En que diplomados esta interesado?</label>
                                <input type="text" class="form-control form-control-lg" id="interestedSave"
                                    placeholder="Introduce el o los diplomados en el que esta interesado">
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
                                    <option>INGENIERÍA EN AERONÁUTICA</option>
                                    <option>ARQUITECTO</option>
                                    <option>ARQUITECTO PAISAJISTA</option>
                                    <option>ARQUITECTO URBANISTA</option>
                                    <option>ARQUITECTURA</option>
                                    <option>ARQUITECTURA DE INTERIORES</option>
                                    <option>ARQUITECTURA Y ADMINISTRACIÓN DE LA CONSTRUCCIÓN</option>
                                    <option>ARQUITECTURA Y PAISAJISMO</option>
                                    <option>INGENIERO ARQUITECTO</option>
                                    <option>LICENCIATURA EN ARQUITECTURA</option>
                                    <option>LICENCIATURA EN ARQUITECTURA DE PAISAJE</option>
                                    <option>LICENCIATURA EN URBANISMO</option>
                                    <option>LICENCIATURA EN URBANÍSTICA Y MEDIO AMBIENTE</option>
                                    <option>PROFESIONAL ASOCIADO EN DISEÑO ARQUITECTÓNICO</option>
                                    <option>INGENIERO BIOMÉDICO</option>
                                    <option>INGENIERO BIÓNICO</option>
                                    <option>INGENIERO BIOTECNÓLOGO</option>
                                    <option>INGENIERO BIOTECNÓLOGO ACUÍCOLA</option>
                                    <option>INGENIERO BIOTECNÓLOGO AMBIENTAL</option>
                                    <option>INGENIERO EN BIOTECNOLOGÍ </option>
                                    <option>INGENIERÍA EN GEOCIENCIAS</option>
                                    <option>INGENIERÍA EN GEOFÍSICA</option>
                                    <option>INGENNIERÍA EN GEOLOGÍA MINERA</option>
                                    <option>INGENIERÍA EN GEOMÁTICA</option>
                                    <option>INGENIERO GEODÉSICO</option>
                                    <option>INGENIERO GEOFÍSICO</option>
                                    <option>INGENIERO GEÓLOGO</option>
                                    <option>INGENIERO GEÓLOGO EN HIDROLOGÍA</option>
                                    <option>INGENIERO GEÓLOGO MINERALOGISTA</option>
                                    <option>LICENCIATURA EN GEOCIENCIAS</option>
                                    <option>LICENCIATURA EN GEOFÍSICA </option>
                                    <option>INGENIERO NAVAL</option>
                                    <option>LICENCIATURA EN CIENCIAS NAVALES</option>
                                    <option>PILOTO NAVAL</option>
                                    <option>PILOTO NAVAL / INGENIERO GEÓGRAFO HIDRÓGRAFO</option>
                                    <option>INGENIERÍA CIBERNÉTICA</option>
                                    <option>INGENIERÍA CIBERNÉTICA ELECTRÓNICA</option>
                                    <option>INGENIERO CIBERNÉTICO Y EN SISTEMAS COMPUTACIONALES</option>
                                    <option>INGENIERÍA COMPUTACIONAL</option>
                                    <option>INGENIERÍA DE SOFTWARE</option>
                                    <option>INGENIERÍA EN CIBERNÉTICA</option>
                                    <option>INGENIERÍA EN CIBERNÉTICA ELECTRÓNICA</option>
                                    <option>INGENIERÍA EN CIENCIAS COMPUTACIONALES</option>
                                    <option>INGENIERÍA EN CIENCIAS COMPUTACIONALES Y TELECOMUNICACIONES</option>
                                    <option>INGENIERÍA EN CIENCIAS DE LA COMPUTACIÓN</option>
                                    <option>INGENIERÍA EN COMPUTACIÓN</option>
                                    <option>INGENIERÍA EN COMPUTACIÓN E INFORMÁTICA</option>
                                    <option>INGENIERÍA EN COMPUTACIÓN ESPECIALIDAD SOFTWARE DE SISTEMAS</option>
                                    <option>INGENIERÍA EN COMPUTACIÓN FINANCIERA</option>
                                    <option>INGENIERÍA EN COMPUTACIÓN Y ELECTRÓNICA</option>
                                    <option>INGENIERÍA EN COMPUTACIÓN Y REDES DE COMPUTADORAS</option>
                                    <option>INGENIERÍA EN COMPUTACIÓN Y SISTEMAS</option>
                                    <option>INGENIERÍA EN COMPUTACIÓN Y SISTEMAS DIGITALES</option>
                                    <option>INGENIERÍA EN DESARROLLO DE APLICACIONES COMPUTACIONALES</option>
                                    <option>INGENIERÍA EN DESARROLLO DE SOFTWARE</option>
                                    <option>INGENIERÍA EN INFORMÁTICA</option>
                                    <option>INGENIERÍA EN INFORMÁTICA ADMINISTRATIVA</option>
                                    <option>INGENIERÍA EN INFORMÁTICA CORPORATIVA</option>
                                    <option>INGENIERÍA EN PROGRAMACIÓN DE VIDEOJUEGOS</option>
                                    <option>INGENIERÍA EN REDES COMPUTACIONALES</option>
                                    <option>INGENIERÍA EN SEGURIDAD COMPUTACIONAL</option>
                                    <option>INGENIERÍA EN SISTEMAS</option>
                                    <option>INGENIERÍA EN SISTEMAS ADMINISTRATIVOS</option>
                                    <option>INGENIERÍA EN SISTEMAS COMPUTACIONALES</option>
                                    <option>INGENIERÍA EN SISTEMAS COMPUTACIONALES ADMINISTRATIVOS</option>
                                    <option>INGENIERÍA EN SISTEMAS COMPUTACIONALES ÁREA SISTEMAS DE INFORMACIÓN</option>
                                    <option>INGENIERÍA EN SISTEMAS COMPUTACIONALES ÁREA TELEINFORMÁTICA</option>
                                    <option>INGENIERÍA EN SISTEMAS COMPUTACIONALES EN HARDWARE</option>
                                    <option>INGENIERÍA EN SISTEMAS COMPUTACIONALES EN SOFTWARE</option>
                                    <option>INGENIERÍA EN SISTEMAS COMPUTACIONALES Y ELECTRÓNICOS</option>
                                    <option>INGENIERÍA EN SISTEMAS COMPUTACIONALES Y TELEMÁTICA</option>
                                    <option>INGENIERÍA EN SISTEMAS COMPUTARIZADOS E INFORMÁTICA</option>
                                    <option>INGENIERÍA EN SISTEMAS DE CALIDAD</option>
                                    <option>INGENIERÍA EN SISTEMAS DE COMPUTACIÓN ADMINISTRATIVA</option>
                                    <option>INGENIERÍA EN SISTEMAS DE INFORMACIÓN</option>
                                    <option>INGENIERÍA EN SISTEMAS DE INFORMACIÓN ADMINISTRATIVA</option>
                                    <option>INGENIERÍA EN SISTEMAS DE INFORMACIÓN GEOGRÁFICA</option>
                                    <option>INGENIERÍA EN SISTEMAS DE MERCADOTECNIA</option>
                                    <option>INGENIERÍA EN SISTEMAS DE TELECOMUNICACIONES</option>
                                    <option>INGENIERÍA EN SISTEMAS DIGITALES</option>
                                    <option>INGENIERÍA EN SISTEMAS DIGITALES Y COMUNICACIONES</option>
                                    <option>INGENIERÍA EN SISTEMAS DIGITALES Y TELECOMUNICACIONES</option>
                                    <option>INGENIERÍA EN SISTEMAS Y COMUNICACIONES</option>
                                    <option>INGENIERÍA EN SISTEMAS Y TECNOLOGÍAS DE INFORMACIÓN</option>
                                    <option>INGENIERÍA EN SISTEMAS Y TECNOLOGÍAS INDUSTRIALES</option>
                                    <option>INGENIERÍA EN SOFTWARE Y TECNOLOGÍAS DE CÓMPUTO</option>
                                    <option>INGENIERÍA EN TECNOLOGÍA DEPORTIVA</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS COMPUTACIONALES</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS DE INFORMACIÓN Y COMUNICACIONES</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS DE INFORMACIÓN Y TELECOMUNICACIONES</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS DE INTERNET</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS DE LA INFORMÁTICA</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS DE LA INFORMÁTICA Y LA COMPUTACIÓN</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS DE MANUFACTURA</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS DEL CONOCIMIENTO</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS ESTRATÉGICAS DE INFORMACIÓN</option>
                                    <option>INGENIERÍA EN TELEINFORMÁTICA</option>
                                    <option>LICENCIATURA EN ADMINISTRACIÓN DE COMPUTACIÓN</option>
                                    <option>LICENCIATURA EN ANIMACIÓN 3D Y EFECTOS VISUALES</option>
                                    <option>LICENCIATURA EN ANIMACIÓN DIGITAL</option>
                                    <option>LICENCIATURA EN CIENCIAS COMPUTACIONALES</option>
                                    <option>LICENCIATURA EN CIENCIAS DE LA COMPUTACIÓN</option>
                                    <option>LICENCIATURA EN CIENCIAS DE LA INFORMÁTICA</option>
                                    <option>LICENCIATURA EN CIENCIAS EN COMPUTACIÓN</option>
                                    <option>LICENCIATURA EN CIENCIAS GEOINFORMÁTICAS</option>
                                    <option>LICENCIATURA EN COMPUTACIÓN</option>
                                    <option>LICENCIATURA EN COMPUTACIÓN ADMINISTRATIVA</option>
                                    <option>LICENCIATURA EN COMPUTACIÓN FINANCIERA</option>
                                    <option>LICENCIATURA EN COMPUTACIÓN Y SISTEMAS</option>
                                    <option>LICENCIATURA EN DESARROLLO COMPUTACIONAL</option>
                                    <option>LICENCIATURA EN DESARROLLO DE SOFTWARE</option>
                                    <option>LICENCIATURA EN INFORMÁTICA</option>
                                    <option>LICENCIATURA EN INFORMÁTICA ADMINISTRATIVA</option>
                                    <option>LICENCIATURA EN INFORMÁTICA ADMINISTRATIVA Y FINANCIERA</option>
                                    <option>LICENCIATURA EN INFORMÁTICA CONTABLE</option>
                                    <option>LICENCIATURA EN INFORMÁTICA EMPRESARIAL</option>
                                    <option>LICENCIATURA EN INFORMÁTICA ESPECIALIDAD REDES</option>
                                    <option>LICENCIATURA EN INFORMÁTICA FINANCIERA</option>
                                    <option>LICENCIATURA EN INFORMÁTICA INDUSTRIAL</option>
                                    <option>LICENCIATURA EN INFORMÁTICA PARA NEGOCIOS</option>
                                    <option>LICENCIATURA EN INFORMÁTICA Y ADMINISTRACIÓN </option>
                                    <option>LICENCIATURA EN INFORMÁTICA Y CONTABILIDAD </option>
                                    <option>LICENCIATURA EN INGENIERÍA EN SISTEMAS Y TELEMÁTICA</option>
                                    <option>LICENCIATURA EN PRODUCCIÓN MULTIMEDIA</option>
                                    <option>LICENCIATURA EN SISTEMAS ADMINISTRATIVOS COMPUTACIONALES</option>
                                    <option>LICENCIATURA EN SISTEMAS AUTOMATIZADOS PARA LA ADMINISTRACIÓN</option>
                                    <option>LICENCIATURA EN SISTEMAS COMPUTACIONALES</option>
                                    <option>LICENCIATURA EN SISTEMAS COMPUTACIONALES ADMINISTRATIVOS</option>
                                    <option>LICENCIATURA EN SISTEMAS COMPUTACIONALES Y TECNOLOGÍAS DE LA INFORMACIÓN</option>
                                    <option>LICENCIATURA EN SISTEMAS COMPUTARIZADOS E INFORMÁTICA</option>
                                    <option>LICENCIATURA EN SISTEMAS DE COMPUTACIÓN ADMINISTRATIVA</option>
                                    <option>LICENCIATURA EN SISTEMAS DE INFORMACIÓN</option>
                                    <option>LICENCIATURA EN SISTEMAS DE INFORMACIÓN ADMINISTRATIVA</option>
                                    <option>LICENCIATURA EN SISTEMAS DE TECNOLOGÍAS Y DE LA INFORMACIÓN</option>
                                    <option>LICENCIATURA EN SISTEMAS ESPECIALIDAD ADMINISTRACIÓN</option>
                                    <option>LICENCIATURA EN SISTEMAS INFORMÁTICOS</option>
                                    <option>LICENCIATURA EN SISTEMAS MULTIMEDIA</option>
                                    <option>LICENCIATURA EN SISTEMAS, INFORMÁTICA Y AUDITORÍA</option>
                                    <option>LICENCIATURA EN TECNOLOGÍA DE LA INFORMACIÓN</option>
                                    <option>LICENCIATURA EN TECNOLOGÍA DE LA INFORMACIÓN Y COMUNICACIONES</option>
                                    <option>LICENCIATURA EN TECNOLOGÍA EDUCATIVA</option>
                                    <option>LICENCIATURA EN TECNOLOGÍAS DE INFORMACIÓN</option>
                                    <option>LICENCIATURA EN TECNOLOGÍAS DE INFORMACIÓN Y NEGOCIOS</option>
                                    <option>LICENCIATURA EN TECNOLOGÍAS DE INFORMACIÓN Y TELECOMUNICACIONES</option>
                                    <option>LICENCIATURA EN TECNOLOGÍAS DE LA INFORMACIÓN</option>
                                    <option>LICENCIATURA EN TECNOLOGÍAS Y SISTEMAS DE INFORMACIÓN</option>
                                    <option>LICENCIATURA EN TELEINFORMÁTICA</option>
                                    <option>PROFESIONAL ASOCIADO EN INFORMÁTICA ADMINISTRATIVA</option>
                                    <option>PROFESIONAL ASOCIADO EN PRODUCCIÓN MULTIMEDIA</option>
                                    <option>PROFESIONAL ASOCIADO EN PRODUCCIÓN MULTIMEDIA EDUCATIVA</option>
                                    <option>TÉCNICO SUPERIOR EN COMPUTACIÓN ADMINISTRATIVA</option>
                                    <option>TÉCNICO SUPERIOR EN PROGRAMACIÓN</option>
                                    <option>INGENIERÍA EN DISEÑO GRÁFICO DIGITAL</option>
                                    <option>LICENCIATURA EN DECORACIÓN DE INTERIORES</option>
                                    <option>LICENCIATURA EN DECORACIÓN DE INTERIORES Y PAISAJISMO</option>
                                    <option>LICENCIATURA EN DISEÑO</option>
                                    <option>LICENCIATURA EN DISEÑO AMBIENTAL</option>
                                    <option>LICENCIATURA EN DISEÑO ARQUITECTÓNICO Y DE INTERIORES</option>
                                    <option>LICENCIATURA EN DISEÑO ARQUITECTÓNICO Y DECORACIÓN DE INTERIORES</option>
                                    <option>LICENCIATURA EN DISEÑO ARTESANAL</option>
                                    <option>LICENCIATURA EN DISEÑO CON PIEDRAS Y METALES FINOS</option>
                                    <option>LICENCIATURA EN DISEÑO DE INFORMACIÓN</option>
                                    <option>LICENCIATURA EN DISEÑO DE INFORMACIÓN VISUAL</option>
                                    <option>LICENCIATURA EN DISEÑO DE INFORMACIÓN Y MEDIOS DIGITALES</option>
                                    <option>LICENCIATURA EN DISEÑO DE INTERIORES</option>
                                    <option>LICENCIATURA EN DISEÑO DE INTERIORES Y AMBIENTACIÓN</option>
                                    <option>LICENCIATURA EN DISEÑO DE INTERIORES Y PAISAJISMO</option>
                                    <option>LICENCIATURA EN DISEÑO DE LA COMUNICACIÓN GRÁFICA</option>
                                    <option>LICENCIATURA EN DISEÑO DE LA COMUNICACIÓN VISUAL</option>
                                    <option>LICENCIATURA EN DISEÑO DE LA MODA E INDUSTRIA DEL VESTIDO</option>
                                    <option>LICENCIATURA EN DISEÑO DE LA MODA EN INDUMENTARIA Y TEXTILES</option>
                                    <option>LICENCIATURA EN DISEÑO DE LA MODA INTERNACIONAL</option>
                                    <option>LICENCIATURA EN DISEÑO DE MOBILIARIO Y PRODUCTO</option>
                                    <option>LICENCIATURA EN DISEÑO DE MODA INTERNACIONAL</option>
                                    <option>LICENCIATURA EN DISEÑO DE MODAS</option>
                                    <option>LICENCIATURA EN DISEÑO DE MODAS Y CALZADO</option>
                                    <option>LICENCIATURA EN DISEÑO DE MODAS Y TEXTILES</option>
                                    <option>LICENCIATURA EN DISEÑO DE PRODUCTOS</option>
                                    <option>LICENCIATURA EN DISEÑO DE SISTEMAS MULTIMEDIA</option>
                                    <option>LICENCIATURA EN DISEÑO DIGITAL INTERACTIVO</option>
                                    <option>LICENCIATURA EN DISEÑO E INDUSTRIA DEL VESTIDO</option>
                                    <option>LICENCIATURA EN DISEÑO GRÁFICO</option>
                                    <option>LICENCIATURA EN DISEÑO GRÁFICO DIGITAL</option>
                                    <option>LICENCIATURA EN DISEÑO GRÁFICO INDUSTRIAL</option>
                                    <option>LICENCIATURA EN DISEÑO GRÁFICO PUBLICITARIO</option>
                                    <option>LICENCIATURA EN DISEÑO GRÁFICO PÚBLICO</option>
                                    <option>LICENCIATURA EN DISEÑO GRÁFICO Y VISUAL</option>
                                    <option>LICENCIATURA EN DISEÑO INDUSTRIAL</option>
                                    <option>LICENCIATURA EN DISEÑO INTEGRAL</option>
                                    <option>LICENCIATURA EN DISEÑO INTERACTIVO</option>
                                    <option>LICENCIATURA EN DISEÑO MECÁNICO INDUSTRIAL</option>
                                    <option>LICENCIATURA EN DISEÑO PARA LA COMUNICACIÓN GRÁFICA</option>
                                    <option>LICENCIATURA EN DISEÑO PARA LA INNOVACIÓN ARTESANAL</option>
                                    <option>LICENCIATURA EN DISEÑO PUBLICITARIO</option>
                                    <option>LICENCIATURA EN DISEÑO TEXTIL</option>
                                    <option>LICENCIATURA EN DISEÑO TEXTIL Y CREACIÓN DE MODA</option>
                                    <option>LICENCIATURA EN DISEÑO TEXTIL Y MODA</option>
                                    <option>LICENCIATURA EN DISEÑO URBANO AMBIENTAL</option>
                                    <option>LICENCIATURA EN DISEÑO Y COMUNICACIÓN GRÁFICA</option>
                                    <option>LICENCIATURA EN DISEÑO Y COMUNICACIÓN VISUAL</option>
                                    <option>LICENCIATURA EN DISEÑO Y COMUNICACIÓN VISUAL CON ORIENTACIÓN EN AUDIOVISUAL
                                        Y MULTIMEDIA</option>
                                    <option>LICENCIATURA EN DISEÑO Y COMUNICACIÓN VISUAL CON ORIENTACIÓN EN DISEÑO
                                        EDITORIAL</option>
                                    <option>LICENCIATURA EN DISEÑO Y COMUNICACIÓN VISUAL CON ORIENTACIÓN EN FOTOGRAFÍA</option>
                                    <option>LICENCIATURA EN DISEÑO Y COMUNICACIÓN VISUAL CON ORIENTACIÓN EN ILUSTRACIÓN</option>
                                    <option>LICENCIATURA EN DISEÑO Y COMUNICACIÓN VISUAL CON ORIENTACIÓN EN SOPORTES
                                        TRIDIMENSIONALES</option>
                                    <option>LICENCIATURA EN DISEÑO Y MERCADOTÉCNIA DE LA MODA</option>
                                    <option>LICENCIATURA EN DISEÑO Y PRODUCCIÓN DEL VESTIDO</option>
                                    <option>LICENCIATURA EN DISEÑO Y PRODUCCIÓN PUBLICITARIA</option>
                                    <option>LICENCIATURA EN DISEÑO Y PUBLICIDAD EN MODA</option>
                                    <option>LICENCIATURA EN ILUSTRACIÓN GRÁFICA</option>
                                    <option>LICENCIATURA EN MODA E INDUSTRIA DEL VESTIDO</option>
                                    <option>LICENCIATURA EN MODA Y CREACIÓN</option>
                                    <option>PROFESIONAL ASOCIADO EN DISEÑO DE MODAS</option>
                                    <option>INGENIERÍA AMBIENTAL</option>
                                    <option>INGENIERO ECÓLOGO</option>
                                    <option>INGENIERÍA EN CIENCIAS AMBIENTALES</option>
                                    <option>INGENIERÍA EN CONTROL AMBIENTAL Y ECOLOGÍA</option>
                                    <option>INGENIERÍA EN DESARROLLO SUSTENTABLE</option>
                                    <option>INGENIERÍA EN ECOLOGÍA</option>
                                    <option>INGENIERÍA EN MANEJO DE RECURSOS NATURALES</option>
                                    <option>INGENIERÍA EN MANEJO DE RECURSOS NATURALES EN CONSERVACIÓN DE RECURSOS
                                        NATURALES</option>
                                    <option>INGENIERÍA EN MANEJO DE RECURSOS NATURALES EN FAUNA SILVESTRE</option>
                                    <option>INGENIERÍA EN MANEJO DE RECURSOS NATURALES EN SILVICULTURA Y ECOLOGÍA DE
                                        BOSQUES</option>
                                    <option>INGENIERÍA EN PROCESOS AMBIENTALES</option>
                                    <option>INGENIERÍA EN SISTEMAS AMBIENTALES</option>
                                    <option>LICENCIATURA EN EL AGUA Y EL AMBIENTE</option>
                                    <option>PROFESIONAL ASOCIADO EN TECNOLOGÍA AMBIENTAL</option>
                                    <option>INGENIERO BIOQUÍMICO</option>
                                    <option>INGENIERO BIOQUÍMICO AMBIENTAL</option>
                                    <option>INGENIERO BIOQUÍMICO EN ALIMENTOS</option>
                                    <option>INGENIERO BIOQUÍMICO EN FERMENTACIONES</option>
                                    <option>INGENIERO BIOQUÍMICO INDUSTRIAL</option>
                                    <option>INGENIERÍA CIVIL</option>
                                    <option>INGENIERO CIVIL ADMINISTRADOR</option>
                                    <option>INGENIERÍA CIVIL AMBIENTAL</option>
                                    <option>INGENIERÍA CIVIL EN ESTRUCTURAS</option>
                                    <option>INGENIERÍA CIVIL PARA LA DIRECCIÓN</option>
                                    <option>INGENIERO CONSTRUCTOR</option>
                                    <option>INGENIERÍA EN OBRAS Y SERVICIOS</option>
                                    <option>LICENCIATURA EN EDIFICACIÓN Y ADMINISTRACIÓN DE OBRAS</option>
                                    <option>LICENCIATURA EN INGENIERÍA DE CONSTRUCCIÓN</option>
                                    <option>INGENIERÍA EN SISTEMAS DE TRANSPORTE URBANO</option>
                                    <option>INGENIERÍA EN TRANSPORTE</option>
                                    <option>INGENIERO ELECTRICISTA</option>
                                    <option>INGENIERO ELECTRICISTA ADMINISTRADOR</option>
                                    <option>INGENIERO ELECTRICISTA EN DISEÑO Y MANUFACTURA</option>
                                    <option>INGENIERO ELECTRICISTA EN SISTEMAS ELÉCTRICOS</option>
                                    <option>INGENIERO ELÉCTRICO</option>
                                    <option>INGENIERO ELÉCTRICO ELECTRÓNICO</option>
                                    <option>INGENIERO ELÉCTRICO Y COMUNICACIONES</option>
                                    <option>INGENIERO ELÉCTRICO Y ELECTRÓNICO</option>
                                    <option>INGENIERO ELÉCTRICO Y EN SISTEMAS ELECTRÓNICOS</option>
                                    <option>INGENIERO ELÉCTRICO Y MECÁNICO</option>
                                    <option>INGENIERO ELÉCTRICO Y TELECOMUNICACIONES</option>
                                    <option>INGENIERO ELECTRÓNICO</option>
                                    <option>INGENIERO ELECTRÓNICO AUTOMOTRIZ</option>
                                    <option>INGENIERO ELECTRÓNICO BIOMÉDICO</option>
                                    <option>INGENIERO ELECTRÓNICO E INSTRUMENTACIÓN</option>
                                    <option>INGENIERO ELECTRÓNICO EN COMPUTACIÓN</option>
                                    <option>INGENIERO ELECTRÓNICO EN MANUFACTURA</option>
                                    <option>INGENIERO ELECTRÓNICO EN TELEMÁTICA</option>
                                    <option>INGENIERO ELECTRÓNICO ESPECIALIDAD INSTRUMENTACION BIOMÉDICA</option>
                                    <option>INGENIERO ELECTRÓNICO INDUSTRIAL</option>
                                    <option>INGENIERO ELECTRÓNICO Y AUTOMATIZACIÓN</option>
                                    <option>INGENIERO ELECTRÓNICO Y COMUNICACIONES NAVALES</option>
                                    <option>INGENIERO ELECTRÓNICO Y CONTROL</option>
                                    <option>INGENIERO ELECTRÓNICO Y DE COMUNICACIONES</option>
                                    <option>INGENIERO ELECTRÓNICO Y SISTEMAS DIGITALES</option>
                                    <option>INGENIERO ELECTRÓNICO Y SISTEMAS INTELIGENTES</option>
                                    <option>INGENIERO ELECTRÓNICO Y TELECOMUNICACIONES</option>
                                    <option>INGENIERÍA EN COMUNICACIONES</option>
                                    <option>INGENIERÍA EN COMUNICACIONES Y ELECTRÓNICA</option>
                                    <option>INGENIERÍA EN COMUNICACIONES Y ELECTRÓNICA EN ACÚSTICA</option>
                                    <option>INGENIERÍA EN COMUNICACIONES Y ELECTRÓNICA EN COMPUTACIÓN</option>
                                    <option>INGENIERÍA EN COMUNICACIONES Y ELECTRÓNICA EN COMUNICACIONES</option>
                                    <option>INGENIERÍA EN COMUNICACIONES Y ELECTRÓNICA EN CONTROL</option>
                                    <option>INGENIERÍA EN COMUNICACIONES Y ELECTRÓNICA EN ELECTRÓNICA</option>
                                    <option>INGENIERÍA EN ELECTRICIDAD</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA DE POTENCIA</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA E INDUSTRIAL</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA INDUSTRIAL</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA MÉDICA</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA Y AUTOMATIZACIÓN</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA Y COMPUTACIÓN</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA Y COMPUTADORAS</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA Y COMUNICACIONES</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA Y CONTROL</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA Y DE COMUNICACIONES</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA Y SISTEMAS DIGITALES</option>
                                    <option>INGENIERÍA EN ELECTRÓNICA Y TELECOMUNICACIONES</option>
                                    <option>INGENIERÍA EN SISTEMAS ELECTRÓNICOS</option>
                                    <option>INGENIERÍA EN SISTEMAS ELECTRÓNICOS INDUSTRIALES</option>
                                    <option>INGENIERÍA EN SISTEMAS ELECTRÓNICOS Y DE TELECOMUNICACIONES</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS ELECTRÓNICAS</option>
                                    <option>LICENCIATURA EN ELECTRÓNICA</option>
                                    <option>LICENCIATURA EN TECNOLOGÍA EN ELECTRÓNICA</option>
                                    <option>INGENIERÍA EN AUTOMATIZACIÓN</option>
                                    <option>INGENIERÍA EN AUTOMATIZACIÓN DE SISTEMAS</option>
                                    <option>INGENIERÍA EN AUTOMATIZACIÓN Y CONTROL INDUSTRIAL</option>
                                    <option>INGENIERÍA EN CONTROL E INSTRUMENTACIÓN</option>
                                    <option>INGENIERÍA EN CONTROL Y AUTOMATIZACIÓN</option>
                                    <option>INGENIERÍA EN CONTROL Y COMPUTACIÓN</option>
                                    <option>INGENIERÍA EN INSTRUMENTACIÓN ELECTRÓNICA</option>
                                    <option>INGENIERÍA EN INSTRUMENTACIÓN Y CONTROL</option>
                                    <option>INGENIERÍA EN ROBÓTICA INDUSTRIAL</option>
                                    <option>INGENIERÍA EN SISTEMAS Y AUTOMATIZACIÓN</option>
                                    <option>INGENIERÍA EN REDES Y TELECOMUNICACIONES</option>
                                    <option>INGENIERÍA EN TELECOMUNICACIONES</option>
                                    <option>INGENIERÍA EN TELECOMUNICACIONES Y ELECTRÓNICA</option>
                                    <option>INGENIERÍA EN TELEMÁTICA</option>
                                    <option>INGENIERO TELEMÁTICO</option>
                                    <option>INGENIERÍA EN ENERGÍA</option>
                                    <option>INGENIERÍA EN SISTEMAS DE ENERGÍA</option>
                                    <option>INGENIERÍA DE MINAS</option>
                                    <option>INGENIERÍA DE MINAS Y METALURGIA</option>
                                    <option>INGENIERÍA DE MINAS Y METALURGISTA</option>
                                    <option>INGENIERÍA EN METALURGIA Y MATERIALES</option>
                                    <option>INGENIERÍA EN METALÚRGICA Y MATERIALES EN INGENIERÍA DE MATERIALES</option>
                                    <option>INGENIERÍA EN METALÚRGICA Y MATERIALES EN PROCESAMIENTO DE MATERIALES</option>
                                    <option>INGENIERÍA EN MINAS Y METALURGISTA</option>
                                    <option>INGENIERO METALÚRGICO</option>
                                    <option>INGENIERÍA METALURGISTA</option>
                                    <option>INGENIERÍA METALURGISTA Y DE MATERIALES</option>
                                    <option>INGENIERO MINERO</option>
                                    <option>INGENIERO MINERO METALÚRGICO</option>
                                    <option>INGENIERO MINERO METALURGISTA</option>
                                    <option>INGENIERO PETROLERO</option>
                                    <option>INGENIERÍA DE MATERIALES</option>
                                    <option>INGENIERÍA EN CIENCIA DE LOS MATERIALES</option>
                                    <option>INGENIERÍA EN CIENCIAS DE LOS MATERIALES</option>
                                    <option>INGENIERÍA EN NANOTECNOLOGÍA E INGENIERÍA MOLECULAR</option>
                                    <option>INGENIERO FÍSICO</option>
                                    <option>INGENIERO FÍSICO INDUSTRIAL</option>
                                    <option>INGENIERÍA HIDRÁULICA</option>
                                    <option>INGENIERÍA DE MANTENIMIENTO Y SEGURIDAD INDUSTRIAL</option>
                                    <option>INGENIERÍA EN ADMINISTRACIÓN DE LA MANUFACTURA</option>
                                    <option>INGENIERÍA EN CALIDAD Y PRODUCTIVIDAD</option>
                                    <option>INGENIERÍA EN CONTROL DE CALIDAD Y SISTEMAS</option>
                                    <option>INGENIERÍA EN MANTENIMIENTO INDUSTRIAL</option>
                                    <option>INGENIERÍA EN MANUFACTURA</option>
                                    <option>INGENIERÍA EN PROCESOS DE MANUFACTURA</option>
                                    <option>INGENIERÍA EN PRODUCCIÓN</option>
                                    <option>INGENIERÍA EN ROBÓTICA INDUSTRIAL</option>
                                    <option>INGENIERÍA EN SISTEMAS DE LOGÍSTICA</option>
                                    <option>INGENIERÍA EN SISTEMAS DE PRODUCCIÓN</option>
                                    <option>INGENIERÍA EN SISTEMAS INTEGRADOS Y DE MANUFACTURA</option>
                                    <option>INGENIERÍA INDUSTRIAL</option>
                                    <option>INGENIERÍA INDUSTRIAL ADMINISTRADOR</option>
                                    <option>INGENIERÍA INDUSTRIAL ADMINISTRATIVA</option>
                                    <option>INGENIERÍA INDUSTRIAL ELÉCTRICO</option>
                                    <option>INGENIERÍA INDUSTRIAL EN ADMINISTRACIÓN AMBIENTAL</option>
                                    <option>INGENIERÍA INDUSTRIAL EN ALIMENTOS</option>
                                    <option>INGENIERÍA INDUSTRIAL EN AUTOMATIZACIÓN ELECTRÓNICA</option>
                                    <option>INGENIERÍA INDUSTRIAL EN AUTOMATIZACIÓN, ELECTRÓNICA Y COMUNICACIONES</option>
                                    <option>INGENIERÍA INDUSTRIAL EN CALIDAD</option>
                                    <option>INGENIERÍA INDUSTRIAL EN ELECTRÓNICA</option>
                                    <option>INGENIERÍA INDUSTRIAL EN ELECTRÓNICA, AUTOMATIZACIÓN Y COMUNICACIONES</option>
                                    <option>INGENIERÍA INDUSTRIAL EN INSTRUMENTACIÓN Y CONTROL DE PROCESOS</option>
                                    <option>INGENIERÍA INDUSTRIAL EN MANTENIMIENTO</option>
                                    <option>INGENIERÍA INDUSTRIAL EN MANUFACTURA</option>
                                    <option>INGENIERÍA INDUSTRIAL EN MECÁNICA</option>
                                    <option>INGENIERÍA INDUSTRIAL EN MECATRÓNICA</option>
                                    <option>INGENIERÍA INDUSTRIAL EN OPERACIONES INTERNACIONALES</option>
                                    <option>INGENIERÍA INDUSTRIAL EN PRODUCCIÓN Y SISTEMAS</option>
                                    <option>INGENIERÍA INDUSTRIAL EN PRODUCTIVIDAD Y CALIDAD</option>
                                    <option>INGENIERÍA INDUSTRIAL EN SISTEMAS DE PRODUCCIÓN</option>
                                    <option>INGENIERÍA INDUSTRIAL EN TEXTIL</option>
                                    <option>INGENIERÍA INDUSTRIAL ESPECIALIZADA EN ADMINISTRACIÓN </option>
                                    <option>INGENIERÍA INDUSTRIAL ESTADÍSTICO</option>
                                    <option>INGENIERÍA INDUSTRIAL MECÁNICO</option>
                                    <option>INGENIERÍA INDUSTRIAL PARA LA DIRECCIÓN</option>
                                    <option>INGENIERÍA INDUSTRIAL QUÍMICO</option>
                                    <option>INGENIERÍA INDUSTRIAL Y ADMINISTRACIÓN</option>
                                    <option>INGENIERÍA INDUSTRIAL Y DE CALIDAD</option>
                                    <option>INGENIERÍA INDUSTRIAL Y DE MANTENIMIENTO</option>
                                    <option>INGENIERÍA INDUSTRIAL Y DE PROCESOS</option>
                                    <option>INGENIERÍA INDUSTRIAL Y DE SERVICIOS</option>
                                    <option>INGENIERÍA INDUSTRIAL Y DE SISTEMAS</option>
                                    <option>INGENIERÍA INDUSTRIAL Y EN PRODUCCIÓN</option>
                                    <option>INGENIERÍA INDUSTRIAL Y EN SISTEMAS ORGANIZACIONALES</option>
                                    <option>INGENIERÍA INDUSTRIAL Y GESTIÓN E INNOVACIÓN TECNOLÓGICA</option>
                                    <option>INGENIERÍA INDUSTRIAL Y SISTEMAS</option>
                                    <option>INGENIERÍA PROCESOS DE MANUFACTURA</option>
                                    <option>LICENCIATURA EN SISTEMAS DE CALIDAD</option>
                                    <option>INGENIERO ELECTROMECÁNICO</option>
                                    <option>INGENIERO ELECTROMECÁNICO EN DISEÑO Y MANUFACTURA</option>
                                    <option>INGENIERO ELECTROMECÁNICO EN MECATRÓNICA</option>
                                    <option>INGENIERÍA EN MANUFACTURA DE AUTOPARTES</option>
                                    <option>INGENIERÍA EN MECATRÓNICA</option>
                                    <option>INGENIERÍA EN MECATRÓNICA Y PRODUCCIÓN</option>
                                    <option>INGENIERÍA EN SISTEMAS MECÁNICOS Y ELÉCTRICOS</option>
                                    <option>INGENIERO MECÁNICO</option>
                                    <option>INGENIERO MECÁNICO ADMINISTRADOR</option>
                                    <option>INGENIERO MECÁNICO AGRÍCOLA</option>
                                    <option>INGENIERO MECÁNICO AUTOMOTRIZ</option>
                                    <option>INGENIERO MECÁNICO ELECTRICISTA</option>
                                    <option>INGENIERO MECÁNICO ELECTRICISTA EN ELECTRICIDAD Y ELECTRÓNICA</option>
                                    <option>INGENIERO MECÁNICO ELECTRICISTA EN MECÁNICA</option>
                                    <option>INGENIERO MECÁNICO ELÉCTRICO</option>
                                    <option>INGENIERO MECÁNICO EN ENERGÉTICOS</option>
                                    <option>INGENIERO MECÁNICO EN INDUSTRIAL</option>
                                    <option>INGENIERO MECÁNICO INDUSTRIAL</option>
                                    <option>INGENIERO MECÁNICO NAVAL</option>
                                    <option>INGENIERO MECÁNICO Y ELÉCTRICO</option>
                                    <option>INGENIERO MECÁNICO Y EN SISTEMAS ENERGÉTICOS</option>
                                    <option>INGENIERO MECATRÓNICO</option>
                                    <option>INGENIERO MECATRÓNICO Y SISTEMAS DE CONTROL DE PROCESOS</option>
                                    <option>INGENIERÍA TÉCNICA MECÁNICA</option>
                                    <option>MAQUINISTA NAVAL</option>
                                    <option>INGENIERO OCEÁNICO</option>
                                    <option>INGENIERO QUÍMICO</option>
                                    <option>INGENIERO QUÍMICO ADMINISTRADOR</option>
                                    <option>INGENIERO QUÍMICO AGRÍCOLA</option>
                                    <option>INGENIERO QUÍMICO AGROINDUSTRIAL</option>
                                    <option>INGENIERO QUÍMICO AMBIENTAL</option>
                                    <option>INGENIERO QUÍMICO BIÓLOGO</option>
                                    <option>INGENIERO QUÍMICO CLÍNICO</option>
                                    <option>INGENIERO QUÍMICO DE SISTEMAS</option>
                                    <option>INGENIERO QUÍMICO EN ALIMENTOS</option>
                                    <option>INGENIERO QUÍMICO EN INGENIERÍA DE PROCESOS</option>
                                    <option>INGENIERO QUÍMICO EN METALURGIA</option>
                                    <option>INGENIERO QUÍMICO EN TECNOLOGÍA DE ALIMENTOS</option>
                                    <option>INGENIERO QUÍMICO INDUSTRIAL</option>
                                    <option>INGENIERO QUÍMICO METALÚRGICO</option>
                                    <option>INGENIERO QUÍMICO METALURGISTA</option>
                                    <option>INGENIERO QUÍMICO PETROLERO</option>
                                    <option>INGENIERO QUÍMICO PETROQUÍMICO</option>
                                    <option>INGENIERO QUÍMICO Y DE SISTEMAS</option>
                                    <option>INGENIERÍA TEXTIL</option>
                                    <option>INGENIERÍA TEXTIL EN ACABADOS</option>
                                    <option>INGENIERÍA TEXTIL EN CONFECCIÓN</option>
                                    <option>INGENIERÍA TEXTIL EN HILADOS</option>
                                    <option>INGENIERÍA TEXTIL EN TEJIDOS</option>
                                    <option>INGENIERÍA EN SISTEMAS TOPOGRÁFICOS</option>
                                    <option>INGENIERO HIDROLÓGICO</option>
                                    <option>INGENIERO TOPÓGRAFO</option>
                                    <option>INGENIERO TOPÓGRAFO E HIDRÓGRAFO</option>
                                    <option>INGENIERO TOPÓGRAFO E HIDRÓLOGO</option>
                                    <option>INGENIERO TOPÓGRAFO GEODESTA</option>
                                    <option>INGENIERO TOPÓGRAFO GEOMÁTICO</option>
                                    <option>INGENIERO TOPÓGRAFO HIDRÓLOGO</option>
                                    <option>INGENIERO TOPÓGRAFO Y FOTOGRAMETRISTA</option>
                                    <option>INGENIERO TOPÓGRAFO Y GEODÉSICO</option>
                                    <option>INGENIERO TOPÓGRAFO Y GEODESTA</option>
                                    <option>INGENIERO EN TOPOGRAFÍA E HIDROLOGÍA</option>
                                    <option>INGENIERO ACUACULTOR</option>
                                    <option>INGENIERÍA EN PESQUERÍAS</option>
                                    <option>INGENIERÍA EN RECURSOS ACUÁTICOS</option>
                                    <option>INGENIERÍA EN TECNOLOGÍA DE CAPTURA</option>
                                    <option>INGENIERO PESQUERO</option>
                                    <option>LICENCIATURA EN PESQUERÍAS</option>
                                    <option>INGENIERÍA EN INTELIGENCIA DE MERCADOS</option>
                                    <option>INGENIERÍA EN NEGOCIOS INTERNACIONALES</option>
                                    <option>INGENIERÍA EN PROCESOS INDUSTRIALES</option>
                                    <option>INGENIERÍA EN PROCESOS ORGANIZACIONALES</option>
                                    <option>LICENCIATURA EN DESARROLLO ORGANIZACIONAL</option>
                                    <option>LICENCIATURA EN PROCESOS ORGANIZACIONALES</option>
                                    <option>INGENIERO FARMACÉUTICO</option>
                                    <option>LICENCIATURA EN QUÍMICA INDUSTRIAL</option>
                                    <option>QUÍMICO INDUSTRIAL</option>
                                    <option>INGENIERÍA EN TECNOLOGÍA DE LA MADERA</option>
                                    <option>INGENIERÍA DE ALIMENTOS</option>
                                    <option>INGENIERÍA EN CIENCIA DE LOS ALIMENTOS</option>
                                    <option>INGENIERÍA EN CIENCIA Y TECNOLOGÍA DE ALIMENTOS</option>
                                    <option>INGENIERÍA EN INDUSTRIAS ALIMENTARIAS</option>
                                    <option>INGENIERÍA EN TECNOLOGÍA DE ALIMENTOS</option>
                                    <option>INGENIERO QUÍMICO DE ALIMENTOS</option>
                                    <option>LICENCIATURA EN CIENCIAS DE ALIMENTOS</option>
                                    <option>LICENCIATURA EN TECNOLOGÍA DE ALIMENTOS</option>
                                    <option>PROFESIONAL ASOCIADO EN ELABORACIÓN DE PRODUCTOS LÁCTEOS</option>
                                    <option>PROFESIONAL ASOCIADO EN MICROINDUSTRIAS ALIMENTARIAS</option>
                                    <option>QUÍMICO BIÓLOGO BROMATÓLOGO</option>
                                    <option>QUÍMICO BIÓLOGO EN TECNOLOGÍA EN ALIMENTOS</option>
                                    <option>QUÍMICO EN ALIMENTOS</option>
                                    <option>LICENCIATURA EN DESARROLLO TURÍSTICO</option>
                                    <option>LICENCIATURA EN DESARROLLO URBANO MUNICIPAL</option>
                                    <option>LICENCIATURA EN DESARROLLO URBANO Y ECOLOGÍA</option>
                                    <option>LICENCIATURA EN DESARROLLO Y ADMINISTRACIÓN DE BIENES RAÍCES</option>
                                    <option>LICENCIATURA EN DESARROLLOS TURÍSTICOS</option>
                                    <option>LICENCIATURA EN PLANEACIÓN URBANA</option>
                                    <option>LICENCIATURA EN PLANEACIÓN Y DESARROLLO TURÍSTICO</option>
                                    <option>URBANISTA</option>
                                    <option>LICENCIATURA EN DERECHO</option>
                                    <option>INGENIERÍA EN TECNOLOGÍAS DE LA INFORMACIÓN</option>
                                    <option>LICENCIATURA EN CONTADURÍA PÚBLICA</option>
                                    <option>INGENIERIA AGROINDUSTRIAL</option>
                                    <option>INGENIERIA INDUSTRIAL</option>
                                    <option>LICENCIATURA EN CIENCIAS DE LA COMUNICACIÓN</option>
                                    <option>LICENCIATURA EN MATEMATICAS</option>
                                    <option>LICENCIATURA EN ADMINISTRACION DE EMPRESAS</option>
                                    <option>LICENCIATURA EN ADMINISTRACION DE NEGOCIOS INTERNACIONALES</option>
                                    <option>LICENCIATURA EN PERIODISMO Y COMUNICACIÓN COLECTIVA</option>
                                    <option>LICENCIATURA EN MERCADOTECNIA Y PUBLICIDAD</option>
                                    <option>LICENCIATURA EN ENSEÑANZA DEL INGLES</option>
                                    <option>TECNICO AUTOMOTRIZ</option>
                                    <option>INGENIERIA EN MECANICA AUTOMOTRIZ</option>
                                    <option>LICENCIATURA EN CIENCIAS POLITICAS Y ADMINISTRACION PUBLICA</option>
                                    <option>LICENCIATURA EN TRABAJO SOCIAL</option>
                                    <option>LICENCIATURA EN ENFERMERIA</option>
                                    <option>LICENCIATURA EN PSICOLOGIA</option>
                                    <option>LICENCIATURA EN NUTRICION Y DIETETICA</option>
                                    <option>MEDICO CIRUJANO</option>
                                    <option>LICENCIATURA EN ENFERMERIA Y OBSTETRICIA</option>
                                    <option>LICENCIATURA EN NUTRIOLOGIA</option>
                                    <option>LICENCIATURA EN BIOLOGIA</option>
                                    <option>LICENCIATURA EN QUIMICA CLINICA</option>
                                    <option>MEDICO</option>
                                    <option>LICENCIATURA EN PEDAGOGIA</option>
                                    <option>LICENCIATURA EN GESTION TURISTICA</option>
                                    <option>INGENIERO MECANICO EN MANTENIMIENTO INDUSTRIAL</option>
                                    <option>OTRO</option>
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
                            <hr>
                            {{-- <div class="form-group col-md-12">
                                <h5 class="modal-title">Documentación</h5>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Comprobante de Domicilio</label>
                                <input type="file" class="form-control form-control-lg" id="proofaddressSave"
                                    placeholder="Introduce profesión del alumno">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputPassword1">Comprobante de Ultimo Grado de Estudios</label>
                                <input type="file" class="form-control form-control-lg" id="proofstudiesSave"
                                    placeholder="Introduce profesión del alumno">
                            </div> --}}
                            {{-- <div class="form-group col-md-12">
                                <h5 class="modal-title">*Selecciona <span style="color:red;">ES PROSPECTO</span>
                                    unicamente si el alumno aún no esta seguro de inscribirse a un diplomado.</h5>
                            </div> --}}
                            {{-- <div class="form-group col-md-12">
                                <label for="exampleInputPassword1">Selecciona opción</label>
                                <select name="status" id="status" class="form-control form-control-lg">
                                    <option value="">---Selecciona Opción---</option>
                                    <option value="1">YA SERA ALUMNO</option>
                                    <option value="0">ES PROSPECTO</option>
                                </select>
                            </div> --}}
                            {{-- <div id="blockDiplomat" class="col-md-12">
                                <div class="form-group col-md-12">
                                    <h5 class="modal-title">Matricular a Diplomado</h5>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputPassword1">Selecciona Diplomado</label>
                                    <select name="generationSave" id="generationSave" class="form-control form-control-lg">
                                        @forelse ($generations as $generation)
                                        <option value="{{$generation->id}}">{{$generation->name_diplomat}}---{{$generation->number_generation}}</option>
                                        @empty
                                        <option>NO EXISTEN GENERACIONES REGISTRADAS</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div> --}}
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
