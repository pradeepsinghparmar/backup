<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\Project;
use App\Models\Task;
use App\Models\Permission;
use App\Models\Userpermission;
use App\Models\Attendance;
use App\Models\Allapi;
use App\Models\Group;
use App\Models\State;
use App\Models\RegisteredUser;
use App\Models\Dailytask;
use App\Models\Taskassign;
use App\Models\Leave;
use App\Models\Attendanceday;
use App\Models\Pmt;
use App\Models\Weeklytarget;
use App\Models\Dailytaskcomments;
use App\Models\Contact;
use App\Models\LeadComment;
use App\Mail\VerifyMail;
use App\Models\Event;
use PDF;
use DateTime;
use Hash;
use Mail;
use Auth;
class UserController extends Controller
{
    public function index(){
        $users = User::whereIsAdmin('0')->get();
        return view('admin.user_list', compact('users'));
    }

    public function delete_user($id){
        $user = User::find($id);
        $user->delete();
        return redirect()->route('user.index');
    }

    public function create_employee(Request $request){
        $groups = Group::get();
        $role = Role::where('role_status', '1')->orderBy('role_id', 'DESC')->get();
        return view('admin.employee.create',compact('role','groups'));
    }

    public function employee_list(Request $request){
        $staff = User::orderBy('name','ASC')->where('id','!=',1)->get();
        $groups = Group::get();
        $role = Role::where('role_status', '1')->orderBy('role_id', 'DESC')->get();
        return view('admin.employee.index', compact('staff','role','groups'));
    }

    public function store_employee(Request $request){
        $ph = $request->country_code.$request->phone;
        $message = '';
        $error = 0;
        if (User::where('email', $request->email)->exists()) {
            $message .= 'Email id already registrated. ';
            $error = 1;
        }
        if(User::Where('phone', $ph)->exists()){
            $message .= 'Phone No. already registrated.';
            $error = 1;
        }
        if($error == 1){
            return redirect()->route('create_employee')->with('error',$message);
        }else{
            $data = array();
            $data['name']= $request->name;
            $data['last_name']= $request->last_name;
            $data['email']= $request->email;
            $data['phone']= $ph;
            $data['employee_type']= $request->employee_type;
            $data['password']= Hash::make($request->password);
            $data['hourly_rate']= $request->hourly_rate;
            $data['salary']= $request->salary;
            $data['role']= $request->role;
            $data['group_id']= $request->group_id;
            $data['login_status']= '1';
            $data['is_dashboard'] = $request->is_dashboard;
            $data['is_ideaboard'] = $request->is_ideaboard;

            $user = new User;
            $user->setConnection('mysql2');

            $user->name= $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $ph;
            $user->employee_type = $request->employee_type;
            $user->password = Hash::make($request->password);
            //$user->hourly_rate = $request->hourly_rate;
            //$user->salary = $request->salary;
            //$user->role = $request->role;
            //$user->group_id = $request->group_id;
            $user->login_status = '1';
            //$user->is_dashboard = $request->is_dashboard;
            //$user->is_ideaboard = $request->is_ideaboard;
            $user->save();
            $getd = User::create($data);

            $employee_id = 'C20-'.$getd->id;
            User::where('id',$getd->id)->update(['employee_id'=>$employee_id]);
            return redirect()->route('employee_list')->with('success','Employee Has Been Added successfully');
        }
    }

    public function edit_employee($id){
        $editstaff = User::where('id',$id)->first();
        $groups = Group::get();
        $role = Role::where('role_status', '1')->orderBy('role_id', 'DESC')->get();
        return view('admin.employee.edit', compact('editstaff','role','groups'));
    }

    public function update_employee(Request $request,$id){
        $data = array();
        $data['name']= $request->name;
        $data['last_name']= $request->last_name;
        //$data['email']= $request->email;
        $data['phone']= $request->phone;
        $data['employee_type']= $request->employee_type;
        if($request->password !=''){
            $data['password']= Hash::make($request->password);
        }
        $data['hourly_rate']= $request->hourly_rate;
        $data['salary']= $request->salary;
        $data['role']= $request->role;
        $data['group_id']= $request->group_id;
        $data['is_dashboard'] = $request->is_dashboard;
        $data['is_ideaboard'] = $request->is_ideaboard;
        User::where('id',$id)->update($data);
        return redirect()->route('employee_list')->with('success','Staff Has Been Updated successfully');
    }

    public function delete_employee($id){
        $category = User::where('id',$id)->delete();   
        //$attendance = Attendance::where('employee_id',$id)->delete();
        return redirect()->route('employee_list');
    }

    public function change_employee_status(Request $request){
        $staff_id = $request->staff_id;
        $details = User::where('id',$staff_id)->first();
        $status = $details->login_status;
        if($status == '0'){
            $newStatus = '1';
        }else if($status == '1'){
            $newStatus = '0';
        }
        $update['login_status'] = $newStatus;
        User::where('id',$staff_id)->update($update);
        echo $status;
    }

    public function create_vendor(Request $request){
        return view('admin.vendor.create');
    }

    public function vendor_list(Request $request){
        $staff = Vendor::orderBy('id', 'DESC')->get();
        return view('admin.vendor.index', compact('staff'));
    }

    public function store_vendor(Request $request){

        $ph = $request->country_code.$request->phone;
        $message = '';
        $error = 0;
        if (Vendor::where('email', $request->email)->exists()) {
            $message .= 'Email id already registred. ';
            $error = 1;
        }
        if(Vendor::Where('phone', $ph)->exists()){
            $message .= 'Phone No. already registrated.';
            $error = 1;
        }
        if($error == 1){
            return redirect()->route('create_vendor')->with('error',$message);
        }else{
            $data = array();
            $data['name']= $request->name;
            $data['email']= $request->email;
            $data['phone']= $ph;
            $data['address']= $request->address;
            //$data['status']= $request->status;
            $getd = Vendor::create($data);

            $vendor_id = 'VEN-'.$getd->id;
            Vendor::where('id',$getd->id)->update(['vendor_id'=>$vendor_id]);
            return redirect()->route('vendor_list')->with('success','Vendor Has Been Added successfully');
        }
    }

