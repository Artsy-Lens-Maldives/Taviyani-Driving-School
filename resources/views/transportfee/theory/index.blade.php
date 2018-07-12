@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row" style="margin-bottom: 10px;">
                    <h3 style="margin-right: 10px;">Theory Fee</h3>
                    <button data-toggle="modal" data-target="#feeAddModel" class="btn btn-success">Add</button>
                </div>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered">
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

    <div class="modal" id="feeAddModel" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width:100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Theory Fee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url()->current() }}" method="POST">
                        <div class="form-group">
                            <label>Select Student</label>
                            <select name="student_id" class="form-control">
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} - {{ $student->phone }}</option>
                                @endforeach
                            </select>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        endDate: '-18y',
        autoclose: true,
    });
</script>

@endsection