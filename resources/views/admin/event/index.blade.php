@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Event</h1>
            </div>
             <div class="col-md-2">
                <!-- <a href="#" class="btn btn-info btn-icon-split">
                    <span class="text">Create event</span>
                </a> -->
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="container-fluid"><br>
                <div class="card-body">
                    <div class="table-responsive">
                         <table class="export_example">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Company</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($events as $key => $event)
                                    <tr>
                                        <td>{{ $event->first_name }} {{ $event->last_name }}</td>
                                        <td>{{ $event->email }}</td>
                                        <td>{{ $event->phone }}</td>
                                        <td>{{ $event->company_name }}</td>
                                        <td>{{ date("l M d , Y, H:m a", strtotime($event->created_at)) }}</td>
                                        @if(App\Models\Userpermission::get_permission('event','is_edit') || App\Models\Userpermission::get_permission('event','is_delete')) 
                                            <td> 
                                                <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_event', $event->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                @if(App\Models\Userpermission::get_permission('event','is_edit')) 
                                                    <a class="btn btn-success btn-circle btn-sm"  href="{{route('edit_event', $event->id)}}"  title="Edit"><i class="fas fa-edit"></i></a>
                                                    <!-- <a href="#" data-toggle="modal" data-target="#myModal"><i id="{{$event->id}}" class="fa fa-plus tt" style="float: right; color: blue;"></i></a> -->
                                                @endif
                                                @if(App\Models\Userpermission::get_permission('event','is_delete'))    
                                                    <a class="btn btn-danger btn-circle btn-sm" onclick="if (!confirm('Are you sure? you want to delete this info')) return false;" href="{{route('delete_event', $event->id)}}"  title="Delete">
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Comments</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card bg-white border-0 b-shadow-4">
                                        <div class="card-body ">
                                            <form action="#" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Comment</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="comment"  placeholder="Comment" class="form-control"  required>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="id" id="id">
                                                <input type="submit" class="btn btn-primary" value="Save"> 
                                            </form>
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
    <style type="text/css">
    .export_example{
        border: 2px solid #c3c5e0;
    }
    table {
        table-layout:fixed;
        width:95% !important;
    }
    td{
        overflow:hidden;
        text-overflow: ellipsis;
    }
</style>
<script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $(document).on('click','.tt',(function(){
               var id = $(this).attr('id');
               $('#id').val(id);
            }));
        });
        function add(id,d){
            $('#text'+id+''+d).toggle("slide");
        }
    </script>
@endsection