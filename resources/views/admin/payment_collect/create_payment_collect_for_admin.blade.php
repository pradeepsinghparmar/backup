@extends('admin.layout')

@section('content')
<style>
 input[type="month"]::before{
  content: attr(placeholder="Select Month year") !important;
  color: #aaa;
  width: 100%;
}

input[type="month"]:focus::after,
input[type="month"]:active::after {
  content: "";
  width: 0%;
}
</style>
  <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                                        <div class="col-md-10">
                                   <h1 class="h3 mb-2 text-gray-800">Create Payment Collect</h1>
                                    </div>
                                     <div class="col-md-2">
                                     <a href="{{ route('all_emp_payment_collect') }}" class="btn btn-dark btn-icon-split">
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
<form action="{{ route('store_payment_collect_for_admin') }}" method="post" enctype="multipart/form-data">
@csrf
    <div class="row mb-3">
        <label for="validationCustom01" class="col-sm-3 col-form-label">Site Name</label>
        <div class="col-sm-9">
            <select name="site_id" ID="site_id" class="form-control" for="validationCustom01" required>
                <option value="">Select Site Name</option>
                @foreach($site_list as $info)
                <option value="{{ $info->name }}">{{ $info->site_id_name }} (Site No - {{ $info->name }})</option>
                @endforeach
                </select>
        </div>
    </div>
    <!--<div class="row mb-3">-->
    <!--    <label for="validationCustom01" class="col-sm-3 col-form-label">Month</label>-->
    <!--    <div class="col-sm-9">-->
    <!--        <select name="month" class="form-control" for="validationCustom01" required>-->
    <!--            <option value="">Select Month</option>-->
    <!--            <option value="01">Jan</option>-->
    <!--            <option value="02">Feb</option>-->
    <!--            <option value="03">March</option>-->
    <!--            <option value="04">April</option>-->
    <!--            <option value="05">May</option>-->
    <!--            <option value="06">Jun</option>-->
    <!--            <option value="07">July</option>-->
    <!--            <option value="08">Aug</option>-->
    <!--            <option value="09">Sep</option>-->
    <!--            <option value="10">Oct</option>-->
    <!--            <option value="11">Nov</option>-->
    <!--            <option value="12">Dec</option>-->
    <!--            </select>-->
    <!--    </div>-->
    <!--</div>-->
     <div class="row mb-3">
        <label for="validationCustom01" class="col-sm-3 col-form-label">Month-Year</label>
        <div class="col-sm-9">
            <input id="month" type="month" class="form-control" name="month" disabled  required>
        </div>
    </div>
     <div class="row mb-3">
        <label for="validationCustom02" class="col-sm-3 col-form-label">Total Amount</label>
        <div class="col-sm-9">
            <input type="number" name="total_amount" placeholder="Total Amount" class="form-control" id="total_amount" required readonly>
        </div>
    </div>
     <div class="row mb-3">
        <label for="validationCustom02" class="col-sm-3 col-form-label">Cash Received</label>
        <div class="col-sm-9">
            <input type="number" name="cash_received"  min="1" placeholder="Cash Received" class="form-control" id="validationCustom02" required>
        </div>
    </div>
    <!-- <div class="row mb-3">-->
    <!--    <label for="validationCustom02" class="col-sm-3 col-form-label">Cash Due</label>-->
    <!--    <div class="col-sm-9">-->
    <!--        <input type="number" name="cash_due" min="1"  placeholder="Cash Due" class="form-control" id="validationCustom02" required>-->
    <!--    </div>-->
    <!--</div>-->
     <div class="row mb-3">
        <label for="validationCustom02" class="col-sm-3 col-form-label">Date</label>
        <div class="col-sm-9">
            <input type="date" name="date"  id="pdate" placeholder="date" class="form-control" id="validationCustom02" value="{{ date('Y-m-d') }}">
        </div>
    </div>
    
     <div class="row mb-3">
        <label for="validationCustom02" class="col-sm-3 col-form-label">Site Location</label>
        <div class="col-sm-9">
            <input type="text" name="site_location"  readonly placeholder="Site Location" class="form-control" id="site_location">
        </div>
    </div>
     
    
   <input class="address" type="hidden" name="formatted_address" value="">
                            <input name="lat" class="latitude" type="hidden" value="">
                            <input name="lng" class="longitude" type="hidden" value="">
 <div class="loading" style="display: none">Loading&#8230;</div>
   
    <input type="submit" class="btn btn-primary" value="Save">
    
