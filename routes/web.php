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

Route::get('/clear-cache', function() {
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
    Route::get('/','UserController@show');
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
    Route::get('/convenios', function(){
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
Route::middleware(['auth'])->group(function($route){
    # Ruta para devolver al usuario original
    $route->get('revertir', 'SuplantacionController@revertir');

    # Ruta de suplantación
    $route->get('{user}', 'SuplantacionController@suplantar');
});

// Rutas extras para vendedores
Route::get('/datos/generaciones', 'GeneralController@index');
Route::get('/datos/generaciones/todos', 'GeneralController@dataGenerations')->name('sellers.generations');
Route::get('/datos/generaciones/alumnos/inscritos/{id}', 'GeneralController@studentsInscription');

Route::get('/prueba/admin', function(){
    return view('test.test');
});

//Rutas para control escolar
// Students..
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












