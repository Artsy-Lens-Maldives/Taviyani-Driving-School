@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Request::is('/'))
                        You are Home
                    @endif
                    <p>You are logged in <strong>{{ Auth::user()->name }}</strong>! Your Role is {{ Auth::user()->getRoleNames() }}</p>
                    <p><div id="todaysDate"></div></p>
                    <p>-Taviyani Driving School-</p>

                    <a href="//taviyani.xyz/home">Back to XYZ</a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quick Search</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(request()->student_id == null)
                        <h4>Search for student</h4>
                        <form class="form-inline" method="GET">
                            <select name="student_id" id="student" class="selectpicker form-control mr-2" data-live-search="true" data-width="fit">
                                @foreach ($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                            <h6 class="mr-2">OR</h6>
                            <input type="text" class="form-control mr-2" placeholder="ID Card No">
                            <h6 class="mr-2">OR</h6>
                            <input type="text" class="form-control mr-2" placeholder="Phone No">

                            <button type="submit" class="btn btn-primary mb-2">Submit</button>
                        </form>
                    @else                        
                        <h4>Student Details</h4>
                        
                        <table id="example" width="100%" class="table table-bordered" data-page-length="25">                        
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
                                    <th>Location</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(request()->student_id !== null)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->id_card }}</td>
                                        <td>{{ $student->phone }}</td>
                                        <td>
                                            @if ($student->categories->count() > 0)
                                                @foreach ($student->categories as $category)    
                                                    [{{ $category->code }}]
                                                @endforeach
                                            @else
                                                <a class="btn btn-warning">Unassigned</a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($student->finished_at !== NULL)
                                                Student Finished
                                            @elseif ($student->refunded == '1')
                                                <button class="btn btn-danger">Refunded</button>
                                            @else
                                                @if ($student->slot !== NULL)
                                                    {{ $student->slot->instructor->name }}
                                                @else
                                                    <button onclick="updateTime({{ $student->id }})" data-toggle="modal" data-target="#feeAddModel" class="btn btn-warning" style="margin: 1px">Unassigned</button>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ strtoupper($student->location->code) }}/{{ $student->created_at->format("Y") }}/{{ $student->created_at->format("m") }}/{{ $student->id }}</td>
                                        <td>{{ $student->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($student->user_id !== null & $student->user !== null)
                                                {{ $student->user->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $student->location->name }}</td>
                                        <td>
                                            <a href="/student/delete/{{ $student->id }}" class="btn btn-danger" style="margin: 1px" onclick="return confirm('Are you sure you would like to delete this student. This process cannot be reversed.')"><i class="fas fa-trash"></i></a>
                                            <a href="/student/edit/{{ $student->id }}" class="btn btn-warning" style="margin: 1px" target="_blank"><i class="fas fa-edit"></i></a>
                                            <a href="/student/receipt/{{ $student->id }}" class="btn btn-success" style="margin: 1px" target="_blank"><i class="fas fa-receipt"></i></a>
                                            <a href="/student/theory/{{ $student->id }}" class="btn btn-info" style="margin: 1px" target="_blank">Theory</a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <hr>
                        
                        <h4>Theory Fees</h4>
                        <form class="form-inline" method="GET">
                            
                        </form>
                        <table class="table table-bordered">
                            <thead>
                                <th>Atempt</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                                <th>Slip Taken</th>
                                <th>Slip Add Date</th>
                                <th>Test Date</th>
                            </thead>
                            <tbody id="theoryTable">
                            @if ($theory->count() > 0)
                                <?php $i = 1 ?>
                                @foreach($theory as $t)
                                <?php $remaining = $t->total - $t->paid; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $t->paid }}</td>
                                    <td>{{ $remaining }}</td>
                                    @if ($t->slipTaken == 0 )
                                        <td>No</td>
                                        <td>-</td>
                                        <td>-</td>
                                    @else
                                        <td>Yes</td>
                                        <td>{{ $t->created_at->format('d/m/Yh:ia') }}</td>
                                        <td>{{ $t->date->format('d/m/Y') }}</td>
                                    @endif
                                </tr>
                                <?php $i++ ?>
                                @endforeach
                            @else
                                <tr><td colspan="6"><center>No Entries Found</center></td></tr>
                            @endif
                            </tbody>
                        </table>
                        <hr>
                        
                        <h4>Driving Fees</h4>
                        <table class="table table-bordered">
                            <thead>
                                <th>Atempt</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                                <th>Slip Taken</th>
                                <th>Slip Add Date</th>
                                <th>Test Date</th>
                            </thead>
                            <tbody id="drivingTable">
                            @if ($driving->count() > 0)
                                <?php $j = 1 ?>
                                @foreach($driving as $t)
                                <?php $remaining = $t->total - $t->paid; ?>
                                <tr>
                                    <td>{{ $j }}</td>
                                    <td>{{ $t->paid }}</td>
                                    <td>{{ $remaining }}</td>
                                    @if ($t->slipTaken == 0 )
                                        <td>No</td>
                                        <td>-</td>
                                        <td>-</td>
                                    @else
                                        <td>Yes</td>
                                        <td>{{ $t->created_at->format('d/m/Yh:ia') }}</td>
                                        <td>{{ $t->date->format('d/m/Y') }}</td>
                                    @endif
                                </tr>
                                <?php $j++ ?>
                                @endforeach
                            @else
                                <tr><td colspan="6"><center>No Entries Found</center></td></tr>
                            @endif
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
    $(document).ready(function() {
        // $.fn.dataTable.moment( 'D/M/YYYY' );

        // $('#example').DataTable({
        //     responsive: true,
        //     "autoWidth": false,
        //     "order": [6, 'desc'],
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'print',
        //         'excel',
        //         'pdf',
        //         'colvis'
        //     ]
        // });
    });


    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function updateDate()
    {
        var str = "";

        var days = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        var now = new Date();

        str += "Today is: <strong>" + days[now.getDay()] + ", " + now.getDate() + " " + months[now.getMonth()] + " " + now.getFullYear() + " " + addZero(now.getHours()) +":" + addZero(now.getMinutes()) + ":" + addZero(now.getSeconds()) + '</strong>';
        document.getElementById("todaysDate").innerHTML = str;
    }

    setInterval(updateDate, 1000);
    updateDate();
</script>

@endsection