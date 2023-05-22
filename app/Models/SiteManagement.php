<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class SiteManagement extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'location_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
