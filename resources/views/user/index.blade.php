@extends('layouts.table')

@section('title', 'Users')

@section('button')
    <a href="#" class="btn btn-success" style="margin-left: 10px">Add new User</a>
@endsection

@section('table')
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->getRoleNames() }}</td>
            <td>
                <a class="btn btn-danger" style="margin: 1px">Delete</a>
                <a class="btn btn-warning" style="margin: 1px">Edit</a>
                <button onclick="updateId({{ $user->id }})" data-toggle="modal" data-target="#feeAddModel" class="btn btn-info" style="margin: 1px">Assign Role</button>
            </td>
        </tr>

        @endforeach
    </tbody>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        });

        function updateId(id) {
            $('#user_id').val(id);
        }
    </script>
@endsection

@section('model-body')
    <form id="feeForm" action="{{ url()->current() }}/assign-role" method="POST">
        @csrf
        <input type="hidden" name="user_id" id="user_id">
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="exampleRadios1" value="student">
            <label class="form-check-label" for="exampleRadios1">
                Student
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="instructor">
            <label class="form-check-label" for="exampleRadios2">
                Instructor
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="admin">
            <label class="form-check-label" for="exampleRadios2">
                Admin
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="role" id="exampleRadios2" value="office">
            <label class="form-check-label" for="exampleRadios2">
                Office
            </label>
        </div>
    </form>
@endsection