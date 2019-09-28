@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="box-center" style="width: 40%">
            <center>
                <h1>Theory Practice Test</h1>
                <br>
                <h2>Waiting For Test</h2>
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

        fetchUrl();
    });

    function fetchUrl() {
        $.ajax({
            type: "GET",
            url: '/api/check-for-new-test',
            success: function(data)
            {
                if (data == 'false') {
                    console.log(false);
                } else {
                    window.location.replace(data.url);
                }
            }
        });
    }

    window.setInterval(function(){
        fetchUrl();
    }, 30000);

    </script>
@endsection