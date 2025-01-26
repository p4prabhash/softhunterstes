<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\ApproveAuthorizationController;
use Laravel\Passport\Http\Controllers\DenyAuthorizationController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Laravel\Passport\Http\Controllers\ClientController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\ScopeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])->middleware('throttle');
Route::get('/oauth/authorize', [AuthorizationController::class, 'authorize']);
Route::post('/oauth/authorize', [ApproveAuthorizationController::class, 'approve']);
Route::delete('/oauth/authorize', [DenyAuthorizationController::class, 'deny']);
Route::get('/oauth/scopes', [ScopeController::class, 'all']);
Route::get('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'index']);
Route::post('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'store']);
Route::delete('/oauth/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy']);
