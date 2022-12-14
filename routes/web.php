<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

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
/**
 * Common route for public view
 */
Route::get('/', [PublicController::class, 'getIndexView']);
/**
 * Route for AJAX call
 */
Route::post('/getData', [PublicController::class, 'getFreshData']);
