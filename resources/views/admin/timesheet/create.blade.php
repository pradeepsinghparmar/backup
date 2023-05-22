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
            text-align: right;
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

        .tt{
            /*width: 50%;*/
        }


        /*tr:nth-child(even) {
            background-color: #dddddd;
        }*/
    </style>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
               <h1 class="h3 mb-2 text-gray-800">Timesheet</h1>
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
                        <form action="{{ route('timesheet') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="bs-form-wrapper">
                                <div class="input-wrapper">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="date" id="date" name="date"  placeholder="Date" class="form-control" required>
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
                        <form id="timesheet" action="{{ route('store_timesheet') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="today" value="{{ $today }}">
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
                                        <tr>
                                            <td class="td"><input type="hidden" name="task_id[]" value="{{ $timesheet['task_id'] }}"></td>
                                            <td class="td"><input class="form-control tt" type="number" name="mon_hours[]" value="{{ $timesheet['mon_hours'] }}" step="0.5"></td>
                                    @endif
                                    @if($i % 5 != 0)
                                        @if($i % 5 ==1)
                                            <td class="td"><input class="form-control tt" type="number" name="tue_hours[]" value="{{ $timesheet['tue_hours'] }}" step="0.5"></td>
                                        @endif
                                        @if($i % 5 ==2)
                                            <td class="td"><input class="form-control tt" type="number" name="wed_hours[]" value="{{ $timesheet['wed_hours'] }}" step="0.5"></td>
                                        @endif
                                        @if($i % 5 ==3)
                                            <td class="td"><input class="form-control tt" type="number" name="thu_hours[]" value="{{ $timesheet['thu_hours'] }}" step="0.5"></td>
                                        @endif
                                        @if($i % 5 ==4)
                                                <td class="td"><input class="form-control tt" type="number" name="fri_hours[]" value="{{ $timesheet['fri_hours'] }}" step="0.5"></td>
                                                <td class="td" style="background-color: #dddddd6b;"></td>
                                                <td class="td" style="background-color: #dddddd6b;"></td>
                                                <td class="td"></td>
                                            </tr>
                                        @endif
                                    @endif
                                        @php $i++; @endphp
                                    @endforeach
                                    <tr id="add_task_button">
                                        <td colspan="9" style="padding: 15px 12px !important;">
                                            <a href="#" data-toggle="modal" data-target="#myModal_1"><b>+Add Task</b></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class="row mb-3">
                                <div class="col-sm-9"></div>
                                <div class="col-sm-3">
                                    <input type="submit" id="submit" disabled="disabled" class="btn btn-primary" value="Save">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal_1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 80% !important;">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="col">
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="myTable">
                                        <thead>
                                            <tr>
                                                <th class="popth">Project</th>
                                                <th class="popth">Task</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            <tr>
                                                <td class="td">
                                                    <input type="text" id="search_project" name="search_project">
                                                </td>
                                                <td class="td">
                                                    <input type="text" id="search_task" name="search_task">
                                                </td>
                                            </tr>
                                             @foreach($projects as $project)
                                                <tr class="data">
                                                    <td class="td">
                                                        <input type="radio" id="{{ $project->project }} - {{ $project->name }}" class="project_id" name="project_id" value="{{ $project->id }}">
                                                        <label>{{ $project->project }}</label>
                                                    </td>
                                                    <td class="td">
                                                        <label>{{ $project->name }}</label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <div class="row mb-3">
                                        <div class="col-sm-9"></div>
                                        <div class="col-sm-3">
                                            <input class="btn btn-primary add_task" value="Add Task">
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $(document).on('click','#timesheet .form-control',(function(){
                $('#submit').attr('disabled',false);
            }));

            $(document).on('keyup','#search_project',(function(){
                var proj = this.value;
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('search_project') }}",
                    method: 'POST',
                    data:{ name:proj, _token:_token},
                    success: function(response) {
                        $("#myTable").find("tr:gt(1)").remove();
                        $('#myTable').append(response);
                        $('#search_project').focus();
                    }
                });
            }));

            $(document).on('keyup','#search_task',(function(){
                var task = this.value;
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('search_task') }}",
                    method: 'POST',
                    data:{ name:task, _token:_token},
                    success: function(response) {
                        $("#myTable").find("tr:gt(1)").remove();
                        $('#myTable').append(response);
                        $('#search_task').focus();
                    }
                });
            }));

            $(document).on('click','.add_task',(function(){
                var id = '';
                var name = '';
                var html='';
                $('.project_id').each(function(){
                    if(this.checked){
                        id=this.value;
                        name = $(this).attr('id');
                        this.checked = false;
                        html = '<tr><td class="td" colspan="9">'+name+'</td></tr><tr><td class="td"><input type="hidden" name="task_id[]" value="'+id+'"></td><td class="td"><input class="form-control tt" type="number" name="mon_hours[]" step="0.5"></td><td class="td"><input class="form-control tt" type="number" name="tue_hours[]" step="0.5" ></td><td class="td"><input class="form-control tt" type="number" name="wed_hours[]" step="0.5"></td><td class="td"><input class="form-control tt" type="number" name="thu_hours[]" step="0.5"></td><td class="td"><input class="form-control tt" type="number" name="fri_hours[]"step="0.5" ></td><td class="td" style="background-color: #dddddd6b;"></td><td class="td" style="background-color: #dddddd6b;"></td><td class="td"></td></tr>';
                    }
                });


                $(html).insertBefore("#add_task_button");
                $('#myModal_1').modal('toggle');
            }));
            $("body").on("click",".add-more",function(event){
                //var html = $(".after-add-more").first().clone();
              
                //  $(html).find(".change").prepend("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");
              
                  //$(html).find(".change").html("<label for=''>&nbsp;</label><br/><a class='btn btn-danger remove'>- Remove</a>");

                var html = '<tr><td colspan="9"></td></tr><tr><td><input type="hidden" name="task_id[]"></td><td><input class="form-control" type="text" name="mon_hours[]" ></td><td><input class="form-control" type="text" name="tue_hours[]" ></td><td><input class="form-control" type="text" name="wed_hours[]" ></td><td><input class="form-control" type="text" name="thu_hours[]" ></td><td><input class="form-control" type="text" name="fri_hours[]" ></td><td style="background-color: #dddddd6b;"></td><td style="background-color: #dddddd6b;"></td><td></td></tr>';

                $(html).insertBefore("#add_task_button");
              
              
                //$(".after-add-more").last().after(html);
                event.preventDefault();
                $('form .add-more').attr('onclick','').unbind('click');
            });

            // $("body").on("click",".remove",function(){ 
            //     $(this).parents(".after-add-more").remove();
            // });
        });
    </script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $("#project_id").select2({
          placeholder: "Select",
          allowClear: true,
      });
    </script>
@endsection