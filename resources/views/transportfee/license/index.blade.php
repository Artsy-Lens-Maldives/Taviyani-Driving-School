@extends('layouts.table')

@section('title', 'License Fee')

@section('button')
    <button data-toggle="modal" data-target="#feeAddModel" class="btn btn-success" style="margin-left: 10px">Add Slip</button>
@endsection

@section('table')
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Paid</th>
            <th>Remaining</th>
            <th>License taken</th>
            <th>Date taken</th>
            <th>Date paid</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fees as $fee)
            <tr>
                <td>{{ $fee->student->name }}</td>
                <td>{{ $fee->paid }}</td>
                <td>{{ $fee->remaining }}</td>
                <td>
                    @if($fee->slipTaken == 1)
                        License
                    @else
                        <button class="btn btn-info">Add License</button>
                    @endif
                </td>
                <td>{{ $fee->date }}</td>
                <td>{{ $fee->paid }}</td>
                <td>
                    <a href="" class="btn btn-danger">Delete</a>
                    <a href="" class="btn btn-warning">Edit</a>
                </td>
            </tr>
        @endforeach
    </tbody>
@endsection

@section('model-body')
    <form id="feeForm" action="{{ url()->current() }}/post" method="POST">
        @csrf
        <div id="prefetch" class="form-group">
            <label>Enter Student name</label>
            <input type="text" class="form-control typeahead" name="student" placeholder="Enter student name">
        </div>
        <div class="form-group">
            <label>Rate</label>
            <input type="number" class="form-control" name="rate" value="250">
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
                License Taken
            </label>
        </div>
        <div id="slipTaken">
            <div class="form-group">
                <label for="date">Date</label>
                <input type='text' class="form-control datepicker" name="date" id="date" />
                <small id="dateHelpBlock" class="form-text text-muted">
                    Enter date license was taken from the ministry
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
                $("#date").val(null);
            }
        };
    </script>
@endsection