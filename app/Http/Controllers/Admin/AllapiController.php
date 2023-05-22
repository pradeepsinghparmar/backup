<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allapi;
use App\Models\Sale;
use App\Models\MonthlySale;
use App\Models\User;
use App\Models\PaymentCollect;
use App\Models\SiteManagement;
use App\Models\Newapidata;
use App\Models\SitePaymentTotal;
use App\Models\SaleReportCreateVoucher;
use DB;
use Hash;
class AllapiController extends Controller
{
    public function index(){
        $api_list = Allapi::orderBy('id','DESC')->get();
        return view('admin.all_api.index', compact('api_list'));
    }
    
    
    public function create_allapi(Request $request){
        return view('admin.all_api.create');
    }
    
    
   
    public function store_allapi(Request $request)
        {
           
        //   $url = $request->api_url;   
        //   $ch = curl_init();
        //   curl_setopt($ch, CURLOPT_URL, $url);
        //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //   $result = curl_exec($ch);
        //   $getlist = $result;
        //   $show_list = json_decode($getlist,true);     
        //     if(!empty($show_list)){
        //       foreach($show_list as $info) { 
        //          $amount =    $info['sale'];
        //       }
        //     }else{
        //         $amount =    '0';
        //     }
            $data = array();
            $data['site_id_name']= $request->site_id_name;
            $data['name']= $request->name;
            $data['api_url']= $request->api_url;
            $data['type']= $request->type;
         
            Allapi::create($data);
            return redirect()->route('allapi.index')->with('success','API Has Been Added successfully');
        }
        
    public function delete_allapi($id){
        $category = Allapi::where('id',$id)->delete();   
        return redirect()->route('allapi.index');
    }
    
    
     public function change_status(Request $request)
    {
         $api_id = $request->api_id;
        
         $details = Allapi::where('id',$api_id)->first(); 
        //   dd($details);
            $name = $details->name;
            $status = $details->status;
            if($status == '0'){
                $newStatus = '1';
            }else if($status == '1'){
                $newStatus = '0';
            }
            $update['status'] = $newStatus;
            
            Allapi::where('id',$api_id)->update($update);
            
            SitePaymentTotal::where('site_id',$name)->update($update);
            Sale::where('name',$name)->update($update);
            MonthlySale::where('name',$name)->update($update);
            echo $status;

    }
    
    
     public function cash_reports(Request $request){
        //  where('status','1')->
        $total_payment =  SitePaymentTotal::where('month',date('m'))->where('year',date('Y'))->where('status','1')->get();
        // dd($total_payment);
        $site_list =  Allapi::where('status','1')->get();
        // dd($site_list);
        $payment_adjustment = PaymentCollect::where('payment_adjustment','1')->where('month',date('m'))->where('year',date('Y'))->sum('cash_received');
        // dd($payment_adjustment);
        $total_site_payments = SitePaymentTotal::where('month',date('m'))->where('year',date('Y'))->where('status','1')->sum('total_amount');
        $total_site_count = SitePaymentTotal::where('month',date('m'))->where('year',date('Y'))->where('status','1')->get()->count();
        return view('admin.all_api.cash_reports',compact('payment_adjustment','total_payment','site_list','total_site_payments','total_site_count'));
    } 
    
    
    // public function search_sitewise_cash_reports(Request $request){
        
    //     $from_date = $request->start_date;
    //     $to_date = $request->end_date;
    //     $name = $request->site_name;
    //     $api_site_info =  Allapi::where('name',$name)->first();
    //     //  dd($from_date);
    //       if(!empty($name) && !empty($from_date) && !empty($to_date))
    //       {
    //          if($api_site_info->type == '1')
    //          {
    //          // $show_site_total_payment1 = PaymentCollect::where('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->get();
    //         //   dd($show_site_total_payment);
    //           //foreach($show_site_total_payment1 as $ps){
    //               $show_site_total_payment = Newapidata::distinct()->where('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->orderBy('activation_date','ASC')->get(['activation_date']);
    //              // dd($show_site_total_payment);
    //          // }
    //           $sum_site_total_payment = Newapidata::where('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->get()->sum('price');
              
