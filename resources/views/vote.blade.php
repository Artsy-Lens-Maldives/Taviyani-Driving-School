@extends('layouts.clean')

@section('content')
<?php

$eligible = $result->votes->eligible;
$turout_percentage = $result->votes->turnout_percent;
$ibu = $result->candidates[1]->votes;
$remaining = str_replace( ',', '', $eligible) - str_replace( ',', '', $result->votes->counted);

// ((262,135*87.8%)*50%)+1)-79,452 = 35626.265

$expceted = str_replace( ',', '', $eligible) * ($turout_percentage / 100);
$yageen = (($expceted * (50/100)) + 1) - $ibu;

?>

{{ $yageen }}
<br>
{{ $remaining }}

@endsection