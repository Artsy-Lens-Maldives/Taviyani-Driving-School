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
</div>
@endsection

@section('js')

<script>
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