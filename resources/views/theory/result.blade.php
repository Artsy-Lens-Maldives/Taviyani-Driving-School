@extends('layouts.theory')

@section('content')

<div class="container">
    <div class="card" style="margin-top: 100px;">
        <div class="card-body">
            <h1>Theory Paper: Result</h1>
            <hr>
            <div class="score">
                <span class="score-text">Final Score</span>
                <br>
                <span class="score-percent">{{ $result[0]['percent'] }}
                </span>
                <br>
                <span class="score-text">{{ $result[0]['correct'] }} of {{ $result[0]['total'] }} correct</span>
            </div>
            <hr>

            @foreach ($newArray as $item)
                {{ $item[0]['question'] }}
            @endforeach
        </div>
    </div>
</div>

@endsection

@section('css')

<style>
    body {
        background-color: #f2f8ff;
        background-image: url('/logo/dr-r.png');
        background-repeat: repeat;
    }
    .score {
        text-align: center;
    }
    .score-text {
        font-size: 60px;
        color: blue;
    }
    .score-percent {
        font-size: 55px;
        color: red;
    }
</style>

@endsection