@extends('layouts/user')
@section('title')
    profile
@endsection

@section('css')
<link href="/dist/css/style.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/assets/libs/dropzone/dist/min/dropzone.min.css">
<link href="/assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
<link href="/dist/js/pages/chartist/chartist-init.css" rel="stylesheet">
<link href="/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css" rel="stylesheet">
<link href="/assets/extra-libs/css-chart/css-chart.css" rel="stylesheet">
<link href="/assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/libs/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css">

@endsection

@section('main')
<div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-5 align-self-center">
                    <h4 class="page-title">Profile</h4>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><b>{{$user->name}}</b> profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <div class="m-r-10">
                            <div class="lastmonth"></div>
                        </div>
                        <div class="">
                        @if(count(Auth::user()->bpms) > 0)
                        <small>Your LAST Bpm</small>
                        <h4 class="text-info m-b-0 font-medium">
                            @if(Auth::user()->bpms->first()['bpm'])
                            <span class='lastbpm'>{{Auth::user()->bpms->last()['bpm']}}</span> since 
                            <span class='lastbpm_date'>{{Auth::user()->bpms->last()['created_at']->diffForHumans()}}</span>
                            
                            @else
                            no data
                            @endif
                        </h4>
                        @else
                        <h4 style="color:red">No Data</h4>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- Row -->
            <div class="row">
                <!-- Column -->
                <div class="col-lg-3 col-xlg-4 col-md-4">
                    <div class="card">
                        <div class="card-body">
                        <center class="m-t-30"> <img src="{{$user->avatar != null ? $user->avatar : "https://ui-avatars.com/api/?size=500&name=$user->name" }}" class="rounded-circle" width="150" />
                                <h4 class="card-title m-t-10">{{$user->name}}</h4>
                            <h6 class="card-subtitle"><?php echo $user->state == 1 ? "active" : "not active" ?></h6>
                                <div class="row text-center justify-content-md-center">
                                <div class="col-12"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">{{count($user->families)}}</font></a></div>
                                </div>
                            </center>
                        </div>
                        <div>
                        <hr> 
                        </div>
                        <div class="card-body"> 
                        <a href="{{route('healt_report')}}"><button type="button" class="btn btn-block btn-lg btn-info">Download My Report <i class="fa fa-heart"></i></button></a><br>
                        <small class="text-muted"><i class="fas fa-envelope"></i> Email address </small>
                        <h6>{{$user->email}}</h6>
                        @if (!is_null($user->phone))
                        <small class="text-muted p-t-30 db"><i class="fas fa-phone"></i> Phone</small>
                        <h6>0{{$user->phone}}</h6>
                        @endif
                        @if (!is_null($user->age))
                            <small class="text-muted p-t-30 db"><i class=" fas fa-child"></i> age</small>
                            <h6>{{$user->age}} Years</h6>
                        @endif
                        @if (!is_null($user->weight))
                            <small class="text-muted p-t-30 db"><i class="fas fa-weight"></i> weight</small>
                            <h6>{{$user->weight}} Kg</h6>
                        @endif
                        @if (!is_null($user->geneder))
                            <small class="text-muted p-t-30 db"> <i class="fas fa-user"></i> geneder</small>
                            <h6>{{$user->geneder}}</h6>
                        @endif
                        @if (!is_null($user->start_sleep))
                            <small class="text-muted p-t-30 db"><i class="far fa-clock"></i> i sleep at</small>
                            <h6>{{$user->start_sleep}}</h6>
                        @endif
                        @if (!is_null($user->end_sleep))
                            <small class="text-muted p-t-30 db"><i class="far fa-clock"></i> i wake up at</small>
                            <h6>{{$user->end_sleep}}</h6>
                        @endif
                        </div>
                    </div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-9 col-xlg-8 col-md-8">
                    <div class="card">
                        <!-- Tabs -->
                        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Setting</a>
                            </li>
                        </ul>
                        <!-- Tabs -->
                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong>
                                            <br>
                                        <p class="text-muted">{{$user->name}}</p>
                                        </div>
                                        @if (!is_null($user->phone))
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                            <br>
                                        <p class="text-muted">{{$user->phone}}</p>
                                        </div>
                                        @endif
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                                            <br>
                                        <p class="text-muted">{{$user->email}}</p>
                                        </div>
                                    </div>
                                    <hr>


                                    <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="row">
                                                        <div class="col-lg-9 col-md-7">
                                                            <div class="card-body">
                                                                <h4 class="card-title">Realtime Data of Bpm</h4>
                                                            <h5 class="card-subtitle lastbpm_date">{{$date}}</h5>
                                                                <div class="demo-container m-t-20" style="width:100%; height:400px;">
                                                                    <div id="placeholder" class="flot-chart-content" style="width:100%; height:400px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-5 border-left p-l-0">
                                                            <div class="text-center m-t-30 m-b-40 p-t-20 p-b-20">
                                                             @if(count(Auth::user()->bpms) > 0)
                                                                <font class="display-3 lastbpm">{{Auth::user()->lastBpm(Auth::user()->id)['bpm']}}</font>
                                                                <h6 class="text-muted lastbpm_date">{{Auth::user()->lastBpm(Auth::user()->id)['created_at']->diffforhumans() }}</h6>
                                                            @else
                                                             <font class="display-3">No Data</font>
                                                            @endif
                                                            </div>
                                                            <hr>
                                                            <div class="card-body">
                                                                <div class="row text-center">
                                                                    <!-- Column -->
                                                                    <div class="col p-r-0">
                                                                        <h1 class="font-light lastminute">{{round( Auth::user()->lastBpmMinute(Auth::user()->id)  , 2)}}</h1>
                                                                        <h6 class="text-muted">Beat per <span class="num_minute"></span><br> minute</h6></div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="card-body">
                                                                <div class="row text-center">
                                                                    <!-- Column -->
                                                                    <div class="col p-r-0">
                                                                        <h1 class="font-light lasthour">{{round( Auth::user()->lastBpmHour(Auth::user()->id)  , 2)}}</h1>
                                                                        <h6 class="text-muted">Beat per <span class="num_hour"></span><br> Hour</h6>
                                                                    </div>
                                                                    <!-- Column -->
                                                                </div>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row text-center">
                                                                    <!-- Column -->
                                                                    <div class="col p-r-0">
                                                                        <h1 class="font-light lastday">0</h1>
                                                                        <h6 class="text-muted">Beat per <span class="num_day"></span><br> Day</h6></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    @if (count($user->families) > 0)
                                    <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-lg-4">
                                                            <div class="card-body">
                                                                <h4 class="card-title">Family</h4>
                                                                <h5 class="card-subtitle">last hour Bpms</h5>
                                                                <h2 class="font-medium m-t-40 m-b-0">{{count($user->families)}}</h2>
                                                                <span class="text-muted">of Your family use our product</span>
                                                                <div class="image-box m-t-30 m-b-30">
                                                                    @foreach ($user->families as $member)
                                                                <a href="{{route('user_profile2' , $member->user->id)}}" class="m-r-10" data-toggle="tooltip" data-placement="top" title="{{$member->user->name}}"><img src='{{$member->user->avatar != null ? $member->user->avatar : "https://ui-avatars.com/api/?size=500&name=" . $member->user->name }}' class="rounded-circle" width="45" alt="user"></a>
                                                                    @endforeach
                                                                </div>
                                                            <a href="{{route('family')}}" class="btn btn-lg btn-info waves-effect waves-light">Checkout All family</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-lg-8 border-left">
                                                            <div class="card-body">
                                                                <ul class="list-style-none">
                                                                    @foreach ($user->families->take(3) as $member2) 
                                                                    <li class="m-t-30">
                                                                        <div class="d-flex align-items-center">
                                                                            @if(count(Auth::user()->lastBpm($member2->user->id)) > 0)
                                                                                @if(Auth::user()->lastBpm($member2->user->id)['bpm'] > 80 || Auth::user()->lastBpm($member2->user->id)['bpm'] < 60)
                                                                                    <i class="mdi mdi-emoticon-dead display-5 text-muted"></i>
                                                                                @else
                                                                                    <i class="mdi mdi-emoticon-excited display-5 text-muted"></i>
                                                                                @endif
                                                                            @else
                                                                                <i class="mdi mdi-emoticon-neutral display-5 text-muted"></i>
                                                                            @endif
                                                                            <div class="m-l-10">
                                                                            <h5 class="m-b-0">
                                                                                <a 
                                                                                    href="{{route('user_profile2' , $member2->user->id)}}"
                                                                                >
                                                                                    {{$member2->user->name}}
                                                                                </a>
                                                                            </h5>
                                                                                @if(count(Auth::user()->lastBpm($member2->user->id)) > 0)
                                                                                <span class="text-muted">Bpm : {{Auth::user()->lastBpm($member2->user->id)['bpm'] }} At {{Auth::user()->lastBpm($member2->user->id)['created_at']->diffforhumans() }}</span>
                                                                                @else
                                                                                <span class="text-muted">No Data</span>
                                                                                @endif
                                                                                </div>
                                                                        </div>
                                                                        <div class="progress">
                                                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{Auth::user()->lastBpm($member2->user->id)['bpm']}}%" aria-valuenow="{{Auth::user()->lastBpm($member2->user->id)['bpm']}}" aria-valuemin="60" aria-valuemax="90"></div>
                                                                        </div>
                                                                    </li>
                                                                    @endforeach
                                                                    {{-- <li class="m-t-30">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="mdi mdi-emoticon-sad display-5 text-muted"></i>
                                                                            <div class="m-l-10">
                                                                                <h5 class="m-b-0">Negative Reviews</h5>
                                                                                <span class="text-muted">5547 Reviews</span></div>
                                                                        </div>
                                                                        <div class="progress">
                                                                            <div class="progress-bar bg-orange" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="60" aria-valuemax="90"></div>
                                                                        </div>
                                                                    </li>
                                                                    <li class="m-t-30">
                                                                        <div class="d-flex align-items-center">
                                                                            <i class="mdi mdi-emoticon-neutral display-5 text-muted"></i>
                                                                            <div class="m-l-10">
                                                                                <h5 class="m-b-0">Neutral Reviews</h5>
                                                                                <span class="text-muted">547 Reviews</span></div>
                                                                        </div>
                                                                        <div class="progress">
                                                                            <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="60" aria-valuemax="90"></div>
                                                                        </div>
                                                                    </li> --}}
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- Row -->
                                    @endif
                                </div>
                            </div>
                            <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                                <div class="card-body">
                                <form class="form-horizontal form-material" method="POST" action="{{route("update_profile")}}">
                                    @csrf
                                        <div class="form-group">
                                            <label class="col-md-12">Full Name</label>
                                            <div class="col-md-12">
                                            <input type="text" placeholder="name" class="form-control form-control-line" name="name" value="{{ !is_null($user->name) ? $user->name : old('name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Password</label>
                                            <div class="col-md-12">
                                                <input type="password" value="" class="form-control form-control-line" name="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-12">Confirm Password</label>
                                                <div class="col-md-12">
                                                    <input type="password" value="" class="form-control form-control-line" name="password_confirmation">
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Phone No</label>
                                            <div class="col-md-12">
                                            <input type="text" placeholder="phone number" class="form-control form-control-line" name="phone" value="{{ !is_null($user->phone) ? $user->phone : old('phone') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-12">Age</label>
                                                <div class="col-md-12">
                                                <input type="number" placeholder="Age" class="form-control form-control-line" name="age" value="{{ !is_null($user->age) ? $user->age : old('age') }}">
                                                </div>
                                            </div>
                                        <div class="form-group">
                                            <label class="col-sm-12">Select geneder</label>
                                            <div class="col-sm-12">
                                                <select class="form-control form-control-line" name="geneder">
                                                    <option value="male" {{ $user->geneder == "male" ? "selected" : "" }} >male</option>
                                                    <option value="female" {{ $user->geneder == "female" ? "selected" : "" }} >female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">start sleep</label>
                                            <div class="col-md-12">
                                                <input type="time" placeholder="start sleep" class="form-control form-control-line" name="start_sleep" value="{{ !is_null($user->start_sleep) ? $user->start_sleep : old('start_sleep') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label class="col-md-12">start sleep</label>
                                                <div class="col-md-12">
                                                <input type="time" placeholder="end sleep" class="form-control form-control-line" name="end_sleep" value="{{ !is_null($user->end_sleep) ? $user->end_sleep : old('end_sleep') }}">
                                                </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success" type="submit">Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
            <!-- Row -->
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Right sidebar -->
            <!-- ============================================================== -->
            <!-- .right-sidebar -->
            <!-- ============================================================== -->
            <!-- End Right sidebar -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
    </div>
