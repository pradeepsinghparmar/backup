<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Allapi;
use App\Models\Sale;
use App\Models\MonthlySale;
use App\Models\Newapidata;
use App\Models\SitePaymentTotal;
use App\Models\Attendance;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttendanceCron extends Command
{
    protected $signature = 'attendance:cron';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
      
    
        $all_today_att = Attendance::where('date',date('Y-m-d'))->get(); 
         $data_clockout = array();
                            foreach($all_today_att as $all_att)
                            {
                                if(empty($all_att->clock_out) || $all_att->clock_out == NULL || $all_att->clock_out == '')
                                {
                                    $date   = new DateTime();
                                    $current_date = $date->format('Y-m-d');
                                    $current_time = date("H:i:s");
                                    $begin = '23:45:00';
                                    $end   = '23:51:00';
                                    // $begin = '13:20:00';
                                    // $end   = '13:59:00';
                                    $date1 = $date->format($current_time);
                                    $date2 = $date->format($begin);
                                    $date3 = $date->format($end);
                    
                                     if ($date1 >= $date2 && $date1 <= $date3) 
                                     {
                                      $time1 = new DateTime($all_att->clock_in);
                                      $time2 = new DateTime('23:51:00');
                                      $time_diff = $time1->diff($time2);
                                      $hourss = $time_diff->h;
                                     
                                      $data_clockout['clock_out']= '23:51:00';
                                      $data_clockout['total_hours']= $hourss;
                                      $data_clockout['clock_out_location']= 'Automatic clock out.';
                                      $data_clockout['status']= '0';
                            
                                      Attendance::where('id',$all_att->id)->update($data_clockout);
                                        
                                    }
                                }
                           }// attendance foreach
      
       
    } //function ka
}
