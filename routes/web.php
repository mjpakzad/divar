<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('mj/{id}', function ($id) {
//    Auth::loginUsingId($id);
//});
//Auth::routes();
/**
Route::prefix('admin')->name('admin.')->namespace('Admin')->middleware(['auth', 'twoFactor'])->group(function () {
    Route::get('/', 'AppController@index')->name('app.index');
    Route::get('cats/{cat}/ajax', 'CatController@ajax')->name('cats.ajax');
    Route::resource('cats', 'CatController')->only(['index', 'show']);
    Route::get('categories/ajax', 'CategoryController@ajax')->name('categories.ajax');
    Route::resource('categories', 'CategoryController')->except('show');
    Route::get('groups/ajax', 'GroupController@ajax')->name('groups.ajax');
    Route::resource('groups', 'GroupController')->except('show');
    Route::post('provinces/ajax', 'ProvinceController@ajax')->name('provinces.ajax');
    Route::resource('provinces', 'ProvinceController')->except('show');
    Route::post('has-district', 'CityController@hasDistrict')->name('city-has-district');
    Route::prefix('cities')->name('cities.')->group(function () {
        Route::resource('{city}/districts', 'DistrictController')->except('show');
        Route::get('{city}/edit', 'CityController@edit')->name('edit');
        Route::patch('{city}', 'CityController@update')->name('update');
        Route::resource('/', 'CityController')->except('show');
    });
    Route::prefix('shop')->name('shop.')->namespace('Shop')->group(function () {
        Route::get('categories/ajax', 'CategoryController@ajax')->name('categories.ajax');
        Route::resource('categories', 'CategoryController')->except('show');
    });
    Route::resource('weather', 'WeatherController')->except(['show']);
    Route::post('commercials/{commercial}/tags', 'CommercialController@tags')->name('commercials.tags');
    Route::resource('tickets', 'TicketController')->except(['create', 'store', 'edit']);
    Route::resource('filters', 'FilterController')->except('show');
    Route::resource('attributes', 'AttributeController')->except('show');
    Route::resource('options', 'OptionController')->except('show');
    Route::resource('manufacturers', 'ManufacturerController')->except('show');
    Route::resource('products', 'ProductController')->except('show');
    Route::resource('fields', 'FieldController')->except('show');
    Route::get('users/export', 'UserController@export')->name('users.export');
    Route::get('commercials/export', 'CommercialController@export')->name('commercials.export');
    Route::get('products/export', 'ProductController@export')->name('products.export');
    Route::post('users/list', 'UserController@list')->name('users.list');
    Route::post('categories/list', 'CategoryController@list')->name('categories.list');
    Route::get('users/ajax', 'UserController@ajax')->name('users.ajax');
    Route::get('blog/ajax', 'ArticleController@ajax')->name('blog.ajax');
    Route::get('fields/ajax', 'FieldController@ajax')->name('fields.ajax');
    Route::get('commercials/ajax', 'CommercialController@ajax')->name('commercials.ajax');
    Route::get('products/ajax', 'ProductController@ajax')->name('products.ajax');
    Route::resource('comments', 'CommentController')->only(['index', 'update', 'show', 'destroy']);
    Route::resource('reviews', 'ReviewController')->only(['index', 'update', 'show', 'destroy']);
    Route::get('sms/{commercial}', 'CommercialController@sms')->name('sms.show');
    Route::post('sms/{commercial}', 'CommercialController@send')->name('sms.send');
    Route::post('commercials/districts', 'CommercialController@districts')->name('commercials.districts');
    Route::post('commercials/fields', 'CommercialController@fields')->name('commercials.fields');
    Route::resource('commercials', 'CommercialController')->except('show');
    Route::resource('contacts', 'ContactController')->only(['index', 'show', 'destroy']);
    Route::resource('pages', 'PageController')->except('show');
    Route::resource('blog', 'ArticleController')->except('show');
    Route::get('users/{user}/commercials/ajax', 'UserController@commercialsAjax')->name('user.commercials.ajax');
    Route::get('users/{user}/commercials', 'UserController@commercials')->name('users.commercials');
    Route::resource('users', 'UserController')->except('show');
    Route::resource('roles', 'RoleController')->except('show');
    Route::resource('banners', 'BannerController')->except('show');
    Route::resource('permissions', 'PermissionController')->only('update', 'edit');
    Route::resource('reports', 'ReportController')->only(['index', 'show', 'destroy']);
    Route::resource('settings', 'SettingController')->only(['index', 'edit', 'update']);
    Route::resource('reasons', 'ReportReasonController', ['as' => 'reports'])->except('show');
    Route::resource('reports', 'ReportController')->only(['show', 'index', 'delete']);
    Route::resource('services', 'ServiceController')->only(['index', 'edit', 'update']);
    Route::resource('invoices', 'InvoiceController')->only(['index', 'show']);
    Route::resource('payments', 'PaymentController')->only('index');
    Route::resource('products', 'ProductController')->except('show');
    Route::resource('options', 'OptionController')->except('show');
    Route::resource('transactions', 'TransactionController')->only(['index', 'show']);
});

Route::post('2fa/resend', 'Auth\TwoFactorController@resendVerificationCode')->name('twoFactor.resendVerification');
Route::get('2fa', 'Auth\TwoFactorController@showVerificationForm')->name('twoFactor.verificationForm');
Route::post('2fa', 'Auth\TwoFactorController@verification')->name('twoFactor.verification');
Route::post('password/sms', 'Auth\ForgotPasswordController@sendResetLinkSms')->name('password.sms');
Route::get('reset/password/{token?}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::name('frontend.')->namespace('Frontend')->group(function () {
    Route::prefix('payments')->as('payments.')->group(function () {
        Route::get('request/{invoice}', 'PaymentController@request')->name('request');
        Route::any('callback', 'PaymentController@callback')->name('callback');
        Route::get('result', 'PaymentController@result')->name('result');
    });
    Route::post('search', 'SearchController@process')->name('search.process');
    Route::get('search/{phrase?}', 'SearchController@show')->name('search.show');
    Route::get('/', 'AppController@index')->name('app.index');
    Route::prefix('shop')->name('shop.')->namespace('Shop')->group(function() {
        Route::post('categories/{category}', 'CategoryController@filter')->name('categories.filter');
        Route::resource('categories', 'CategoryController')->only('show');
    });
    Route::get('compare', 'CompareController@index')->name('compare');
    Route::post('compare/add/{id}', 'CompareController@add')->name('compare.add');
    Route::post('compare/remove/{id}', 'CompareController@remove')->name('compare.remove');
    Route::get('products/find/search', 'ProductController@search')->name('products.search');
    //Route::get('shop', 'ShopController@index')->name('shop.index');
    Route::resource('products', 'ProductController')->only(['index', 'show']);
    Route::resource('manufacturers', 'ManufacturerController')->only('show');
    Route::resource('tickets', 'TicketController');
    Route::post('cities/districts', 'CitiesController@districts')->name('cities.districts');
    Route::post('has-district', 'CitiesController@hasDistrict')->name('city-has-district');
    Route::resource('z/{commercial}/comments', 'CommentController')->only('store');
    Route::get('z/{commercial}', 'CommercialController@show')->name('commercials.show');
    Route::get('all', 'CommercialController@index')->name('commercials.index');
    Route::get('manage/{commercial}', 'CommercialController@manage')->name('commercials.manage');
    Route::get('page/{page}', 'PageController')->name('pages.show');
    Route::resource('reports', 'ReportController')->only('store');
    Route::resource('bookmarks', 'BookmarkController')->only('store');
    Route::resource('blog/{article}/reviews', 'ReviewController')->only('store');
    Route::resource('blog', 'BlogController')->only(['index', 'show']);
    Route::get('categories/{category}', 'CategoryController@show')->name('categories.show');
    Route::post('my', 'MyController@update')->name('my.update');
    Route::get('my', 'MyController@show')->name('my.show');
    Route::get('sitemap.xml', 'SitemapController')->name('sitemap');
    Route::resource('contact', 'ContactController')->only('store');
    Route::get('weather/{weather}', 'WeatherController@show')->name('weather.show');
    Route::get('weather', 'WeatherController@index')->name('weather.index');
    Route::post('commercials/{commercial}/contact', 'CommercialController@contact')->name('commercials.contact');
    Route::post('commercials/{commercial}/bookmark', 'CommercialController@bookmark')->name('commercials.bookmark');
    Route::resource('promotes', 'PromoteController')->only('show', 'update');
    Route::resource('commercials', 'CommercialController')->only(['edit', 'update', 'destroy']);
    Route::get('{city}/new', 'CommercialController@new')->name('commercials.new');
    Route::get('{city}/{category}/new', 'CommercialController@create')->name('commercials.create');
    Route::post('{city}/{category}', 'CommercialController@store')->name('commercials.store');
    Route::get('{city}/{category}', 'CitiesController@category')->name('cities.category');
    Route::get('{city}', 'CitiesController@show')->name('cities.show');
});
*/
