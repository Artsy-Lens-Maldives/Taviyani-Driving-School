@extends('layouts.app')

@section('content')

    <div class="container">
        <table class="table">
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->id_card }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>
                            @if ($student->category->exists())
                                {{ $student->category->code }}
                            @else
                                <a class="btn btn-warning">Unassigned</a>
                            @endif
                        </td>
                        <td>
                            @if ($student->slot->instructor->exists())
                                {{ $student->slot->instructor->name }}
                            @else
                                <a class="btn btn-warning">Unassigned</a>
                            @endif
                        </td>
                        <td>-</td>
                        <td>{{ $student->created_at->toFormattedDateString() }}</td>
                        <td>-</td>
                        <td>
                            <a class="btn btn-danger" style="margin: 1px">Delete</a>
                            <a class="btn btn-warning" style="margin: 1px">Edit</a>
                            <a class="btn btn-success" style="margin: 1px">Recipt</a>
                            <a class="btn btn-info" style="margin: 1px">Assign</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection