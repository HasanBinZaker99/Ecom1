<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    // Admin Login Route without admin group
    Route::match(['get','post'],'login','AdminController@login');
    // Admin dashboard route without admin group
    //Route::get('dashboard','AdminController@dashboard');
    Route::group(['middleware' => ['admin']],function(){
        Route::get('dashboard','AdminController@dashboard');
        //Admin Logout
        Route::get('logout','AdminController@logout');
        //Update Password
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');
        //Check Admin Password
        Route::post('check-admin-password','AdminController@checkAdminPassword');
        // Update Admin Details
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');
    });
});


