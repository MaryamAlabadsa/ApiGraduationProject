<div class="row ">
    @foreach($posts->post_media as $image)

        <div class="col-xl-3 col-md-3 mb-xl-0 mb-4">

            <a href="{{$image}}" class="image-tile w-100"><img src="{{$image}}" class="w-70"
                                                               alt="image small"></a>

        </div>
    @endforeach

</div>
