<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Attendanceday;
use App\Models\Holiday;
use App\Models\Month;
use App\Models\Leave;
use Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDF;
use DateTime;
class AttendanceController extends Controller
{
    public function index(Request $request){
        $id = Auth::user()->id;
        if ($request->emp_id != null && $request->month != null) {
            $empid = $request->emp_id;
            $m_day = $request->month;
            $y_day = date('Y');
            $users = User::where('id','!=',1)->where('login_status',1)->get();
            $months1 = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get();
            foreach($holiday as $row1){
        	   $returnArray1[] = $row1;
            }
            if(!empty($returnArray1)){
                $holi_names = array_column($returnArray1, 'day');
                $json_holi_result = json_encode($holi_names);
            }else{
                $holi_names ='';
                $json_holi_result = '';
            }
            $month_day_count = $months1->count();
            //   $emplist = Attendanceday::distinct()->get(['employee_id']);
            $emplist = Attendanceday::where('employee_id',$empid)->distinct()->get(['employee_id']);
        }elseif ($request->emp_id == '' && $request->month != null) {
            $empid = $request->emp_id;
            $m_day = $request->month;
            $y_day = date('Y');
            $users = User::where('id','!=',1)->where('login_status',1)->get();
            $months1 = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get();
            foreach($holiday as $row1){
        	   $returnArray1[] = $row1;
            }
            if(!empty($returnArray1)){
                $holi_names = array_column($returnArray1, 'day');
                $json_holi_result = json_encode($holi_names);
            }else{
                $holi_names ='';
                $json_holi_result = '';
            }
            $month_day_count = $months1->count();
            $emplist = Attendanceday::distinct()->get(['employee_id']);
        }else{
            $m_day = date('m');
            $y_day = date('Y');
            $empid = '';

            $users = User::where('id','!=',1)->where('login_status',1)->get();
            $months1 = Month::where('month',date('m'))->orderBy('day','ASC')->get();
            $holiday = Holiday::where('month',date('m'))->where('year',date('Y'))->orderBy('day','ASC')->get(); 
            foreach($holiday as $row1){
                $returnArray1[] = $row1;
            }
            if(!empty($returnArray1)){
                $holi_names = array_column($returnArray1, 'day');
                $json_holi_result = json_encode($holi_names);
            }else{
                $holi_names ='';
                $json_holi_result = '';
            }
            $month_day_count = $months1->count();
            $emplist = Attendanceday::distinct()->get(['employee_id']);
        }
        $holidays = array();
        $i = 0;
        foreach($holiday as $row1){
            $holidays[$i] = $row1->date;
            $i++;
        }
        $dateObj   = DateTime::createFromFormat('!m', $m_day);
        $monthName = $dateObj->format('F');
        $months = array();
        foreach ($months1 as $key => $value) {
            $months[$key] = $value;
        }
        if($y_day % 4 !=0){
            if($m_day == 2){
                unset($months[28]);
            }
        }
        $month_day_count = count($months);
        return view('admin.attendance/index', compact('users','emplist','months','month_day_count','holiday','json_holi_result','m_day','y_day','empid','holidays','monthName'));
    } 

