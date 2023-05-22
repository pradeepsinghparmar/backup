<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'role';
    
    protected $guarded = ['role_id','created_at'];
    
    
}
