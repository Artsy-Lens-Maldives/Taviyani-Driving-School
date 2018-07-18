@extends('layouts.table')

@section('title', 'Driving Test Fee')

@section('button')
    <button data-toggle="modal" data-target="#feeAddModel" class="btn btn-success" style="margin-left: 10px">Add Slip</button>
@endsection

@section('table')
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Attempts</th>
            <th>Paid</th>
            <th>Remaining</th>
            <th>Slip taken</th>
            <th>Slip add date</th>
            <th>Test date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fees as $fee)
            <tr>
                <td>{{ $fee->student->name }}</td>
                <td>{{ $fee->student->driving_count }}</td>
                <td>
                    @if ($fee->paid > 0)
                        {{ $fee->paid }}
                    @else
                        0
                    @endif
                </td>
                <td>{{ $fee->total - $fee->paid }}</td>
                <td>
                    @if ($fee->slipTaken == 1)
                        <button class="btn btn-success" disabled>Slip Taken</button>
                    @else
                        <a class="btn btn-warning">Slip not Taken</a>
                    @endif
                </td>
                <td>
                    @if ($fee->created_at !== NULL)
                        {{ $fee->created_at->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if ($fee->date !== NULL)
                        {{ $fee->date->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    <a href="" class="btn btn-danger">Delete</a>
                    <a href="" class="btn btn-warning">Edit</a>
                    @if ($fee->total - $fee->paid == 0)
                        <a href="" class="btn btn-success disabled" disabled>Paid fully</a>
                    @else
                        <a href="" class="btn btn-info">Recive Payment</a>
                    @endif
                    @if ($fee->date !== NULL)
                        @if (!$fee->date->isPast())
                            <a href="" class="btn btn-secondary">Send Reminder</a>
                        @endif
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
            <label>Select Student <span class="red">*</span></label>
            <input type="text" class="form-control typeahead" name="student" placeholder="Enter student name" required>
        </div>
        <div class="form-group">
            <label>Rate</label>
            <input type="number" class="form-control" name="rate" value="100" required>
        </div>
        <div class="form-group">
            <label>Paid</label>
            <input type="number" class="form-control" name="paid">
            <small id="paidHelpBlock" class="form-text text-muted">
                Enter amount paid by the customer
            </small>
        </div>
        <hr>
        <div class="form-check">
            <input class="form-check-input" name="slipTaken" type="checkbox" value="1" id="defaultCheck1" onchange="showSlipTaken()">
            <label class="form-check-label" for="defaultCheck1">
                Slip Taken
            </label>
        </div>
        <div id="slipTaken">
            <div class="form-group">
                <label for="date">Date</label>
                <input type='text' class="form-control datepicker" name="date" id="date" value="" />
                <small id="dateHelpBlock" class="form-text text-muted">
                    Enter date of the test
                </small>
            </div>
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
            $( "#slipTaken" ).hide();
            $('#example').DataTable();

            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });

        function showSlipTaken() {
            var d = new Date();
            var month = d.getMonth()+1;
            var day = d.getDate();

            var output = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear()

            if ($('#defaultCheck1').is(":checked")) {
                $( "#slipTaken" ).show( "slow" );
                $("#date").val(output);
            } else {
                $( "#slipTaken" ).hide( "slow" );
                $("#date").val('');
            }
        };
    </script>
@endsection