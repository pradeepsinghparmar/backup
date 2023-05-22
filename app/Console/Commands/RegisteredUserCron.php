<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Allapi;
use App\Models\RegisteredUser;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisteredUserCron extends Command
{
    protected $signature = 'registereduser:cron';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
      
       
         $data_new_r = array();
           $api_list_new_r = Allapi::where('status','1')->where('type','1')->orderBy('id','DESC')->get();
        //   dd($api_list_new);
        // foreach($api_list_new_r as $info_new_r){
            
            // $api_r = "https://protik.ae/jwp_api_dev/home/registrations";
            $api_r = "https://protik.ae/jwp_api_dev/home/registrations_all";
            $token  = substr(md5(date('YMD', strtotime('today')).'chanam'), 0, 12);
            // $site_name_new = substr($info_new_r->name);
        //   $name_token = $site_name_new.'/'.$token;
        //   $name_token = "396".'/'.$token;
         
          $url_new = $api_r.'/'.$token;
        //   dd($url_new);
         $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url_new);
   
        $statusCode = $response->getStatusCode();
        $responseBody1 = json_decode($response->getBody(), true);
        //   dd($responseBody1);
                //   if(!empty($responseBody1)){
                    
foreach($responseBody1 as $list_n){
            //  dd($list_n['mobile']);
  $user = RegisteredUser::where('site_id', $list_n['site_id'])->where('mobile', $list_n['mobile'])->exists();

  if(!$user){              
   
      $data_new_r['site_id']= $list_n['site_id'];
      $data_new_r['mac_address']= $list_n['mac_address'];
      $data_new_r['name']= $list_n['name'];
      $data_new_r['mobile']= $list_n['mobile'];
      
    //   dd($data_new_r);
      RegisteredUser::create($data_new_r);
    } 
}                  
                      

                     
                //   }
        // } //foreach
   
  
  
  
       
    } //function ka
    
    
}
