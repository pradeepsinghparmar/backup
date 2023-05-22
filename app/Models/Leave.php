<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Leave extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leave_table';

    protected $guarded = ['id','created_at'];

}