    //          }elseif($api_site_info->type == '2')
    //          {
    //              $show_site_total_payment = Newapidata::where('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->orderBy('activation_date','ASC')->get();
    //             //  dd($show_site_total_payment);
    //              $sum_site_total_payment = Newapidata::where('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->get()->sum('price');
    //          }
    //       }
    //     $site_list =  Allapi::get();
    //     return view('admin.all_api.sitewise_cash_reports',compact('site_list','api_site_info','name','from_date','to_date','show_site_total_payment','sum_site_total_payment'));
    // }
    
    
      public function search_sitewise_cash_reports(Request $request){
        //  dd($request->all());
        //$selected = implode(",", $request->site_name);
        //dd($selected);
        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $name = $request->site_name;
        // dd($name);
       
	   // $searchValues = implode(',', $name);
        // $api_site_info =  Allapi::where('name',$name)->get();
        //  dd($from_date);
          if(!empty($name) && !empty($from_date) && !empty($to_date))
          {
            //  if($api_site_info->type == '1')
            //  {
                 //var_dump($name);die;
                  $show_site_total_payment = Newapidata::distinct()->whereIn('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->orderBy('site_name','ASC')->orderBy('activation_date','ASC')->get(['activation_date','site_name']);
                //  $show_site_total_payment =  \DB::select("SELECT DISTINCT activation_date,site_name FROM `new_api_details_tbl` WHERE `site_name` IN ($name) AND activation_date >= '2022-05-01' AND activation_date <= '2022-05-05'");
                //  dd($show_site_total_payment);
                //   $sum_site_total_payment = Newapidata::whereIn('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->get()->sum('price');
            //  }elseif($api_site_info->type == '2')
            //  {
            //      $show_site_total_payment = Newapidata::whereIn('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->orderBy('activation_date','ASC')->get();
            //      $sum_site_total_payment = Newapidata::whereIn('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->get()->sum('price');
            //  }
          }
        $site_list =  Allapi::where('status','1')->get();
        return view('admin.all_api.sitewise_cash_reports',compact('site_list','name','from_date','to_date','show_site_total_payment'));
    }


     public function search_sitewise_cash_received_reports(Request $request){
        
        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $name = $request->site_name;
        $api_site_info =  Allapi::where('name',$name)->first();
        //  dd($from_date);
          if(!empty($name) && !empty($from_date) && !empty($to_date))
          {
            //  if($api_site_info->type == '1')
            //  {
             // $show_site_total_payment1 = PaymentCollect::where('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->get();
            //   dd($show_site_total_payment);
              //foreach($show_site_total_payment1 as $ps){
                  $show_site_total_payment = PaymentCollect::where('payment_adjustment','0')->whereIn('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('date','ASC')->get();
                 // dd($show_site_total_payment);
             // }
                 $sum_site_total_payment = PaymentCollect::where('payment_adjustment','0')->whereIn('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get()->sum('cash_received');
              
            //  }elseif($api_site_info->type == '2')
            //  {
            //      $show_site_total_payment = PaymentCollect::where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('date','ASC')->get();
            //     //  dd($show_site_total_payment);
            //      $sum_site_total_payment = PaymentCollect::where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get()->sum('price');
            //  }
          }
        $site_list =  Allapi::where('status','1')->get();
        return view('admin.all_api.sitewise_cash_received_reports',compact('api_site_info','site_list','name','from_date','to_date','show_site_total_payment','sum_site_total_payment'));
    }
    
      public function search_cash_received_reports(Request $request){
        
        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $name = $request->site_name;
        $api_site_info =  Allapi::where('name',$name)->first();
        //  dd($from_date);
          if(!empty($name) && !empty($from_date) && !empty($to_date))
          {
            //  if($api_site_info->type == '1')
            //  {
             // $show_site_total_payment1 = PaymentCollect::where('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->get();
            //   dd($show_site_total_payment);
              //foreach($show_site_total_payment1 as $ps){
                  $show_site_total_payment = PaymentCollect::where('payment_adjustment','0')->where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('date','ASC')->get();
                 // dd($show_site_total_payment);
             // }
                 $sum_site_total_payment = PaymentCollect::where('payment_adjustment','0')->where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get()->sum('cash_received');
              
            //  }elseif($api_site_info->type == '2')
            //  {
            //      $show_site_total_payment = PaymentCollect::where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('date','ASC')->get();
            //     //  dd($show_site_total_payment);
            //      $sum_site_total_payment = PaymentCollect::where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get()->sum('price');
            //  }
          }
        $site_list =  Allapi::where('status','1')->get();
        return view('admin.all_api.search_cash_received',compact('api_site_info','site_list','name','from_date','to_date','show_site_total_payment','sum_site_total_payment'));
    }
    
     public function search_cash_due_reports(Request $request){
        
        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $name = $request->site_name;
        $api_site_info =  Allapi::where('name',$name)->first();
        //  dd($from_date);
          if(!empty($name) && !empty($from_date) && !empty($to_date))
          {
            //  if($api_site_info->type == '1')
            //  {
             // $show_site_total_payment1 = PaymentCollect::where('site_name',$name)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->get();
            //   dd($show_site_total_payment);
              //foreach($show_site_total_payment1 as $ps){
                  $show_site_total_payment = PaymentCollect::where('payment_adjustment','0')->where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('date','DESC')->limit(1)->get();
                 // dd($show_site_total_payment);
             // }
                 $sum_site_total_payment = PaymentCollect::where('payment_adjustment','0')->where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get()->sum('cash_due');
              
            //  }elseif($api_site_info->type == '2')
            //  {
            //      $show_site_total_payment = PaymentCollect::where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('date','ASC')->get();
            //     //  dd($show_site_total_payment);
            //      $sum_site_total_payment = PaymentCollect::where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get()->sum('price');
            //  }
          }
        $site_list =  Allapi::where('status','1')->get();
        return view('admin.all_api.search_cash_due',compact('api_site_info','site_list','name','from_date','to_date','show_site_total_payment','sum_site_total_payment'));
    }
        
     
   public function cash_summary(Request $request){
       $name = $request->site_name;
       if(!empty($name))
          {
             $total_payment =  SitePaymentTotal::whereIn('site_id',$name)->where('month',date('m'))->where('year',date('Y'))->get();
             $total_system_amount = SitePaymentTotal::whereIn('site_id',$name)->where('month',date('m'))->where('year',date('Y'))->get()->sum('total_amount');
             $payment_received = PaymentCollect::where('payment_adjustment','0')->whereIn('site_id',$name)->where('month',date('m'))->where('year',date('Y'))->sum('cash_received');
              //$sum_site_total_payment = PaymentCollect::where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get()->sum('price');
          }else{
            $total_payment =  SitePaymentTotal::where('month',date('m'))->where('year',date('Y'))->where('status','1')->get();
            // dd($total_payment);
            // $site_list =  Allapi::get();
            $total_system_amount = SitePaymentTotal::where('month',date('m'))->where('year',date('Y'))->get()->where('status','1')->sum('total_amount');
            // dd($total_system_amount);
            
            $payment_received = PaymentCollect::where('payment_adjustment','0')->where('month',date('m'))->where('year',date('Y'))->sum('cash_received');
        }
        $payment_adjustment = PaymentCollect::where('payment_adjustment','1')->where('month',date('m'))->where('year',date('Y'))->sum('cash_received');
        // dd($payment_adjustment);
        $site_list =  Allapi::where('status','1')->get();  
        return view('admin.all_api.cash_summary',compact('payment_received','total_payment','site_list','name','total_system_amount','payment_adjustment'));
    } 
     public function received_voucher_all(){
        $data = User::get();
        foreach($data as $d){
           $price = SaleReportCreateVoucher::where('user_id',$d->id)->where('status','success')->sum('price');
           $d['price'] = $price;
           
        }

       return view('admin.all_api.voucher_summary',compact('data'));
    } 
    
     public function received_voucher_singel( $id){
       
            $userdata = User::where('id',$id)->first();
           $data = SaleReportCreateVoucher::where('user_id',$id)->where('status','success')->get();
          foreach($data as $d){
           $sitename = DB::table('all_api_tbl')->where('name',$d->site_id)->pluck('site_id_name');
           $d['sitename'] = $sitename;
        }
         $ndata = User::get();
        foreach($ndata as $d){
           $price = SaleReportCreateVoucher::where('user_id',$d->id)->where('status','success')->sum('price');
           $d['price'] = $price;
        }

       return view('admin.all_api.voucher_summary_singel',compact('data','userdata','ndata'));
    } 
     public function received_voucher_filter(Request $request){
        
        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $name = $request->profile_name;
        // dd($name);
          if(!empty($name) && !empty($from_date) && !empty($to_date))
          {
            $data = SaleReportCreateVoucher::where('status','success')->whereIn('profile',$name)->where('created_at', '>=',$from_date)->where('created_at', '<=',$to_date)->orderBy('created_at','ASC')->get();
            
          }
        //   dd($data);
            foreach($data as $d){
           $sitename = DB::table('all_api_tbl')->where('name',$d->site_id)->pluck('site_id_name');
           $d['sitename'] = $sitename;
        }
         $ndata = User::get();
        foreach($ndata as $d){
           $price = SaleReportCreateVoucher::where('user_id',$d->id)->where('status','success')->sum('price');
           $d['price'] = $price;
           
        }
        return view('admin.all_api.voucher_summary_singel',compact('data','ndata'));
    }
    public function cash_site_summary(Request $request, $id){
        
        $site_id = $id;
        $from_date = $request->start_date;
        $to_date = $request->end_date;
          if(!empty($from_date) && !empty($to_date))
          {
             $show_site_total_payment = Newapidata::distinct()->where('site_name',$id)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->orderBy('site_name','ASC')->orderBy('activation_date','ASC')->get(['activation_date','site_name']);
             $payment_adjustment = PaymentCollect::where('payment_adjustment','1')->where('site_id',$id)->where('date',$from_date)->where('date',$to_date)->sum('cash_received');
             $total_price = Newapidata::where('site_name',$id)->where('activation_date',$from_date)->where('activation_date',$to_date)->sum('price');
              
          }else{
              $from_date = date("Y-m-d", strtotime("first day of this month"));
             $to_date = date("Y-m-d", strtotime("last day of this month"));
             $show_site_total_payment = Newapidata::distinct()->where('site_name',$id)->where('month',date('m'))->where('year', date('Y'))->orderBy('site_name','ASC')->orderBy('activation_date','ASC')->get(['activation_date','site_name']);
            //  dd($show_site_total_payment);
            $payment_adjustment = PaymentCollect::where('payment_adjustment','1')->where('site_id',$id)->where('month',date('m'))->where('year',date('Y'))->sum('cash_received');
          $total_price = Newapidata::where('site_name',$id)->where('month',date('m'))->where('year',date('Y'))->sum('price');
          }
        $site_list =  Allapi::where('name',$id)->first();    
        return view('admin.all_api.cash_site_summary',compact('total_price','payment_adjustment','site_id','site_list','from_date','to_date','show_site_total_payment'));
    } 
    
    
    public function cash_received_summary(Request $request, $id){
        $site_id = $id;
        $from_date = $request->start_date;
        $to_date = $request->end_date;
          if(!empty($from_date) && !empty($to_date))
          {
             $show_site_total_payment = PaymentCollect::where('payment_adjustment','0')->where('site_id',$id)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('date','ASC')->get();
             $system_amount =  SitePaymentTotal::where('site_id',$id)->where('month',date('m',strtotime($from_date)))->where('year',date('Y',strtotime($to_date)))->first(); 
            //  $show_due = PaymentCollect::where('payment_adjustment','0')->where('site_id',$id)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('date','ASC')->get();
           
              
          }else{   
             $from_date = date("Y-m-d", strtotime("first day of this month"));
             $to_date = date("Y-m-d", strtotime("last day of this month"));
             
             $show_site_total_payment = PaymentCollect::where('payment_adjustment','0')->where('site_id',$id)->where('month',date('m'))->where('year', date('Y'))->orderBy('date','ASC')->get();
             //dd($show_site_total_payment);
             $system_amount =  SitePaymentTotal::where('site_id',$id)->where('month',date('m'))->where('year',date('Y'))->first();   
             
          }
        $users = User::whereIsAdmin('0')->get();
        $site_list =  Allapi::where('name',$id)->first();   
        
        return view('admin.all_api.cash_received_summary',compact('system_amount','users','site_id','site_list','from_date','to_date','show_site_total_payment'));
    }
    
     public function cash_site_cash_report(Request $request, $id){
        
        $site_id = $id;
        $from_date = $request->start_date;
        $to_date = $request->end_date;
          if(!empty($from_date) && !empty($to_date))
          {
             $show_site_total_payment = Newapidata::distinct()->where('site_name',$id)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->orderBy('site_name','ASC')->orderBy('activation_date','ASC')->get(['activation_date','site_name']);
          }else{
              $from_date = date("Y-m-d", strtotime("first day of this month"));
             $to_date = date("Y-m-d", strtotime("last day of this month"));
             $show_site_total_payment = Newapidata::distinct()->where('site_name',$id)->where('month',date('m'))->where('year', date('Y'))->orderBy('site_name','ASC')->orderBy('activation_date','ASC')->get(['activation_date','site_name']);
            //  dd($show_site_total_payment);
          }
        $site_list =  Allapi::where('name',$id)->first();    
        return view('admin.all_api.cash_site_cash_report',compact('site_id','site_list','from_date','to_date','show_site_total_payment'));
    } 
    
     public function cash_site_balance_report(Request $request, $id){
        
        $site_id = $id;
        $from_date = $request->start_date;
        $to_date = $request->end_date;
          if(!empty($from_date) && !empty($to_date))
          {
             $show_site_total_payment = Newapidata::distinct()->where('site_name',$id)->where('activation_date', '>=',$from_date)->where('activation_date', '<=',$to_date)->orderBy('site_name','ASC')->orderBy('activation_date','ASC')->get(['activation_date','site_name']);
          }else{
              $from_date = date("Y-m-d", strtotime("first day of this month"));
             $to_date = date("Y-m-d", strtotime("last day of this month"));
             $show_site_total_payment = Newapidata::distinct()->where('site_name',$id)->where('month',date('m'))->where('year', date('Y'))->orderBy('site_name','ASC')->orderBy('activation_date','ASC')->get(['activation_date','site_name']);
            //  dd($show_site_total_payment);
          }
        $site_list =  Allapi::where('name',$id)->first();    
        return view('admin.all_api.cash_site_balance_report',compact('site_id','site_list','from_date','to_date','show_site_total_payment'));
    } 

    public function remaining_balance(Request $request){
        $name = $request->site_name;
       if(!empty($name))
          {
             $total_payment =  SitePaymentTotal::whereIn('site_id',$name)->where('month',date('m'))->where('year',date('Y'))->get();
             $total_system_amount = SitePaymentTotal::whereIn('site_id',$name)->where('month',date('m'))->where('year',date('Y'))->get()->sum('total_amount');
             $payment_received = PaymentCollect::where('payment_adjustment','0')->whereIn('site_id',$name)->where('month',date('m'))->where('year',date('Y'))->sum('cash_received');
              //$sum_site_total_payment = PaymentCollect::where('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->get()->sum('price');
          }else{
            $total_payment =  SitePaymentTotal::where('month',date('m'))->where('year',date('Y'))->where('status','1')->get();
            // dd($total_payment);
            // $site_list =  Allapi::get();
            $total_system_amount = SitePaymentTotal::where('month',date('m'))->where('year',date('Y'))->get()->where('status','1')->sum('total_amount');
            // dd($total_system_amount);
            
            $payment_received = PaymentCollect::where('payment_adjustment','0')->where('month',date('m'))->where('year',date('Y'))->sum('cash_received');
        }
        $payment_adjustment = PaymentCollect::where('payment_adjustment','1')->where('month',date('m'))->where('year',date('Y'))->sum('cash_received');
        // dd($payment_adjustment);
        $site_list =  Allapi::where('status','1')->get();  
        return view('admin.all_api.remaining_balance',compact('payment_received','total_payment','site_list','name','total_system_amount','payment_adjustment'));
    } 

    public function received_balance(Request $request){

      
        $name = $request->site_name;
        $from_date = $request->start_date;
        $to_date = $request->end_date;
          if(!empty($from_date) && !empty($to_date))
          {
             $clist = PaymentCollect::whereIn('site_id',$name)->where('date', '>=',$from_date)->where('date', '<=',$to_date)->orderBy('site_id','ASC')->orderBy('date','ASC')->get();
          }else{
              $from_date = date("Y-m-d", strtotime("first day of this month"));
             $to_date = date("Y-m-d", strtotime("last day of this month"));
            $clist = PaymentCollect::where('payment_adjustment','0')->where('month',date('m'))->where('year',date('Y'))->orderBy('id','DESC')->get();
            //  dd($show_site_total_payment);
          }
        $users = User::get();
        
        // dd($clist);
        $site_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        
       
        return view('admin.all_api.received_balance', compact('name','from_date','to_date','clist','site_list','users'));
    }  
    
    public function delete_received_payment_collect($id){
               
        $pc = PaymentCollect::where('id',$id)->delete();   
        return redirect()->route('received_balance');
    }  
    
    
    
    public function testallapi()
    {
         $from_date_new = date("Y-m-d", strtotime("first day of this month"));
        $to_date_new = date("Y-m-d", strtotime("last day of this month"));

         $data_new = array();
         $data_new1 = array();
         $data_a = array();
         $data_i = array();
         $api_list_new = Allapi::where('status','1')->where('type','1')->orderBy('id','DESC')->get();
        //   dd($api_list_new);
        foreach($api_list_new as $info_new){
            $token  = substr(md5(date('YMD', strtotime('today')).'chanam'), 0, 12);
          $datebetween = $token.'/'.$from_date_new.'/'.$to_date_new;
          $url_new = $info_new->api_url.'/'.$datebetween;
         $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url_new);
   
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        //   dd($responseBody);
                  if(!empty($responseBody)){
                    
foreach($responseBody as $list_n){
                
  $user = Newapidata::where('voucher_code', $list_n['voucher_code'])->exists();

  if(!$user){              
   
      $data_new['site_name']= $info_new->name;
      $data_new['mac_address']= $list_n['mac_address'];
      $data_new['site_id']= $list_n['site_id'];
      $data_new['voucher_code']= $list_n['voucher_code'];
      $data_new['activation_date']= $list_n['activation_date'];
      $data_new['expiry_date']= $list_n['expiry_date'];
      $data_new['price']= $list_n['price'];
      $data_new['profile']= $list_n['profile'];
      $data_new['month']= date('m',strtotime($list_n['activation_date']));
      $data_new['year']= date('Y',strtotime($list_n['activation_date']));
    //   dd($data_new);
      Newapidata::create($data_new);
    } 
}                  
                      
if (SitePaymentTotal::where('site_id',$list_n['site_id'])->where('month',date('m',strtotime($list_n['activation_date'])))->where('year',date('Y',strtotime($list_n['activation_date'])))->exists()) {
// your code...
$data_a['total_amount']= Newapidata::where('site_id',$list_n['site_id'])->where('month',date('m',strtotime($list_n['activation_date'])))->where('year',date('Y',strtotime($list_n['activation_date'])))->sum('price');
SitePaymentTotal::where('site_id',$list_n['site_id'])->where('month',date('m',strtotime($list_n['activation_date'])))->where('year',date('Y',strtotime($list_n['activation_date'])))->update($data_a);
}else{
$data_i['site_id'] = $list_n['site_id'];
$data_i['month'] = date('m',strtotime($list_n['activation_date']));
$data_i['year'] = date('Y',strtotime($list_n['activation_date']));
$data_i['total_amount'] = Newapidata::where('site_id',$list_n['site_id'])->where('month',date('m',strtotime($list_n['activation_date'])))->where('year',date('Y',strtotime($list_n['activation_date'])))->sum('price');
SitePaymentTotal::create($data_i);
                                          } 
                     
                  }
        } //foreach
    }
  
}