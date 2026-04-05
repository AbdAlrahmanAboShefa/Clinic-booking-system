<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index')->middleware('permission:settings.manage');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update')->middleware('permission:settings.manage');
    Route::get('/notifications/{id}/read', function (string $id) {
    $notification = Auth::user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    $appointmentId = $notification->data['appointment_id'] ?? null;
    return $appointmentId
        ? redirect()->route('appointments.show', $appointmentId)
        : back();
})->name('notifications.read');

Route::post('/notifications/mark-all-read', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return back();
})->name('notifications.markAllRead');
    Route::get('/patient/profile/create', [PatientController::class, 'createProfile'])->name('patient.profile.create');
    Route::post('/patient/profile', [PatientController::class, 'storeProfile'])->name('patient.profile.store');
    Route::get('/patient/profile/edit', [PatientController::class, 'editProfile'])->name('patient.profile.edit');
    Route::patch('/patient/profile', [PatientController::class, 'updateProfile'])->name('patient.profile.update');
Route::get('/appointments/report/pdf', [AppointmentController::class, 'downloadReport'])
    ->name('appointments.report.pdf')
    ->middleware('role:admin');
    Route::resource('patients', PatientController::class)
        ->middleware('permission:patients.view');

    Route::get('/appointments/available-slots', [AppointmentController::class, 'getAvailableSlots'])
        ->name('appointments.available-slots')
        ->middleware('permission:appointments.create');

    Route::resource('appointments', AppointmentController::class)
        ->middleware('permission:appointments.view');

    Route::post('/appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])
        ->name('appointments.confirm')
        ->middleware('permission:appointments.view');

    Route::post('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])
        ->name('appointments.reject')
        ->middleware('permission:appointments.view');

    Route::resource('doctors', DoctorController::class)
        ->middleware('permission:doctors.view');

    Route::resource('schedules', ScheduleController::class)
        ->middleware('permission:schedules.manage');

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/activity-log', [ActivityLogController::class, 'index'])->name('admin.activity-log.index');
        Route::get('/admin/activity-log/{activity}', [ActivityLogController::class, 'show'])->name('admin.activity-log.show');

        Route::get('/admin/permissions', [PermissionController::class, 'index'])->name('admin.permissions.index');
        Route::get('/admin/permissions/users', [PermissionController::class, 'assignRoleToUserPage'])->name('admin.permissions.users');
        Route::get('/admin/permissions/user/{user}/edit', [PermissionController::class, 'manageUserRoles'])->name('admin.permissions.user.edit');
        Route::patch('/admin/permissions/user/{user}/sync', [PermissionController::class, 'syncRolesToUser'])->name('admin.permissions.user.sync');
        Route::post('/admin/permissions/user/{user}/assign-role', [PermissionController::class, 'assignRoleToUser'])->name('admin.permissions.user.assign-role');
        Route::post('/admin/permissions/user/{user}/remove-role', [PermissionController::class, 'removeRoleFromUser'])->name('admin.permissions.user.remove-role');
        
        Route::get('/admin/permissions/role/{role}/edit', [PermissionController::class, 'manageRolePermissions'])->name('admin.permissions.role.edit');
        Route::patch('/admin/permissions/role/{role}/sync', [PermissionController::class, 'syncPermissionsToRole'])->name('admin.permissions.role.sync');
        Route::post('/admin/permissions/role/{role}/give', [PermissionController::class, 'givePermissionToRole'])->name('admin.permissions.role.give');
        Route::post('/admin/permissions/role/{role}/revoke', [PermissionController::class, 'revokePermissionFromRole'])->name('admin.permissions.role.revoke');
    });
    // PDF لـ appointment واحد
Route::get('/appointments/{appointment}/pdf', [AppointmentController::class, 'downloadPdf'])
    ->name('appointments.pdf')
    ->middleware('permission:appointments.view');

// PDF تقرير كل الـ appointments (admin فقط)

});

require __DIR__.'/auth.php';
