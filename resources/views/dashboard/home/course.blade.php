@extends('layouts.dashboard')


    @section('content')
        <div class="container-fluid">
            <h3 class="text-dark mb-4 text-center">Courses</h3>
            <div class="card shadow col-md-8 mx-auto mb-5">
                <div class="card-body">
                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Course Name</th>
                                    <th>Week</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>HTML</td>
                                <td>Week 1</td>
                                <td><a href="{{ route('home.courses.week1') }}" class="btn btn-sm btn-outline-info">Start Course</a></td>
                            </tbody>
                            <tbody>
                                <td>HTML</td>
                                <td>Week 2</td>
                                <td><a href="{{ route('home.courses.week2') }}" class="btn btn-sm btn-outline-info">Start Course</a></td>
                            </tbody>
                            <tbody>
                                <td>HTML</td>
                                <td>Week 3</td>
                                <td><a href="{{ route('home.courses.week3') }}" class="btn btn-sm btn-outline-info">Start Course</a></td>
                            </tbody>
                            <tbody>
                                <td>HTML</td>
                                <td>Week 4</td>
                                <td><a href="{{ route('home.courses.week4') }}" class="btn btn-sm btn-outline-info">Start Course</a></td>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Course Name </strong></td>
                                    <td><strong>Week</strong></td>
                                    <td><strong>Action</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    @endsection

