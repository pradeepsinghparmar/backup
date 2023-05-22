<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Allapi;
use App\Models\Sale;
use App\Models\MonthlySale;
use App\Models\Sendotpmail;
use App\Models\PaymentCollect;
use App\Models\Attendance;
use App\Models\Verify_otp;
use App\Models\Verify_email;
use App\Models\ActivityNotification;
use App\Models\Holiday;
use App\Models\Month;
use App\Models\AccessSites;
use App\Models\SitePaymentTotal;
use App\Mail\VerifyMail;
use App\Mail\Sendotp;
use App\Mail\Forgot_password;
use App\Models\Notification;
use App\Models\SaleReportCreateVoucher;
use App\Models\Contact;
use App\Models\Event;
use Hash;
use Mail;
use DateTime;
use Validator;
use App\Models\RegisteredUser;

class ApiController extends Controller
{
    
// 404 - page not found 
// 200 - fetch data sucess

   /* function login(Request $request) 
    {
        //echo "hey";die;
        $user= User::where('email', $request->email)->first();
        // print_r($data);
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        
             $token = $user->createToken('my-app-token')->plainTextToken;
        
            $response = [
                'user' => $user,
                'token' => $token
            ];
        
             return response($response, 201);
    }*/
    
    public function getEmployeeList(Request $request)
    {
        
        
    //   return ['name'=>'arpit','email'=>'arpitpanchal@gmail.com'];
       
    //   $students = User::get()->toJson(JSON_PRETTY_PRINT);
       $emp = User::whereIsAdmin('0')->get();
       return response()->json(["message" => "Employee records.","data" =>$emp
            ], 200);
    //   return response($emp, 200);
            //   return response()->json([
            //     "message" => "student record created"
            // ], 201);
    }
    
    public function EmployeeDetailsByToken(Request $request)
    {
       $emp = User::where('api_token', $request->token)->whereIsAdmin('0')->first();
       if($emp)
       {
       return response()->json(["status" => true,"message" => "Employee Details.","data" =>$emp
            ], 200);
       }else
        {
           return response()->json(["status" => false,"message" => "Invalid token"]);
        }
    }
    
