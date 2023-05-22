<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Allapi;
use App\Models\Newapidata;
use App\Models\SitePaymentTotal;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApiCron extends Command
{
    protected $signature = 'api:cron';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
      
        $from_date_new = date("Y-m-d", strtotime("first day of this month"));
        // $to_date_new = date("Y-m-d", strtotime("last day of this month"));

        // $from_date_new = date("Y-m-d");
        ///$from_date_new = date("2022-08-08");
        $to_date_new = date("Y-m-d");
        
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
                //   if(!empty($responseBody)){
                    
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
                     
                //   }
        } //foreach
   
  
  
  
       
    } //function ka
    
    
}
