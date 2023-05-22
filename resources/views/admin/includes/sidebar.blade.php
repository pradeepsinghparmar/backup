<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion _sidebar-style" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboards') }}" style="background-color: #fff;">
        <div class="sidebar-brand-icon rotate-n-15">
            <!--<i class="fas fa-laugh-wink"></i>-->
            <img src="{{ asset('admin/assets/css/aa.png') }}" width="120">
        </div>
        <!--<div class="sidebar-brand-text mx-3">JWP</div>-->
    </a>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboards') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    @if(Auth::user()->id!=1)
    <li class="nav-item">
        <a class="nav-link" href="{{ route('timemanagement') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>My Time Management</span>
        </a>
    </li>
    @endif
    @if(App\Models\Permission::admin_permission('attendanc_list'))
        <li class="nav-item {{(Route::currentRouteName()=='attendance.index') ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('attendance.index') }}">
                <i class="fas fa-random"></i>
                <span>Monthly Attendence</span>
            </a>
        </li>
    @endif


    @if(App\Models\Permission::admin_permission('role_list') || App\Models\Permission::admin_permission('permission_list'))
        <li class="nav-item {{(Route::currentRouteName()=='role_lists') ||(Route::currentRouteName()=='role_list') ? 'active' : ''}}">
            <a class="nav-link {{(Route::currentRouteName()=='role_lists') ||(Route::currentRouteName()=='role_list') ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapse1"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Admin</span>
            </a>
            <div id="collapse1" class="collapse {{(Route::currentRouteName()=='role_lists') ||(Route::currentRouteName()=='role_list') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if(App\Models\Permission::admin_permission('role_list'))
                        <a class="collapse-item" href="{{ route('role_lists') }}">User Role</a>
                    @endif
                    @if(App\Models\Permission::admin_permission('permission_list'))
                        <a class="collapse-item" href="{{ route('role_list') }}">User Permission</a>
                    @endif
                </div>
            </div>
        </li>
    @endif
    
    @if(App\Models\Permission::admin_permission('employee_list') || App\Models\Permission::admin_permission('vendor') || App\Models\Permission::admin_permission('customer_master') || App\Models\Permission::admin_permission('project_master') || App\Models\Permission::admin_permission('task_master') || App\Models\Permission::admin_permission('group'))
        <li class="nav-item {{(Route::currentRouteName()=='group_list' || Route::currentRouteName()=='employee_list' ||Route::currentRouteName()=='vendor_list' ||Route::currentRouteName()=='customer_list' ||Route::currentRouteName()=='project_list' ||Route::currentRouteName()=='task_list' ||Route::currentRouteName()=='create_employee'||Route::currentRouteName()=='edit_employee'||Route::currentRouteName()=='create_vendor'||Route::currentRouteName()=='edit_vendor'||Route::currentRouteName()=='create_customer'||Route::currentRouteName()=='edit_customer'||Route::currentRouteName()=='create_project'||Route::currentRouteName()=='edit_project'||Route::currentRouteName()=='create_task'||Route::currentRouteName()=='edit_task') ? 'active' : ''}}">
        <a class="nav-link {{(Route::currentRouteName()=='group_list' || Route::currentRouteName()=='employee_list' ||Route::currentRouteName()=='vendor_list' ||Route::currentRouteName()=='customer_list' ||Route::currentRouteName()=='project_list' ||Route::currentRouteName()=='task_list' ||Route::currentRouteName()=='create_employee'||Route::currentRouteName()=='edit_employee'||Route::currentRouteName()=='create_vendor'||Route::currentRouteName()=='edit_vendor'||Route::currentRouteName()=='create_customer'||Route::currentRouteName()=='edit_customer'||Route::currentRouteName()=='create_project'||Route::currentRouteName()=='edit_project'||Route::currentRouteName()=='create_task'||Route::currentRouteName()=='edit_task') ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTwo2"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data Build</span>
        </a>
        <div id="collapseTwo2" class="collapse {{(Route::currentRouteName()=='group_list' || Route::currentRouteName()=='employee_list' ||Route::currentRouteName()=='vendor_list' ||Route::currentRouteName()=='customer_list' ||Route::currentRouteName()=='project_list' ||Route::currentRouteName()=='task_list' ||Route::currentRouteName()=='create_employee'||Route::currentRouteName()=='edit_employee'||Route::currentRouteName()=='create_vendor'||Route::currentRouteName()=='edit_vendor'||Route::currentRouteName()=='create_customer'||Route::currentRouteName()=='edit_customer'||Route::currentRouteName()=='create_project'||Route::currentRouteName()=='edit_project'||Route::currentRouteName()=='create_task'||Route::currentRouteName()=='edit_task') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if(App\Models\Permission::admin_permission('employee_list'))
                <a class="collapse-item" href="{{ route('employee_list') }}">Employee Master</a>
                @endif
                @if(App\Models\Permission::admin_permission('vendor'))
                <a class="collapse-item" href="{{ route('vendor_list') }}">Vendor Master</a>
                @endif
                @if(App\Models\Permission::admin_permission('customer_master'))
                <a class="collapse-item" href="{{ route('customer_list') }}">Customer Master</a>
                @endif
                @if(App\Models\Permission::admin_permission('project_master'))
                <a class="collapse-item" href="{{ route('project_list') }}">Project Master</a>
                @endif
                @if(App\Models\Permission::admin_permission('task_master'))
                <a class="collapse-item" href="{{ route('task_list') }}">Task Master</a>
                @endif
                @if(App\Models\Permission::admin_permission('group'))
                <a class="collapse-item" href="{{ route('group_list') }}">Group Master</a>
                @endif
            </div>
        </div>
    </li>
    @endif
    <li class="nav-item {{(Route::currentRouteName()=='attendance.index' ||Route::currentRouteName()=='reports' ||Route::currentRouteName()=='holiday_list' ||Route::currentRouteName()=='create_holiday' ||Route::currentRouteName()=='edit_holiday') ? 'active' : ''}}">
        <a class="nav-link {{(Route::currentRouteName()=='attendance.index' ||Route::currentRouteName()=='reports' ||Route::currentRouteName()=='holiday_list' ||Route::currentRouteName()=='create_holiday' ||Route::currentRouteName()=='edit_holiday' || Route::currentRouteName()=='attendencelist') ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTwo3"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Time Entry Report</span>
        </a>
        <div id="collapseTwo3" class="collapse {{(Route::currentRouteName()=='attendance.index' ||Route::currentRouteName()=='reports' ||Route::currentRouteName()=='holiday_list' ||Route::currentRouteName()=='create_holiday' ||Route::currentRouteName()=='edit_holiday' || Route::currentRouteName()=='attendencelist') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if(App\Models\Permission::admin_permission('reports'))
                    <a class="collapse-item" href="{{ route('reports') }}">My  Daily Time</a>
                    <!--<a class="collapse-item" >My Timesheet</a>-->
                @endif
                @if(App\Models\Permission::admin_permission('attendanc_list'))
                    <!-- <a class="collapse-item" href="{{ route('attendance.index') }}">Attendance</a> -->
                    <a class="collapse-item" href="{{ route('attendencelist') }}">My Team Time</a>
                @endif
                @if(App\Models\Permission::admin_permission('attendanc_list'))
                    <!-- <a class="collapse-item" href="{{ route('attendance.index') }}">Attendance</a> -->
                    <a class="collapse-item" href="{{ route('attendance.index') }}">Monthly Attendence Report</a>
                @endif
                @if(App\Models\Permission::admin_permission('holiday_calender'))
                <a class="collapse-item" href="{{ route('holiday_list') }}">HoliDay Calender</a>
                @endif
            </div>
        </div>
    </li>

    @if(App\Models\Permission::admin_permission('activity_reports'))
        <li class="nav-item {{ (Route::currentRouteName()=='activity_reports' || Route::currentRouteName()=='activity_reports_weekly' || Route::currentRouteName()=='activity_reports_monthly') ? 'active' : ''}}">
            <a class="nav-link  {{ (Route::currentRouteName()=='activity_reports' || Route::currentRouteName()=='activity_reports_weekly' || Route::currentRouteName()=='activity_reports_monthly') ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTwo4"
                aria-expanded="true" aria-controls="collapseTwo4">
                <i class="fas fa-fw fa-user"></i>
                <span>All Reports</span>
            </a>
            <div id="collapseTwo4" class="collapse {{ (Route::currentRouteName()=='activity_reports' || Route::currentRouteName()=='activity_reports_weekly' || Route::currentRouteName()=='activity_reports_monthly') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('activity_reports') }}">Daily Task Report</a>
                    <a class="collapse-item" href="{{ route('activity_reports_weekly') }}">Weekly Task Report</a>
                    <a class="collapse-item" href="{{ route('activity_reports_monthly') }}">Monthly Task Report</a>
                </div>
            </div>
        </li> 
    @endif

    @if(App\Models\Permission::admin_permission('timesheet'))
        <!-- <li class="nav-item">
            <a class="nav-link" href="{{ route('timesheet') }}">
                <i class="fas fa-random"></i>
                <span>Timesheet</span>
            </a>
        </li> -->

        <li class="nav-item {{ (Route::currentRouteName()=='timesheet' || Route::currentRouteName()=='my_activity') ? 'active' : ''}}">
            <a class="nav-link  {{ (Route::currentRouteName()=='timesheet' || Route::currentRouteName()=='my_activity') ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTwo1"
                aria-expanded="true" aria-controls="collapseTwo1">
                <i class="fas fa-fw fa-user"></i>
                <span>Timesheet</span>
            </a>
            <div id="collapseTwo1" class="collapse {{ (Route::currentRouteName()=='timesheet' || Route::currentRouteName()=='my_activity') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('timesheet') }}">Add Timesheet</a>
                    <a class="collapse-item" href="{{ route('my_activity') }}">My Activity</a>
                </div>
            </div>
        </li> 
    @endif

    @if(App\Models\Permission::admin_permission('state_registry'))
        <li class="nav-item {{(Route::currentRouteName()=='state_lists') ? 'active' : ''}}">
            <a class="nav-link {{(Route::currentRouteName()=='state_lists') ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapsestate"
                aria-expanded="true" aria-controls="collaps">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Finance</span>
            </a>
            <div id="collapsestate" class="collapse {{(Route::currentRouteName()=='state_lists') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if(App\Models\Permission::admin_permission('state_registry'))
                        <a class="collapse-item" href="{{ route('state_lists') }}">State Registry</a>
                    @endif
                </div>
            </div>
        </li>
    @endif


    @if(App\Models\Permission::admin_permission('daily_task') || App\Models\Permission::admin_permission('task_assignment') || App\Models\Permission::admin_permission('idea_board'))
        <li class="nav-item {{(Route::currentRouteName()=='assigntask_list' || Route::currentRouteName()=='dailytask_list' || Route::currentRouteName()=='board' ) ? 'active' : ''}}">
        <a class="nav-link {{(Route::currentRouteName()=='dailytask_list' || Route::currentRouteName()=='board' || Route::currentRouteName()=='assigntask_list') ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTwoone"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Idea Board</span>
        </a>
        <div id="collapseTwoone" class="collapse {{(Route::currentRouteName()=='assigntask_list' || Route::currentRouteName()=='dailytask_list' || Route::currentRouteName()=='board') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if(App\Models\Permission::admin_permission('daily_task'))
                <a class="collapse-item" href="{{ route('dailytask_list') }}">Daily Tasks</a>
                @endif
                @if(App\Models\Permission::admin_permission('task_assignment'))
                <a class="collapse-item" href="{{ route('assigntask_list') }}">Tasks Assignments</a>
                @endif
                @if(App\Models\Permission::admin_permission('idea_board'))
                <a class="collapse-item" href="{{ route('board') }}">Idea Board</a>
                @endif
            </div>
        </div>
    </li>
    @endif

    <!-- <li class="nav-item">
            <a class="nav-link" href="{{ route('my_activity') }}">
                <i class="fas fa-random"></i>
                <span>My Activity</span>
            </a>
        </li> -->
    @if(App\Models\Permission::admin_permission('employee_list'))
        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo1"
                aria-expanded="true" aria-controls="collapseTwo1">
                <i class="fas fa-fw fa-user"></i>
                <span>Employee Management</span>
            </a>
            <div id="collapseTwo1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('attendance.index') }}">Attendance List</a>
                    <a class="collapse-item" href="{{ route('holiday_list') }}">Holiday List</a>
                </div>
            </div>
        </li> -->
    @endif

    @if(App\Models\Permission::admin_permission('attendanc_list'))
    <!-- <li class="nav-item">
        <a class="nav-link" href="{{ route('attendencelist') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Attendance List</span></a>
    </li> -->
    @endif
    @if(App\Models\Permission::admin_permission('notification'))
        <li class="nav-item {{(Route::currentRouteName()=='create_notification' ||Route::currentRouteName()=='notification.index' ||Route::currentRouteName()=='activity_list') ? 'active' : ''}}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Notification</span>
            </a>
            <div id="collapseUtilities" class="collapse {{(Route::currentRouteName()=='create_notification' ||Route::currentRouteName()=='notification.index' ||Route::currentRouteName()=='activity_list') ? 'show' : ''}}" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if(App\Models\Userpermission::get_permission('notification','is_create'))
                        <a class="collapse-item" href="{{ route('create_notification') }}">Add Notification</a>
                    @endif
                    <a class="collapse-item" href="{{ route('notification.index') }}">Notification List</a>
                    <a class="collapse-item" href="{{ route('activity_list') }}">Recent Activity List</a>
                </div>
            </div>
        </li>
    @endif



    @if(App\Models\Permission::admin_permission('pmt') || App\Models\Permission::admin_permission('weekly_target'))
        <li class="nav-item {{(Route::currentRouteName()=='pmt_lists' || Route::currentRouteName()=='create_weekly_target' || Route::currentRouteName()=='searchweeklytarget') ? 'active' : ''}}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#performance"
                aria-expanded="true" aria-controls="performance">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Performance Matrix</span>
            </a>
            <div id="performance" class="collapse {{(Route::currentRouteName()=='pmt_lists' || Route::currentRouteName()=='create_weekly_target' || Route::currentRouteName()=='searchweeklytarget') ? 'show' : ''}}" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if(App\Models\Permission::admin_permission('pmt'))
                        <a class="collapse-item" href="{{ route('pmt_lists') }}">PMT</a>
                    @endif
                    @if(App\Models\Permission::admin_permission('weekly_target'))
                    <a class="collapse-item" href="{{ route('searchweeklytarget') }}">Weekly Target</a>
                    @endif
                    @if(App\Models\Permission::admin_permission('weekly_target_actual'))
                    <a class="collapse-item" href="{{ route('weeklytargetactual') }}">Weekl Actual</a>
                    @endif
                    <!-- <a class="collapse-item" href="{{ route('activity_list') }}">Recent Activity List</a> -->
                </div>
            </div>
        </li>
    @endif


    @if(App\Models\Permission::admin_permission('lead'))
        <li class="nav-item {{(Route::currentRouteName()=='lead') ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('lead') }}">
                <i class="fas fa-random"></i>
                <span>Lead Generation</span>
            </a>
        </li>
    @endif

    @if(App\Models\Permission::admin_permission('event'))
        <li class="nav-item {{(Route::currentRouteName()=='event') ? 'active' : ''}}">
            <a class="nav-link" href="{{ route('event') }}">
                <i class="fas fa-random"></i>
                <span>Event</span>
            </a>
        </li>
    @endif
   
    @if(App\Models\Permission::admin_permission('notification'))
        <!--<li class="nav-item">-->
        <!--    <a class="nav-link" href="{{ route('reports') }}">-->
        <!--        <i class="fas fa-random"></i>-->
        <!--        <span>Reports</span>-->
        <!--    </a>-->
        <!--</li>-->
    @endif
    @if(App\Models\Permission::admin_permission('leave'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('leave_list') }}">
                <i class="fas fa-random"></i>
                <span>Leave Application</span>
            </a>
        </li>
    @endif

    @if(App\Models\Permission::admin_permission('leave_list'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('leave_all') }}">
                <i class="fas fa-random"></i>
                <span>Leave List</span>
            </a>
        </li>
    @endif
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
            Logout
        </a>
    </li>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    <!-- Sidebar Message -->
</ul>
<!-- End of Sidebar -->