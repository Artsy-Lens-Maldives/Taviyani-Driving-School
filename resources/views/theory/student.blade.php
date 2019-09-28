@extends('layouts.app')

@section('content')
    <div class="container">
        <center>
        <div class="box-center" style="width: 40%" id="theory">
            <center>
                <h3>Theory Practice Test</h3>
                <h4>Student Name: <b>{{ $student->name }}</b></h4>
                <br>
                <button class="btn btn-primary btn-lg btn-block" onclick="startTest('{{ url()->current() }}/practice/1/all')">Theory All Questions</button>
                <button class="btn btn-info btn-lg btn-block" onclick="startTest('{{ url()->current() }}/practice/1/time')">Theory (30 Questions - 30 Mins)</button>
            </center>
        </div>
        <div class="box-center" style="width: 40%; display: none;" id="started">
            <center>
                <h2>Test Started</h2>
            </center>
        </div>
        </center>  
    </div>
@endsection

@section('js')
    <script>
    $(function() {
        //         
    });

    function startTest(url) {
        $.ajax({
            type: "POST",
            url: '/api/create-new-test',
            data: {
                url: url,
                _token: '{{ csrf_token() }}'
            },
            success: function(data)
            {
                console.log(data);
                $('#theory').hide();
                $('#started').show();
            }
        });
    }
    </script>
@endsection