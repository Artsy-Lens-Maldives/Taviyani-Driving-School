@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="/css/dhivehi.css"/>
@endsection

@section('content')
    <div class="container">
        <center>
            <div class="box-center" style="width: 40%" id="theory">
                <center>
                    <h3>Theory Practice Test</h3>
                    <h4>Student Name: <b>{{ $student->name }}</b></h4>
                    <hr>
                    <h1>Test Started</h1>
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
    </script>
@endsection