    public function edit_vendor($id){
        $editstaff = Vendor::where('id',$id)->first();
        return view('admin.vendor.edit', compact('editstaff'));
    }

    public function update_vendor(Request $request,$id){ 
        $data = array();
        $data['name']= $request->name;
        //$data['email']= $request->email;
        $data['phone']= $request->phone;
        $data['address']= $request->address;
        Vendor::where('id',$id)->update($data);
        return redirect()->route('vendor_list')->with('success','Vendor Has Been Updated successfully');
    }

    public function delete_vendor($id){
        $category = Vendor::where('id',$id)->delete();   
        //$attendance = Attendance::where('employee_id',$id)->delete();
        return redirect()->route('vendor_list');
    }

    public function change_vendor_status(Request $request){
        $staff_id = $request->staff_id;
        $details = Vendor::where('id',$staff_id)->first();
        $status = $details->status;
        if($status == '0'){
            $newStatus = '1';
        }else if($status == '1'){
            $newStatus = '0';
        }
        $update['status'] = $newStatus;
        Vendor::where('id',$staff_id)->update($update);
        echo $status;
    }

    public function create_customer(Request $request){
        return view('admin.customer.create');
    }

    public function customer_list(Request $request){
        $staff = Customer::orderBy('id', 'DESC')->get();
        return view('admin.customer.index', compact('staff'));
    }

    public function store_customer(Request $request){
        $ph = $request->country_code.$request->phone;
        $message = '';
        $error = 0;
        if (Customer::where('email', $request->email)->exists()) {
            $message .= 'Email id already registrated. ';
            $error = 1;
        }
        if(Customer::Where('phone', $ph)->exists()){
            $message .= 'Phone No. already registrated.';
            $error = 1;
        }
        if($error == 1){
            return redirect()->route('create_customer')->with('error',$message);
        }else{
            $data = array();
            $data['name']= $request->name;
            $data['email']= $request->email;
            $data['phone']= $ph;
            $data['address']= $request->address;
            //$data['status']= $request->status;
            $getd = Customer::create($data);

            $customer_id = 'CUS-'.$getd->id;
            Customer::where('id',$getd->id)->update(['customer_id'=>$customer_id]);
            return redirect()->route('customer_list')->with('success','Customer Has Been Added successfully');
        }
    }

    public function edit_customer($id){
        $editstaff = Customer::where('id',$id)->first();
        return view('admin.customer.edit', compact('editstaff'));
    }

    public function update_customer(Request $request,$id){ 
        $data = array();
        $data['name']= $request->name;
        $data['phone']= $request->phone;
        $data['address']= $request->address;
        Customer::where('id',$id)->update($data);
        return redirect()->route('customer_list')->with('success','Customer Has Been Updated successfully');
    }

    public function delete_customer($id){
        $category = Customer::where('id',$id)->delete();
        return redirect()->route('customer_list');
    }

    public function change_customer_status(Request $request){
        $staff_id = $request->staff_id;
        $details = Customer::where('id',$staff_id)->first();
        $status = $details->status;
        if($status == '0'){
            $newStatus = '1';
        }else if($status == '1'){
            $newStatus = '0';
        }
        $update['status'] = $newStatus;
        Customer::where('id',$staff_id)->update($update);
        echo $status;
    }

    //project start
    public function create_project(Request $request){
        $vendor = Vendor::where('status', '1')->orderBy('name', 'ASC')->get();
        $customer = Customer::where('status', '1')->orderBy('name', 'ASC')->get();
        $employee = User::where('login_status', '1')->orderBy('name', 'ASC')->get();
        return view('admin.project.create', compact('vendor','customer','employee'));
    }

    public function project_list(Request $request){
        $staff = Project::orderBy('id', 'DESC')->get();
        $vendor = Vendor::where('status', '1')->orderBy('name', 'ASC')->get();
        $customer = Customer::where('status', '1')->orderBy('name', 'ASC')->get();
        $employee = User::where('login_status', '1')->orderBy('name', 'ASC')->get();
        return view('admin.project.index', compact('staff','vendor','customer','employee'));
    }

    public function store_project(Request $request){ 
        
        if (Project::where('name', $request->name)->exists()) {
          return redirect()->route('create_project')->with('error','Project Name already registrated, please check.');
        }else{
            $data = array();
            $data['name']= $request->name;
            $data['description']= $request->description;
            $data['vendor_id']= $request->vendor_id;
            $data['customer_id']= $request->customer_id;
            $data['user_id']= implode(',', $request->user_id);
            //$data['status']= $request->status;
            $getd = Project::create($data);

            $project_id = 'PRO-'.$getd->id;
            Project::where('id',$getd->id)->update(['project_id'=>$project_id]);
            return redirect()->route('project_list')->with('success','Project Has Been Added successfully');
        }
    }

    public function edit_project($id){
        $editstaff = Project::where('id',$id)->first();
        $vendor = Vendor::where('status', '1')->orderBy('name', 'ASC')->get();
        $customer = Customer::where('status', '1')->orderBy('name', 'ASC')->get();
        $employee = User::where('login_status', '1')->orderBy('name', 'ASC')->get();
        return view('admin.project.edit', compact('editstaff','vendor','customer','employee'));
    }

    public function update_project(Request $request,$id){ 
        $data = array();
        $data['name']= $request->name;
        $data['description']= $request->description;
        $data['vendor_id']= $request->vendor_id;
        $data['customer_id']= $request->customer_id;
        $data['user_id']= implode(',', $request->user_id);
        //$data['status']= $request->status;
        Project::where('id',$id)->update($data);
        return redirect()->route('project_list')->with('success','Project Has Been Updated successfully');
    }

    public function delete_project($id){
        Project::where('id',$id)->delete();   
        return redirect()->route('project_list');
    }

    public function change_project_status(Request $request){
        $id = $request->staff_id;
        $details = Project::where('id',$id)->first();
        $status = $details->status;
        if($status == '0'){
            $newStatus = '1';
        }else if($status == '1'){
            $newStatus = '0';
        }
        $update['status'] = $newStatus;
        Project::where('id',$id)->update($update);
        echo $status;
    }
    //project end

    //task start
     public function create_task(Request $request){
        $project = Project::where('status', '1')->orderBy('id', 'DESC')->get();
        //$employee = User::where('login_status', '1')->orderBy('id', 'DESC')->get();
        return view('admin.task.create', compact('project'));
    }

