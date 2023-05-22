<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Auth;
 
class Userpermission extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_permissions';

    protected $guarded = ['id','created_at'];

    function get_permission($codename ,$is_permission)
    {
        $user_id = Auth::user()->id;
        $users = User::where('id',$user_id)->first();
        $role_id = $users->role;
        $permission = Permission::where('codename',$codename)->first();
        $permission_id = $permission->permission_id ;
        $count = Userpermission::where('role_id',$role_id)->Where('permission_id', $permission_id)->Where($is_permission, 1)->count();
        if($count>0){
            return 1;
        }else{
            return 0;
        }
    }
}