    public function getEmployeeLogin(Request $request){
        
        $user= User::where('email', $request->email)->whereIsAdmin('0')->first();
         if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
        if($user->login_status == '1')
        {
       
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['These credentials do not match our records.']
                ], 404);
            }
            
            $validated = auth()->attempt([
            'email'=>$request->email,
            'password'=>$request->password
            ],$request->password);
            
            $token = $user->createToken('my-app-token')->plainTextToken;
            
            $datas['api_token'] = $token;
            User::where('email', $request->email)->update($datas);
            
            if($validated == TRUE)
            {
               return response()->json(["status" => true,"message" => "Login Successfully","user" => $user,"token" => $token,"data" =>$validated], 200);
            }
            else
            {
               return response()->json(["status" => false,"message" => "Email id and password not valid","data" =>$validated]);
            }
        }else{
            return response()->json(["status" => false,"message" => "Your Account is inactive contact to admin."]);
        }
           
    }
    
    public function sendotp(Request $request){
      
    //   echo 'ok';die;
      $otp = substr(str_shuffle("0123456789"), 0, 4);
     
        
        $datas = array();
        $result = User::where("phone", $request->phone)->exists();
      
        if($result){
           
            $datetime               = date('Y-m-d H:i:s');
            $datas['otp']            = $otp;
             $datas['phone']          = $request->phone;
            $datas['date_time']      = date("Y-m-d H:i:s");
            $datas['otp_valid_time'] = date("Y-m-d H:i:s",strtotime("+5 minutes", strtotime($datetime)));
            
            $infoo = Sendotpmail::insert($datas);
            
            // $detail = [
            //     'subject' => 'Otp send',
            //     'otp'     => $datas['otp']
            // ];
            
           
        $message = "Thank you for choosing Your Clindcast Time Logs. Use the following OTP to complete your Forgot Password procedures. OTP is valid for 5 minutes.Your OTP is ".$otp." Thanks Clindcast Time Logs Team";
     
       $url = "https://elitbuzz-me.com/sms/smsapi?api_key=C200332460c9157cc64e06.85843724&type=text&contacts=" .
         $request->phone . "&" .
         "senderid=JWP-WiFi". "&" .
         "msg="  . urlencode($message);
         
           $output = file($url);
         
          if($output){
            //   $mail = mail::to($request->email)->send(new Sendotp($detail));
                return response()->json(["status" => true,"message" => "Otp Send on your Mobile Successfully","data" =>$otp], 200);
            }else{
                return response()->json(["status" => false,"message" => "Something Wrong"]);
           }
            
        }else{
            
                return response()->json(["status" => false,"message" => "This Mobile Number is not exist, please enter correct mobile number."]);
           
        }
    }
    
    public function verify_otp(Request $request){
       
         $curnt_time = date('Y-m-d H:i:s');
         $otp_valid_time = Sendotpmail::select('*')->where('phone', $request->phone)->orderBy('id','desc')->first();
        if($otp_valid_time->otp == $request->otp){
         
            if ($curnt_time >= $otp_valid_time->date_time && $curnt_time <= $otp_valid_time->otp_valid_time) 
            {
                $password = $request->password;
                $confirm_password = $request->confirm_password;
           
                if($password == $confirm_password){
                   
                     $data = array();
                     $data1['password'] = Hash::make($request->password);
                     
                    // $id = User::select('id,email')->where('phone', $request->phone)->first();
                   
                    $infoo = User::where('phone',$request->phone)->update($data1);
                    return response()->json(["status" => true,"message" => "Otp Verify Successfully"], 200);
                }else{
                    return response()->json(["status" => false,"message" => "Both Password Does Not Match"]);
                }
            }else{
                return response()->json(["status" => false,"message" => "Otp Expired"]);
            }
        }else{
            
               return response()->json(["status" => false,"message" => "Invalid Otp"]);
           
        }
    }
    
    // public function forgot_password(Request $request){
    //   $result = User::where("phone", $request->phone)->exists();
    //   if($result){
    //         $password = $request->password;
    //         $confirm_password = $request->confirm_password;
       
    //         if($password == $confirm_password){
               
    //          $data = array();
    //          $data1['password'] = Hash::make($request->password);
             
    //         // $id = User::select('id,email')->where('phone', $request->phone)->first();
           
    //         $infoo = User::where('phone',$request->phone)->update($data1);
            
    //         // $detail = [
    //         //     'subject' =>'Change Password',
    //         //     'password' => $password
    //         // ];
            
    //         if($infoo){
    //         //   $mail = mail::to($id['email'])->send(new Forgot_password($detail));
    //             return response()->json(["status" => true,"message" => "Password Change Successfully"], 200);
    //         }else{
    //             return response()->json(["status" => false,"message" => "Something Wrong"]);
    //       }
             
    //     }else{
            
    //         return response()->json(["status" => false,"message" => "Password Does Not Match"]);
    //     }
    //   }else{
            
    //         return response()->json(["status" => false,"message" => "This Mobile Number is not exist, please enter correct Mobile Number."]);
           
    //     }
    // }
    public function  get_permissions(Request $request){
        $employee_id = $request->employee_id;
        if(!$employee_id){
            return response()->json(["status" => false,"message" => "Employee_id not found","data" =>'data'], 404);
        }
        $user= DB::table('users')->where('id', $employee_id)->leftJoin('role','users.role','role.role_id')->value('permission');
        $userArray =  json_decode($user);
        $Arraydata =  DB::table('permission')->whereIn('permission_id', $userArray)->select('codename')->get();
        $data = array();
       foreach($Arraydata as $d){
           $data[] = $d->codename;
       }

         return response()->json(["status" => true,"message" => "Permissions Found","data" =>$data], 200);
    }
   
    public function profile_updated(Request $request){
        
            $data = array();

       if ($file = $request->file('file')) {
           
           $datass = $request->all();

            $validator = Validator::make($datass, [
                'file'=>'required|mimes:png,jpeg,jpg|max:5120',
            ]);
             if ($validator->fails()) {
                return response()->json(["status" => false,"message" => "Upload Image size less then 5 MB"]);
            }else{
                $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                $file->move('./admin/backend/user_profile/', $fileName);    
            }
        }
       $data['name']     = $request->name;
       $data['phone']    = $request->phone;  
       $data['email']    = $request->email;  
      if(!empty($fileName))
      {
          $data['image'] = $fileName;
         $data['image_url'] = asset('admin/backend/user_profile/'.$fileName);
      }
       $infoos = User::where('email',$request->email)->update($data);
       $user= User::where('email', $request->email)->first();
              
                
        if($user){
            return response()->json(["status" => true,"message" => "Profile Update Successfully","data" =>$user], 200);
        }else{
            return response()->json(["status" => false,"message" => "Something Wrong"]);
       }
           
       
    }
   
   
    
    public function profile_picture_upload(Request $request)
    {
        
       $data = array();
       $validator = Validator::make($request->all(),[ 
              'file' => 'required|mimes:png,jpeg,jpg',
        ]);   
 
        if($validator->fails()) {          
            
            return response()->json(["success" => false,'message'=>$validator->errors()], 401);                        
         }  
 
  
        if ($file = $request->file('file')) {
            $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            $file->move('./admin/backend/user_profile/', $fileName); 
 
            //store your file into directory and db
           
         $data['image'] = $fileName;
         $data['image_url'] = asset('admin/backend/user_profile/'.$fileName);
     
         $infoos = User::where('email',$request->email)->update($data);
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $data['image_url']
            ],200);
  
        }
        
        
        
    }
    public function payment_collect(Request $request){
        $data['employee_id']    = $request->employee_id;
        $data['site_id']        = $request->site_id;
        $data['site_location']  = $request->site_location;
        $data['total_amount']   = $request->total_amount;
        $data['cash_received']  = $request->cash_received;
        $data['cash_due']       = $request->cash_due;
        $data['date']           = $request->date;
        $data['month']          = $request->month;
         $data['year']          = $request->year;
       
        // $timestamp = strtotime($request->selectedmonth);
        // $data['month'] = date('m', $timestamp);
        // $data['year'] = date('Y', $timestamp);
        
        $infos = PaymentCollect::create($data);
         
        if($infos){
            return response()->json(["status" => true,"message" => "Payment Collect Successfully"], 200);
        }else{
            return response()->json(["status" => false,"message" => "Something Wrong"]);
        }
    }
    
    public function get_payment_collect(Request $request){
       
        $employee_id = $request->employee_id;
        $emp_dataa = PaymentCollect::where('employee_id',$employee_id)->get();
        
         foreach ($emp_dataa as $emp_data){ 
             
            $getside_name = Allapi::where('name',$emp_data->site_id)->first();
            
        // Code Here
        $detail[] = [
                'employee_id'       => $emp_data->employee_id,
                'site_id'           => $emp_data->site_id,
                'site_name'           => $getside_name->site_id_name,
                'site_location'     => $emp_data->site_location,
                'total_amount'      => $emp_data->total_amount,
                'cash_received'     => $emp_data->cash_received,
                'cash_due'          => $emp_data->cash_due,
                'date'              => $emp_data->date,
                'month'             => $emp_data->month,
                'year'              => $emp_data->year
                ,
            ];
        }
        
            
            if(!empty($detail)){
                return response()->json(["status" => true,"message" => "Payment Collect Data Get Successfully","data" =>$detail], 200);
                
            }else{
                return response()->json(["status" => false,"message" => "Data Not found"]);
           }
    }
    
    public function get_attandance(Request $request){
       
        $employee_id = $request->employee_id;
        $month       = $request->month;
        $year        = $request->year;
        $attendance_dataa = Attendance::where('employee_id',$employee_id)->where('month',$month)->where('year',$year)->get();
        
         foreach ($attendance_dataa as $att_data){ 
        // Code Here
        $detail[] = [
                'id'           => $att_data->id,
                'employee_id'           => $att_data->employee_id,
                'working_from'          => $att_data->working_from,
                'mark_attendance_by'    => $att_data->mark_attendance_by,
                'date'                  => $att_data->date,
                'day'                   => $att_data->day,
                'month'                 => $att_data->month,
                'year'                  => $att_data->year,
                'clock_in'              => $att_data->clock_in,
                'clock_out'             => $att_data->clock_out,
                'total_hours'           => $att_data->total_hours,
                'late'                  => $att_data->late,
                'live_location'         => $att_data->live_location,
                'clock_out_location'    => $att_data->clock_out_location,
                'status'                => $att_data->status,
                'created_at'            => $att_data->created_at
                ,
            ];
        }
        
            if(!empty($detail)){
                return response()->json(["status" => true,"message" => "Get Attandance Successfully","data" =>$detail], 200);
                
            }else{
                return response()->json(["status" => false,"message" => "data not found"]);
           }
    }
    
    public function get_attandance_by_hour(Request $request){
       
        $employee_id = $request->employee_id;
        $month       = $request->month;
        $year        = $request->year;
        $attendance_dataa = Attendance::where('employee_id',$employee_id)->where('month',$month)->where('year',$year)->get();
        
         foreach ($attendance_dataa as $att_data){ 
        // Code Here
        $detail[] = [
                'employee_id'           => $att_data->employee_id,
                'working_from'          => $att_data->working_from,
                'mark_attendance_by'    => $att_data->mark_attendance_by,
                'date'                  => $att_data->date,
                'day'                   => $att_data->day,
                'month'                 => $att_data->month,
                'year'                  => $att_data->year,
                'clock_in'              => $att_data->clock_in,
                'clock_out'             => $att_data->clock_out,
                'total_hours'           => $att_data->total_hours,
                'late'                  => $att_data->late,
                'live_location'         => $att_data->live_location,
                'clock_out_location'    => $att_data->clock_out_location,
                'status'                => $att_data->status,
                'created_at'            => $att_data->created_at
                ,
            ];
        }
        
            if(!empty($detail)){
                return response()->json(["status" => true,"message" => "Get Attandance Successfully","data" =>$detail], 200);
                
            }else{
                return response()->json(["status" => false,"message" => "data not found"]);
           }
    }
    
    public function count_cash_received(Request $request){
        $employee_id = $request->employee_id;
        $month = date('m');
        
        $received = PaymentCollect::where('employee_id',$employee_id)->where('month',$month )->sum('cash_received');
        $count_id = PaymentCollect::where('employee_id',$employee_id)->count('id');
      
        if(!empty($received)){
                return response()->json(["status" => true,"message" => "Get Count Successfully","Total Received " =>$received,"Total Count Id " =>$count_id ], 200);
                
            }else{
                return response()->json(["status" => false,"message" => "Something Wrong"]);
           }
    }
    
    public function site_name(Request $request){
       
        $site_data = Allapi::where('status','1')->get();
        
        foreach ($site_data as $st_data){ 
        // Code Here
        $detail[] = [
                'id'           => $st_data->id,
                'site_id'           => $st_data->name,
                'site_id_name' => $st_data->site_id_name
            ];
        }
        
        if(!empty($detail)){
            return response()->json(["status" => true,"message" => "Get Data Successfully","site_data" =>$detail], 200);
            
        }else{
            return response()->json(["status" => false,"message" => "Data not found"]);
       }
    }
    
     public function site_data(Request $request){
         
       
        $site_id     = $request->site_id;
        $month       = $request->month;
        $year        = $request->year;
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
        
        if(!empty($amount_count)){
                return response()->json(["status" => true,"message" => "Get Successfully" , "total_site_amount" =>$amount_count, ], 200);
                
            }else{
                return response()->json(["status" => false,"message" => "Data not found"]);
        }
    }
    
    public function dashboard_data(Request $request){
        $employee_id = $request->employee_id;
        $month = date('m');
        $year = date('Y');
        
        $total_day_in_month = date('d');
        $holiday  = Holiday::where('month',$month)->where('year',$year)->where('created_at','<=',date("Y-m-d"))->count('id');
        $total_day = $total_day_in_month - $holiday;
       
        $present  = Attendance::where('employee_id',$employee_id)->where('month',$month)->where('year',$year)->count('id');
        $absent = $total_day - $present;
        if($absent < 0){
                $absent =0;
            }
        
        // $total_amount = PaymentCollect::where('employee_id',$employee_id)->where('month',$month )->where('year',$year)->sum('total_amount'); 
        // $cash_received = PaymentCollect::where('employee_id',$employee_id)->where('month',$month )->where('year',$year)->sum('cash_received');
        // $cash_due = PaymentCollect::where('employee_id',$employee_id)->where('month',$month )->where('year',$year)->sum('cash_due');
            $total_amount = PaymentCollect::where('employee_id',$employee_id)->sum('total_amount'); 
            $cash_received = PaymentCollect::where('employee_id',$employee_id)->sum('cash_received');
            $cash_due = PaymentCollect::where('employee_id',$employee_id)->sum('cash_due');
        
        // $notification = ActivityNotification::where('user_id',$employee_id)->count('id');
        $notification = Notification::where('type' , '2')->where('user_id',$request->employee_id)
     ->orWhere('type', '1')->count('id');
        $total_sales_voucher_report = SaleReportCreateVoucher::where('user_id',$employee_id)->where('status','success')->sum('price');
        $detail = [
                ['value'   => $present,
                'heading'   => 'Present'],
                ['value'   => $absent,
                'heading'   => 'Absent'],
                ['value'   => $total_amount,
                'heading'   => 'Total Amount'],
                ['value'   => $cash_received,
                'heading'   => 'Cash Received'],
                ['value'   => $cash_due,
                'heading'   => 'Cash Due'],
                ['value'   => $notification,
                'heading'   => 'Notification'],
                 ['value'   => $total_sales_voucher_report,
                'heading'   => 'Total recharge cash'],
               
            ];
            
        if(!empty($detail)){
                return response()->json(["status" => true,"message" => "data fetch sucessfully" ,"data" => $detail], 200);
                
            }else{
                return response()->json(["status" => false,"message" => "Data not found"]);
        }
    }
    
   public function store_attendence(Request $request)
    {
      
        $office_time = '10:00:00';
        $request->validate([

            'working_from' => 'required',

        ]);
         $employee_id = $request->employee_id;
        if (Attendance::where(['employee_id' => $employee_id,'date' => date('Y-m-d')])->exists()) {
            return response()->json(["status" => false,"message" => "Today you had already use clock-in to clock-out."]);
        }else{
          $data = array();
            $data['employee_id']= $employee_id;
            $data['working_from']= $request->working_from;
            $data['mark_attendance_by']= '1';
            $data['date']= date('Y-m-d');
            $data['day']= date('d');
            $data['month']= date('m');
            $data['year']= date('Y');
            $data['live_location']= $request->live_location;
            $data['clock_in']= $request->clock_in_time;
            if($office_time < $request->clock_in_time){
              $data['late']= 'Yes';
            }else{
              $data['late']= 'No'; 
            }
            $att = Attendance::create($data);
            if(!empty($att)){
                return response()->json(["status" => true,"message" => "Check in time saved successfully" ], 200);
                
            }else{
                return response()->json(["status" => false,"message" => "Something Wrong"]);
           }
        }

    }
    
    public function checkout_attendance(Request $request)
    {
          $id = $request->id;
          $employee_id = $request->employee_id;
          $get_d =  Attendance::where('id',$id)->first(); 
          
          $time1 = new DateTime($get_d->clock_in);
          $time2 = new DateTime($request->clock_out_time);
          $time_diff = $time1->diff($time2);
          $hourss = $time_diff->h;
          $data = array();
          $data['clock_out']= $request->clock_out_time;
          $data['total_hours']= $hourss;
          if(!empty($request->live_location)){
            $data['clock_out_location']= $request->live_location;
          }
          $data['status']= '0';
          
          $att= Attendance::where('employee_id',$employee_id)->where('id',$id)->update($data);
          
          if(!empty($att)){
                return response()->json(["status" => true,"message" => "Check out time saved successfully" ], 200);
                
            }else{
                return response()->json(["status" => false,"message" => "Something Wrong"]);
           }
    }
    
   public function notification(Request $request)
    {
       
       $emp = Notification::where('type' , '2')->where('user_id',$request->employee_id)
     ->orWhere('type', '1')->orderBy('id','desc')->get();
    //   echo $emp;
       if(!empty($emp))
       {
       return response()->json(["status" => true,"message" => "Records found.","data" =>$emp
            ], 200);
       }else{
        return response()->json(["status" => false,"message" => "Rrecords not found."], 401);
       }
  
    }
    
    
   // for recharge voucher api 
    public function getAssignSites(Request $request)
    {
       
       $emp = AccessSites::getAssignSites($request->user_id);
    //   echo $emp;
    
     foreach ($emp as $st_data){ 
        // Code Here
        $detail[] = [
                'user_id'           => $st_data->user_id,
                'site_id'           => $st_data->name,
                'site_id_name' => $st_data->site_id_name
            ];
        }
       if(!empty($detail))
       {
       return response()->json(["status" => true,"message" => "Records found.","data" =>$detail
            ], 200);
       }else{
        return response()->json(["status" => false,"message" => "Rrecords not found."], 401);
       }
  
    }
    
     public function get_gateway_profile(Request $request){
        $site_id = $request->site_id;
        
        $token = substr(md5(date('YMD', strtotime('today')).'chanam'), 0, 12);
          $url = 'https://protik.ae/jwp_api_dev/home/get_profiles/'.$site_id.'/'.$token;
         $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
   
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        //   echo $result1;die;
          foreach ($responseBody as $row){ 
            //   echo   $row['profile_name'];die;
        // Code Here
        $detail[] = [
                'profile_name'           => $row['profile_name'],
                'profile_validity'           => $row['profile_validity'],
                'profile_price' => $row['profile_price']
            ];
        }
      if(!empty($detail))
      {
      return response()->json(["status" => true,"message" => "Records found.","data" =>$detail
            ], 200);
      }else{
        return response()->json(["status" => false,"message" => "Rrecords not found."], 401);
      }
          
        
    }
    
     public function get_registere_mobile_number(Request $request)
    {
       
    //   $detail = RegisteredUser::where('mobile',$request->mobile)->get();
    //   $detail = RegisteredUser::get();
      $detail = DB::table('registered_user_tbl')
->select('registered_user_tbl.*','all_api_tbl.site_id_name')
->where('registered_user_tbl.site_id',$request->site_id)
->join('all_api_tbl','all_api_tbl.name','=','registered_user_tbl.site_id')
->get();
    //   echo $detail;

      if(!empty($detail))
      {
      return response()->json(["status" => true,"message" => "Records found.","data" =>$detail
            ], 200);
      }else{
        return response()->json(["status" => false,"message" => "Rrecords not found."], 401);
      }
  
    }
    
    public function store_recharge_voucher(Request $request)
    {
        
        // dd($request->all());
        $site_id = $request->site_id;
        $user_mob = $request->user_mob;
        $uname = RegisteredUser::where('mobile',$user_mob)->orderBy('id','desc')->first();
        // $user_name = $request->user_name;
        $user_name = $uname->name;
        $get_profile_days = $request->profile_name;
        $price = $request->profile_price;
       
        
        $token = substr(md5(date('YMD', strtotime('today')).'chanam'), 0, 12);
          $url = 'https://protik.ae/jwp_api_dev/home/live_sale/'.$site_id.'/'.$token.'/'.$user_name.'/'.$user_mob.'/'.$get_profile_days;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
   
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        // dd($responseBody['type']);
        
        $user_id = $request->user_id;
        $datas = array();
        
        $datas['user_id'] = $user_id;
        $datas['site_id'] = $site_id;
        $datas['username'] = $user_name;
        $datas['mobile'] = $user_mob;
        $datas['voucher_code'] = $responseBody['code'];
        $datas['status'] = $responseBody['type'];
        $datas['profile'] = $responseBody['profile'];
        $datas['price'] = $price;
        $datas['sale_date'] = date('Y-m-d');
        $datas['month'] = date('m');
        $datas['year'] = date('Y');
        $datas['created_at'] = date('Y-m-d H:i:s');
        
        $instd = SaleReportCreateVoucher::create($datas);
        $message = "Dear ".$user_name.", Your Wi-fi voucher number is ".$responseBody['code']." to register camp Wi-Fi.Complaints or Feedback at (10am to 10pm). Thanks Clindcast Time Logs Team";
        $url = "https://elitbuzz-me.com/sms/smsapi?api_key=C200332460c9157cc64e06.85843724&type=text&contacts=" .
             $user_mob . "&" .
             "senderid=JWP-WiFi". "&" .
             "msg="  . urlencode($message);
             
        $output = file($url);
        if(!empty($instd))
          {
          return response()->json(["status" => true,"message" => "Recharge voucher Been Created successfully."], 200);
          }else{
            return response()->json(["status" => false,"message" => "Rrecords not found."], 401);
          }
            
   }
   
   
   public function all_recharge_voucher_list(Request $request)
    {
       
    //   $detail = RegisteredUser::where('mobile',$request->mobile)->get();
      $detail = DB::table('sale_report_create_voucher_tbl')->where('user_id',$request->user_id)->leftjoin('all_api_tbl','sale_report_create_voucher_tbl.site_id','=','all_api_tbl.name')->select('sale_report_create_voucher_tbl.id as id','sale_report_create_voucher_tbl.site_id as site_id','all_api_tbl.site_id_name as site_id_name','sale_report_create_voucher_tbl.created_at as createdate', 'sale_report_create_voucher_tbl.username as username','sale_report_create_voucher_tbl.mobile','sale_report_create_voucher_tbl.voucher_code as voucher_code','sale_report_create_voucher_tbl.status as status'
      ,'sale_report_create_voucher_tbl.profile as profile'
      ,'sale_report_create_voucher_tbl.price as price')->orderBy('id', 'DESC')->get();
    //   echo $detail;

      if(!empty($detail))
      {
      return response()->json(["status" => true,"message" => "Records found.","data" =>$detail
            ], 200);
      }else{
        return response()->json(["status" => false,"message" => "Rrecords not found."], 401);
      }
  
    }
    
    public function received_voucher_filter(Request $request){
        
        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $name = $request->profile_name;
        $user_id = $request->user_id;
        // dd($name);
          if(!empty($name) && !empty($from_date) && !empty($to_date) && !empty($user_id))
          {
         $detail = DB::table('sale_report_create_voucher_tbl')->whereIn('profile',$name)->where('user_id',$user_id)->leftjoin('all_api_tbl','sale_report_create_voucher_tbl.site_id','=','all_api_tbl.name')->select('sale_report_create_voucher_tbl.id as id','all_api_tbl.site_id_name as site_id_name','sale_report_create_voucher_tbl.created_at as createdate', 'sale_report_create_voucher_tbl.username as username','sale_report_create_voucher_tbl.mobile','sale_report_create_voucher_tbl.voucher_code as voucher_code','sale_report_create_voucher_tbl.status as status'
      ,'sale_report_create_voucher_tbl.profile as profile'
      ,'sale_report_create_voucher_tbl.price as price')->whereBetween('sale_report_create_voucher_tbl.created_at', [$from_date, $to_date])->orderBy('id', 'DESC')->get();
          }else{
             return response()->json(["status" => false,"message" => "Rrecords not found.", "err"=>$name, "errfrom"=>$from_date, "errto"=>$to_date, "user_id"=>$user_id ], 401); 
          }

            
         return response()->json(["status" => true,"message" => "Records found.","data" =>$detail
            ], 200);
    }
    
