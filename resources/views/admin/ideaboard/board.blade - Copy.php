@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between _employee-deshboard _title-style">
            <div class="col-md-8">
                <h1 class="h3 mb-0 text-gray-800"></h1>
            </div>
            <div class="col-md-2">
            </div>
        </div>
        <!-- Content Row -->
        <div class="_icon-box">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header" style="background: #0c6ead;">
                        <h5 class="m-0 font-weight-bold" style=" color: white !important; text-align: center;">
                            Idea Board 
                        </h5>
                    </div>
                </div>
                <div class="col-md-12" style="padding-top:10px">
                    <h5 class="font-weight-bold">
                        @php echo (date("d M Y l", strtotime($date))); @endphp
                    </h5>
                </div>
            </div>
        </div>
        <div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <form action="{{ route('board') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-3" style="float: left;">
                            <select name="emp_id" class="form-control">
                               <option value="">Select Employee</option>
                                @foreach($users as $hi)
                                <option value="{{ $hi->id }}" {{ $emp_id == $hi->id ? 'selected="selected"' : '' }}>{{ $hi->name }} {{ $hi->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2" style="float: left;">
                            <input type="date" id="date" name="date"  placeholder="Date" value="{{ $date }}" class="form-control" required>
                        </div>
                        <div class="col-sm-2" style="float: left;">
                            <button class="btn btn-primary">Search</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="container-fluid"><br>
                <div class="_icon-box">
                    <div class="card-header" style="background: #0c6ead;">
                        <h6 class="m-0 font-weight-bold" style=" color: white;">ALL</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        @php $i = 1; 
                        $co = count($users);
                        @endphp
                        <table>
                        @foreach($employeess as $key => $data)
                            @if($i==1 || $i % 3 == 1)
                                <tr>
                            @endif
                            <td>
                                <div style="background: #0c6ead; padding: 0.75rem 6.25rem;">
                                    <h6 class="m-0 font-weight-bold" style=" color: white;">{{$data->name}} {{$data->last_name}}</h6>
                                </div>
                                @if(App\Models\Userpermission::get_permission('daily_task','is_create'))
                                    <a href="#" data-toggle="modal" data-target="#myModal"><i id="{{$data->id}}" class="fa fa-plus tt" style="float: right; color: blue;"></i></a>
                                @endif
                                <br>
                                @php 
                                    $astask = App\Models\Taskassign::select('*')->whereRaw('FIND_IN_SET('.$data->id.',user_id)')->where('date', $date)->get();
                                    $cc = count($astask);
                                @endphp
                                <table>
                                    @php $j=1; @endphp
                                    @foreach($astask as $as)
                                    @if($j==1 || $j % 2 == 1)
                                        <tr>
                                    @endif
                                    <td>
                                        <div class="cc">
                                            @php 
                                            $task = App\Models\Dailytask::select('*')->where('id', $as->task_id)->first();
                                            @endphp
                                            <h6 style="padding-top: 10px;">{{ $task->task}}</h6>
                                        </div>
                                         @if(Auth::user()->id==$data->id || Auth::user()->role==1)
                                            <i class="fa fa-plus" style="float: right; color: blue;" onclick="add({{$as->task_id}},{{$data->id}})"></i>
                                        @endif
                                        <br>
                                         @php 
                                        $taskcomments = App\Models\Dailytaskcomments::select('*')->where('user_id', $data->id)->where('task_id', $as->task_id)->whereDate('date', '=', $date)->get();
                                        @endphp
                                        @foreach($taskcomments as $comments)
                                            <div class="cd">
                                                <?php $comment1s=explode(",",$comments->comments); ?>
                                                @foreach($comment1s as $comment1)
                                                <br>
                                                &nbsp;&nbsp;&nbsp;&nbsp;{{$comment1}}
                                                <br>
                                                @endforeach
                                            <?php //echo nl2br($comments->comments); ?> 
                                            </div>
                                        <br>
                                        @endforeach
                                        <div class="addStickyForm" id="text{{$as->task_id}}{{$data->id}}" style="display: none;">
                                            <textarea class="stickyText" data-board-id="{{$as->task_id}}" id="{{$data->id}}" maxlength="140" rows="4"></textarea>
                                        </div>
                                    </td>
                                    @if($j % 2 == 0 && $cc == $j)
                                        </tr>
                                    @endif
                                    @php $j++; @endphp
                                    @endforeach
                                 </table>
                                 <br>
                             </td>
                            @if($i % 3 == 0 && $co ==$i)
                                <tr>
                            @endif
                            @php $i++; @endphp
                        @endforeach
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
                    <h4 class="modal-title">Assign Task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card bg-white border-0 b-shadow-4">
                                        <div class="card-body ">
                                            <form action="{{ route('store_assigntask1') }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label">Task</label>
                                                    <div class="col-sm-9">
                                                        <select name="task_id[]" id="task_id" multiple class="form-control" style="width:100% !important;">
                                                            @foreach($tasks as $rl)
                                                            <option value="{{ $rl->id }}">{{ $rl->task }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-sm-3 col-form-label required">Date</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" name="date"  placeholder="Date" class="form-control" value="{{ $date }}" required>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="user_id" id="user_id"> 
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
    {{ csrf_field() }}
    <style>
        .cc{
            font-size: 0.75em;
            text-overflow: ellipsis;
            background: #ccffff;
            min-height: 100px;
            height: auto;
            width: 150px;
            text-align: center;
            max-width: 15em;
            word-wrap: break-word;
            cursor: pointer;
            overflow: hidden;
            position: relative;
        }
        .cd{
            font-size: 0.75em;
            text-overflow: ellipsis;
            background: #ffc690;
            min-height: 100px;
            height: auto;
            width: 150px;
            max-width: 15em;
            word-wrap: break-word;
            cursor: pointer;
            overflow: hidden;
            position: relative;
        }
        .addStickyForm textarea, .green.ui-widget-content {
            background-color: #ffc690;
            border: 1px solid #dcffe0;
        }
        .sticky, .addStickyForm textarea {
            max-width: 15em;
            word-wrap: break-word;
            cursor: pointer;
            float: left;
            width: 100%;
            height: 100px;
            overflow: hidden;
            position: relative;
            border: 1px solid #d5d5cb;
            font-size: 0.75em;
            text-overflow: ellipsis;
            margin-left: 5px;
            margin-top: 5px;
        }
        .dash{
            color: #fff;
            padding: 10px 20px 10px 20px;
            background-color: #00b050;
            border-radius: 10px;
        }
        @media only screen and (min-width:1281px) and (max-width:1536px){
            .entry{
                color: #fff !important;
                background-color: #007bff !important;
                padding: 10px 15px 10px 15px !important;
            }
        }
        @media only screen and (min-width:1225px) and (max-width:1280px){
            .entry{
                color: #fff !important;
                background-color: #007bff !important;
                padding: 10px 15px 10px 15px !important;
            }
        }
        @media only screen and (min-width:769px) and (max-width:1224px){
            .entry{
                color: #fff !important;
                background-color: #007bff !important;
                padding: 10px 15px 10px 15px !important;
            }
        }
        @media only screen and (min-width:481px) and (max-width:768px){

        }
        @media only screen and (min-width:320px) and (max-width:480px){

        }
        @media only screen and (min-width:279px) and (max-width:319px){
        }

    </style>
    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $(document).on('change','.stickyText',(function(){
                var date = $('#date').val();
                var value = $(this).val();
                var task_id = $(this).attr('data-board-id');
                var user_id = $(this).attr('id');
                //alert('val = '+value+', task = '+task_id+', user_id ='+user_id+', date = '+date);

                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('adddailytaskcomments') }}",
                    method: 'POST',
                    data:{date:date, value: value, task_id: task_id, user_id: user_id, _token:_token},
                    success: function(response) {
                        location.reload();
                    }
                });
            }));

            $(document).on('click','.tt',(function(){
               var id = $(this).attr('id');
               $('#user_id').val(id);
            }));
        });
        function add(id,d){
            $('#text'+id+''+d).toggle("slide");
        }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#task_id").select2({
            placeholder: "Select",
            allowClear: true,
        });
    </script>
@endsection