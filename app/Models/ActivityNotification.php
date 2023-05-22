<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class ActivityNotification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_notification';
    
    protected $guarded = ['id','created_at'];
    
    
}
