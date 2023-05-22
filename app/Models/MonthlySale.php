<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class MonthlySale extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'monthly_sale_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
