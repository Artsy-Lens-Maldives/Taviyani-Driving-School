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
                    @foreach($instructors as $instructor)
                    <td>
                        <?php $students = \App\Student::where('finished_at', '=', null)->where('instructor_id', $instructor->id)->where('time_id', $time->id)->with('categories')->get() ?>
                        @foreach ($students as $student)
                           <b>{{ $student->name }}</b> - (@foreach ($student->categories as $category) {{ $category->code }} @endforeach)
                           <br>
                        @endforeach
                    </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
