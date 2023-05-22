<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SiteManagement;
use Hash;
class SiteManagementController extends Controller
{
    public function index(){
        $site_management = SiteManagement::orderBy('id','DESC')->get();
        return view('admin.site_management.index', compact('site_management'));
    }
    
    
    public function create_site_management(Request $request){
        return view('admin.site_management.create');
    }

    public function store_site_management(Request $request)
        {
            $data = array();
            $data['site_name']= $request->site_name;
            $data['building_no_name']= $request->building_no_name;
            $data['street_name']= $request->street_name;
            $data['city']= $request->city;
            $data['postcode']= $request->postcode;
            $data['description']= $request->description;
            $data['google_map_location']= $request->google_map_location;
          
            SiteManagement::create($data);
            return redirect()->route('site_management.index')->with('success','Site Management Has Been Added successfully');
        }
        
    public function delete_site_management($id){
        $del = SiteManagement::where('id',$id)->delete();   
        return redirect()->route('site_management.index');
    }
    
     public function view_site_management($id){
        $view_site_management = SiteManagement::where('id',$id)->first();
        return view('admin.site_management.view', compact('view_site_management'));
    }
    
     public function edit_site_management($id){
        $edit_site_management = SiteManagement::where('id',$id)->first();
        return view('admin.site_management.edit', compact('edit_site_management'));
    }
    
      public function update_site_management(Request $request, $id)
        {
            $data = array();
            $data['building_no_name']= $request->building_no_name;
            $data['site_name']= $request->site_name;
            $data['street_name']= $request->street_name;
            $data['city']= $request->city;
            $data['postcode']= $request->postcode;
            $data['description']= $request->description;
            $data['google_map_location']= $request->google_map_location;
          
            SiteManagement::where('id',$id)->update($data);
            return redirect()->route('site_management.index')->with('success','Site Management Has Been Updated successfully');
        }
    
        
     
   
        
  
}