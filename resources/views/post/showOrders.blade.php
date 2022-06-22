
<div class="row">
    @foreach($orders as $order)

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="d-flex flex-column justify-content-center">
                    <h6 class="text-sm font-weight-normal mb-1">
                        <img src="{{$order->user_image_link}}" class="avatar avatar-xl  me-3 " alt="">
                        <span class="font-weight-bold">{{$order->user_name}}</span>
                    </h6>
                    <p class="text-2xl text-primary mb-0">
                        {{$order->massage}}
                    </p>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">
                        <i class="fa fa-clock me-1"></i>
                    </span>{{$order->created_at->diffForHumans(now())}}</p>
                @if($order->user_id==$post->second_user)
                    @if($post->is_donation)
                        <span class="btn-simple">beneficiary</span>
                    @else
                        <span class="selected">Donor</span>
                    @endif
                @endif
            </div>
        </div>
    </div>
    @endforeach

</div>