    public function task_list(Request $request){
        $staff = Task::orderBy('id', 'DESC')->get();
        $project = Project::where('status', '1')->orderBy('id', 'DESC')->get();
        //$employee = User::where('login_status', '1')->orderBy('id', 'DESC')->get();
        return view('admin.task.index', compact('staff','project'));
    }

    public function store_task(Request $request){
        $data = array();
        $data['name']= $request->name;
        $data['description']= $request->description;
        $data['project_id']= $request->project_id;
        $getd = Task::create($data);

        $task_id = 'TSK-'.$getd->id;
        Task::where('id',$getd->id)->update(['task_id'=>$task_id]);
        return redirect()->route('task_list')->with('success','Task Has Been Added successfully');
    }

    public function edit_task($id){
        $editstaff = Task::where('id',$id)->first();
        $project = Project::where('status', '1')->orderBy('id', 'DESC')->get();
        //$employee = User::where('login_status', '1')->orderBy('id', 'DESC')->get();
        return view('admin.task.edit', compact('editstaff','project'));
    }

    public function update_task(Request $request,$id){ 
        $data = array();
        $data['name']= $request->name;
        $data['description']= $request->description;
        $data['project_id']= $request->project_id;
        //$data['employee_id']= $request->employee_id;
        Task::where('id',$id)->update($data);
        return redirect()->route('task_list')->with('success','Task Has Been Updated successfully');
    }

    public function delete_task($id){
        Task::where('id',$id)->delete();   
        return redirect()->route('task_list');
    }

    public function change_task_status(Request $request){
        $id = $request->staff_id;
        $details = Task::where('id',$id)->first();
        $status = $details->status;
        if($status == '0'){
            $newStatus = '1';
        }else if($status == '1'){
            $newStatus = '0';
        }
        $update['status'] = $newStatus;
        Task::where('id',$id)->update($update);
        echo $status;
    }
    //task end

    public function staff_list(Request $request){
        $staff = User::whereIsAdmin('0')->Where('role','!=', 3)->orderBy('id', 'DESC')->get();
        $role = Role::where('role_status', '1')->orderBy('role_id', 'DESC')->get();
        return view('admin.staff.index', compact('staff','role'));
    }

    public function create_staff(Request $request){
         $role = Role::where('role_status', '1')->orderBy('role_id', 'DESC')->get();
        return view('admin.staff.create',compact('role'));
    }

    public function store_staff(Request $request){
        $ph = $request->country_code.$request->phone;
        if (User::where('email', $request->email)->orWhere('phone', $ph)->exists()) {
          return redirect()->route('create_staff')->with('error','Mobile Number OR Email id already registrated, please check.');
        }else{

            $web_url = url('/');
            $app_url = '';
            $data = array();
            $data['name']= $request->name;
            $data['email']= $request->email;
            $data['phone']= $ph;
            $data['password']= Hash::make($request->password);
            $data['role']= $request->role;
            $data['login_status']= '1';

            $getd = User::create($data);
            $editRole = Role::where('role_id',$request->role)->first();
            $detail = [
                'subject' =>'Account Opening',
                'name' =>$request->name,
                'email' =>$request->email,
                'account_type' => $editRole->name,
                'password' => $request->password,
                'web_url' => url('/'),
                'app_url' => $app_url
            ];

            /*mail::to($request->email)->send(new VerifyMail($detail));

            $message = "Dear ".$request->name.",  Thank you for joining at our site Clindcast Time Logs.Your acccount type is : ".$editRole->name." . Email: ".$request->email." Password: ".$request->password."  Web Login: ".$web_url." App Login: ".$app_url."";

            $url = "https://elitbuzz-me.com/sms/smsapi?api_key=C200332460c9157cc64e06.85843724&type=text&contacts=" .
            $ph . "&" .
             "senderid=JWP-WiFi". "&" .
             "msg="  . urlencode($message);

            $output = file($url);*/
            return redirect()->route('staff_list')->with('success','Employee Has Been Added successfully');
        }
    }

    public function delete_staff($id){
        $category = User::where('id',$id)->delete();   
        $attendance = Attendance::where('employee_id',$id)->delete();
        return redirect()->route('staff_list');
    }

    public function edit_staff($id){
        $editstaff = User::where('id',$id)->first();
        $role = Role::where('role_status', '1')->orderBy('role_id', 'DESC')->get();
        //  dd($editstaff);
        return view('admin.staff.edit', compact('editstaff','role'));
    }

    public function assign_sites(Request $request,$id){
        $staff_info = User::where('id',$id)->first(); 
        $api_list = Allapi::where('status','1')->orderBy('id','DESC')->get();
        $sites = AccessSites::where('user_id', $id)->orderBy('id','DESC')->get();
        $sites_ids = AccessSites::select('site_id')->where('user_id', $id)->orderBy('id','DESC')->get();
        $sid = AccessSites::select("site_id")
                    ->where('user_id',$id)
                    ->get();
        $js = json_encode($sid);

        $de =   json_decode($js);
        foreach($de as $vl)
        {
            $s[] = $vl->site_id;
        }
        if(!empty($s)){
            $asign_ids =   $s;
        }else{
            $asign_ids =   '';
        }
        return view('admin.staff.assign_sites', compact('staff_info','api_list','sites','asign_ids','sid'));
    }

    public function update_assign_sites(Request $request,$id){
           
        $answers = [];
        foreach($request->site_id as $sid) {
            $answers[] = [
                'user_id' => $request->user_ids,
                'site_id' => $sid
            ];
        }
        AccessSites::insert($answers);
        return redirect()->route('assign_sites',$id)->with('success','Sites Assign successfully.');
    }

    public function delete_assign_sites($id){
        $ids = AccessSites::where('id',$id)->first();
        $rid = $ids->user_id;
        $category = AccessSites::where('id',$id)->delete();
        return redirect()->route('assign_sites',$rid);
    }

