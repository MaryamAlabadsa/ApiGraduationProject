@extends('layouts.master')

@section('title')
    <title>Profile - final project</title>
@endsection

@section('style')
    <meta charset="utf-8">

    <link href="{{asset('css/vertical-layout-light/style.css')}}" rel="stylesheet"/>

    <!-- endinject -->

@endsection

@section('aside')
    @include('profile.asidePosts')
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Welcome {{\Illuminate\Support\Facades\Auth::user()->name}}</h3>
                    <h6 class="font-weight-normal mb-0">All systems are running smoothly! </h6>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="justify-content-end d-flex">
                        <div class=" flex-md-grow-1 flex-xl-grow-0">
                            <button class="btn btn-sm btn-light bg-white " type="button"
                                    id="dropdownMenuDate2" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="true">
                                 Today ( {{ now()->format('Y-m-d') }} )
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card tale-bg">
                <div class="card-people mt-auto">
                    <img src="https://www.bootstrapdash.com/demo/skydash/template/images/dashboard/people.svg"
                         alt="people">
                    <div class="weather-info">
                        <div class="d-flex">
                            <div>
                                <h2 class="mb-0 font-weight-normal"><i class="icon-sun me-2"></i>31<sup>C</sup></h2>
                            </div>
                            <div class="ms-2">
                                <h4 class="location font-weight-normal"> {{\Illuminate\Support\Facades\Auth::user()->address}}</h4>
                                <h6 class="font-weight-normal">Illinois</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Today’s Posts</p>
                            <?php
                            use Carbon\Carbon;
                            $todayPosts = \App\Models\Post::whereDate('created_at', Carbon::today())->get()->count();
                            //                            dd(\App\Models\Post::whereDate('created_at', Carbon::today())->get())
                            ?>
                            <p class="fs-30 mb-2">
                                {{$todayPosts}}
                            </p>
                            {{--                            <p>10.00% (30 days)</p>--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Today’s Users</p>
                            <?php
                            $todayUsers = \App\Models\User::whereDate('created_at', Carbon::today())->get()->count();
                            ?>
                            <p class="fs-30 mb-2">{{$todayUsers}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4 p-4 stretch-card transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Number of Pending Posts</p>
                            <?php
                            $posts = \App\Models\Post::whereNull("second_user")->get()->count()
                            ?>
                            <p class="fs-30 mb-2">{{$posts}}</p>
                            {{--                            <p>2.00% (30 days)</p>--}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 p-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Number of Users</p>
                            <?php
                            $users = \App\Models\User::all()->count();
                            ?>
                            <p class="fs-30 mb-2">{{$users}}</p>
                            {{--                            <p>0.22% (30 days)</p>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{--                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">--}}

                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Today’s Orders</p>
                            <?php
                            $todayOrders = \App\Models\Order::whereDate('created_at', Carbon::today())->get()->count();
                            ?>
                            <p class="fs-30 mb-2">
                                {{$todayOrders}}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
