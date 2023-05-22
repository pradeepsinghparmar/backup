<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\ActivityNotification;
use App\Models\Role;
use App\Models\Permission;
use Auth;
use Hash;
use Illuminate\Support\Str;
class EmployeeController extends Controller
{
    public function index(){
        $users = User::whereIsAdmin('0')->get();
        return view('admin.employee.index', compact('users'));
    }
    /*
    public function employee_assign_sites(Request $request,$id){
        $users = User::whereIsAdmin('0')->get();
         $api_list = Allapi::orderBy('id','DESC')->get();
         $assign_sites = AssignSites::where('employee_id', $id)->first();
        return view('admin.employee.assign_sites', compact('users','api_list','assign_sites'));
    }
    
    public function employee_dashboard($id)
    {
        $view_info = User::where('id',$id)->first();
        $cash_received = PaymentCollect::where('employee_id',$id)->sum('cash_received');
        $cash_due = PaymentCollect::where('employee_id',$id)->sum('cash_due');
        $present = Attendance::where('employee_id',$id)->where('month',date('m'))->where('year',date('Y'))->get();
        $countpresent = $present->count();
        return view('admin.employee.view', compact('view_info','countpresent','cash_received','cash_due'));
    }
        
    public function employee_payment_collect($id){
        $users = User::whereIsAdmin('0')->get();
        $clist = PaymentCollect::where('employee_id',$id)->orderBy('id','DESC')->get();
        $site_list = SiteManagement::orderBy('id','DESC')->get();
        return view('admin.employee.all_payment_collect', compact('clist','site_list','users'));
    }
    
    public function view_employee_payment_collect(Request $request,$id){
        $users = User::whereIsAdmin('0')->get();
        $vlist = PaymentCollect::where('id',$id)->first();
        $site_list = SiteManagement::orderBy('id','DESC')->get();
        return view('admin.employee.view_all_payment_collect', compact('vlist','site_list','users'));
    }
    
    public function delete_employee_payment_collect(Request $request,$id){
        $vlist = PaymentCollect::where('id',$id)->first();
        $pc = PaymentCollect::where('id',$id)->delete();   
        return redirect('/admin/employee_payment_collect/'.$vlist->employee_id);
    }

    // for employee 
    public function create_contact(Request $request){
        return view('admin.contact.create_contact');
    }
    
    public function store_contact(Request $request){
        $id = Auth::user()->id;
        $data = array();
        $data['user_id']= $id;
        $data['subject']= $request->subject;
        $data['message']= $request->message;
     
        ContactAdmin::create($data);
        return redirect()->route('contact_list')->with('success','Contact Has Been Added successfully');
    }

    public function view_contact(Request $request,$id){
        $view_contact_list = ContactAdmin::where('id',$id)->first();
        return view('admin.contact.view_contact', compact('view_contact_list'));
    }
    
    public function contact_list(Request $request){
        $id = Auth::user()->id;
        $all_contact_list = ContactAdmin::where('user_id',$id)->orderBy('id','DESC')->get();
        return view('admin.contact.contact_list', compact('all_contact_list'));
    }
    
    public function delete_contact(Request $request,$id){
        $pc = ContactAdmin::where('id',$id)->delete();   
        return redirect('/admin/contact_list');
    }
    
    //end
    //for admin
    public function all_contact_list(Request $request){
        $emp = User::whereIsAdmin('0')->get();
        $all_contact_list = ContactAdmin::orderBy('id','DESC')->get();
        return view('admin.contact.all_contact_list', compact('all_contact_list','emp'));
    }
    
    public function delete_contact_list(Request $request,$id){
        $pc = ContactAdmin::where('id',$id)->delete();   
        return redirect('/admin/all_contact_list/');
    }
    
    public function view_all_contact(Request $request,$id){
        $users = User::whereIsAdmin('0')->get();
        $view_contact_list = ContactAdmin::where('id',$id)->first();
        return view('admin.contact.all_view_contact', compact('view_contact_list','users'));
    }*/
    //end
    
    //activity notification
    public function activity_list(Request $request){
        $emp = User::whereIsAdmin('0')->get();
        $role = Role::where('role_status','1')->get();
        $activity_list = ActivityNotification::orderBy('id','DESC')->get();
        return view('admin.contact.activity_list', compact('activity_list','emp','role'));
    }
    
    public function delete_activity(Request $request,$id){
        $pc = ActivityNotification::where('id',$id)->delete();   
        return redirect('/admin/activity_list/');
    }
    
    public function view_activity(Request $request,$id){
        $infos = ActivityNotification::where('id',$id)->first();
        $status = $infos->status;
        if($status == "unread"){
            $update['status'] = "read";
             ActivityNotification::where('id',$id)->update($update);
        }
        $users = User::whereIsAdmin('0')->get();
        $role = Role::where('role_status','1')->get();
        $view_activity_list = ActivityNotification::where('id',$id)->first();
        return view('admin.contact.activity_view', compact('view_activity_list','users','role'));
    }
    //end

}