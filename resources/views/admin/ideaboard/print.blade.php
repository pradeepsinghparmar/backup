@extends('admin.layout1')
@section('content')
    <div class="container-fluid">
        <!-- Content Row -->
        <div class="_icon-box">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header" style="background: #0c6ead;border-radius: 20px;">
                        <h5 class="m-0 font-weight-bold" style=" color: white !important; text-align: center;">
                            Idea Board 
                        </h5>
                    </div>
                </div>
                <div class="col-md-12" style="padding-top:10px;">
                    <h5 class="font-weight-bold">
                        @php echo (date("d M Y l", strtotime($date))); @endphp
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="container-fluid"><br>
                 <div class="card-body">
                    <div class="table-responsive">
                         <table class="export_example">
                            <tr>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Task</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employeess as $key => $data)
                                    <tr>
                                        <td>{{$data->name}} {{$data->last_name}}</td>
                                        <td colspan="2">
                                        <table style="width: 100%;">
                                            @php 
                                                $astask = App\Models\Taskassign::select('*')->whereRaw('FIND_IN_SET('.$data->id.',user_id)')->where('date', $date)->get();
                                            @endphp
                                            @foreach($astask as $as)
                                            <tr>
                                                @php 
                                                    $task = App\Models\Dailytask::select('*')->where('id', $as->task_id)->first();
                                                @endphp
                                                <td>
                                                    {{ $task->task}}
                                                </td>
                                                <td>
                                                @php 
                                                    $taskcomments = App\Models\Dailytaskcomments::select('*')->where('user_id', $data->id)->where('task_id', $as->task_id)->whereDate('date', '=', $date)->get();
                                                    @endphp
                                                    @foreach($taskcomments as $comments)
                                                        @php $comment1s=explode(",",$comments->comments);@endphp
                                                        @foreach($comment1s as $comment1)
                                                        <br>
                                                        {{$comment1}}
                                                        @endforeach
                                                    @endforeach
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </tr>
                        </table>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            window.print();
            return false;
        });
    </script>
@endsection