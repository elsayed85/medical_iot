@extends('layouts/user')
@section('title')
    Home
@endsection

@section('css')
<link href="/dist/css/style.min.css" rel="stylesheet">
<style>
    .red{
        color:red!important;
    }
</style>
@endsection

@section('main')
<div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-5 align-self-center">
                    <h4 class="page-title">Welcome {{Auth::user()->name}}</h4>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-left border-orange">
                                    <div class="card-body">
                                        <a href="{{route("family")}}">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <span class="text-orange display-6"><i class="ti-user"></i></span>
                                            </div>
                                            <div class="ml-auto">
                                                <h2>{{count(Auth::user()->families)}}</h2>
                                                <h6 class="text-orange">Family members</h6>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-left border-info">
                                    <div class="card-body">
                                        <a href="{{route("doctor.index")}}">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <span class="text-info display-6"><i class="fas fa-user-md"></i></span>
                                            </div>
                                            <div class="ml-auto">
                                                <h2>{{count(Auth::user()->doctors)}}</h2>
                                                <h6 class="text-info">Doctors</h6>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-left border-cyan">
                                    <div class="card-body">
                                        <a href="{{route("user_profile")}}">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <span class="text-cyan display-6"><i class="fas fa-heartbeat heart_icon"></i></span>
                                            </div>
                                            <div class="ml-auto">
                                                <h2 class="all">{{count(Auth::user()->bpms)}}</h2>
                                                <h6 class="text-cyan">All Heart Beats</h6>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="card border-left border-success">
                                    <div class="card-body">
                                        <a href="{{route("user_profile")}}">
                                        <div class="d-flex no-block align-items-center">
                                            <div>
                                                <span class="text-success display-6"><i class="fas fa-heartbeat"></i></span>
                                            </div>
                                            <div class="ml-auto">
                                                @if(count(Auth::user()->lastBpm(Auth::user()->id)))
                                                <h2 class="lastbpm">{{Auth::user()->lastBpm(Auth::user()->id)->bpm}}</h2>
                                                @else
                                                <h2>0</h2>
                                                @endif
                                                <h6 class="text-success">last Bpm</h6>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <input class="dial" data-readOnly='true' data-plugin="knob" data-width="250" data-height="250" name="temp" data-angleOffset="90" data-linecap="round" data-fgColor="#7460ee" value="0" />
                                </div>
                            </div>
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
    <script src="/assets/extra-libs/knob/jquery.knob.min.js"></script>
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
            if((dataARR.length > 0 && dataARR[dataARR.length - 1].created_at != json['temp']['last'].created_at)){
                dataARR.push(json['temp']['last']);
                knobfunction(json['temp']['last'].temp)
                
            $('.lastbpm').text(json['bpm']['last'].bpm)
            $('.lastbpm_date').text(time_ago(new Date(json['bpm']['last'].created_at)))
            
            }
        }
        else{
            dataARR.push(json['temp']['last']);
            knobfunction(json['temp']['last'].temp)
            
            $('.lastbpm').text(json['bpm']['last'].bpm)
            $('.lastbpm_date').text(time_ago(new Date(json['bpm']['last'].created_at)))
        }
        $('.lastbpm').text(json['bpm']['last'].bpm)
        $('.lastbpm_date').text(time_ago(new Date(json['bpm']['last'].created_at)))
    }

    }
}).done(function(results) {
        console.log("done : " + dataARR);
});
} , 3000); 
    
    
    

    function knobfunction(value1){
        $('.dial')
        .val(value1)
        .trigger('change');
    }
     

    $(function() {
        $('[data-plugin="knob"]').knob({
            'change' : function (v) { console.log(v); }
        });
    });
    </script>
@endsection
