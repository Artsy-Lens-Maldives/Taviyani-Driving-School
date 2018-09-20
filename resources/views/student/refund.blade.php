@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                    
                    @endif
                @endforeach
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Refund Student</div>

                <div class="card-body">
                    <form method="POST" action="{{ url()->current() }}">
                        @csrf
                        <input type="hidden" name="refunded" value="1">
                        <h4>Are you sure you want to refund this student?</h4>
                        <ul>
                            <li>Name: {{ $student->name }}</li>
                            <li>Id Card No: {{ $student->id_card }}</li>
                            <li>Phone: {{ $student->phone }}</li>
                            <li>Current Address: {{ $student->c_address }}</li>
                            <li>Permanent Address: {{ $student->p_address }}</li>
                            <li>Rate: {{ $student->rate }}</li>
                            <li>Discount: {{ ($student->discount == null) ? '-' : $student->discount }}</li>
                        </ul>
                        <hr>
                        <button type="sumit" class="btn btn-success btn-lg btn-block">Yes</button>
                        <a class="btn btn-danger btn-lg btn-block" href="/student/edit/{{ $student->id }}">No</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        endDate: '-18y',
        autoclose: true,
    });
    
    function updateRate(rate) {
        $("#rate").attr('value', rate);
    }
</script>

@endsection