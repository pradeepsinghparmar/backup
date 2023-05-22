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
        <div class="card shadow mb-4" id="respon">
        </div>
        @foreach($datas as $data)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php print_r(App\Models\Group::where('id',$data['group_id'])->first()->name);
                ?></h6>
                </div>
                <div class="container-fluid"><br>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="export_example">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>PMT</th>
                                        <th>{{$data['week_arr']['Mon']}} <br>Mon</th>
                                        <th>{{$data['week_arr']['Tue']}} <br>Tue</th>
                                        <th>{{$data['week_arr']['Wed']}} <br>Wed</th>
                                        <th>{{$data['week_arr']['Thu']}} <br>Thu</th>
                                        <th>{{$data['week_arr']['Fri']}} <br>Fri</th>
                                        <th>{{$data['week_arr']['Sat']}} <br>Sat</th>
                                        <th>{{$data['week_arr']['Sun']}} <br>Sun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['record'] as $key => $dat)
                                        <tr>
                                            <td>@php print_r(App\Models\User::where('id',$dat->user_id)->first()->name); @endphp </td>
                                            <td>@php print_r(App\Models\Pmt::where('id',$dat->pmt_id)->first()->pmt); @endphp</td>
                                            <td>{{ $dat->mon}}</td>
                                            <td>{{$dat->tue}}</td>
                                            <td>{{$dat->wed}}</td>
                                            <td>{{$dat->thu}}</td>
                                            <td>{{$dat->fri}}</td>
                                            <td>{{$dat->sat}}</td>
                                            <td>{{$dat->sun}}</td>
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
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        <script>
            $(document).ready(function(){
                // $(document).on('change','#week',(function(){
                //     alert($('#week').val());
                //     $('.date').value
                // }));

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
                        url: "{{ route('create_weekly_target') }}",
                        method: 'POST',
                        data:{ week:week,pmt_id:pmt_id,group_id:group_id, _token:_token},
                        success: function(response) {
                            console.log(response);
                            $('#respon').html(response.view);
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