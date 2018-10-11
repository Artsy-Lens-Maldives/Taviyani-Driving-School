@extends('layouts.theory')

@section('content')

<div class="container">
    @foreach ($newArray as $item)
        <?php print_r($item) ?>
    @endforeach

    <hr>

    <?php print_r($result) ?>
</div>

@endsection