@endsection
@section('js')
<script src="/assets/libs/dropzone/dist/min/dropzone.min.js"></script>
<script src="/assets/libs/chartist/dist/chartist.min.js"></script>
<script src="/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<script src="/assets/libs/echarts/dist/echarts-en.min.js"></script>
<script src="/assets/libs/flot/excanvas.min.js"></script>
<script src="/assets/libs/flot/jquery.flot.js"></script>
<script src="/assets/libs/jquery.flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="/assets/extra-libs/c3/d3.min.js"></script>
<script src="/assets/extra-libs/c3/c3.min.js"></script>
<script src="/assets/libs/gaugeJS/dist/gauge.min.js"></script>
    <script src="/assets/libs/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>

<script>

   /* function getRandomData() {
        $.ajaxSetup({async: false});
        $.ajax({
            beforeSend: function(request) {
                request.setRequestHeader("Authorization", 'Bearer {{Auth::user()->api_token}}');
            },
            dataType: "json",
            url: "http://hearts2020.com/api/user/bpm/last",
            success: function(json) {
                if(!$.isEmptyObject(json)){
                    if(data.length > 0){
                        if(data.length > 0 && data[data.length - 1].created_at != json.created_at){
                            data.push(json.bpm);
                            $('.lastbpm').text(json.bpm);
                            $('.lastbpm_date').text(time_ago(new Date(json.created_at)));
                            console.log(data);
                        }
                    }
                    else{
                        data.push(json.bpm);
                        $('.lastbpm').text(json.bpm);
                        $('.lastbpm_date').text(time_ago(new Date(json.created_at)));
                        console.log(data);
                    }
                    $('.lastbpm_date').text(time_ago(new Date(json.created_at)))
                }
            }
        }).done(function (data) {
            return [44,50,22];
        });
        return [44,50,22];
    }
    */





