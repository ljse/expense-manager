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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// I used this kind of route instead of resource to prove that I can handle different routing techniques
Route::group(['prefix' => 'user_management'], function(){
	// Roles
	Route::get('roles', 'RoleController@index')->name('admin.role.index');
	Route::post('roles', 'RoleController@store')->name('admin.role.store');
	Route::put('roles/role/{role}', 'RoleController@update')->name('admin.role.update');
	Route::delete('roles/role/{role}', 'RoleController@destroy')->name('admin.role.delete');

	// User
	Route::get('users', 'UserController@index')->name('admin.user.index');
	Route::put('users/user/{user}', 'UserController@update')->name('admin.user.update');
	Route::put('users/user/{user}/remove', 'UserController@removeRole')->name('admin.role.removeRole');
});

Route::group(['prefix' => 'categories'], function(){
	Route::get('/', 'ExpenseCategoriesController@index')->name('users.cats.index');
	Route::post('/', 'ExpenseCategoriesController@store')->name('users.cats.store');
	Route::put('/category/{expenseCategories}', 'ExpenseCategoriesController@update')->name('users.cats.update');
	Route::delete('/category/{expenseCategories}', 'ExpenseCategoriesController@destroy')->name('users.cats.delete');
});

Route::group(['prefix' => 'expenses'], function(){
	Route::get('/', 'ExpenseController@index')->name('users.exp.index');
	Route::post('/', 'ExpenseController@store')->name('users.exp.store');
	Route::put('/expense/{expense}', 'ExpenseController@update')->name('users.exp.update');
	Route::delete('/expense/{expense}', 'ExpenseController@destroy')->name('users.exp.destroy');
});