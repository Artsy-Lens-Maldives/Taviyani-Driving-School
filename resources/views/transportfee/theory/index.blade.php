@extends('layouts.table')

@section('title', 'Theory Fee')

@section('table')
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Attempts</th>
            <th>Paid</th>
            <th>Remaining</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fees as $fee)
            <tr>
                <td>{{ $fee->student->name }}</td>
                <td>{{ $fee->student->theory_count }}</td>
                <td>{{ $fee->paid }}</td>
                <td>{{ $fee->total - $fee->paid }}</td>
                <td>{{ $fee->status }}</td>
                <td>{{ $fee->date->format('d/m/Y') }}</td>
                <td>
                    <a href="" class="btn btn-danger">Delete</a>
                    <a href="" class="btn btn-warning">Edit</a>
                    @if ($fee->total - $fee->paid == 0)
                        <a href="" class="btn btn-success disabled" disabled>Paid fully</a>
                    @else
                        <a href="" class="btn btn-info">Recive Payment</a>
                    @endif
                    @if (!$fee->date->isPast())
                        <a href="" class="btn btn-secondary">Send Reminder</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
@endsection

@section('model-body')
    <form id="feeForm" action="{{ url()->current() }}/post" method="POST">
        @csrf
        <div id="prefetch" class="form-group">
            <label>Select Student</label>
            <input type="text" class="form-control typeahead" name="student" placeholder="Enter student name">
        </div>
        <div class="form-group">
            <?php
                $now = \Carbon\Carbon::now();
            ?>
            <label for="date">Date</label>
            <input type='text' class="form-control datepicker" value="{{ $now->format('d/m/Y') }}" name="date" id="dob" />
        </div>
        <hr>
        <div class="form-group">
            <label>Rate</label>
            <input type="number" class="form-control" name="rate" value="100">
        </div>
        <div class="form-group">
            <label>Paid</label>
            <input type="number" class="form-control" name="paid">
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option>Slip taken</option>
                <option>Slip not taken</option>
            </select>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
        });
        
        var students = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '/api/student/names'
        });

        $('#prefetch .typeahead').typeahead(null, {
            name: 'students',
            source: students
        });

        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endsection