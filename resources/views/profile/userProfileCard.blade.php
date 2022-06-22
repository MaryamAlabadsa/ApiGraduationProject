<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:weight@100;200;300;400;500;600;700;800&display=swap");


    body{
        background-color: #ae9cc9;
        font-family: "Poppins", sans-serif;
        font-weight: 300;
    }

    .container{
        height: 100vh;
    }

    .card{

        width: 380px;
        border: none;
        border-radius: 15px;
        padding: 8px;
        background-color: #fff;
        position: relative;
        height: 370px;
    }

    .upper{

        height: 100px;

    }

    .upper img{

        width: 100%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;

    }

    .user{
        position: relative;
    }

    .profile img{


        height: 80px;
        width: 80px;
        margin-top:2px;


    }

    .profile{

        position: absolute;
        top:-50px;
        left: 38%;
        height: 90px;
        width: 90px;
        border:3px solid #fff;

        border-radius: 50%;

    }

    .follow{

        border-radius: 15px;
        padding-left: 20px;
        padding-right: 20px;
        height: 35px;
    }

    .stats span{

        font-size: 29px;
    }

</style>
{{--<div class="container d-flex justify-content-center align-items-center">--}}

    <div class="card justify-content-center align-items-center">

        <div class="upper">

            <img src="https://i.imgur.com/Qtrsrk5.jpg" class="img-fluid">

        </div>

        <div class="user text-center">

            <div class="profile">

                <img src="{{$user->image_link}}" class="rounded-circle" width="80">

            </div>

        </div>


        <div class="mt-5 text-center">

            <h4 class="mb-0">{{$user->name}}</h4>
            <span class="text-muted d-block mb-2">{{$user->phone_number}}</span>

            <button class="btn btn-primary btn-sm follow" value="btn-show-details">more Details</button>


            <div class="d-flex justify-content-between align-items-center mt-4 px-4">

                <div class="stats">
                    <h6 class="mb-0">Donation posts</h6>
                    <span>{{$num_donation_posts}}</span>

                </div>


                <div class="stats">
                    <h6 class="mb-0">requests posts</h6>
                    <span>{{$num_request_posts}}</span>

                </div>

            </div>

        </div>

    </div>

{{--</div>--}}

