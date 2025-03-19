@extends('backend.patient.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{asset('backend')}}/plugins/morris/morris.css">
    <style>
        <style>
            /* Add some margin and padding to ensure the chart isn't too close to other elements */
        #morrisArea {
            height: 400px;
            margin-bottom: 50px;
        }

        /* Style for the appointments summary section */
        .appointments-summary {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .appointments-summary h4 {
            margin-bottom: 10px;
        }

        .appointments-summary p {
            font-size: 16px;
        }

        /* Style for the labels on the x-axis */
        .morris-hover .morris-hover-row-label {
            font-size: 14px;  /* Slightly larger font for clarity */
        }

        .morris-hover .morris-hover-point {
            font-size: 12px;  /* Data label font size */
        }
    </style>

    </style>
@endpush
@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Welcome {{Auth::user()->first_name}} {{Auth::user()->last_name}}</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
										<span class="dash-widget-icon text-primary border-primary">
											<i class="fe fe-users"></i>
										</span>
                        <div class="dash-count">
                            <h3>{{$appointments->total_count}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Appointments</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary w-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
										<span class="dash-widget-icon text-success">
											<i class="fe fe-credit-card"></i>
										</span>
                        <div class="dash-count">
                            <h3>{{$appointments->booked_count}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Booked Appointments</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success w-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
										<span class="dash-widget-icon text-danger border-danger">
											<i class="fe fe-money"></i>
										</span>
                        <div class="dash-count">
                            <h3>{{$appointments->approved_count}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Accepted Appointment</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger w-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
										<span class="dash-widget-icon text-warning border-warning">
											<i class="fe fe-folder"></i>
										</span>
                        <div class="dash-count">
                            <h3>{{$appointments->pending_count}}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">

                        <h6 class="text-muted">Pending Appointmetns</h6>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning w-50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <!-- Sales Chart -->
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Appoitnments</h4>
                </div>
                <div class="card-body">
                    <!-- Appointments Summary Section (Optional, to display data above the graph) -->
{{--                    <div class="appointments-summary">--}}
{{--                        <h4>Appointments Summary</h4>--}}
{{--                        <p><strong>Appointments:</strong> {{ $appointments->total_count }}</p>--}}
{{--                        <p><strong>Booked Appointments:</strong> {{ $appointments->booked_count }}</p>--}}
{{--                        <p><strong>Pending Appointments:</strong> {{ $appointments->pending_count }}</p>--}}
{{--                        <p><strong>Approved Appointments:</strong> {{ $appointments->approved_count }}</p>--}}
{{--                    </div>--}}

                    <!-- Morris Area Chart -->
                    <div id="morrisArea" style="height: 400px; margin-bottom: 50px;"></div>
                </div>
            </div>
            <!-- /Sales Chart -->

        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('backend')}}/plugins/raphael/raphael.min.js"></script>
    <script src="{{asset('backend')}}/plugins/morris/morris.min.js"></script>
{{--    <script src="{{asset('backend')}}/js/chart.morris.js"></script>--}}

    <script>
        $(function(){
            // Get the appointments data passed from the controller
            var appointmentsData = @json($appointments);

            console.log(appointmentsData);  // Check the appointments data in the browser console

            // Morris Area Chart (using the appointments data)
            window.mA = Morris.Area({
                element: 'morrisArea',
                data: [
                    { y: 'Booked', a: appointmentsData.booked_count },
                    { y: 'Pending', a: appointmentsData.pending_count },
                    { y: 'Approved', a: appointmentsData.approved_count },
                ],
                xkey: 'y', // Status names (Booked, Pending, Approved)
                ykeys: ['a'], // Values for the appointment counts
                labels: ['Appointments'], // Label for the value on the chart
                lineColors: ['#1b5a90'],  // Color for the area chart line
                lineWidth: 2,
                fillOpacity: 0.5,
                gridTextSize: 10,
                hideHover: 'auto',
                resize: true,
                redraw: true,
                pointSize: 5,
                // Show the value of each point on the chart
                parseTime: false, // Optional: Make sure the chart does not try to interpret data as time-based
                goalLineColors: ['#ff9d00'], // Color for goal line, if applicable
                hoverCallback: function (index, options, content, row) {
                    return content + ' <br> Status: ' + row.y + '<br> Count: ' + row.a;
                },
                // Adding data point labels on the chart
                pointFillColors: ['#fff'],
                gridTextColor: '#333',
                gridTextSize: 12
            });

            // Redraw chart when window is resized
            $(window).on("resize", function(){
                mA.redraw();
            });
        });
    </script>


@endpush
