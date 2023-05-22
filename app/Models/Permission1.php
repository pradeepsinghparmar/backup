<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission1;
use Auth;
class Permission1 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission1';
    
    protected $guarded = ['permission_id','created_at'];
    
    function admin_permission($codename)
    {
        $admin_id = Auth::user()->id;
        $admin = User::where('id',$admin_id)->first();
       
        $permission_obj = Permission1::where('codename',$codename)->first();
        
        $permission = $permission_obj != null && isset($permission_obj->permission_id) ? $permission_obj->permission_id : 0;
       
        if ($admin->role == 1) {
            return true;
        } else {
            $role = $admin->role;
            
            // $role_p = Role::select('permission')->where('role_id',$role)->first();
            $role_p = Permission1::get_type_name_by_id($role,'permission');
           
            $role_permissions = json_decode($role_p);
            //  dd($role_permissions);
            // if (is_array($permission) && in_array($role_permissions, $permission)) {
            //     return true;
            // }else{
            //     return false;
            // }
            if (in_array($permission, $role_permissions)) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    function get_type_name_by_id($type_id,$field)
    {
        if ($type_id != '') {
            // $l = $this->db->get_where($type, array(
            //     $type . '_id' => $type_id
            // ));
            $l = Role::where('role_id',$type_id)->first();
            $n = $l->count();
            // dd($n);
            if ($n > 0) {
                return $l->$field;
            }
        }
    }
}
