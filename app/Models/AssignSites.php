<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class AssignSites extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assign_sites_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
