@extends('control_panal.master')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                <tr>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        email
                                    </th>
                                    <th>
                                        address
                                    </th>
                                    <th class="text-center">
                                        img_url
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>
                                        Dakota Rice
                                    </td>
                                    <td>
                                        Niger
                                    </td>
                                    <td>
                                        Oud-Turnhout
                                    </td>
                                    <td class="text-center">
                                        $36,738
                                    </td>
                                    <td class="jsgrid-cell jsgrid-control-filed jsgrid-align-center " style="width: 50px;">
                                        <input class="jsgrid-button jsgrid-edit-button" type="button" title="edit">
                                        <input class="jsgrid-button jsgrid-delete-button" type="button" title="delete">
                                    </td>

                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="{{asset('control_panel_style/js/js-grid.js')}}'"></script>
    <script src="{{asset('control_panel_style/js/db.js')}}'"></script>
@endsection
