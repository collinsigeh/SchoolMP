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

Route::resource('/bankdetails', 'BankdetailsController');

Route::resource('/calendars', 'CalendarsController');

Route::post('/cbts/cbt_approval/{id}', 'CbtsController@cbt_approval')->name('cbts.cbt_approval');
Route::get('/cbts/listing/{id}', 'CbtsController@listing')->name('cbts.listing');
Route::get('/cbts/newexam/{id}', 'CbtsController@newexam')->name('cbts.newexam');
Route::get('/cbts/new3rdtest/{id}', 'CbtsController@new3rdtest')->name('cbts.new3rdtest');
Route::get('/cbts/new2ndtest/{id}', 'CbtsController@new2ndtest')->name('cbts.new2ndtest');
Route::get('/cbts/new1sttest/{id}', 'CbtsController@new1sttest')->name('cbts.new1sttest');
Route::get('/cbts/newpractice/{id}', 'CbtsController@newpractice')->name('cbts.newpractice');
Route::resource('/cbts', 'CbtsController');

Route::resource('/classes', 'ClassesController');

Route::resource('/classsubjects', 'ClasssubjectsController');

Route::get('/dashboard/relogin', 'DashboardController@relogin')->name('dashboard.relogin');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/directors/new', 'DirectorsController@new')->name('directors.new');
Route::post('/directors/add', 'DirectorsController@add')->name('directors.add');
Route::resource('/directors', 'DirectorsController');

Route::resource('/enrolments', 'EnrolmentsController');

Route::resource('/expenses', 'ExpensesController');

Route::resource('/guardians', 'GuardiansController');

Route::resource('/itempayments', 'ItempaymentsController');

Route::resource('/items', 'ItemsController');

Route::get('/lessons/listing/{id}', 'LessonsController@listing')->name('lessons.listing');
Route::get('/lessons/newvideo/{id}', 'LessonsController@newvideo')->name('lessons.newvideo');
Route::get('/lessons/newaudio/{id}', 'LessonsController@newaudio')->name('lessons.newaudio');
Route::get('/lessons/newphoto/{id}', 'LessonsController@newphoto')->name('lessons.newphoto');
Route::get('/lessons/newtext/{id}', 'LessonsController@newtext')->name('lessons.newtext');
Route::resource('/lessons', 'LessonsController');

Route::get('/orders/all', 'OrdersController@all')->name('orders.all');
Route::get('/orders/detail/{id}', 'OrdersController@detail')->name('orders.detail');
Route::put('orders/changedetail/{id}', 'OrdersController@changedetail')->name('orders.changedetail');
Route::resource('/orders', 'OrdersController');

Route::resource('/packages', 'PackagesController');

Route::get('payments/verifypaystack_transaction', 'PaymentsController@verifypaystack_transaction')->name('payments.verifypaystack_transaction');
Route::put('payments/pay_with_paystack', 'PaymentsController@pay_with_paystack')->name('payments.pay_with_paystack');
Route::post('payments/pay_with_voucher', 'PaymentsController@pay_with_voucher')->name('payments.pay_with_voucher');
Route::resource('/payments', 'PaymentsController');

Route::resource('/payment_processors', 'PaymentprocessorsController');

Route::resource('/paymentvouchers', 'PaymentvouchersController');

Route::resource('/products', 'ProductsController');

Route::resource('/questions', 'QuestionsController');

Route::resource('/results', 'ResultsController');

Route::resource('/resulttemplates', 'ResulttemplatesController');

Route::resource('/school_settings', 'SchoolsettingsController');

Route::get('/schools/all', 'SchoolsController@all')->name('schools.all');
Route::resource('/schools', 'SchoolsController');

Route::resource('/settings', 'SettingsController');

Route::get('/staff/new', 'StaffController@new')->name('staff.new');
Route::post('/staff/add', 'StaffController@add')->name('staff.add');
Route::resource('/staff', 'StaffController');

Route::get('/students/payment_history/{id}', 'StudentsController@payment_history')->name('students.payment_history');
Route::get('/students/cbt_completed/{id}', 'StudentsController@cbt_completed')->name('students.cbt_completed');
Route::post('/students/cbt_submitted/{id}', 'StudentsController@cbt_submitted')->name('students.cbt_submitted');
Route::get('/students/cbt_started/{id}', 'StudentsController@cbt_started')->name('students.cbt_started');
Route::post('/students/cbt_live/{id}', 'StudentsController@cbt_live')->name('students.cbt_live');
Route::get('/students/cbt/{id}', 'StudentsController@cbt')->name('students.cbt');
Route::get('/students/cbts/{id}', 'StudentsController@cbts')->name('students.cbts');
Route::get('/students/lessons/{id}', 'StudentsController@lessons')->name('students.lessons');
Route::get('/students/subject/{id}', 'StudentsController@subject')->name('students.subject');
Route::get('/students/term/{id}', 'StudentsController@term')->name('students.term');
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
