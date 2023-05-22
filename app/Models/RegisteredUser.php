<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class RegisteredUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registered_user_tbl';
    
    protected $guarded = ['id','created_at'];
    
}
