<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    //$exitCode = Artisan::call('route:cache');
    $exitCode = Artisan::call('view:clear');
    return 'DONE'; //Return anything..
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/descargar/recibo/{id}', 'PaymentController@voucher');
Route::get('/inicio/semaforo/vendedor', 'HomeController@traffic');
Route::get('/inicio/comisiones/pendientes', 'HomeController@commisionsDebt');
Route::get('/inicio/comisiones/pagadas', 'HomeController@commisionsPayment');
Route::get('/inicio/reporte/prospectos', 'ReportController@showProspects');
Route::get('/inicio/datos/prospectos', 'ReportController@dataProspects');



// Users
Route::group(['prefix' => 'usuarios', 'middleware' => 'permission:modulo-administracion'], function () {
    Route::get('/', 'EmployeController@index');
    Route::get('/datos', 'EmployeController@dataEmployes')->name('users.data');
    Route::get('/crear', 'EmployeController@create');
    Route::post('/guardar', 'EmployeController@store');
    Route::get('/editar/{id}', 'EmployeController@edit');
    Route::put('/actualizar/{id}', 'EmployeController@update');
    Route::delete('eliminar/{id}', 'EmployeController@destroy');
});

Route::group(['prefix' => 'perfil', 'middleware' => 'permission:modulo-perfil'], function () {
    Route::get('/', 'UserController@show');
    Route::get('/editar/', 'UserController@edit');
    Route::put('/actualizar/{id}', 'UserController@update');
});

// Fees
Route::group(['prefix' => 'cuotas', 'middleware' => 'permission:modulo-cuotas-de-estudiantes'], function () {
    Route::get('/', 'AccountTypeController@index');
    Route::get('/datos', 'AccountTypeController@dataAccounts')->name('accounts.data');
    Route::get('/crear', 'AccountTypeController@create');
    Route::post('/guardar', 'AccountTypeController@store');
    Route::get('/editar/{id}', 'AccountTypeController@edit');
    Route::put('/actualizar/{id}', 'AccountTypeController@update');
    Route::delete('eliminar/{id}', 'AccountTypeController@destroy');
});

// Accounts
Route::group(['prefix' => 'cuentas', 'middleware' => 'permission:modulo-cuentas-bancarias'], function () {
    Route::get('/', 'AccountController@index');
    Route::get('/datos', 'AccountController@dataAccounts')->name('accounts.data');
    Route::get('/crear', 'AccountController@create');
    Route::post('/guardar', 'AccountController@store');
    Route::get('/editar/{id}', 'AccountController@edit');
    Route::put('/actualizar/{id}', 'AccountController@update');
    Route::delete('eliminar/{id}', 'AccountController@destroy');
});

// Payment Methods
Route::group(['prefix' => 'metodos-de-pago', 'middleware' => 'permission:modulo-transacciones'], function () {
    Route::get('/', 'PaymentMethodController@index');
    Route::get('/datos', 'PaymentMethodController@dataMethods')->name('payment_methods.data');
    Route::get('/crear', 'PaymentMethodController@create');
    Route::post('/guardar', 'PaymentMethodController@store');
    Route::get('/editar/{id}', 'PaymentMethodController@edit');
    Route::put('/actualizar/{id}', 'PaymentMethodController@update');
    Route::delete('eliminar/{id}', 'PaymentMethodController@destroy');
});


// Students..
Route::group(['prefix' => 'alumnos', 'middleware' => 'permission:modulo-alumnos'], function () {
    Route::get('/', 'StudentController@index');
    Route::get('/prospectos', 'StudentController@prospects');
    Route::get('/datos/prospectos', 'StudentController@dataProspects');
    Route::get('/datos', 'StudentController@dataStudents')->name('students.data');
    Route::post('/checkCurp', 'StudentController@checkCurp');
    Route::get('/crear', 'StudentController@create');
    Route::post('/guardar', 'StudentController@store');
    Route::get('/editar/{id}', 'StudentController@edit');
    Route::put('/actualizar/{id}', 'StudentController@update');
    Route::put('/actualizar/semaforo/{id}', 'StudentController@updateStatus');
    Route::delete('eliminar/{id}', 'StudentController@destroy');
    Route::put('/descartar/{id}', 'StudentController@down');
    Route::get('/documentos/{id}', 'StudentController@Documents');
    Route::get('/consultar/{id}', 'StudentController@show');
    Route::post('/subir/documentos', 'StudentController@uploadDocuments');
    Route::get('/consultar/{id}', 'StudentController@searchStudent');
    Route::post('/procesar/inscripcion', 'StudentController@incscriptionStudent');
    Route::get('/detalles/{porcent}', 'StudentController@detailsPorcent');
});

