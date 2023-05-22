@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Weekly Target List</h1>
            </div>
             <div class="col-md-2">
            </div>
       </div>
         @foreach($groups as $gr)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">{{ $gr->name}}</h6>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                         <table class="export_example">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                $users = App\Models\User::select('*')->where('is_dashboard',1)->where('group_id',$gr->id)->orderBy('name','ASC')->get();
                                    @endphp
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{  $user->name }}</td>
                                        <td>{{ }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('store_weekly_target') }}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="date" id="date" value="{{$week}}">
                                    <input type="hidden" name="group_id" value="{{ $gr->id }}">
                                    @csrf
                                    @php
                                    $users = App\Models\User::select('*')->where('is_dashboard',1)->where('group_id',$gr->id)->orderBy('name','ASC')->get();
                                    @endphp
                                    @foreach($users as $user)
                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label required">{{  $user->name }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="{{$user->id}}" class="form-control" required>
                                            </div>
                                        </div>
                                    @endforeach
                                    <input type="submit" class="btn btn-primary" value="Save"> 
                                </form>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
        <style type="text/css">
            #DataTables_Table_0_filter{
                float: left;
            }
            .dt-buttons {
                display: none;
            }

            .dataTables_filter{
                display: none;
            }
            .export_example{
                border: 2px solid #c3c5e0;
            }
            .required:after {
                content:" *";
                color: red;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script>
            $(document).ready(function(){
                $(document).on('change','#week',(function(){
                    //alert(this.value);
                    //$('.date').value
                }));
            });
            $("#group_id").select2({
              placeholder: "Select",
              allowClear: true,
            });
            $("#pmt_id").select2({
              placeholder: "Select",
              allowClear: true,
            });
        </script>
@endsection