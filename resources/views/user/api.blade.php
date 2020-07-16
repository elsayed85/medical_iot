@extends('layouts/user')
@section('title')
    Api
@endsection

@section('css')
<link href="/dist/css/style.min.css" rel="stylesheet">
<style>
    #sidebarnav li:first-child {
    display: none;
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
                        <div class="card text-white bg-success">
                            <div class="card-header">
                                API Routes
                            </div>
                            <div class="card-body">
                                <p>use this Base Url for each request then the Request url from the table</p>
                                <h5>Base url : {{route('/')}}</h5>
                                <p>for each request that need authorization , Add Header <code>Authorization</code> as a key then add the next <code>Token</code> as a value</p>
                                <h5>Token</h5>
                                <pre class="language-html scrollable"><code class="text-white">Bearer {{Auth::user()->api_token}}</code></pre>
                                <p>be careful when copy [copy all the text]</p>
                                
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table table-striped table-dark m-b-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Method</th>
                                            <th scope="col">Request url</th>
                                            <th scope="col">use for what ?</th>
                                            <th scope="col">Need authorization ?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>GET</td>
                                            <td>/api/auth/signup</td>
                                            <td>Register new user</td>
                                            <td>NO</td>
                                        </tr>
                                        <tr>
                                            <td>POST</td>
                                            <td>/api/auth/login</td>
                                            <td>Login</td>
                                            <td>NO</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>/api/auth/user</td>
                                            <td>Get all data of user</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>POST</td>
                                            <td>/api/auth/update</td>
                                            <td>Updata all data of user</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>POST</td>
                                            <td>/api/auth/update</td>
                                            <td>Updata all data of user</td>
                                            <td>YES</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <table class="table table-striped table-dark m-b-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Method</th>
                                            <th scope="col">Request url</th>
                                            <th scope="col">use for what ?</th>
                                            <th scope="col">Need authorization ?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>POST</td>
                                            <td>/api/user/bpm/{Number}</td>
                                            <td>Send Bpm</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>POST</td>
                                            <td>/api/user/temp/{Number}</td>
                                            <td>Send Temp</td>
                                            <td>Yes</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <table class="table table-striped table-dark m-b-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Method</th>
                                            <th scope="col">Request url</th>
                                            <th scope="col">use for what ?</th>
                                            <th scope="col">Need authorization ?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/bpms</td>
                                            <td>Get all Bpms without classification</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/bpm/last</td>
                                            <td>Get last Bpm inserted in DB</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/bpm/last/minute</td>
                                            <td>Get last Bpms in last minute inserted in DB</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/bpm/last/hour</td>
                                            <td>Get last Bpms in last hour inserted in DB</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/bpm/last/day</td>
                                            <td>Get last Bpms in last day inserted in DB</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/bpm/last/all</td>
                                            <td>Get all Bpms with <br>[second , minute , hour , day ,info[ day => [min , max] , hour => [min , max] , minute => [min , max] ]<br>  classification</td>
                                            <td>YES</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <table class="table table-striped table-dark m-b-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Method</th>
                                            <th scope="col">Request url</th>
                                            <th scope="col">use for what ?</th>
                                            <th scope="col">Need authorization ?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/temps</td>
                                            <td>Get all Temps without classification</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/temp/last</td>
                                            <td>Get last Temp inserted in DB</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/temp/last/minute</td>
                                            <td>Get last Temps in last minute inserted in DB</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/temp/last/hour</td>
                                            <td>Get last Temps in last hour inserted in DB</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/temp/last/day</td>
                                            <td>Get last Temps in last day inserted in DB</td>
                                            <td>YES</td>
                                        </tr>
                                        <tr>
                                            <td>GET</td>
                                            <td>api/user/temp/last/all</td>
                                            <td>Get all Temps with [second , minute , hour , day , min , max] classification</td>
                                            <td>YES</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                            </div>
                        </div>
<!-- Card -->
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
    <script>
    $(function() {
        "use strict";
        $("#main-wrapper").AdminSettings({
            Theme: false, // this can be true or false ( true means dark and false means light ),
            Layout: 'vertical',
            LogoBg: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6 
            NavbarBg: 'skin6', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
            SidebarType: 'overlay', // You can change it full / mini-sidebar / iconbar / overlay
            SidebarColor: 'skin1', // You can change the Value to be skin1/skin2/skin3/skin4/skin5/skin6
            SidebarPosition: true, // it can be true / false ( true means Fixed and false means absolute )
            HeaderPosition: true, // it can be true / false ( true means Fixed and false means absolute )
            BoxedLayout: false, // it can be true / false ( true means Boxed and false means Fluid ) 
        });
    });
    </script>

@endsection
