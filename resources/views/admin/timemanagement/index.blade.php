@extends('admin.layout')
@section('content')
    <div class="container-fluid _dashboard-style">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between _employee-deshboard _title-style">
            <div class="col-md-8">
                <h1 class="h3 mb-0 text-gray-800">Welcome @if(Auth::user()->name) {{ Auth::user()->name }} @endif @if(Auth::user()->last_name) {{ Auth::user()->last_name }} @endif </h1>
            </div>
            <div class="col-md-2"> &nbsp;&nbsp;&nbsp;
                <b> @php //echo (date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('h:i a') );  @endphp</b>
            </div>
        </div>
        <!-- Content Row -->
        <div class="_icon-box">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Timeline Daily Tracking</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="_icon-box">
            <div class="row">
                <div class="col-md-12" id="clock">
                    <b style="color: #000 !important; font-size: 20px;"> @php echo (date("l M d , Y", strtotime(date("Y/m/d"))).' '.date('h:i a').' '.date_default_timezone_get() );  @endphp</b>
                </div>
            </div>
            <div class="col-md-6" style="padding-top: 25px; border: 2px solid #c3c5e0; padding: 10px; border-radius: 25px; @if($on_leave) display: block; @endif">
                <div class="row" style="padding-top:15px">
                    <div class="col-md-6">
                        <b class="entry">Total Working Hours</b>
                    </div>
                    <div class="col-md-6">
                        <time class="entry" id="timer">00:00:00</time>
                    </div>
                </div>
                <div class="row" style="padding-top:20px">
                    <div class="col-md-3">
                        <button id="daystart" @if($is_login) disabled @endif onclick="dayStart();" class="btn dash">Login</button>
                    </div>
                    <div class="col-md-9">
                        <b id="login-time">@if($is_login) {{ $login_time }}@endif</b>
                    </div>
                </div>

                <div class="row" style="padding-top:20px">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <button class="btn dash1" @if(!$is_login) disabled @endif @if($is_logout) disabled @endif @if($is_break) disabled @endif onclick="breakStart();" id="breakstart">Break Start</button>
                    </div>
                    <div class="col-md-7">
                        <b id="break-start-time"> {{ $break_in_time }} </b>
                    </div>
                </div>
                <div class="row" style="padding-top:20px">
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                        <button class="btn dash1" @if($is_logout) disabled @endif @if($is_breakout) disabled @endif
                        @if(!$is_break) disabled @endif onclick="breakEnd();" id="breakend">Break End</button>
                    </div>
                    <div class="col-md-7">
                        <b id="break-out-time">@if($is_breakout) {{ $break_out_time }}@endif</b>
                    </div>
                </div>

                <div class="row" style="padding-top:20px">
                    <div class="col-md-3">
                        <button class="btn dash" @if(!$is_login) disabled @endif @if($is_break) {{ $break_in_time }} @endif @if($is_logout) disabled @endif onclick="dayEnd(1);" id="dayend">Logout</button>
                    </div>
                    <div class="col-md-9">
                        <b id="day-end-time">@if($is_logout) {{ $logout_time }}@endif</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ csrf_field() }}
    <style>
        .dash{
            color: #fff;
            padding: 10px 20px 10px 20px;
            background-color: #00b050;
            border-radius: 10px;
        }
        .dash1{
            color: #fff;
            padding: 10px 20px 10px 20px;
            background-color: #0b0c0b;
            border-radius: 10px;
        }
        .entry{
            color: #fff !important;
            background-color: #007bff !important;
            padding: 10px 40px 10px 40px !important;
        }
        .entry1{
            color: #fff !important;
            background-color: #ff6f00 !important;
            padding: 10px 40px 10px 40px !important;
        }

        #DataTables_Table_0_filter{
            display: none;
        }
        .dt-buttons{
            display: none;
        }
        .export_example{
            border: 2px solid #c3c5e0;
        }

        @media only screen and (min-width:1281px) and (max-width:1536px){
            .entry{
                color: #fff !important;
                background-color: #007bff !important;
                padding: 10px 15px 10px 15px !important;
            }
        }

        @media only screen and (min-width:1225px) and (max-width:1280px){
            .entry{
                color: #fff !important;
                background-color: #007bff !important;
                padding: 10px 15px 10px 15px !important;
            }
        }

        @media only screen and (min-width:769px) and (max-width:1224px){
            .entry{
                color: #fff !important;
                background-color: #007bff !important;
                padding: 10px 15px 10px 15px !important;
            }
        }

        @media only screen and (min-width:481px) and (max-width:768px){

        }

        @media only screen and (min-width:320px) and (max-width:480px){

        }

        @media only screen and (min-width:279px) and (max-width:319px){

        }

    </style>
    <script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        /*(function timer() {
            'use strict';
            //declare
            var output = document.getElementById('timer');
            var toggle = document.getElementById('daystart');
            var pause = document.getElementById('breakstart');
            var resum = document.getElementById('breakend');
            var dayend = document.getElementById('dayend');
            var running = false;
            var paused = false;
            var timer;

            // timer start time
            var then;
            // pause duration
            var delay;
            // pause start time
            var delayThen;

            // start timer
            var start = function() {
                delay = 0;
                running = true;
                then = Date.now();
                timer = setInterval(run,51);
                //toggle.innerHTML = 'stop';
                $('#daystart').attr('disabled',true);
                $('#breakstart').attr('disabled',false);
                $('#dayend').attr('disabled',false);
            };

            // parse time in ms for output
            var parseTime = function(elapsed) {
                // array of time multiples [hours, min, sec, decimal]
                var d = [3600000,60000,1000,10];
                var time = [];
                var i = 0;

                while (i < d.length) {
                    var t = Math.floor(elapsed/d[i]);

                    // remove parsed time for next iteration
                    elapsed -= t*d[i];

                    // add '0' prefix to m,s,d when needed
                    t = (i > 0 && t < 10) ? '0' + t : t;
                    time.push(t);
                    i++;
                }
                return time;
            };

            // run
            var run = function() {
                // get output array and print
                var time = parseTime(Date.now()-then-delay);
                output.innerHTML = time[0] + ':' + time[1] + ':' + time[2] ;
            };

            // stop
            var stop = function() {
                paused = true;
                delayThen = Date.now();
                //toggle.innerHTML = 'resume';
                $('#breakstart').attr('disabled',true);
                $('#breakend').attr('disabled',false);
                $('#dayend').attr('disabled',true);
                //clear.dataset.state = 'visible';
                clearInterval(timer);
                // call one last time to print exact time
                run();
            };

            // resume
            var resume = function() {
                paused = false;
                delay += Date.now()-delayThen;
                timer = setInterval(run,51);
                //toggle.innerHTML = 'stop';
                $('#breakend').attr('disabled',true);
                $('#breakstart').attr('disabled',false);
                $('#dayend').attr('disabled',false);
                //clear.dataset.state = '';
            };

            // clear
            var reset = function() {
                running = false;
                paused = false;
                //toggle.innerHTML = 'start';
                output.innerHTML = '0:00:00.00';
                //clear.dataset.state = '';
            };

            // evaluate and route
            var router = function() {
                if (!running) start();
                else if (paused) resume();
                else stop();
            };

            var end = function() {
                if (running) stop();
                $('#daystart').attr('disabled',true);
                $('#breakstart').attr('disabled',true);
                $('#breakend').attr('disabled',true);
                $('#dayend').attr('disabled',true);
            };
            
            toggle.addEventListener('click',router);
            pause.addEventListener('click',router);
            resum.addEventListener('click',resume);
            dayend.addEventListener('click',end);

        })();*/

        jQuery(document).ready(function($){
            //var isMobile = window.orientation > -1;
            //alert(isMobile ? 'Mobile' : 'Not mobile');
            // $('#breakstart').attr('disabled',true);
            // $('#breakend').attr('disabled',true);
            // $('#dayend').attr('disabled',true);

            /*localStorage.removeItem('startTime');
            localStorage.removeItem('breakstopTime');
            localStorage.removeItem('breakstartTime');
            localStorage.removeItem('time');
            localStorage.removeItem('dayend');*/

            setInterval(timestamp, 10000);
            var interval = 1000 * 60 * 1;
            setInterval(myteam, interval);
            if(localStorage.getItem('login_time')){
                $('#login-time').html(localStorage.getItem('login_time'));
            }

            if(localStorage.getItem('break-out-time')){
                $('#break-out-time').html(localStorage.getItem('break-out-time'));
            }
            if(localStorage.getItem('break-start-time')){
                $('#break-start-time').html(localStorage.getItem('break-start-time'));
            }

            if(localStorage.getItem('day-end-time')){
                $('#day-end-time').html(localStorage.getItem('day-end-time'));
            }

            if(localStorage.getItem('today')){
                var todate = localStorage.getItem('today');

                var d = new Date();
                var month = d.getMonth()+1;
                var day = d.getDate();
                var date = ((''+month).length<2 ? '0' : '') + month + '/' +
                    ((''+day).length<2 ? '0' : '') + day+ '/' +d.getFullYear();

                var todayend = parseInt(localStorage.getItem('dayend'));
                if(todate == date && todayend==1){
                }else{
                    localStorage.removeItem('dayend');
                    localStorage.removeItem('login_time');
                    localStorage.removeItem('break-out-time');
                    localStorage.removeItem('break-start-time');
                    localStorage.removeItem('day-end-time');
                }
            }else{
                var d = new Date();
                var month = d.getMonth()+1;
                var day = d.getDate();
                var date = ((''+month).length<2 ? '0' : '') + month + '/' +
                    ((''+day).length<2 ? '0' : '') + day+ '/' +d.getFullYear();
                localStorage.setItem('today', date);
            }
        });

        var i = checkconnection();

        function checkconnection() {
            var status = navigator.onLine;
            if (status) {
                return true;
            } else {
                return false;
            }
        }

        function timestamp() {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('clock') }}",
                method: 'POST',
                data:{ _token:_token},
                success: function(response) {
                    $('#clock').html(response);
                }
            });
        }

        function myteam() {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('myteam') }}",
                method: 'POST',
                data:{ _token:_token},
                success: function(response) {
                    $('#myteam').html(response);
                }
            });
        }

        function dayStart() {
            var _token = $('input[name="_token"]').val();
            //startTime = parseInt(Date.now());
            $.ajax({
                url: "{{ route('daystart') }}",
                method: 'POST',
                data:{ _token:_token},
                success: function(response) {
                    if(response.msg!=''){
                        alert(response.msg);
                        location.reload();
                    }else{
                        start();
                        $('#daystart').attr('disabled',true);
                        $('#breakstart').attr('disabled',false);
                        $('#breakend').attr('disabled',true);
                        $('#dayend').attr('disabled',false);
                        if(localStorage.getItem('login_time')){
                            $('#login-time').html(localStorage.getItem('login_time'));
                        }else{
                            localStorage.setItem('login_time', response.time);
                            $('#login-time').html(localStorage.getItem('login_time'));
                        }
                        alert("Login Sucess");
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert("Something Went Wrong Please try Again");
                }
            });
        }

        function dayEnd() {
            var _token = $('input[name="_token"]').val();
            var id = parseInt(localStorage.getItem('attendance_id'));
            $.ajax({
                url: "{{ route('dayend') }}",
                method: 'POST',
                data:{ _token:_token},
                success: function(response) {
                    $('#daystart').attr('disabled',true);
                    $('#breakstart').attr('disabled',true);
                    $('#breakend').attr('disabled',true);
                    $('#dayend').attr('disabled',true);
                    localStorage.setItem('day-end-time', response.time);
                    $('#day-end-time').html(localStorage.getItem('day-end-time'));
                    alert("You Are LogOut Now");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert("Something Went Wrong Please try Again");
                }
            });
        }

        function breakStart() {
            var _token = $('input[name="_token"]').val();
            var daystart = 'daystart';
            $.ajax({
                url: "{{ route('breakstart') }}",
                method: 'POST',
                data:{ _token:_token},
                success: function(response) {
                    stop();
                    $('#breakstart').attr('disabled',true);
                    $('#breakend').attr('disabled',false);
                    $('#dayend').attr('disabled',true);
                    localStorage.setItem('break-start-time', response.time);
                    $('#break-start-time').html(localStorage.getItem('break-start-time'));
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert("Something Went Wrong Please try Again");
                }
            });
        }

        function breakEnd() {
            var _token = $('input[name="_token"]').val();
            var id = parseInt(localStorage.getItem('attendance_id'));
            $.ajax({
                url: "{{ route('breakend') }}",
                method: 'POST',
                data:{ _token:_token},
                success: function(response) {
                    resume();
                    $('#breakend').attr('disabled',true);
                    $('#breakstart').attr('disabled',false);
                    $('#dayend').attr('disabled',false);
                    localStorage.setItem('break-out-time', response.time);
                    $('#break-out-time').html(localStorage.getItem('break-out-time'));
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert("Something Went Wrong Please try Again");
                }
            });
        }

        var timer;
        var startTime;
        var breakstartTime;
        var breakendTime;
        var time;

        var stopBtn = document.getElementById('breakstart');
        var toggle = document.getElementById('daystart');
        var pause = document.getElementById('breakstart');
        var resum = document.getElementById('breakend');
        var dayend = document.getElementById('dayend');

        function start() {
            startTime = parseInt(localStorage.getItem('startTime') || Date.now());
            localStorage.setItem('startTime', startTime);
            timer = setInterval(clockTick, 100);
        }

        function stop() {
            clearInterval(timer);
            var time =  $("#timer").html();
            localStorage.setItem('time', time);
            localStorage.removeItem('breakstartTime');
            breakstartTime = parseInt(localStorage.getItem('breakstartTime') || Date.now());
            localStorage.setItem('breakstartTime', breakstartTime);
            clearInterval(timer);
        }

        function reset() {
            clearInterval(timer);
            localStorage.removeItem('startTime');
            document.getElementById('timer').innerHTML = "00:00:00";
        }

        function resume(){
            breakstopTime = parseInt(localStorage.getItem('breakstopTime') || Date.now());
            breakstartTime = parseInt(localStorage.getItem('breakstartTime'));
            startTime = parseInt(localStorage.getItem('startTime'));
            diff = breakstopTime-breakstartTime;
            startTime = startTime+diff;
            localStorage.setItem('startTime', startTime);
            localStorage.removeItem('breakstopTime');
            localStorage.removeItem('breakstartTime');
            timer = setInterval(clockTick, 100);
        }

        function clockTick() {
            var currentTime = Date.now(),
                timeElapsed = new Date(currentTime - startTime),
                hours = timeElapsed.getUTCHours(),
                mins = timeElapsed.getUTCMinutes(),
                secs = timeElapsed.getUTCSeconds(),
                ms = timeElapsed.getUTCMilliseconds(),
                display = document.getElementById("timer");

            display.innerHTML =
                (hours > 9 ? hours : "0" + hours) + ":" +
                (mins > 9 ? mins : "0" + mins)+ ":" +
                (secs > 9 ? secs : "0" + secs);
        };

        /*toggle.addEventListener('click', function() {
            start();
        })

        stopBtn.addEventListener('click', function() {
            stop();
        })

        resum.addEventListener('click', function() {
            resume();
        })*/

        dayend.addEventListener('click', function() {
            stop();
            localStorage.setItem('dayend', 1);
            localStorage.removeItem('startTime', startTime);
            localStorage.removeItem('breakstopTime');
            localStorage.removeItem('breakstartTime');
            localStorage.removeItem('time');
        })

        if(localStorage.getItem('breakstartTime')){
            document.getElementById("timer").innerHTML=localStorage.getItem('time').toString();
            $('#daystart').attr('disabled',true);
            $('#breakstart').attr('disabled',true);
            $('#breakend').attr('disabled',false);
            $('#dayend').attr('disabled',true);
        } else if(localStorage.getItem('startTime')){
            start();
        }

        if(localStorage.getItem('dayend')){
            $('#daystart').attr('disabled',true);
            $('#breakstart').attr('disabled',true);
            $('#breakend').attr('disabled',true);
            $('#dayend').attr('disabled',true);
        }

    </script>
@endsection


