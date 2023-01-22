@extends('layouts.dashboard')
@section('content')
<div class="container">
    <form class="border rounded p-5" id="form" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data" method="POST" >
        @csrf
        <div class="mb-3">
            <label for="course" class="form-label">Course Name</label>
            <input type="text" name="course" class="form-control" id="course" placeholder="Course">
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <input type="text" name="level" class="form-control" id="level" placeholder="Level">
        </div>

        <button class="btn btn-primary d-block btn-user w-100" type="submit">Create Course</button>
    </form>
</div>
@endsection
