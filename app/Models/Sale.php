<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Sale extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'today_sale_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
