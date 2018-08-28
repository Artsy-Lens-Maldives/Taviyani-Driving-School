@extends('layouts.app')

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

                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
                        <h4>Edit Category</h4>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Category Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Category Code</label>
                                <input type="text" class="form-control" name="code" value="{{ $category->code }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Rate</label>
                            <input type="rate" class="form-control" name="rate" value="{{ $category->rate }}" required>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection