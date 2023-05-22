 @extends('admin.layout')

@section('content')
 <div class="app-content _profile-style">
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="page-description page-description-tabbed _title-style">
                                    <h1 class="h3 mb-2 text-gray-800">Settings</h1>

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="hoaccountme" aria-selected="true">My Profile</button>
                                        </li>
                                        <!--<li class="nav-item" role="presentation">-->
                                        <!--    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">Security</button>-->
                                        <!--</li>-->
                                        <!--<li class="nav-item" role="presentation">-->
                                        <!--    <button class="nav-link" id="integrations-tab" data-bs-toggle="tab" data-bs-target="#integrations" type="button" role="tab" aria-controls="integrations" aria-selected="false">Integrations</button>-->
                                        <!--</li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                                        @if ($errors->any())

                                            <div class="alert alert-danger">
                                        
                                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        
                                                <ul>
                                        
                                                    @foreach ($errors->all() as $error)
                                        
                                                        <li>{{ $error }}</li>
                                        
                                                    @endforeach
                                        
                                                </ul>
                                        
                                            </div>
                                        
                                        @endif
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
                                        <form action="{{ route('update_profile',[$profile->id]) }}"  method='post' enctype="multipart/form-data">
                                        <!--<form action="#" method="POST">-->
                                        @csrf
    <input type="hidden" name="_method" value="put">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                  <div class="col-md-12"> 
                                                  <div class="row">
                                                  <div class="col-md-4">
                                                         <div class="row m-t-xxl">
                                                                    <div class="col-md-12">
                                                                        <label for="settingsInputEmail" class="form-label">Name</label>
                                                        <input type="text" name="name" class="form-control" id="settingsInputEmail" value="{{$profile->name}}" aria-describedby="settingsEmailHelp" placeholder="Enter Name">

                                                                    </div>
                                                                </div> 
                                                                
                                                                 <div class="row m-t-xxl">
                                                                    <div class="col-md-12">
                                                                        <label for="settingsInputEmail" class="form-label">Email address</label>
                                                        <input type="email" name="email" class="form-control" id="settingsInputEmail" aria-describedby="settingsEmailHelp"  value="{{$profile->email}}"  placeholder="example@neptune.com">


                                                                    </div>
                                                                </div> 
                                                                
                                                                <div class="row m-t-xxl">
                                                                    <div class="col-md-12">
                                                                         <label for="settingsPhoneNumber" class="form-label">Phone Number</label>
                                                        <input type="number" name="phone" class="form-control" id="settingsPhoneNumber" placeholder="(xxx) xxx-xxxx"  value="{{$profile->phone}}" >



                                                                    </div>
                                                                </div> 
                                                                
                                                        </div>
                                    
                                                   <div class="col-md-4">
                                                        <div class="row m-t-xxl">
                                                                    <div class="col-md-12">
                                                                        <label for="settingsNewPassword" class="form-label">New Password</label>
                                                        <input type="password" name="new_password" id="new_password" class="form-control" aria-describedby="settingsNewPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">



                                                                    </div>
                                                                </div> 
                                                                
                                                                
                                                                 <div class="row m-t-xxl">
                                                                    <div class="col-md-12">
                                                                       <label for="settingsConfirmPassword" class="form-label">Confirm Password</label>
                                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" aria-describedby="settingsConfirmPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">




                                                                    </div>
                                                                </div> 
                                                       </div>
                                    
                                    
                                                    <div class="col-md-4">
                                                        
                                                      
                                                        <div class="row m-t-xxl">
                                                                    <div class="col-md-12">
                                                                        @if($profile->image_url != null)
                                             <div class="avatar avatar-rounded">
                                                <img src="{{ $profile->image_url }}" alt="Banner">
                                            </div>
                                        @else
                                           <div class="avatar avatar-rounded">
                                                <img src="{{ asset('admin/assets/img/undraw_profile.svg') }}" alt="Banner">
                                            </div>
                                        @endif
                                                                    </div>
                                                                </div>  
                                                        <br>
                                                         <div class="row m-t-xxl">
                                                                    <div class="col-md-12 file-input">
                                                                        <input type="file" name="banner" class="form-control file-input__input" id="file-input">
                                                                        <label for="settingsNewPassword" class="form-label file-input__label">
                                                                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload" class="svg-inline--fa fa-upload fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                          <path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"
                                                                          ></path>
                                                                        </svg>
                                                                        <span>Upload file</span></label>
                                                                    </div>
                                                                </div>  
                                                        
                                                        </div>
                                                        </div>
                                        </div>
                                    
                                                <!--<div class="row m-t-lg">-->
                                                <!--    <div class="col">-->
                                                <!--        <label for="settingsAbout" class="form-label">About</label>-->
                                                <!--        <textarea class="form-control" name="about" id="settingsAbout" maxlength="500" rows="4" aria-describedby="settingsAboutHelp"></textarea>-->
                                                <!--        <div id="emailHelp" class="form-text">Brief information about you to display on profile (max: 500 characters)</div>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                               
                                                        <br>
                                                  <div class="col-md-12"> 
                                                  <div class="col-md-6" style="float:left;">
                                                        <br><input type="submit" class="btn btn-primary m-t-sm" value="Update Profile" id="btnSubmit">
                                                </div>
                                                 </div>       
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                        <div class="card">
                                            <div class="card-body">
                                                <form class="form-horizontal" method="POST" action="{{ route('changePasswordPost') }}">
                                                 @csrf
                                                <!--<div class="settings-security-two-factor">-->
                                                <!--    <h5>Two-Factor Authentication</h5>-->
                                                <!--    <span>Two-factor authentication is automatically enabled on your account, for security reasons we require all users to authenticate with SMS code or authorized third-party auth apps. Read more about our security policy <a href="#">here</a>.</span>-->
                                                <!--</div>-->
                                                <div class="row m-t-xxl">
                                                    <div class="col-md-6">
                                                        <label for="settingsCurrentPassword" class="form-label">Current Password</label>
                                                        <input type="password" name="old_password" class="form-control" aria-describedby="settingsCurrentPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                                        <!--<div id="settingsCurrentPassword" class="form-text">Never share your password with anyone.</div>-->
                                                    </div>
                                                </div>
                                                <div class="row m-t-xxl">
                                                    <div class="col-md-6">
                                                        <label for="settingsNewPassword" class="form-label">New Password</label>
                                                        <input type="password" name="new_password" class="form-control" aria-describedby="settingsNewPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                                    </div>
                                                </div>
                                                <div class="row m-t-xxl">
                                                    <div class="col-md-6">
                                                        <label for="settingsConfirmPassword" class="form-label">Confirm Password</label>
                                                        <input type="password" name="confirm_password" class="form-control" aria-describedby="settingsConfirmPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                                    </div>
                                                </div>
                                                <!--<div class="row m-t-xxl">-->
                                                <!--    <div class="col-md-6">-->
                                                <!--        <label for="settingsSmsCode" class="form-label">SMS Code</label>-->
                                                <!--        <div class="input-group">-->
                                                <!--            <input type="password" class="form-control" aria-describedby="settingsSmsCode" placeholder="&#9679;&#9679;&#9679;&#9679;">-->
                                                <!--            <button class="btn btn-primary btn-style-light" id="settingsResentSmsCode">Resend</button>-->
                                                <!--        </div>-->
                                                <!--        <div id="settingsSmsCode" class="form-text">Code will be sent to the phone number from your account.</div>-->
                                                <!--    </div>-->
                                                <!--</div>-->
                                                <div class="row m-t-lg">
                                                    <div class="col">
                                                        <!--<div class="form-check">-->
                                                        <!--    <input class="form-check-input" type="checkbox" value="" id="settingsPasswordLogout" checked>-->
                                                        <!--    <label class="form-check-label" for="settingsPasswordLogout">-->
                                                        <!--        Log out from all current sessions-->
                                                        <!--    </label>-->
                                                        <!--</div>-->
                                                        <input type="submit" class="btn btn-primary m-t-sm" value="Change Password">
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="integrations" role="tabpanel" aria-labelledby="integrations-tab">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="settings-integrations">
                                                    <div class="settings-integrations-item">
                                                        <div class="settings-integrations-item-info">
                                                            <img src="{{ asset('admin/assets/assets/images/icons/jira_software.png') }}" alt="">
                                                            <span>Plan, track, and manage your agile and software development projects in Jira.</span>
                                                        </div>
                                                        <div class="settings-integrations-item-switcher">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input form-control-md" type="checkbox" id="settingsIntegrationOneSwitcher" checked>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="settings-integrations-item">
                                                        <div class="settings-integrations-item-info">
                                                            <img src="{{ asset('admin/assets/assets/images/icons/confluence.png') }}" alt="">
                                                            <span>Build, organize, and collaborate on work in one place from virtually anywhere.</span>
                                                        </div>
                                                        <div class="settings-integrations-item-switcher">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input form-control-md" type="checkbox" id="settingsIntegrationTwoSwitcher" checked>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="settings-integrations-item">
                                                        <div class="settings-integrations-item-info">
                                                            <img src="{{ asset('admin/assets/assets/images/icons/bitbucket.png') }}" alt="">
                                                            <span>Build, test, and deploy with unlimited private or public space with Bitbucket.</span>
                                                        </div>
                                                        <div class="settings-integrations-item-switcher">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input form-control-md" type="checkbox" id="settingsIntegrationThreeSwitcher">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="settings-integrations-item">
                                                        <div class="settings-integrations-item-info">
                                                            <img src="{{ asset('admin/assets/assets/images/icons/sourcetree.png') }}" alt="">
                                                            <span>A Git GUI that offers a visual representation of your repositories.</span>
                                                        </div>
                                                        <div class="settings-integrations-item-switcher">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input form-control-md" type="checkbox" id="settingsIntegrationFourSwitcher">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
              <script src="https://owlok.in/jwpl/public/admin/assets/vendor/jquery/jquery.min.js"></script>        
            
             <script type="text/javascript">
    $(function () {
        $("#btnSubmit").click(function () {
            var password = $("#new_password").val();
            var confirmPassword = $("#confirm_password").val();
            if (password != confirmPassword) {
                alert("confirm password do not match.");
                return false;
            }
            return true;
        });
    });
</script>
@endsection