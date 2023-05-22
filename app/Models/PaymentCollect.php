<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class PaymentCollect extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_collect_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
