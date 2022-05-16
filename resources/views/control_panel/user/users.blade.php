 @extends('control_panel.master')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="table-sorter-wrapper col-lg-12 table-responsive">
                                <table id="sortable-table-1" class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="sortStyle">user image<i class="ti-angle-down"></i></th>
                                        <th class="sortStyle">user Name<i class="ti-angle-down"></i></th>
                                        <th class="sortStyle">User Email<i class="ti-angle-down"></i></th>
                                        <th class="sortStyle">phone Number<i class="ti-angle-down"></i></th>
                                        <th class="sortStyle">address<i class="ti-angle-down"></i></th>
                                        <th class="sortStyle">Longitude&Latitude<i class="ti-angle-down"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>
                                            <div class="d-flex ">
{{--                                                <img src="{{$post->first_user_image_link}}" >--}}

                                                <img src="{{$user->image_link}}" >

                                            </div>
                                        </td>

                                        <td><a href="/user/{{$user->id}}">{{$user->name}}</a></td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone_number}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>{{$user->Longitude}} {{$user->Latitude}}</td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('control_panel_style/js/js-grid.js')}}'"></script>
    <script src="{{asset('control_panel_style/js/db.js')}}'"></script>
@endsection