    public function employee_att(Request $request){
       
        if ($request->month != null && $request->year != null) {
            $m_day = $request->month;
            $y_day = $request->year;
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get(); 
            $userlist = Attendanceday::select('day')->where('employee_id', Auth::user()->id)->where('year', $y_day)->where('month', $m_day)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = '';
            }
        }else{
            $m_day = date('m');
            $y_day = date('Y');
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get();
            $userlist = Attendanceday::select('day')->where('employee_id', Auth::user()->id)->where('year', $y_day)->where('month', $m_day)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = '';
            }
        }
        return view('admin.attendance/employee_att', compact('users','months','json_result','month_day_count','month_day_attendance','userlist','holiday','m_day','y_day'));
    }

    public function employee_hour_att(Request $request){

        if ($request->month != null && $request->year != null) {
            $m_day = $request->month;
            $y_day = $request->year;
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get();
            $userlist = Attendanceday::select('day')->where('employee_id', Auth::user()->id)->where('year', $y_day)->where('month', $m_day)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = '';
            }
        }else{
            $m_day = date('m');
            $y_day = date('Y');
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get();
            $userlist = Attendanceday::select('day')->where('employee_id', Auth::user()->id)->where('year', $y_day)->where('month', $m_day)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = '';
            }
        }
        return view('admin.attendance/employee_hour_att', compact('users','months','json_result','month_day_count','month_day_attendance','userlist','holiday','m_day','y_day'));
    }

    public function employee_att_details(Request $request,$id){
        $employee_id = $id;
        $emp_att = Attendanceday::where('employee_id',$id)->where('month',date('m'))->where('year',date('Y'))->orderBy('date','DESC')->get();
        // dd($emp_att);
        $present_att = Attendanceday::where('employee_id',$id)->where('month',date('m'))->where('year',date('Y'))->count();
        $late_att = Attendanceday::where('employee_id',$id)->where('month',date('m'))->where('year',date('Y'))->where('late','Yes')->count();
        $holiday_att = Holiday::where('month',date('m'))->where('year',date('Y'))->count();
        // dd(date('t'));
        $users = User::whereIsAdmin('0')->get();
        return view('admin.attendance/employee_att_details',compact('emp_att','present_att','late_att','holiday_att','employee_id','users'));
    }

    // public function all_employee_hour_attendance(){
       
    //       $users = User::whereIsAdmin('0')->get();
    //       $months = Month::where('month',date('m'))->orderBy('day','ASC')->get(); 
    //       $holiday = Holiday::where('month',date('m'))->where('year',date('Y'))->orderBy('day','ASC')->get(); 
    //       $month_day_count = $months->count();
    //       $emplist = Attendanceday::distinct()->get(['employee_id']);
        
    //      return view('admin.attendance/all_employee_hour_attendance', compact('users','emplist','months','month_day_count','holiday'));
        
    // }

    public function all_employee_hour_attendance(Request $request){

        if ($request->emp_id != null && $request->month != null && $request->year != null) {
            $empid = $request->emp_id;
            $m_day = $request->month;
            $y_day = $request->year;
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get(); 
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $emplist = Attendanceday::where('employee_id',$empid)->distinct()->get(['employee_id']);
        }else if ($request->emp_id == '' && $request->month != null && $request->year != null) {
            $empid = $request->emp_id;
            $m_day = $request->month;
            $y_day = $request->year;
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get(); 
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $emplist = Attendanceday::distinct()->get(['employee_id']);
        }else{
            $m_day = date('m');
            $y_day = date('Y');
            $empid = '';
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',date('m'))->orderBy('day','ASC')->get(); 
            $holiday = Holiday::where('month',date('m'))->where('year',date('Y'))->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $emplist = Attendanceday::distinct()->get(['employee_id']);
        }
        return view('admin.attendance/all_employee_hour_attendance', compact('users','emplist','months','month_day_count','holiday','m_day','y_day','empid'));
    }

    public function employee_hour_attendance(Request $request,$id){
        if ($request->month != null && $request->year != null) {
            $m_day = $request->month;
            $y_day = $request->year;
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get(); 
            $month_day_count = $months->count();
            $userlist = Attendanceday::select('day')->where('employee_id', $id)->where('year', $y_day)->where('month', $m_day)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = '';
            }
        }else{
            $m_day = date('m');
            $y_day = date('Y');
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $userlist = Attendanceday::select('day')->where('employee_id', $id)->where('year', $y_day)->where('month', $m_day)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = '';
            }
        }
        return view('admin.attendance/employee_hour_attendance', compact('users','months','json_result','month_day_count','month_day_attendance','userlist','m_day','y_day'));
    }

    public function employee_calendar_attendance(Request $request,$id){
        if ($request->month != null && $request->year != null) {
            $m_day = $request->month;
            $y_day = $request->year;
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $userlist = Attendanceday::select('day')->where('employee_id', $id)->where('year', $y_day)->where('month', $m_day)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = '';
            }
        }else{
            $m_day = date('m');
            $y_day = date('Y');
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $userlist = Attendanceday::select('day')->where('employee_id', $id)->where('year', $y_day)->where('month', $m_day)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = '';
            }
        }
        return view('admin.attendance/employee_calendar_attendance', compact('users','months','json_result','month_day_count','month_day_attendance','userlist','m_day','y_day'));
    }

    //public function create_attendance(){

        //return view('admin.attendance/create');
    // }

    public function employee_attendance(Request $request,$id){
        $employee_id = $id;
        $emp_att = Attendanceday::where('employee_id',$id)->where('month',date('m'))->where('year',date('Y'))->orderBy('date','DESC')->get(); 
        // dd($emp_att);
        $present_att = Attendanceday::where('employee_id',$id)->where('month',date('m'))->where('year',date('Y'))->count();
        $late_att = Attendanceday::where('employee_id',$id)->where('month',date('m'))->where('year',date('Y'))->where('late','Yes')->count();
        $holiday_att = Holiday::where('month',date('m'))->where('year',date('Y'))->where('created_at','<=',date("Y-m-d"))->count();
        $users = User::whereIsAdmin('0')->get();
        return view('admin.attendance/employee_attendance',compact('emp_att','present_att','late_att','holiday_att','employee_id','users'));
    }

    public function search_attendance(Request $request){
        $smonth = $request->month;
        $syear = $request->year;
        if(!empty($smonth) && !empty($syear)){
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$smonth)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $userlist = Attendanceday::select('day')->where('employee_id', Auth::user()->id)->where('year', $syear)->where('month', $smonth)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = '';
            }
            return view('admin.attendance/index', compact('users','months','json_result','month_day_count','month_day_attendance','smonth','syear')); 
        }elseif(!empty($smonth) && !empty($syear)){
            $users = User::whereIsAdmin('0')->get();
            $months = Month::where('month',$smonth)->orderBy('day','ASC')->get();
            $month_day_count = $months->count();
            $userlist = Attendanceday::select('day')->where('employee_id', Auth::user()->id)->where('year', $syear)->where('month', $smonth)->get();
            $month_day_attendance = $userlist->count();
            foreach($userlist as $row){
                $returnArray[] = $row;
            }
            if(!empty($returnArray)){
                $last_names = array_column($returnArray, 'day');
                $json_result = json_encode($last_names);
            }else{
                $last_names ='';
                $json_result = ''; 
            }
            return view('admin.attendance/index', compact('users','months','json_result','month_day_count','month_day_attendance','smonth','syear')); 
        }
    }

    public function holiday_list(){
        $holiday_list = Holiday::orderBy('date','ASC')->get(); 
        return view('admin.attendance.holiday_list',compact('holiday_list'));
    }
    
    public function create_holiday(){
        return view('admin.attendance.create_holiday');
    } 

    public function store_holiday(Request $request){
        $data = array();
        for ($x = 0; $x < count($request->date); $x ++) {
            $data['date']= $request->date[$x];
            $data['day']= date('d',strtotime($request->date[$x]));
            $data['month']= date('m',strtotime($request->date[$x]));
            $data['year']= date('Y',strtotime($request->date[$x]));
            $data['occasion']= $request->occasion[$x];
            Holiday::create($data);
        }
        return redirect()->route('holiday_list')->with('success','Holiday Has Been Added successfully');
    }

    public function edit_holiday(Request $request,$id)
    {
        $holiday_edit = Holiday::where('id',$id)->first(); 
        return view('admin.attendance.edit_holiday',compact('holiday_edit'));
    }

    public function update_holiday(Request $request,$id){
        $data = array();
        $data['date']= $request->date;
        $data['day']= date('d',strtotime($request->date));
        $data['month']= date('m',strtotime($request->date));
        $data['year']= date('Y',strtotime($request->date));
        $data['occasion']= $request->occasion;
        Holiday::where('id',$id)->update($data);
        return redirect()->route('holiday_list')->with('success','Holiday Has Been Updated successfully');
    }

    public function delete_holiday($id){
        $category = Holiday::where('id',$id)->delete();
        return redirect()->route('holiday_list');
    }

    public function leave_list(){
        $leave_list = Leave::where('user_id',Auth::user()->id)->orderBy('from','ASC')->get(); 
        return view('admin.attendance.leave_list',compact('leave_list'));
    }

    public function create_leave(){
        return view('admin.attendance.create_leave');
    } 

    public function getWorkingDays($startDate,$endDate){
        // do strtotime calculations just once
        $endDate = strtotime($endDate);
        $startDate = strtotime($startDate);

        $days = ($endDate - $startDate) / 86400 + 1;

        $no_full_weeks = floor($days / 7);
        $no_remaining_days = fmod($days, 7);

        //It will return 1 if it's Monday,.. ,7 for Sunday
        $the_first_day_of_week = date("N", $startDate);
        $the_last_day_of_week = date("N", $endDate);

        //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
        //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
        if ($the_first_day_of_week <= $the_last_day_of_week) {
            if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
            if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
        }
        else {
            // (edit by Tokes to fix an edge case where the start day was a Sunday
            // and the end day was NOT a Saturday)

            // the day of the week for start is later than the day of the week for end
            if ($the_first_day_of_week == 7) {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $no_remaining_days--;

                if ($the_last_day_of_week == 6) {
                    // if the end date is a Saturday, then we subtract another day
                    $no_remaining_days--;
                }
            }
            else {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $no_remaining_days -= 2;
            }
        }

        //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
        //---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
       $workingDays = $no_full_weeks * 5;
        if ($no_remaining_days > 0 )
        {
          $workingDays += $no_remaining_days;
        }
        return round($workingDays);
    }

    public function store_leave(Request $request){
        $data = array();
        $data['user_id']=Auth::user()->id;
        $data['from']= $request->from;
        $data['to']= $request->to;
        $data['occasion']= $request->occasion;
        $data['duration']= $request->duration;
        $date1=date_create($request->from);
        $date2=date_create($request->to);
        $diff=date_diff($date1,$date2);
        $dd= $diff->format("%a");

       if($request->from != $request->to){

        $total_leave = $this->getWorkingDays($request->from,$request->to);
        $holidays = Holiday::whereBetween('date', [$request->from, $request->to])->count();
        $data['duration'] = $total_leave-$holidays;
            /*$today = strtotime($request->from);
            $wday = date('w', $today);   
            $datesat = date('Y-m-d', $today - ($wday - 6)*86400);
            $datesun = date('Y-m-d', $today - ($wday - 7)*86400);

            if (($datesat >= $request->from) && ($datesat <= $request->to)){
                $dd = $dd-2;
            }

            $holiday = Holiday::whereBetween('date', [$request->from, $request->to])->count();

            if($holiday>0){
              $dd= $dd-$holiday;
            }
            if ($request->from != $request->to) {
                $data['duration']=$dd+1;
            }else{
                $data['duration']=1;
            }*/
        }
        Leave::create($data);
        return redirect()->route('leave_list')->with('success','Leave Has Been Added successfully');
    }

    public function edit_leave(Request $request,$id)
    {
        $leave_edit = Leave::where('id',$id)->first(); 
        return view('admin.attendance.leave_edit',compact('leave_edit'));
    }

    public function update_leave(Request $request,$id){
        $data = array();
        $data['user_id']=Auth::user()->id;
        $data['from']= $request->from;
        $data['to']= $request->to;
        $data['occasion']= $request->occasion;
        $data['duration']= $request->duration;
        $date1=date_create($request->from);
        $date2=date_create($request->to);
        $diff=date_diff($date1,$date2);
        $dd= $diff->format("%a");
        if($request->from != $request->to){
            $total_leave = $this->getWorkingDays($request->from,$request->to);
            $holidays = Holiday::whereBetween('date', [$request->from, $request->to])->count();
            $data['duration'] = $total_leave-$holidays;
        }
        Leave::where('id',$id)->update($data);
        return redirect()->route('leave_list')->with('success','Holiday Has Been Updated successfully');
    }

    public function delete_leave($id){
        $category = Leave::where('id',$id)->delete();
        return redirect()->route('leave_list');
    }

    public function leave_all(){
        $user = User::get();
        $leave_list = Leave::orderBy('from','ASC')->get(); 
        return view('admin.attendance.leave_all',compact('leave_list','user'));
    }

    public function create_all_leave(){
        $user = User::orderBy('name','ASC')->get();
        return view('admin.attendance.create_all_leave',compact('user'));
    }

    public function store_all_leave(Request $request){
        $data = array();
        $data['user_id']=$request->user_id;
        $data['from']= $request->from;
        $data['to']= $request->to;
        $data['occasion']= $request->occasion;
        $data['duration']= $request->duration;
        $date1=date_create($request->from);
        $date2=date_create($request->to);
        $diff=date_diff($date1,$date2);
        $dd= $diff->format("%a");
        if($request->from != $request->to){
            $total_leave = $this->getWorkingDays($request->from,$request->to);
            $holidays = Holiday::whereBetween('date', [$request->from, $request->to])->count();
            $data['duration'] = $total_leave-$holidays;
        }
        Leave::create($data);
        return redirect()->route('leave_all');
    }

    public function edit_all_leave(Request $request,$id)
    {
        $user = User::get();
        $leave_edit = Leave::where('id',$id)->first();
        return view('admin.attendance.leave_all_edit',compact('leave_edit','user'));
    }

    public function update_all_leave(Request $request,$id){
        $data = array();
        $data['from']= $request->from;
        $data['to']= $request->to;
        $data['occasion']= $request->occasion;
        $data['status']= $request->status;
        $data['duration']= $request->duration;
        if($request->from != $request->to){
            $total_leave = $this->getWorkingDays($request->from,$request->to);
            $holidays = Holiday::whereBetween('date', [$request->from, $request->to])->count();
            $data['duration'] = $total_leave-$holidays;
        }
        Leave::where('id',$id)->update($data);
        $user = User::get();
        $leave_list = Leave::orderBy('id','DESC')->get(); 
        return view('admin.attendance.leave_all',compact('leave_list','user'));
    }

    public function createMonthlyAttendencePDF(Request $request){
        $id = Auth::user()->id;
        if ($request->emp_id != null && $request->month != null) {
            $empid = $request->emp_id;
            $m_day = $request->month;
            $y_day = date('Y');
            $users = User::where('id','!=',1)->get();
            $months1 = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get();
            foreach($holiday as $row1){
               $returnArray1[] = $row1;
            }
            if(!empty($returnArray1)){
                $holi_names = array_column($returnArray1, 'day');
                $json_holi_result = json_encode($holi_names);
            }else{
                $holi_names ='';
                $json_holi_result = '';
            }
            $month_day_count = $months1->count();
            //   $emplist = Attendanceday::distinct()->get(['employee_id']);
            $emplist = Attendanceday::where('employee_id',$empid)->distinct()->get(['employee_id']);
        }elseif ($request->emp_id == '' && $request->month != null) {
            $empid = $request->emp_id;
            $m_day = $request->month;
            $y_day = date('Y');
            $users = User::where('id','!=',1)->get();
            $months1 = Month::where('month',$m_day)->orderBy('day','ASC')->get();
            $holiday = Holiday::where('month',$m_day)->where('year',$y_day)->orderBy('day','ASC')->get();
            foreach($holiday as $row1){
               $returnArray1[] = $row1;
            }
            if(!empty($returnArray1)){
                $holi_names = array_column($returnArray1, 'day');
                $json_holi_result = json_encode($holi_names);
            }else{
                $holi_names ='';
                $json_holi_result = '';
            }
            $month_day_count = $months1->count();
            $emplist = Attendanceday::distinct()->get(['employee_id']);
        }else{
            $m_day = date('m');
            $y_day = date('Y');
            $empid = '';

            $users = User::where('id','!=',1)->get();
            $months1 = Month::where('month',date('m'))->orderBy('day','ASC')->get();
            $holiday = Holiday::where('month',date('m'))->where('year',date('Y'))->orderBy('day','ASC')->get(); 
            foreach($holiday as $row1){
                $returnArray1[] = $row1;
            }
            if(!empty($returnArray1)){
                $holi_names = array_column($returnArray1, 'day');
                $json_holi_result = json_encode($holi_names);
            }else{
                $holi_names ='';
                $json_holi_result = '';
            }
            $month_day_count = $months1->count();
            $emplist = Attendanceday::distinct()->get(['employee_id']);
            }

        foreach ($months1 as $key => $value) {
            $months[$key] = $value;
        }
        if($y_day % 4 !=0){
            if($m_day == 2){
                unset($months[28]);
            }
        }
        $month_day_count = count($months);

        $dateObj   = DateTime::createFromFormat('!m', $m_day);
        $monthName = $dateObj->format('F');
        $data = array();
        $data['emplist']= $emplist;
        $data['users'] = $users;
        $data['months'] = $months;
        $data['m_day'] = $m_day;
        $data['y_day'] = $y_day;
        $data['month_day_count'] = $month_day_count;
        $data['holiday'] = $holiday;
        $data['json_holi_result'] = $json_holi_result;
        $data['empid'] = $empid;
        $data['holidays'] = $holiday;
        $data['monthName'] = $monthName;
        $data['y_day'] = $y_day;

        view()->share('data',$data);
        $pdf = PDF::loadView('admin.attendance.monthlypdf', $data)->setPaper('legal', 'landscape');
        return $pdf->download('Monthly_Attence_Report.pdf');
    } 
}