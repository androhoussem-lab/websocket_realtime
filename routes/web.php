<?php

use App\Events\WebSocketDemoEvent;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

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
    //broadcast(new WebSocketDemoEvent('some data'));
    return view('welcome');
});

Route::get('/chat', 'ChatController@index' );








Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
