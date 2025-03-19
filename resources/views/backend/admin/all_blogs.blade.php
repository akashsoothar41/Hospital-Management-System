@extends('backend.admin.layouts.master')
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Blogs</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Blogs</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-md-12">

            <!-- Recent Orders -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                            <tr>
                                <th>Doctor Name</th>
                                <th>Speciality</th>
                                <th>Title</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($blogs as $blog)
                                <tr>
                                    <!-- Doctor Details -->
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="" class="avatar avatar-sm mr-2">
                                                <img class="avatar-img rounded-circle"
                                                     src="{{ asset('backend') }}/{{ $blog->doctor->profile->image ?? 'default-avatar.png' }}"
                                                     alt="Doctor Image">
                                            </a>
                                            <a href="">{{ $blog->doctor->first_name ?? 'N/A' }} {{ $blog->doctor->last_name ?? 'N/A' }}</a>
                                        </h2>
                                    </td>

                                    <td>{{ $blog->doctor->speciality->name ?? 'No Speciality' }}</td>
                                    <td>{{ $blog->title }}</td>

                                    <!-- Display Toggle Status Checkbox -->
                                    <td>
                                        @if($blog->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /Recent Orders -->

        </div>
    </div>
@endsection
