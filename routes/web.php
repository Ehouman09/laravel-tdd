<?php
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MessagesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', LoginController::class)->name('login');
    Route::post('login', [LoginController::class, 'login']);
});


Route::delete('logout', LogoutController::class);

Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('contacts', ContactsController::class)->names('contacts');

    Route::get('/messages/create', [MessagesController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessagesController::class, 'send'])->name('messages.send');

});