<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Pmt extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pmts';
    
    protected $guarded = ['id','created_at'];
    
}