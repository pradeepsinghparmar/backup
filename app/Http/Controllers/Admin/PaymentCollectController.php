<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaymentCollect;
use App\Models\SiteManagement;
use App\Models\Allapi;
use App\Models\Newapidata;
use App\Models\SitePaymentTotal;
use App\Models\ActivityNotification;
use Hash;
use Auth;
class PaymentCollectController extends Controller
{
    public function index(){
         $id = Auth::user()->id;
         $clist = PaymentCollect::where('employee_id',$id)->orderBy('id','DESC')->get();
         $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
          $count_received = PaymentCollect::where('employee_id',$id)->where('payment_adjustment','0')->sum('cash_received');
        $count_due = PaymentCollect::where('employee_id',$id)->where('payment_adjustment','0')->sum('cash_due');
        return view('admin.payment_collect.index', compact('clist','site_list','count_received','count_due'));
    }
    
    public function getTotalSitePayment(Request $request){
        $site_id = $request->site_id;
        $month_year = $request->month;
        $myear = explode("-",$month_year);
        // dd($myear);
        $year = $myear[0];
        $month = $myear[1];
        $amount_count1 = SitePaymentTotal::where('site_id',$site_id)->where('year',$year)->where('month',$month)->first();
         if(!empty($amount_count1->total_amount)){
          $amount_count11 = $amount_count1->total_amount;
        }else{
          $amount_count11 = '0';  
        }
        $amount_count2 = PaymentCollect::where('site_id',$site_id)->where('year',$year)->where('month',$month)->sum('cash_received');
        if(!empty($amount_count2)){
          $amount_count_plus = $amount_count11 - $amount_count2;
          $amount_count = number_format((float)$amount_count_plus, 2, '.', '');
        }else{
          $amount_count = $amount_count11;  
        }
        echo  json_encode($amount_count);
    }
    
    // for admin
    public function all_emp_payment_collect(){
        $users = User::get();
        $clist = PaymentCollect::where('payment_adjustment','0')->where('month',date('m'))->where('year',date('Y'))->orderBy('date','DESC')->distinct()->get(['site_id']);
        // dd($clist);
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        
        // $count_cash = PaymentCollect::where('payment_adjustment','0')->sum('total_amount');
        // $count_received = PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->groupBy('site_id')->get();
        // $count_received = PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->distinct()->get(['site_id','employee_id']);
        // dd($count_received);
       
        // $count_due =  PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->distinct()->get(['site_id'])->sum('cash_due');
        return view('admin.payment_collect.all_emp_payment_collect', compact('clist','site_list','users'));
    }  
    
     public function all_due_cash(){
        $users = User::get();
        $clist = PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->distinct()->get(['site_id']);
        // dd($clist);
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        
        // $count_cash = PaymentCollect::where('payment_adjustment','0')->sum('total_amount');
        // $count_received = PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->groupBy('site_id')->get();
        // $count_received = PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->distinct()->get(['site_id','employee_id']);
        // dd($count_received);
       
        // $count_due =  PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->distinct()->get(['site_id'])->sum('cash_due');
        return view('admin.payment_collect.all_due_cash', compact('clist','site_list','users'));
    }  
    
     public function all_received_cash(){
        $users = User::get();
        $clist = PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->distinct()->get(['site_id']);
        // dd($clist);
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        
        // $count_cash = PaymentCollect::where('payment_adjustment','0')->sum('total_amount');
        // $count_received = PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->groupBy('site_id')->get();
        // $count_received = PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->distinct()->get(['site_id','employee_id']);
        // dd($count_received);
       
        // $count_due =  PaymentCollect::where('payment_adjustment','0')->orderBy('id','DESC')->distinct()->get(['site_id'])->sum('cash_due');
        return view('admin.payment_collect.all_received_cash', compact('clist','site_list','users'));
    }  
    
    
    public function all_payment_collect(Request $request,$id){
        $site_id = $id;
        $from_date = $request->start_date;
        $to_date = $request->end_date;
          if(!empty($from_date) && !empty($to_date))
          {
$clist = PaymentCollect::where('site_id',$id)->where('payment_adjustment','0')->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('id','DESC')->get();
	}else{
$clist = PaymentCollect::where('site_id',$id)->where('payment_adjustment','0')->orderBy('id','DESC')->get();
}
        $users = User::get();
        
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        $count_cash = PaymentCollect::where('payment_adjustment','0')->sum('total_amount');
        $count_received = PaymentCollect::where('payment_adjustment','0')->sum('cash_received');
        $count_due = PaymentCollect::where('payment_adjustment','0')->sum('cash_due');
        return view('admin.payment_collect.all_payment_collect', compact('from_date','to_date','site_id','clist','site_list','users','count_received','count_due','count_cash'));
    }
    
