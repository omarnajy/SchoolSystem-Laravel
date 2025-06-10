<?php


use App\Http\Controllers\StudentController;
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
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::get('/profile/edit', 'HomeController@profileEdit')->name('profile.edit');
Route::put('/profile/update', 'HomeController@profileUpdate')->name('profile.update');
Route::get('/profile/changepassword', 'HomeController@changePasswordForm')->name('profile.change.password');
Route::post('/profile/changepassword', 'HomeController@changePassword')->name('profile.changepassword');

// Routes pour tous les utilisateurs authentifiés
Route::group(['middleware' => ['auth']], function () {
    // Voir son propre emploi du temps (étudiants et enseignants)
    Route::get('my-schedule', 'ScheduleController@show')->name('schedules.my.show');

    // Accès aux présences pour tous les rôles (avec restrictions dans le contrôleur)
    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');
    
});

Route::group(['middleware' => ['auth','role:Admin']], function () 
{
    Route::get('/roles-permissions', 'RolePermissionController@roles')->name('roles-permissions');
    Route::get('/role-create', 'RolePermissionController@createRole')->name('role.create');
    Route::post('/role-store', 'RolePermissionController@storeRole')->name('role.store');
    Route::get('/role-edit/{id}', 'RolePermissionController@editRole')->name('role.edit');
    Route::put('/role-update/{id}', 'RolePermissionController@updateRole')->name('role.update');

    Route::get('/permission-create', 'RolePermissionController@createPermission')->name('permission.create');
    Route::post('/permission-store', 'RolePermissionController@storePermission')->name('permission.store');
    Route::get('/permission-edit/{id}', 'RolePermissionController@editPermission')->name('permission.edit');
    Route::put('/permission-update/{id}', 'RolePermissionController@updatePermission')->name('permission.update');

    Route::get('assign-subject-to-class/{id}', 'GradeController@assignSubject')->name('class.assign.subject');
    Route::post('assign-subject-to-class/{id}', 'GradeController@storeAssignedSubject')->name('store.class.assign.subject');

    Route::resource('assignrole', 'RoleAssign');
    Route::resource('classes', 'GradeController');
    Route::resource('subject', 'SubjectController');
    Route::resource('teacher', 'TeacherController');
    Route::resource('parents', 'ParentsController');
    Route::resource('student', 'StudentController');
    //Route::get('attendance', 'AttendanceController@index')->name('attendance.index');

    // Routes pour la gestion des paiements
    Route::resource('payments', 'PaymentController');
    Route::post('payments/{payment}/mark-paid', 'PaymentController@markAsPaid')->name('payments.mark-paid');
    Route::get('payments-bulk-create', 'PaymentController@bulkCreate')->name('payments.bulk-create');
    Route::post('payments-bulk-store', 'PaymentController@bulkStore')->name('payments.bulk-store');
    Route::get('payments-update-overdue', 'PaymentController@updateOverduePayments')->name('payments.update-overdue');

    // Gestion complète des emplois du temps
    Route::resource('schedules', 'ScheduleController');
    
    // Routes spéciales pour les emplois du temps
    Route::get('schedules-bulk-create', 'ScheduleController@bulkCreate')->name('schedules.bulk-create');
    Route::post('schedules-bulk-store', 'ScheduleController@bulkStore')->name('schedules.bulk-store');
    Route::get('schedules-available-slots', 'ScheduleController@getAvailableSlots')->name('schedules.get-available-slots');
    
    // Voir l'emploi du temps d'une classe spécifique
    Route::get('schedules/class/{id}', 'ScheduleController@showClassSchedule')->name('schedules.class.show');
    
    // Voir l'emploi du temps d'un enseignant spécifique
    Route::get('schedules/teacher/{id}', 'ScheduleController@showTeacherSchedule')->name('schedules.teacher.show');

    // Routes pour les étudiants
    Route::get('students/download-template/{type?}', 'StudentController@downloadTemplate')->name('students.download-template');
    Route::post('students/bulk-import', 'StudentController@bulkImport')->name('students.bulk-import');

     // Routes pour les enseignants
    Route::get('teachers/download-template/{type?}', 'TeacherController@downloadTemplate')->name('teachers.download-template');
    Route::post('teachers/bulk-import', 'TeacherController@bulkImport')->name('teachers.bulk-import');

    // Routes pour les matières 
    Route::get('subjects/download-template/{type?}', 'SubjectController@downloadTemplate')->name('subjects.download-template');
    Route::post('subjects/bulk-import', 'SubjectController@bulkImport')->name('subjects.bulk-import');

    // Routes pour les parents 
    Route::get('parents/download-template/{type?}', 'ParentsController@downloadTemplate')->name('parents.download-template');
    Route::post('parents/bulk-import', 'ParentsController@bulkImport')->name('parents.bulk-import');

});

Route::group(['middleware' => ['auth','role:Teacher']], function () 
{
    Route::post('attendance', 'AttendanceController@store')->name('teacher.attendance.store');
    Route::get('attendance-create/{classid}', 'AttendanceController@createByTeacher')->name('teacher.attendance.create');

    Route::get('my-teacher-schedule', 'ScheduleController@showTeacherSchedule')->name('teacher.schedule.show');

});

Route::group(['middleware' => ['auth','role:Parent']], function () 
{
    Route::get('attendance/{attendance}', 'AttendanceController@show')->name('attendance.show');
    Route::get('schedules/student/{studentId}', 'ScheduleController@showStudentSchedule')->name('schedules.student.show');

    Route::get('my-payments', 'PaymentController@parentPayments')->name('parent.payments.index');
});

Route::group(['middleware' => ['auth','role:Student']], function () {


});


