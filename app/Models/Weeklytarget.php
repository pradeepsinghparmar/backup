<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Weeklytarget extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weekly_target';
    
    protected $guarded = ['id','created_at'];   
}