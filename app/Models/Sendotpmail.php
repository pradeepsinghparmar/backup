<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Sendotpmail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'verify_email_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
