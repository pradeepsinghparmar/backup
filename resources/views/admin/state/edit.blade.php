@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Edit State Registry</h1>
            </div>
            <div class="col-md-2">
                <a href="{{ route('state_lists') }}" class="btn btn-dark btn-icon-split">
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!--<div class="card-header py-3">-->
            <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
            <!--</div>-->
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-custom alert-indicator-top indicator-danger" role="alert">
                        <div class="alert-content">
                            <span class="alert-title">Error!</span>
                            <span class="alert-text"> {{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-9">
                            <form action="{{ route('update_state',$editstate->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">State Name</label>
                                    <div class="col-sm-9">
                                        <!-- <input type="text" name="name" value="{{ $editstate->name }}" placeholder="PBM Name" class="form-control" required> -->
                                        <select name="name" class="form-control" id="name" required>
                                            <option value="Alabama" @if($editstate->name=='Alabama') selected @endif>Alabama</option>
                                            <option value="Alaska" @if($editstate->name=='Alaska') selected @endif>Alaska</option>
                                            <option value="Arizona" @if($editstate->name=='Arizona') selected @endif>Arizona</option>
                                            <option value="Arkansas" @if($editstate->name=='Arkansas') selected @endif>Arkansas</option>
                                            <option value="California" @if($editstate->name=='California') selected @endif>California</option>
                                            <option value="Colorado" @if($editstate->name=='Colorado') selected @endif>Colorado</option>
                                            <option value="Connecticut" @if($editstate->name=='Connecticut') selected @endif>Connecticut</option>
                                            <option value="Delaware" @if($editstate->name=='Delaware') selected @endif>Delaware</option>
                                            <option value="District Of Columbia" @if($editstate->name=='District Of Columbia') selected @endif>District Of Columbia</option>
                                            <option value="Florida" @if($editstate->name=='Florida') selected @endif>Florida</option>
                                            <option value="Georgia" @if($editstate->name=='Georgia') selected @endif>Georgia</option>
                                            <option value="Hawaii" @if($editstate->name=='Hawaii') selected @endif>Hawaii</option>
                                            <option value="Idaho" @if($editstate->name=='Idaho') selected @endif>Idaho</option>
                                            <option value="Illinois" @if($editstate->name=='Illinois') selected @endif>Illinois</option>
                                            <option value="Indiana" @if($editstate->name=='Indiana') selected @endif>Indiana</option>
                                            <option value="Iowa" @if($editstate->name=='Iowa') selected @endif>Iowa</option>
                                            <option value="Kansas" @if($editstate->name=='Kansas') selected @endif>Kansas</option>
                                            <option value="Kentucky" @if($editstate->name=='Kentucky') selected @endif>Kentucky</option>
                                            <option value="Louisiana" @if($editstate->name=='Louisiana') selected @endif>Louisiana</option>
                                            <option value="Maine" @if($editstate->name=='Maine') selected @endif>Maine</option>
                                            <option value="Maryland" @if($editstate->name=='Maryland') selected @endif>Maryland</option>
                                            <option value="Massachusetts" @if($editstate->name=='Massachusetts') selected @endif>Massachusetts</option>
                                            <option value="Michigan" @if($editstate->name=='Michigan') selected @endif>Michigan</option>
                                            <option value="Minnesota" @if($editstate->name=='Minnesota') selected @endif>Minnesota</option>
                                            <option value="Mississippi" @if($editstate->name=='Mississippi') selected @endif>Mississippi</option>
                                            <option value="Missouri" @if($editstate->name=='Missouri') selected @endif>Missouri</option>
                                            <option value="Montana" @if($editstate->name=='Montana') selected @endif>Montana</option>
                                            <option value="Nebraska" @if($editstate->name=='Nebraska') selected @endif>Nebraska</option>
                                            <option value="Nevada" @if($editstate->name=='Nevada') selected @endif>Nevada</option>
                                            <option value="New Hampshire" @if($editstate->name=='New Hampshire') selected @endif>New Hampshire</option>
                                            <option value="New Jersey" @if($editstate->name=='New Jersey') selected @endif>New Jersey</option>
                                            <option value="New Mexico" @if($editstate->name=='New Mexico') selected @endif>New Mexico</option>
                                            <option value="New York" @if($editstate->name=='New York') selected @endif>New York</option>
                                            <option value="North Carolina" @if($editstate->name=='North Carolina') selected @endif>North Carolina</option>
                                            <option value="North Dakota" @if($editstate->name=='North Dakota') selected @endif>North Dakota</option>
                                            <option value="Ohio" @if($editstate->name=='Ohio') selected @endif>Ohio</option>
                                            <option value="Oklahoma" @if($editstate->name=='Oklahoma') selected @endif>Oklahoma</option>
                                            <option value="Oregon" @if($editstate->name=='Oregon') selected @endif>Oregon</option>
                                            <option value="Pennsylvania" @if($editstate->name=='Pennsylvania') selected @endif>Pennsylvania</option>
                                            <option value="Rhode Island" @if($editstate->name=='Rhode Island') selected @endif>Rhode Island</option>
                                            <option value="South Carolina" @if($editstate->name=='South Carolina') selected @endif>South Carolina</option>
                                            <option value="South Dakota" @if($editstate->name=='South Dakota') selected @endif>South Dakota</option>
                                            <option value="Tennessee" @if($editstate->name=='Tennessee') selected @endif>Tennessee</option>
                                            <option value="Texas" @if($editstate->name=='Texas') selected @endif>Texas</option>
                                            <option value="Utah" @if($editstate->name=='Utah') selected @endif>Utah</option>
                                            <option value="Vermont" @if($editstate->name=='Vermont') selected @endif>Vermont</option>
                                            <option value="Virginia" @if($editstate->name=='Virginia') selected @endif>Virginia</option>
                                            <option value="Washington" @if($editstate->name=='Washington') selected @endif>Washington</option>
                                            <option value="West Virginia" @if($editstate->name=='West Virginia') selected @endif>West Virginia</option>
                                            <option value="Wisconsin" @if($editstate->name=='Wisconsin') selected @endif>Wisconsin</option>
                                            <option value="Wyoming" @if($editstate->name=='Wyoming') selected @endif>Wyoming</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <h2><label class="col-sm-12 col-form-label">SIT</label></h2>
                                </div>
                                <div style="border: 1px solid #ddd; margin: 5px; padding-top: 10px; padding-bottom: 10px;">
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">SIT</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="siu" value="{{ $editstate->siu }}" placeholder="SIT" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">Website</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="website" value="{{ $editstate->website }}" placeholder="Website" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">User Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="user_name"  placeholder="User Name" value="{{ $editstate->user_name }}"  class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">Password</label>
                                        <div class="col-sm-7">
                                            <input type="password" id="password" name="password" value="{{ $editstate->password }}"  placeholder="Password" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1 input-group-text"><i class="fas fa-eye-slash" id="eye"></i></div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label">Notes</label>
                                        <div class="col-sm-8">
                                            <input type="textarea" name="notes" value="{{ $editstate->notes }}"  placeholder="Notes" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <h2><label class="col-sm-12 col-form-label">SIU</label></h2>
                                </div>
                                <div style="border: 1px solid #ddd; margin: 5px; padding-top: 10px; padding-bottom: 10px;">
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">SIU</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="su" value="{{ $editstate->su }}" placeholder="SIU" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">Website</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="siu_website" value="{{ $editstate->siu_website }}" placeholder="Website" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">User Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="siu_user_name"  placeholder="User Name" value="{{ $editstate->siu_user_name }}"  class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">Password</label>
                                        <div class="col-sm-7">
                                            <input type="password" id="siu_password" name="siu_password" value="{{ $editstate->siu_password }}"  placeholder="Password" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1 input-group-text"><i class="fas fa-eye-slash" id="siu_eye"></i></div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label">Notes</label>
                                        <div class="col-sm-8">
                                            <input type="textarea" name="siu_notes" value="{{ $editstate->siu_notes }}" placeholder="Notes" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Comments</label>
                                    <div class="col-sm-9">
                                        <input type="textarea" name="comments" value="{{ $editstate->comments }}" placeholder="Comments" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label  class="col-sm-3 col-form-label">Update</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="updates" value="{{ $editstate->updates }}" placeholder="Update" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Next Task</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="next_task" value="{{ $editstate->next_task }}" placeholder="Next Task" class="form-control" required>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Update">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        i{
            cursor:pointer;
        }
        .required:after {
            content:" *";
            color: red;
        }
        .dd{
            margin-left: 5px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
    $(function(){
  
          $('#eye').click(function(){
               
                if($(this).hasClass('fa-eye-slash')){
                   
                  $(this).removeClass('fa-eye-slash');
                  
                  $(this).addClass('fa-eye');
                  
                  $('#password').attr('type','text');
                    
                }else{
                 
                  $(this).removeClass('fa-eye');
                  
                  $(this).addClass('fa-eye-slash');  
                  
                  $('#password').attr('type','password');
                }
            });
          $('#siu_eye').click(function(){
       
                if($(this).hasClass('fa-eye-slash')){
                   
                  $(this).removeClass('fa-eye-slash');
                  
                  $(this).addClass('fa-eye');
                  
                  $('#siu_password').attr('type','text');
                    
                }else{
                 
                  $(this).removeClass('fa-eye');
                  
                  $(this).addClass('fa-eye-slash');  
                  
                  $('#siu_password').attr('type','password');
                }
            });
            $("#name").select2({
                placeholder: "Select",
                allowClear: true,
            });
        });
    </script>
@endsection