@extends('layouts.table')

@section('css')
<link rel="stylesheet" type="text/css" href="/css/dhivehi.css"/>
@endsection

@section('title', 'Theory Questions')

@section('button')
    <a href="{{ url()->current() }}/add-questions" class="btn btn-success" style="margin-left: 10px">Add Question</a>
@endsection

@section('table')
    <thead>
        <tr>
            <th>Question</th>
            <th>Created Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($theory->questions as $question)
        <tr>
            <td @if($theory->isDhivehi == '1') class="dhivehi-font dhivehi-rtl" style="text-align: right" @endif>{{ $question->body }}</td>
            <td>{{ $question->created_at->diffForHumans() }}</td>
            <td>
                <a class="btn btn-danger" href="{{ url()->current() }}/delete/{{ $question->id }}">Delete</a>
                <a class="btn btn-warning" href="{{ url()->current() }}/edit-questions/{{ $question->id }}">Edit</a>
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
    </script>
@endsection