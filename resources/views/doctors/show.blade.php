@extends('layouts/user')
@section('title')
{{$doctor->name}} profile
@endsection

@section('css')
<link href="/dist/css/style.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/assets/libs/dropzone/dist/min/dropzone.min.css">
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
                            <li class="breadcrumb-item active" aria-current="page"><b>{{$doctor->name}}</b> profile</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <div class="m-r-10">
                            <div class="lastmonth">
                                <a href="{{route('doctor.edit' , $doctor->id)}}"><button type="button" class="btn waves-effect waves-light btn-rounded btn-outline-primary"><i class="fas fa-edit"></i> Edit</button>
                                </a>
                                <form style="display: inline" action="{{route('doctor.destroy' , $doctor->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn waves-effect waves-light btn-rounded btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                            </div>
                        </div>
                        <div class="">
                        @if(count(Auth::user()->bpms) > 0)
                        <small>Your LAST Bpm</small>
                        <h4 class="text-info m-b-0 font-medium">
                            {{Auth::user()->bpms->first()['bpm'] ? Auth::user()->bpms->last()['bpm'] . " since " . Auth::user()->bpms->last()['created_at']->diffForHumans()  : "no data" }}
                        
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
                    <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <center class="m-t-30"> <img src={{"https://ui-avatars.com/api/?size=500&name=" . $doctor->name}} class="rounded-circle" width="150" />
                                    <h4 class="card-title m-t-10">{{$doctor->name}}</h4>
                                        <h6 class="card-subtitle">{{$doctor->phone}}</h6>
                                    </center>
                                </div>
                                <div>
                                    <hr> </div>
                                <div class="card-body">
                                    <small class="text-muted p-t-30 db">Phone</small>
                                    <h6>{{$doctor->phone}}</h6> 
                                    <small class="text-muted p-t-30 db">Address</small>
                                    <h6>{{$doctor->address}}</h6>
                                    @if(!is_null($doctor->info))
                                    <div class="map-box">
                                            <small class="text-muted p-t-30 db">Info</small>
                                            <h6>{{$doctor->info}}</h6>
                                    </div>
                                    @endif
                                    @if(!is_null($doctor->facebook))
                                    <small class="text-muted p-t-30 db">Social Profile</small>
                                    <br/><a href="{{$doctor->facebook}}" >
                                <button class="btn btn-circle btn-secondary"><i class="fab fa-facebook-f"></i></button></a>
                                    @endif
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
@endsection