// Tecahers
Route::group(['prefix' => 'docentes', 'middleware' => 'permission:modulo-docentes'], function () {
    Route::get('/', 'TeacherController@index');
    Route::get('/datos', 'TeacherController@dataTeachers')->name('teachers.data');
    Route::get('/crear', 'TeacherController@create');
    Route::post('/guardar', 'TeacherController@store');
    Route::get('/editar/{id}', 'TeacherController@edit');
    Route::put('/actualizar/{id}', 'TeacherController@update');
    Route::delete('eliminar/{id}', 'TeacherController@destroy');
});

// Diplomats
Route::group(['prefix' => 'diplomados', 'middleware' => 'permission:modulo-control-escolar'], function () {
    Route::get('/', 'DiplomatController@index');
    Route::get('/datos', 'DiplomatController@dataDiplomats')->name('diplomats.data');
    Route::get('/crear', 'DiplomatController@create');
    Route::post('/guardar', 'DiplomatController@store');
    Route::get('/editar/{id}', 'DiplomatController@edit');
    Route::put('/actualizar/{id}', 'DiplomatController@update');
    Route::delete('eliminar/{id}', 'DiplomatController@destroy');
});

// Generations of Diplomats
Route::group(['prefix' => 'generaciones', 'middleware' => 'permission:modulo-control-escolar'], function () {
    Route::get('/', 'GenerationController@index');
    Route::get('/datos', 'GenerationController@dataGenerations')->name('generations.data');
    Route::get('/crear', 'GenerationController@create');
    Route::post('/guardar', 'GenerationController@store');
    Route::get('/editar/{id}', 'GenerationController@edit');
    Route::put('/actualizar/{id}', 'GenerationController@update');
    Route::delete('eliminar/{id}', 'GenerationController@destroy');

    //
    Route::get('/alumnos/buscar', 'GenerationController@findStudent');
    Route::get('/alumnos/inscritos/{id}', 'GenerationController@studentsInscription');
    Route::get('/alumnos/{id}', 'GenerationController@students');
    Route::get('/alumnos/consultar/{id}', 'GenerationController@search');
    Route::put('/alumnos/baja/{id}', 'GenerationController@down');
    Route::put('/alumnos/alta/{id}', 'GenerationController@up');

    Route::get('/alumnos/baja/consultar/{id}', 'GenerationController@low');

    Route::get('/inscripciones/recientes/', 'GenerationController@recentsInscription');
    Route::get('/convenios/pendientes/', 'AgreementController@list');

    Route::get('/consultar/inscripcion/{id}', 'GenerationController@consult');
    Route::put('/marcar/leida/{id}', 'GenerationController@read');
    Route::get('/enviar/recibo/{id}', 'GenerationController@sendVoucher');
    Route::get('/enviar/recibo/dos/{id}', 'GenerationController@sendVoucherTwo');
});


// Payments
Route::group(['prefix' => 'pagos'], function () {
    Route::get('/procesar', 'PaymentController@processPayment');
    Route::get('/generaciones/{id}', 'PaymentController@listGenerations');
    Route::get('/generaciones/alumnos/{id}', 'PaymentController@listStudents');
    Route::post('/recibir', 'PaymentController@received');
    Route::post('/recibir/alterno', 'PaymentController@receivedAlternate');
    Route::post('/recibir/convenio', 'AgreementController@processAgreement');
    Route::get('/ingresos', 'PaymentController@showReceiveds');
    Route::get('/ingresos/modificar', 'PaymentController@showPayments');
    Route::get('/recibidos', 'PaymentController@paymentReceiveds');
    Route::get('/revertir', 'PaymentController@paymentReceivedsForRevert');
    Route::get('/deuda/{id}', 'PaymentController@debt');
    Route::get('/editar/{id}', 'PaymentController@edit');
    Route::put('/actualizar/{id}', 'PaymentController@update');

    Route::get('/buscar/curp/{curp}', 'PaymentController@dataPayment');
});

