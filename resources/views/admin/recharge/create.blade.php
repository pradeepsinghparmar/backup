@extends('admin.layout')

@section('content')
<style>
#country-list {
    overflow-y: auto;
    overflow-x: auto;
    /*background-color: white;*/
    height: 300px;
  border: 1px solid grey;
  padding: 20px;
}
#text_box {
   position: absolute;
   width: 100%;
   max-width:870px;
   cursor: pointer;
   overflow-y: auto;
   max-height: 400px;
   box-sizing: border-box;
   z-index: 1001;
}
.link-class:hover{
   background-color:#f1f1f1;
  }
  ul.a {
  list-style-type: circle;
}
.input-error{
    outline: 1px solid red;
}
.select2-container .select2-selection--single{
    height:40px !important;
    border-radius:5px 5px 5px 5px;
    margin-top: 5px;
}
.select2-container--default .select2-selection--single{
         border: 1px solid #ccc !important; 
     border-radius: 0px !important; 
}

</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">Create Recharge</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('all_recharge_list.index') }}" class="btn btn-dark btn-icon-split">
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

                                         <div class="row">
                                <div class="col-md-12">         
                       <div class="col-md-3">
                           </div>            
                <div class="col-md-9">                          
<form action="{{ route('store_recharge_voucher') }}" method="post" enctype="multipart/form-data">
@csrf

 
    <div class="row mb-3">
        <label for="validationCustom01" class="col-sm-3 col-form-label">Site Name</label>
        <div class="col-sm-9">
            <select name="site_id" id="site_id" class="form-control" for="validationCustom01" required>
                <option value="">Select Site Name</option>
                @foreach($site_list as $info)
                <option value="{{ $info->name }}">{{ $info->site_id_name }} (Site No - {{ $info->name }})</option>
                @endforeach
            </select>
        </div>
    </div>
     <div class="row mb-3">
        <label for="validationCustom02" class="col-sm-3 col-form-label">User Mobile No.</label>
        <div class="col-sm-9">
            <!--<input type="tel" name="user_mob"  placeholder="Search by User Mobile Number like: 971" class="form-control" id="user_mob" maxlength="12" minlength="12" required>-->
            <!--<input type="hidden" name="user_name" id="user_name">-->
            <!--<div id="countryList"></div>-->
            <select class="form-control select2" name="user_mob" id="user_mob_new" required>
	           <option value="">Select Mobile Number</option> 
	          
	        </select>
        </div>
        
    </div>
    
     <div class="row mb-3">
        <label for="validationCustom01" class="col-sm-3 col-form-label">Gateway Profile</label>
        <div class="col-sm-9">
            <select name="gateway_profile" class="form-control" id="gateway_profile" required>
                 <option value="">Select Gateway Profile</option>
            </select>
        </div>
    </div><br>
<div class="row mb-3">
        <label for="validationCustom01" class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
           <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </div>
   
    
    
</form>
                                        
        </div>                                
              
                           </div>
                           </div>
                                        
                                        
                                        
                                        
                                     
                    </div>
                </div>
            </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('.select2').select2();
</script>
{{ csrf_field() }}

<script type="text/javascript">
 $('#site_id').on('change', function() {
    //  alert($('#site_id').val());
      $('#user_mob_new').removeAttr('disabled');
      $('#user_mob_new').val('');
      $('#user_name').val('');
     $('#gateway_profile').val('');
     	
 }); 
       
</script>   	
     	
<script type="text/javascript">
 $('#site_id').on('change', function() {
    //  alert($('#site_id').val());
      $('#user_mob_new').removeAttr('disabled');
      $('#user_mob_new').val('');
      $('#user_name').val('');
     	$('#gateway_profile').val('');
       var _token = $('input[name="_token"]').val();
          var site_id = $('#site_id').val();
           $('#gateway_profile').html('');
        //   alert(site_id);
              $.ajax({
                    url: "{{ route('get_gateway_profile') }}",
                    type: "POST",
                    data:{site_id:site_id,_token:_token},
                    dataType: "json",
                    beforeSend: function(){
                        $('#gateway_profile').html('');
            			//$("#gateway_profile").css("background","#fff url(https://owlok.in/carbook/assets/frontend/lg.jpeg) no-repeat 100px");
            		
            		},
                    success:function(data) {
                        
                    //   alert(data);
                     data1 = $.parseJSON(data);
                         $.each(data1, function(key, value){
                			$('#gateway_profile').append('<option value="'+ value.profile_name+'|'+value.profile_price+'">'+ value.profile_name+' | Price : '+ value.profile_price+'</option>');
                		});
                		
                    } 
       }); 
         
  });
</script>
<script type="text/javascript">
 $('#site_id').on('change', function() {
    //  alert($('#site_id').val());
      $('#user_mob_new').removeAttr('disabled');
      $('#user_mob_new').val('');
      $('#user_name').val('');
     	$('#gateway_profile').val('');
       var _token = $('input[name="_token"]').val();
          var site_id = $('#site_id').val();
           $('#user_mob_new').html('');
        //   alert(site_id);
              $.ajax({
                    url: "{{ route('get_mobile_number_sitewise') }}",
                    type: "POST",
                    data:{site_id:site_id,_token:_token},
                    dataType: "json",
                    beforeSend: function(){
                        $('#user_mob_new').html('');
            			//$("#gateway_profile").css("background","#fff url(https://owlok.in/carbook/assets/frontend/lg.jpeg) no-repeat 100px");
            		
            		},
                    success:function(data) {
                        
                    //   alert(data);
                    //  data1 = $.parseJSON(data);
                         $.each(data, function(key, value){
                			$('#user_mob_new').append('<option value="'+ value.mobile+'">'+ value.mobile+' | '+ value.name+'</option>');
                		});
                		
                    } 
       }); 
         
  });
</script>
<script>
//     $(document).ready(function(){

//  $('#user_mob').keyup(function(){ 
//   var site_id = $('#site_id').val();

//         var user_mobField = $('#user_mob').val();
//         if(user_mobField != '')
//         {
//          var _token = $('input[name="_token"]').val();
//          $.ajax({
//           url:"{{ route('get_user_detail') }}",
//           method:"POST",
//           data:{site_id:site_id,user_mobField:user_mobField, _token:_token},
//           beforeSend: function(){
//             			$("#user_mob").css("background","#fff url(https://thumbs.gfycat.com/ChubbyEmbarrassedEchidna-max-1mb.gif) no-repeat 375px");
            		
//             		},
//           success:function(data){
//           $('#countryList').fadeIn();  
//                     $('#countryList').html(data);
//                     $("#user_mob").css("background","#fff");
//           }
//          });
//         }
//     });

//     $(document).on('click', 'li', function(){ 
//          var click_text = $(this).text().split('|');
//               $('#user_name').val($.trim(click_text[0]));
//               $('#user_mob').val($.trim(click_text[1])); 
//               $('#countryList').fadeOut();  
//               $("#user_mob").css("background","#fff");
//     });  

// });
</script>


<script>
  (function($) {
  $.fn.inputFilter = function(callback, errMsg) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
      if (callback(this.value)) {
        // Accepted value
        if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
          $(this).removeClass("input-error");
          this.setCustomValidity("");
        }
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        // Rejected value - restore the previous one
        $(this).addClass("input-error");
        this.setCustomValidity(errMsg);
        this.reportValidity();
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        // Rejected value - nothing to restore
        this.value = "";
      }
    });
  };
}(jQuery));


// Install input filters.
$("#user_mob").inputFilter(function(value) {
  return /^-?\d*$/.test(value); }, "Must be an integer");

</script>





  
@endsection