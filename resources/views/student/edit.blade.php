@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Student {{ ($student->refunded == '1') ? ' - REFUNDED' : '' }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url()->current() }}">
                        <h4>Student Detail @if($student->finished_at !== NULL) <br><b style="color: red">Student completed driving on: </b> {{ $student->finished_at }} @endif</h4>
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Mohamed Ahmed" value="{{ $student->name }}" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="idcardno">Id Card Number</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="idcardno" id="id_card" placeholder="123456" value="{{ $student->id_card }}" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phoneno">Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+960</span>
                                    </div>
                                    <input type="text" class="form-control" name="phone" id="phoneno" placeholder="7654321" value="{{ $student->phone }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Permanent Address</label>
                            <input type="text" class="form-control" name="p_address"  id="p_address" placeholder="M.House Name" value="{{ $student->p_address }}">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Residential Address</label>
                            <input type="text" class="form-control" name="c_address" id="c_address" placeholder="G.House Name" value="{{ $student->c_address }}">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <?php
                                    $now = \Carbon\Carbon::now();
                                    $now->subYears(18);
                                ?>
                                <label for="dob">Date of Birth</label>
                                <input type='text' class="form-control datepicker" value="{{ $student->dateofbirth }}" name="dateofbirth" id="dob">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="female" @if ($student->gender == 'female') selected @endif>Female</option>
                                    <option value="male" @if ($student->gender == 'male') selected @endif>Male</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="licenseNo">License No. and Expiry Date (if issued)</label>
                                <input type="text" class="form-control" id="license_no" name="license_no" placeholder="AXXXXXX" value="{{ $student->license_no }}">
                            </div>
                        </div>
                        <hr>
                        <h4>Category and Location</h4>
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input class="category form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}" data-rate="{{ $category->rate }}"
                                @foreach ($student->categories as $cat)
                                    @if ($cat->code == $category->code) 
                                        checked
                                    @endif
                                @endforeach
                                >
                                <label class="form-check-label" for="exampleRadios1">
                                    {{ $category->code }} - {{ $category->name }} - Price: {{ $category->rate }}
                                </label>
                            </div>
                        @endforeach
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="rate">Rate</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">MVR</span>
                                    </div>
                                    <input type="text" class="form-control" name="rate" id="rate" placeholder="2000" value="{{ $student->rate }}">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="discount">Discount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">MVR</span>
                                    </div>
                                    <input type="text" class="form-control" name="discount" id="discount" placeholder="100" value="{{ $student->discount }}">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <label>Select Location</label>
                            <select class="form-control" name="location_id">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                    @if ($student->location_id == $location->id)
                                        selected
                                    @endif
                                    >{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Select Instructor</label>
                                <select class="form-control" name="instructor_id" id="instructor">
                                    <option value="0">Unassgined</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}"
                                        @if ($instructor->id == $student->instructor_id)
                                        selected
                                        @endif
                                        >{{ $instructor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Select Time</label>
                                <div class="form-group">
                                    <select class="form-control" name="time_id" id="times">
                                        <option value="0">Unassgined</option>
                                        @if ($student->instructor)
                                            @foreach ($student->instructor->times as $time)
                                                <option value="{{ $time->id }}"
                                                @if ($time->id == $student->time_id)
                                                selected
                                                @endif
                                                >{{ $time->time }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        @if ($student->refunded == '0')
                        <a href="/student/refund/{{ $student->id }}" class="btn btn-danger float-right">Refund</a>
                        @endif
                        @if ($student->finished_at == NULL)
                        <a href="/student/end/{{ $student->id }}" class="btn btn-warning float-right" style="margin-right: 5px;">Student Finish</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript">
    $( document ).ready(function() {
        $("#instructor").change(function() {
            updateTime();
        });
    });

    function updateTime() {
        var id = $( "#instructor" ).val();
        console.log(id);
        $.ajax({
            type: "GET",
            url: "/api/free-times/"+id,
            success: function(times) {
                $("#times").html('<option value="0">Unassgined</option>'+times);
                console.log('Updated');
            }
        });
    }
    
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        endDate: '-18y',
        autoclose: true,
    });
    
    $("input:checkbox.category").click(function() {
        var rate = $(this).data('rate');
        var current = $("#rate").attr('value');
        // console.log(rate)

        if($(this).is(":checked")) {
            $("#rate").attr('value', parseInt(current) + parseInt(rate));
        } else {
            $("#rate").attr('value', parseInt(current) - parseInt(rate));
        }
    }); 
</script>

@endsection