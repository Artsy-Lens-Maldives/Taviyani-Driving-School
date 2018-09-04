@extends('layouts.table')

@section('title', 'Theory test Fee')

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
                <td>{{ $fee->student->theory_count }}</td>
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
                        <button class="btn btn-warning" data-toggle="modal" data-target="#slipAddModal" onclick="getSlipInfo('{{ $fee->id }}')">Slip not Taken</button>
                    @endif
                </td>
                <td>
                        @if ($fee->slipTaken == 1)
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

    <div class="modal" id="slipAddModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width:100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Slip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="slipAddForm" action="{{ url()->current() }}/addSlip" method="POST">
                        @csrf
                        <input type="hidden" name="slip_id" id="slip_id" value="">
                        <div id="prefetch" class="form-group">
                            <label>Student Name<span class="red">*</span></label>
                            <input type="text" class="form-control typeahead" name="student" id="selectStudentName" value="" required>
                        </div>
                        <div class="form-group">
                            <label>Rate</label>
                            <input type="number" class="form-control" name="rate" value="100" required>
                        </div>
                        <div class="form-group">
                            <label>Paid</label>
                            <input type="number" class="form-control" name="paid" id="selectStudentPaid">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="date">Test Date</label>
                            <input type='text' class="form-control datepicker" name="date" id="date" value="" />
                            <small id="dateHelpBlock" class="form-text text-muted">
                                Enter date of the test
                            </small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input form="feeForm" type="submit" class="btn btn-primary"></input>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('model-body')
    <form id="feeForm" action="{{ url()->current() }}/post" method="POST">
        @csrf
        <div class="form-group">
            <label>Select Student <span class="red">*</span></label>
            <div id="prefetch">
                <input type="text" class="form-control typeahead" name="student" placeholder="Enter student name" required>
            </div>
        </div>
        <div class="form-group">
            <label>Rate</label>
            <input type="number" class="form-control" name="rate" value="100" required>
        </div>
        <div class="form-group">
            <label>Paid</label>
            <input type="number" class="form-control" name="paid" min="0" value="0">
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

        console.log(students);

        $('#prefetch .typeahead').typeahead(null, {
            name: 'students',
            source: students
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

        function getSlipInfo(id) {
            $.get("/api/slip-info/" + id, function(data, status){
                console.log(data);
                $("selectStudentName").attr('value', data.student.name);
                $("selectStudentPaid").attr('value', data.paid);
            });
        }
    </script>
@endsection