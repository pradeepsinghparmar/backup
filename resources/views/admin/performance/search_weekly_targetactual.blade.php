@php 
$datas = $tt['datas'];
@endphp
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
    });
</script>
