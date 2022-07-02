@extends('control_panel.master')

@section('title')
    <title>Revenues - dentist assistant</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('/control_panel/datatable_buttons_files/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/control_panel/ltr/app-assets/vendors/css/pickadate/pickadate.css') }}">
@endsection

@section('content')

    <div class="main-panel">
        <!-- BEGIN : Main Content-->
        <div class="main-content">
            <div class="content-overlay"></div>
            <div class="content-wrapper">
                <section class="users-list-wrapper">

                    <div class="row">
                        <div class="col-12">
                            <div class="content-header">All Revenues</div>
                        </div>
                    </div>
                    <!-- Table starts -->
                    <div class="users-list-table">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <table class="table table-striped zero-configuration" id="main_statistics">
                                        </table>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>From Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                              <span class="ft-calendar font-medium-2"></span>
                                                            </span>
                                                        </div>
                                                        <input type='text' onchange="filterRevenuesByDate()" name="start_date" class="form-control pickadate-short-string" placeholder="Start Date">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>To Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                              <span class="ft-calendar font-medium-2"></span>
                                                            </span>
                                                        </div>
                                                        <input type='text' onchange="filterRevenuesByDate()" name="end_date" class="form-control pickadate-short-string" placeholder="End Date">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<h4 class="card-title">All Revenues</h4>--}}
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- Datatable starts -->
                                            <div class="table-responsive">
                                                <table id="dataTable" class="table table-striped zero-configuration">
                                                    <thead>
                                                    <tr>
                                                        <th>Treatment</th>
                                                        <th>Patient</th>
                                                        <th>Revenues</th>
                                                        <th>Un Paid</th>
                                                        <th>Tools</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Datatable ends -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Table ends -->
                </section>

            </div>
        </div>
   <button class="btn btn-primary scroll-top" type="button"><i class="ft-arrow-up"></i></button>

    </div>

@endsection

@section('script')

    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{ asset('control_panel/ltr/app-assets/vendors/js/pickadate/picker.js') }}"></script>
    <script src="{{ asset('control_panel/ltr/app-assets/vendors/js/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('control_panel/ltr/app-assets/vendors/js/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('control_panel/ltr/app-assets/vendors/js/pickadate/legacy.js') }}"></script>
    <!-- END PAGE VENDOR JS-->
    <script src="{{ asset('control_panel/ltr/app-assets/js/form-datetimepicker.min.js') }}"></script>
  <script>
        var table = '';
        $(document).ready(function() {
            table = $('#dataTable').DataTable( {
                "processing": true,
                "serverSide": true,
                autoWidth: false, // might need this
                // dom: 'Bfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ],
                "pagingType": "full_numbers",
                "drawCallback": function( settings ) {
                    $("[rel='tooltip']").tooltip();
                    $('.cut-text').tooltip();
                    $('#main_statistics').empty().html(table.data().context[0].json['statistics']);
                    // $('.buttons-copy').removeClass('dt-button');
                    // $('.buttons-copy').addClass('btn');
                    // $('.buttons-copy').addClass('btn-danger');
                    // $('.buttons-csv').removeClass('dt-button');
                    // $('.buttons-csv').addClass('btn');
                    // $('.buttons-csv').addClass('btn-info');
                    // $('.buttons-excel').removeClass('dt-button');
                    // $('.buttons-excel').addClass('btn');
                    // $('.buttons-excel').addClass('btn-success');
                    // $('.buttons-pdf').removeClass('dt-button');
                    // $('.buttons-pdf').addClass('btn');
                    // $('.buttons-pdf').addClass('btn-primary');
                    // $('.buttons-print').removeClass('dt-button');
                    // $('.buttons-print').addClass('btn');
                    // $('.buttons-print').addClass('btn-warning');
                    // alert( 'DataTables has redrawn the table' );
                },
                "ajax": "{{ route('revenues.getData') }}",
                "columnDefs": [
                    { "sortable": false, "targets": [2,3,4] },
                ],
                "aoColumns": [
                    // { "mData": "id" },
                    { "mData": "treatment_title" },
                    { "mData": "patient_name" },
                    { "mData": "total_revenues" },
                    { "mData": "total_un_paid_amount" },
                    { "mData": "tools" }
                ]
            } );
        });
        function filterRevenuesByDate(){
            var start_date = $('input[name="start_date"]').val();
            var end_date = $('input[name="end_date"]').val();
            table.ajax.url( '{{ route('revenues.getData') }}'+'?start_date='+start_date+'&end_date='+end_date ).load();
        }
        function getAllUnPaidRevenues(){
            $.get('getAllUnPaidRevenues',function(data){
                $('.modal-content-xl').empty().html(data)
            })
        }
        (function(){
            $('#revenues_li').addClass('active');
        }());

    </script>
@endsection
