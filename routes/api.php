<?php

use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/latest', [BlogController::class, 'latestBlog']);
Route::get('/blogs/search', [BlogController::class, 'searchBlog']);
Route::get('/blogs/{slug}', [BlogController::class, 'show']);
Route::get('/blogs/category/{categoryId}', [BlogController::class, 'byCategory']);
