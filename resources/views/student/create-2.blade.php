@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Select category</div>

                <div class="card-body">
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="{{ $category->id }}">
                                <label class="form-check-label" for="exampleRadios1">
                                    {{ $category->code }} - {{ $category->name }} - Price: (add price column)
                                </label>
                            </div>
                        @endforeach
                        <hr>
                        
                        <button type="submit" class="btn btn-primary">Next Step</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection