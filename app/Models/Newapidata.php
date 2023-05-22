<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Newapidata extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'new_api_details_tbl';
    
    protected $guarded = ['id','created_at'];
    
    
}
