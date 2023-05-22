<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Hash;
use Auth;
use Illuminate\Support\Str;
class NotificationController extends Controller
{
    public function index(){
        $id = Auth::user()->id;
        $user_id = Auth::user()->role;
        if($user_id == '1'){
            $noti = Notification::orderBy('id','DESC')->get();
            $user = User::orderBy('id','DESC')->get();
            return view('admin.notification.index', compact('noti'));
        }else{
            $noti = Notification::where('type' , '2')->where('user_id' , $id)
            ->orWhere('type', '1')->get();
            return view('admin.notification.index', compact('noti'));    
        }
    }

    public function create_notification(Request $request){
        $user = User::orderBy('id','DESC')->get();
        return view('admin.notification.create', compact('user'));
    }

    public function store_notification(Request $request){ 
        if($request->hasFile('banner')) {
            $img_ext = $request->file('banner')->getClientOriginalExtension();
            $filename = 'noti-' . time() . '.' . $img_ext;
            $path = $request->file('banner')->move(public_path('admin/backend/notification'), $filename);//image save public folder
        }
        $data = array();
        $data['title']= $request->title;
        $data['message']= $request->description;
        if($request->type == "1"){
            $data['type']= $request->type;
        }elseif($request->type == "2"){
            $data['user_id']= $request->user_id;
            $data['type']= $request->type;
        }
        if(!empty($filename)){
            $data['file_name']   = $filename;
            $data['file_name_url']      = url('admin/backend/notification/'.$filename);
        }
        Notification::create($data);
        return redirect()->route('notification.index')->with('success','Notification Has Been Added successfully');
    }

    public function view_notification($id){
         $user = User::orderBy('id','DESC')->get();
        $view_notification = Notification::where('id',$id)->first();
        return view('admin.notification.view', compact('view_notification','user'));
    }
    public function delete_notification($id){
        $category = Notification::where('id',$id)->delete();
        return redirect()->route('notification.index');
    }

}