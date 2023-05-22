<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class AccessSites extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'access_site_tbl';
    
    protected $guarded = ['id','created_at'];
    
    public function getAssignSites($user_id) {
            return DB::table('access_site_tbl')
                ->join('all_api_tbl', 'access_site_tbl.site_id', '=', 'all_api_tbl.id')
                ->select('access_site_tbl.user_id','all_api_tbl.name','all_api_tbl.site_id_name')
                ->where('access_site_tbl.user_id',$user_id)
                ->get();
        }
}