    public function update_staff(Request $request,$id){
        // if (User::where('email', $request->name)->exists()) {  
        $data = array();
        $data['name']= $request->name;
        $data['phone']= $request->phone;
        $data['password']= Hash::make($request->password);
        $data['role']= $request->role;
        User::where('id',$id)->update($data);
        return redirect()->route('staff_list')->with('success','Staff Has Been Updated successfully');
        //      }else{
        //      return redirect()->route('create_staff')->with('error','Email id already registrated, check email id.'); 
        //   }
    }

    public function change_user_status(Request $request){
        $staff_id = $request->staff_id;

        $details = User::where('id',$staff_id)->first();
        $status = $details->login_status;
        if($status == '0'){
            $newStatus = '1';
        }else if($status == '1'){
            $newStatus = '0';
        }
        $update['login_status'] = $newStatus;
        User::where('id',$staff_id)->update($update);
        echo $status;
    }

    public function role_list(Request $request){
        $role = Role::where('role_status', '1')->orderBy('role_id', 'DESC')->get();
        return view('admin.role.index', compact('role'));
    }

    public function edit_role_permission($id){
        $role = Role::where('role_id', $id)->first();
        $permissions = DB::table('permission')
            ->join('user_permissions', 'permission.permission_id', '=', 'user_permissions.permission_id')
            ->select('permission.permission_id', 'permission.name', 'permission.codename', 'user_permissions.is_create', 'user_permissions.is_edit', 'user_permissions.is_delete')
            ->where('user_permissions.role_id',$id)
            ->get();

        //$permissions = Permission::orderBy('permission_id', 'ASC')->get();
        return view('admin.role.edit', compact('role','permissions'));
    }

    public function update_role_permission(Request $request,$id){
        $user_permissions=$request->user_permissions;

        foreach($user_permissions as $id_modul => $data) {
            $arrs = array();
            $arrs['is_create'] = @$data['is_create']?:0;
            $arrs['is_edit'] = @$data['is_edit']?:0;
            $arrs['is_delete'] = @$data['is_delete']?:0;
            DB::table("user_permissions")->where('role_id',$id)->Where('permission_id', $data['permission_id'])->update($arrs);
        }
        $data = array();
        if(!empty($request->permission)){
        $data['permission']= json_encode($request->permission);
        }else{
        $data['permission']= [];
        }
        Role::where('role_id',$id)->update($data);
        return redirect()->route('role_list')->with('success','Permission Has Been Updated successfully');
    }

    public function registered_user_list(Request $request){
        $registered_user_list = RegisteredUser::orderBy('id', 'DESC')->get();
        return view('admin.registered_user_list', compact('registered_user_list'));
    }

    public function create_role(Request $request){
        return view('admin.staff.createrole');
    }

    public function store_role(Request $request){
        if (Role::where('name', $request->name)->exists()) {   
          return redirect()->route('create_role')->with('error','Role already registrated, please check.'); 
        }else{
            $data = array();
            $data['name']= $request->name;
            $data['description']= $request->description;
            $data['role_status']= $request->role_status;
            $getd= Role::create($data);

            $id = $getd->id;

            $permissions = Permission::get();
            foreach($permissions as $permission){
                Userpermission::create(['role_id'=> $id,'permission_id'=> $permission->permission_id ]);
            }

            return redirect()->route('role_lists')->with('success','Role Has Been Added successfully');
        }
    }

    public function role_lists(Request $request){
        $roles = Role::orderBy('role_id', 'DESC')->get();
        return view('admin.staff.role_list', compact('roles'));
    }

    public function delete_role($id){
        Role::where('role_id',$id)->delete();
        return redirect()->route('role_lists');
    }

    public function edit_roles($id){
        $role = Role::where('role_id',$id)->first();
        return view('admin.staff.edit_role', compact('role','role'));
    }

    public function update_roles(Request $request,$id){
        $data = array();
        $data['name']= $request->name;
        $data['description']= $request->description;
        $data['role_status']= $request->role_status;
        Role::where('role_id',$id)->update($data);
        return redirect()->route('role_lists')->with('success','Role Has Been Updated successfully');
    }

    public function permission_lists(Request $request){
        $permissions = Permission::orderBy('permission_id', 'DESC')->get();
        return view('admin.permission.list', compact('permissions'));
    }

    public function create_permission(Request $request){
        return view('admin.permission.create');
    }

    public function store_permission(Request $request){
        if (Permission::where('name', $request->name)->exists()) {
          return redirect()->route('create_role')->with('error','Permission already registrated, please check.');
        }else{
            $data = array();
            $data['name']= $request->name;
            $data['description']= $request->description;
            $data['codename']= $request->codename;
            Role::create($data);
            return redirect()->route('permission_lists')->with('success','Permission Has Been Added successfully');
        }
    }

    public function create_group(Request $request){
        return view('admin.group.create');
    }

    public function group_list(Request $request){
        $staff = Group::orderBy('id', 'DESC')->get();
        return view('admin.group.index', compact('staff'));
    }

    public function store_group(Request $request){
        $ph = $request->country_code.$request->phone;
        $message = '';
        $error = 0;
        if (Group::where('name', $request->name)->exists()) {
            $message .= 'name id already registrated. ';
            $error = 1;
        }
        if($error == 1){
            return redirect()->route('create_group')->with('error',$message);
        }else{
            $data = array();
            $data['name']= $request->name;
            Group::create($data);
            return redirect()->route('group_list')->with('success','Group Has Been Added successfully');
        }
    }

    public function edit_group($id){
        $editstaff = Group::where('id',$id)->first();
        return view('admin.group.edit', compact('editstaff'));
    }

    public function update_group(Request $request,$id){ 
        $data = array();
        $data['name']= $request->name;
        Group::where('id',$id)->update($data);
        return redirect()->route('group_list')->with('success','Group Has Been Updated successfully');
    }

    public function delete_group($id){
        Group::where('id',$id)->delete();
        return redirect()->route('group_list');
    }

    public function create_state(Request $request){
        return view('admin.state.create');
    }

    public function store_state(Request $request){
        if (State::where('name', $request->name)->exists()) {
          return redirect()->route('create_state')->with('error','State Registry already registrated, please check.');
        }else{
            $data = array();
            $data['name']= $request->name;
            $data['siu']= $request->siu;
            $data['website']= $request->website;
            $data['user_name']= $request->user_name;
            $data['password']= $request->password;
            $data['notes']= $request->notes;
            $data['su']= $request->su;
            $data['siu_website']= $request->siu_website;
            $data['siu_user_name']= $request->siu_user_name;
            $data['siu_password']= $request->siu_password;
            $data['siu_notes']= $request->siu_notes;
            $data['comments'] = $request->comments;
            $data['updates']= $request->updates;
            $data['next_task']= $request->next_task;
            
            State::create($data);
            return redirect()->route('state_lists')->with('success','State Registry Has Been Added successfully');
        }
    }

    public function state_lists(Request $request){
        $states = State::orderBy('id', 'DESC')->get();
        return view('admin.state.index', compact('states'));
    }

    public function delete_state($id){
        State::where('id',$id)->delete();   
        return redirect()->route('state_lists');
    }

    public function edit_state($id){
        $editstate = State::where('id',$id)->first();
        return view('admin.state.edit', compact('editstate'));
    }

    public function view_state($id){
        $view_state = State::where('id',$id)->first();
        return view('admin.state.view', compact('view_state'));
    }

    public function update_state(Request $request,$id){
        $data = array();
        $data['name']= $request->name;
        $data['siu']= $request->siu;
        $data['website']= $request->website;
        $data['user_name']= $request->user_name;
        $data['password']= $request->password;
        $data['notes']= $request->notes;
        $data['su']= $request->su;
        $data['siu_website']= $request->siu_website;
        $data['siu_user_name']= $request->siu_user_name;
        $data['siu_password']= $request->siu_password;
        $data['siu_notes']= $request->siu_notes;
        $data['comments'] = $request->comments;
        $data['updates']= $request->updates;
        $data['next_task']= $request->next_task;
        State::where('id',$id)->update($data);
        return redirect()->route('state_lists')->with('success','State Registry Has Been Updated successfully');
    }

    //task Assigment
    public function create_dailytask(Request $request){
        return view('admin.ideaboard.dailytask');
    }

    public function dailytask_list(Request $request){
        $staff = Dailytask::orderBy('id', 'DESC')->get();
        return view('admin.ideaboard.tasklist', compact('staff'));
    }

    public function store_dailytask(Request $request){ 
        
        // if (Project::where('name', $request->name)->exists()) {
        //   return redirect()->route('create_dailytask')->with('error','Project Name already registrated, please check.');
        // }else{
            $data = array();
            // $data['taskid']= $request->taskid;
            $data['task']= $request->task;
            $data['comment']= $request->comment;
            $getd = Dailytask::create($data);
            return redirect()->route('dailytask_list')->with('success','Task Has Been Added successfully');
        //}
    }

    public function edit_dailytask($id){
        $editstaff = Dailytask::where('id',$id)->first();
        return view('admin.ideaboard.edittask', compact('editstaff'));
    }

    public function update_dailytask(Request $request,$id){ 
        $data = array();
        // $data['taskid']= $request->taskid;
        $data['task']= $request->task;
        $data['comment']= $request->comment;
        Dailytask::where('id',$id)->update($data);
        return redirect()->route('dailytask_list')->with('success','Task Has Been Updated successfully');
    }

    public function delete_dailytask($id){
        Dailytask::where('id',$id)->delete();   
        return redirect()->route('dailytask_list');
    }


    //task Assigment
    public function create_assigntask(Request $request){
        $task = Dailytask::orderBy('task', 'ASC')->get();
        $employee = User::where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get();
        return view('admin.ideaboard.taskassignment', compact('task','employee'));
    }

    public function assigntask_list(Request $request){
        $staff = Taskassign::orderBy('id', 'DESC')->get();
        $task = Dailytask::orderBy('task', 'ASC')->get();
        $employee = User::where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get();
        return view('admin.ideaboard.index', compact('staff','task','employee'));
    }

    public function store_assigntask(Request $request){ 
        $tasks=$request->task_id;
        foreach($tasks as $task){
            $data = array();
            $data['task_id']= $task;
            $data['date']= $request->date;
            $data['user_id']= implode(',', $request->user_id);
            $getd = Taskassign::create($data);
        }
        return redirect()->route('assigntask_list')->with('success','Task assign successfully');
    }

    public function store_assigntask1(Request $request){ 
        $tasks=$request->task_id;
        foreach($tasks as $task){
            $data = array();
            $data['task_id']= $task;
            $data['date']= $request->date;
            $data['user_id']= $request->user_id;
            $count = Taskassign::where('task_id',$task)->where('date',$request->date)->where('user_id',$request->user_id)->count();
            if($count==0){
                Taskassign::create($data);
            }
        }
        return redirect()->route('board');
        /*$date = date('Y-m-d');
        if($request->date){
            $date = $request->date;
        }
        $emp_id ='';
        $taskassigns = Taskassign::whereDate('date', '=', $date)->orderBy('id', 'DESC')->get();
        $user_id = Auth::user()->id;
        $admin_role = Auth::user()->role;
        $tasks = Dailytask::orderBy('task', 'ASC')->get();
        $users = User::where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get();
        $employeess = User::where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get(); 
        return view('admin.ideaboard.board',compact('users','taskassigns','tasks','date','employeess','emp_id'));*/
    }

    public function edit_assigntask($id){
        $editstaff = Taskassign::where('id',$id)->first();
        $task = Dailytask::orderBy('task', 'ASC')->get();
        $employee = User::where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get();
        return view('admin.ideaboard.edit', compact('editstaff','task','employee'));
    }

    public function update_assigntask(Request $request,$id){ 
        $data = array();
        $data['task_id']= $request->task_id;
        $data['date']= $request->date;
        $data['user_id']= implode(',', $request->user_id);
        Taskassign::where('id',$id)->update($data);
        return redirect()->route('assigntask_list')->with('success','Updated successfully');
    }

    public function delete_assigntask($id){
        Taskassign::where('id',$id)->delete();
        return redirect()->route('assigntask_list');
    }

    public function board(Request $request){
        $date = date('Y-m-d');
        if($request->date){
            $date = $request->date;
        }
        $emp_id ='';
        if($request->emp_id){
            $emp_id = $request->emp_id;
        }
        $group_id ='';
        if($request->group_id){
            $group_id = $request->group_id;
        }
        $groups = Group::get();
        $taskassigns = Taskassign::whereDate('date', '=', $date)->orderBy('id', 'DESC')->get();
        $user_id = Auth::user()->id;
        $admin_role = Auth::user()->role;
        $tasks = Dailytask::orderBy('task', 'ASC')->get();
        $users = User::where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get();
        $employeess = User::where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get(); 
        if($request->emp_id){
            $employeess = User::where('id', $emp_id)->where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get();  
        }
        if($request->group_id){
            $employeess = User::where('login_status', '1')->where('group_id', $group_id)->orderBy('name', 'ASC')->get();
        }

        return view('admin.ideaboard.board',compact('users','taskassigns','tasks','date','employeess','emp_id','groups','group_id'));
    }

    /*public function adddailytaskcomments (Request $request){
        $data = array();
        $data['user_id']= $request->user_id;
        $data['task_id']= $request->task_id;
        $data['comments']= $request->value.', '.date("m/d h:i a", strtotime(date("Y/m/d h:i:sa")));
        $data['date']= $request->date;

        // $count = Dailytaskcomments::where('user_id', $data['user_id'])->where('task_id', $data['task_id'])->whereDate('date', '=', $data['date'])->count();
        // if($count>0){
        //     $dailytask = Dailytaskcomments::where('user_id', $data['user_id'])->where('task_id', $data['task_id'])->whereDate('date', '=', $data['date'])->first();
        //     $comments = $dailytask->comments;
        //     $data['comments'] = $dailytask->comments.', '.$request->value.', '.date("m/d h:i a", strtotime(date("Y/m/d h:i:sa")));
        //     Dailytaskcomments::where('id',$dailytask->id)->update($data);
        // }else{
            Dailytaskcomments::create($data);
        //}
        
        $response = ["id"=>'sucess'];
        return response()->json($response);
    }*/

    public function adddailytaskcomments (Request $request){
        $data = array();
        $data['user_id']= $request->user_id;
        $data['task_id']= $request->task_id;
        $data['comments']= $request->value.','.Auth::user()->name.' '.date("m/d h:i a", strtotime(date("Y/m/d h:i:sa")));
        $data['date']= $request->date;

        Dailytaskcomments::create($data);
        
        $response = ["id"=>'sucess'];
        return response()->json($response);
    }

    //pmt start
    public function create_pmt(Request $request){
        $groups = Group::get();
        //$employee = User::where('login_status', '1')->where('is_dashboard', '1')->orderBy('name', 'ASC')->get();
        return view('admin.performance.create_pmt', compact('groups'));
    }

    public function store_pmt(Request $request){ 
    
        $data = array();
        $data['pmt']= $request->pmt;
        $data['description']= $request->description;
        $data['group_id']= $request->group_id;
        $getd = Pmt::create($data);
        return redirect()->route('pmt_lists')->with('success','PMT added successfully');
    }

    public function edit_pmt($id){
        $pmts = Pmt::where('id',$id)->first();
        $groups = Group::get();
        return view('admin.performance.edit_pmt', compact('groups','pmts'));
    }

    public function update_pmt(Request $request,$id){ 
        $data = array();
         $data['pmt']= $request->pmt;
        $data['description']= $request->description;
        $data['group_id']= $request->group_id;
        Pmt::where('id',$id)->update($data);
        return redirect()->route('pmt_lists')->with('success','Updated successfully');
    }

    public function delete_pmt ($id){
        Pmt::where('id',$id)->delete();
        return redirect()->route('pmt_lists');
    }

    public function pmt_lists(Request $request){
        $pmts = Pmt::orderBy('id', 'DESC')->get();
        $groups = Group::get();
        return view('admin.performance.pmt_lists', compact('groups','pmts'));
    }

    public function getStartAndEndDate($week, $year) {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        $ret['week_start'] = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ret['week_second'] = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ret['week_third'] = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ret['week_fourth'] = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ret['week_fifth'] = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ret['week_sixth'] = $dto->format('Y-m-d');
        $dto->modify('+1 days');
        $ret['week_end'] = $dto->format('Y-m-d');
        return $ret;
    }

    public function searchweeklytarget(Request $request){
        $pmts = Pmt::orderBy('id', 'DESC')->get();
        $users = User::orderBy('name')->get();
        $groups = Group::get();
        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        $week = $date->format("W");
        $options =array();
        $w = 52;
        //$w = $date->format("W");
        for($x = 1; $x <= $w; $x++){
            $week_arr = $this->getStartAndEndDate($x,date("Y"));
            $options[$x]['value'] = $x;
            $options[$x]['week_start'] = date("D M d ", strtotime($week_arr["week_start"]));
            $options[$x]['week_end'] =date("D M d ", strtotime($week_arr["week_end"]));
        }
        $datas = array();
        $j=0;
        for($x = $w; $x >= 1; $x--){
            $week_arr = $this->getStartAndEndDate($x,date("Y"));
            $start_date = $week_arr['week_start'];
            foreach($groups as $group){
                foreach($pmts as $pmt){
                    $count = Weeklytarget::where('group_id',$group->id)->where('pmt_id',$pmt->id)->whereDate('date', '=',$start_date)->count();
                    if($count>0){
                        $weak = array();
                        $weak['Mon'] = date('m/d',strtotime($week_arr['week_start']));
                        $weak['Tue'] = date('m/d',strtotime($week_arr['week_second']));
                        $weak['Wed'] = date('m/d',strtotime($week_arr['week_third']));
                        $weak['Thu'] = date('m/d',strtotime($week_arr['week_fourth']));
                        $weak['Fri'] = date('m/d',strtotime($week_arr['week_fifth']));
                        $weak['Sat'] = date('m/d',strtotime($week_arr['week_sixth']));
                        $weak['Sun'] = date('m/d',strtotime($week_arr['week_end']));
                        $datas[$j]['week_arr'] = $weak;
                        $datas[$j]['group_id'] = $group->id;
                        $datas[$j]['record'] = Weeklytarget::where('group_id',$group->id)->where('pmt_id',$pmt->id)->whereDate('date', '=',$start_date)->get();
                        $j++;
                }   }
            }
        }

        return view('admin.performance.search_weeklytarget', compact('options','groups','week','pmts','datas'));
    }

    //weekly target 
    public function create_weekly_target(Request $request){
        $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }

        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        if($request->week==''){
            $wday = $date->format("W");
        }else{
            $wday = $request->week;
        }
        
        $group_id = $request->group_id;
        $pmt_id = $request->pmt_id;
        $week_arr = $this->getStartAndEndDate($wday,date("Y"));
        $group_name = Group::where('id',$group_id)->first()->name;

        $week_start = $week_arr['week_start'];
        $today = strtotime($week_arr["week_start"]);

        $weak = array();
        $weak['Mon'] = date('m/d',strtotime($week_arr['week_start']));
        $weak['Tue'] = date('m/d',strtotime($week_arr['week_second']));
        $weak['Wed'] = date('m/d',strtotime($week_arr['week_third']));
        $weak['Thu'] = date('m/d',strtotime($week_arr['week_fourth']));
        $weak['Fri'] = date('m/d',strtotime($week_arr['week_fifth']));
        $weak['Sat'] = date('m/d',strtotime($week_arr['week_sixth']));
        $weak['Sun'] = date('m/d',strtotime($week_arr['week_end']));

        $tt['group_id'] = $group_id;
        $tt['weak'] = $weak;
        $tt['week_start'] = $week_start;
        $tt['pmt_id'] = $pmt_id;
        $tt['group_name'] = $group_name;

