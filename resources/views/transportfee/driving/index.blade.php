@extends('layouts.app')

@section('content')

    <div class="container">
    <div class="row">
            <div class="col-md-12">
                <h3>{{ $type }}</h3>
            </div>
            <div class="col-md-12">
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Paid</th>
                            <th>Remaining</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fees as $fee)
                            <tr>
                                <td>{{ $fee->student->name }}</td>
                                <td>{{ $fee->paid }}</td>
                                <td>{{ $fee->remaining }}</td>
                                <td>{{ $fee->status }}</td>
                                <td>
                                    <a href="" class="btn btn-danger">Delete</a>
                                    <a href="" class="btn btn-warning">Edit</a>
                                    @if ($fee->paid - $fee->remaining == 0)
                                        <a href="" class="btn btn-success">Paid</a>
                                    @else
                                        <a href="" class="btn btn-info">Recive Payment</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection