    @extends('layouts.app')

    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a student</div>

                    <div class="card-body">
                        <form method="POST" action="{{ url()->current() }}" onkeypress="return event.keyCode != 13;">
                            <h4>Student Detail</h4>
                            @csrf
                            <div class="form-group">
                                <label for="idcardno">Id Card Number</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="idcardno" id="id_card" placeholder="123456">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="button" onclick="getStudentInfo()">Search DB</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Mohamed Ahmed">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phoneno">Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">+960</span>
                                        </div>
                                        <input type="text" class="form-control" name="phone" id="phoneno" placeholder="7654321">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phoneno">Phone Number - 2</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">+960</span>
                                        </div>
                                        <input type="text" class="form-control" name="phone_2" id="phoneno_2" placeholder="7654321">
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
                            <hr>
                            <h4>Category, rate and Location</h4>
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="category" value="{{ $category->id }}" onchange="updateRate({{ $category->rate }})">
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
                                        <input type="text" class="form-control" name="rate" id="rate" placeholder="2000">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="discount">Discount</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">MVR</span>
                                        </div>
                                        <input type="text" class="form-control" name="discount" id="discount" placeholder="100">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Select Location</label>
                                <select class="form-control" name="location_id">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
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

        function updateRate(rate) {
            $("#rate").attr('value', rate);
        }
    </script>

    <script>
        function getStudentInfo() {
            var nid = $("#id_card").val();
            console.log(nid);

            $.get("/api/people/A" + nid, function(data, status){
                console.log(data);
                $("#name").attr('value', data.name);
                $("#p_address").attr('value', data.atoll + '. ' + data.island + ', ' + data.house);
                $("#dob").attr('value', data.dob);

                if (data.student !== null) {
                    $("#phoneno").attr('value', data.student.phone);
                    $("#phoneno_2").attr('value', data.student.phone_2);
                    $("#c_address").attr('value', data.student.c_address);
                    if(data.student.gender == 'male') {
                        $('#gender option[value=male]').attr('selected','selected');
                    }
                    if(data.student.gender == 'female') {
                        $('#gender option[value=female]').attr('selected','selected');
                    }
                    $("#license_no").attr('value', data.student.license_no);
                }
            });
        }

    </script>

    @endsection