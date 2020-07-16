@extends('layouts/user')
@section('title')
Family Members
@endsection

@section('css')
<link href="/dist/css/style.min.css" rel="stylesheet">
<link href="/assets/libs/magnific-popup/dist/magnific-popup.css" rel="stylesheet">
@endsection

@section('main')
<div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-5 align-self-center">
                    <h4 class="page-title">Family</h4>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Family</li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <div class="m-r-10">
                            <div class="lastmonth"></div>
                        </div>
                        <div class="">@if(count(Auth::user()->bpms) > 0)
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
            <div class="container-fluid">
                <div class="row el-element-overlay">
                    @foreach ($family as $member)
                    <div class="col-lg-3 col-md-6">
                            <div class="card">
                                <div class="el-card-item">
                                    <div class="el-card-avatar el-overlay-1"> <img src="{{$member->user->avatar != null ? $member->user->avatar : "https://ui-avatars.com/api/?size=500&name=" . $member->user->name}}" alt="user" />
                                        <div class="el-overlay">
                                            <ul class="list-style-none el-info">
                                                <li class="el-item"><a class="btn default btn-outline image-popup-vertical-fit el-link" href="{{$member->user->avatar != null ? $member->user->avatar : "https://ui-avatars.com/api/?size=500&name=" . $member->user->name}}"><i class="icon-magnifier"></i></a></li>
                                                <li class="el-item"><a class="btn default btn-outline el-link" href="{{route('user_profile2' , $member->user->id)}}"><i class="icon-link"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="el-card-content">
                                        <h4 class="m-b-0">{{$member->user->name}}</h4> <span class="text-muted">{{$member->type}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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
</div>
@endsection
@section('js')
<script src="/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="/assets/libs/magnific-popup/meg.init.js"></script>
@endsection