@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
                        <h4>Add Instructor</h4>
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Mohamed Ahmed">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="idcardno">Id Card Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">A</span>
                                    </div>
                                    <input type="text" class="form-control" name="idcardno" id="id_card" placeholder="123456">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phoneno">Phone Number</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+960</span>
                                    </div>
                                    <input type="text" class="form-control" name="phone" id="phoneno" placeholder="7654321">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Permanent Address</label>
                            <input type="text" class="form-control" name="p_address"  id="p_address" placeholder="M.House Name">
                        </div>
                        <div class="form-group">
                            <label for="inputAddress2">Residential Address</label>
                            <input type="text" class="form-control" name="c_address" id="c_address" placeholder="G.House Name">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <?php
                                    $now = \Carbon\Carbon::now();
                                    $now->subYears(18);
                                ?>
                                <label for="dob">Date of Birth</label>
                                <input type='text' class="form-control dob-datepicker" value="{{ $now->format('d/m/Y') }}" name="dob" id="dob" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Select Location</label>
                            <select class="form-control" name="location_id">
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
                                <input type="text" class="form-control" name="license_no" id="license_no" placeholder="123456">
                            </div>
                            <div class="form-group col-md-6">
                                <?php
                                    $now_2 = \Carbon\Carbon::now();
                                ?>
                                <label for="phoneno">License Expiry</label>
                                <input type='text' class="form-control datepicker" value="{{ $now_2->format('d/m/Y') }}" name="license_expiry" id="license_expiry" />
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
                        <h4>Login Details</h4>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="email@taviyani.com.mv" value="@taviyani.com.mv">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" name="pass" id="password" placeholder="enter password" value="Welcome123">
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
</script>

@endsection