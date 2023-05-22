<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class State extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'states';
    
    protected $guarded = ['id','created_at'];
    
}