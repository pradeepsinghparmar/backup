@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">All Customer</h1>
            </div>
            <div class="col-md-2">
                @if(App\Models\Userpermission::get_permission('customer_master','is_create'))
                    <a href="{{ route('create_customer') }}" class="btn btn-info btn-icon-split">
                        <span class="text">Add Customer</span>
                    </a>
                @endif
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!--<div class="card-header py-3">-->
            <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
            <!--</div>-->
            <div class="container-fluid"><br>
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
                <div class="card-body">
                    <div class="table-responsive">
                         <table class="export_example">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Customer Id</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    @if(App\Models\Userpermission::get_permission('customer_master','is_edit') || App\Models\Userpermission::get_permission('customer_master','is_delete')) 
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <!-- <tfoot>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Customer Id</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    @if(App\Models\Userpermission::get_permission('customer_master','is_edit') || App\Models\Userpermission::get_permission('customer_master','is_delete')) 
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </tfoot> -->
                            <tbody>
                                @php $i = 0;@endphp
                                @foreach($staff as $key => $staff)
                                    @php $i++;@endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $staff->customer_id }}</td>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ $staff->address }}</td>
                                        <td>{{ $staff->phone }}</td>
                                        <td>{{ $staff->email }}</td>
                                        @if(App\Models\Userpermission::get_permission('customer_master','is_edit')) 
                                            <td>
                                                <div class="form-check form-switch">
                                                    @if($staff->status == '1')
                                                        <input class="form-check-input" type="checkbox"id="{{ $staff->id }}" onclick="publishUser(this);" checked="">
                                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                    @elseif($staff->status == '0')
                                                        <input class="form-check-input" type="checkbox" id="{{ $staff->id }}" onclick="publishUser(this);">
                                                        <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                                                    @endif
                                                </div>
                                            </td>
                                        @else
                                            <td>@if($staff->status==1) Active @else Deactive @endif</td>
                                        @endif
                                        @if(App\Models\Userpermission::get_permission('customer_master','is_edit') || App\Models\Userpermission::get_permission('customer_master','is_delete')) 
                                            <td> 
                                                @if(App\Models\Userpermission::get_permission('customer_master','is_edit')) 
                                                    <a class="btn btn-success btn-circle btn-sm"  href="{{route('edit_customer', $staff->id)}}"  title="Edit"><i class="fas fa-edit"></i></a>
                                                @endif
                                                @if(App\Models\Userpermission::get_permission('customer_master','is_delete'))    
                                                    <a   class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;" href="{{route('delete_customer', $staff->id)}}"  title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
{{ csrf_field() }}

<script>
function publishUser(sender) {
    var _token = $('input[name="_token"]').val();
    var staff_id = sender.id;
    //if (!confirm('Are you sure? you want to delete this info')) return false;
    $.ajax({ 
        url: "{{ route('change_customer_status') }}",
        method: 'POST',
        data:{staff_id:staff_id, _token:_token},

        success: function(data) {
            if(data == "0"){
                alert('Active Successfully');
                location.reload();
            }else if(data == "1"){
                alert('Inactive Successfully');
                location.reload();
            }
        } 
    });
}
</script>
@endsection