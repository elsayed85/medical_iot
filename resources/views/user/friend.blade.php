@extends('layouts/user')
@section('title')
{{$user->name}} profile
@endsection

@section('css')
<link href="/dist/css/style.min.css" rel="stylesheet">
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
                        @if(Auth::user()->inFamily($user->id))
                        <div class=""><small>LAST Bpm</small>
                        <h4 class="text-info m-b-0 font-medium">
                            @if($user->bpms->first()['bpm'])
                            <span class='lastbpm'>{{$user->bpms->last()['bpm']}}</span> since 
                            <span class='lastbpm_date'>{{$user->bpms->last()['created_at']->diffForHumans()}}</span>
                            @else
                            no data
                            @endif  
                        </h4></div>
                        @endif
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
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <center class="m-t-30"> <img src="https://ui-avatars.com/api/?size=500&name={{$user->name}}" class="rounded-circle" width="150" />
                                <h4 class="card-title m-t-10">{{$user->name}}</h4>
                            <h6 class="card-subtitle">
                                {{$info['type']}} || {{$user->geneder}}
                            </h6>
                            @if ($user->id != Auth::user()->id)
                                <div class="row text-center justify-content-md-center">
                                    <div class="col-12">
                                        @if ($info['type'] == '')
                                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal" ><i class="ti-plus"></i>Add</button>
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="exampleModalLabel1">New message</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        </div>
                                                    <form action="{{route('adduser' , $user->id)}}" method="post">
                                                        <div class="modal-body">
                                                            @csrf
                                                            <input type="hidden" name="second" value="{{$user->id}}">
                                                            <div class="form-group m-b-30">
                                                            <label class="mr-sm-2" for="inlineFormCustomSelect">Add 
                                                                <b>{{$user->name}}</b> as your :</label>
                                                                    <select name="type" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                                                                        <option value="son">son</option>
                                                                        <option value="father">father</option>
                                                                        <option value="wife">wife</option>
                                                                    </select>
                                                                </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Add</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                        </div>                                       
                                        @else
                                        <form action="{{route('removeuser' , $user->id)}}" method="post">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" name="second" value="{{$user->id}}">
                                            <button class="btn btn-danger" type="submit"></i>remove</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            </center>
                        </div>
                        <div>
                            <hr> </div>
                        <div class="card-body"> 
                        @if (!is_null($user->facebook))
                            <small class="text-muted p-t-30 db"><i class="fab fa-facebook-f"></i>  facebook</small>
                            <h6><a href="{{$user->facebook}}">my profile on facebook </a></a></h6>
                        @endif
                        <small class="text-muted"><i class="fas fa-envelope"></i> Email address </small>
                        <h6>{{$user->email}}</h6>
                        @if(Auth::user()->inFamily($user->id))
                            @if (!is_null($user->phone))
                                <small class="text-muted p-t-30 db"><i class="fas fa-phone"></i> Phone</small>
                                <h6>{{$user->phone}}</h6>
                            @endif
                            @if (!is_null($user->age))
                                <small class="text-muted p-t-30 db"><i class=" fas fa-child"></i> age</small>
                                <h6>{{$user->age}}</h6>
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
                        @endif
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card">
                        <!-- Tabs -->
                        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
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
                                        @if (Auth::user()->inFamily($user->id) && !is_null($user->phone))
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
                                    <p class="m-t-30">
                                    @if(Auth::user()->inFamily($user->id))
                                        @if(count($user->doctors))
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title">Doctors</h4>
                                                <div class="table-responsive">
                                                        <table class="table">
                                                            <thead class="bg-inverse text-white">
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Phone</th>
                                                                    <th>Address</th>
                                                                    <th>Facebook</th>
                                                                    <th>info</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach ($user->doctors as $doc)
                                                                <tr>
                                                                    <td>{{$doc->name}}</td>
                                                                    <td><a href="tel:0{{$doc->phone}}">0{{$doc->phone}}</a></td>
                                                                    <td>{{$doc->address}}</td>
                                                                    <td><a href="{{$doc->facebook}}">Click Here</a></a></td>
                                                                    <td>{{$doc->info}}</td>
                                                                </tr>                                                                    
                                                            @endforeach

                                                            </tbody>
                                                        </table>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <h3 style="color:red">No Doctors</h3>
                                        @endif
                                    @endif
                                    @isset($data)
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                        @if(count($data['bpm']))
                                            <h2>Bpms : </h2>
                                            <input class="bpm" data-readOnly='true' data-plugin="knob" data-width="250" data-height="250" name="temp" data-angleOffset="90" data-linecap="round" data-fgColor="#7460ee" value="{{$data['bpm']}}" />
                                        @else
                                        <h3 style="color:red">No Data for Heart </h3>
                                        @endif
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            @if(count($data['temp']))
                                            <h2>Temps : </h2>
                                            <div class="card">
                                            <div class="card-body">
                                            <div class="text-center">
                                            <input class="temp" data-readOnly='true' data-plugin="knob" data-width="250" data-height="250" name="temp" data-angleOffset="90" data-linecap="round" data-fgColor="#7460ee" value="{{$data['temp']}}" />
                                            </div>
                                            </div>
                                            </div>
                                        @else
                                        <h3 style="color:red">No Data for temperature </h3>
                                        @endif
                                        </div>
                                    </div>
                                    <hr>
                                    @endisset
                                    </p>
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
@if(Auth::user()->inFamily($user->id))
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
    url: "http://hearts2020.com/api/user/{{$user->id}}/data",
    success: function(json) {
    if(!$.isEmptyObject(json)){
        if(dataARR.length > 0){
            if(
                (dataARR.length > 0 && dataARR[dataARR.length - 1].created_at != json['temp']['last'].created_at) 
                || 
                (dataARR.length > 0 && dataARR[dataARR.length - 1].created_at != json['bpm']['last'].created_at) 
            ){
                dataARR.push(json['temp']['last']);
                knobfunction('temp' , json['temp']['last'].temp)
                knobfunction('bpm' , json['bpm']['last'].bpm)
                 
            $('.lastbpm').text(json['bpm']['last'].bpm)
            $('.all').text(json['bpm'].count)
            $('.lastbpm_date').text(time_ago(new Date(json['bpm']['last'].created_at)))
            
            }
        }
        else{
            dataARR.push(json['temp']['last']);
            knobfunction('temp' ,json['temp']['last'].temp)
            knobfunction('bpm' ,json['bpm']['last'].bpm)
            
            $('.lastbpm').text(json['bpm']['last'].bpm)
            $('.all').text(json['bpm'].count)
            $('.lastbpm_date').text(time_ago(new Date(json['bpm']['last'].created_at)))
        }
        $('.lastbpm').text(json['bpm']['last'].bpm)
        $('.all').text(json['bpm'].count)
        $('.lastbpm_date').text(time_ago(new Date(json['bpm']['last'].created_at)))
    }

    }
}).done(function(results) {
        console.log(dataARR);
});
} , 3000); 
    
    
    

    function knobfunction(class_x , value){
        $('.' + class_x)
        .val(value)
        .trigger('change');
    }
     

    $(function() {
        $('[data-plugin="knob"]').knob({
            'change' : function (v) { console.log(v); }
        });
    });
    </script>
@endif
@endsection
