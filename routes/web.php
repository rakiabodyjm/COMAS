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

/*Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', 'DashboardController@index');

Route::get('/pogi.json', 'LoansController@autocomplete');


Route::get('/projects/locations', 'LocationsController@index');

Route::post('/projects/{projectsid}/edit/update', 'ProjectsController@update')->name('projects.update');

Route::get('projects/{projectsid}/edit', 'ProjectsController@edit');

Route::get('/projects/locations/{location}/edit');

// Route::get('projects/engineers', 'AssignmentsController@engineerview');
Route::get('projects', 'ProjectsController@index');
Route::post('projects/all', 'ProjectsController@store');

Route::get('/projects/all', 'ProjectsController@all');


Route::get('/projects/assign/try', 'AssignmentsController@try');

Route::get('/projects/assign', 'AssignmentsController@index')->name('assign.index');
Route::post('/projects/assign/', 'AssignmentsController@assignthatbitch')->name('assign.post');
Route::post('/projects/disassign', 'AssignmentsController@disassignthatbitch');
// Route::get('/projects/assign/try', function () {
//     return view('projects.assign.try');
// });


Route::get('/{ano}/try.json', 'AssignmentsController@feeder');

Route::get('/projects/{projectid}/', 'ProjectsController@show')->name('projects.show');

//Route::resource('/projects', 'ProjectsController');


Route::get('projects/locations/{location}/edit', 'LocationsController@edit');


Route::resource('/employees/skills', 'SkillsController');

//These are the employee Routes
Route::resource('employees', 'EmployeesController')->only(['index', 'store', 'edit', 'update']);


Route::resource('locations', 'LocationsController');



Route::resource('payroll', 'PayrollsController')->only(['index', 'create']);


Route::resource('/employees/deductions/loans', 'LoansController');

Route::get('/employees/{where}', 'SalaryDeductionsController@index')->name('saldec.index');
Route::get('/employees/{where}/{id}/edit', 'SalaryDeductionsController@edit')->name('saldec.edit');
Route::post('/employees/{where}/{id}/edit/post', 'SalaryDeductionsController@update')->name('saldec.update');

//Show employee
Route::get('/employees/summary/{id}', 'EmployeesController@show')->name('employee.show');
Route::get('/employees/summary/{id}/from/{dateFrom}/to/{dateTo}', 'PrintsController@employee')->name('employee.show');


Route::post('/employees/{where}/store', 'SalaryDeductionsController@store');

Route::get('/employees/{where}/{id}', 'SalaryDeductionsController@show');

Route::post('/employees/{where}/{id}', 'SalaryDeductionsController@add');


Route::get('/projects/{projectsid}/attendance', 'DTRsController@index');


Route::get('/employees/{where}/{id}', 'SalaryDeductionLogsController@show')->name('saldec.show');
Route::post('/employees/{where}/{id}/store', 'SalaryDeductionLogsController@store')->name('sallogs.store');

Route::get('/dates.json/{date}/{projectid}', 'LoansController@dates');

Route::get('/projects/{projectid}/attendance/{date}', 'AttendanceController@attendance')->name('attendance.view');
Route::post('/projects/{projectid}/attendance/{date}/post', 'AttendanceController@post')->name('attendance.post');
Route::post('/projects/{projectid}/attendance/{date}/update', 'AttendanceController@update')->name('attendance.update');
Route::post('/projects/{projectid}/attendance/{date}/summon', 'AttendanceController@summon')->name('attendance.summonpost');
Route::post('/projects/{projectid}/attendance/{date}/delete/{id}', 'AttendanceController@delete')->name('attendance.delete');
Route::post('/projects/{projectid}/attendance/{date}/deleteDTR/{dtrid}', 'AttendanceController@DTRdelete')->name('dtr.delete');

Route::post('/projects/cipher', 'AttendanceController@cipher')->name('attendance.cipher');



Route::get('/projects/{projectid}/summary/from/{datefrom}/to/{dateto}', 'PrintsController@project');


Route::post('/payroll/{projectid}/{datefrom}', 'PayrollsController@create')->name('prints.payroll');

Route::post('/payroll/datepost/{function}/{date}', 'PayrollsController@holidays')->name('payroll.holidaypost');
Route::get('/payroll/print/{projectid}/{datefrom}/{dateto}', 'PrintsController@payroll');
Route::get('/payroll/get/{projectid}/{projectdate}', 'PrintsController@finalPayroll');
Route::get('/chart', 'DashboardController@graph');
Route::get('/payroll/holiday', 'PrintsController@holiday');
Route::get('/singil/{date}', 'PrintsController@singil');
Route::post('/bayad', 'PrintsController@bayad');



Route::resource('inventorytransfer/inventory', 'InventoriesController');
Route::resource('inventorytransfer', 'InventoryTransfersController');
Route::post('/inventorytransfer/inventorytransfer/checkout', 'InventoryTransfersController@puta');
Route::post('/inventorytransfer/inventorytransfer/transfer', 'InventoryTransfersController@quantity');
Route::post('/inventorytransfer/inventorytransfer/materialdelete', 'InventoryTransfersController@materialdelete');


//request routes
Route::get('request', 'InventoryTransfersController@indexrequest');
//Route::resource('request', 'RequestsController');

Route::post('/request/{requestid}/delete', 'InventoryTransfersController@delete');
Route::post('/request/{requestid}/accept', 'InventoryTransfersController@accept');
Route::post('/post', 'InventoryTransfersController@request');

//Log Route
Route::get('logs', 'LogsController@index');
Route::resource('logs', 'LogsController');
