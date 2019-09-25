@extends('layouts.clean')

@section('content')

<div style="padding: 10px;">
    <div class="row">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th></th>
                    @foreach($instructors as $instructor)
                    
                    <th>
                        {{ $instructor->name }} - {{ $instructor->phone }}
                        <br>
                        (@foreach ($instructor->categories as $category)
                            {{ $category->code }}
                        @endforeach)
                    </th>

                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach ($times as $time)
                <tr>
                    <td>{{ $time->time }}</td>
                    @foreach ($time->slots as $slot)
                    <td style="background-color: rgb(173,216,230)">
                        <?php $student = $slot->student ?>
                        @if ($slot->isEmpty == 0)
                            @if ($student)
                                <b>{{ $student->name }}</b> - {{ $student->phone }} - @foreach ($student->categories as $category) [{{ $category->code }}] @endforeach
                            @endif
                        @endif
                    </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
