<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
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
    echo "hello there";
    return view('welcome');
});

Route::get('/home', function() {
    return Inertia::render('Home');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/blog', [BlogController::class, 'show']);

require __DIR__.'/auth.php';
