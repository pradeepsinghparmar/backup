<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Notification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'push_noti_message_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