// Expenses
Route::group(['prefix' => 'gastos', 'middleware' => 'permission:modulo-transacciones'], function () {
    Route::get('/', 'ExpenseController@index');
    Route::get('/datos', 'ExpenseController@dataExpenses')->name('expenses.data');
    Route::get('/crear', 'ExpenseController@create');
    Route::post('/guardar', 'ExpenseController@store');
    Route::get('/editar/{id}', 'ExpenseController@edit');
    Route::put('/actualizar/{id}', 'ExpenseController@update');
    Route::delete('eliminar/{id}', 'ExpenseController@destroy');
});


// Incentives
Route::group(['prefix' => 'comisiones'], function () {
    Route::get('/', 'IncentiveController@index');
    Route::get('/datos', 'IncentiveController@data')->name('expenses.data');
    Route::put('/pagar/{id}', 'IncentiveController@pay');
});


// Messages
Route::group(['prefix' => 'mensajeria', 'middleware' => 'permission:modulo-emails'], function () {
    Route::get('/crear', 'MessageController@create');
    Route::post('/enviar', 'MessageController@store');
});

// Roles
Route::resource('admin/roles', 'RoleController');

// SMS
Route::get('/enviar/sms', 'SmsController@send');

// PUSHER
Route::get('/pusher', function () {
    event(new App\Events\HelloPusherEvent('Hi there Pusher!'));
    return "Event has been sent!";
});

// Notifications
Route::get('/nueva/inscripcion/{id}', 'StudentController@newInscription');

// Reports
Route::get('/exportar/estudiantes', 'ReportController@displayReport');

// Todos
Route::group(['prefix' => 'tareas'], function () {
    Route::get('/', 'TodoController@index');
    Route::get('/datos', 'TodoController@dataTodos')->name('todos.data');
    Route::get('/crear', 'TodoController@create');
    Route::post('/guardar', 'TodoController@store');
    Route::get('/editar/{id}', 'TodoController@edit');
    Route::get('/actualizar/{id}', 'TodoController@update');
    Route::delete('eliminar/{id}', 'TodoController@destroy');
});

// Reports
Route::group(['prefix' => 'reportes'], function () {
    Route::get('/adeudos', 'ReportController@showDebts');
    Route::get('/datos/adeudos', 'ReportController@debts');
    Route::get('/datos/adeudos/descargar', 'ReportController@displayReportDebts');
    Route::get('/no-documentos', 'ReportController@showNoDocuments');
    Route::get('/estudiantes/no-documentos', 'ReportController@noDocuments');
    Route::get('/convenios', function () {
        return view('reports.convenios');
    });
});

// Campaings
Route::group(['prefix' => 'campanias'], function () {
    Route::get('/', 'CampaingController@index');
    Route::get('/datos', 'CampaingController@dataCampaings')->name('campaings.data');
    Route::get('/crear', 'CampaingController@create');
    Route::post('/guardar', 'CampaingController@store');
    Route::get('/editar/{id}', 'CampaingController@edit');
    Route::put('/actualizar/{id}', 'CampaingController@update');
    Route::delete('eliminar/{id}', 'CampaingController@destroy');

    Route::get('/estudiantes', 'CampaingController@dataStudents')->name('campaings.students');
    Route::get('/agregar/estudiantes', 'CampaingController@addStudents')->name('campaings.massadd');
});

// Suplantación
Route::middleware(['auth'])->group(function ($route) {
    # Ruta para devolver al usuario original
    $route->get('revertir', 'SuplantacionController@revertir');

    # Ruta de suplantación
    $route->get('{user}', 'SuplantacionController@suplantar');
});

// Rutas extras para vendedores
Route::get('/datos/generaciones', 'GeneralController@index');
Route::get('/datos/generaciones/todos', 'GeneralController@dataGenerations')->name('sellers.generations');
Route::get('/datos/generaciones/alumnos/inscritos/{id}', 'GeneralController@studentsInscription');

Route::get('/prueba/admin', function () {
    return view('test.test');
});

