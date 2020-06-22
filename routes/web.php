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

Route::get('/home', 'DashboardController@index');

Auth::routes();

Route::resource('/alternative_currencies', 'Alternative_currenciesController');

Route::post('/arms/addclassteacher', 'ArmsController@addclassteacher')->name('arms.addclassteacher');
Route::resource('/arms', 'ArmsController');

Route::resource('/calendars', 'CalendarsController');

Route::resource('/classes', 'ClassesController');

Route::resource('/classsubjects', 'ClasssubjectsController');

Route::get('/dashboard/relogin', 'DashboardController@relogin')->name('dashboard.relogin');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/directors/new', 'DirectorsController@new')->name('directors.new');
Route::post('/directors/add', 'DirectorsController@add')->name('directors.add');
Route::resource('/directors', 'DirectorsController');

Route::resource('/enrolments', 'EnrolmentsController');

Route::resource('/guardians', 'GuardiansController');

Route::resource('/items', 'ItemsController');

Route::get('/orders/all', 'OrdersController@all')->name('orders.all');
Route::get('/orders/detail/{id}', 'OrdersController@detail')->name('orders.detail');
Route::put('orders/changedetail/{id}', 'OrdersController@changedetail')->name('orders.changedetail');
Route::resource('/orders', 'OrdersController');

Route::resource('/packages', 'PackagesController');

Route::resource('/payments', 'PaymentsController');

Route::resource('/products', 'ProductsController');

Route::resource('/results', 'ResultsController');

Route::resource('/resulttemplates', 'ResulttemplatesController');

Route::get('/schools/all', 'SchoolsController@all')->name('schools.all');
Route::resource('/schools', 'SchoolsController');

Route::resource('/settings', 'SettingsController');

Route::get('/staff/new', 'StaffController@new')->name('staff.new');
Route::post('/staff/add', 'StaffController@add')->name('staff.add');
Route::resource('/staff', 'StaffController');

Route::resource('/students', 'StudentsController');

Route::resource('/subjects', 'SubjectsController');

Route::get('/subscriptions/buy/{id}', 'SubscriptionsController@buy')->name('subscriptions.buy');
Route::resource('/subscriptions', 'SubscriptionsController');

Route::resource('/terms', 'TermsController');

Route::get('users/profile/edit', 'UsersController@profileedit')->name('profile.edit');
Route::put('users/profile', 'UsersController@profileupdate')->name('profile.update');
Route::get('users/profile', 'UsersController@profile')->name('users.profile');
Route::put('users/changepassword/{user}', 'UsersController@changepassword')->name('users.changepassword');
Route::put('users/changeuserpassword/{user}', 'UsersController@changeuserpassword')->name('users.changeuserpassword');
Route::resource('/users', 'UsersController');

Route::resource('/wards', 'WardsController');

Route::get('/welcome/login', 'WelcomeController@login')->name('welcome.login');
Route::get('/welcome/login/{id}', 'WelcomeController@login')->name('welcome.login');
Route::get('/welcome/faqs', 'WelcomeController@faqs')->name('welcome.faqs');
Route::get('/welcome', 'WelcomeController@index')->name('welcome.index');
