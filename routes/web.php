<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Auth::routes();

Route::view('/chat', 'chat');

Route::resource('messages', 'App\Http\Controllers\MessageController')->only([
    'index',
    'store'
]);

Route::get('posts/{post}', function($slug){
    $path = __DIR__ . "/.../resources/posts/{$slug}.html";

    // dump, die, debug window in a 404 event
    // ddd($path);

    if(! file_exists($path)) {
        return redirect('/');
    }

    $post = file_get_contents($path);

    return view('post', [
        'post' => $post
    ]);
})->where('post', '[A-z_\-]+');