//Administración
Route::group(['prefix' => 'admon'], function () {
    Route::get('/inicio', function () {
        return view('admon.home');
    });

    Route::get('/perfil', function(){
        return view('admon.update');
    });


    Route::get('/perfil/editar/', 'UserController@edit');
    Route::put('/perfil/actualizar/{id}', 'UserController@update');

    //Cuentas
    Route::get('/cuentas', 'Admon\AccountController@index');
    Route::get('/cuentas/datos', 'Admon\AccountController@dataAccounts')->name('admon.accounts.data');
    Route::get('/cuentas/crear', 'Admon\AccountController@create');
    Route::post('/cuentas/guardar', 'Admon\AccountController@store');
    Route::get('/cuentas/editar/{id}', 'Admon\AccountController@edit');
    Route::put('/cuentas/actualizar/{id}', 'Admon\AccountController@update');
    Route::delete('/cuentas/eliminar/{id}', 'Admon\AccountController@destroy');

    //Alumnos
    Route::get('/alumnos/lista', 'Admon\StudentController@index');
    Route::get('/alumnos/datos', 'Admon\StudentController@dataStudents');
    Route::get('/alumnos/editar/{id}', 'Admon\StudentController@edit');
    Route::put('/alumnos/actualizar/{id}', 'Admon\StudentController@update');
    Route::get('/alumnos/expediente/{id}', 'Admon\StudentController@proceedings');
    //Docentes
    Route::get('/docentes/lista', 'Admon\TeacherController@index');
    Route::get('/docentes/datos', 'Admon\TeacherController@dataTeachers');
    Route::get('/docentes/crear', 'Admon\TeacherController@create');
    Route::post('/docentes/guardar', 'Admon\TeacherController@store');
    Route::get('/docentes/editar/{id}', 'Admon\TeacherController@edit');
    Route::put('/docentes/actualizar/{id}', 'Admon\TeacherController@update');
    Route::delete('/docentes/eliminar/{id}', 'Admon\TeacherController@destroy');
    //Diplomados
    Route::get('/diplomados/lista', 'Admon\DiplomatController@index');
    Route::get('/diplomados/datos', 'Admon\DiplomatController@dataDiplomats')->name('admon.diplomats.data');
    Route::get('/diplomados/crear', 'Admon\DiplomatController@create');
    Route::post('/diplomados/guardar', 'Admon\DiplomatController@store');
    Route::get('/diplomados/editar/{id}', 'Admon\DiplomatController@edit');
    Route::put('/diplomados/actualizar/{id}', 'Admon\DiplomatController@update');
    Route::delete('/diplomados/eliminar/{id}', 'Admon\DiplomatController@destroy');
    //Generaciones
    Route::get('/generaciones/lista', 'Admon\GenerationController@index');
    Route::get('/generaciones/datos', 'Admon\GenerationController@dataGenerations');
    Route::get('/generaciones/crear', 'Admon\GenerationController@create');
    Route::post('/generaciones/guardar', 'Admon\GenerationController@store');
    Route::get('/generaciones/editar/{id}', 'Admon\GenerationController@edit');
    Route::put('/generaciones/actualizar/{id}', 'Admon\GenerationController@update');
    
    Route::delete('/generaciones/eliminar/{id}', 'Admon\GenerationController@destroy');

    Route::get('/generaciones/alumnos/buscar', 'Admon\GenerationController@findStudent');
    Route::get('/generaciones/alumnos/inscritos/{id}', 'Admon\GenerationController@studentsInscription');
    Route::get('/generaciones/alumnos/{id}', 'Admon\GenerationController@students');
    Route::get('/generaciones/alumnos/consultar/{id}', 'Admon\GenerationController@search');
    Route::put('/generaciones/alumnos/baja/{id}', 'Admon\GenerationController@down');
    Route::put('/generaciones/alumnos/alta/{id}', 'Admon\GenerationController@up');
    Route::delete('/generaciones/eliminar/alumno/{id}', 'Admon\GenerationController@deleteStudent');

    Route::POST('/generaciones/alumnos/descuento/', 'Admon\GenerationController@discount');

    Route::get('/generaciones/alumnos/baja/consultar/{id}', 'Admon\GenerationController@low');

    Route::get('/generaciones/inscripciones/recientes/', 'Admon\GenerationController@recentsInscription');
    Route::get('/generaciones/convenios/pendientes/', 'AgreementController@list');
    Route::get('/generaciones/convenios/pendientes/al-dia', 'AgreementController@listToday');

    Route::get('/generaciones/consultar/inscripcion/{id}', 'Admon\GenerationController@consult');
    Route::put('/generaciones/marcar/leida/{id}', 'Admon\GenerationController@read');
    Route::get('/generaciones/enviar/recibo/{id}', 'Admon\GenerationController@sendVoucher');
    Route::get('/generaciones/enviar/recibo/dos/{id}', 'Admon\GenerationController@sendVoucherTwo');
    Route::post('/generaciones/editar/pago/', 'Admon\GenerationController@editPay');
    Route::post('/generaciones/editar/pago/alterno', 'Admon\GenerationController@editPayTwo');
});

