@extends('admin.layout')
@section('content')
<style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        th {
            background-color: #dddddd6b;
            border: 1px solid #dddddd;
            text-align: left;
            font-size: 12px; 
            /*padding: 8px;*/
        }
        td{
            border: 1px solid #dddddd;
            font-size: 12px;
            /*padding: 8px;*/
            width: 20px !important;
        }

        tr {
            border: 1px solid #dddddd;
        }

        .tr {
            line-height: 0.5 !important;
        }

        .td{
            padding: 5px 12px !important;
        }

        .popth {
            text-align: center;
            font-size: 14px;
        }

        .tt{
            height: calc(1.5em + -0.25rem + 2px);
        }

        .btn-activity {
            cursor: pointer;
            color: #007bff;
            font-size: 13px;
            line-height: 1.5;
        }
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
               <h1 class="h3 mb-2 text-gray-800">My Activity</h1>
            </div>
            <div class="col-md-2">
                <a href="" class="btn btn-dark btn-icon-split">
                    <span class="text">Back</span>
                </a>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <!--<div class="card-header py-3">-->
            <!--    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>-->
            <!--</div>-->
            <div class="card-body">
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

                <div class="row">
                    <div class="col-md-12">
                        <form id="form_search" action="{{ route('my_activity') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="bs-form-wrapper">
                                <div class="input-wrapper">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="date" id="date" name="date" value="{{$date}}" placeholder="Date" class="form-control" required>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="submit" class="btn btn-primary" value="Add">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-10">
                           <h1 class="h3 mb-2 text-gray-800">Time Worked</h1>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="today" name="today" value="{{ $today }}">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 70px; text-align: left !important;">Day</th>
                                    <th>{{ $weak['Mon'] }} <br>Mon</th>
                                    <th>{{ $weak['Tue'] }} <br>Tue</th>
                                    <th>{{ $weak['Wed'] }} <br>Wed</th>
                                    <th>{{ $weak['Thu'] }} <br>Thu</th>
                                    <th>{{ $weak['Fri'] }} <br>Fri</th>
                                    <th>{{ $weak['Sat'] }} <br>Sat</th>
                                    <th>{{ $weak['Sun'] }} <br>Sun</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=0; @endphp
                                @foreach($timesheets as $timesheet)
                                @if($i % 5==0)
                                    <tr>
                                        <td class="td" colspan="9">{{ $timesheet['project'] }}</td>
                                    </tr>
                                    <tr class="tr">
                                        <td class="td">
                                            <input type="hidden" name="task_id[]" value="{{ $timesheet['task_id'] }}">
                                        </td>
                                        <td class="td">
                                            <input disabled="disabled" class="form-control tt" type="number" value="{{ $timesheet['mon_hours'] }}" @if($timesheet['timesheet_id'] !='')
                                            data-toggle="popover" title="Count : {{ $timesheet['count'] }} Comment : {{ $timesheet['comments'] }}"
                                            @endif><br>
                                            <a href="#" data-toggle="modal" data-target="#myModal_{{ $timesheet['id'] }}" class="btn-activity" >+Add Activity</a>
                                            <div class="modal fade" id="myModal_{{ $timesheet['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row justify-content-between">
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <form id="activity_{{ $timesheet['id'] }}" action="" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @if($timesheet['timesheet_id'] !='')
                                                                                <input type="hidden" name="timesheet_id" value="{{$timesheet['timesheet_id']}}">
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-4 col-form-label required">Count#</label>
                                                                                    <label class="col-sm-8 col-form-label required">Comments</label>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-sm-4">
                                                                                        <input disabled="disabled" type="text" 
                                                                                        value="{{ $timesheet['count'] }}" class="form-control" required>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <input disabled="disabled" type="textarea" 
                                                                                        value="{{ $timesheet['comments'] }}" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-3 col-form-label required">Count#</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="number" name="count" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-3 col-form-label required">Comments</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="text" name="comments" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <input onclick="add_activity({{ $timesheet['id'] }})" class="btn btn-primary add_activity" value="Save">
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                @endif
                                @if($i % 5 != 0)
                                    @if($i % 5 ==1)
                                        <td class="td">
                                            <input disabled="disabled" class="form-control tt" type="number"value="{{ $timesheet['tue_hours'] }}" @if($timesheet['timesheet_id'] !='')
                                            data-toggle="popover" title="Count : {{ $timesheet['count'] }} Comment : {{ $timesheet['comments'] }}"
                                            @endif><br>
                                            <a href="#" data-toggle="modal" data-target="#myModal_{{ $timesheet['id'] }}" class="btn-activity">+Add Activity</a>
                                            <div class="modal fade" id="myModal_{{ $timesheet['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row justify-content-between">
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <form id="activity_{{ $timesheet['id'] }}" action="" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @if($timesheet['timesheet_id'] !='')
                                                                                <input type="hidden" name="timesheet_id" value="{{$timesheet['timesheet_id']}}">
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-4 col-form-label required">Count#</label>
                                                                                    <label class="col-sm-8 col-form-label required">Comments</label>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-sm-4">
                                                                                        <input disabled="disabled" type="text" 
                                                                                        value="{{ $timesheet['count'] }}" class="form-control" required>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <input disabled="disabled" type="textarea" 
                                                                                        value="{{ $timesheet['comments'] }}" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-3 col-form-label required">Count#</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="number" name="count" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-3 col-form-label required">Comments</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="text" name="comments" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <input onclick="add_activity({{ $timesheet['id'] }})" class="btn btn-primary add_activity" value="Save">
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    @if($i % 5 ==2)
                                        <td class="td">
                                            <input disabled="disabled" class="form-control tt" type="number" value="{{ $timesheet['wed_hours'] }}" @if($timesheet['timesheet_id'] !='')
                                            data-toggle="popover" title="Count : {{ $timesheet['count'] }} Comment : {{ $timesheet['comments'] }}"
                                            @endif><br>
                                            <a href="#" data-toggle="modal" data-target="#myModal_{{ $timesheet['id'] }}" class="btn-activity">+Add Activity</a>
                                            <div class="modal fade" id="myModal_{{ $timesheet['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row justify-content-between">
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <form id="activity_{{ $timesheet['id'] }}" action="" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @if($timesheet['timesheet_id'] !='')
                                                                                <input type="hidden" name="timesheet_id" value="{{$timesheet['timesheet_id']}}">
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-4 col-form-label required">Count#</label>
                                                                                    <label class="col-sm-8 col-form-label required">Comments</label>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-sm-4">
                                                                                        <input disabled="disabled" type="text" 
                                                                                        value="{{ $timesheet['count'] }}" class="form-control" required>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <input disabled="disabled" type="textarea" 
                                                                                        value="{{ $timesheet['comments'] }}" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-3 col-form-label required">Count#</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="number" name="count" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-3 col-form-label required">Comments</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="text" name="comments" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <input onclick="add_activity({{ $timesheet['id'] }})" class="btn btn-primary add_activity" value="Save">
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    @if($i % 5 ==3)
                                        <td class="td">
                                            <input disabled="disabled" class="form-control tt" type="number" value="{{ $timesheet['thu_hours'] }}" @if($timesheet['timesheet_id'] !='')
                                            data-toggle="popover" title="Count : {{ $timesheet['count'] }} Comment : {{ $timesheet['comments'] }}"
                                            @endif><br>
                                            <a href="#" data-toggle="modal" data-target="#myModal_{{ $timesheet['id'] }}" class="btn-activity">+Add Activity</a>
                                            <div class="modal fade" id="myModal_{{ $timesheet['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row justify-content-between">
                                                                <div class="col">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <form id="activity_{{ $timesheet['id'] }}" action="" method="post" enctype="multipart/form-data">
                                                                                @csrf
                                                                                @if($timesheet['timesheet_id'] !='')
                                                                                <input type="hidden" name="timesheet_id" value="{{$timesheet['timesheet_id']}}">
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-4 col-form-label required">Count#</label>
                                                                                    <label class="col-sm-8 col-form-label required">Comments</label>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-sm-4">
                                                                                        <input disabled="disabled" type="text" 
                                                                                        value="{{ $timesheet['count'] }}" class="form-control" required>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <input disabled="disabled" type="textarea" 
                                                                                        value="{{ $timesheet['comments'] }}" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-3 col-form-label required">Count#</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="number" name="count" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-3 col-form-label required">Comments</label>
                                                                                    <div class="col-sm-9">
                                                                                        <input type="text" name="comments" class="form-control" required>
                                                                                    </div>
                                                                                </div>
                                                                                <input onclick="add_activity({{ $timesheet['id'] }})" class="btn btn-primary add_activity" value="Save">
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    @if($i % 5 ==4)
                                            <td class="td">
                                                <input disabled="disabled" class="form-control tt" type="number" value="{{ $timesheet['fri_hours'] }}" @if($timesheet['timesheet_id'] !='')
                                            data-toggle="popover" title="Count : {{ $timesheet['count'] }} Comment : {{ $timesheet['comments'] }}"
                                            @endif><br>
                                                <a href="#" data-toggle="modal" data-target="#myModal_{{ $timesheet['id'] }}" class="btn-activity">+Add Activity</a>
                                                <div class="modal fade" id="myModal_{{ $timesheet['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row justify-content-between">
                                                                    <div class="col">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <form id="activity_{{ $timesheet['id'] }}" action="" method="post" enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    @if($timesheet['timesheet_id'] !='')
                                                                                <input type="hidden" name="timesheet_id" value="{{$timesheet['timesheet_id']}}">
                                                                                <div class="row mb-3">
                                                                                    <label class="col-sm-4 col-form-label required">Count#</label>
                                                                                    <label class="col-sm-8 col-form-label required">Comments</label>
                                                                                </div>
                                                                                <div class="row mb-3">
                                                                                    <div class="col-sm-4">
                                                                                        <input disabled="disabled" type="text" 
                                                                                        value="{{ $timesheet['count'] }}" class="form-control" required>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <input disabled="disabled" type="textarea" 
                                                                                        value="{{ $timesheet['comments'] }}" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                @endif
                                                                                    <div class="row mb-3">
                                                                                        <label class="col-sm-3 col-form-label required">Count#</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="number" name="count" class="form-control" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mb-3">
                                                                                        <label class="col-sm-3 col-form-label required">Comments</label>
                                                                                        <div class="col-sm-9">
                                                                                            <input type="text" name="comments" class="form-control" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input onclick="add_activity({{ $timesheet['id'] }})" class="btn btn-primary add_activity" value="Save">
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="td" style="background-color: #dddddd6b;"></td>
                                            <td class="td" style="background-color: #dddddd6b;"></td>
                                            <td class="td"></td>
                                        </tr>
                                    @endif
                                @endif
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <div class="row mb-3">
                            <div class="col-sm-9"></div>
                            <div class="col-sm-3">
                                <input type="submit" id="submit" disabled="disabled" class="btn btn-primary" value="Save">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        function add_activity(id){
            var $inputs = $('#activity_'+id+' :input');
            var values = {};
            $inputs.each(function() {
                values[this.name] = $(this).val();
            });

            var count = values['count'];
            var comments = values['comments'];
            var timesheet_id = id;
            var _token = $('input[name="_token"]').val();
            if(values['timesheet_id']){
                url = "{{ route('update_myactivity') }}";
            }else{
                url = "{{ route('store_myactivity') }}";
            }
            $.ajax({
                url: url,
                method: 'POST',
                data:{ count:count, comments:comments, timesheet_id:timesheet_id, _token:_token},
                success: function(response) {
                    $('#myModal_'+id).modal('toggle');
                    //var route = "{{ route('my_activity') }}";
                    //var today = $('#today').val();
                    //var form = $('<form method="post"><input type="submit" />@csrf<input type="text" name="date" value="' + today + ' /></form>').attr('action', route);
                    //$(document.body).append(form);
                    //console.log(form);
                   // $('input[type="submit"]', form).click();
                    $("#form_search").submit();
                }
            });

            $(document).ready(function() {
                $('[data-toggle="popover"]').popover({
                    placement: 'top',
                    trigger: 'hover'
                });
            });
        }
    </script>
@endsection