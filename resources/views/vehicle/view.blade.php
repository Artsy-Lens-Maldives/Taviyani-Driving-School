@extends('layouts.table')

@section('title', 'Vehicles')

@section('table')
    <thead>
        <tr>
            <th>Number</th>
            <th>Category</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vehicles as $vehicle)
    
        <tr>
            <td>{{ $vehicle->number }}</td>
            <td>{{ $vehicle->category->code }} - {{ $vehicle->category->name }}</td>
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