<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class ContactAdmin extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_to_admin_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
