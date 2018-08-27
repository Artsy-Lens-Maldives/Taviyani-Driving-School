@extends('layouts.table')

@section('title', 'Students')

@section('table')
    <thead>
        <tr>
            <th>Name</th>
            <th>Id Card</th>
            <th>Phone</th>
            <th>Category</th>
            <th>Instructor</th>
            <th>Slip Number</th>
            <th>Registered Date</th>
            <th>Registered By</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->id_card }}</td>
                <td>{{ $student->phone }}</td>
                <td>
                    @if ($student->category !== NULL)
                        {{ $student->category->code }}
                    @else
                        <a class="btn btn-warning">Unassigned</a>
                    @endif
                </td>
                <td>
                    @if ($student->slot !== NULL)
                        {{ $student->slot->instructor->name }}
                    @else
                    <button onclick="updateTime({{ $student->id }})" data-toggle="modal" data-target="#feeAddModel" class="btn btn-warning" style="margin: 1px">Unassigned</button>
                    @endif
                </td>
                <td>TDS/{{ $student->created_at->format("Y") }}/{{ $student->created_at->format("m") }}/{{ $student->id }}</td>
                <td>{{ $student->created_at->format('d/m/Y') }}</td>
                <td>
                    @if ($student->user_id !== null)
                        {{ $student->user->name }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <center>
                        <a href="/student/delete/{{ $student->id }}" class="btn btn-danger" style="margin: 1px" onclick="return confirm('Are you sure you would like to delete this category. This process cannot be reversed.')"><i class="fas fa-trash"></i></a>
                        <a href="/student/edit/{{ $student->id }}" class="btn btn-warning" style="margin: 1px"><i class="fas fa-edit"></i></a>
                        @if ($student->slot == null)
                            <button onclick="updateTime({{ $student->id }})" data-toggle="modal" data-target="#feeAddModel" class="btn btn-success" style="margin: 1px"><i class="fas fa-receipt"></i></button>
                        @endif
                    </center>
                </td>
            </tr>
        @endforeach
    </tbody>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $.fn.dataTable.moment( 'D/M/YYYY' );

            $('#example').DataTable({
                responsive: true,
                "autoWidth": false,
                "order": [7, 'desc'],
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'excel',
                    'pdf',
                    'colvis'
                ]
            });

            updateTime();

            $("#instructor").change(function() {
                updateTime();
            });
        });

        function updateTime(student_id) {
            $('#student_id').val(student_id)
            var id = $( "#instructor" ).val();
            console.log(id);
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
        <input type="hidden" name="student_id" id="student_id">
        <div class="form-group">
            <label>Instructor</label>
            <select class="form-control" name="instructor_id" id="instructor">
                @foreach ($instructors as $instructor)
                    <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>    
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