<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Auth;
 
class Timesheetactivity extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'timesheet_activity';

    protected $guarded = ['id','created_at'];

}