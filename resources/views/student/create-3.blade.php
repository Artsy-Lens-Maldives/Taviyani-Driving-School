@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Select Instructor and Time</div>

                <div class="card-body">
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
                        <div class="form-group">
                            <select class="form-control" name="instructor" id="instructor">
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>    
                                @endforeach
                            </select>
                        </div>

                        <hr>

                        <div class="form-group">
                            <select class="form-control" name="time" id="times">
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Finish</button>
                        <a href="{{ url('/student/ongoing/'. $student->location->id) }}" class="btn btn-info">Assign time later</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
    $( document ).ready(function() {
        updateTime();

        $("#instructor").change(function() {
            updateTime();
        });
    });

    function updateTime() {
        var id = $( "#instructor" ).val();
        console.log(id);
        $.ajax({
            type: "GET",
            url: "/api/free-times/"+id,
            success: function(times) {
                $("#times").html(times);
                console.log('Updated');
            }
        });
    }
</script>

@endsection