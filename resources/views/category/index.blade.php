@extends('layouts.table')

@section('title', 'Categories')

@section('table')
    <thead>
        <tr>
            <th>Number</th>
            <th>Code</th>
            <th>Rate</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
    
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->code }}</td>
            <td>{{ $category->rate }}</td>
            <td>
                <a href="/category/delete/{{ $category->id }}" class="btn btn-danger" style="margin: 1px" onclick="return confirm('Are you sure you would like to delete this category. This process cannot be reversed.')">Delete</a>
                <a href="/category/edit/{{ $category->id }}" class="btn btn-warning" style="margin: 1px">Edit</a>
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