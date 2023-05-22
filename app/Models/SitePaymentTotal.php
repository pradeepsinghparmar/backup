<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class SitePaymentTotal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_total_payment_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