// create and insert value on database  
  
//  public function createStudent(Request $request) {
//     $student = new Student;
//     $student->name = $request->name;
//     $student->course = $request->course;
//     $student->save();

//     return response()->json([
//         "message" => "student record created"
//     ], 201);
//   }  

// get all value From database  

// public function getAllStudents() {
//     $students = Student::get()->toJson(JSON_PRETTY_PRINT);
//     return response($students, 200);
//   }
  
// get value by id from database  

//     public function getStudent($id) {
//     if (Student::where('id', $id)->exists()) {
//         $student = Student::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
//         return response($student, 200);
//       } else {
//         return response()->json([
//           "message" => "Student not found"
//         ], 404);
//       }
//   }

// update value by id from database  

// public function updateStudent(Request $request, $id) {
//     if (Student::where('id', $id)->exists()) {
//         $student = Student::find($id);
//         $student->name = is_null($request->name) ? $student->name : $request->name;
//         $student->course = is_null($request->course) ? $student->course : $request->course;
//         $student->save();

//         return response()->json([
//             "message" => "records updated successfully"
//         ], 200);
//         } else {
//         return response()->json([
//             "message" => "Student not found"
//         ], 404);
        
//     }
// } 

// delete value by id from database 

//   public function deleteStudent ($id) {
//       if(Student::where('id', $id)->exists()) {
//         $student = Student::find($id);
//         $student->delete();

