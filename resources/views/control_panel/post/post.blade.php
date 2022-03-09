@extends('control_panel.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <section class="widget">

            <div class="body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="hidden-xs">#</th>
                        <th>Picture</th>
                        <th>user name</th>
                        <th class="hidden-xs">Info</th>
                        <th class="hidden-xs">Date</th>
                        <th class="hidden-xs">STATUS</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($posts as $post) :?>

                    <tr>
                        <td class="hidden-xs">1</td>
                        <td>
                            <img class="img-rounded" src="img/jpeg/1.jpg" alt="" height="50">
                        </td>
                        <td>
                            {{$post-> post_first_user}}
                        </td>
                        <td>
                            {{$post-> title}}
                        </td>
                        <td class="hidden-xs">

                            {{$post-> is_donation}}

                        </td>
                        <td class="hidden-xs text-muted">
                            post_category
                        </td>
                        <td class="hidden-xs text-muted">
                            45.6 KB
                        </td>
                        <td class="width-150">
                            <div class="progress progress-sm mt-xs js-progress-animate">
                                <div class="progress-bar progress-bar-success" data-width="29%" style="width: 0;"></div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>


                    </tbody>

                </table>
                <div class="clearfix">
                    <div class="pull-right">
                        <button class="btn btn-default btn-sm mr-md">
                            Send to ...
                        </button>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-inverse dropdown-toggle" data-toggle="dropdown">
                                &nbsp; Clear &nbsp;
                                <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="#">Clear</a></li>
                                <li><a href="#">Move ...</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </div>
                    </div>
                    <p>Basic table with styled content</p>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
