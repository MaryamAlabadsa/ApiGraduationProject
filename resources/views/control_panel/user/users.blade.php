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
                                        <th class="sortStyle">user Name<i class="ti-angle-down"></i></th>
                                        <th class="sortStyle">User Email<i class="ti-angle-down"></i></th>
                                        <th class="sortStyle">Product<i class="ti-angle-down"></i></th>
                                        <th class="sortStyle">Amount<i class="ti-angle-down"></i></th>
                                        <th class="sortStyle">Deadline<i class="ti-angle-down"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex ">
                                                <img src="{{$post->first_user_image_link}}" >
                                            </div>
                                        </td>
                                        <td>1</td>
                                        <td>Herman Beck</td>
                                        <td>John</td>
                                        <td>Photoshop</td>
                                        <td>$456.00</td>
                                        <td>12 May 2017</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Herman Beck</td>
                                        <td>Conway</td>
                                        <td>Flash</td>
                                        <td>$965.00</td>
                                        <td>13 May 2017</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>John Richards</td>
                                        <td>Alex</td>
                                        <td>Premeire</td>
                                        <td>$255.00</td>
                                        <td>14 May 2017</td>
                                    </tr>

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
