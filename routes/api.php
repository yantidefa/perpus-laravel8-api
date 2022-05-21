<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//member
// Route::apiResource('/members', [App\Http\Controllers\Api\MemberController::class]);
Route::get('/members', [App\Http\Controllers\Api\MemberController::class, 'index']);
Route::post('/members/create', [App\Http\Controllers\Api\MemberController::class, 'store']);
Route::get('/members/{member}', [App\Http\Controllers\Api\MemberController::class, 'show']);
Route::put('/members/update/{member}', [App\Http\Controllers\Api\MemberController::class, 'update']);
Route::delete('/members/delete/{member}', [App\Http\Controllers\Api\MemberController::class, 'destroy']);

//book
Route::get('/books', [App\Http\Controllers\Api\BookController::class, 'index']);
Route::post('/books/create', [App\Http\Controllers\Api\BookController::class, 'store']);
Route::get('/books/{book}', [App\Http\Controllers\Api\BookController::class, 'show']);
Route::put('/books/update/{book}', [App\Http\Controllers\Api\BookController::class, 'update']);
Route::delete('/books/delete/{book}', [App\Http\Controllers\Api\BookController::class, 'destroy']);

//borrow
Route::get('/borrow', [App\Http\Controllers\Api\BorrowController::class, 'index']);
Route::get('/borrow/{borrow}', [App\Http\Controllers\Api\BorrowController::class, 'show']);
Route::post('/borrow/create', [App\Http\Controllers\Api\BorrowController::class, 'store']);
Route::put('/borrow/update/{borrow}', [App\Http\Controllers\Api\BorrowController::class, 'update']);
Route::delete('/borrow/delete/{borrow}', [App\Http\Controllers\Api\BorrowController::class, 'destroy']);