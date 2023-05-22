<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Auth;
 
class Timesheet extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'timesheets';

    protected $guarded = ['id','created_at'];

}