@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-md-10">
                <h1 class="h3 mb-2 text-gray-800">Weekly Target</h1>
            </div>
             <div class="col-md-2">
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="container-fluid"><br>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bs-form-wrapper">
                                <div class="input-wrapper">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <label class="col-sm-2">Date</label>
                                                <div class="col-sm-10">
                                                    <select name="week" id="week" class="form-control">
                                                         @foreach($options as $option)
                                                            <option value="{{ $option['value'] }}" @if($option['value']==$week) Selected @endif>({{ $option['week_start'] }}-{{ $option['week_end'] }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <div class="row">
                                                <label class="col-sm-2">Group</label>
                                                <div class="col-sm-4">
                                                    <select name="group_id" id="group_id" class="form-control">
                                                        <option selected="" disabled="" value="">Select</option>
                                                        @foreach($groups as $gr)
                                                            <option value="{{ $gr->id }}">{{ $gr->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label class="col-sm-2">PMT</label>
                                                <div class="col-sm-4">
                                                   <select name="pmt_id" id="pmt_id" class="form-control">
                                                        <option selected="" disabled="" value="">Select</option>
                                                        @foreach($pmts as $pr)
                                                            <option value="{{ $pr->id }}">{{ $pr->pmt }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="submit" id="search" class="btn btn-primary" value="Search">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="respon">
        
        @foreach($datas as $data)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php print_r(App\Models\Group::where('id',$data['group_id'])->first()->name);
                ?></h6>
                </div>
                <div class="container-fluid"><br>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="export_example1">
                                <thead>
                                    <tr>
                                        <th colspan="2">Date</th>
                                        <th colspan="2">{{$data['week_arr']['Mon']}} <br>Mon</th>
                                        <th colspan="2">{{$data['week_arr']['Tue']}} <br>Tue</th>
                                        <th colspan="2">{{$data['week_arr']['Wed']}} <br>Wed</th>
                                        <th colspan="2">{{$data['week_arr']['Thu']}} <br>Thu</th>
                                        <th colspan="2">{{$data['week_arr']['Fri']}} <br>Fri</th>
                                        <th colspan="2">{{$data['week_arr']['Sat']}} <br>Sat</th>
                                        <th colspan="2">{{$data['week_arr']['Sun']}} <br>Sun</th>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <th>PMT</th>
                                        <th>T</th>
                                        <th>A</th>
                                        <th>T</th>
                                        <th>A</th>
                                        <th>T</th>
                                        <th>A</th>
                                        <th>T</th>
                                        <th>A</th>
                                        <th>T</th>
                                        <th>A</th>
                                        <th>T</th>
                                        <th>A</th>
                                        <th>T</th>
                                        <th>A</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['record'] as $key => $dat)
                                        <tr data-id="{{$dat->id}}">
                                            <td>@php print_r(App\Models\User::where('id',$dat->user_id)->first()->name); @endphp </td>
                                            <td>@php print_r(App\Models\Pmt::where('id',$dat->pmt_id)->first()->pmt); @endphp</td>
                                            <td>{{ $dat->mon}} </td><td> <input type="text" name="mon_act" value="{{ $dat->mon_act}}" class="intd"></td>
                                            <td>{{$dat->tue}} </td><td> <input type="text" name="tue_act" value="{{ $dat->tue_act}}" class="intd"></td>
                                            <td>{{$dat->wed}} </td><td> <input type="text" name="wed_act" value="{{ $dat->wed_act}}" class="intd"></td>
                                            <td>{{$dat->thu}} </td><td> <input type="text" name="thu_act" value="{{ $dat->thu_act}}" class="intd"></td>
                                            <td>{{$dat->fri}} </td><td> <input type="text" name="fri_act" value="{{ $dat->fri_act}}" class="intd"></td>
                                            <td>{{$dat->sat}} </td><td> <input type="text" name="sat_act" value="{{ $dat->sat_act}}" class="intd"></td>
                                            <td>{{$dat->sun}} </td><td> <input type="text" name="sun_act" value="{{ $dat->sun_act}}" class="intd"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
     @csrf
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
            .center{
                text-align: center;
            }
            .intd
            {
                width: 30px;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
        <script>
            $(document).ready(function(){
                var oTable = $('.export_example1').dataTable( {
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 0, 1, 2, 3 , 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15] }, 
                        { "bSearchable": false, "aTargets": [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15] }
                    ],
                    "bPaginate": false,
                    "bLengthChange": false,
                });

                $(document).on('change','.intd',(function(){
                    var name = $(this).attr('name');
                    var id = $(this).closest('tr').attr('data-id');
                    var value = $(this).val();

                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('store_weeklyactualtarget') }}",
                        method: 'POST',
                        data:{ name:name,value:value,id:id, _token:_token},
                        success: function(response) {
                            console.log(response);
                        }
                    });

                }));

                $(document).on('click','#search',(function(){
                    var week = $('#week').val();
                    var group_id = $('#group_id').val();
                    if(group_id == null){
                        alert('please Select Group');
                        return false;
                    }
                    var pmt_id = $('#pmt_id').val();
                    if(pmt_id == null){
                        alert('please Select Task');
                        return false;
                    }
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: "{{ route('searchactual_weeklytarget') }}",
                        method: 'POST',
                        data:{ week:week,pmt_id:pmt_id,group_id:group_id, _token:_token},
                        success: function(response) {
                            if(response.status==1){
                                sweetAlert("No Record Found");
                            }else{
                                $('#respon').html(response.view);
                            }
                        }
                    });
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