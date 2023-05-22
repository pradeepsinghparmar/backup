<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('EmployeeDetailsByToken',[ApiController::class,'EmployeeDetailsByToken'])->name('EmployeeDetailsByToken');
    Route::post('get_permissions',[ApiController::class,'get_permissions'])->name('get_permissions');
    Route::post('profile_updated',[ApiController::class,'profile_updated'])->name('profile_updated');
    Route::post('profile_picture_upload',[ApiController::class,'profile_picture_upload'])->name('profile_picture_upload');
    
    Route::post('payment_collect',[ApiController::class,'payment_collect'])->name('payment_collect');
    
    Route::post('get_payment_collect',[ApiController::class,'get_payment_collect'])->name('get_payment_collect');
    
    Route::post('get_attandance',[ApiController::class,'get_attandance'])->name('get_attandance');
    
    Route::post('get_attandance_by_hour',[ApiController::class,'get_attandance_by_hour'])->name('get_attandance_by_hour');
    

    Route::post('count_cash_received',[ApiController::class,'count_cash_received'])->name('count_cash_received');
    
    Route::post('store_attendence',[ApiController::class,'store_attendence'])->name('store_attendence');
    
    Route::post('checkout_attendance',[ApiController::class,'checkout_attendance'])->name('checkout_attendance');
    
    Route::post('dashboard_data',[ApiController::class,'dashboard_data'])->name('dashboard_data');
    
    Route::post('site_name',[ApiController::class,'site_name'])->name('site_name');
    
    Route::post('site_data',[ApiController::class,'site_data'])->name('site_data');
    
    Route::post('notification',[ApiController::class,'notification'])->name('notification');
    
     Route::post('getAssignSites',[ApiController::class,'getAssignSites'])->name('getAssignSites');
     Route::post('get_gateway_profile',[ApiController::class,'get_gateway_profile'])->name('get_gateway_profile');
     Route::post('get_registere_mobile_number',[ApiController::class,'get_registere_mobile_number'])->name('get_registere_mobile_number');
     Route::post('store_recharge_voucher',[ApiController::class,'store_recharge_voucher'])->name('store_recharge_voucher');
     Route::post('all_recharge_voucher_list',[ApiController::class,'all_recharge_voucher_list'])->name('all_recharge_voucher_list');
     Route::post('received_voucher_filter',[ApiController::class,'received_voucher_filter'])->name('received_voucher_filter');
     
    

});
Route::post('getEmployeeLogin',[ApiController::class,'getEmployeeLogin'])->name('getEmployeeLogin');
Route::post('sendotp',[ApiController::class,'sendotp'])->name('sendotp');
Route::post('verify_otp',[ApiController::class,'verify_otp'])->name('verify_otp');
Route::post('forgot_password',[ApiController::class,'forgot_password'])->name('forgot_password');

Route::post('store_lead',[ApiController::class,'store_lead'])->name('store_lead');
Route::post('store_event',[ApiController::class,'store_event'])->name('store_event');