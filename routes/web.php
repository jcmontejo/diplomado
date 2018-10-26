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

// Students
Route::group(['prefix' => 'alumnos'], function () {
    Route::get('/', 'StudentController@index');
    Route::get('/datos', 'StudentController@dataStudents')->name('students.data');
    Route::get('/crear', 'StudentController@create');
    Route::post('/guardar', 'StudentController@store');
    Route::get('/editar/{id}', 'StudentController@edit');
    Route::put('/actualizar/{id}', 'StudentController@update');
    Route::delete('eliminar/{id}', 'StudentController@destroy');
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

