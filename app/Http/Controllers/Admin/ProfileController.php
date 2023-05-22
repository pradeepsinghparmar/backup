<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Http;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Project;
use App\Models\Attendanceday;
use App\Models\ActivityNotification;
use App\Models\RegisteredUser;
use App\Models\Timesheet;
use App\Models\Leave;
use App\Models\Group;
use App\Models\Timesheetactivity;
use Hash;
use Auth;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use PDF;
use Illuminate\Support\Facades\Redirect;
class ProfileController extends Controller
{
    public function dashboards(){
        $user_id = Auth::user()->id;
        $admin_role = Auth::user()->role;
            $data=[
                'title'=>'Dashboard'
            ];

            $on_leave=0;
            $Onleave = Leave::where('user_id',$user_id)->whereDate('from' ,'<=', date('Y-m-d'))->whereDate('to', '>=', date('Y-m-d'))->count();
            if($Onleave>0){
                $on_leave=1;
            }
            
            $login =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->count();
            $is_login = 0;
            $login_time = '';
            $login_in_time ='';
            if($login>0){
                $login =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->first();

                $login_in_time =  strtotime($login->login_time);
                $login_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$login_in_time).' '.date_default_timezone_get();
                $is_login = 1;
            }


            $logout =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->count();
            $is_logout = 0;
            $logout_time = '';
            if($logout>0){
                $logout =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->first();

                $logout_in_time =  strtotime($logout->logout_time);
                $logout_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$logout_in_time).' '.date_default_timezone_get();
                $is_logout = 1;
            }

            $break =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->count();
            $is_break = 0;
            $break_in_time ='';
            $break_id = 0;

            if($break>0){
                $break =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->first();

                $is_break = 1;
                $break_id = $break->id;
                $break_time =  strtotime($break->break_in);
                $break_in_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$break_time).' '.date_default_timezone_get();

            }

            $is_breakout = 0;
            $break_out_time = '';
            if($break_id !=0){
                $break_out =  Attendanceday::where('id',$break_id)->where('break_out','!=','00:00:00')->count();
                if($break_out>0){
                    $break_out =  Attendanceday::where('id',$break_id)->where('break_out','!=','00:00:00')->first();
                    $is_breakout = 1;
                    $is_break = 1;
                    $break_time =  strtotime($break_out->break_in);
                    $break_in_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$break_time).' '.date_default_timezone_get();
                    $break_in_out_time =  strtotime($break_out->break_out);
                    $break_out_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$break_in_out_time).' '.date_default_timezone_get();
                }
            }

        $j=0;
        $table = '';
        $Groups = Group::get();
        $gd = array();
        foreach($Groups as $Group){ 
            $i=0;
             $datas = array();
            $users = User::orderBy('name','ASC')->where('is_dashboard',1)->where('group_id',$Group->id)->get();   
            foreach($users as $user){
                $uid = $user->id;
                $is_leave=0;
                //$leave = Leave::where('user_id',$uid)->where('from',date('Y-m-d'))->count();
                $leave = Leave::where('user_id',$uid)->whereDate('from' ,'<=', date('Y-m-d'))->whereDate('to', '>=', date('Y-m-d'))->where('duration','!=',0.5)->count();
                if($leave>0){
                    $is_leave=1;
                }
                $login1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->count();
                $is_login1 = 0;
                $login_time1 = '';
                if($login1>0){
                    $login1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->first();

                    $login_in_time1 =  strtotime($login1->login_time);
                    $login_time1 = date('H:i:a',$login_in_time1);
                    //$login_time1 = $login1->login_time;
                    $is_login1 = 1;
                }

                $logout1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->count();
                $is_logout1 = 0;
                $logout_time1 = '';
                if($logout1>0){
                    $logout1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->first();

                    $logout_in_time1 =  strtotime($logout1->logout_time);
                    $logout_time1 = date('H:i:a',$logout_in_time1);
                    $is_logout1 = 1;
                }

                $break1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->count();
                $is_break1 = 0;
                $break_in_time1 ='';
                $break_id1 = 0;

                if($break1>0){
                    $break1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->first();

                    $is_break1 = 1;
                    $break_id1 = $break1->id;
                    $break_time1 =  strtotime($break1->break_in);
                    $break_in_time1 = date('H:i:a',$break_time1);
                }

                $is_breakout1 = 0;
                $break_out_time1 = '';
                if($break_id1 !=0){
                        $break_out1 =  Attendanceday::where('id',$break_id1)->where('date',date('Y-m-d'))->where('break_out','!=','00:00:00')->count();
                    if($break_out1>0){
                        $break_out1 =  Attendanceday::where('id',$break_id1)->where('date',date('Y-m-d'))->where('break_out','!=','00:00:00')->first();
                        $is_breakout1 = 1;
                        $break_in_out_time1 =  strtotime($break_out1->break_out);
                        $break_out_time1 = date('H:i:a',$break_in_out_time1);
                    }
                }
                $datas[$i]['user_id'] = $user->name.' '.$user->last_name;
                $datas[$i]['is_leave'] = $is_leave;
                $datas[$i]['is_login1'] = $is_login1;
                $datas[$i]['login_time1'] = $login_time1;
                $datas[$i]['is_break1'] = $is_break1;
                $datas[$i]['break_in_time1'] = $break_in_time1;
                $datas[$i]['is_breakout1'] = $is_breakout1;
                $datas[$i]['break_out_time1'] = $break_out_time1;
                $datas[$i]['is_logout1'] = $is_logout1;
                $datas[$i]['logout_time1'] = $logout_time1;
                $i++;
            }
            $gd[$j]['list'] = $datas;
            $gd[$j]['id'] = $Group->id;
            $gd[$j]['name'] = $Group->name;
            $j++;
        }

        return view('admin.dashboard',$data,compact('is_login','login_time','is_break','break_in_time','is_breakout','break_out_time','is_logout','logout_time','datas','on_leave','login_in_time','gd'));
    }

    public function myteam(){
        $user_id = Auth::user()->id;
        //$users = User::orderBy('name','ASC')->where('id','!=',1)->get();
        $datas = array();
        /*$j=0;
        $table = '';
        $Groups = Group::get();
        $gd = array();
        foreach($Groups as $Group){ 
            $i=0;
            $users = User::orderBy('name','ASC')->where('id','!=',1)->where('group_id',$Group->id)->get();   
            foreach($users as $user){
                $uid = $user->id;
                $is_leave=0;
                //$leave = Leave::where('user_id',$uid)->where('from',date('Y-m-d'))->count();
                $leave = Leave::where('user_id',$uid)->whereDate('from' ,'<=', date('Y-m-d'))->whereDate('to', '>=', date('Y-m-d'))->where('duration','!=',0.5)->count();
                if($leave>0){
                    $is_leave=1;
                }
                $login1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->count();
                $is_login1 = 0;
                $login_time1 = '';
                if($login1>0){
                    $login1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->first();

                    $login_in_time1 =  strtotime($login1->login_time);
                    $login_time1 = date('H:i:a',$login_in_time1);
                    //$login_time1 = $login1->login_time;
                    $is_login1 = 1;
                }

                $logout1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->count();
                $is_logout1 = 0;
                $logout_time1 = '';
                if($logout1>0){
                    $logout1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->first();

                    $logout_in_time1 =  strtotime($logout1->logout_time);
                    $logout_time1 = date('H:i:a',$logout_in_time1);
                    $is_logout1 = 1;
                }

                $break1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->count();
                $is_break1 = 0;
                $break_in_time1 ='';
                $break_id1 = 0;

                if($break1>0){
                    $break1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->first();

                    $is_break1 = 1;
                    $break_id1 = $break1->id;
                    $break_time1 =  strtotime($break1->break_in);
                    $break_in_time1 = date('H:i:a',$break_time1);
                }

                $is_breakout1 = 0;
                $break_out_time1 = '';
                if($break_id1 !=0){
                        $break_out1 =  Attendanceday::where('id',$break_id1)->where('date',date('Y-m-d'))->where('break_out','!=','00:00:00')->count();
                    if($break_out1>0){
                        $break_out1 =  Attendanceday::where('id',$break_id1)->where('date',date('Y-m-d'))->where('break_out','!=','00:00:00')->first();
                        $is_breakout1 = 1;
                        $break_in_out_time1 =  strtotime($break_out1->break_out);
                        $break_out_time1 = date('H:i:a',$break_in_out_time1);
                    }
                }
                $datas[$i]['user_id'] = $user->name.' '.$user->last_name;
                $datas[$i]['is_leave'] = $is_leave;
                $datas[$i]['is_login1'] = $is_login1;
                $datas[$i]['login_time1'] = $login_time1;
                $datas[$i]['is_break1'] = $is_break1;
                $datas[$i]['break_in_time1'] = $break_in_time1;
                $datas[$i]['is_breakout1'] = $is_breakout1;
                $datas[$i]['break_out_time1'] = $break_out_time1;
                $datas[$i]['is_logout1'] = $is_logout1;
                $datas[$i]['logout_time1'] = $logout_time1;
                $i++;
            }
            $gd[$j]['list'] = $datas;
            $gd[$j]['id'] = $Group->id;
            $gd[$j]['name'] = $Group->name;
            $j++;
        }*/

        $j=0;
        $table = '';
        $Groups = Group::get();
        $gd = array();
        foreach($Groups as $Group){
            if($Group->id==Auth::user()->group_id || Permission::admin_permission('admin_dashboard')){
                $i=0;
                 $datas = array();
                $users = User::orderBy('name','ASC')->where('is_dashboard',1)->where('group_id',$Group->id)->get();
                foreach($users as $user){

                    $uid = $user->id;
                    $is_leave=0;
                    $leave = Leave::where('user_id',$uid)->whereDate('from' ,'<=', date('Y-m-d'))->whereDate('to', '>=', date('Y-m-d'))->where('duration','!=',0.5)->count();
                    if($leave>0){
                        $is_leave=1;
                    }

                    $login1 = Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->count();
                    $is_login1 = 0;
                    $login_time1 = '';
                    $hourss=0;
                    $time1=0;
                    if($login1>0){
                        $login1 = Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->first();

                        $login_in_time1 =  strtotime($login1->login_time);
                        $login_time1 = date('H:i:a',$login_in_time1);
                        //$login_time1 = $login1->login_time;
                        $is_login1 = 1;

                        $time1 = new DateTime($login1->login_time);
                        $time2 = new DateTime(date('H:i:s'));
                        $time_diff = $time1->diff($time2);
                        $seconds = $time_diff->days * 24 * 60 * 60;
                        $seconds += $time_diff->h * 60 * 60;
                        $seconds += $time_diff->i * 60;
                        $seconds += $time_diff->s;
                        $hourss =$seconds;
                    }

                    $logout1 = Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->count();
                    $is_logout1 = 0;
                    $logout_time1 = '';
                    $hh='';
                    if($logout1>0){
                        $logout1 = Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->first();

                        $logout_in_time1 = strtotime($logout1->logout_time);
                        $logout_time1 = date('H:i:a',$logout_in_time1);
                        $is_logout1 = 1;
                        $hh = $logout1->total_hours;
                    }

                    $break1 = Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->count();
                    $is_break1 = 0;
                    $break_in_time1 ='';
                    $break_id1 = 0;

                    if($break1>0){
                        $break1 = Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->first();

                        $is_break1 = 1;
                        $break_id1 = $break1->id;
                        $break_time1 =  strtotime($break1->break_in);
                        $break_in_time1 = date('H:i:a',$break_time1);
                    }

                    $is_breakout1 = 0;
                    $break_out_time1 = '';
                    $total_break_time=0;
                    $t_break = '';
                    if($break_id1 !=0){
                            $break_out1 = Attendanceday::where('id',$break_id1)->where('date',date('Y-m-d'))->where('break_out','!=','00:00:00')->count();
                        if($break_out1>0){
                            $break_out1 = Attendanceday::where('id',$break_id1)->where('date',date('Y-m-d'))->where('break_out','!=','00:00:00')->first();

                            $total_break_time = Attendanceday::select( DB::raw('sum(total_hours) as total_hours'))->where('login_time','00:00:00')->where('employee_id',$uid)->whereDate('date', '=', date('Y-m-d'))->first()->total_hours;

                            $t_break =$this->secondsToWords($total_break_time);
                            //$total_break_time= gmdate("H:i:s",$dd);
                            $is_breakout1 = 1;
                            $break_in_out_time1 = strtotime($break_out1->break_out);
                            $break_out_time1 = date('H:i:a',$break_in_out_time1);
                        }
                    }
                    $total_working='';
                    if($is_login1){
                        $total_work = $hourss-$total_break_time;
                        $total_working = $this->secondsToWords($total_work);
                    }
                    if($is_logout1){
                        $total_working = $this->secondsToWords($hh);
                    }

                    $datas[$i]['user_id'] = $user->name.' '.$user->last_name;
                    $datas[$i]['is_leave'] = $is_leave;
                    $datas[$i]['is_login1'] = $is_login1;
                    $datas[$i]['login_time1'] = $login_time1;
                    $datas[$i]['is_break1'] = $is_break1;
                    $datas[$i]['break_in_time1'] = $break_in_time1;
                    $datas[$i]['is_breakout1'] = $is_breakout1;
                    $datas[$i]['break_out_time1'] = $break_out_time1;
                    $datas[$i]['is_logout1'] = $is_logout1;
                    $datas[$i]['total_hours'] = $total_working;
                    $datas[$i]['logout_time1'] = $logout_time1;
                    $datas[$i]['t_break'] = $t_break;
                    $i++;
                }

                $gd[$j]['list'] = $datas;
                $gd[$j]['id'] = $Group->id;
                $gd[$j]['name'] = $Group->name;
                $j++;
            }
        }

        $tt['gd'] = $gd ;
        //$tt['datas'] = $datas ;

        /*$table = '';
        foreach($gd as $g){
            //if($g["id"]==Auth::user()->group_id){
                $h = 0;
                $table .='<div class="row">
                <div class="col-md-11">
                    <div class="container-fluid"><br>
                        <div class="_icon-box">
                            <div class="card-header" style="background: #0c6ead;">
                                <h6 class="m-0 font-weight-bold" style=" color: white;">ClinDCast Team Time Management ('.$g["name"].')</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>User</th>
                                            <th>Login time</th>
                                            <th>Break Start</th>
                                            <th>Break End</th>
                                            <th>Logout Time</th>
                                            <th>Total Working Time</th>
                                            <th>Status</th>
                                            <th>Total Break Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="myteam">';
                foreach($datas as $key => $data){
                     $h++;
                    $table .= '<tr>
                        <td>'. $h .'</td>
                        <td>'. $data['user_id'] .'</td>
                        <td>'. $data['login_time1'] .'</td>
                        <td>'. $data['break_in_time1'] .'</td>
                        <td>'.  $data['break_out_time1'] .'</td>
                        <td>'.  $data['logout_time1'] .'</td>
                        <td>'.  $data['total_hours'] .'</td>
                        <td>';
                        if($data['is_leave']){
                            $table .= '<span class="badge bg-light-danger text-danger rounded-pill" style="background: #ffba00 !important;">On Leave</span>';
                        }elseif($data['is_logout1']){
                            $table .= '<span class="badge bg-light-danger text-danger rounded-pill">Logged out</span>';
                        }elseif($data['is_breakout1']){
                            $table .= '<span class="badge bg-light-success text-success rounded-pill">Online</span>';
                        }elseif($data['is_break1']){
                            $table .= '<span class="badge bg-light-danger text-danger rounded-pill" style="background: #ffba00 !important;">On Break</span>';
                        }elseif($data['is_login1']){
                            $table .= '<span class="badge bg-light-success text-success rounded-pill">Online</span>';
                        }else{
                            $table .= '<span class="badge bg-light-danger text-danger rounded-pill">Yet To Join</span>';
                        }
                        $table .= '</td>
                        <td>'.$data['t_break'].'</td>
                    </tr>';
                }

                $table .='</tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            //}
        }*/

        return response()->json(['table' => view('admin.timemanagement.dashboard')->with('tt',$tt)->render()]);

        //return view('admin.timemanagement.index',$data,compact('is_login','login_time','is_break','break_in_time','is_breakout','break_out_time','is_logout','logout_time','datas','on_leave','login_in_time'));

        //return response()->json(['table'=>$table]);
        //echo $table;
    }
    
    public function dashboard_demo(){
        $user_id = Auth::user()->id;
        // $api_active_count = Allapi::where('status','1')->get()->count();
        // $api_deactive_count = Allapi::where('status','0')->get()->count();
        $total_staff = User::where('role_status','1')->get()->count();
        // $today_sale = Sale::where('status','1')->get()->sum('sale');
        // $monthly_sale = MonthlySale::where('status','1')->whereMonth('date', date('m'))->whereYear('date', date('Y'))->get()->sum('sale');
        // $api_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        $todayattendance = Attendance::where('date',date('Y-m-d'))->first();
        return view('admin.dashboard1',compact('total_staff','todayattendance'));
    }

    public function profile(){
        $user_id = Auth::user()->id;
        $profile = User::where('id',$user_id)->first();
        return view('admin.profile',compact('profile'));
    }

    public function update_profile(Request $request, $id){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
        $data1 = array();
        if($request->hasFile('banner')) {
            $img_ext = $request->file('banner')->getClientOriginalExtension();
            $filename = 'profile_photo-' . time() . '.' . $img_ext;
            $path = $request->file('banner')->move(public_path('admin/backend/user_profile'), $filename);//image save public folder
            $data1['image']= $filename;
            $data1['image_url'] = url('admin/backend/user_profile/'.$filename);
        }
        $data1['name']= $request->name;
        $data1['email'] = $request->email;
        $data1['phone'] = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $data1['password']= Hash::make($request->new_password);
        }

        $query_insert = User::where('id',$id)->update($data1);
        return redirect()->route('profile')->with('success','Profile Has Been updated successfully');
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('getLogin')->with('success','You have been successfully logged out');
    }

    /*public function recharge_list(){
        //   $url = "http://jwp208.dyndns.info:88/api/sale";
        //   $ch = curl_init();
        //   curl_setopt($ch, CURLOPT_URL, $url);
        //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //   $result = curl_exec($ch);
        //   $getlist = $result;
        //   $show_list = json_decode($getlist,true);
        //   dd($getlist);
        $api_list = Allapi::where('status','1')->where('type','2')->orderBy('id','DESC')->get();
        // dd($api_list);
        return view('admin.recharge_report.index',compact('api_list'));
    }
    
    
    public function store_today_sale()
    {
        $data = array();
        $data1 = array();
        $api_list = Allapi::where('status','1')->where('type','2')->orderBy('id','DESC')->get();
        foreach($api_list as $info){
            $url = $info->api_url;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            $getlist = $result;
            $show_list = json_decode($getlist,true);
            if(!empty($show_list)){
                foreach($show_list as $list){
                    $data['name']= $info->name;
                    $data['sale']= $list['sale'];
                    $data['date']= $list['date'];
                }
                if (Sale::where('name', $info->name)->exists()) {
                    $data1['sale']= $list['sale'];
                    $data1['date']= $list['date'];
                    Sale::where('name', $info->name)->update($data1);
                }else{
                    Sale::create($data);
                } 
            }
        }
    }

    public function store_monthly_sale()
    {
        $from_date = date("Y-m-d", strtotime("first day of this month"));
        $to_date = date("Y-m-d", strtotime("last day of this month"));

        $data = array();
        $data1 = array();
        $api_list = Allapi::where('status','1')->where('type','2')->orderBy('id','DESC')->get();
        foreach($api_list as $info){
            //$from_date = date("Y-m-d", strtotime("first day of previous month"));
            //$to_date = date("Y-m-d", strtotime("last day of previous month"));
            $from_to = '?from='.$from_date.'&to='.$to_date;
            $url = $info->api_url.$from_to;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            $getlist = $result;
            $show_list = json_decode($getlist,true);
            if(!empty($show_list)){
                foreach($show_list as $list){
                    $data['name']= $info->name;
                    $data['sale']= $list['sale'];
                    $data['date']= $list['date'];
                }
                if (MonthlySale::where(['name' => $info->name,'date' => $list['date']])->exists()) {
                    // your code...
                    // Sale::create($data);
                    $data1['sale']= $list['sale'];
                    MonthlySale::where(['name' => $info->name,'date' => $list['date']])->update($data1);
                }else{
                    MonthlySale::create($data);
                    // Sale::where('date',$list['date'])->update($data);
                } 
            }
        }
    }*/
    
    function admin_permission($codename)
    {
        $admin_id = Auth::user()->id;
        $admin = User::where('id',$admin_id)->first();
        $permission_obj = Permission::where('codename',$codename)->first();
        $permission = $permission_obj != null && isset($permission_obj->permission_id) ? $permission_obj->permission_id : 0;
        if ($admin->role == 1) {
            return true;
        } else {
            $role = $admin->role;
            $role_p = Role::select('permission')->where('role_id',$role)->first();
            $role_permissions = json_decode($role_p);
            if (in_array($permission, $role_permissions)) {
                return true;
            } else {
                return false;
            }
        }
    }
    /*
    public function recharge_history(Request $request){     
       $recharge_history = Allapi::where('status','1')->where('type','2')->orderBy('id','DESC')->get();
        return view('admin.recharge_report.recharge_history',compact('recharge_history'));
    }

    public function search_history(Request $request){

        $from_date = $request->start_date;
        $to_date = $request->end_date;
        $name = $request->site_name;
        if(!empty($name) && !empty($from_date) && !empty($to_date)){
            $api_list = Allapi::where('status','1')->where('type','2')->where('id',$name)->first();
            //  dd($api_list);
            //  foreach($api_list as $info){
            $from_to = '?from='.$from_date.'&to='.$to_date.'&group=day';
            $url = $api_list->api_url.$from_to;
            //   dd($url);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($ch);
            $getlist = $result;
            $show_list = json_decode($getlist,true);
            //  }
        }
        $recharge_history = Allapi::where('status','1')->where('type','2')->orderBy('id','DESC')->get();
        return view('admin.recharge_report.recharge_history',compact('recharge_history','show_list','name','to_date','from_date'));
    }

    //  new api
    public function new_recharge_history(Request $request){

       $new_recharge_history = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.recharge_report.new_recharge_history',compact('new_recharge_history'));
    } 

    public function view_site_details(Request $request,$id){
         
        if ($request->start_date != null && $request->end_date != null) {
            $f_day = $request->start_date;      
            $l_day = $request->end_date;  
            $id_d = Allapi::where('id',$id)->first();
            if($id_d->type == '1'){

            $token  = substr(md5(date('YMD', strtotime('today')).'chaman'), 0, 12);
            $datebetween = $token.'/'.$f_day.'/'.$l_day;
            $url_new = $id_d->api_url.'/'.$datebetween;
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url_new);

            $statusCode = $response->getStatusCode();
            $show_site_details1 = json_decode($response->getBody(), true);
            return view('admin.recharge_report.view_site_details',compact('show_site_details1','f_day','l_day'));
            }else if($id_d->type == '2'){

                $from_to = '?from='.$f_day.'&to='.$l_day.'&group=day';
                $url = $id_d->api_url.$from_to;
                //   dd($url);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result4 = curl_exec($ch);
                $getlist4 = $result4;
                $show_site_details2 = json_decode($getlist4,true);  
                return view('admin.recharge_report.view_site_details',compact('show_site_details2','f_day','l_day'));
            }
        }else{
            
            $id_d = Allapi::where('id',$id)->first();
            $f_day = date('Y-m-d', strtotime('first day of this month'));
            $l_day = date('Y-m-d');
            // dd($l_day);
            $token  = substr(md5(date('YMD', strtotime('today')).'chaman'), 0, 12);
            $datebetween = $token.'/'.$f_day.'/'.$l_day;
            $url_new = $id_d->api_url.'/'.$datebetween;
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', $url_new);

            $statusCode = $response->getStatusCode();
            $show_site_details1 = json_decode($response->getBody(), true);
            $from_to = '?from='.$f_day.'&to='.$l_day.'&group=day';
            $url2 = $id_d->api_url.$from_to;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $result2 = curl_exec($ch);
            $getlist2 = $result2;
            $show_site_details2 = json_decode($getlist2,true);
            //   dd($show_site_details2);
            return view('admin.recharge_report.view_site_details',compact('show_site_details1','show_site_details2','f_day','l_day'));
        }
    }
    // end new api

    //offline api details by amar sir
    public function offline_recharge_history(Request $request){
        //   $new_recharge_history = Allapi::where('status','1')->where('type','1')->orderBy('id','DESC')->get();
        $new_recharge_history = Allapi::where('status','1')->orderBy('id','DESC')->get();
        return view('admin.recharge_report.offline_recharge_history',compact('new_recharge_history'));
    } 
    
    public function view_offline_site_details(Request $request,$id){

        if ($request->start_date != null && $request->end_date != null) {
            $f_day = $request->start_date;      
            $l_day = $request->end_date;  
            $show_site_details = Newapidata::where('site_name',$id)->where('activation_date', '>=',$f_day)->where('activation_date', '<=',$l_day)->orderBy('activation_date','ASC')->get();
            $api_name = Allapi::where('name',$id)->first();
        }else{
            
            $f_day = $request->start_date;      
            $l_day = $request->end_date;  
            $show_site_details = Newapidata::where('site_name',$id)->orderBy('activation_date','ASC')->get();
            $api_name = Allapi::where('name',$id)->first();
        }
        return view('admin.recharge_report.view_offline_site_details',compact('api_name','show_site_details','f_day','l_day'));
    }*/
    //end offline api

    public function storeattendance(Request $request)
    {
        $office_time = '10:00:00';
        $request->validate([
            'working_from' => 'required',
        ]);
        $user_id = Auth::user()->id;
        if (Attendance::where(['employee_id' => $user_id,'date' => date('Y-m-d')])->exists()) {
            return redirect()->route('dashboards')->with('error','Today you had already use clock-in to clock-out.');
        }else{
            $data = array();
            $data['employee_id']= $user_id;
            $data['working_from']= $request->working_from;
            $data['mark_attendance_by']= '1';
            $data['date']= date('Y-m-d');
            $data['day']= date('d');
            $data['month']= date('m');
            $data['year']= date('Y');
            $data['live_location']= $request->live_location;
            $data['clock_in']= date('H:i:s');
            if($office_time < date('H:i:s')){
                $data['late']= 'Yes';
            }else{
                $data['late']= 'No'; 
            }

            Attendance::create($data);
            $data1['user_id']= Auth::user()->id;
            $data1['user_type']= Auth::user()->role;
            $data1['module']= 'Attendance';
            $data1['activity']= 'Clock In';
            $data1['status']= 'unread';
            ActivityNotification::create($data1);
            return redirect()->route('dashboards')->with('success','Attendance saved successfully');
        }
    }

    public function checkoutattendance(Request $request, $id)
    {
        $get_d =  Attendance::where('id',$id)->first(); 
        $time1 = new DateTime($get_d->clock_in);
        $time2 = new DateTime(date('H:i:s'));
        $time_diff = $time1->diff($time2);
        $hourss = $time_diff->h;
        $user_id = Auth::user()->id;
        $data = array();
        $data['clock_out']= date('H:i:s');
        $data['total_hours']= $hourss;
        if(!empty($request->live_location)){
            $data['clock_out_location']= $request->live_location;
        }
        $data['status']= '0';
    
        Attendance::where('employee_id',$user_id)->where('id',$id)->update($data);
        $data1['user_id']= Auth::user()->id;
        $data1['user_type']= Auth::user()->role;
        $data1['module']= 'Attendance';
        $data1['activity']= 'Clock Out';
        $data1['status']= 'unread';
        ActivityNotification::create($data1);
        return redirect()->route('dashboards')->with('success','Check out time saved successfully');
    }

    public function daystart(Request $request)
    {
        $user_id = Auth::user()->id;
        $get =  Attendanceday::where('employee_id',$user_id)->whereDate('date', '=', date('Y-m-d'))->where('login_time','!=','00:00:00')->count();
        if($get>0){
            $response = ["msg"=>"already login"];
            return response()->json($response);
        }

        $data = array();
        $data['employee_id']= $user_id;
        $data['mark_attendance_by']= '1';
        $data['date']= date('Y-m-d');
        $data['day']= date('d');
        $data['month']= date('m');
        $data['year']= date('Y');
        $data['login_time']=date('H:i:s');
        $getd = Attendanceday::create($data);
        $data1['user_id']= Auth::user()->id;
        $data1['user_type']= Auth::user()->role;
        $data1['module']= 'Attendance';
        $data1['activity']= 'Login Start';
        $data1['status']= 'unread';
        ActivityNotification::create($data1);
        $tt = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('h:i a').' '.date_default_timezone_get();
        $response = ["id"=>$getd->id,"time"=>$tt,"msg"=>""];
        return response()->json($response);
    }

    public function dayend()
    {
        $user_id = Auth::user()->id;
        $get_d =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->first();
        $id = $get_d->id;

        $total_break_time = 0;

        $count = Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('login_time','00:00:00')->where('login_time','00:00:00')->groupBy('date', 'employee_id')->count();
        if($count>0){
            $total_break_time =  Attendanceday::select( DB::raw('sum(total_hours) as total_hours'))->where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('login_time','00:00:00')->where('login_time','00:00:00')->groupBy('date', 'employee_id')->first()->total_hours;
        }

        $time1 = new DateTime($get_d->login_time);
        $time2 = new DateTime(date('H:i:s'));
        $time_diff = $time1->diff($time2);
        $seconds = $time_diff->days * 24 * 60 * 60;
        $seconds += $time_diff->h * 60 * 60;
        $seconds += $time_diff->i * 60;
        $seconds += $time_diff->s;
        $hours =$seconds;

        $hourss = $hours - $total_break_time;
        $data['total_break_time']= $total_break_time;
        $data['total_hours']= $hourss;
        $data['logout_time']=date('H:i:s');

        Attendanceday::where('employee_id',$user_id)->where('id',$id)->update($data);
        $data1['user_id']= Auth::user()->id;
        $data1['user_type']= Auth::user()->role;
        $data1['module']= 'Attendance';
        $data1['activity']= 'Logout';
        $data1['status']= 'unread';
        ActivityNotification::create($data1);

        $login_time = $get_d->login_time;
        $tt = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('h:i a').' '.date_default_timezone_get();
        $response = ["time"=>$tt];
        return response()->json($response);
    }

    public function breakstart()
    {
        $user_id = Auth::user()->id;
        $data = array();
        $data['employee_id']= $user_id;
        $data['mark_attendance_by']= '1';
        $data['date']= date('Y-m-d');
        $data['day']= date('d');
        $data['month']= date('m');
        $data['year']= date('Y');
        $data['break_in']= date('H:i:s');
        //$data['clock_in']= date('H:i');
        $getd = Attendanceday::create($data);

        $data1['user_id']= Auth::user()->id;
        $data1['user_type']= Auth::user()->role;
        $data1['module']= 'Attendance';
        $data1['activity']= 'Break End';
        $data1['status']= 'unread';
        ActivityNotification::create($data1);
        //print($getd->id);
        $tt = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('h:i a').' '.date_default_timezone_get();
        $response = ["id"=>$getd->id,"time"=>$tt];
        return response()->json($response);
    }

    public function breakend()
    {
        $user_id = Auth::user()->id;
        $get_d =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->first();
        $id = $get_d->id;

        $time1 = new DateTime($get_d->break_in);
        $time2 = new DateTime(date('H:i:s'));
        $time_diff = $time1->diff($time2);
        $seconds = $time_diff->days * 24 * 60 * 60;
        $seconds += $time_diff->h * 60 * 60;
        $seconds += $time_diff->i * 60;
        $seconds += $time_diff->s;
        $hourss =$seconds;
        
        $data = array();
        $data['total_hours']= $hourss;
        $data['break_out']= date('H:i:s');    
    
        Attendanceday::where('employee_id',$user_id)->where('id',$id)->update($data);
        $data1['user_id']= Auth::user()->id;
        $data1['user_type']= Auth::user()->role;
        $data1['module']= 'Attendance';
        $data1['activity']= 'Break End';
        $data1['status']= 'unread';
        ActivityNotification::create($data1);
        $tt = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('h:i a').' '.date_default_timezone_get();
        $response = ["time"=>$tt];
        return response()->json($response);
    }

    public function reports(){
        $user_id = Auth::user()->id;
        $data = Attendanceday::select('*',DB::raw('DATE_FORMAT(login_time, "%H:%i") as login_time'),DB::raw('DATE_FORMAT(logout_time, "%H:%i") as logout_time'), DB::raw('DATE_FORMAT(break_in, "%H:%i") as break_in'),DB::raw('DATE_FORMAT(break_out, "%H:%i") as break_out'))->where('employee_id',$user_id)->whereDate('date', '=', date('Y-m-d'))->get();
        return view('admin.report.index', compact('data'));
    }

    // public function attendencelist(){
    //     if(Attendanceday::count()>0){
    //         $data = Attendanceday::select('*', DB::raw('sum(total_hours) as total_hours'))->where('login_time','!=','00:00:00')->whereDate('date', '=', date('Y-m-d'))->groupBy('date', 'employee_id')->get();
    //     }else{
    //         $data = Attendanceday::get();
    //     }
    //     $user = User::get();
    //     return view('admin.report.indexadmin', compact('data','user'));
    // }

    public function attendencelist(Request $request){

        $date = date('Y-m-d');
        if($request->date){
            $date = $request->date;
        }
        if(Attendanceday::count()>0){
            //$data = Attendanceday::select('*', DB::raw('sum(total_hours) as total_hours'))->where('login_time','!=','00:00:00')->whereDate('date', '=', $date)->groupBy('date', 'employee_id')->get();

            $data = DB::table('attendance_day')
                ->join('users', 'attendance_day.employee_id', '=', 'users.id')
                ->select('attendance_day.*',  DB::raw('sum(attendance_day.total_hours) as total_hours'))
                ->where('attendance_day.login_time','!=','00:00:00')
                ->whereDate('attendance_day.date', '=', $date)
                ->orderBy('users.name')
                ->groupBy('attendance_day.date', 'attendance_day.employee_id')
                ->get();
        }else{
            $data = Attendanceday::get();
        }
        $user = User::get();
        return view('admin.report.all_user_reports', compact('data','user','date'));
    }

    public function attendencedetail($id,$date){
        $data = Attendanceday::select('*',DB::raw('DATE_FORMAT(login_time, "%H:%i") as login_time'),DB::raw('DATE_FORMAT(logout_time, "%H:%i") as logout_time'), DB::raw('DATE_FORMAT(break_in, "%H:%i") as break_in'),DB::raw('DATE_FORMAT(break_out, "%H:%i") as break_out'))->where('employee_id',$id)->whereDate('date', '=', $date)->get();
        return view('admin.report.index', compact('data'));
    }

    public function clock(){
        echo '<b style="color: #000 !important; font-size: 20px;"> '.date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('h:i:s a').' '.date_default_timezone_get().'</b>';
    }


    public function secondsToWords($seconds) {
        /*** number of days ***/
        $days = (int)($seconds / 86400);
        /*** if more than one day ***/
        $plural = $days > 1 ? 'days' : 'day';
        /*** number of hours ***/
        $hours = (int)(($seconds - ($days * 86400)) / 3600);
        /*** number of mins ***/
        $mins = (int)(($seconds - $days * 86400 - $hours * 3600) / 60);
        /*** number of seconds ***/
        $secs = (int)($seconds - ($days * 86400) - ($hours * 3600) - ($mins * 60));
        /*** return the string ***/
        return sprintf("%d H, %d m", $hours, $mins);
    }

    public function secondsToWords1($seconds) {
        /*** number of days ***/
        $days = (int)($seconds / 86400);
        /*** if more than one day ***/
        $plural = $days > 1 ? 'days' : 'day';
        /*** number of hours ***/
        $hours = (int)(($seconds - ($days * 86400)) / 3600);
        /*** number of mins ***/
        $mins = (int)(($seconds - $days * 86400 - $hours * 3600) / 60);
        /*** number of seconds ***/
        $secs = (int)($seconds - ($days * 86400) - ($hours * 3600) - ($mins * 60));
        /*** return the string ***/
        return $hours;
    }

    /*public function timesheet(Request $request){
        $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }
        $wday = date('w', $today);   

        $datemon = date('m/d', $today - ($wday - 1)*86400);
        $datetue = date('m/d', $today - ($wday - 2)*86400);
        $datewed = date('m/d', $today - ($wday - 3)*86400);
        $datethu = date('m/d', $today - ($wday - 4)*86400);
        $datefri = date('m/d', $today - ($wday - 5)*86400);
        $datesat = date('m/d', $today - ($wday - 6)*86400);
        $datesun = date('m/d', $today - ($wday - 7)*86400);

        $weak = array();
        $weak['Mon'] = $datemon;
        $weak['Tue'] = $datetue;
        $weak['Wed'] = $datewed;
        $weak['Thu'] = $datethu;
        $weak['Fri'] = $datefri;
        $weak['Sat'] = $datesat;
        $weak['Sun'] = $datesun;

        $user_id = Auth::user()->id;

        //$today = time();
        $wday = date('w', $today);
        $dateS = date('Y-m-d', $today - ($wday - 1)*86400);
        $dateE = date('Y-m-d', $today - ($wday - 5)*86400);
        $Timesheets = Timesheet::where('user_id',$user_id)->whereBetween('date', [$dateS, $dateE])->orderBy('task_id', 'ASC')->get();

        $timesheets = array();
        $i=0;
        foreach($Timesheets as $Timesheet){
            $timesheets[$i]['task_id'] = $Timesheet->task_id;

            $data = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.name', 'projects.name as project')
                ->where('tasks.id',$Timesheet->task_id)
                ->first();

            $timesheets[$i]['project'] = $data->project .' - '.$data->name;
            if($i % 5 == 0){
                $timesheets[$i]['mon_hours'] = $Timesheet->hour;
            }
            if($i % 5==1){
                $timesheets[$i]['tue_hours'] = $Timesheet->hour;
            }
            if($i % 5==2){
                $timesheets[$i]['wed_hours'] = $Timesheet->hour;
            }
            if($i % 5==3){
                $timesheets[$i]['thu_hours'] = $Timesheet->hour;
            }
            if($i % 5==4){
                $timesheets[$i]['fri_hours'] = $Timesheet->hour;
            }
            $i++;
        }

        $projects = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.*', 'projects.name as project')
                //->where('projects.user_id',$user_id)
                ->whereRaw("find_in_set('".$user_id."',projects.user_id)")
                ->get();

        return view('admin.timesheet.create',compact('weak','projects','timesheets','today'));
    }*/

    public function timesheet(Request $request){
        $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }
       
        $wday = date('w', $today);   

        $datemon = date('m/d', $today - ($wday - 1)*86400);
        $datetue = date('m/d', $today - ($wday - 2)*86400);
        $datewed = date('m/d', $today - ($wday - 3)*86400);
        $datethu = date('m/d', $today - ($wday - 4)*86400);
        $datefri = date('m/d', $today - ($wday - 5)*86400);
        $datesat = date('m/d', $today - ($wday - 6)*86400);
        $datesun = date('m/d', $today - ($wday - 7)*86400);
        

        $weak = array();
        $weak['Mon'] = $datemon;
        $weak['Tue'] = $datetue;
        $weak['Wed'] = $datewed;
        $weak['Thu'] = $datethu;
        $weak['Fri'] = $datefri;
        $weak['Sat'] = $datesat;
        $weak['Sun'] = $datesun;

        $user_id = Auth::user()->id;

        //$today = time();
        $wday = date('w', $today);
        $dateS = date('Y-m-d', $today - ($wday - 1)*86400);
        $dateE = date('Y-m-d', $today - ($wday - 5)*86400);
        $Timesheets = Timesheet::where('user_id',$user_id)->whereBetween('date', [$dateS, $dateE])->orderBy('task_id', 'ASC')->orderBy('date', 'ASC')->get();
        
        
        $datemon1 = date('Y-m-d', $today - ($wday - 1)*86400);
        $datetue1 = date('Y-m-d', $today - ($wday - 2)*86400);
        $datewed1 = date('Y-m-d', $today - ($wday - 3)*86400);
        $datethu1 = date('Y-m-d', $today - ($wday - 4)*86400);
        $datefri1 = date('Y-m-d', $today - ($wday - 5)*86400);
        //$datesat1 = date('Y-m-d', $today - ($wday - 6)*86400);
        //$datesun1 = date('Y-m-d', $today - ($wday - 7)*86400);
        
        $dates['mon']=$datemon1;
        $dates['tue']=$datetue1;
        $dates['wed']=$datewed1;
        $dates['thu']=$datethu1;
        $dates['fri']=$datefri1;
        
        $timesheets = array();
        $i=0;
        foreach($Timesheets as $Timesheet){
            
            $timesheets[$i]['task_id'] = $Timesheet->task_id;

            $data = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.name', 'projects.name as project')
                ->where('tasks.id',$Timesheet->task_id)
                ->first();

            $timesheets[$i]['project'] = $data->project .' - '.$data->name;
            if($Timesheet->date == $datemon1){
                $timesheets[$i]['mon_hours'] = $Timesheet->hour;
            }
            if($Timesheet->date==$datetue1){
                $timesheets[$i]['tue_hours'] = $Timesheet->hour;
            }
            if($Timesheet->date==$datewed1){
                $timesheets[$i]['wed_hours'] = $Timesheet->hour;
            }
            if($Timesheet->date==$datethu1){
                $timesheets[$i]['thu_hours'] = $Timesheet->hour;
            }
            if($Timesheet->date==$datefri1){
                $timesheets[$i]['fri_hours'] = $Timesheet->hour;
            }
            $i++;
        }
        
        $projects = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.*', 'projects.name as project')
                //->where('projects.user_id',$user_id)
                ->whereRaw("find_in_set('".$user_id."',projects.user_id)")
                ->get();

        return view('admin.timesheet.create',compact('weak','projects','timesheets','today'));
    }

   /* public function store_timesheet(Request $request){

        $alltasks = $request->task_id;
        $allmon_hours = $request->mon_hours;
        $alltue_hours = $request->tue_hours;
        $allwed_hours = $request->wed_hours;
        $allthu_hours = $request->thu_hours;
        $allfri_hours = $request->fri_hours;

        $timesheet = array();
        $i=0;
        $user_id = Auth::user()->id;

        foreach($alltasks as $task) {
            $timesheet[$i]['user_id'] = $user_id;
            $timesheet[$i]['task_id'] = $task;
            $i++;
        }

        //$today = time();
        //if($request->today){
            $today = $request->today;
        //}
        $wday = date('w', $today);

        $i=0;
        foreach($allmon_hours as $allmon_hour) {
            $timesheet[$i]['hour'] = $allmon_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 1)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 1)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 1)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $i=0;
        foreach($alltue_hours as $alltue_hour) {
            $timesheet[$i]['hour'] = $alltue_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 2)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 2)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 2)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $i=0;
        foreach($allwed_hours as $allwed_hour) {
            $timesheet[$i]['hour'] = $allwed_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 3)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 3)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 3)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $i=0;
        foreach($allthu_hours as $allthu_hour) {
            $timesheet[$i]['hour'] = $allthu_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 4)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 4)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 4)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $i=0;
        foreach($allfri_hours as $allfri_hour) {
            $timesheet[$i]['hour'] = $allfri_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 5)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 5)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 5)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $datemon = date('m/d', $today - ($wday - 1)*86400);
        $datetue = date('m/d', $today - ($wday - 2)*86400);
        $datewed = date('m/d', $today - ($wday - 3)*86400);
        $datethu = date('m/d', $today - ($wday - 4)*86400);
        $datefri = date('m/d', $today - ($wday - 5)*86400);
        $datesat = date('m/d', $today - ($wday - 6)*86400);
        $datesun = date('m/d', $today - ($wday - 7)*86400);

        $weak = array();
        $weak['Mon'] = $datemon;
        $weak['Tue'] = $datetue;
        $weak['Wed'] = $datewed;
        $weak['Thu'] = $datethu;
        $weak['Fri'] = $datefri;
        $weak['Sat'] = $datesat;
        $weak['Sun'] = $datesun;

        $projects = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.*', 'projects.name as project')
                ->whereRaw("find_in_set('".$user_id."',projects.user_id)")
                ->get();

        $dateS = date('Y-m-d', $today - ($wday - 1)*86400);
        $dateE = date('Y-m-d', $today - ($wday - 5)*86400);
        $Timesheets = Timesheet::where('user_id',$user_id)->whereBetween('date', [$dateS, $dateE])->orderBy('task_id', 'ASC')->get();

        $timesheets = array();
        $i=0;
        foreach($Timesheets as $Timesheet){
            $timesheets[$i]['task_id'] = $Timesheet->task_id;

            $data = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.name', 'projects.name as project')
                ->where('tasks.id',$Timesheet->task_id)
                ->first();

            $timesheets[$i]['project'] = $data->project .' - '.$data->name;
            if($i % 5 == 0){
                $timesheets[$i]['mon_hours'] = $Timesheet->hour;
            }
            if($i % 5==1){
                $timesheets[$i]['tue_hours'] = $Timesheet->hour;
            }
            if($i % 5==2){
                $timesheets[$i]['wed_hours'] = $Timesheet->hour;
            }
            if($i % 5==3){
                $timesheets[$i]['thu_hours'] = $Timesheet->hour;
            }
            if($i % 5==4){
                $timesheets[$i]['fri_hours'] = $Timesheet->hour;
            }
            $i++;
        }
        return view('admin.timesheet.create',compact('weak','projects','timesheets','today'))->with('success','Timesheet Has Been Added successfully');;
    }*/

    public function store_timesheet(Request $request){

        $alltasks = $request->task_id;
        $allmon_hours = $request->mon_hours;
        $alltue_hours = $request->tue_hours;
        $allwed_hours = $request->wed_hours;
        $allthu_hours = $request->thu_hours;
        $allfri_hours = $request->fri_hours;

        $timesheet = array();
        $i=0;
        $user_id = Auth::user()->id;

        foreach($alltasks as $task) {
            $timesheet[$i]['user_id'] = $user_id;
            $timesheet[$i]['task_id'] = $task;
            $i++;
        }

        //$today = time();
        //if($request->today){
            $today = $request->today;
        //}
        $wday = date('w', $today);

        $i=0;
        foreach($allmon_hours as $allmon_hour) {
            $timesheet[$i]['hour'] = $allmon_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 1)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 1)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 1)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $i=0;
        foreach($alltue_hours as $alltue_hour) {
            $timesheet[$i]['hour'] = $alltue_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 2)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 2)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 2)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $i=0;
        foreach($allwed_hours as $allwed_hour) {
            $timesheet[$i]['hour'] = $allwed_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 3)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 3)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 3)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $i=0;
        foreach($allthu_hours as $allthu_hour) {
            $timesheet[$i]['hour'] = $allthu_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 4)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 4)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 4)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $i=0;
        foreach($allfri_hours as $allfri_hour) {
            $timesheet[$i]['hour'] = $allfri_hour;
            $timesheet[$i]['date'] = date('Y-m-d', $today - ($wday - 5)*86400);
            if(Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 5)*86400))->count() ==1){
                Timesheet::where('user_id',$user_id)->where('task_id',$timesheet[$i]['task_id'])->where('date',date('Y-m-d', $today - ($wday - 5)*86400))->update($timesheet[$i]);
            }else{
                Timesheet::create($timesheet[$i]);
            }
            $i++;
        }

        $datemon = date('m/d', $today - ($wday - 1)*86400);
        $datetue = date('m/d', $today - ($wday - 2)*86400);
        $datewed = date('m/d', $today - ($wday - 3)*86400);
        $datethu = date('m/d', $today - ($wday - 4)*86400);
        $datefri = date('m/d', $today - ($wday - 5)*86400);
        $datesat = date('m/d', $today - ($wday - 6)*86400);
        $datesun = date('m/d', $today - ($wday - 7)*86400);

        $weak = array();
        $weak['Mon'] = $datemon;
        $weak['Tue'] = $datetue;
        $weak['Wed'] = $datewed;
        $weak['Thu'] = $datethu;
        $weak['Fri'] = $datefri;
        $weak['Sat'] = $datesat;
        $weak['Sun'] = $datesun;
        
         $datemon1 = date('Y-m-d', $today - ($wday - 1)*86400);
        $datetue1 = date('Y-m-d', $today - ($wday - 2)*86400);
        $datewed1 = date('Y-m-d', $today - ($wday - 3)*86400);
        $datethu1 = date('Y-m-d', $today - ($wday - 4)*86400);
        $datefri1 = date('Y-m-d', $today - ($wday - 5)*86400);

        $projects = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.*', 'projects.name as project')
                ->whereRaw("find_in_set('".$user_id."',projects.user_id)")
                ->get();

        $dateS = date('Y-m-d', $today - ($wday - 1)*86400);
        $dateE = date('Y-m-d', $today - ($wday - 5)*86400);
        $Timesheets = Timesheet::where('user_id',$user_id)->whereBetween('date', [$dateS, $dateE])->orderBy('task_id', 'ASC')->orderBy('date', 'ASC')->get();

        $timesheets = array();
        $i=0;
        foreach($Timesheets as $Timesheet){
            $timesheets[$i]['task_id'] = $Timesheet->task_id;

            $data = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.name', 'projects.name as project')
                ->where('tasks.id',$Timesheet->task_id)
                ->first();

            $timesheets[$i]['project'] = $data->project .' - '.$data->name;
            // if($i % 5 == 0){
            //     $timesheets[$i]['mon_hours'] = $Timesheet->hour;
            // }
            // if($i % 5==1){
            //     $timesheets[$i]['tue_hours'] = $Timesheet->hour;
            // }
            // if($i % 5==2){
            //     $timesheets[$i]['wed_hours'] = $Timesheet->hour;
            // }
            // if($i % 5==3){
            //     $timesheets[$i]['thu_hours'] = $Timesheet->hour;
            // }
            // if($i % 5==4){
            //     $timesheets[$i]['fri_hours'] = $Timesheet->hour;
            // }
            if($Timesheet->date == $datemon1){
                $timesheets[$i]['mon_hours'] = $Timesheet->hour;
            }
            if($Timesheet->date==$datetue1){
                $timesheets[$i]['tue_hours'] = $Timesheet->hour;
            }
            if($Timesheet->date==$datewed1){
                $timesheets[$i]['wed_hours'] = $Timesheet->hour;
            }
            if($Timesheet->date==$datethu1){
                $timesheets[$i]['thu_hours'] = $Timesheet->hour;
            }
            if($Timesheet->date==$datefri1){
                $timesheets[$i]['fri_hours'] = $Timesheet->hour;
            }
            $i++;
        }
        return view('admin.timesheet.create',compact('weak','projects','timesheets','today'))->with('success','Timesheet Has Been Added successfully');;
    }

    public function search_project(Request $request){
        $name = $request->name;
        $user_id = Auth::user()->id;
        $projects = DB::table('tasks')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->select('tasks.*', 'projects.name as project')
            ->whereRaw("find_in_set('".$user_id."',projects.user_id)")
            ->where('projects.name','like','%'.$name.'%')
            ->get();

        $tr='';

        foreach($projects as $project){
            $tr .= '<tr>
                <td>
                    <input type="radio" id="'.$project->project .' - '. $project->name .'" class="project_id" name="project_id" value="'. $project->id .'">
                    <label>'. $project->project .'</label>
                </td>
                <td>
                    <label>'. $project->name .'</label>
                </td>
            </tr>';
        }
        echo $tr;
    }

    public function search_task(Request $request){
        $name = $request->name;
        $user_id = Auth::user()->id;
        $projects = DB::table('tasks')
            ->join('projects', 'tasks.project_id', '=', 'projects.id')
            ->select('tasks.*', 'projects.name as project')
            ->whereRaw("find_in_set('".$user_id."',projects.user_id)")
            ->where('tasks.name','like','%'.$name.'%')
            ->get();

        $tr='';
        foreach($projects as $project){
            $tr .= '<tr>
                <td>
                    <input type="radio" id="'.$project->project .' - '. $project->name .'" class="project_id" name="project_id" value="'. $project->id .'">
                    <label>'. $project->project .'</label>
                </td>
                <td>
                    <label>'. $project->name .'</label>
                </td>
            </tr>';
        }
        echo $tr;
    }

    /*public function my_activity(Request $request){
        $today = time();
        $date = date('Y-m-d');
        if($request->date){
            $date = $request->date;
            $today = strtotime($request->date);
        }
       
        $wday = date('w', $today);   
        $datemon = date('m/d', $today - ($wday - 1)*86400);
        $datetue = date('m/d', $today - ($wday - 2)*86400);
        $datewed = date('m/d', $today - ($wday - 3)*86400);
        $datethu = date('m/d', $today - ($wday - 4)*86400);
        $datefri = date('m/d', $today - ($wday - 5)*86400);
        $datesat = date('m/d', $today - ($wday - 6)*86400);
        $datesun = date('m/d', $today - ($wday - 7)*86400);

        $weak = array();
        $weak['Mon'] = $datemon;
        $weak['Tue'] = $datetue;
        $weak['Wed'] = $datewed;
        $weak['Thu'] = $datethu;
        $weak['Fri'] = $datefri;
        $weak['Sat'] = $datesat;
        $weak['Sun'] = $datesun;

        $user_id = Auth::user()->id;

        //$today = time();
        $wday = date('w', $today);
        $dateS = date('Y-m-d', $today - ($wday - 1)*86400);
        $dateE = date('Y-m-d', $today - ($wday - 5)*86400);
        $Timesheets = Timesheet::where('user_id',$user_id)->whereBetween('date', [$dateS, $dateE])->orderBy('task_id', 'ASC')->get();

        $timesheets = array();
        $i=0;
        foreach($Timesheets as $Timesheet){
            $timesheets[$i]['task_id'] = $Timesheet->task_id;

            $data = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.name', 'projects.name as project')
                ->where('tasks.id',$Timesheet->task_id)
                ->first();

            $timesheets[$i]['project'] = $data->project .' - '.$data->name;
            if($i % 5 == 0){
                $timesheets[$i]['mon_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            if($i % 5==1){
                $timesheets[$i]['tue_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            if($i % 5==2){
                $timesheets[$i]['wed_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            if($i % 5==3){
                $timesheets[$i]['thu_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            if($i % 5==4){
                $timesheets[$i]['fri_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            $i++;
        }

        // echo "<pre>";
        // print_r($timesheets);exit;

        $projects = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.*', 'projects.name as project')
                //->where('projects.user_id',$user_id)
                ->whereRaw("find_in_set('".$user_id."',projects.user_id)")
                ->get();

        return view('admin.timesheet.addactivity',compact('weak','projects','timesheets','today','date'));
    }*/

    public function my_activity(Request $request){
        $today = time();
        $date = date('Y-m-d');
        if($request->date){
            $date = $request->date;
            $today = strtotime($request->date);
        }
       
        $wday = date('w', $today);   
        $datemon = date('m/d', $today - ($wday - 1)*86400);
        $datetue = date('m/d', $today - ($wday - 2)*86400);
        $datewed = date('m/d', $today - ($wday - 3)*86400);
        $datethu = date('m/d', $today - ($wday - 4)*86400);
        $datefri = date('m/d', $today - ($wday - 5)*86400);
        $datesat = date('m/d', $today - ($wday - 6)*86400);
        $datesun = date('m/d', $today - ($wday - 7)*86400);

        $weak = array();
        $weak['Mon'] = $datemon;
        $weak['Tue'] = $datetue;
        $weak['Wed'] = $datewed;
        $weak['Thu'] = $datethu;
        $weak['Fri'] = $datefri;
        $weak['Sat'] = $datesat;
        $weak['Sun'] = $datesun;
        
        $datemon1 = date('Y-m-d', $today - ($wday - 1)*86400);
        $datetue1 = date('Y-m-d', $today - ($wday - 2)*86400);
        $datewed1 = date('Y-m-d', $today - ($wday - 3)*86400);
        $datethu1 = date('Y-m-d', $today - ($wday - 4)*86400);
        $datefri1 = date('Y-m-d', $today - ($wday - 5)*86400);

        $user_id = Auth::user()->id;

        //$today = time();
        $wday = date('w', $today);
        $dateS = date('Y-m-d', $today - ($wday - 1)*86400);
        $dateE = date('Y-m-d', $today - ($wday - 5)*86400);
        $Timesheets = Timesheet::where('user_id',$user_id)->whereBetween('date', [$dateS, $dateE])->orderBy('task_id', 'ASC')->orderBy('date', 'ASC')->get();

        $timesheets = array();
        $i=0;
        foreach($Timesheets as $Timesheet){
            $timesheets[$i]['task_id'] = $Timesheet->task_id;

            $data = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.name', 'projects.name as project')
                ->where('tasks.id',$Timesheet->task_id)
                ->first();

            $timesheets[$i]['project'] = $data->project .' - '.$data->name;
            if($Timesheet->date == $datemon1){
                $timesheets[$i]['mon_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            if($Timesheet->date == $datetue1){
                $timesheets[$i]['tue_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            if($Timesheet->date == $datewed1){
                $timesheets[$i]['wed_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            if($Timesheet->date == $datethu1){
                $timesheets[$i]['thu_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            if($Timesheet->date == $datefri1){
                $timesheets[$i]['fri_hours'] = $Timesheet->hour;
                $timesheets[$i]['id'] = $Timesheet->id;
                $timesheets[$i]['timesheet_id'] = '';

                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                    $timesheets[$i]['timesheet_id'] = $time_activity->timesheet_id;
                    $timesheets[$i]['count'] = $time_activity->count;
                    $timesheets[$i]['comments'] = $time_activity->comments;
                }
            }
            $i++;
        }

        // echo "<pre>";
        // print_r($timesheets);exit;

        $projects = DB::table('tasks')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->select('tasks.*', 'projects.name as project')
                //->where('projects.user_id',$user_id)
                ->whereRaw("find_in_set('".$user_id."',projects.user_id)")
                ->get();

        return view('admin.timesheet.addactivity',compact('weak','projects','timesheets','today','date'));
    }

    public function store_myactivity(Request $request){
       $count = $request->count;
       $comments = $request->comments;
       $timesheet_id = $request->timesheet_id;

       $data = array();
       $data['timesheet_id'] = $timesheet_id;
       $data['count'] = $count;
       $data['comments'] =date("h:i:sa").' '.$comments;

       Timesheetactivity::create($data);
       echo 'done';
    }

    public function update_myactivity(Request $request){
       $count = $request->count;
       $comments = $request->comments;
       $timesheet_id = $request->timesheet_id;
       $timesheet = Timesheetactivity::where('timesheet_id', $timesheet_id)->first();

       $data = array();
       //$data['timesheet_id'] = $timesheet_id;
       $data['count'] = $count+$timesheet->count;
       $data['comments'] = date("h:i:sa").' '.$comments .' '. $timesheet->comments;

       Timesheetactivity::where('timesheet_id', $timesheet_id)->update($data);
       echo 'done';
    }

    public function activity_reports(Request $request){
        $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }

        $from = date('Y-m-d');
        $to = date('Y-m-d');
        if($request->from){
            $from = $request->from;
        }
        if($request->to){
            $to = $request->to;
        }
        $user_ids =array();
        if($request->user_id){
            $user_ids = $request->user_id;
        }
        $project_id ='';
        if($request->project_id !=''){
            $project_id = $request->project_id;
        }

        $Timesheets = Timesheet::whereBetween('date', [$from, $to])->orderBy('task_id', 'ASC')->get();

        $timesheets = array();
        $i=0;
        foreach($Timesheets as $Timesheet){
            if(count($user_ids)>0){
                if(in_array($Timesheet->user_id, $user_ids)){
                    $query = DB::table('tasks');
                    $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                    $query->select('tasks.name', 'projects.name as project');
                    $query->where('tasks.id',$Timesheet->task_id);
                    if($request->project_id !=''){
                        $query->where('projects.id',$request->project_id);
                    }
                    $data = $query->first();
                    $count = $query->count();
                    if($count>0){

                        $timesheets[$i]['date'] = $Timesheet->date;
                        $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                        $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                        $timesheets[$i]['hours'] = $Timesheet->hour;
                        $timesheets[$i]['count'] = '';
                        $timesheets[$i]['comments'] = '';

                        if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                            $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                            $timesheets[$i]['count'] = $time_activity->count;
                            $timesheets[$i]['comments'] = $time_activity->comments;
                        }
                        $i++;
                    }
                }
                            
            }else{
                $query = DB::table('tasks');
                    $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                    $query->select('tasks.name', 'projects.name as project');
                    $query->where('tasks.id',$Timesheet->task_id);
                    if($request->project_id !=''){
                        $query->where('projects.id',$request->project_id);
                    }
                $data = $query->first();
                $count = $query->count();
                if($count>0){

                    $timesheets[$i]['date'] = $Timesheet->date;
                    $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                    $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                    $timesheets[$i]['hours'] = $Timesheet->hour;
                    $timesheets[$i]['count'] = '';
                    $timesheets[$i]['comments'] = '';

                    if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                        $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                        $timesheets[$i]['count'] = $time_activity->count;
                        $timesheets[$i]['comments'] = $time_activity->comments;
                    }
                    $i++;
                }
            }
        }
        $users = User::orderBy('name')->get();
        $projects = Project::get();

        return view('admin.timesheet.activity_report',compact('timesheets','from','to','users','projects','user_ids','project_id'));
    }

    public function createPDF(Request $request) {
        // retreive all records from db
        $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }

        $from = date('Y-m-d');
        $to = date('Y-m-d');
        if($request->from1){
            $from = $request->from1;
        }
        if($request->to1){
            $to = $request->to1;
        }
        $user_ids =array();
        if($request->user_id1){
            $user_ids = $request->user_id1;
        }

        $Timesheets = Timesheet::whereBetween('date', [$from, $to])->orderBy('task_id', 'ASC')->get();

        $timesheets = array();
        $i=0;
        foreach($Timesheets as $Timesheet){
            if(count($user_ids)>0){
                if(in_array($Timesheet->user_id, $user_ids)){
                    $query = DB::table('tasks');
                    $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                    $query->select('tasks.name', 'projects.name as project');
                    $query->where('tasks.id',$Timesheet->task_id);
                    if($request->project_id !=''){
                        $query->where('projects.id',$request->project_id1);
                    }
                    $data = $query->first();
                    $count = $query->count();
                    if($count>0){

                        $timesheets[$i]['date'] = $Timesheet->date;
                        $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                        $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                        $timesheets[$i]['hours'] = $Timesheet->hour;
                        $timesheets[$i]['count'] = '';
                        $timesheets[$i]['comments'] = '';

                        if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                            $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                            $timesheets[$i]['count'] = $time_activity->count;
                            $timesheets[$i]['comments'] = $time_activity->comments;
                        }
                        $i++;
                    }
                }
                            
            }else{
                $query = DB::table('tasks');
                    $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                    $query->select('tasks.name', 'projects.name as project');
                    $query->where('tasks.id',$Timesheet->task_id);
                    if($request->project_id !=''){
                        $query->where('projects.id',$request->project_id1);
                    }
                $data = $query->first();
                $count = $query->count();
                if($count>0){

                    $timesheets[$i]['date'] = $Timesheet->date;
                    $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                    $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                    $timesheets[$i]['hours'] = $Timesheet->hour;
                    $timesheets[$i]['count'] = '';
                    $timesheets[$i]['comments'] = '';

                    if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                        $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                        $timesheets[$i]['count'] = $time_activity->count;
                        $timesheets[$i]['comments'] = $time_activity->comments;
                    }
                    $i++;
                }
            }
        }

        view()->share('timesheets',$timesheets);
        $pdf = PDF::loadView('admin.timesheet.activity_report_pdf', $timesheets);
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    public function testHook(){

        return Redirect::to('https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize?response_type=code&grant_type=authorization_code&scope=fhirUser&client_id=3b5ac3c3-3c3b-47b8-8200-4f4af073b9ec&state=1&redirect_uri=https://localhost/clindcast_time_logs/public/tt');
        // $client = new \GuzzleHttp\Client();

        // $request = $client->createRequest(
        //     'GET', 'https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize',[
        //         'query' => [
        //             'client_id' => 'myclientid',
        //             'response_type' => 'code',
        //             'scope' => 'inventory',
        //             'redirect_uri' => 'https://myownsite/uri.php',
        //         ],
        //     ]
        // );

        // // Send the request
        // $response = $client->send($request);


        // $client = new \GuzzleHttp\Client();

        //     $options = [
        //         'headers' => [
        //             'Content-Type' => 'text/xml; charset=utf-8',
        //             'client_id' => 'myclientid',
        //             'response_type' => 'code',
        //             'scope' => 'fhirUser',
        //             'redirect_uri' => 'https://myownsite/uri.php',
        //         ],
        //         'http_errors' => false,
        //         'verify' => false,
        //         'body'    => ''
        //     ];
        //     $response = $client->request('POST', 'https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize'.'/rest/', $options);

        // $http = new \GuzzleHttp\Client();
        //     $response = $http->post(
        //         'https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize',
        //         [
        //             'form_params' => [
        //                 'grant_type' => 'Auhorization Code',
        //                 'client_id' => 'c205e3e8-6e0c-4b6e-b911-083502dcace3',
        //                 'scope' => 'fhirUser',
        //                 'state' => 1,
        //                 'redirect_uri' => '',
        //             ],
        //         ]
        //     );
        //     $array = $response->getBody()->getContents();
        //     $json = json_decode($array, true);

           /* $client = new \GuzzleHttp\Client();
            $response = $client->post('https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize', [
                'form_params' => [
                    'grant_type' => 'client_credentials'
                    'response_type' => 'code',
                    'client_id' => 'c205e3e8-6e0c-4b6e-b911-083502dcace3',
                    'redirect_uri' => 'http://localhost/clindcast_time_logs/public/test1',
                    'scope' => 'launch',
                    'state' => 1,
                ]
            ]);*/

            //https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize?response_type=code&scope=fhirUser&client_id=c205e3e8-6e0c-4b6e-b911-083502dcace3&state=1&redirect_uri=https://www.clindcast.com

           //https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize?response_type=code&scope=fhirUser&client_id=c205e3e8-6e0c-4b6e-b911-083502dcace3&state=1&redirect_uri=https://www.clindcast.com

            // https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize?scope=launch&response_type=code&redirect_uri=http://localhost/clindcast_time_logs/public/&client_id=c205e3e8-6e0c-4b6e-b911-083502dcace3&launch=[launch_token]&state=1e]

            // curl -v -X POST "https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize" \
            //     -u "<CLIENT_ID>:<CLIENT_SECRET>" \
            //     -H "Content-Type: application/x-www-form-urlencoded" \
            //     -d "grant_type=client_credentials"

            //https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize?response_type=code&scope=fhirUser&client_id=c205e3e8-6e0c-4b6e-b911-083502dcace3&state=1&redirect_uri=https://www.clindcast.com

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://fhir.epic.com/interconnect-fhir-oauth/oauth2/authorize",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "grant_type=authorization_code&response_type=code&client_id=c205e3e8-6e0c-4b6e-b911-083502dcace3&redirect_uri=https://www.clindcast.com",
              CURLOPT_HTTPHEADER => [
                "grant_type: authorization_code"
              ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
              echo $response;
            }
            //echo "<pre>";
            //print_r($response);exit;
    }

    public function testHook1(Request $request) {
        echo $request;
    }

    public function getStartAndEndDate($week, $year) {
      $dto = new DateTime();
      $dto->setISODate($year, $week);
      $ret['week_start'] = $dto->format('Y-m-d');
      $dto->modify('+6 days');
      $ret['week_end'] = $dto->format('Y-m-d');
      return $ret;
    }

    public function activity_reports_week(Request $request){

        $users = User::orderBy('name')->get();
            
            foreach($users as $user){

                $tasks = DB::table('tasks')
                        ->join('projects', 'tasks.project_id', '=', 'projects.id')
                        ->select('tasks.id')
                        ->whereRaw("find_in_set('".$user->id."',projects.user_id)")
                        ->get();
            }
    }

    public function activity_reports_weekly(Request $request){
        $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }

        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        $week = $date->format("W");
        if($request->week){
            $week = $request->week;
        }
        $data = array();
        $timesheets = array();
        $i=0;
        $options =array();
        $w = $date->format("W");
        for($x = 1; $x <= $w; $x++){
            $week_arr = $this->getStartAndEndDate($x,date("Y"));
            $options[$x]['value'] = $x;
            $options[$x]['week_start'] = date("D M d ", strtotime($week_arr["week_start"]));
            $options[$x]['week_end'] =date("D M d ", strtotime($week_arr["week_end"]));
        }

        $week_array = $this->getStartAndEndDate($week,date("Y"));

        $from = $week_array['week_start'];
        $to = $week_array['week_end'];

        $user_ids =array();
        if($request->user_id){
            $user_ids = $request->user_id;
        }
        $project_id ='';
        if($request->project_id !=''){
            $project_id = $request->project_id;
        }
        $users = User::orderBy('name')->get();
        foreach($users as $user){
            $tasks = DB::table('tasks')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->select('tasks.id')
                    ->whereRaw("find_in_set('".$user->id."',projects.user_id)")
                    ->get();
            foreach($tasks as $task){
                $Timesheets = Timesheet::where('user_id',$user->id)->where('task_id',$task->id)->whereBetween('date', [$from, $to])->orderBy('task_id', 'ASC')->get();

                $counts = 0;
                $hours = 0;
                $comments = '';
                foreach($Timesheets as $Timesheet){
                    if(count($user_ids)>0){
                        if(in_array($Timesheet->user_id, $user_ids)){
                            $query = DB::table('tasks');
                            $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                            $query->select('tasks.name', 'projects.name as project');
                            $query->where('tasks.id',$Timesheet->task_id);
                            if($request->project_id !=''){
                                $query->where('projects.id',$request->project_id);
                            }
                            $data = $query->first();
                            $count = $query->count();
                            if($count>0){

                                $timesheets[$i]['date'] =  $from;
                                $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                                $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                                $hours = $Timesheet->hour+$hours;
                                $timesheets[$i]['hours'] = $hours;
                                $timesheets[$i]['count'] = $counts;
                                $timesheets[$i]['comments'] = $comments;


                                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                                    $counts = $time_activity->count+$counts;
                                    $comments .= date("D M d ", strtotime($time_activity->created_at)) ." ".$time_activity->comments."\n";
                                    $timesheets[$i]['count'] = $counts;
                                    $timesheets[$i]['comments'] = $comments;
                                }
                                //$i++;
                            }
                        }
                                    
                    }else{
                        $query = DB::table('tasks');
                            $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                            $query->select('tasks.name', 'projects.name as project');
                            $query->where('tasks.id',$Timesheet->task_id);
                            if($request->project_id !=''){
                                $query->where('projects.id',$request->project_id);
                            }
                        $data = $query->first();
                        $count = $query->count();
                        if($count>0){

                            $timesheets[$i]['date'] =  $from;
                            $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                            $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                            $hours = $Timesheet->hour+$hours;
                            $timesheets[$i]['hours'] = $hours;
                            $timesheets[$i]['count'] = $counts;
                            $timesheets[$i]['comments'] = $comments;


                            if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                                $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                                $counts = $time_activity->count+$counts;
                                $comments .= date("D M d ", strtotime($time_activity->created_at)) ." ".$time_activity->comments."\n";
                                $timesheets[$i]['count'] = $counts;
                                $timesheets[$i]['comments'] = $comments;
                            }
                        }
                    }
                }
                $i++;
            }
        }
        $users = User::orderBy('name')->get();
        $projects = Project::get();

        return view('admin.timesheet.activity_weekly_report',compact('timesheets','from','to','users','projects','user_ids','project_id','options','week'));
    }
    
    public function createWeeklyPDF(Request $request) {
       $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }

        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        $week = $date->format("W");
        if($request->week1){
            $week = $request->week1;
        }
        $data = array();
        $timesheets = array();
        $i=0;

        $week_array = $this->getStartAndEndDate($week,date("Y"));

        $from = $week_array['week_start'];
        $to = $week_array['week_end'];

        $user_ids =array();
        if($request->user_id1){
            $user_ids = $request->user_id1;
        }
        $project_id ='';
        if($request->project_id1 !=''){
            $project_id = $request->project_id1;
        }

        $users = User::orderBy('name')->get();
        
        foreach($users as $user){

            $tasks = DB::table('tasks')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->select('tasks.id')
                    ->whereRaw("find_in_set('".$user->id."',projects.user_id)")
                    ->get();
            foreach($tasks as $task){

                $Timesheets = Timesheet::where('user_id',$user->id)->where('task_id',$task->id)->whereBetween('date', [$from, $to])->orderBy('task_id', 'ASC')->get();

                $counts = 0;
                $hours = 0;
                $comments = '';
                foreach($Timesheets as $Timesheet){
                    if(count($user_ids)>0){
                        if(in_array($Timesheet->user_id, $user_ids)){
                            $query = DB::table('tasks');
                            $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                            $query->select('tasks.name', 'projects.name as project');
                            $query->where('tasks.id',$Timesheet->task_id);
                            if($request->project_id1 !=''){
                                $query->where('projects.id',$request->project_id1);
                            }
                            $data = $query->first();
                            $count = $query->count();
                            if($count>0){
                                $timesheets[$i]['to'] =$to;
                                $timesheets[$i]['from'] = $from;
                                $timesheets[$i]['date'] =  $from;
                                $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                                $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                                $hours = $Timesheet->hour+$hours;
                                $timesheets[$i]['hours'] = $hours;
                                $timesheets[$i]['count'] = $counts;
                                $timesheets[$i]['comments'] = $comments;


                                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                                    $counts = $time_activity->count+$counts;
                                    $comments .= date("D M d ", strtotime($time_activity->created_at)) ." ".$time_activity->comments."\n";
                                    $timesheets[$i]['count'] = $counts;
                                    $timesheets[$i]['comments'] = $comments;
                                }
                                //$i++;
                            }
                        }
                                    
                    }else{
                        $query = DB::table('tasks');
                            $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                            $query->select('tasks.name', 'projects.name as project');
                            $query->where('tasks.id',$Timesheet->task_id);
                            if($request->project_id1 !=''){
                                $query->where('projects.id',$request->project_id1);
                            }
                        $data = $query->first();
                        $count = $query->count();
                        if($count>0){
                            $timesheets[$i]['to'] =$to;
                                $timesheets[$i]['from'] = $from;
                            $timesheets[$i]['date'] =  $from;
                            $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                            $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                            $hours = $Timesheet->hour+$hours;
                            $timesheets[$i]['hours'] = $hours;
                            $timesheets[$i]['count'] = $counts;
                            $timesheets[$i]['comments'] = $comments;


                            if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                                $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                                $counts = $time_activity->count+$counts;
                                $comments .= date("D M d ", strtotime($time_activity->created_at)) ." ".$time_activity->comments."\n";
                                $timesheets[$i]['count'] = $counts;
                                $timesheets[$i]['comments'] = $comments;
                            }
                            //$i++;
                        }
                    }
                }
                $i++;
            }
        }

        view()->share('timesheets',$timesheets ,$to ,$from);
        $pdf = PDF::loadView('admin.timesheet.timesheetweeklypdf', $timesheets);
        return $pdf->download('Weekly_Task_Details_Report.pdf');
    }

    public function getStartAndEndDateofmonth($month, $year) 
    {
      $dt = $year."-".$month."-23";
      $ret['month_start'] = date("Y-m-01", strtotime($dt));
      $ret['month_end'] = date("Y-m-t", strtotime($dt));
      return $ret;
    }

    public function activity_reports_monthly(Request $request){
        $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }

        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        $month = date('m');
        if($request->month){
            $month = $request->month;
        }
        $data = array();
        $timesheets = array();
        $i=0;
        $options =array();
        $m = date('m');
        for($x = 1; $x <= $m; $x++){
            $month_arr = $this->getStartAndEndDateofmonth($x,date("Y"));
            $options[$x]['value'] = $x;
            $options[$x]['month_start'] = date("D M d ", strtotime($month_arr["month_start"]));
            $options[$x]['month_end'] =date("D M d ", strtotime($month_arr["month_end"]));
        }

            $month_array = $this->getStartAndEndDateofmonth($month,date("Y"));

            $from = $month_array['month_start'];
            $to = $month_array['month_end'];

            $user_ids =array();
            if($request->user_id){
                $user_ids = $request->user_id;
            }
            $project_id ='';
            if($request->project_id !=''){
                $project_id = $request->project_id;
            }

            $users = User::orderBy('name')->get();
            
            foreach($users as $user){

                $tasks = DB::table('tasks')
                        ->join('projects', 'tasks.project_id', '=', 'projects.id')
                        ->select('tasks.id')
                        ->whereRaw("find_in_set('".$user->id."',projects.user_id)")
                        ->get();
                foreach($tasks as $task){

                    $Timesheets = Timesheet::where('user_id',$user->id)->where('task_id',$task->id)->whereBetween('date', [$from, $to])->orderBy('task_id', 'ASC')->get();

                    $counts = 0;
                    $hours = 0;
                    $comments = '';
                    foreach($Timesheets as $Timesheet){
                        if(count($user_ids)>0){
                            if(in_array($Timesheet->user_id, $user_ids)){
                                $query = DB::table('tasks');
                                $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                                $query->select('tasks.name', 'projects.name as project');
                                $query->where('tasks.id',$Timesheet->task_id);
                                if($request->project_id !=''){
                                    $query->where('projects.id',$request->project_id);
                                }
                                $data = $query->first();
                                $count = $query->count();
                                if($count>0){

                                    $timesheets[$i]['date'] =  $from;
                                    $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                                    $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                                    $hours = $Timesheet->hour+$hours;
                                    $timesheets[$i]['hours'] = $hours;
                                    $timesheets[$i]['count'] = $counts;
                                    $timesheets[$i]['comments'] = $comments;

                                    if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                                        $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                                        $counts = $time_activity->count+$counts;
                                        $comments .= date("D M d ", strtotime($time_activity->created_at)) ." ".$time_activity->comments."\n";
                                        $timesheets[$i]['count'] = $counts;
                                        $timesheets[$i]['comments'] = $comments;
                                    }
                                    //$i++;
                                }
                            }
                                        
                        }else{
                            $query = DB::table('tasks');
                                $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                                $query->select('tasks.name', 'projects.name as project');
                                $query->where('tasks.id',$Timesheet->task_id);
                                if($request->project_id !=''){
                                    $query->where('projects.id',$request->project_id);
                                }
                            $data = $query->first();
                            $count = $query->count();
                            if($count>0){

                                $timesheets[$i]['date'] =  $from;
                                $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                                $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                                $hours = $Timesheet->hour+$hours;
                                $timesheets[$i]['hours'] = $hours;
                                $timesheets[$i]['count'] = $counts;
                                $timesheets[$i]['comments'] = $comments;


                                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                                    $counts = $time_activity->count+$counts;
                                    $comments .= date("D M d ", strtotime($time_activity->created_at)) ." ".$time_activity->comments."\n";
                                    $timesheets[$i]['count'] = $counts;
                                    $timesheets[$i]['comments'] = $comments;
                                }
                                //$i++;
                            }
                        }
                    }
                    $i++;
                }
                
            //}
        }

        // echo "<pre>";
        // print_r($timesheets);exit;
        $users = User::orderBy('name')->get();
        $projects = Project::get();

        return view('admin.timesheet.activity_monthly_report',compact('timesheets','from','to','users','projects','user_ids','project_id','options','month'));
    }
    
    public function createMonthlyPDF(Request $request) {
       $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }

        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        $month = date('m');
        if($request->month){
            $month = $request->month;
        }
        $data = array();
        $timesheets = array();
        $i=0;

       $month_array = $this->getStartAndEndDateofmonth($month,date("Y"));

        $from = $month_array['month_start'];
        $to = $month_array['month_end'];

        $user_ids =array();
        if($request->user_id1){
            $user_ids = $request->user_id1;
        }
        $project_id ='';
        if($request->project_id1 !=''){
            $project_id = $request->project_id1;
        }

        $users = User::orderBy('name')->get();
        
        foreach($users as $user){

            $tasks = DB::table('tasks')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->select('tasks.id')
                    ->whereRaw("find_in_set('".$user->id."',projects.user_id)")
                    ->get();
            foreach($tasks as $task){

                $Timesheets = Timesheet::where('user_id',$user->id)->where('task_id',$task->id)->whereBetween('date', [$from, $to])->orderBy('task_id', 'ASC')->get();

                $counts = 0;
                $hours = 0;
                $comments = '';
                foreach($Timesheets as $Timesheet){
                    if(count($user_ids)>0){
                        if(in_array($Timesheet->user_id, $user_ids)){
                            $query = DB::table('tasks');
                            $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                            $query->select('tasks.name', 'projects.name as project');
                            $query->where('tasks.id',$Timesheet->task_id);
                            if($request->project_id1 !=''){
                                $query->where('projects.id',$request->project_id1);
                            }
                            $data = $query->first();
                            $count = $query->count();
                            if($count>0){
                                $timesheets[$i]['to'] =$to;
                                $timesheets[$i]['from'] = $from;
                                $timesheets[$i]['date'] =  $from;
                                $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                                $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                                $hours = $Timesheet->hour+$hours;
                                $timesheets[$i]['hours'] = $hours;
                                $timesheets[$i]['count'] = $counts;
                                $timesheets[$i]['comments'] = $comments;


                                if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                                    $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                                    $counts = $time_activity->count+$counts;
                                    $comments .= date("D M d ", strtotime($time_activity->created_at)) ." ".$time_activity->comments."\n";
                                    $timesheets[$i]['count'] = $counts;
                                    $timesheets[$i]['comments'] = $comments;
                                }
                                //$i++;
                            }
                        }
                                    
                    }else{
                        $query = DB::table('tasks');
                            $query->join('projects', 'tasks.project_id', '=', 'projects.id');
                            $query->select('tasks.name', 'projects.name as project');
                            $query->where('tasks.id',$Timesheet->task_id);
                            if($request->project_id1 !=''){
                                $query->where('projects.id',$request->project_id1);
                            }
                        $data = $query->first();
                        $count = $query->count();
                        if($count>0){
                            $timesheets[$i]['to'] =$to;
                                $timesheets[$i]['from'] = $from;
                            $timesheets[$i]['date'] =  $from;
                            $timesheets[$i]['name'] = User::where('id',$Timesheet->user_id)->first()->name;
                            $timesheets[$i]['project'] = $data->project .' - '.$data->name;
                            $hours = $Timesheet->hour+$hours;
                            $timesheets[$i]['hours'] = $hours;
                            $timesheets[$i]['count'] = $counts;
                            $timesheets[$i]['comments'] = $comments;


                            if(Timesheetactivity::where('timesheet_id',$Timesheet->id)->count()){
                                $time_activity = Timesheetactivity::where('timesheet_id',$Timesheet->id)->first();
                                $counts = $time_activity->count+$counts;
                                $comments .= date("D M d ", strtotime($time_activity->created_at)) ." ".$time_activity->comments."\n";
                                $timesheets[$i]['count'] = $counts;
                                $timesheets[$i]['comments'] = $comments;
                            }
                            //$i++;
                        }
                    }
                }
                $i++;
            }
        }

        view()->share('timesheets',$timesheets ,$to ,$from);
        $pdf = PDF::loadView('admin.timesheet.timesheetmonthlypdf', $timesheets);
        return $pdf->download('Monthly_Task_Details_Report.pdf');
    }

    public function getToken(){
          $curl = curl_init();
          $params = array(
            CURLOPT_URL =>  ACCESS_TOKEN_URL."?"
                            ."code=".$code
                            ."&grant_type=authorization_code"
                            ."&client_id=". CLIENT_ID
                            ."&client_secret=". CLIENT_SECRET
                            ."&redirect_uri=". CALLBACK_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_NOBODY => false, 
            CURLOPT_HTTPHEADER => array(
              "cache-control: no-cache",
              "content-type: application/x-www-form-urlencoded",
              "accept: *",
              "accept-encoding: gzip, deflate",
            ),
          );
         
          curl_setopt_array($curl, $params);
         
          $response = curl_exec($curl);
          $err = curl_error($curl);
         
          curl_close($curl);
         
          if ($err) {
            echo "cURL Error #01: " . $err;
          } else {
            $response = json_decode($response, true);    
            if(array_key_exists("access_token", $response)) return $response;
            if(array_key_exists("error", $response)) echo $response["error_description"];
            echo "cURL Error #02: Something went wrong! Please contact admin.";
          }
        }

    public function tt(Request $request) {
       $code= $request->code;
       //echo($code);exit;
       $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://fhir.epic.com/interconnect-fhir-oauth/api/FHIR/R4/CarePlan?ID=eq081-VQEgP8drUUqCWzHfw3',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer '.$code.''
          ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }

    public function checkweekend($dt){
        $dt1 = strtotime($dt);
        $dt2 = date("l", $dt1);
        $dt3 = strtolower($dt2);
        if(($dt3 == "saturday" )|| ($dt3 == "sunday")){
                return 1;
        }else{
                return 0;
        }
    }

    public function getleave($user_id){
        $Onleave = Leave::where('user_id',11)->whereBetween('from', ['2023-02-01', '2023-02-29'])->sum('duration');
    }

    public function addlogouttime(Request $request)
    {
        $id = $request->id;
        $time = $request->time;

        $get_d =  Attendanceday::where('id',$id)->first();
        $total_break_time = 0;

        $count = Attendanceday::where('employee_id',$get_d->employee_id)->where('date',$get_d->date)->where('login_time','00:00:00')->groupBy('date', 'employee_id')->count();
        if($count>0){
            $total_break_time =  Attendanceday::select( DB::raw('sum(total_hours) as total_hours'))->where('employee_id',$get_d->employee_id)->where('date',$get_d->date)->where('login_time','00:00:00')->groupBy('date', 'employee_id')->first()->total_hours;
        }

        $time1 = new DateTime($get_d->login_time);
        $time2 = new DateTime($time);
        $time_diff = $time1->diff($time2);
        $seconds = $time_diff->days * 24 * 60 * 60;
        $seconds += $time_diff->h * 60 * 60;
        $seconds += $time_diff->i * 60;
        $seconds += $time_diff->s;
        $hours =$seconds;

        $hourss = $hours - $total_break_time;
        $data['total_break_time']= $total_break_time;
        $data['total_hours']= $hourss;
        $data['logout_time']=$time;

        Attendanceday::where('id',$id)->update($data);
        return 1;
    }

    public function timemanagement(){
        $user_id = Auth::user()->id;
        $admin_role = Auth::user()->role;
        $data=[
            'title'=>'Dashboard'
        ];

        $on_leave=0;
        $Onleave = Leave::where('user_id',$user_id)->whereDate('from' ,'<=', date('Y-m-d'))->whereDate('to', '>=', date('Y-m-d'))->where('duration','!=',0.5)->count();
        if($Onleave>0){
            $on_leave=1;
        }
        
        $login =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->count();
        $is_login = 0;
        $login_time = '';
        $login_in_time ='';
        if($login>0){
            $login =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->first();

            $login_in_time =  strtotime($login->login_time);
            $login_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$login_in_time).' '.date_default_timezone_get();
            $is_login = 1;
        }


        $logout =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->count();
        $is_logout = 0;
        $logout_time = '';
        if($logout>0){
            $logout =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->first();

            $logout_in_time =  strtotime($logout->logout_time);
            $logout_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$logout_in_time).' '.date_default_timezone_get();
            $is_logout = 1;
        }

        $break =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->where('break_out','==','00:00:00')->orderBy('id','DESC')->count();
        $is_break = 0;
        $break_in_time ='';
        $break_id = 0;

        if($break>0){
            $break =  Attendanceday::where('employee_id',$user_id)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->where('break_out','==','00:00:00')->orderBy('id','DESC')->first();

            $is_break = 1;
            $break_id = $break->id;
            $break_time =  strtotime($break->break_in);
            $break_in_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$break_time).' '.date_default_timezone_get();

        }

        $is_breakout = 0;
        $break_out_time = '';
        if($break_id !=0){
            $break_out =  Attendanceday::where('id',$break_id)->where('break_out','!=','00:00:00')->count();
            if($break_out>0){
                $break_out =  Attendanceday::where('id',$break_id)->where('break_out','!=','00:00:00')->first();
                $is_breakout = 1;
                //$is_break = 1;
                $break_time =  strtotime($break_out->break_in);
                $break_in_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$break_time).' '.date_default_timezone_get();
                $break_in_out_time =  strtotime($break_out->break_out);
                $break_out_time = date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('H:i:a',$break_in_out_time).' '.date_default_timezone_get();
            }
        }

        $users = User::orderBy('name','ASC')->get();
        $datas = array();
        $i=0;
        foreach($users as $user){
            $uid = $user->id;
            $is_leave=0;
            //$leave = Leave::where('user_id',$uid)->where('from',date('Y-m-d'))->count();
            $leave = Leave::where('user_id',$uid)->whereDate('from' ,'<=', date('Y-m-d'))->whereDate('to', '>=', date('Y-m-d'))->count();
            if($leave>0){
                $is_leave=1;
            }
            $login1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->count();
            $is_login1 = 0;
            $login_time1 = '';
            if($login1>0){
                $login1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('login_time','!=','00:00:00')->orderBy('id','DESC')->first();

                $login_in_time1 =  strtotime($login1->login_time);
                $login_time1 = date('H:i:a',$login_in_time1);
                //$login_time1 = $login1->login_time;
                $is_login1 = 1;
            }

            $logout1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->count();
            $is_logout1 = 0;
            $logout_time1 = '';
            if($logout1>0){
                $logout1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('logout_time','!=','00:00:00')->orderBy('id','DESC')->first();

                $logout_in_time1 =  strtotime($logout1->logout_time);
                $logout_time1 = date('H:i:a',$logout_in_time1);
                $is_logout1 = 1;
            }

            $break1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->count();
            $is_break1 = 0;
            $break_in_time1 ='';
            $break_id1 = 0;

            if($break1>0){
                $break1 =  Attendanceday::where('employee_id',$uid)->where('date',date('Y-m-d'))->where('break_in','!=','00:00:00')->orderBy('id','DESC')->first();

                $is_break1 = 1;
                $break_id1 = $break1->id;
                $break_time1 =  strtotime($break1->break_in);
                $break_in_time1 = date('H:i:a',$break_time1);
            }

            $is_breakout1 = 0;
            $break_out_time1 = '';
            if($break_id1 !=0){
                    $break_out1 =  Attendanceday::where('id',$break_id1)->where('date',date('Y-m-d'))->where('break_out','!=','00:00:00')->count();
                if($break_out1>0){
                    $break_out1 =  Attendanceday::where('id',$break_id1)->where('date',date('Y-m-d'))->where('break_out','!=','00:00:00')->first();
                    $is_breakout1 = 1;
                    $break_in_out_time1 =  strtotime($break_out1->break_out);
                    $break_out_time1 = date('H:i:a',$break_in_out_time1);
                }
            }
            $datas[$i]['user_id'] = $user->name.' '.$user->last_name;
            $datas[$i]['is_leave'] = $is_leave;
            $datas[$i]['is_login1'] = $is_login1;
            $datas[$i]['login_time1'] = $login_time1;
            $datas[$i]['is_break1'] = $is_break1;
            $datas[$i]['break_in_time1'] = $break_in_time1;
            $datas[$i]['is_breakout1'] = $is_breakout1;
            $datas[$i]['break_out_time1'] = $break_out_time1;
            $datas[$i]['is_logout1'] = $is_logout1;
            $datas[$i]['logout_time1'] = $logout_time1;
            $i++;
        }
            //$login_in_time = $login_in_time*1000;
        return view('admin.timemanagement.index',$data,compact('is_login','login_time','is_break','break_in_time','is_breakout','break_out_time','is_logout','logout_time','datas','on_leave','login_in_time'));
    }
}

// https://www.athenahealth.com/developer-portal