//Auxiliar de Admon
//Administración
Route::group(['prefix' => 'auxiliar'], function () {
    Route::get('/inicio', function () {
        return view('auxiliar.home');
    });

    Route::get('/perfil', function(){
        return view('auxiliar.update');
    });

    Route::get('/perfil/editar/', 'UserController@edit');
    Route::put('/perfil/actualizar/{id}', 'UserController@update');

    //Alumnos
    Route::get('/alumnos/lista', 'Auxiliar\StudentController@index');
    Route::get('/alumnos/datos', 'Auxiliar\StudentController@dataStudents');
    Route::get('/alumnos/editar/{id}', 'Auxiliar\StudentController@edit');
    Route::put('/alumnos/actualizar/{id}', 'Auxiliar\StudentController@update');
    //Docentes
    Route::get('/docentes/lista', 'Auxiliar\TeacherController@index');
    Route::get('/docentes/datos', 'Auxiliar\TeacherController@dataTeachers');
    Route::get('/docentes/crear', 'Auxiliar\TeacherController@create');
    Route::post('/docentes/guardar', 'Auxiliar\TeacherController@store');
    Route::get('/docentes/editar/{id}', 'Auxiliar\TeacherController@edit');
    Route::put('/docentes/actualizar/{id}', 'Auxiliar\TeacherController@update');
    Route::delete('/docentes/eliminar/{id}', 'Auxiliar\TeacherController@destroy');
    //Diplomados
    Route::get('/diplomados/lista', 'Auxiliar\DiplomatController@index');
    Route::get('/diplomados/datos', 'Auxiliar\DiplomatController@dataDiplomats')->name('Auxiliar.diplomats.data');
    Route::get('/diplomados/crear', 'Auxiliar\DiplomatController@create');
    Route::post('/diplomados/guardar', 'Auxiliar\DiplomatController@store');
    Route::get('/diplomados/editar/{id}', 'Auxiliar\DiplomatController@edit');
    Route::put('/diplomados/actualizar/{id}', 'Auxiliar\DiplomatController@update');
    Route::delete('/diplomados/eliminar/{id}', 'Auxiliar\DiplomatController@destroy');
    //Generaciones
    Route::get('/generaciones/lista', 'Auxiliar\GenerationController@index');
    Route::get('/generaciones/datos', 'Auxiliar\GenerationController@dataGenerations');
    Route::get('/generaciones/crear', 'Auxiliar\GenerationController@create');
    Route::post('/generaciones/guardar', 'Auxiliar\GenerationController@store');
    Route::get('/generaciones/editar/{id}', 'Auxiliar\GenerationController@edit');
    Route::put('/generaciones/actualizar/{id}', 'Auxiliar\GenerationController@update');
    Route::delete('/generaciones/eliminar/{id}', 'Auxiliar\GenerationController@destroy');

    Route::get('/generaciones/alumnos/buscar', 'Auxiliar\GenerationController@findStudent');
    Route::get('/generaciones/alumnos/inscritos/{id}', 'Auxiliar\GenerationController@studentsInscription');
    Route::get('/generaciones/alumnos/{id}', 'Auxiliar\GenerationController@students');
    Route::get('/generaciones/alumnos/consultar/{id}', 'Auxiliar\GenerationController@search');
    Route::put('/generaciones/alumnos/baja/{id}', 'Auxiliar\GenerationController@down');
    Route::put('/generaciones/alumnos/alta/{id}', 'Auxiliar\GenerationController@up');

    Route::get('/generaciones/alumnos/baja/consultar/{id}', 'Auxiliar\GenerationController@low');

    Route::get('/generaciones/inscripciones/recientes/', 'Auxiliar\GenerationController@recentsInscription');
    Route::get('/generaciones/convenios/pendientes/', 'AgreementController@list');
    Route::get('/generaciones/convenios/pendientes/al-dia', 'AgreementController@listToday');

    Route::get('/generaciones/consultar/inscripcion/{id}', 'Auxiliar\GenerationController@consult');
    Route::put('/generaciones/marcar/leida/{id}', 'Auxiliar\GenerationController@read');
    Route::get('/generaciones/enviar/recibo/{id}', 'Auxiliar\GenerationController@sendVoucher');
    Route::get('/generaciones/enviar/recibo/dos/{id}', 'Auxiliar\GenerationController@sendVoucherTwo');
    Route::post('/generaciones/editar/pago/', 'Auxiliar\GenerationController@editPay');
});