</form>
                                        
        </div>                                
              
                           </div>
                           </div>
                                        
                                        
                                        
                                        
                                     
                    </div>
                </div>
            </div>
        <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
         <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACdj2YDqnKhGzGVJPkIYPNhqJPH9_5nVU&libraries=places"></script>
<script>
//     $(function(){
//     var dtToday = new Date();
    
//     var month = dtToday.getMonth() + 1;
//     var day = dtToday.getDate();
//     var year = dtToday.getFullYear();
//     if(month < 10)
//         month = '0' + month.toString();
//     if(day < 10)
//         day = '0' + day.toString();
    
//     var maxDate = year + '-' + month + '-' + day;
//     $('#pdate').attr('min', maxDate);
// });
</script>
<script>
    
    jQuery(document).ready(function($){
	var offset = 100,
		offset_opacity = 150,
		scroll_top_duration = 500,
		$back_to_top = $('.cd-top');
		
	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
		if( $(this).scrollTop() > offset_opacity ) { 
			$back_to_top.addClass('cd-fade-out');
		}
	});
	
	$back_to_top.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0 ,
		 	}, scroll_top_duration
		);
	});
	
	$('.btnNext').click(function(){
	  $('.faculty_tab > .active').next('li').find('a').trigger('click');
	});

	  $('.btnPrevious').click(function(){
	  $('.faculty_tab > .active').prev('li').find('a').trigger('click');
	});

	$("body").on("contextmenu",function(e){
		//return false;
	});

	window_refresh_timeSet();
	
	
});


function window_refresh_timeSet(){
	var viewportWidth = $(window).width();
	if (viewportWidth < 767) {
		
		$('.tab-content>.tab-pane').removeClass('fade');
		$('.tab-content>.tab-pane').css( "display", "inline-block" );
			
				$('.mainNav li a[href^="#"]').on('click',function (e) {
					
					$('.navbar-toggle').removeClass('collapsed');
					$('#myNavbar').removeClass('in');
					
					e.preventDefault();

					var target = this.hash;
					var $target = $(target);

					$('html, body').stop().animate({
						'scrollTop': $target.offset().top
					}, 900, 'swing', function () {
						window.location.hash = target;
					});
				});
	}

	setTimeout(window_refresh_timeSet, 50);     
}

$(document).ready(function(){
//open popup
$("#pop").click(function(){
	// alert();
$("#overlay_form").fadeIn(1000);
positionPopup();
});
 
//close popup
$("#close").click(function(){
$("#overlay_form").fadeOut(500);
});
});
 
//position the popup at the center of the page
function positionPopup(){
if(!$("#overlay_form").is(':visible')){
return;
}

}
 
//maintain the popup at center of the page when browser resized
$(window).bind('resize',positionPopup);

navigator.geolocation.getCurrentPosition(success, error);
    function success(position)
    {
        var GEOCODING = 'https://maps.googleapis.com/maps/api/geocode/json?address='+ position.coords.latitude +','+ position.coords.longitude +'&key=AIzaSyACdj2YDqnKhGzGVJPkIYPNhqJPH9_5nVU';
        // alert(GEOCODING);
        $.getJSON(GEOCODING).done(function (location) {
           
            $('.latitude').val(position.coords.latitude);
            $('.longitude').val(position.coords.longitude);
            $('.address').val(location.results[0].formatted_address);
            $('#site_location').val(location.results[0].formatted_address);
            $('.loading').show('fast').delay(3000).hide('slow');
        })
    }
    function error(err) {
        console.log(err)
    }



</script>
{{ csrf_field() }}

<script type="text/javascript">
 $('select[name="site_id"]').on('change', function() {
    //  alert();
      $('#month').removeAttr('disabled');
       $('#month').val('');
  });
    $(document).ready(function() {
        var _token = $('input[name="_token"]').val();
        $('input[name="month"]').on('change', function() {
            
            var month = $(this).val();
            var site_id = $('#site_id').val();
            // alert(month);
            // alert(site_id);
            if(month && site_id) {
                $.ajax({
                    url: "{{ route('getTotalSitePayment') }}",
                    type: "POST",
                    dataType: "json",
                    data:{site_id:site_id,month:month, _token:_token},
                    success:function(data) {
                    //   alert(data);
                            $('#total_amount').val(data);
                    }
                });
            }
        });
    });
</script>
@endsection