$(function() {
    "use strict";
    var data = [],
        totalPoints = 300;

    function getRandomData() {
        if (data.length > 0) data = data.slice(1);
        // Do a random walk
        while (data.length < totalPoints) {
            var prev = data.length > 0 ? data[data.length - 1] : 50,
                y = prev + Math.random() * 10 - 5;
            if (y < 0) {
                y = 0;
            } else if (y > 100) {
                y = 100;
            }
            data.push(y);
        }
        // Zip the generated y values with the x values
        var res = [];
        for (var i = 0; i < data.length; ++i) {
            res.push([i, data[i]])
        }
        return res;
    }
    // Set up the control widget
    var updateInterval = 250;
    $("#updateInterval").val(updateInterval).change(function() {
        var v = $(this).val();
        if (v && !isNaN(+v)) {
            updateInterval = +v;
            if (updateInterval < 1) {
                updateInterval = 1;
            } else if (updateInterval > 3000) {
                updateInterval = 3000;
            }
            $(this).val("" + updateInterval);
        }
    });
    var plot = $.plot("#placeholder", [getRandomData()], {
        series: {
            shadowSize: 0 // Drawing is faster without shadows
        },
        yaxis: {
            min: 0,
            max: 100
        },
        xaxis: {
            show: false
        },
        colors: ["#26c6da"],
        grid: {
            color: "#AFAFAF",
            hoverable: true,
            borderWidth: 0,
            backgroundColor: 'transparent'
        },
        tooltip: true,
        tooltipOpts: {
            content: "Visit: %y",
            defaultTheme: false
        }
    });
    $(window).resize(function() {
        $.plot($('#placeholder'), data);
    });

    function update() {
        plot.setData([getRandomData()]);
        // Since the axes don't change, we don't need to call plot.setupGrid()
        plot.draw();
        setTimeout(update, updateInterval);
    }
    update();
    });
