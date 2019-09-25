@extends('layouts.table')

@section('title', 'Instructors')

@section('button')
    <a href="{{ url('instructor/create') }}" class="btn btn-success" style="margin-left: 10px">Add a Insrtuctor</a>
@endsection

@section('table')
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Category</th>
            <th>Location</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($instructors as $instructor)
        
        <tr>
            <td>{{ $instructor->name }}</td>
            <td>{{ $instructor->phone }}</td>
            <td>
                @foreach($instructor->categories as $category)
                    {{ $category->code }}
                @endforeach
            </td>
            <td>{{ $instructor->location->name }}</td>
            <td>
                <a href="/instructor/delete/{{ $instructor->id }}" class="btn btn-danger" style="margin: 1px">Delete</a>
                <a href="/instructor/edit/{{ $instructor->id }}" class="btn btn-warning" style="margin: 1px">Edit</a>
                <button onclick="updateTime({{ $instructor->id }})" data-toggle="modal" data-target="#feeAddModel" class="btn btn-info" style="margin: 1px">Assign</button>
            </td>
        </tr>

        @endforeach
    </tbody>
@endsection

@section('js')
    <script type="text/javascript">
        var id;

        $(document).ready(function() {
            $('#example').DataTable();

            updateTime();

            $("#instructor").change(function() {
                updateTime();
            });
        });

        function updateTime(id_instructor) {
            id = id_instructor;
            console.log(id);

            $('#instructor_id').val(id);

            $.ajax({
                type: "GET",
                url: "/api/free-times/"+id,
                success: function(times) {
                    $("#times").html(times);
                    console.log('Updated');
                }
            });
        }
    </script>
@endsection

@section('model-body')
    <form id="feeForm" action="{{ url()->current() }}/assign-student" method="POST">
        @csrf
        <input type="hidden" name="instructor_id" id="instructor_id">
        <div class="form-group">
            <label>Select Student</label>
            <select name="student_id" id="student" class="selectpicker form-control" data-live-search="true">
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Select Time</label>
            <select class="form-control" name="time_id" id="times">
            </select>
        </div>
    </form>
@endsection