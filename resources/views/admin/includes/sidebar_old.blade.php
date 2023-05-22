<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion _sidebar-style" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboards') }}">
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
    <li class="nav-item {{(Route::currentRouteName()=='employee_list' ||Route::currentRouteName()=='vendor_list' ||Route::currentRouteName()=='customer_list' ||Route::currentRouteName()=='project_list' ||Route::currentRouteName()=='task_list' ||Route::currentRouteName()=='create_employee'||Route::currentRouteName()=='edit_employee'||Route::currentRouteName()=='create_vendor'||Route::currentRouteName()=='edit_vendor'||Route::currentRouteName()=='create_customer'||Route::currentRouteName()=='edit_customer'||Route::currentRouteName()=='create_project'||Route::currentRouteName()=='edit_project'||Route::currentRouteName()=='create_task'||Route::currentRouteName()=='edit_task') ? 'active' : ''}}">
        <a class="nav-link {{(Route::currentRouteName()=='employee_list' ||Route::currentRouteName()=='vendor_list' ||Route::currentRouteName()=='customer_list' ||Route::currentRouteName()=='project_list' ||Route::currentRouteName()=='task_list' ||Route::currentRouteName()=='create_employee'||Route::currentRouteName()=='edit_employee'||Route::currentRouteName()=='create_vendor'||Route::currentRouteName()=='edit_vendor'||Route::currentRouteName()=='create_customer'||Route::currentRouteName()=='edit_customer'||Route::currentRouteName()=='create_project'||Route::currentRouteName()=='edit_project'||Route::currentRouteName()=='create_task'||Route::currentRouteName()=='edit_task') ? '' : 'collapsed'}}" href="#" data-toggle="collapse" data-target="#collapseTwo2"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data Build</span>
        </a>
        <div id="collapseTwo2" class="collapse {{(Route::currentRouteName()=='employee_list' ||Route::currentRouteName()=='vendor_list' ||Route::currentRouteName()=='customer_list' ||Route::currentRouteName()=='project_list' ||Route::currentRouteName()=='task_list' ||Route::currentRouteName()=='create_employee'||Route::currentRouteName()=='edit_employee'||Route::currentRouteName()=='create_vendor'||Route::currentRouteName()=='edit_vendor'||Route::currentRouteName()=='create_customer'||Route::currentRouteName()=='edit_customer'||Route::currentRouteName()=='create_project'||Route::currentRouteName()=='edit_project'||Route::currentRouteName()=='create_task'||Route::currentRouteName()=='edit_task') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
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
            </div>
        </div>
    </li>
    <li class="nav-item {{(Route::currentRouteName()=='attendance.index' ||Route::currentRouteName()=='reports' ||Route::currentRouteName()=='holiday_list' ||Route::currentRouteName()=='create_holiday' ||Route::currentRouteName()=='edit_holiday') ? 'active' : ''}}">
        <a class="nav-link {{(Route::currentRouteName()=='attendance.index' ||Route::currentRouteName()=='reports' ||Route::currentRouteName()=='holiday_list' ||Route::currentRouteName()=='create_holiday' ||Route::currentRouteName()=='edit_holiday'  || Route::currentRouteName()=='attendencelist') ? 'collapsed' : ''}}" href="#" data-toggle="collapse" data-target="#collapseTwo3"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Time Entry</span>
        </a>
        <div id="collapseTwo3" class="collapse {{(Route::currentRouteName()=='attendance.index' ||Route::currentRouteName()=='reports' ||Route::currentRouteName()=='holiday_list' ||Route::currentRouteName()=='create_holiday' ||Route::currentRouteName()=='edit_holiday'  || Route::currentRouteName()=='attendencelist') ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @if(App\Models\Permission::admin_permission('attendanc_list'))
                    <!-- <a class="collapse-item" href="{{ route('attendance.index') }}">Attendance</a> -->
                    <a class="collapse-item" href="{{ route('attendencelist') }}">Attendance</a>
                @endif
                @if(App\Models\Permission::admin_permission('reports'))
                    <a class="collapse-item" href="{{ route('reports') }}">Reports</a>
                @endif
                @if(App\Models\Permission::admin_permission('holiday_calender'))
                <a class="collapse-item" href="{{ route('holiday_list') }}">HoliDay Calender</a>
                @endif
            </div>
        </div>
    </li>
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
    @if(App\Models\Permission::admin_permission('notification'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('reports') }}">
                <i class="fas fa-random"></i>
                <span>Reports</span>
            </a>
        </li>
    @endif
    @if(App\Models\Permission::admin_permission('leave'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('leave_list') }}">
                <i class="fas fa-random"></i>
                <span>Leave Application</span>
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