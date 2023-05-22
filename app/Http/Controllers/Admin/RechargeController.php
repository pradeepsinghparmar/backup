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
use App\Models\AccessSites;
use App\Models\RegisteredUser;
use Illuminate\Support\Facades\DB;
use Auth;
use Hash;
class RechargeController extends Controller
{
    public function index(){
        $user_id = Auth::user()->id;
        $role = Auth::user()->role;
        if($role == '11' || $role == '10' || $role == '8' || $role == '12')
        {
            $recharge_list = SaleReportCreateVoucher::where('user_id',$user_id)->orderBy('id','DESC')->get();
            
        }else{
            $recharge_list = SaleReportCreateVoucher::orderBy('id','DESC')->get();
        }
        
        $site_list = Allapi::where('type','1')->orderBy('id','DESC')->get();
        
        $users = User::get();
        return view('admin.recharge.index', compact('site_list','recharge_list','users'));
    }
    
    
    public function create_recharge(Request $request){
        $user_id = Auth::user()->id;
        // dd($user_id);
        $role = Auth::user()->role;
        if($role == '11' || $role == '10' || $role == '8' || $role == '12')
        {
           $site_list = AccessSites::getAssignSites($user_id);
        //   dd($site_list);
        }else{
         $site_list = Allapi::where('type','1')->orderBy('id','DESC')->get();
        }
        //  dd($site_list);
        
        // $r_user_list = RegisteredUser::get();
//         $r_user_list = DB::table('registered_user_tbl')
// ->select('registered_user_tbl.*','all_api_tbl.site_id_name')
// ->where('registered_user_tbl.site_id',$request->site_id)
// ->join('all_api_tbl','all_api_tbl.name','=','registered_user_tbl.site_id')
// ->get();
        return view('admin.recharge.create', compact('site_list'));
    }
     public function get_mobile_number_sitewise(Request $request){
   
//     $r_user_list = DB::table('registered_user_tbl')
// ->select('registered_user_tbl.*','all_api_tbl.site_id_name')
// ->where('registered_user_tbl.site_id',$request->site_id)
// ->join('all_api_tbl','all_api_tbl.name','=','registered_user_tbl.site_id')
// ->get
// dd($request->site_id);
$r_user_list = RegisteredUser::where('site_id',$request->site_id)->get();
// dd($r_user_list);
        //  $result = json_encode($r_user_list);
        //   $result = json_decode($response,true);
                        //   prx($result);
        //   echo $r_user_list;exit();
          echo  json_encode($r_user_list);
     }
    public function view_recharge_voucher(Request $request,$id){
         $site_list = Allapi::where('type','1')->orderBy('id','DESC')->get();
         $recharge_list = SaleReportCreateVoucher::where('id',$id)->first();
          $users = User::get();
        return view('admin.recharge.view', compact('site_list','recharge_list','users'));
    }
    
    
    public function get_user_detail(Request $request){
        
        if($request->get('user_mobField'))
     {
        $site_id = $request->get('site_id');
        $term = $request->get('user_mobField');
        $token = substr(md5(date('YMD', strtotime('today')).'chanam'), 0, 12);
          $url = 'https://protik.ae/jwp_api_dev/home/search_user/'.$token.'/'.$site_id.'/?term='.$term;
        //   $url = 'https://protik.ae/jwp_api_dev/home/search_user/d9ce1e796930/432/?term='.$term;
        //   $ch = curl_init();
        //   curl_setopt($ch, CURLOPT_URL, $url);
        //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //   $response = curl_exec($ch);
        //   curl_close($ch);
        //   $result = json_decode($response,true);
                        //   prx($result);
                        
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
   
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
           $output = '<ul class="dropdown-menu" style="display:block; position:relative;width: 564px;height: 200px;
    overflow: scroll;">';
          foreach($responseBody as $row)
          {
           $output .= '
           <li><a href="#"><i class="fas fa-fw fa-circle"></i>'.$row['name'].' | '.$row['mobile'].'</a></li>
           ';
          }
          $output .= '</ul>';
          echo $output;
     }
    }
    
    public function get_gateway_profile(Request $request){
        $site_id = $request->site_id;
        
        $token = substr(md5(date('YMD', strtotime('today')).'chanam'), 0, 12);
          $url = 'https://protik.ae/jwp_api_dev/home/get_profiles/'.$site_id.'/'.$token;
        //   $client = new \GuzzleHttp\Client();
        // $response = $client->request('GET', $url);
   
        // $statusCode = $response->getStatusCode();
        // $responseBody = json_encode($response->getBody());
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          $response = curl_exec($ch);
          curl_close($ch);
          $result = json_encode($response);
        //   $result = json_decode($response,true);
                        //   prx($result);
           echo $result;exit();
    }
    
    public function store_recharge_voucher(Request $request){
        
        // dd($request->all());
        $site_id = $request->site_id;
        $user_mob = $request->user_mob;
        
        if (RegisteredUser::where('site_id',$request->site_id)->where('mobile',$user_mob)->exists()) {   
             
        $uname = RegisteredUser::where('site_id',$request->site_id)->where('mobile',$user_mob)->first();
        // $user_name = $request->user_name;
        $user_name = $uname->name;
        $gateway_profile = $request->gateway_profile;
        $strArray = explode('|',$gateway_profile);
       
        $get_profile_days = $strArray[0];
        $price = $strArray[1];
        //  dd($price);
        
        $token = substr(md5(date('YMD', strtotime('today')).'chanam'), 0, 12);
          $url = 'https://protik.ae/jwp_api_dev/home/live_sale/'.$site_id.'/'.$token.'/'.$user_name.'/'.$user_mob.'/'.$get_profile_days;
          $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
   
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        // dd($responseBody['type']);
        
        $user_id = Auth::user()->id;
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
        $instd = SaleReportCreateVoucher::create($datas);
        $message = "Dear ".$user_name.", Your Wi-fi voucher number is ".$responseBody['code']." to register camp Wi-Fi.Complaints or Feedback at (10am to 10pm). Thanks Clindcast Time Logs Team";
        $url = "https://elitbuzz-me.com/sms/smsapi?api_key=C200332460c9157cc64e06.85843724&type=text&contacts=" .
             $user_mob . "&" .
             "senderid=JWP-WiFi". "&" .
             "msg="  . urlencode($message);
             
        $output = file($url);
        return redirect()->route('all_recharge_list.index')->with('success','Recharge voucher Been Created successfully.');
        }else{
             return redirect()->route('create_recharge')->with('error','Something wrong select, Please check Site Name and Mobile Number.'); 
          
        }
    }
    
    
}