</script>
<script>
var dataARR = [];
function time_ago(time) {

  switch (typeof time) {
    case 'number':
      break;
    case 'string':
      time = +new Date(time);
      break;
    case 'object':
      if (time.constructor === Date) time = time.getTime();
      break;
    default:
      time = +new Date();
  }
  var time_formats = [
    [60, 'seconds', 1], // 60
    [120, '1 minute ago', '1 minute from now'], // 60*2
    [3600, 'minutes', 60], // 60*60, 60
    [7200, '1 hour ago', '1 hour from now'], // 60*60*2
    [86400, 'hours', 3600], // 60*60*24, 60*60
    [172800, 'Yesterday', 'Tomorrow'], // 60*60*24*2
    [604800, 'days', 86400], // 60*60*24*7, 60*60*24
    [1209600, 'Last week', 'Next week'], // 60*60*24*7*4*2
    [2419200, 'weeks', 604800], // 60*60*24*7*4, 60*60*24*7
    [4838400, 'Last month', 'Next month'], // 60*60*24*7*4*2
    [29030400, 'months', 2419200], // 60*60*24*7*4*12, 60*60*24*7*4
    [58060800, 'Last year', 'Next year'], // 60*60*24*7*4*12*2
    [2903040000, 'years', 29030400], // 60*60*24*7*4*12*100, 60*60*24*7*4*12
    [5806080000, 'Last century', 'Next century'], // 60*60*24*7*4*12*100*2
    [58060800000, 'centuries', 2903040000] // 60*60*24*7*4*12*100*20, 60*60*24*7*4*12*100
  ];
  var seconds = (+new Date() - time) / 1000,
    token = 'ago',
    list_choice = 1;

  if (seconds == 0) {
    return 'Just now'
  }
  if (seconds < 0) {
    seconds = Math.abs(seconds);
    token = 'from now';
    list_choice = 2;
  }
  var i = 0,
    format;
  while (format = time_formats[i++])
    if (seconds < format[0]) {
      if (typeof format[2] == 'string')
        return format[list_choice];
      else
        return Math.floor(seconds / format[2]) + ' ' + format[1] + ' ' + token;
    }
  return time;
}
setInterval(function () {
    $.ajax({
    beforeSend: function(request) {
        request.setRequestHeader("Authorization", 'Bearer {{Auth::user()->api_token}}');
    },
    dataType: "json",
    url: "http://hearts2020.com/api/user/data",
    success: function(json) {
    if(!$.isEmptyObject(json)){
        if(dataARR.length > 0){
            if(dataARR.length > 0 && dataARR[dataARR.length - 1].created_at != json['bpm']['last'].created_at){
                dataARR.push(json['bpm']['last']);
                
                $('.lastbpm').text(json['bpm']['last'].bpm)
                $('.lastbpm_date').text(time_ago(new Date(json['bpm']['last'].created_at)))
                
                $('.lastminute').text(json['bpm']['avg']['minute'].value);
                $('.num_minute').text(json['bpm']['avg']['minute'].time);

                $('.lasthour').text(json['bpm']['avg']['hour'].value);
                $('.num_hour').text(json['bpm']['avg']['hour'].time);
                
                $('.lastday').text(json['bpm']['avg']['day'].value);
                $('.num_day').text(json['bpm']['avg']['day'].time);


            }
        }
        else{
            dataARR.push(json['bpm']['last']);
            $('.lastbpm').text(json['bpm']['last'].bpm)
            $('.lastbpm_date').text(time_ago(new Date(json['bpm']['last'].created_at)))
            
            $('.lastminute').text(json['bpm']['avg']['minute'].value);
            $('.num_minute').text(json['bpm']['avg']['minute'].time);
            
            $('.lasthour').text(json['bpm']['avg']['hour'].value);
            $('.num_hour').text(json['bpm']['avg']['hour'].time);
            
            $('.lastday').text(json['bpm']['avg']['day'].value);
            $('.num_day').text(json['bpm']['avg']['day'].time);
            
        }
        $('.lastbpm_date').text(time_ago(new Date(json['bpm']['last'].created_at)))
    }

    }
}).done(function(results) {
        console.log("done : " + dataARR);
});
} , 3000); 
</script>
@endsection
