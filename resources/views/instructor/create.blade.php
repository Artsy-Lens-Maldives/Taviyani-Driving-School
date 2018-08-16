@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-body">
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            
                            @endif
                        @endforeach
                    </div>

                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
                        <h4>Add Instructor</h4>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Mohamed" onkeyup="updateEmail()" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Ahmed" onkeyup="updateEmail()" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="idcardno">Id Card Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">A</span>
                                    </div>
                                    <input type="text" class="form-control" name="idcardno" id="id_card" placeholder="123456" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phoneno">Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+960</span>
                                    </div>
                                    <input type="text" class="form-control" name="phone" id="phoneno" placeholder="7654321" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Permanent Address</label>
                            <input type="text" class="form-control" name="p_address"  id="p_address" placeholder="M.House Name" required>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Residential Address</label>
                            <input type="text" class="form-control" name="c_address" id="c_address" placeholder="G.House Name" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <?php
                                    $now = \Carbon\Carbon::now();
                                    $now->subYears(18);
                                ?>
                                <label for="dob">Date of Birth</label>
                                <input type='text' class="form-control dob-datepicker" value="{{ $now->format('d/m/Y') }}" name="dob" id="dob" / required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Select Location</label>
                            <select class="form-control" name="location_id" required>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <h4>License Info</h4>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="license_no">License No</label>
                                <input type="text" class="form-control" name="license_no" id="license_no" placeholder="123456" required>
                            </div>
                            <div class="form-group col-md-6">
                                <?php
                                    $now_2 = \Carbon\Carbon::now();
                                ?>
                                <label for="phoneno">License Expiry</label>
                                <input type='text' class="form-control datepicker" value="{{ $now_2->format('d/m/Y') }}" name="license_expiry" id="license_expiry" required>
                            </div>
                        </div>
                        <hr>
                        <h4>Select the categories</h4>
                        @foreach ($categories as $category)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->id }}">
                                <label class="form-check-label">
                                    {{ $category->code }} - {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                        <hr>
                        <h4>Select Working Hours</h4>
                        @foreach ($times as $time)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="time[]" value="{{ $time->id }}">
                                <label class="form-check-lablel">
                                    {{ $time->time }}
                                </label>
                            </div>
                        @endforeach
                        <hr>
                        <h4>Login Details</h4>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="email@taviyani.com.mv" value="@taviyani.com.mv" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" name="pass" min="6" id="password" placeholder="enter password" value="Welcome123" required>
                            </div>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript">
    $('.dob-datepicker').datepicker({
        format: 'dd/mm/yyyy',
        endDate: '-18y',
        autoclose: true,
    });
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
    });

    $( document ).ready(function () {

    });
    function updateEmail() {
        $firstName = $('#first_name').val().toLowerCase();
        $lastName = $('#last_name').val().toLowerCase();
        $('#email').val($firstName + "." + $lastName + "@taviyani.com.mv");
        console.log($firstName + "." + $lastName + "@taviyani.com.mv");
    }
</script>

@endsection