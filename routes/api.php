<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ApiAdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('/signup', [ApiAdminController::class, 'signup']);
Route::post('/login', [ApiAdminController::class, 'login']);
Route::post('/teachers', [ApiAdminController::class, 'insertTeacher']);
Route::delete('/teachers/{id}', [ApiAdminController::class, 'deleteTeacher']);
Route::put('/teachers/{id}', [ApiAdminController::class, 'updateTeacher']);
Route::post('/department', [ApiAdminController::class, 'insertDepartment']);
Route::delete('/department/{id}', [ApiAdminController::class, 'deleteDepartment']);
Route::put('/department/{id}', [ApiAdminController::class, 'updateDepartment']);
Route::post('/department/{department_name}', [ApiAdminController::class, 'assignHod']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





