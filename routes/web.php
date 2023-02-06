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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middleware' => ['IfLogged']],function(){
    Route::any('/','AuthController@index')->name('index');
});
Route::post('/doLogin','AuthController@doLogin')->name('doLogin');
Route::get('/doLogout','AuthController@doLogout')->name('doLogout');
//Prepaid
Route::get('/login/prepaid','PrepaidController@index');
Route::post('/doLoginPrepaid','PrepaidController@doLoginPrepaid');
Route::get('/doLogoutPrepaid','PrepaidController@doLogoutPrepaid');

Route::group(['middleware' => ['AuthLogin','web']],function(){
    Route::get('/home','DashboardController@index')->name('home');
    Route::get('/ctb','CtbController@index')->name('ctb');
    Route::get('/ctb/create','CtbController@create')->name('ctb_create');
    Route::post('/ctb/insert','CtbController@insert')->name('ctb_insert');
    Route::get('/ctb/edit/{id}','CtbController@edit');
    Route::post('/ctb/update/{id}','CtbController@update');
    Route::get('/ctb/delete/{id}','CtbController@destroy');
    Route::post('ctb/auto','CtbController@auto_fill');
    Route::get('ctb/load','CtbController@loadData');

    Route::get('obc','ObcController@index');
    Route::get('obc/load','ObcController@loadData');
    Route::get('obc/edit/{id}','ObcController@edit');
    Route::post('obc/update/{id}','ObcController@update');

    Route::get('oplang','OplangController@index');
    Route::get('oplang/edit/{id}','OplangController@edit');
    Route::post('oplang/update/{id}','OplangController@update');
    Route::get('oplang/load','OplangController@loadData');

    Route::get('master/caring','MasterController@hasil_caring_view');
    Route::get('master/caring/load','MasterController@loadData');
    Route::post('master/caring/insert','MasterController@hasil_caring_insert');
    Route::get('master/caring/edit/{id}','MasterController@hasil_caring_edit');
    Route::post('master/caring/update/{id}','MasterController@hasil_caring_update');
    Route::get('master/caring/delete/{id}','MasterController@hasil_caring_delete');

    Route::get('user','UserController@index');
    Route::get('user/load','UserController@loadData');
    Route::post('user/insert','UserController@insert');
    Route::get('user/edit/{id}','UserController@edit');
    Route::post('user/update/{id}','UserController@update');
    Route::get('user/delete/{id}','UserController@destroy');
    Route::get('user/upas/{id}','UserController@updatePassword');

    Route::get('report/agent','ReportController@report_agent');
    Route::get('report/obc','ReportController@report_obc');
    Route::get('report/ctb/dowload','ReportController@downloadCtbReport');
    Route::get('report/obc/dowload','ReportController@downloadObcReport');
    Route::get('wo','ShareWoController@index');
    Route::get('wo/unmapped','ShareWoController@get_unmapped_wo');
    Route::get('wo/mapped','ShareWoController@get_mapped_wo');
    Route::post('wo/share','ShareWoController@add_wo_to_obc');

    Route::get('prepaid','PrepaidController@index');
    Route::get('prepaid/load','PrepaidController@loadData');
    Route::get('prepaid/edit/{id}','PrepaidController@edit');
    Route::post('prepaid/update/{id}','PrepaidController@update');

    Route::get('voc','VocController@hasil_voc_view');
    Route::get('voc/load','VocController@loadData');
    Route::post('voc/insert','VocController@insert');
    Route::get('voc/edit/{id}','VocController@edit');
    Route::post('voc/update/{id}','VocController@update');
    Route::get('voc/delete/{id}','VocController@destroy');

    Route::get('hvc','HvcController@index');
    Route::get('hvc/load','HvcController@loadData');
    Route::get('hvc/edit/{id}','HvcController@detailHvc');
    Route::post('hvc/update/{id}','HvcController@updateHvc');

});

