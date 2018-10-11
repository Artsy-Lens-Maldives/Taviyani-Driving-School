@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="box-center" style="width: 40%">
            <center>
                <h3>Theory Practice Test</h3>
                <br>
                <a href="{{ url()->current() }}/practice/all" class="btn btn-primary btn-lg btn-block">Theory All Questions</a>
                <a href="{{ url()->current() }}/practice/time" class="btn btn-info btn-lg btn-block">Theory (30 Questions - 30 Mins)</a>
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
    </script>
@endsection