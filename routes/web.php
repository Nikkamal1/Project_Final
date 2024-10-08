<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminReportsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LineNotifyController;



// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});
// Authentication routes
Auth::routes();

// Middleware for authentication
Route::middleware('auth')->group(function () {
    // Routes for Admin
    Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {
        Route::resource('admin/appointments', AppointmentController::class)->names([
            'index' => 'admin.appointments.index',
            'create' => 'admin.appointments.create',
            'store' => 'admin.appointments.store',
            'show' => 'admin.appointments.show',
            'edit' => 'admin.appointments.edit',
            'update' => 'admin.appointments.update',
            'destroy' => 'admin.appointments.destroy',
        ]);
        // routes/web.php

Route::prefix('admin')->middleware('auth')->group(function () {
    // Route for listing all users
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    
    // Route for showing the form to create a new user
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    
    // Route for storing a newly created user
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    
    // Route for showing the form to edit a user
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    
    // Route for updating a user
    Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    
    // Route for deleting a user
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
        Route::resource('admin/assessments', AssessmentController::class)->names([
            'index' => 'admin.assessments.index',
            'create' => 'admin.assessments.create',
            'store' => 'admin.assessments.store',
            'show' => 'admin.assessments.show',
            'edit' => 'admin.assessments.edit',
            'update' => 'admin.assessments.update',
            'destroy' => 'admin.assessments.destroy',
        ]);
        Route::get('/admin/reports', [AdminReportsController::class, 'index'])->name('admin.reports');
        Route::resource('history', HistoryController::class)->names([
            'index' => 'admin.history.index',
            'create' => 'admin.history.create',
            'store' => 'admin.history.store',
            'show' => 'admin.history.show',
            'edit' => 'admin.history.edit',
            'update' => 'admin.history.update',
            'destroy' => 'admin.history.destroy',
        ]);
        
        Route::get('home', [HomeController::class, 'adminHome'])->name('admin.home');
    });

   // Routes for Staff
Route::prefix('staff')->middleware(['auth', 'is_staff'])->group(function () {
    Route::get('appointments/createForUser', [AppointmentController::class, 'createForUser'])->name('staff.appointments.createForUser');

    Route::resource('staff/appointments', AppointmentController::class)->names([
        'index' => 'staff.appointments.index',
        'create' => 'staff.appointments.create',
        'store' => 'staff.appointments.store',
        'show' => 'staff.appointments.show',
        'edit' => 'staff.appointments.edit',
        'update' => 'staff.appointments.update',
        'destroy' => 'staff.appointments.destroy',
    ]);
    
    Route::resource('staff/assessments', AssessmentController::class)->names([
        'index' => 'staff.assessments.index',
        'create' => 'staff.assessments.create',
        'store' => 'staff.assessments.store',
        'show' => 'staff.assessments.show',
        'edit' => 'staff.assessments.edit',
        'update' => 'staff.assessments.update',
        'destroy' => 'staff.assessments.destroy',
    ]);
    Route::resource('history', HistoryController::class)->names([
        'index' => 'staff.history.index',
        'create' => 'staff.history.create',
        'store' => 'staff.history.store',
        'show' => 'staff.history.show',
        'edit' => 'staff.history.edit',
        'update' => 'staff.history.update',
        'destroy' => 'staff.history.destroy',
    ]);
    Route::get('home', [HomeController::class, 'staffHome'])->name('staff.home');
});


    // Routes for User
    Route::middleware(['auth'])->group(function () {
        Route::resource('appointments', AppointmentController::class)->names([
            'index' => 'user.appointments.index',
            'create' => 'user.appointments.create',
            'store' => 'user.appointments.store',
            'show' => 'user.appointments.show',
            'edit' => 'user.appointments.edit',
            'update' => 'user.appointments.update',
            'destroy' => 'user.appointments.destroy',
        ]);
        Route::resource('assessments', AssessmentController::class)->names([
            'index' => 'user.assessments.index',
            'create' => 'user.assessments.create',
            'store' => 'user.assessments.store',
            'show' => 'user.assessments.show',
            'edit' => 'user.assessments.edit',
            'update' => 'user.assessments.update',
            'destroy' => 'user.assessments.destroy',
        ]);
        Route::get('/user/appointments/calendar', [AppointmentController::class, 'calendar'])->name('user.appointments.calendar');
        Route::resource('user/histories', HistoryController::class)->names([
            'index' => 'user.history.index',
            'create' => 'user.history.create',
            'store' => 'user.history.store',
            'show' => 'user.history.show',
            'edit' => 'user.history.edit',
            'update' => 'user.history.update',
            'destroy' => 'user.history.destroy',
        ]);
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('user.profile.password.update');

        Route::get('home', [HomeController::class, 'userHome'])->name('user.home');
    });
    // Route for LINE Notify
    Route::get('/line/authorize', [LineNotifyController::class, 'redirectToLineNotify'])->name('line.notify.authorize');
    Route::get('/callback', [LineNotifyController::class, 'handleCallback'])->name('line.notify.callback');

   

Route::post('/appointments/{id}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');

});

