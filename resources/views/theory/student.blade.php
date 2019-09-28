@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="box-center" style="width: 40%">
            <center>
                <h3>Theory Practice Test</h3>
                <h4>Student Name: <b>{{ $student->name }}</b></h4>
                <br>
                <button class="btn btn-primary btn-lg btn-block" onclick="startTest('{{ url()->current() }}/practice/1/all')">Theory All Questions</button>
                <button class="btn btn-info btn-lg btn-block" onclick="startTest('{{ url()->current() }}/practice/1/time')">Theory (30 Questions - 30 Mins)</button>
            </center>
        </div>
    </div>
@endsection

@section('js')
    <script>
    $(function() {
        $('.box-center').css({
            'position' : 'absolute',
            'left' : '50%',
            'top' : '50%',
            'margin-left' : function() {return -$(this).outerWidth()/2},
            'margin-top' : function() {return -$(this).outerHeight()/2}
        });
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
                console.log(data)
            }
        });
    }
    </script>
@endsection