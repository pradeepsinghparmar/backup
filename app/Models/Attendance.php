<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Attendance extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendance_tbl';
    
    protected $guarded = ['id','created_at'];
    
    // function getAllAttendance($year,$month)
    // {
    //      DB::table("attendance_tbl")->select('attendance_tbl.*',
    //     DB::raw('GROUP_CONCAT(mark_attendance_by ORDER BY date) as atten'),
    //     DB::raw('GROUP_CONCAT(date ORDER BY date) as date_att')
    // )->where('year', '=', $year)
    // ->where('month', '=', $month)
    // ->groupBy('employee_id')
    // ->orderBy('date', 'ASC')
    // ->get();
    // }
    
    // public function monthwiseemployeereport($month,$year,$empp_id) { 
    //      $employeeattendanceviewlist = DB::table('attendance_tbl')
    //             ->select('attendance_tbl.date','attendance_tbl.employee_id')
    //             ->where('attendance_tbl.month','=',$month)                 
    //             ->where('attendance_tbl.year','=',$year)   
    //             ->where('attendance_tbl.employee_id','=',$empp_id) 
    //             ->orderBy('date','ASC')
    //             ->get();
    //             foreach ($employeeattendanceviewlist as $empattendanceviewlist1) {
    //                 $empattendanceviewlist1->mark_attendance_by = date('d',strtotime($empattendanceviewlist1->date));
    //                 $employeeattendanceviewlistt = $empattendanceviewlist1;
    //             }
    //             return json_encode($employeeattendanceviewlist);
      
    // }
    
}
