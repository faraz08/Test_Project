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

//Route::get('/', function () {
//    return view('case');
//});


//Route::get('/', function (\Illuminate\Http\Request $request) {
//    $user = $request->user();
//	dd($user);
//
//    dd($user->can('create-tasks'));
//});


Route::post('register-user', 'Users\RegisterController@register')->name('register-user');

Auth::routes();


Route::get('/', 'Dashboard\DashboardController@index')->name('dashboard');
//Route::get('dashboard', 'Cases\CaseController@caseList')->name('dashboard');


//Route::get('text', 'Dashboard\DashboardController@getCasesMonths')->name('text');
//Route::get('getMonthlyCasesCount', 'Dashboard\DashboardController@getMonthlyCasesCount')->name('getMonthlyCasesCount');


Route::get('dashboard', 'Dashboard\DashboardController@index')->name('dashboard');
Route::get('home', 'Dashboard\DashboardController@index')->name('home');
Route::get('getMonthlyCasesData', 'Dashboard\DashboardController@getMonthlyCasesData')->name('getMonthlyCasesData');

Route::get('create-case', 'Cases\CaseController@index')->name('create-case')->middleware('can:create-case,App\Model\Case');
Route::post('case-submit', 'Cases\CaseController@caseSubmit')->name('case-submit');
Route::post('edit-patient-case-submit', 'Cases\CaseController@editPatientCaseSubmit')->name('edit-patient-case-submit');
Route::get('case-list', 'Cases\CaseController@caseList')->name('case-list');
Route::post('get-case-numbers-ajax-call', 'Cases\CaseController@getCaseNumbers')->name('get-case-numbers-ajax-call');
Route::post('get-sidebar-search-ajax-call', 'Cases\CaseController@getCaseNumbersForSidebar')->name('get-sidebar-search-ajax-call');
Route::post('get-case-data-ajax-call', 'Cases\CaseController@getCasesData')->name('get-case-data-ajax-call');
Route::post('get-patient-revision-modal-ajax-call', 'Cases\CaseController@getPatientRevisionModal')->name('get-patient-revision-modal-ajax-call');
Route::post('del-patient-revision-ajax-call', 'Cases\CaseController@deletePatientRevision')->name('del-patient-revision-ajax-call');
Route::post('del-case-ajax-call', 'Cases\CaseController@deleteCase')->name('del-case-ajax-call');
Route::post('show-patient-modal-ajax-call', 'Cases\CaseController@showPatientModal')->name('show-patient-modal-ajax-call');
Route::post('show-patientList-modal-ajax-call', 'Cases\CaseController@showPatientListModal')->name('show-patientList-modal-ajax-call');
Route::post('get-roles-ajax-call', 'Cases\CaseController@getRolesAjaxCall')->name('get-roles-ajax-call');
Route::get('case-number-search', 'Cases\CaseController@caseNumberSearch')->name('case-number-search');
Route::post('search-case-list', 'Cases\CaseController@searchCaseList')->name('search-case-list');
Route::get('search-case-by-number', 'Cases\CaseController@searchCaseByNumber')->name('search-case-by-number');
Route::post('get-filtered-cases', 'Cases\CaseController@getFilteredCases')->name('get-filtered-cases');
Route::get('patient-case-edit/{patientId}', 'Cases\CaseController@caseEdit')->name('patient-case-edit');
Route::post('show-edit-case-modal-ajax-call', 'Cases\CaseController@showEditCaseModalAjaxCall')->name('show-edit-case-modal-ajax-call');
Route::post('dropzone-files', 'Cases\CaseController@dropzoneFiles')->name('dropzone-files');
//Route::post('del-dropzone-file', 'Cases\CaseController@delDropzoneFile')->name('del-dropzone-file');
Route::post('del-dropzone-file-related-to-patient', 'Cases\CaseController@delDropzoneFileRelatedtoPatient')->name('del-dropzone-file-related-to-patient');
Route::post('get-case-number-data-ajax-call', 'Cases\CaseController@getCaseNumberDataAjaxCall')->name('get-case-number-data-ajax-call');
//Route::get('{case_id}/{random_num}', 'Cases\CaseController@caseUrlView');


Route::get('num', 'Cases\CaseController@getMaxOccuringChar')->name('num');


Route::get('users', 'Users\UserController@index')->name('users');
Route::get('edit-Permissions/{slug}', 'Users\UserController@editPermissions')->name('edit-Permissions');
Route::post('user_permissions', 'Users\UserController@createRolePermissions')->name('user_permissions');
Route::post('edit-user_permissions', 'Users\UserController@editUserPermissions')->name('edit-user_permissions');
Route::post('user-status-change', 'Users\UserController@userStatusChange')->name('user-status-change');
Route::post('delete-user', 'Users\UserController@deleteUser')->name('delete-user');
Route::post('delete-user-role', 'Users\UserController@deleteUserRole')->name('delete-user-role');
Route::post('user-roles-permission', 'Users\UserController@createRolePermissions')->name('user-roles-permission');
Route::post('register-department', 'Users\UserController@registerDepartment')->name('register-department');
Route::post('department-details', 'Users\UserController@departmentDetails')->name('department-details');
Route::post('get-permissions', 'Users\UserController@getPermissions')->name('get-permissions');
Route::post('assign-user-department', 'Users\UserController@assignUserDepartment')->name('assign-user-department');
Route::post('delete-department', 'Users\UserController@deleteDepartment')->name('delete-department');
Route::get('user-profile/{user}', 'Users\UserController@userProfile')->name('user-profile');
Route::post('update-user-password', 'Users\UserController@updateUserPassword')->name('update-user-password');

Route::get('user-profile', function () {
    return view('users.user_profile');
});


////Route::group(['middleware' => 'role:admin'], function() {
//    Route::get('/admin', function() {
//        return 'Welcome Admin';
//    });
//});

Route::get('{case_id}/{random_num}', 'Cases\CaseController@caseUrlView');

Route::get('/home', 'HomeController@index')->name('home');
