@php 
$weak = $tt['weak'];
$group_id = $tt['group_id'];
$group_name = $tt['group_name'];
$week_start = $tt['week_start'];
$pmt_id = $tt['pmt_id'];
@endphp
<div class="card-header py-3">
    <h6 class="m-0 font-weight-bold">{{ $group_name}}</h6>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-3">
                <div class="col-sm-2">Name</div>
                <div class="col-sm-1 center">{{ $weak['Mon'] }}<br> Mon</div>
                <div class="col-sm-1 center">{{ $weak['Tue'] }}<br> Tue</div>
                <div class="col-sm-1 center">{{ $weak['Wed'] }}<br> Wed</div>
                <div class="col-sm-1 center">{{ $weak['Thu'] }}<br> Thu</div>
                <div class="col-sm-1 center">{{ $weak['Fri'] }}<br> Fri</div>
                <div class="col-sm-1 center">{{ $weak['Sat'] }}<br> Sat</div>
                <div class="col-sm-1 center">{{ $weak['Sun'] }}<br> Sun</div>

            </div>
        </div>
        <div class="col-md-12">
            <form action="{{ route('store_weekly_target') }}" id="target" method="post" enctype="multipart/form-data">
                <input type="hidden" name="date" id="date" value="{{ $week_start }}">
                <input type="hidden" name="group_id" value="{{ $group_id }}">
                <input type="hidden" name="pmt_id" value="{{$pmt_id}}">
                @csrf
                @php
                $users = App\Models\User::select('*')->where('is_dashboard',1)->where('group_id',$group_id)->orderBy('name','ASC')->get();
                $i=1;
                @endphp
                @foreach($users as $user)
                    <div class="row mb-3">
                        <input type="hidden" name="user_id{{$i}}" value="{{ $user->id }}">
                        <label class="col-sm-2 col-form-label">{{  $user->name }} {{  $user->last_name }}</label>
                        <div class="col-sm-1">
                            <input type="text" name="mon{{$i}}" class="form-control">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" name="tue{{$i}}" class="form-control">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" name="wed{{$i}}" class="form-control">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" name="thu{{$i}}" class="form-control">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" name="fri{{$i}}" class="form-control">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" name="sat{{$i}}" class="form-control">
                        </div>
                        <div class="col-sm-1">
                            <input type="text" name="sun{{$i}}" class="form-control">
                        </div>
                    </div>
                    @php
                    $i++;
                    @endphp
                @endforeach
                <div class="row mb-3"><input type="submit" id="submit" class="btn btn-primary" value="Save"></div>
            </form>
        </div>
    </div>
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
    .center{
        text-align: center;
    }
</style>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function(){

        $(document).on('click','#submit',(function(){
        }));

    });

</script>