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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/descargar/recibo/{id}', 'PaymentController@voucher');


// Users
Route::group(['prefix' => 'usuarios'], function () {
    Route::get('/', 'EmployeController@index');
    Route::get('/datos', 'EmployeController@dataEmployes')->name('users.data');
    Route::get('/crear', 'EmployeController@create');
    Route::post('/guardar', 'EmployeController@store');
    Route::get('/editar/{id}', 'EmployeController@edit');
    Route::put('/actualizar/{id}', 'EmployeController@update');
    Route::delete('eliminar/{id}', 'EmployeController@destroy');
});

Route::group(['prefix' => 'perfil'], function () {
    Route::get('/','UserController@show');
    Route::get('/editar/', 'UserController@edit');
    Route::put('/actualizar/{id}', 'UserController@update');
});

// Fees
Route::group(['prefix' => 'cuotas'], function () {
    Route::get('/', 'AccountTypeController@index');
    Route::get('/datos', 'AccountTypeController@dataAccounts')->name('accounts.data');
    Route::get('/crear', 'AccountTypeController@create');
    Route::post('/guardar', 'AccountTypeController@store');
    Route::get('/editar/{id}', 'AccountTypeController@edit');
    Route::put('/actualizar/{id}', 'AccountTypeController@update');
    Route::delete('eliminar/{id}', 'AccountTypeController@destroy');
});

// Accounts
Route::group(['prefix' => 'cuentas'], function () {
    Route::get('/', 'AccountController@index');
    Route::get('/datos', 'AccountController@dataAccounts')->name('accounts.data');
    Route::get('/crear', 'AccountController@create');
    Route::post('/guardar', 'AccountController@store');
    Route::get('/editar/{id}', 'AccountController@edit');
    Route::put('/actualizar/{id}', 'AccountController@update');
    Route::delete('eliminar/{id}', 'AccountController@destroy');
});

// Payment Methods
Route::group(['prefix' => 'metodos-de-pago'], function () {
    Route::get('/', 'PaymentMethodController@index');
    Route::get('/datos', 'PaymentMethodController@dataMethods')->name('payment_methods.data');
    Route::get('/crear', 'PaymentMethodController@create');
    Route::post('/guardar', 'PaymentMethodController@store');
    Route::get('/editar/{id}', 'PaymentMethodController@edit');
    Route::put('/actualizar/{id}', 'PaymentMethodController@update');
    Route::delete('eliminar/{id}', 'PaymentMethodController@destroy');
});


// Students
Route::group(['prefix' => 'alumnos'], function () {
    Route::get('/', 'StudentController@index');
    Route::get('/datos', 'StudentController@dataStudents')->name('students.data');
    Route::get('/crear', 'StudentController@create');
    Route::post('/guardar', 'StudentController@store');
    Route::get('/editar/{id}', 'StudentController@edit');
    Route::put('/actualizar/{id}', 'StudentController@update');
    Route::delete('eliminar/{id}', 'StudentController@destroy');
    Route::get('/documentos/{id}', 'StudentController@Documents');
    Route::get('/consultar/{id}', 'StudentController@show');
    Route::post('/subir/documentos', 'StudentController@uploadDocuments');
    Route::get('/consultar/{id}', 'StudentController@searchStudent');
    Route::post('/procesar/inscripcion', 'StudentController@incscriptionStudent');
});

// Tecahers
Route::group(['prefix' => 'docentes'], function () {
    Route::get('/', 'TeacherController@index');
    Route::get('/datos', 'TeacherController@dataTeachers')->name('teachers.data');
    Route::get('/crear', 'TeacherController@create');
    Route::post('/guardar', 'TeacherController@store');
    Route::get('/editar/{id}', 'TeacherController@edit');
    Route::put('/actualizar/{id}', 'TeacherController@update');
    Route::delete('eliminar/{id}', 'TeacherController@destroy');
});

// Diplomats
Route::group(['prefix' => 'diplomados'], function () {
    Route::get('/', 'DiplomatController@index');
    Route::get('/datos', 'DiplomatController@dataDiplomats')->name('diplomats.data');
    Route::get('/crear', 'DiplomatController@create');
    Route::post('/guardar', 'DiplomatController@store');
    Route::get('/editar/{id}', 'DiplomatController@edit');
    Route::put('/actualizar/{id}', 'DiplomatController@update');
    Route::delete('eliminar/{id}', 'DiplomatController@destroy');
});

// Generations of Diplomats
Route::group(['prefix' => 'generaciones'], function () {
    Route::get('/', 'GenerationController@index');
    Route::get('/datos', 'GenerationController@dataGenerations')->name('generations.data');
    Route::get('/crear', 'GenerationController@create');
    Route::post('/guardar', 'GenerationController@store');
    Route::get('/editar/{id}', 'GenerationController@edit');
    Route::put('/actualizar/{id}', 'GenerationController@update');
    Route::delete('eliminar/{id}', 'GenerationController@destroy');

    Route::get('/alumnos/buscar', 'GenerationController@findStudent');
    Route::get('/alumnos/inscritos/{id}', 'GenerationController@studentsInscription');
    Route::get('/alumnos/{id}', 'GenerationController@students');
});

// Payments
Route::group(['prefix' => 'pagos'], function () {
    Route::get('/procesar', 'PaymentController@processPayment');
    Route::get('/generaciones/{id}', 'PaymentController@listGenerations');
    Route::get('/generaciones/alumnos/{id}', 'PaymentController@listStudents');
    Route::post('/recibir', 'PaymentController@received');
    Route::get('/ingresos', 'PaymentController@showReceiveds');
    Route::get('/recibidos', 'PaymentController@paymentReceiveds');
    Route::get('/deuda/{id}', 'PaymentController@debt');
});

// Expenses
Route::group(['prefix' => 'gastos'], function () {
    Route::get('/', 'ExpenseController@index');
    Route::get('/datos', 'ExpenseController@dataExpenses')->name('expenses.data');
    Route::get('/crear', 'ExpenseController@create');
    Route::post('/guardar', 'ExpenseController@store');
    Route::get('/editar/{id}', 'ExpenseController@edit');
    Route::put('/actualizar/{id}', 'ExpenseController@update');
    Route::delete('eliminar/{id}', 'ExpenseController@destroy');
});

// Messages
Route::group(['prefix' => 'mensajeria'], function () {
    Route::get('/crear', 'MessageController@create');
    Route::post('/enviar', 'MessageController@store');
});






