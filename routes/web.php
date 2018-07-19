<?php

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

use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    Mail::raw('Hello world', function ($message) {
            $message->to('foo@bar.com');
        $message->from('bar@foo.com');
    });

    return view('welcome');
});

Route::view('feedback', 'feedback');