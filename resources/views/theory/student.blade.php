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
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Select Theory</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                        @foreach ($theories as $theory)
                        <option value="{{ $theory->id }}" @if ($theory->isDhivehi == '1') class="dhivehi-font dhivehi-rtl" @endif>{{ $theory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary btn-lg btn-block" onclick="startTest('{{ url()->current() }}/practice/all')">Theory All Questions</button>
                <button class="btn btn-info btn-lg btn-block" onclick="startTest('{{ url()->current() }}/practice/time')">Theory (30 Questions - 30 Mins)</button>
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

    function post(path, params, method='post') {

        const form = document.createElement('form');
        form.method = method;
        form.action = path;

        for (const key in params) {
        if (params.hasOwnProperty(key)) {
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = key;
            hiddenField.value = params[key];

            form.appendChild(hiddenField);
        }
        }

        document.body.appendChild(form);
        form.submit();
    }

    function startTest(url) {
        post('{{ url()->current() }}', { url: url + '/' + $('#exampleFormControlSelect1').val(), _token: '{{ csrf_token() }}' })
    }
    </script>
@endsection