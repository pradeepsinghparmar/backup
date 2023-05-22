@extends('admin.layout')
@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-md-10">
           <h1 class="h3 mb-2 text-gray-800">All Role</h1>
        </div>
        <div class="col-md-2">
            <a href="{{ route('create_role') }}" class="btn btn-info btn-icon-split">
                <span class="text">Add Role</span>
            </a>
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
                                <th>Role</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>S.No.</th>
                                <th>Role</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php $i = 0;@endphp
                            @foreach($roles as $key => $role)
                                @php $i++;@endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                       @if($role->role_status == 1) Active @else Deactive  @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-circle btn-sm"  href="{{route('edit_roles', $role->role_id)}}" title="Edit"><i class="fas fa-edit"></i></a>
                                        <!-- <a class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;"   href="{{route('delete_role', $role->role_id)}}" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a> -->
                                    </td>
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