@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">All Holiday List</h1>
            </div>
            <div class="col-md-2">
                @if(App\Models\Userpermission::get_permission('holiday_calender','is_create'))
                    <a href="{{ route('create_holiday') }}" class="btn btn-info btn-icon-split">
                        <span class="text">Create Holiday</span>
                    </a>
                @endif
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
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
                                <th>S No</th>
                                <th>Date</th>
                                <th>occasion</th>
                                <th>Added On</th>
                                @if(App\Models\Userpermission::get_permission('holiday_calender','is_edit') || App\Models\Userpermission::get_permission('holiday_calender','is_delete'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=0; @endphp
                            @foreach($holiday_list as $key => $customer)
                                @php $i++; @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ date('d M y',strtotime($customer->date)) }}</td>
                                    <td>{{ $customer->occasion }}</td>
                                    <td>{{ date('d M y H:i A',strtotime($customer->created_at)) }}</td>
                                    @if(App\Models\Userpermission::get_permission('holiday_calender','is_edit') || App\Models\Userpermission::get_permission('holiday_calender','is_delete'))
                                        <td>
                                            @if(App\Models\Userpermission::get_permission('holiday_calender','is_edit'))
                                                <a class="btn btn-success btn-circle btn-sm" href="{{route('edit_holiday', $customer->id)}}" title="Edit"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if(App\Models\Userpermission::get_permission('holiday_calender','is_delete'))
                                                <a class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;" href="{{route('delete_holiday', $customer->id)}}" title="Delete">
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
@endsection