@extends('control_panel.master')
@section('content')
    <div class="row">
        <div class="row flex-grow">
            <div class="col-12 grid-margin stretch-card">
                <div class="card card-rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h4 class="card-title card-title-dash">Top Performer</h4>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    @foreach($posts as $post)
                                    <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                        <div class="d-flex">
                                            <img class="img-sm rounded-10" src="{{$posts-> second_user_image_link}}" alt="profile">
                                            <div class="wrapper ms-3">
                                                <p class="ms-1 mb-1 fw-bold">Brandon Washington</p>
                                                <small class="text-muted mb-0">162543</small>
                                            </div>
                                        </div>
                                        <div class="text-muted text-small">
                                            1h ago
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
