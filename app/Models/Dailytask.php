<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Dailytask extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily_task';

    protected $guarded = ['id','created_at'];

}