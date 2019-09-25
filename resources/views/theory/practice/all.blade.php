@extends('layouts.theory')

@section('content')

    <section class="panel dhivehi-font dhivehi-rtl" id="start">
        <div class="center-box">
            <div class="content">
                <center>
                    <img src="/logo/dr.png" alt="Taviyani Logo" style="width: 40%; margin-bottom:20px;">
                    <h1 style="font-size: 350%">{{ $theory->name }} - ހުރިހާ ސުވާލެއް</h1>
                    <hr>
                    <a class="btn btn-success btn-lg btn-block" href="#panel-1" style="font-size: 250%">ޓެސްޓް ފަށާ</a>
                </center>
            </div>
        </div>
    </section>

    <form method="POST" action="{{ url()->current() }}">
        {{ csrf_field() }}
        <?php $i = 0 ?>
        @foreach ($theory->questions as $question)
            <?php $i++ ?>
            <section class="panel dhivehi-font dhivehi-rtl" id="panel-{{ $i }}">
                <div class="vertical-box">
                    <div class="question">
                        <div style="text-align: right">
                            <h5 style="font-size: 200%;">{{ $i }}) {{ $question->body }}</h2>
                            
                            <div class="question-answers">
                            @foreach ($question->answers as $answer)
                                <div class="form-check">
                                    <label style="margin-right: 20px; font-size: 150%">
                                        <input type="radio" class="form-check-input" name="{{ $question->id }}" style="width:1em; height:1em; margin-right: -40px;" value="{{ $answer->id }}">
                                        {{ $answer->answer }}
                                    </label>
                                </div>
                                <br>
                            @endforeach
                            </div>
            
                            <div class="question-buttons">
                                @if ($i !== $theory->questions->count())
                                    <a name="" id="" class="btn btn-primary" href="#panel-{{ $i + 1 }}" role="button" style="font-size: 200%;">
                                        ކުރިޔަށް
                                    </a>
                                @else
                                    <button type="submit" class="btn btn-primary" style="font-size: 200%;">
                                        ޓެސްޓް ނިންމާ
                                    </button>
                                @endif
                                @if ($i !== 1)
                                    <a name="" id="" class="btn btn-info" href="#panel-{{ $i - 1 }}" role="button" style="font-size: 200%;">
                                        ފަހަތަށް
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    </form>

@endsection

@section('css')

<style>
    body {
        overflow: hidden;
        background-color: #f2f8ff;
        background-image: url('/logo/dr-r.png');
        background-repeat: repeat;
    }

    .panel {
        height: 100vh;
        width: 100vw;
        border: 5px #0984e3 solid;

        /* display: flex;
        justify-content: center;
        align-items: center; */
    }

    .center-box {
        height: 100vh;
        width: 100vw;

        display: flex;
        justify-content: center;
        align-items: center;
    }

    .vertical-box {
        height: 100vh;
        width: 100vw;

        display: flex;
        flex-direction: column;
        justify-content: center;

        /* padding-right: 100px; */
    }

    .content {
        background-color: rgba(160, 200, 239, 0.7);
        padding: 30px;
    }

    .question {
        background-color: rgba(160, 200, 239, 0.9);
        padding-right: 100px;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    .question-answers {
        padding-top: 10px;
        padding-right: 30px;
    }
    
    .question-buttons {
        padding-right: 100px;
    }
</style>

@endsection