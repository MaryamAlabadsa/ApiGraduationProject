@extends('control_panel.master')
@section('content')
    <div class="row">
        <div class="col-md-12">


            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <div class="d-sm-flex justify-content-between align-items-start">
                                <div>
                                    <h4 class="card-title card-title-dash">Pending Requests</h4>
                                    <p class="card-subtitle card-subtitle-dash">You have 50+ new requests</p>
                                </div>

                            </div>
                            <div class="table-responsive  mt-1">
                                <table class="table select-table">
                                    <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Title</th>
                                        <th>is donation</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--                                    @if(is_array($post) || is_object($post))--}}
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>
                                                <div class="d-flex ">
                                                    <img src="{{$post->first_user_image_link}}">
                                                    <div>
                                                        <h6><a href="/user/{{$post->first_user}}">{{$post->post_first_user}}</a></h6>
                                                        <p>{{$post->post_first_user_email}}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6>{{$post->title}}</h6>
                                                <p>{{$post->description}}</p>
                                            </td>
                                            <td>
                                                @if($post->is_donation)
                                                    {
                                                    <div class="badge badge-opacity-info">donation</div>
                                                    }@else{
                                                <div class="badge badge-opacity-dark">request</div>
                                                }
                                                @endif
                                            </td>
                                            <td>
                                                @if( $post->second_user === null)
                                                    <div class="badge badge-opacity-danger">In progress</div>
                                                    {{--                                                <div class="tooltip-static-demo">--}}
                                                    {{--                                                    <div class="tooltip bs-tooltip-bottom bs-tooltip-bottom-demo tooltip-success" data-bs-toggle="tooltip" data-bs-placement="bottom" title="success">--}}
                                                    {{--                                                        <div class="arrow"></div>--}}
                                                    {{--                                                        <div class="tooltip-inner">--}}
                                                    {{--                                                            <div class="d-flex ">--}}
                                                    {{--                                                                <img src="{{$post->second_user_image_link}}" >--}}
                                                    {{--                                                                <img src="{{asset('control_panel_style/images/faces/face1.jpg')}}">--}}
                                                    {{--                                                                <img src="{{asset('man3.png')}}">--}}
                                                    {{--                                                                <div>--}}
                                                    {{--                                                                    <h6>{{$post-> post_second_user}}</h6>--}}
                                                    {{--                                                                    <p>{{$post-> post_second_user_email}}</p>--}}
                                                    {{--                                                                </div>--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}
                                                    {{--                                                </div>--}}
                                                @else
                                                    <div class="badge badge-opacity-success">
                                                        <a href="/user/{{$post->second_user}}" >completed
                                                        </a>
                                                        </div>

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{--                                    @endif--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