     public function view_all_payment_collect(Request $request,$id){
         $users = User::get();
        $vlist = PaymentCollect::where('id',$id)->first();
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.payment_collect.view_all_payment_collect', compact('vlist','site_list','users'));
    }
    
    public function delete_all_payment_collect(Request $request,$id){
        $pc = PaymentCollect::where('id',$id)->delete();   
        return redirect()->route('all_emp_payment_collect');
    } 
    
   
    // end admin
    
    public function create_payment_collect(Request $request){
        $get_month_year = Newapidata::distinct()->get(['month','year']);
        // dd(date("Y-m-d", strtotime("first day of january this year")));
        // dd(date("m", strtotime("first day of january this year")));
         //dd(date("m", strtotime("last day of this month")));
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.payment_collect.create', compact('site_list','get_month_year'));
    } 
    
    
    public function view_payment_collect($id){
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        $vlist = PaymentCollect::where('id',$id)->first();
        return view('admin.payment_collect.view', compact('vlist','site_list'));
    }
    
    //for employee
     public function delete_payment_collect(Request $request,$id){
                $data1['user_id']= Auth::user()->id;
                $data1['user_type']= Auth::user()->role;
                $data1['module']= 'Payment Collect';
                $data1['activity']= 'Delete Site Payment';
                $data1['status']= 'unread';
                // dd($data);
                ActivityNotification::create($data1);
        $pc = PaymentCollect::where('id',$id)->delete();   
        return redirect()->route('payment_collect.index');
    }

    public function store_payment_collect(Request $request)
        {
            // dd($request->month);
             if($request->total_amount >= $request->cash_received) {
                 
                 $myear = explode("-",$request->month);
                // dd($myear);
                $year = $myear[0];
                $month = $myear[1];
                $id = Auth::user()->id;
                $data = array();
                $data['site_id']= $request->site_id;
                $data['employee_id']= $id;
                $data['site_location']= $request->site_location;
                $data['cash_received']= $request->cash_received;
                $data['cash_due']= $request->total_amount - $request->cash_received;
                $data['date']= $request->date;
                $data['month']= $month;
                $data['year']= $year;
                $data['total_amount']= $request->total_amount;
                // dd($data);
                PaymentCollect::create($data);
                $data1['user_id']= Auth::user()->id;
                $data1['user_type']= Auth::user()->role;
                $data1['module']= 'Payment Collect';
                $data1['activity']= 'Create Site Payment';
                $data1['status']= 'unread';
                // dd($data);
                ActivityNotification::create($data1);
                
                return redirect()->route('payment_collect.index')->with('success','Site Payment Added successfully');
             }else{ 
                 return redirect()->route('create_payment_collect')->with('error','Please check Total Amount  should not greater then Received Payment.');  
             }
        }
        
   
    // payment adjustment for admin
     public function create_payment_collect_for_admin(Request $request){
        $get_month_year = Newapidata::distinct()->get(['month','year']);
        // dd(date("Y-m-d", strtotime("first day of january this year")));
        // dd(date("m", strtotime("first day of january this year")));
         //dd(date("m", strtotime("last day of this month")));
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.payment_collect.create_payment_collect_for_admin', compact('site_list','get_month_year'));
    } 
     public function store_payment_collect_for_admin(Request $request)
        {
            // dd($request->month);
             // if($request->total_amount >= $request->cash_received) {
                 
                 $myear = explode("-",$request->month);
                // dd($myear);
                $year = $myear[0];
                $month = $myear[1];
                $id = Auth::user()->id;
                $data = array();
                $data['site_id']= $request->site_id;
                $data['employee_id']= $id;
                $data['site_location']= $request->site_location;
                $data['cash_received']= $request->cash_received;
                $data['cash_due']= $request->total_amount - $request->cash_received;
                $data['date']= $request->date;
                $data['month']= $month;
                $data['year']= $year;
                $data['total_amount']= $request->total_amount;
                // dd($data);
                PaymentCollect::create($data);
                $data1['user_id']= Auth::user()->id;
                $data1['user_type']= Auth::user()->role;
                $data1['module']= 'Payment Collect';
                $data1['activity']= 'Create Site Payment';
                $data1['status']= 'unread';
                // dd($data);
                ActivityNotification::create($data1);
                
                return redirect()->route('all_emp_payment_collect')->with('success','Site Payment Added successfully');
             // }else{ 
             //     return redirect()->route('create_payment_collect')->with('error','Please check Total Amount  should not greater then Received Payment.');  
             // }
        }

