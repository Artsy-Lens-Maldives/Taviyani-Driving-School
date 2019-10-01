@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="/css/dhivehi.css"/>

    @if ($theory->isDhivehi == '1')
        <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css" integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If" crossorigin="anonymous">
    @endif
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-body">
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if(Session::has('alert-' . $msg))

                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                            
                            @endif
                        @endforeach
                    </div>

                    @if ($theory->isDhivehi == '0')
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
                        <h4>Edit Question and Answer</h4>
                        <div class="form-group">
                            <label for="usr">Question</label>
                            <input type="text" class="dhivehi-font dhivehi-rtl form-control" name="question" value="{{ $question->body }}">
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="usr">Answer 1 (Write the correct answer here)</label>
                                    <input type="text" class="dhivehi-font dhivehi-rtl form-control" name="answer1">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <input type="file" name="answerPhoto1">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="usr">Answer 2</label>
                                    <input type="text" class="dhivehi-font dhivehi-rtl form-control" name="answer2">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <input type="file" name="answerPhoto2">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="usr">Answer 3</label>
                                    <input type="text" class="dhivehi-font dhivehi-rtl form-control" name="answer3">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <input type="file" name="answerPhoto3">
                            </div>
                        </div>
    
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="usr">Answer 4</label>
                                    <input type="text" class="dhivehi-font dhivehi-rtl form-control" name="answer4">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <input type="file" name="answerPhoto4">
                            </div>
                        </div>
    
                        <hr>
        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @else
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
                        <h4 class="dhivehi-font dhivehi-rtl"> ސުވާލާއި ޖަވާބު ލިޔެލާ</h4>
                        <div class="form-group">
                            <label class="dhivehi-font dhivehi-rtl text-right" for="usr">ސުވާލު</label>
                            <input type="text" class="dhivehi-font dhivehi-rtl form-control form-control-lg" name="question">
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="dhivehi-font dhivehi-rtl" for="usr">(ޖަވާބު 1 (މިގޮޅީގައި ރަނގަޅު ޖަވާބު ލިޔޭ</label>
                                    <input type="text" class="dhivehi-font dhivehi-rtl form-control form-control-lg" name="answer1">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <input type="file" name="answerPhoto1">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="dhivehi-font dhivehi-rtl" for="usr">ޖަވާބު 2</label>
                                    <input type="text" class="dhivehi-font dhivehi-rtl form-control form-control-lg" name="answer2">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <input type="file" name="answerPhoto2">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="dhivehi-font dhivehi-rtl" for="usr">ޖަވާބު 3</label>
                                    <input type="text" class="dhivehi-font dhivehi-rtl form-control form-control-lg" name="answer3">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <input type="file" name="answerPhoto3">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="dhivehi-font dhivehi-rtl" for="usr">ޖަވާބު 4</label>
                                    <input type="text" class="dhivehi-font dhivehi-rtl form-control form-control-lg" name="answer4">
                                </div>
                            </div>
                            <div class="col-3 mt-4">
                                <input type="file" name="answerPhoto4">
                            </div>
                        </div>

                        <hr>
        
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript">
    
</script>

@endsection