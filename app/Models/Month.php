<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Month extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'month_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
