<?php


use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;

use App\Http\Controllers\PersonalInformationController;
use App\Http\Controllers\EmergencyContactController;
use App\Http\Controllers\EducationalQualificationController;
use App\Http\Controllers\ProgramChoiceController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {

    // Route::middleware('auth:sanctum')->get('/users', [UsersController::class, 'index']);

    Route::prefix('users')->group(function () {
        // Get all users
        Route::get('/', [UsersController::class, 'index'])->name('users.index');

        // Create a new user
        Route::post('/', [UsersController::class, 'store'])->name('users.store');

        // Get a specific user
        Route::get('/{user}', [UsersController::class, 'show'])->name('users.show');

        // Update a specific user
        Route::put('/{user}', [UsersController::class, 'update'])->name('users.update');

        // Delete a specific user
        Route::delete('/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

        // Assign roles to a user
        Route::post('/{user}/roles/assign', [UsersController::class, 'assignRole'])->name('users.assignRole');

        // Remove roles from a user
        Route::post('/{user}/roles/remove', [UsersController::class, 'removeRole'])->name('users.removeRole');

        // Sync roles for a user (replace existing roles with new ones)
        Route::post('/{user}/roles/sync', [UsersController::class, 'syncRoles'])->name('users.syncRoles');
    });


    Route::prefix('roles')->group(function () {
        // Get all roles
        Route::get('/', [RolesController::class, 'index'])->name('roles.index');

        // Create a new role
        Route::post('/', [RolesController::class, 'store'])->name('roles.store');

        // Get a specific role
        Route::get('/{role}', [RolesController::class, 'show'])->name('roles.show');

        // Update a specific role
        Route::put('/{role}', [RolesController::class, 'update'])->name('roles.update');

        // Delete a specific role
        Route::delete('/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');

        // Attach a permission to a role
        Route::post('/{role}/permissions/attach', [RolesController::class, 'attachPermission'])
            ->name('roles.attachPermission');

        // Detach a permission from a role
        Route::post('/{role}/permissions/detach', [RolesController::class, 'detachPermission'])
            ->name('roles.detachPermission');
    });


// Route::get('/view-file/{id}',  App\Http\Controllers\UploadDocController::class, 'viewFile');

    Route::apiResource('years', App\Http\Controllers\YearController::class);

      Route::get('/personal-information', [PersonalInformationController::class, 'index']);
    Route::post('/personal-information', [PersonalInformationController::class, 'store']);
    Route::get('/personal-information/{personalInformation}', [PersonalInformationController::class, 'show']);
    Route::put('/personal-information/{personalInformation}', [PersonalInformationController::class, 'update']);
    Route::delete('/personal-information/{personalInformation}', [PersonalInformationController::class, 'destroy']);
    Route::post('/personal-information/{personalInformation}/complete', [PersonalInformationController::class, 'markAsComplete']);

    // Emergency Contact Routes (nested under personal information)
    Route::get('/personal-information/{personalInformation}/emergency-contacts', [EmergencyContactController::class, 'index']);
    Route::post('/personal-information/{personalInformation}/emergency-contacts', [EmergencyContactController::class, 'store']);
    Route::get('/emergency-contacts/{emergencyContact}', [EmergencyContactController::class, 'show']);
    Route::put('/emergency-contacts/{emergencyContact}', [EmergencyContactController::class, 'update']);
    Route::delete('/emergency-contacts/{emergencyContact}', [EmergencyContactController::class, 'destroy']);
    Route::post('/emergency-contacts/{emergencyContact}/complete', [EmergencyContactController::class, 'markAsComplete']);

    // Educational Qualification Routes (nested under personal information)
    Route::get('/personal-information/{personalInformation}/educational-qualifications', [EducationalQualificationController::class, 'index']);
    Route::post('/personal-information/{personalInformation}/educational-qualifications', [EducationalQualificationController::class, 'store']);
    Route::get('/educational-qualifications/{educationalQualification}', [EducationalQualificationController::class, 'show']);
    Route::put('/educational-qualifications/{educationalQualification}', [EducationalQualificationController::class, 'update']);
    Route::delete('/educational-qualifications/{educationalQualification}', [EducationalQualificationController::class, 'destroy']);
    Route::post('/educational-qualifications/{educationalQualification}/complete', [EducationalQualificationController::class, 'markAsComplete']);

    // Program Choice Routes (nested under personal information)
    Route::get('/personal-information/{personalInformation}/program-choices', [ProgramChoiceController::class, 'index']);
    Route::post('/personal-information/{personalInformation}/program-choices', [ProgramChoiceController::class, 'store']);
    Route::get('/program-choices/{programChoice}', [ProgramChoiceController::class, 'show']);
    Route::put('/program-choices/{programChoice}', [ProgramChoiceController::class, 'update']);
    Route::delete('/program-choices/{programChoice}', [ProgramChoiceController::class, 'destroy']);
    Route::post('/program-choices/{programChoice}/complete', [ProgramChoiceController::class, 'markAsComplete']);

    // Document Routes (nested under personal information)
    Route::get('/personal-information/{personalInformation}/documents', [DocumentController::class, 'index']);
    Route::post('/personal-information/{personalInformation}/documents', [DocumentController::class, 'store']);
    Route::get('/documents/{document}', [DocumentController::class, 'show']);
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy']);
    Route::post('/documents/{document}/complete', [DocumentController::class, 'markAsComplete']);
});