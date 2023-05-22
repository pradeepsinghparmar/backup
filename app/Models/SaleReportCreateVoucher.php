<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class SaleReportCreateVoucher extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sale_report_create_voucher_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