//Rutas para control escolar
Route::group(['prefix' => 'control-escolar', 'middleware' => 'permission:modulo-alumnos'], function () {
    //Alumnos
    Route::get('/alumnos/lista', 'Escolar\StudentController@index');
    Route::get('/alumnos/datos', 'Escolar\StudentController@dataStudents');
    Route::get('/alumnos/editar/{id}', 'Escolar\StudentController@edit');
    Route::put('/alumnos/actualizar/{id}', 'Escolar\StudentController@update');
    //Docentes
    Route::get('/docentes/lista', 'Escolar\TeacherController@index');
    Route::get('/docentes/datos', 'Escolar\TeacherController@dataTeachers');
    Route::get('/docentes/crear', 'Escolar\TeacherController@create');
    Route::post('/docentes/guardar', 'Escolar\TeacherController@store');
    Route::get('/docentes/editar/{id}', 'Escolar\TeacherController@edit');
    Route::put('/docentes/actualizar/{id}', 'Escolar\TeacherController@update');
    Route::delete('/docentes/eliminar/{id}', 'Escolar\TeacherController@destroy');
    //Generaciones
    Route::get('/generaciones/lista', 'Escolar\GenerationController@index');
    Route::get('/generaciones/datos', 'Escolar\GenerationController@dataGenerations');
    Route::get('/generaciones/crear', 'Escolar\GenerationController@create');
    Route::post('/generaciones/guardar', 'Escolar\GenerationController@store');
    Route::get('/generaciones/editar/{id}', 'Escolar\GenerationController@edit');
    Route::put('/generaciones/actualizar/{id}', 'Escolar\GenerationController@update');
    Route::delete('/generaciones/eliminar/{id}', 'Escolar\GenerationController@destroy');

    Route::get('/generaciones/alumnos/buscar', 'Escolar\GenerationController@findStudent');
    Route::get('/generaciones/alumnos/inscritos/{id}', 'Escolar\GenerationController@studentsInscription');
    Route::get('/generaciones/alumnos/{id}', 'Escolar\GenerationController@students');
    Route::get('/generaciones/alumnos/consultar/{id}', 'Escolar\GenerationController@search');
    Route::put('/generaciones/alumnos/baja/{id}', 'Escolar\GenerationController@down');
    Route::put('/generaciones/alumnos/alta/{id}', 'Escolar\GenerationController@up');

    Route::get('/generaciones/alumnos/baja/consultar/{id}', 'Escolar\GenerationController@low');

    Route::get('/generaciones/inscripciones/recientes/', 'Escolar\GenerationController@recentsInscription');
    Route::get('/generaciones/convenios/pendientes/', 'AgreementController@list');
    Route::get('/generaciones/convenios/pendientes/al-dia', 'AgreementController@listToday');

    Route::get('/generaciones/consultar/inscripcion/{id}', 'Escolar\GenerationController@consult');
    Route::put('/generaciones/marcar/leida/{id}', 'Escolar\GenerationController@read');
    Route::get('/generaciones/enviar/recibo/{id}', 'Escolar\GenerationController@sendVoucher');
    Route::get('/generaciones/enviar/recibo/dos/{id}', 'Escolar\GenerationController@sendVoucherTwo');
    Route::post('/generaciones/editar/pago/', 'Escolar\GenerationController@editPay');
});

