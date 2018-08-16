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
                    <td>
                        <?php $student = $slot->student ?>
                        @if ($slot->isEmpty == 0)
                        <b>{{ $student->name }}</b> - {{ $student->phone }} - {{ $student->category->code }}
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
