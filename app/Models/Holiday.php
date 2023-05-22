<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Holiday extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'holiday_table';

    protected $guarded = ['id','created_at'];

}