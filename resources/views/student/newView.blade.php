@extends('layouts.table')

@section('title', 'Students registered from site')

@section('table')
    <thead>
        <tr>
            <th>Name</th>
            <th>Id Card</th>
            <th>Phone</th>
            <th>Requested Category</th>
            <th>Requested Instructor</th>
            <th>Registered Date</th>
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
                    {{ $student->category->name }}
                </td>
                <td>
                    {{ $student->instructor->name }}
                </td>
                <td>{{ $student->created_at->format('d/m/Y') }}</td>
                <td>
                    <center>
                        <a class="btn btn-danger" style="margin: 1px"><i class="fas fa-trash"></i></a>
                        <a class="btn btn-warning" style="margin: 1px"><i class="fas fa-edit"></i></a>
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
