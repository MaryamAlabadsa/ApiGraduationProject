<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href=".{{asset('img/favicon.png')}}">
@yield('title')

<!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700"/>
    <!-- Nucleo Icons -->
    <link href="{{asset('css/nucleo-icons.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/nucleo-svg.css')}}" rel="stylesheet"/>
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{asset('css/material-dashboard.css?v=3.0.2')}}" rel="stylesheet"/>
    @yield('style')
    <style>
        .swal2-backdrop-show {
            z-index: 99999999999999999999 !important;
        }

        .swal2-html-container {
            overflow: hidden !important;
        }
    </style>

</head>

<body class="g-sidenav-show  bg-gray-200">
{{--@include('users.aside')--}}
@yield('aside')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    @include('layouts.navBar')
        <div class="container-fluid py-4">
            @yield('content')
            @include('layouts/footer')
        </div>
</main>
<div class="modal fade" id="PostEditModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal_content">
        </div>
    </div>
</div>

@include('layouts/Settings')

<!--   Core JS Files   -->
<script src="{{ asset('js/core/popper.min.js')}}"></script>
<script src="{{ asset('js/core/bootstrap.min.js')}}"></script>
<script src="{{ asset('js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{ asset('js/plugins/smooth-scrollbar.min.js')}}"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('js/material-dashboard.js?v=3.0.2')}}"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.4.0/js/dataTables.autoFill.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.4.0/js/autoFill.bootstrap4.min.js"></script>
<script src="{{asset('sweetalert.js')}}"></script>
<script class="swalMixin">
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: function (toast) {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@yield('script')

</body>

</html>