     public function site_payment_adjustment(){
         $users = User::get();
         $clist = PaymentCollect::distinct()->where('payment_adjustment','1')->where('year',date('Y'))->where('month',date('m'))->orderBy('id','DESC')->get(['site_id','month']);
         $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.payment_adjustment.site_payment_adjustment', compact('clist','site_list','users'));
    }
    
    
     public function search_sitewise_cash_adjustment(Request $request){
         
          $from_date = $request->start_date;
        $to_date = $request->end_date;
        $name = $request->site_name;
        // dd($name);
         if(!empty($name) && !empty($from_date) && !empty($to_date))
          {
              $clist = PaymentCollect::distinct()->where('payment_adjustment','1')->whereIn('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get(['site_id','month']);
            //   dd($clist);
          }
         $users = User::get();
         //$clist = PaymentCollect::distinct()->where('payment_adjustment','1')->where('year',date('Y'))->where('month',date('m'))->orderBy('id','DESC')->get(['site_id','month']);
         $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.payment_adjustment.search_sitewise_cash_adjustment', compact('from_date','to_date','name','clist','site_list','users'));
    }
    
    public function payment_adjustment($site_id){
         $users = User::get();
         $clist = PaymentCollect::where('site_id',$site_id)->where('payment_adjustment','1')->where('year',date('Y'))->where('month',date('m'))->orderBy('id','DESC')->get();
         $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.payment_adjustment.payment_adjustment', compact('clist','site_list','users'));
    }
    
     public function view_payment_adjustment(Request $request,$id){
         $users = User::get();
        $vlist = PaymentCollect::where('id',$id)->first();
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.payment_adjustment.view_payment_adjustment', compact('vlist','site_list','users'));
    }
    
    public function create_payment_adjustment(Request $request){
        $get_month_year = Newapidata::distinct()->get(['month','year']);
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.payment_adjustment.create_payment_adjustment', compact('site_list','get_month_year'));
    } 
     
     
     
      public function store_payment_adjustment(Request $request)
        {
            // dd($request->month);
             if($request->total_amount >= $request->cash_received) {
                 
                 $myear = explode("-",$request->month);
                // dd($myear);
                $year = $myear[0];
                $month = $myear[1];
                $id = Auth::user()->id;
                $data = array();
                $data['site_id']= $request->site_id;
                $data['employee_id']= $id;
                $data['reason']= $request->reason;
                $data['cash_received']= $request->cash_received;
                $data['cash_due']= $request->total_amount - $request->cash_received;
                $data['date']= $request->date;
                $data['month']= $month;
                $data['year']= $year;
                $data['total_amount']= $request->total_amount;
                $data['payment_adjustment']= '1';
                $data['graph']= '1';
                // dd($data);
                PaymentCollect::create($data);
                
                return redirect()->route('site_payment_adjustment')->with('success','Adjustment Site Payment Added successfully');
             }else{ 
                 return redirect()->route('create_payment_adjustment')->with('error','Please check Total Amount  should not greater then Received Payment.');  
             }
        }
        
           public function delete_payment_adjustment(Request $request,$id){
              
                $pc = PaymentCollect::where('id',$id)->delete();   
                return redirect()->route('site_payment_adjustment');
         }
   
    // end payment adjustment for admin
  
}