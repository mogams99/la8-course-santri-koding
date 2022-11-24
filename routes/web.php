<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/update/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/delete/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});
