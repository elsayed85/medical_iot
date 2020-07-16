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
                                <a href="{{route('doctor.show' , $doctor->id)}}"><button type="button" class="btn waves-effect waves-light btn-rounded btn-outline-primary"><i class="fas fa-user-md"></i> Doctor Profile</button></a>
                                <form style="display: inline" action="{{route('doctor.destroy' , $doctor->id)}}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn waves-effect waves-light btn-rounded btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                                <a href="{{route('doctor.create')}}"><button type="button" class="btn waves-effect waves-light btn-rounded btn-outline-primary"><i class="fas fa-user-plus"></i> Add new doctor</button></a>

                            </div>
                        </div>
                        <div class="">                      @if(count(Auth::user()->bpms) > 0)
                        <small>Your LAST Bpm</small>
                        <h4 class="text-info m-b-0 font-medium">
                            {{Auth::user()->bpms->first()['bpm'] ? Auth::user()->bpms->last()['bpm'] . " since " . Auth::user()->bpms->last()['created_at']->diffForHumans()  : "no data" }}
                        
                        </h4>
                        @else
                        <h4 style="color:red">No Data</h4>
                        @endif</div>
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
                <div class="col-sm-12 col-lg-12">
                    <div class="card">
                    <form method="POST" action="{{route("doctor.update" , $doctor->id)}}">
                            @csrf
                            @method('put')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <label for="inputEmail3" class="control-label col-form-label">Doctor Name</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"><i class="far fa-user"></i></span>
                                            </div>
                                        <input type="text" value="{{$doctor->name}}" name="name" class="form-control" placeholder="Doctor Name here" aria-label="Username" aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="control-label col-form-label">Phone number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon11"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="number" value="{{$doctor->phone}}" name="phone" class="form-control" placeholder="Phone number here" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="control-label col-form-label">facebook link</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon13"><i class="fab fa-facebook-f"></i></span>
                                                </div>
                                                <input type="url" value="{{$doctor->facebook}}" name="facebook" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="control-label col-form-label">Address</label>
                                            <textarea name="address" class="form-control" id="exampleTextarea10" rows="3" placeholder="Address Here">{{$doctor->address}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="control-label col-form-label">Info</label>
                                            <textarea name="info"  class="form-control" id="exampleTextarea10" rows="3" placeholder="Info Here">{{$doctor->info}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="action-form">
                                    <div class="form-group m-b-0 text-left">
                                    <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>

                                    <button href="{{route("doctor.index")}}" class="btn btn-dark waves-effect waves-light">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
<script src="/assets/libs/dropzone/dist/min/dropzone.min.js"></script>
@endsection
