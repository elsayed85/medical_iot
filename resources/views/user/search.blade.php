@extends('layouts/user')
@section('title')
Search for {{$name}}
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
                    <h4 class="page-title">Search Result</h4>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Library</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <div class="m-r-10">
                            <div class="lastmonth"></div>
                        </div>
                        <div class=""><small>Your LAST Bpm</small>
                        <h4 class="text-info m-b-0 font-medium">
                            @if(count(Auth::user()->bpms) > 0)
                            {{Auth::user()->bpms->first()['bpm'] ? Auth::user()->bpms->last()['bpm'] . " since " . Auth::user()->bpms->last()['created_at']->diffForHumans()  : "no data" }}
                            @endif
                        </h4></div>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <h4 class="card-title">Search Result For "{{$name}}"</h4>
                            <h6 class="card-subtitle">About {{count($result)}} result</h6>
                            <ul class="search-listing list-style-none">
                                @foreach ($result as $user)
                                <li class="border-bottom" style="margin: 3px 0;padding:10px 0">
                                    <h4 class="m-b-0"><a href="{{route('user_profile2' , $user->id)}}" class="text-cyan font-medium p-0">
                                        {{$user->name}}</a></h4>
                                <a href="{{route('user_profile2' , $user->id)}}" class="search-links p-0 text-success">
                                    {{route('user_profile2' , $user->id)}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <nav aria-label="Page navigation example" class="m-t-40">
                                    {{ $result->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
@endsection