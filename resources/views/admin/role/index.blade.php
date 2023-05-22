@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Manage Role</h1>
            </div>
            <div class="col-md-2">
            </div>
       </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
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
                <!--<div class="card-header py-3">-->
                <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
                <!--</div>-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="export_example">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Added On</th>
                                    @if(App\Models\Userpermission::get_permission('role_list','is_edit'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($role as $key => $staff)
                                    <tr>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ date('d M y H:i A',strtotime($staff->created_at)) }}</td>
                                        @if(App\Models\Userpermission::get_permission('role_list','is_edit'))
                                            <td>
                                                <a class="btn btn-success btn-circle btn-sm"  href="{{route('edit_role_permission', $staff->role_id)}}"  title="Edit"><i class="fas fa-edit"></i></a>
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
	$.ajax({ 
		url: "{{ route('change_user_status') }}",
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