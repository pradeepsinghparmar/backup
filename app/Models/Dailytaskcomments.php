<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Dailytaskcomments extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dailytaskcomments';
    
    protected $guarded = ['id','created_at'];
    
}