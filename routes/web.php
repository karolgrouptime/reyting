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

Route::get('/bestGroups', [DashboardController::class, 'bestGroups']);
Route::get('/worseGroups', [DashboardController::class, 'bestGroups']);

//Route::get('/', [DashboardController::class,'index'])->name('dashboard');

//Route::get('/reyting', [DashboardController::class,'reyting'])->name('reyting');

Route::post('/bests/api', [DashboardController::class, 'bestsApi'])->name('bests.Api');
Route::post('/WorseStudens/api', [DashboardController::class, 'WorseStudentsApi'])->name('WorseStudens.Api');

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

//Route::get('dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/admins', [UserController::class, 'admins'])->name('admins');
    // USERS
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/delete/{user}', [UserController::class, 'delete'])->name('delete');
        Route::get('/block/{user}', [UserController::class, 'block'])->name('block');
        Route::get('/open/{user}', [UserController::class, 'open'])->name('open');
        Route::get('/permissions/{user}', [UserController::class, 'permissions'])->name('permissions');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
        Route::get('/profile/{user}', [UserController::class, 'profile'])->name('profile');
        Route::post('/api', [UserController::class, 'getUsersApi'])->name('api');
    });

    // ROLES
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::post('/update', [RoleController::class, 'update'])->name('update');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}/delete', [RoleController::class, 'delete'])->name('delete');
    });

    // PERMISSIONS
    Route::prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'permissions'])->name('index');
        Route::get('/{perm}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::post('/{perm}/update', [PermissionController::class, 'update'])->name('update');
        Route::post('/store', [PermissionController::class, 'store'])->name('store');
        Route::get('/delete', [PermissionController::class, 'delete'])->name('delete');
    });

    // TEACHERS
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [TeacherController::class, 'teachers'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/store', [TeacherController::class, 'store'])->name('store');
        Route::get('/{teacher}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::get('/{teacher}/edit/dekan', [TeacherController::class, 'teacherEdit'])->name('teacherEdit');
        Route::post('/{teacher}/update/dekan', [TeacherController::class, 'teacherUpdate'])->name('teacherUpdate');
        Route::post('/{teacher}/update', [TeacherController::class, 'update'])->name('update');
        Route::get('/{teacher}/delete', [TeacherController::class, 'delete'])->name('delete');
        Route::get('/{teacher}/profile', [TeacherController::class, 'profile'])->name('profile');
        Route::post('/api', [TeacherController::class, 'getTeachersApi'])->name('api');
        Route::get('/groups', [TeacherController::class, 'teacherGroups'])->name('groups');
        Route::post('/groupsApi', [TeacherController::class, 'teacherGroupsApi'])->name('groupsApi');
        Route::get('/group/subjects/{group}', [TeacherController::class, 'groupSubjects'])->name('groupSubjects');
        Route::post('/getSubjectsOfGroupApi', [TeacherController::class, 'getSubjectsOfGroupApi'])->name('groupSubjects.api');
        Route::get('/groupSubject/{group?}/{subject?}/{semester?}/{rate_can?}', [TeacherController::class, 'groupSubject'])->name('groupSubject');
    });

    // STUDENTS
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'students'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/store', [StudentController::class, 'store'])->name('store');
        Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::post('/{student}/update', [StudentController::class, 'update'])->name('update');
        Route::get('/{student}/delete', [StudentController::class, 'delete'])->name('delete');
        Route::get('/{student}/profile', [StudentController::class, 'profile'])->name('profile');
        Route::post('/api', [StudentController::class, 'getStudentsApi'])->name('api');
        Route::get('/block/{student}', [StudentController::class, 'block'])->name('block');
        Route::get('/open/{student}', [StudentController::class, 'open'])->name('open');
    });

    // GROUPS
    Route::prefix('groups')->name('groups.')->group(function () {
        Route::post('/api', [GroupController::class, 'getGroupsApi'])->name('api');
        Route::post('/store', [GroupController::class, 'store'])->name('store');
        Route::get('/delete/{group}', [GroupController::class, 'delete'])->name('delete');
        Route::get('/edit/{group}', [GroupController::class, 'edit'])->name('edit');
        Route::post('/update/{group}', [GroupController::class, 'update'])->name('update');
        Route::get('/block/{group}', [GroupController::class, 'block'])->name('block');
        Route::get('/open/{group}', [GroupController::class, 'open'])->name('open');
    });
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
