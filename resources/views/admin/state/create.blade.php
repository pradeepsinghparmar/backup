@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
               <h1 class="h3 mb-2 text-gray-800">Add State Registry</h1>
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
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">         
                        <div class="col-md-3">
                        </div>            
                        <div class="col-md-9">                          
                            <form action="{{ route('store_state') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">State Name</label>
                                    <div class="col-sm-9">
                                        <!-- <input type="text" name="name"  placeholder="State Name" class="form-control" required> -->
                                        <select name="name" class="form-control" id="name" required>
                                            <option value="Alabama">Alabama</option>
                                            <option value="Alaska">Alaska</option>
                                            <option value="Arizona">Arizona</option>
                                            <option value="Arkansas">Arkansas</option>
                                            <option value="California">California</option>
                                            <option value="Colorado">Colorado</option>
                                            <option value="Connecticut">Connecticut</option>
                                            <option value="Delaware">Delaware</option>
                                            <option value="District Of Columbia">District Of Columbia</option>
                                            <option value="Florida">Florida</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Hawaii">Hawaii</option>
                                            <option value="Idaho">Idaho</option>
                                            <option value="Illinois">Illinois</option>
                                            <option value="Indiana">Indiana</option>
                                            <option value="Iowa">Iowa</option>
                                            <option value="Kansas">Kansas</option>
                                            <option value="Kentucky">Kentucky</option>
                                            <option value="Louisiana">Louisiana</option>
                                            <option value="Maine">Maine</option>
                                            <option value="Maryland">Maryland</option>
                                            <option value="Massachusetts">Massachusetts</option>
                                            <option value="Michigan">Michigan</option>
                                            <option value="Minnesota">Minnesota</option>
                                            <option value="Mississippi">Mississippi</option>
                                            <option value="Missouri">Missouri</option>
                                            <option value="Montana">Montana</option>
                                            <option value="Nebraska">Nebraska</option>
                                            <option value="Nevada">Nevada</option>
                                            <option value="New Hampshire">New Hampshire</option>
                                            <option value="New Jersey">New Jersey</option>
                                            <option value="New Mexico">New Mexico</option>
                                            <option value="New York">New York</option>
                                            <option value="North Carolina">North Carolina</option>
                                            <option value="North Dakota">North Dakota</option>
                                            <option value="Ohio">Ohio</option>
                                            <option value="Oklahoma">Oklahoma</option>
                                            <option value="Oregon">Oregon</option>
                                            <option value="Pennsylvania">Pennsylvania</option>
                                            <option value="Rhode Island">Rhode Island</option>
                                            <option value="South Carolina">South Carolina</option>
                                            <option value="South Dakota">South Dakota</option>
                                            <option value="Tennessee">Tennessee</option>
                                            <option value="Texas">Texas</option>
                                            <option value="Utah">Utah</option>
                                            <option value="Vermont">Vermont</option>
                                            <option value="Virginia">Virginia</option>
                                            <option value="Washington">Washington</option>
                                            <option value="West Virginia">West Virginia</option>
                                            <option value="Wisconsin">Wisconsin</option>
                                            <option value="Wyoming">Wyoming</option>
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
                                            <input type="text" name="siu"  placeholder="SIT" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">Website</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="website"  placeholder="Website" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">User Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="user_name"  placeholder="User Name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">Password</label>
                                        <div class="col-sm-7">
                                            <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1 input-group-text"><i class="fas fa-eye-slash" id="eye"></i></div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label">Notes</label>
                                        <div class="col-sm-8">
                                            <input type="textarea" name="notes"  placeholder="Notes" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="row mb-1">
                                    <h2><label class="col-sm-12 col-form-label">SIU</label></h2>
                                </div>
                                <div style="border: 1px solid #ddd; margin: 5px; padding-top: 10px; padding-bottom: 10px;">
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">SUI</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="su"  placeholder="SUI" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">Website</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="siu_website"  placeholder="Website" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">User Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="siu_user_name"  placeholder="User Name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label required">Password</label>
                                        <div class="col-sm-7">
                                            <input type="password" name="siu_password" id="siu_password" placeholder="Password" class="form-control" required>
                                        </div>
                                        <div class="col-sm-1 input-group-text"><i class="fas fa-eye-slash" id="siu_eye"></i></div>
                                    </div>
                                    <div class="row mb-3 dd">
                                        <label class="col-sm-3 col-form-label">Notes</label>
                                        <div class="col-sm-8">
                                            <input type="textarea" name="siu_notes"  placeholder="Notes" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Comments</label>
                                    <div class="col-sm-9">
                                        <input type="textarea" name="comments"  placeholder="Comments" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label  class="col-sm-3 col-form-label">Update</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="updates"  placeholder="Update" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label required">Next Task</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="next_task"  placeholder="Next Task" class="form-control" required>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary" value="Save"> 
                            </form>
                        </div>                                
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        .required:after {
            content:" *";
            color: red;
        }
        i{
            cursor:pointer;
        }
        .dd{
            margin-left: 5px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        (function($) {
            $.fn.inputFilter = function(callback, errMsg) {
                return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e){
                    if (callback(this.value)) {
                        // Accepted value
                        if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
                          $(this).removeClass("input-error");
                          this.setCustomValidity("");
                        }
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                    // Rejected value - restore the previous one
                        $(this).addClass("input-error");
                        this.setCustomValidity(errMsg);
                        this.reportValidity();
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        // Rejected value - nothing to restore
                        this.value = "";
                    }
                });
            };
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
        }(jQuery));
        $("#name").select2({
            placeholder: "Select",
            allowClear: true,
        });
    </script>
@endsection