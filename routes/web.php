<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\StudentRankController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\LessonAssessmentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\GroupSubjectController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\EduDepartmentController;
use App\Http\Controllers\SherdulleController;
use App\Http\Controllers\StudentConfigureController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ServiceManInfoController;
use App\Http\Controllers\SubscriptionTypeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\DegreController;
/* dashboard */
Route::get('/bestGroups',[DashboardController::class, 'bestGroups']);
Route::get('/worseGroups', [DashboardController::class,'bestGroups']);

//Route::get('/', [DashboardController::class,'index'])->name('dashboard');
//Route::get('/reyting', [DashboardController::class,'reyting'])->name('reyting');

Route::post('/bests/api', [DashboardController::class, 'bestsApi'])->name('bests.Api');
Route::post('/WorseStudens/api', [DashboardController::class, 'WorseStudentsApi'])->name('WorseStudens.Api');

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/admins', [UserController::class, 'admins'])->name('admins');

     /* users */
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/delete/{user_id}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('/user/block/{user_id}', [UserController::class, 'block'])->name('user.block');
    Route::get('/user/open/{user_id}', [UserController::class, 'open'])->name('user.open');
    Route::get('/user/permissions/{user_id}', [UserController::class, 'permissions'])->name('user.permissions');
    Route::get('/user/edit/{user_id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{user_id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/user/profile/{user_id}', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/userApi', [UserController::class, 'getUsersApi'])->name('user.api');

    /* role */
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
    Route::get('/role/{role_id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('/role/update', [RoleController::class, 'update'])->name('role.update');
    Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{role_id}/delete', [RoleController::class, 'delete'])->name('role.delete');
    /* role */

    /* permissions */
    Route::get('/permissions', [PermissionController::class, 'permissions'])->name('permissions');
    Route::get('/permission/{perm_id}/edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('/permission/{perm_id}/update', [PermissionController::class, 'update'])->name('permission.update');
    Route::post('/permission/store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission/delete', [PermissionController::class, 'delete'])->name('permission.delete');
    /* permissions */

    /* teachers */
    Route::get('/teachers', [TeacherController::class, 'teachers'])->name('teachers');
    Route::get('/teacher/create', [TeacherController::class, 'create'])->name('teacher.create');
    Route::post('/teacher/store', [TeacherController::class, 'store'])->name('teacher.store');
    Route::get('/teacher/{teacher_id}/edit', [TeacherController::class, 'edit'])->name('teacher.edit');
    Route::get('/teacher/{teacher_id}/edit/dekan', [TeacherController::class, 'teacherEdit'])->name('teacher.teacherEdit');
    Route::post('/teacher/{teacher_id}/update/dekan', [TeacherController::class, 'teacherUpdate'])->name('teacher.teacherUpdate');
    Route::post('/teacher/{teacher_id}/update', [TeacherController::class, 'update'])->name('teacher.update');
    Route::get('/teacher/{teacher_id}/delete', [TeacherController::class, 'delete'])->name('teacher.delete');
    Route::get('/teacher/{teacher_id}/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
    Route::post('/teacherApi', [TeacherController::class, 'getTeachersApi'])->name('teacher.api');
    /* teacher group journals */
    Route::get('/teacher/groups', [TeacherController::class, 'teacherGroups'])->name('teacher.groups');
    Route::post('/teacher/groupsApi', [TeacherController::class, 'teacherGroupsApi'])->name('teacher.groupsApi');
    /* teacher group subjects */
    Route::get('/teacher/group/subjects/{group_id}', [TeacherController::class, 'groupSubjects'])->name('teacher.groupSubjects');
    Route::post('/teacher/getSubjectsOfGroupApi', [TeacherController::class, 'getSubjectsOfGroupApi'])->name('teacher.groupSubjects.api');
    Route::get('/teacher/groupSubject/{group_id?}/{subject_id?}/{semester_id?}/{rate_can?}', [TeacherController::class, 'groupSubject'])->name('teacher.groupSubject');
    /* students */
    Route::get('/students', [StudentController::class, 'students'])->name('students');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student/store', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{student_id}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/student/{student_id}/update', [StudentController::class, 'update'])->name('student.update');
    Route::get('/student/{student_id}/delete', [StudentController::class, 'delete'])->name('student.delete');
    Route::get('/student/{student_id}/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::post('/studentApi', [StudentController::class, 'getStudentsApi'])->name('student.api');
    Route::get('/student/block/{student_id}', [StudentController::class, 'block'])->name('student.block');
    Route::get('/student/open/{student_id}', [StudentController::class, 'open'])->name('student.open');

    /* groups */
    Route::post('/groupApi', [GroupController::class, 'getGroupsApi'])->name('group.api');
    Route::post('/group/store', [GroupController::class, 'store'])->name('group.store');
    Route::get('/group/delete/{group_id}', [GroupController::class, 'delete'])->name('group.delete');
    Route::get('/group/edit/{group_id}', [GroupController::class, 'edit'])->name('group.edit');
    Route::post('/group/update/{group_id}', [GroupController::class, 'update'])->name('group.update');
    Route::get('/group/block/{group_id}', [GroupController::class, 'block'])->name('group.block');
    Route::get('/group/open/{group_id}', [GroupController::class, 'open'])->name('group.open');
    /* Other Routes are similar... */

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