Route::group(['prefix' => 'clinica'], function () {
    Route::get('/inicio', function () {
        return view('clinic.home');
    });
    //Doctors
    Route::get('/terapeutas/lista', 'Clinic\DoctorController@index');
    Route::get('/terapeutas/datos', 'Clinic\DoctorController@dataTeachers')->name('doctors.data');
    Route::get('/terapeutas/crear', 'Clinic\DoctorController@create');
    Route::post('/terapeutas/guardar', 'Clinic\DoctorController@store');
    Route::get('/terapeutas/editar/{id}', 'Clinic\DoctorController@edit');
    Route::put('/terapeutas/actualizar/{id}', 'Clinic\DoctorController@update');
    Route::delete('/terapeutas/eliminar/{id}', 'Clinic\DoctorController@destroy');

    //Rooms
    Route::get('/consultorios/lista', 'Clinic\RoomController@index');
    Route::get('/consultorios/datos', 'Clinic\RoomController@dataTeachers')->name('rooms.data');
    Route::get('/consultorios/crear', 'Clinic\RoomController@create');
    Route::post('/consultorios/guardar', 'Clinic\RoomController@store');
    Route::get('/consultorios/editar/{id}', 'Clinic\RoomController@edit');
    Route::put('/consultorios/actualizar/{id}', 'Clinic\RoomController@update');
    Route::delete('/consultorios/eliminar/{id}', 'Clinic\RoomController@destroy');

    //Appoinments
    Route::get('/citas/lista', 'Clinic\AppoinmentController@index');
    Route::get('/citas/datos', 'Clinic\AppoinmentController@dataTeachers')->name('appoinments.data');
    Route::get('/citas/crear', 'Clinic\AppoinmentController@create');
    Route::post('/citas/guardar', 'Clinic\AppoinmentController@store');
    Route::get('/citas/editar/{id}', 'Clinic\AppoinmentController@edit');
    Route::put('/citas/actualizar/{id}', 'Clinic\AppoinmentController@update');
    Route::delete('/citas/eliminar/{id}', 'Clinic\AppoinmentController@destroy');

    Route::get('/calendario', function () {
        return view('clinic.calendar.index');
    });

    Route::get('/calendario/datos', 'Clinic\AppoinmentController@calendar');
});

//Vendedores
Route::group(['prefix' => 'ventas'], function () {
    Route::get('/inicio', function () {
        return view('sales.home');
    });

    Route::get('/perfil', function(){
        return view('sales.update');
    });

    Route::get('/perfil/editar/', 'UserController@edit');
    Route::put('/perfil/actualizar/{id}', 'UserController@update');

    Route::get('/alumnos/lista', 'Sales\StudentController@index');
    Route::get('/alumnos/prospectos', 'Sales\StudentController@prospects');
    Route::get('/alumnos/datos/prospectos', 'Sales\StudentController@dataProspects');

    Route::get('/alumnos/datos', 'Sales\StudentController@dataStudents')->name('students.data');
    Route::post('/alumnos/checkCurp', 'Sales\StudentController@checkCurp');
    Route::get('/alumnos/crear', 'Sales\StudentController@create');
    //Buscar alumno
    Route::get('/alumnos/buscar/{search}', 'Sales\StudentController@search');
    Route::post('/alumnos/guardar', 'Sales\StudentController@store');
    Route::get('/alumnos/editar/{id}', 'Sales\StudentController@edit');
    Route::put('/alumnos/actualizar/{id}', 'Sales\StudentController@update');
    Route::put('/alumnos/actualizar/semaforo/{id}', 'Sales\StudentController@updateStatus');
    Route::delete('/lumnos/eliminar/{id}', 'Sales\StudentController@destroy');
    Route::put('/alumnos/descartar/{id}', 'Sales\StudentController@down');
    Route::get('/alumnos/documentos/{id}', 'Sales\StudentController@Documents');
    Route::get('/alumnos/consultar/{id}', 'Sales\StudentController@show');
    Route::post('/alumnos/subir/documentos', 'Sales\StudentController@uploadDocuments');
    Route::get('/alumnos/consultar/{id}', 'Sales\StudentController@searchStudent');
    Route::post('/alumnos/procesar/inscripcion', 'Sales\StudentController@incscriptionStudent');
    Route::get('/alumnos/detalles/{porcent}', 'Sales\StudentController@detailsPorcent');

    //Buscar generaciones
    Route::get('/alumnos/buscar/generaciones/{id}', 'Sales\StudentController@listGenerations');

    
    //Inscripciones
    
    Route::post('/alumnos/revisar', 'Sales\StudentController@checkStudentInscription');
    Route::post('/alumnos/procesar/reinscripcion', 'Sales\StudentController@incscriptionStudentOld');
    Route::post('/alumnos/procesar/nuevainscripcion', 'Sales\StudentController@nStudent');

    // Rutas extras ventas
    Route::get('/alumnos/datos/generaciones', 'Sales\GeneralController@index');
    Route::get('/alumnos/datos/generaciones/todos', 'Sales\GeneralController@dataGenerations')->name('sales.sellers.generations');
    Route::get('/alumnos/datos/generaciones/alumnos/inscritos/{id}', 'Sales\GeneralController@studentsInscription');
});
