@extends('layouts.master')

@section('title')
    <title>Posts - final project</title>
@endsection

@section('style')
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/autofill/2.4.0/css/autoFill.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
            integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js"
            integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy"
            crossorigin="anonymous"></script>
@endsection

@section('aside')
    @include('post.aside')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <div class="container" style="display: inline-flex ; justify-content: space-between">
                            <h6 class="text-white text-capitalize ps-3">Posts table</h6>
                        </div>
                    </div>
                </div>
                <!-- Filter starts -->
                <div class="users-list-filter px-2">
                    <form>
                        <div class="row border rounded py-2 mb-2 mx-n2">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="users-list-verified">category</label>
                                <fieldset class="form-group">
                                    <select onchange="filterByCategory()" id="posts-list-category"
                                            class="form-control filter-category">
                                        <option value="">Any</option>
                                        <?php
                                        $categories = \App\Models\Category::all();
                                        ?>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="users-list-role">Status</label>
                                <fieldset class="form-group">
                                    <select onchange="filterByCategory()" id="posts-list-status"
                                            class="form-control filter-category">
                                        <option value="">Any</option>
                                        <option value="1">closed</option>
                                        <option value="0">Pending</option>
                                    </select>
                                </fieldset>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="users-list-status">Donation</label>
                                <fieldset class="form-group">
                                    <select onchange="filterByCategory()" id="posts-list-donation"
                                            class="form-control filter-category">
                                        <option value="">Any</option>
                                        <option value="1">donation</option>
                                        <option value="0">beneficiary</option>
                                    </select>
                                </fieldset>
                            </div>

                            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                                <button type="reset" onclick="filterClear()" class="btn btn-primary btn-block users-list-clear glow mb-0">
                                    Clear
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Filter ends -->
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-3">
                        <table id="dataTable" class="table align-items-center justify-content-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    user
                                </th>

                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    postTitle
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    categoryName
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    RequestNumber
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    postedAt
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    isDonation
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    isAvailable
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">
                                    actions
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('control_panel_style/ajax/post.js') }}"></script>

    <script type="text/javascript">
        var table = '';
        $(document).ready(function () {
            table = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('posts.getData') }}",
                "pagingType": "full_numbers",
                "drawCallback": function (settings) {
                    $("[rel='tooltip']").tooltip();
                },
                "columnDefs": [
                    {"sortable": true, "targets": [0, 4]}
                ],
                "aoColumns": [
                    {"mData": "user"},
                    {"mData": "title"},
                    {"mData": "categoryName"},
                    {"mData": "RequestNumber"},
                    {"mData": "postedAt"},
                    {"mData": "isDonation"},
                    {"mData": "isAvailable"},
                    {"mData": "tools"}
                ],
                responsive: true
            });
        });

        function filterByCategory() {
            var category = $('select[id="posts-list-category"]').val();
            var status = $('select[id="posts-list-status"]').val();
            var donation = $('select[id="posts-list-donation"]').val();
            table.ajax.url('/getPostsData?category=' + category + '&status=' + status + '&donation=' + donation).load();
        }
        function filterClear() {
            table.ajax.url('/getPostsData').load();
        }

    </script>

@endsection