//         return response()->json([
//           "message" => "records deleted"
//         ], 202);
//       } else {
//         return response()->json([
//           "message" => "Student not found"
//         ], 404);
//       }
//     }


    public function store_lead(Request $request){
        
        
        $b = explode("
", $request);
        
        $source = str_replace('Host:            ','',$b[6]);

        $request1 =json_decode($b[9]); 
        
        $first_name = $request1->first_name;
        $last_name = $request1->last_name;
        $phone = $request1->phone;
        $email = $request1->email;
        $message = $request1->message;
        $company_name = $request1->company_name;
        $job_title = $request1->job_title;
        $topic = $request1->topic;

        $data = array();

        $data['first_name'] = $first_name;
        $data['last_name'] = $last_name;
        $data['phone'] = $phone;
        $data['email'] = $email;
        $data['message'] = $message;
        $data['company_name'] = $company_name;
        $data['job_title'] = $job_title;
        $data['topic'] = $topic;
        $data['source'] = $source;

        Contact::create($data);
        return response()->json([
          "message" => "records added"
        ], 200);
    }

    public function store_event(Request $request){
        $b = explode("
", $request);
        
        $source = str_replace('Host:            ','',$b[6]);

        $request1 =json_decode($b[9]); 
        
        $first_name = $request1->first_name;
        $last_name = $request1->last_name;
        $phone = $request1->phone;
        $email = $request1->email;
        $company_name = $request1->company_name;

        $data = array();

        $data['first_name'] = $first_name;
        $data['last_name'] = $last_name;
        $data['phone'] = $phone;
        $data['email'] = $email;
        $data['company_name'] = $company_name;
        $data['source'] = $source;

        Event::create($data);
        return response()->json([
          "message" => "records added"
        ], 200);
    }
}