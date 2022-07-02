<figure class="snip1559">
    <div class="profile-image"><img src="{{$user->image_link}}" alt="profile-sample2"/></div>
    <figcaption>
        <h3>{{$user->name}}</h3>
        <h5>Founder</h5>
        <h6> {{$user->posts}} Posts </h6>
        <h6> {{$user->requests}} Requests </h6>
        <button type="button"class="btn bg-gradient-warning w-50 mb-0 toast-btn"
        ><a href="/profile/{{$user->id}}" > More Details</a> </button>';
    </figcaption>
</figure>