        return response()->json(['view' => view('admin.performance.create_weeklytarget')->with('tt',$tt)->render()]);
    }

    public function store_weekly_target(Request $request){
        $req = $request->all();
        $group_id = $req['group_id'];
        $date = $req['date'];
        $pmt_id = $req['pmt_id'];
        $count = count($req);
        $cc = ($count-4)/8;
        for($i = 1; $i <= $cc; $i++){
            $data = array();
            $data['user_id'] = $req['user_id'.$i];
            $data['group_id'] = $group_id;
            $data['date'] = $date;
            $data['pmt_id'] = $pmt_id;
            $data['mon'] = $req['mon'.$i];
            $data['tue'] = $req['tue'.$i];
            $data['wed'] = $req['wed'.$i];
            $data['thu'] = $req['thu'.$i];
            $data['fri'] = $req['fri'.$i];
            $data['sat'] = $req['sat'.$i];
            $data['sun'] = $req['sun'.$i];

            $count = Weeklytarget::where('user_id',$data['user_id'])->whereDate('date', '=',$date)->where('group_id',$group_id)->where('pmt_id',$pmt_id)->count();
            if($count<0){
                $id = Weeklytarget::where('user_id',$data['user_id'])->whereDate('date', '=',$date)->where('group_id',$group_id)->where('pmt_id',$pmt_id)->first()->id;
                Weeklytarget::where('id',$id)->update($data);
            }else{
                Weeklytarget::create($data);
            }
        }
        return redirect()->route('searchweeklytarget');
    }

    public function weekly_target_lists(Request $request){
        // $ddate = date('Y-m-d');
        // $date = new DateTime($ddate);
        // $week = $date->format("W");
        // $options =array();
        // $w = $date->format("W");
        // for($x = 1; $x <= $w; $x++){
        //     $week_arr = $this->getStartAndEndDate($x,date("Y"));
        //     $options[$x]['value'] = $x;
        //     $options[$x]['week_start'] = date("D M d ", strtotime($week_arr["week_start"]));
        //     $options[$x]['week_end'] =date("D M d ", strtotime($week_arr["week_end"]));
        // }
        // $pmts = Pmt::orderBy('id', 'DESC')->get();
        // $groups = Group::where('group_id')->get();

        // $week_start = $this->getStartAndEndDate($req['date'],date("Y"))['week_start'];
        // $week_end = $this->getStartAndEndDate($req['date'],date("Y"))['week_end'];

        //$weeklytargets = Weeklytarget::where('group_id',$group_id)->whereDate('week_start' ,'<=', date('Y-m-d'))->whereDate('week_end', '>=', date('Y-m-d'))->get();

        $weeklytargets = Weeklytarget::get();
        return view('admin.performance.weekly_target_lists', compact('options','groups','week','pmts','ddate'));
    }

    public function lead(){
        $leads = Contact::orderBy('id', 'DESC')->get();
        return view('admin.leadgeneration.index', compact('leads'));
    }

    public function edit_lead($id){
        $editlead = Contact::where('id',$id)->orderBy('created_at','DESC')->first();
        $users = User::orderBy('name')->get();
        return view('admin.leadgeneration.edit', compact('editlead','users'));
    }

    public function update_lead(Request $request, $id){ 
        $data = array();
        $data['first_name']= $request->first_name;
        $data['last_name']= $request->last_name;
        $data['email']= $request->email;
        $data['phone']= $request->phone;
        $data['company_name']= $request->company_name;
        $data['message']= $request->message;
        $data['job_title']= $request->job_title;
        $data['topic']= $request->topic;
        $data['notes']= $request->notes;
        $data['user_id']= implode(',', $request->user_id);

        Contact::where('id',$id)->update($data);
        return redirect()->route('lead')->with('success','Records Has Been Updated successfully');
    }

    public function delete_lead($id){
        Contact::where('id',$id)->delete();
        LeadComment::where('lead_id',$id)->delete();
        return redirect()->route('lead');
    }

    public function view_lead($id){
        $view_lead = Contact::where('id',$id)->first();
        $users = User::orderBy('name')->get();
        $lead_comments = LeadComment::where('lead_id',$id)->get();
        return view('admin.leadgeneration.view_lead', compact('view_lead','users','lead_comments'));
    }

    public function lead_comment(Request $request){ 
        $id = $request->id;
        $data = array();
        $data['user_id'] = Auth::user()->id;
        $data['comment']= $request->comment;
        $data['lead_id']= $id;
        LeadComment::create($data);
        return redirect()->route('lead')->with('success','Records Has Been Updated successfully');
    }

    public function weeklytargetactual(Request $request){
        $pmts = Pmt::orderBy('id', 'DESC')->get();
        $users = User::orderBy('name')->get();
        $groups = Group::get();
        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        $week = $date->format("W");
        $options =array();
        //$w = $date->format("W");
        $w = 52;
        for($x = 1; $x <= $w; $x++){
            $week_arr = $this->getStartAndEndDate($x,date("Y"));
            $options[$x]['value'] = $x;
            $options[$x]['week_start'] = date("D M d ", strtotime($week_arr["week_start"]));
            $options[$x]['week_end'] =date("D M d ", strtotime($week_arr["week_end"]));
        }
        $datas = array();
        $j=0;
        $x = $date->format("W");
        //for($x = $w; $x >= 1; $x--){
            $week_arr = $this->getStartAndEndDate($x,date("Y"));
            $start_date = $week_arr['week_start'];
            foreach($groups as $group){
                foreach($pmts as $pmt){
                    $count = Weeklytarget::where('group_id',$group->id)->where('pmt_id',$pmt->id)->whereDate('date', '=',$start_date)->count();
                    if($count>0){
                        $weak = array();
                        $weak['Mon'] = date('m/d',strtotime($week_arr['week_start']));
                        $weak['Tue'] = date('m/d',strtotime($week_arr['week_second']));
                        $weak['Wed'] = date('m/d',strtotime($week_arr['week_third']));
                        $weak['Thu'] = date('m/d',strtotime($week_arr['week_fourth']));
                        $weak['Fri'] = date('m/d',strtotime($week_arr['week_fifth']));
                        $weak['Sat'] = date('m/d',strtotime($week_arr['week_sixth']));
                        $weak['Sun'] = date('m/d',strtotime($week_arr['week_end']));
                        $datas[$j]['week_arr'] = $weak;
                        $datas[$j]['group_id'] = $group->id;
                        $datas[$j]['record'] = Weeklytarget::where('group_id',$group->id)->where('pmt_id',$pmt->id)->whereDate('date', '=',$start_date)->get();
                        $j++;
                }   }
            }
        //}

        return view('admin.performance.weekly_targetactual', compact('options','groups','week','pmts','datas'));
    }

    public function store_weeklyactualtarget(Request $request){ 
        $data = array();
        $id = $request->id;
        $data[$request->name]= $request->value;
        Weeklytarget::where('id',$id)->update($data);
        return 1;
    }

    public function searchactual_weeklytarget(Request $request){
        $today = time();
        if($request->date){
            $today = strtotime($request->date);
        }

        $ddate = date('Y-m-d');
        $date = new DateTime($ddate);
        if($request->week==''){
            $wday = $date->format("W");
        }else{
            $wday = $request->week;
        }
        
        $group_id = $request->group_id;
        $pmt_id = $request->pmt_id;
        $week_arr = $this->getStartAndEndDate($wday,date("Y"));
        $group_name = Group::where('id',$group_id)->first()->name;

        $week_start = $week_arr['week_start'];
        $today = strtotime($week_arr["week_start"]);
        $start_date = $week_arr['week_start'];

        $count = Weeklytarget::where('group_id',$group_id)->where('pmt_id',$pmt_id)->whereDate('date', '=',$start_date)->count();
        if($count>0){
            $weak = array();
            $weak['Mon'] = date('m/d',strtotime($week_arr['week_start']));
            $weak['Tue'] = date('m/d',strtotime($week_arr['week_second']));
            $weak['Wed'] = date('m/d',strtotime($week_arr['week_third']));
            $weak['Thu'] = date('m/d',strtotime($week_arr['week_fourth']));
            $weak['Fri'] = date('m/d',strtotime($week_arr['week_fifth']));
            $weak['Sat'] = date('m/d',strtotime($week_arr['week_sixth']));
            $weak['Sun'] = date('m/d',strtotime($week_arr['week_end']));
            $datas[0]['week_arr'] = $weak;
            $datas[0]['group_id'] = $group_id;
            $datas[0]['record'] = Weeklytarget::where('group_id',$group_id)->where('pmt_id',$pmt_id)->whereDate('date', '=',$start_date)->get();

            $tt['weak'] = $weak;
            $tt['datas'] = $datas;
            return response()->json(['status' => 0,'view' => view('admin.performance.search_weekly_targetactual')->with('tt',$tt)->render()]);
        }else{
            return response()->json(['status' => 1]);
        }
    }

    public function event(){
        $events = Event::orderBy('id', 'DESC')->get();
        return view('admin.event.index', compact('events'));
    }

    public function edit_event($id){
        $editevent = Event::where('id',$id)->first();
        return view('admin.event.edit', compact('editevent'));
    }

    public function update_event(Request $request,$id){ 
        $data = array();
        $data['first_name']= $request->first_name;
        $data['last_name']= $request->last_name;
        $data['email']= $request->email;
        $data['phone']= $request->phone;
        $data['company_name']= $request->company_name;
        Event::where('id',$id)->update($data);
        return redirect()->route('event')->with('success','Records Has Been Updated successfully');
    }

    public function delete_event($id){
        Event::where('id',$id)->delete();
        return redirect()->route('event');
    }

    public function view_event($id){
        $view_event = Event::where('id',$id)->first();
        return view('admin.event.view_event', compact('view_event'));
    }

    // public function event_comment(Request $request){ 
    //     $id = $request->id;
    //     $data = array();
    //     $data['user_id'] = Auth::user()->id;
    //     $data['comment']= $request->comment;
    //     $data['event_id']= $id;
    //     Event::create($data);
    //     return redirect()->route('lead')->with('success','Records Has Been Updated successfully');
    // }

    public function boardPrint(Request $request){
        $date = date('Y-m-d');
        if($request->date !=''){
            $date = $request->date;
        }
        $emp_id ='';
        if($request->emp_id !=''){
            $emp_id = $request->emp_id;
        }
        $group_id ='';
        if($request->group_id !=''){
            $group_id = $request->group_id;
        }
        $groups = Group::get();
        $user_id = Auth::user()->id;
        $admin_role = Auth::user()->role;
        $tasks = Dailytask::orderBy('task', 'ASC')->get();
        $employeess = User::where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get(); 
        if($request->emp_id !=''){
            $employeess = User::where('id', $emp_id)->where('login_status', '1')->where('id','!=', '1')->orderBy('name', 'ASC')->get();  
        }
        if($request->group_id !=''){
            $employeess = User::where('login_status', '1')->where('group_id', $group_id)->orderBy('name', 'ASC')->get();
        }
        return view('admin.ideaboard.print',compact('date','employeess'));
    }
}