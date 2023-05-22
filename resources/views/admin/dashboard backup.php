<!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Clock In</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-between">
                    <div class="col" id="task_div">
                        <h4 class="mb-4">
                         <i class="fas fa-clock"></i> @php echo date('d-m-Y h:i a'); @endphp</h4>
                        <form action="{{ route('storeattendance') }}" method="post">
                            @csrf
                            <div class="form-group my-3">
                                <label class="f-14 text-dark-grey mb-12" data-label="true" for="working_from">Working From
                                        <sup class="f-14 mr-1">*</sup>
                                
                                </label>
                            
                                <select class="form-control height-35 f-14" placeholder="e.g. Office, Home, etc." name="working_from" id="working_from" required>
                                    <option value="">Select Place</option>
                                    <option value="Office">Office</option>
                                    <option value="Home">Work From Home</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Save">
                                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
            <!--employee dashboard-->
            <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
            <script src="{{ asset('admin/assets/vendor/chart.js/Chart.min.js') }}"></script>
            <!--<script src="{{ asset('admin/assets/js/demo/chart-area-demo.js') }}"></script>-->
            <!--<script src="{{ asset('admin/assets/js/demo/chart-pie-demo.js') }}"></script>-->
            <script>
                function number_format(number, decimals, dec_point, thousands_sep) {
                  // *     example: number_format(1234.56, 2, ',', ' ');
                  // *     return: '1 234,56'
                  number = (number + '').replace(',', '').replace(' ', '');
                  var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function(n, prec) {
                      var k = Math.pow(10, prec);
                      return '' + Math.round(n * k) / k;
                    };
                  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                  if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                  }
                  if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                  }
                  return s.join(dec);
                }
            </script>



            <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" style="width: 600px;">
                <div class="modal-header">
                    <h4 class="modal-title">Clock In</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-between">
                        <div class="col" id="task_div">
                            <h4 class="mb-4">
                                <i class="fas fa-clock"></i>
                                @php echo date('d-m-Y h:i a'); @endphp
                            </h4>
                            <form action="{{ route('storeattendance') }}" method="post">
                                @csrf
                                <div class="form-group my-3">
                                    <label class="f-14 text-dark-grey mb-12" data-label="true" for="working_from">Working From
                                        <sup class="f-14 mr-1">*</sup>
                                    </label>
                            
                                    <select class="form-control height-35 f-14" placeholder="e.g. Office, Home, etc." name="working_from" id="working_from" required>
                                        <option value="">Select Place</option>
                                        <option value="Office">Office</option>
                                        <option value="Home">Work From Home</option>
                                    </select>
                                </div>
                                <div class="form-group my-3">
                                    <label class="f-14 text-dark-grey mb-12" data-label="true" for="working_from">Live Location
                                        <sup class="f-14 mr-1">*</sup>
                                    </label>
                                    <input class="form-control height-45 f-14" placeholder="e.g. live location" name="live_location" id="live_location" required readonly>
                                </div>
                                <input class="address" type="hidden" name="formatted_address" value="">
                                <input name="lat" class="latitude" type="hidden" value="">
                                <input name="lng" class="longitude" type="hidden" value="">
                                <div class="loading" style="display: none">Loading&#8230;</div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary" value="Save">
                                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/chart.js/Chart.min.js') }}"></script>
    <!--<script src="{{ asset('admin/assets/js/demo/chart-area-demo.js') }}"></script>-->
    <!--<script src="{{ asset('admin/assets/js/demo/chart-pie-demo.js') }}"></script>-->
    
    <script>
        function number_format(number, decimals, dec_point, thousands_sep) {
            // * example: number_format(1234.56, 2, ',', ' ');
            // * return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
    </script>
    @if(!empty($todayattendance->id))  
        <!--for clock out model-->
        <div class="modal fade" id="myModal_clockout" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style="width: 600px;">
                    <div class="modal-header">
                        <h4 class="modal-title">Clock Out</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-between">
                            <div class="col" id="task_div">
                                <h4 class="mb-4">
                                    <i class="fas fa-clock"></i> 
                                    @php echo date('d-m-Y h:i a'); @endphp
                                </h4>
                                <form action="{{ route('checkoutattendance',$todayattendance->id) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="put">
                                    <div class="form-group my-3">
                                        <label class="f-14 text-dark-grey mb-12" data-label="true" for="working_from">Clock In
                                            <sup class="f-14 mr-1">*</sup>
                                        
                                        </label>
                                        <input class="form-control height-45 f-14" value="{{ date('H:i A',strtotime($todayattendance->clock_in))}}" placeholder="e.g. Clock In" disabled>
                                    </div>
                                    <div class="form-group my-3">
                                        <label class="f-14 text-dark-grey mb-12" data-label="true" for="live_location">Live Location
                                            <sup class="f-14 mr-1">*</sup>
                                        </label>
                                        <input class="form-control height-45 f-14 address" placeholder="e.g. live location" name="live_location" id="live_location" required readonly>
                                    </div>
                                    <input class="address" type="hidden" name="formatted_address" value="">
                                    <input name="lat" class="latitude" type="hidden" value="">
                                    <input name="lng" class="longitude" type="hidden" value="">
                                    <div class="loading" style="display: none">Loading&#8230;</div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary" value="Save">
                                        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end-->
        <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/chart.js/Chart.min.js') }}"></script>
        <script>
            function number_format(number, decimals, dec_point, thousands_sep) {
                // * example: number_format(1234.56, 2, ',', ' ');
                // * return: '1 234,56'
                number = (number + '').replace(',', '').replace(' ', '');
                var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }
        </script>
    @endif  

    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script> 
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACdj2YDqnKhGzGVJPkIYPNhqJPH9_5nVU&libraries=places"></script>
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
            $.getJSON(GEOCODING).done(function (location) {

                $('.latitude').val(position.coords.latitude);
                $('.longitude').val(position.coords.longitude);
                $('.address').val(location.results[0].formatted_address);
                $('#live_location').val(location.results[0].formatted_address);
                $('.loading').show('fast').delay(3000).hide('slow');
            })
        }
        function error(err) {
            console.log(err)
        }
    </script>


    <!--admin dashboard-->
@if(Auth::user()->role == '1') 
    <div class="container-fluid _dashboard-style">
        <!-- @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
         @endif
        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif -->
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="col-md-10">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>
            <div class="col-md-2"></div>
        </div>
        <!-- Content Row -->
        <div class="_icon-box">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            View Attendance</div>
                                    </div>
                                    <div class="col-auto _icon-br">
                                        <i class="fas fa-sync"></i>
                                        <a href="{{ route('attendance.index') }}" class="text-blue-300 d-none d-sm-inline-block btn btn-primary shadow-sm" style="background-color:#2e4fb19e;width: 54px;font-size: 12px;height: 32px;">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Staff</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_staff ?? '0' }}</div>
                                    </div>
                                    <div class="col-auto _icon-br">
                                        <i class="fas fa-user-check"></i>
                                        <a href="{{ route('staff_list') }}" class="text-blue-300 d-none d-sm-inline-block btn btn-primary shadow-sm" style="background-color:#2e4fb19e;width: 54px;font-size: 12px;height: 32px;">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Employee</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_employee ?? '0' }}</div>
                                    </div>
                                    <div class="col-auto _icon-br">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else