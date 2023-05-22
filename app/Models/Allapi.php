<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Allapi extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'all_api_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
