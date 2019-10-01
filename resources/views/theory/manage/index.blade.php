@extends('layouts.table')

@section('css')
<link rel="stylesheet" type="text/css" href="/css/dhivehi.css"/>
@endsection

@section('title', 'Theory')

@section('button')
    
@endsection

@section('above-table')
    <div class="row">
        <div class="col-md-12">
            <form class="" method="POST" action="{{ url()->current() }}/add">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" id="inlineFormInput" placeholder="Theory Paper Name" class="name" name="name">
                    </div>
                    <div class="col-1">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="inlineFormCheck" name="isDhivehi" value="1" onclick="addRemoveCss()">
                            <label class="form-check-label" for="inlineFormCheck">
                                is Dhivehi
                            </label>
                        </div>
                    </div>
                    <div class="col-1">
                        <button type="submit" class="btn btn-primary mb-2">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('table')
    <thead>
        <tr>
            <th>Name</th>
            <th>Created Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($theories as $theory)
        <tr>
            <td @if($theory->isDhivehi == '1') class="dhivehi-font dhivehi-rtl" style="text-align: right" @endif>{{ $theory->name }}</td>
            <td>{{ $theory->created_at->diffForHumans() }}</td>
            <td>
                <a class="btn btn-danger" href="{{ url()->current() }}/delete/{{ $theory->id }}">Delete</a>
                <a class="btn btn-info" href="{{ url()->current() }}/questions/{{ $theory->id }}">Questions</a>
            </td>
        </tr>
        @endforeach
    </tbody>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            // $('#example').DataTable();
        });

        function addRemoveCss() {
            // if ($('#inlineFormCheck').prop('checked')) {
            //     $('#inlineFormInput').toggleClass("dhivehi-font dhivehi-rtl");
            // } 
            $('#inlineFormInput').toggleClass("dhivehi-font dhivehi-rtl");
        }
    </script>
@endsection