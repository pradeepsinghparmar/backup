<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Taskassign extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_assignment';

    protected $guarded = ['id','created_at'];

}