@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a student</div>

                <div class="card-body">
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
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
                                <input type='text' class="form-control datepicker" value="{{ $now->format('d/m/Y') }}" name="dateofbirth" id="dob" />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="licenseNo">License No. and Expiry Date (if issued)</label>
                                <input type="text" class="form-control" id="license_no" placeholder="AXXXXXX">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Next Step</button>
                    </form>
                </div>
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