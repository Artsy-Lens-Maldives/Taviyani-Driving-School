@extends('layouts.table')

@section('title', 'Instructors')

@section('table')
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($instructors as $instructor)
        
        <tr>
            <td>{{ $instructor->name }}</td>
            <td>{{ $instructor->phone_number }}</td>
            <td>
                @foreach($instructor->categories as $category)
                    {{ $category->code }}
                @endforeach
            </td>
            <td>
                <a class="btn btn-danger" style="margin: 1px">Delete</a>
                <a class="btn btn-warning" style="margin: 1px">Edit</a>
                <a class="btn btn-info" style="margin: 1px">Assign</a>
            </td>
        </tr>

        @endforeach
    </tbody>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endsection