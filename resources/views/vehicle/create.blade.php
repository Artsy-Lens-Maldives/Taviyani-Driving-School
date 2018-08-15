@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h3>Add Vehicle</h3>
                    <hr>
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
                        <h6>Cycle Number</h6>
                        <div class="form-group">
                            <input type="text" class="form-control" name="number" id="number" placeholder="P7002">
                        </div>
                        <br>
                        <h6>Select Category</h6>
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="{{ $category->id }}">
                                <label class="form-check-label" for="exampleRadios1">
                                    {{ $category->code }} - {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection