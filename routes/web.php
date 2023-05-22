<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{AdminauthController,ProfileController,UserController,NotificationController,SiteManagementController,AllapiController,AttendanceController,PaymentCollectController,EmployeeController,RechargeController};

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
    return view('admin.login');
});

Route::get('/clear-cache', function () {

  $exit = Artisan::call('cache:clear');
  $exit=Artisan::call('optimize');
  $exit=Artisan::call('route:cache');
  $exit=Artisan::call('route:clear');
  $exit=Artisan::call('view:clear');
  $exit=Artisan::call('config:cache');
  return 'success';
});

Route::get('admin/login',[AdminauthController::class,'getLogin'])->name('getLogin');
Route::post('admin/login',[AdminauthController::class,'postLogin'])->name('postLogin');
Route::group(['middleware'=>['AccountChacker']],function(){
  
  Route::get('/admin/dashboards',[ProfileController::class,'dashboards'])->name('dashboards');
  Route::get('/admin/dashboard_demo',[ProfileController::class,'dashboard_demo'])->name('dashboard_demo');
  //activity notification
     
  Route::get('/admin/activity_list',[EmployeeController::class,'activity_list'])->name('activity_list');
  Route::get('/admin/view_activity/{id}',[EmployeeController::class,'view_activity'])->name('view_activity');
  Route::get('/admin/delete_activity/{id}',[EmployeeController::class,'delete_activity'])->name('delete_activity');
  //end
     
  Route::post('/admin/storeattendance',[ProfileController::class,'storeattendance'])->name('storeattendance');
  Route::put('/admin/checkoutattendance/{id}',[ProfileController::class,'checkoutattendance'])->name('checkoutattendance');  

  Route::get('/admin/profile',[ProfileController::class,'profile'])->name('profile');
  Route::put('/admin/update_profile/{id}',[ProfileController::class,'update_profile'])->name('update_profile');
  Route::post('admin//changePassword', [ProfileController::class, 'changePasswordPost'])->name('changePasswordPost');
  Route::get('/admin/logout',[ProfileController::class,'logout'])->name('logout');
    
  //registered_user_list
  Route::get('/admin/registered_user_list',[UserController::class,'registered_user_list'])->name('registered_user_list');
    
  //users list
    
  Route::get('/admin/users',[UserController::class,'index'])->name('user.index');
  Route::get('/admin/delete_user/{id}',[UserController::class,'delete_user'])->name('delete_user');
    
  //staff list
  Route::get('/admin/staff/list',[UserController::class,'staff_list'])->name('staff_list');
  Route::get('/admin/create_staff',[UserController::class,'create_staff'])->name('create_staff');
  Route::post('/admin/store_staff',[UserController::class,'store_staff'])->name('store_staff');
  Route::get('/admin/delete_staff/{id}',[UserController::class,'delete_staff'])->name('delete_staff');
  Route::get('/admin/edit_staff/{id}',[UserController::class,'edit_staff'])->name('edit_staff');
  Route::post('/admin/update_staff/{id}',[UserController::class,'update_staff'])->name('update_staff');
     
  //role list
  Route::get('/admin/role_list',[UserController::class,'role_list'])->name('role_list');
  Route::get('/admin/edit_role_permission/{id}',[UserController::class,'edit_role_permission'])->name('edit_role_permission');
  Route::post('/admin/update_role_permission/{id}',[UserController::class,'update_role_permission'])->name('update_role_permission');
      
  Route::post('/admin/change_user_status',[UserController::class,'change_user_status'])->name('change_user_status');
     
  //notification list
  Route::get('/admin/notification',[NotificationController::class,'index'])->name('notification.index');
  Route::get('/admin/create_notification',[NotificationController::class,'create_notification'])->name('create_notification');
  Route::post('/admin/store_notification',[NotificationController::class,'store_notification'])->name('store_notification');
  Route::get('/admin/view_notification/{id}',[NotificationController::class,'view_notification'])->name('view_notification');
  Route::get('/admin/delete_notification/{id}',[NotificationController::class,'delete_notification'])->name('delete_notification'); 
       
  //permission for staff
  Route::get('/admin/admin_permission/{id}',[ProfileController::class,'admin_permission'])->name('admin_permission');
  
  //attendance list
  Route::get('/admin/attendance',[AttendanceController::class,'index'])->name('attendance.index');
  Route::post('/admin/createMonthlyAttendencePDF',[AttendanceController::class,'createMonthlyAttendencePDF'])->name('createMonthlyAttendencePDF');

  Route::get('/admin/all_employee_hour_attendance',[AttendanceController::class,'all_employee_hour_attendance'])->name('all_employee_hour_attendance');
  Route::get('/admin/create_attendance',[AttendanceController::class,'create_attendance'])->name('create_attendance');
  Route::post('/admin/search_attendance',[AttendanceController::class,'search_attendance'])->name('search_attendance');
  Route::get('/admin/holiday_list',[AttendanceController::class,'holiday_list'])->name('holiday_list');
  Route::get('/admin/create_holiday',[AttendanceController::class,'create_holiday'])->name('create_holiday');
  Route::post('/admin/store_holiday',[AttendanceController::class,'store_holiday'])->name('store_holiday');
  Route::get('/admin/edit_holiday/{id}',[AttendanceController::class,'edit_holiday'])->name('edit_holiday');
  Route::post('/admin/update_holiday/{id}',[AttendanceController::class,'update_holiday'])->name('update_holiday');
  Route::get('/admin/delete_holiday/{id}',[AttendanceController::class,'delete_holiday'])->name('delete_holiday');
  Route::get('/admin/employee_attendance/{id}',[AttendanceController::class,'employee_attendance'])->name('employee_attendance');
  Route::get('/admin/employee_hour_attendance/{id}',[AttendanceController::class,'employee_hour_attendance'])->name('employee_hour_attendance');
  Route::get('/admin/employee_calendar_attendance/{id}',[AttendanceController::class,'employee_calendar_attendance'])->name('employee_calendar_attendance');
        
  //employee panel
  Route::get('/admin/employee_att',[AttendanceController::class,'employee_att'])->name('employee_att');
  Route::get('/admin/employee_hour_att',[AttendanceController::class,'employee_hour_att'])->name('employee_hour_att');
  Route::get('/admin/employee_att_details/{id}',[AttendanceController::class,'employee_att_details'])->name('employee_att_details');
     
  //payment collect from site
  Route::get('/admin/payment_collect',[PaymentCollectController::class,'index'])->name('payment_collect.index');
  Route::get('/admin/all_payment_collect/{id}',[PaymentCollectController::class,'all_payment_collect'])->name('all_payment_collect'); //for admin
  Route::get('/admin/all_emp_payment_collect',[PaymentCollectController::class,'all_emp_payment_collect'])->name('all_emp_payment_collect'); //for admin
  Route::get('/admin/view_all_payment_collect/{id}',[PaymentCollectController::class,'view_all_payment_collect'])->name('view_all_payment_collect');  //for admin
  Route::get('/admin/delete_all_payment_collect/{id}',[PaymentCollectController::class,'delete_all_payment_collect'])->name('delete_all_payment_collect');  //for admin
  Route::get('/admin/create_payment_collect',[PaymentCollectController::class,'create_payment_collect'])->name('create_payment_collect');
  Route::post('/admin/store_payment_collect',[PaymentCollectController::class,'store_payment_collect'])->name('store_payment_collect');
  Route::get('/admin/view_payment_collect/{id}',[PaymentCollectController::class,'view_payment_collect'])->name('view_payment_collect'); 
  Route::get('/admin/delete_payment_collect/{id}',[PaymentCollectController::class,'delete_payment_collect'])->name('delete_payment_collect');  //for employee
  Route::post('/admin/getTotalSitePayment',[PaymentCollectController::class,'getTotalSitePayment'])->name('getTotalSitePayment');
  Route::get('/admin/all_due_cash',[PaymentCollectController::class,'all_due_cash'])->name('all_due_cash'); //for admin
  Route::get('/admin/all_received_cash',[PaymentCollectController::class,'all_received_cash'])->name('all_received_cash'); //for admin 

  Route::get('/admin/create_payment_collect_for_admin',[PaymentCollectController::class,'create_payment_collect_for_admin'])->name('create_payment_collect_for_admin'); //for admin

  Route::post('/admin/store_payment_collect_for_admin',[PaymentCollectController::class,'store_payment_collect_for_admin'])->name('store_payment_collect_for_admin');
  // payment adjustment for admin
     
  Route::get('/admin/site_payment_adjustment',[PaymentCollectController::class,'site_payment_adjustment'])->name('site_payment_adjustment'); //for admin
  Route::post('/admin/search_sitewise_cash_adjustment',[PaymentCollectController::class,'search_sitewise_cash_adjustment'])->name('search_sitewise_cash_adjustment'); //for admin
        
  Route::get('/admin/payment_adjustment/{id}',[PaymentCollectController::class,'payment_adjustment'])->name('payment_adjustment'); //for admin
  Route::get('/admin/create_payment_adjustment',[PaymentCollectController::class,'create_payment_adjustment'])->name('create_payment_adjustment');  //for admin
  Route::get('/admin/view_payment_adjustment/{id}',[PaymentCollectController::class,'view_payment_adjustment'])->name('view_payment_adjustment');  //for admin
  Route::get('/admin/delete_payment_adjustment/{id}',[PaymentCollectController::class,'delete_payment_adjustment'])->name('delete_payment_adjustment');  //for admin
  Route::post('/admin/store_payment_adjustment',[PaymentCollectController::class,'store_payment_adjustment'])->name('store_payment_adjustment');//for admin
  //end
     
  Route::get('/admin/employee_dashboard/{id}',[EmployeeController::class,'employee_dashboard'])->name('employee_dashboard'); // for admin
  
  //role section admin
  Route::get('/admin/create_role',[UserController::class,'create_role'])->name('create_role');    
  Route::post('/admin/store_role',[UserController::class,'store_role'])->name('store_role');
  Route::get('/admin/role/lists',[UserController::class,'role_lists'])->name('role_lists');
  Route::get('/admin/delete_role/{id}',[UserController::class,'delete_role'])->name('delete_role');
  Route::get('/admin/edit_role/{id}',[UserController::class,'edit_roles'])->name('edit_roles');
  Route::post('/admin/update_roles/{id}',[UserController::class,'update_roles'])->name('update_roles');

  //permission
  Route::get('/admin/permission_lists',[UserController::class,'permission_lists'])->name('permission_lists');
  Route::get('/admin/create_permission',[UserController::class,'create_permission'])->name('create_permission');
  Route::post('/admin/store_permission',[UserController::class,'store_permission'])->name('store_permission');
  Route::get('/admin/delete_permission/{id}',[UserController::class,'delete_permission'])->name('delete_permission');

  Route::get('/admin/create_employee',[UserController::class,'create_employee'])->name('create_employee');    
  Route::post('/admin/store_employee',[UserController::class,'store_employee'])->name('store_employee');
  Route::get('/admin/employee/list',[UserController::class,'employee_list'])->name('employee_list');
  Route::get('/admin/edit_employee/{id}',[UserController::class,'edit_employee'])->name('edit_employee');
  Route::post('/admin/update_employee/{id}',[UserController::class,'update_employee'])->name('update_employee');
  Route::get('/admin/delete_employee/{id}',[UserController::class,'delete_employee'])->name('delete_employee');
  Route::post('/admin/change_employee_status',[UserController::class,'change_employee_status'])->name('change_employee_status');

  //vendor section
  Route::get('/admin/create_vendor',[UserController::class,'create_vendor'])->name('create_vendor');
  Route::post('/admin/store_vendor',[UserController::class,'store_vendor'])->name('store_vendor');   
  Route::get('/admin/vendor/list',[UserController::class,'vendor_list'])->name('vendor_list');
  Route::get('/admin/edit_vendor/{id}',[UserController::class,'edit_vendor'])->name('edit_vendor');
  Route::get('/admin/delete_vendor/{id}',[UserController::class,'delete_vendor'])->name('delete_vendor');
  Route::post('/admin/update_vendor/{id}',[UserController::class,'update_vendor'])->name('update_vendor');
  Route::post('/admin/change_vendor_status',[UserController::class,'change_vendor_status'])->name('change_vendor_status');

  //customer section
  Route::get('/admin/create_customer',[UserController::class,'create_customer'])->name('create_customer');
  Route::post('/admin/store_customer',[UserController::class,'store_customer'])->name('store_customer');   
  Route::get('/admin/customer/list',[UserController::class,'customer_list'])->name('customer_list');
  Route::get('/admin/edit_customer/{id}',[UserController::class,'edit_customer'])->name('edit_customer');
  Route::get('/admin/delete_customer/{id}',[UserController::class,'delete_customer'])->name('delete_customer');
  Route::post('/admin/update_customer/{id}',[UserController::class,'update_customer'])->name('update_customer');
  Route::post('/admin/change_customer_status',[UserController::class,'change_customer_status'])->name('change_customer_status');

  //project
  Route::get('/admin/create_project',[UserController::class,'create_project'])->name('create_project');
  Route::post('/admin/store_project',[UserController::class,'store_project'])->name('store_project');
  Route::get('/admin/project/list',[UserController::class,'project_list'])->name('project_list');
  Route::get('/admin/edit_project/{id}',[UserController::class,'edit_project'])->name('edit_project');
  Route::get('/admin/delete_project/{id}',[UserController::class,'delete_project'])->name('delete_project');
  Route::post('/admin/update_project/{id}',[UserController::class,'update_project'])->name('update_project');
  Route::post('/admin/change_project_status',[UserController::class,'change_project_status'])->name('change_project_status');

  //task
  Route::get('/admin/create_task',[UserController::class,'create_task'])->name('create_task');
  Route::post('/admin/store_task',[UserController::class,'store_task'])->name('store_task');
  Route::get('/admin/task/list',[UserController::class,'task_list'])->name('task_list');
  Route::get('/admin/edit_task/{id}',[UserController::class,'edit_task'])->name('edit_task');
  Route::get('/admin/delete_task/{id}',[UserController::class,'delete_task'])->name('delete_task');
  Route::post('/admin/update_task/{id}',[UserController::class,'update_task'])->name('update_task');
  Route::post('/admin/change_task_status',[UserController::class,'change_task_status'])->name('change_task_status');

  //leave 
  Route::get('/admin/leave_list',[AttendanceController::class,'leave_list'])->name('leave_list');
  Route::get('/admin/create_leave',[AttendanceController::class,'create_leave'])->name('create_leave');
  Route::post('/admin/store_leave',[AttendanceController::class,'store_leave'])->name('store_leave');
  Route::get('/admin/edit_leave/{id}',[AttendanceController::class,'edit_leave'])->name('edit_leave');
  Route::post('/admin/update_leave/{id}',[AttendanceController::class,'update_leave'])->name('update_leave');
  Route::get('/admin/delete_leave/{id}',[AttendanceController::class,'delete_leave'])->name('delete_leave');
  Route::get('/admin/leave_all',[AttendanceController::class,'leave_all'])->name('leave_all');

  Route::get('/admin/create_all_leave',[AttendanceController::class,'create_all_leave'])->name('create_all_leave');
  Route::post('/admin/store_all_leave',[AttendanceController::class,'store_all_leave'])->name('store_all_leave');
  Route::get('/admin/edit_all_leave/{id}',[AttendanceController::class,'edit_all_leave'])->name('edit_all_leave');
  Route::post('/admin/update_all_leave/{id}',[AttendanceController::class,'update_all_leave'])->name('update_all_leave');

  //attendence
  Route::post('/admin/daystart',[ProfileController::class,'daystart'])->name('daystart');
  Route::post('/admin/dayend',[ProfileController::class,'dayend'])->name('dayend');

  Route::post('/admin/breakstart',[ProfileController::class,'breakstart'])->name('breakstart');
  Route::post('/admin/breakend',[ProfileController::class,'breakend'])->name('breakend');

  Route::get('/admin/reports',[ProfileController::class,'reports'])->name('reports');
  Route::any('/admin/attendencelist',[ProfileController::class,'attendencelist'])->name('attendencelist');
  //Route::any('/admin/reportslist',[ProfileController::class,'reportslist'])->name('reportslist');

  Route::get('/detail/attendence/{id}{date}', [ProfileController::class,'attendencedetail']);

  //timesheet
  Route::any('/admin/timesheet',[ProfileController::class,'timesheet'])->name('timesheet');
  Route::post('/admin/store_timesheet',[ProfileController::class,'store_timesheet'])->name('store_timesheet');
  Route::any('/admin/my_activity',[ProfileController::class,'my_activity'])->name('my_activity');
  Route::post('/admin/store_myactivity',[ProfileController::class,'store_myactivity'])->name('store_myactivity');
  Route::post('/admin/update_myactivity',[ProfileController::class,'update_myactivity'])->name('update_myactivity');
  Route::any('/admin/activity_reports',[ProfileController::class,'activity_reports'])->name('activity_reports');
  Route::any('/admin/prnpriview',[ProfileController::class,'activity_reports'])->name('prnpriview');
  Route::any('/admin/createPDF', [ProfileController::class, 'createPDF'])->name('createPDF');

  Route::any('/admin/activity_reports_weekly', [ProfileController::class, 'activity_reports_weekly'])->name('activity_reports_weekly');
  Route::any('/admin/activity_reports_week', [ProfileController::class, 'activity_reports_week'])->name('activity_reports_week');
  Route::any('/admin/createWeeklyPDF', [ProfileController::class, 'createWeeklyPDF'])->name('createWeeklyPDF');
  Route::any('/admin/activity_reports_monthly', [ProfileController::class, 'activity_reports_monthly'])->name('activity_reports_monthly');
  Route::any('/admin/createMonthlyPDF', [ProfileController::class, 'createMonthlyPDF'])->name('createMonthlyPDF');

  Route::post('/admin/addlogouttime',[ProfileController::class,'addlogouttime'])->name('addlogouttime');

  Route::get('/admin/timemanagement',[ProfileController::class,'timemanagement'])->name('timemanagement');

  //group
  Route::get('/admin/create_group',[UserController::class,'create_group'])->name('create_group');
  Route::post('/admin/store_group',[UserController::class,'store_group'])->name('store_group');   
  Route::get('/admin/group/list',[UserController::class,'group_list'])->name('group_list');
  Route::get('/admin/edit_group/{id}',[UserController::class,'edit_group'])->name('edit_group');
  Route::get('/admin/delete_group/{id}',[UserController::class,'delete_group'])->name('delete_group');
  Route::post('/admin/update_group/{id}',[UserController::class,'update_group'])->name('update_group');

  //state
  Route::get('/admin/create_state',[UserController::class,'create_state'])->name('create_state');
  Route::post('/admin/store_state',[UserController::class,'store_state'])->name('store_state');
  Route::get('/admin/state_lists',[UserController::class,'state_lists'])->name('state_lists');
  Route::get('/admin/edit_state/{id}',[UserController::class,'edit_state'])->name('edit_state');
  Route::get('/admin/delete_state/{id}',[UserController::class,'delete_state'])->name('delete_state');
  Route::post('/admin/update_state/{id}',[UserController::class,'update_state'])->name('update_state');
  Route::get('/admin/view_state/{id}',[UserController::class,'view_state'])->name('view_state');

  //Task Assigment
  Route::get('/admin/create_dailytask',[UserController::class,'create_dailytask'])->name('create_dailytask');
  Route::post('/admin/store_dailytask',[UserController::class,'store_dailytask'])->name('store_dailytask');
  Route::get('/admin/dailytask_list',[UserController::class,'dailytask_list'])->name('dailytask_list');
  Route::get('/admin/edit_dailytask/{id}',[UserController::class,'edit_dailytask'])->name('edit_dailytask');
  Route::get('/admin/delete_dailytask/{id}',[UserController::class,'delete_dailytask'])->name('delete_dailytask');
  Route::post('/admin/update_dailytask/{id}',[UserController::class,'update_dailytask'])->name('update_dailytask');

  //task
  Route::get('/admin/create_assigntask',[UserController::class,'create_assigntask'])->name('create_assigntask');
  Route::post('/admin/store_assigntask',[UserController::class,'store_assigntask'])->name('store_assigntask');
  Route::post('/admin/store_assigntask1',[UserController::class,'store_assigntask1'])->name('store_assigntask1');
  Route::get('/admin/assigntask_list',[UserController::class,'assigntask_list'])->name('assigntask_list');
  Route::get('/admin/edit_assigntask/{id}',[UserController::class,'edit_assigntask'])->name('edit_assigntask');
  Route::get('/admin/delete_assigntask/{id}',[UserController::class,'delete_assigntask'])->name('delete_assigntask');
  Route::post('/admin/update_assigntask/{id}',[UserController::class,'update_assigntask'])->name('update_assigntask');
  //Route::get('/admin/board',[UserController::class,'board'])->name('board');
  Route::any('/admin/board',[UserController::class,'board'])->name('board');
  Route::any('/admin/boardPrint',[UserController::class,'boardPrint'])->name('boardPrint');
  Route::post('/admin/adddailytaskcomments',[UserController::class,'adddailytaskcomments'])->name('adddailytaskcomments');

  //PMT
  Route::get('/admin/create_pmt',[UserController::class,'create_pmt'])->name('create_pmt');
  Route::post('/admin/store_pmt',[UserController::class,'store_pmt'])->name('store_pmt');
  Route::get('/admin/pmt_lists',[UserController::class,'pmt_lists'])->name('pmt_lists');
  Route::get('/admin/edit_pmt/{id}',[UserController::class,'edit_pmt'])->name('edit_pmt');
  Route::get('/admin/delete_pmt/{id}',[UserController::class,'delete_pmt'])->name('delete_pmt');
  Route::post('/admin/update_pmt/{id}',[UserController::class,'update_pmt'])->name('update_pmt');

  //Weekly target
  Route::any('/admin/searchweeklytarget',[UserController::class,'searchweeklytarget'])->name('searchweeklytarget');
  Route::any('/admin/create_weekly_target',[UserController::class,'create_weekly_target'])->name('create_weekly_target');
  Route::post('/admin/store_weekly_target',[UserController::class,'store_weekly_target'])->name('store_weekly_target');

  Route::any('/admin/weeklytargetactual',[UserController::class,'weeklytargetactual'])->name('weeklytargetactual');
  Route::post('/admin/store_weeklyactualtarget',[UserController::class,'store_weeklyactualtarget'])->name('store_weeklyactualtarget');
  Route::any('/admin/searchactual_weeklytarget',[UserController::class,'searchactual_weeklytarget'])->name('searchactual_weeklytarget');

  Route::get('/admin/lead',[UserController::class,'lead'])->name('lead');
  Route::get('/admin/edit_lead/{id}',[UserController::class,'edit_lead'])->name('edit_lead');
  Route::get('/admin/delete_lead/{id}',[UserController::class,'delete_lead'])->name('delete_lead');
  Route::post('/admin/update_lead/{id}',[UserController::class,'update_lead'])->name('update_lead');
  Route::get('/admin/view_lead/{id}',[UserController::class,'view_lead'])->name('view_lead');

  Route::post('/admin/lead_comment',[UserController::class,'lead_comment'])->name('lead_comment');

  //event
  Route::get('/admin/event',[UserController::class,'event'])->name('event');
  Route::get('/admin/edit_event/{id}',[UserController::class,'edit_event'])->name('edit_event');
  Route::get('/admin/delete_event/{id}',[UserController::class,'delete_event'])->name('delete_event');
  Route::post('/admin/update_event/{id}',[UserController::class,'update_event'])->name('update_event');
  Route::get('/admin/view_event/{id}',[UserController::class,'view_event'])->name('view_event');

  //Route::post('/admin/event_comment',[UserController::class,'event_comment'])->name('event_comment');

  //Route::get('/admin/weekly_target_lists',[UserController::class,'weekly_target_lists'])->name('weekly_target_lists');
  // Route::get('/admin/edit_pmt/{id}',[UserController::class,'edit_pmt'])->name('edit_pmt');
  // Route::get('/admin/delete_pmt/{id}',[UserController::class,'delete_pmt'])->name('delete_pmt');
  // Route::post('/admin/update_pmt/{id}',[UserController::class,'update_pmt'])->name('update_pmt');

});
Route::any('/search_project',[ProfileController::class,'search_project'])->name('search_project');
Route::any('/search_task',[ProfileController::class,'search_task'])->name('search_task');
Route::any('/myteam',[ProfileController::class,'myteam'])->name('myteam');
Route::any('/clock',[ProfileController::class,'clock'])->name('clock');
Route::any('/test',[ProfileController::class,'testHook'])->name('test');
Route::get('/test1',[ProfileController::class,'testHook1'])->name('test1');
Route::get('/tt', [ProfileController::class, 'tt'])->name('tt');
//Route::get('/admin/edit_employee/{id}',[UserController::class,'edit_employee'])->name('edit_employee');