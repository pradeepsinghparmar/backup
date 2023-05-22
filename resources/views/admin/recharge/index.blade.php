@extends('admin.layout')

@section('content')

  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-9">
                                   <h1 class="h3 mb-2 text-gray-800">All Recharge List</h1>
                                    </div>
                                     <div class="col-md-3">
                                     <a href="{{ route('create_recharge') }}" class="btn btn-info btn-icon-split">
                                        <span class="text">Create Recharge</span>
                                    </a>
                                          
                                    </div>
                   </div>
                   

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                    @if(Auth::user()->role_status == 0)
                      <div class="row mt-3">
                                <div class="col-md-12">                        
<form action="{{ route('received_voucher_filter') }}" method="post">
@csrf

<div class="col-sm-3" style="float: left;">
     <!--label ui selection fluid dropdown-->
          <select name="profile_name[]" class="form-control multi_select" id="inputEmail3" required multiple data-selected-text-format="count > 3">
               
                @foreach($recharge_list as $d)
               <option value="{{ $d->profile }}">{{ $d->profile }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="start_date" placeholder="Enter Start Date" class="form-control" id="inputEmail3"  required>
        </div>
    
        <div class="col-sm-3" style="float: left;">
            <input type="date" name="end_date" placeholder="Enter End Date" class="form-control" id="inputEmail3" required>
        </div>
    
    <div class="col-sm-3" style="float: left;">
   
          <input type="submit" name="cmdSearch" class="btn btn-primary" value="Search">
           <a href="{{ route('cash_reports') }}" class="btn btn-secondary">All</a>
    </div>
</form>
                                
                            </div>
                        </div>
                    @endif
                       <div class="container-fluid"><br>
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="export_example">
                                    <thead>
                                        <tr>
                                             <th>S.No.</th>
                                             <th>Created By</th>
                                             <th>Site Name</th>
                                                <th>Mobile</th>
                                                <th>Vouchar Code</th>
                                                <th>Status</th>
                                                    <th>Profile</th>
                                                    <th>Price</th>
                                                    <th>Added On</th>
                                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @php $i=0 @endphp
                                        @if(!empty($recharge_list))
                                         @foreach($recharge_list as $key => $info)
  @php $i++; @endphp
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td> <?php foreach($users as $us){
                            if($us->id == $info->user_id){?>
                            {{ $us->name }}
                            <?php } }?></td>
                                                    <td> <?php foreach($site_list as $ids){
                            if($ids->name == $info->site_id){?>
                            {{ $ids->site_id_name }}
                            <?php } }?></td>
                                                    <td>{{ $info->mobile }}</td>
                                                    <td>{{ $info->voucher_code }}</td>
                                                    <td>{{ $info->status }}</td>
                                                   
                                                    <td>{{ $info->profile }}</td>
                                                     <td>{{ $info->price }}</td>
                                                  
                                                    
                                                    <td>{{ date('d M Y',strtotime($info->created_at)) }}</td>
                                                    
                                                    <td>
                                                         <a class="btn btn-primary btn-circle btn-sm"  href="{{route('view_recharge_voucher', $info->id)}}"  title="View"><i class="fas fa-eye"></i></a>
                                                        
                                                    </td>
                                                </tr>
                                                
                                                  @endforeach
@endif
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
  
{{ csrf_field() }}

<script>
function publishUser(sender) {
 var _token = $('input[name="_token"]').val();
  var api_id = sender.id;
    //   alert(_token);
//if (!confirm('Are you sure? you want to delete this info')) return false;
                 $.ajax({ 

                    url: "{{ route('change_status') }}",
                    method: 'POST',
                    data:{api_id:api_id, _token:_token},

                    success: function(data) { 
// alert(data);
                if(data == "0"){
                        alert('Active Successfully');
                        location.reload();
                }else if(data == "1"){
                        alert('Inactive Successfully');
                            location.reload();
                }

                    } 

                }); 


}
</script>

@endsection