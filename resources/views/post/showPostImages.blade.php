<!-- Carousel wrapper -->
<div id="carouselBasicExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">

    <!-- Inner -->
    <div class="carousel-inner">
        <!-- Single item -->
        @foreach($posts->post_media as $post)
        <div class="carousel-item active">
            <img src="{{$post}}" class="d-block w-100"
                 alt="Sunset Over the City" />
        </div>
    @endforeach

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample"
            data-mdb-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample"
            data-mdb-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- Carousel wrapper -->
</div>
