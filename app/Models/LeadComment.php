<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class LeadComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lead_comments';

    protected $guarded = ['id','created_at'];

}