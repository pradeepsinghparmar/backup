<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Attendanceday extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendance_day';
    
    protected $guarded = ['id','created_at'];
    
}