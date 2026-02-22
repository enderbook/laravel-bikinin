@extends('template')

@section('konten')

<div class="card-box">
    <h4 class="card-title">Edit User</h4>
    @foreach($user as $u)

    <form method="post" action="{{url('admin/user/editaction')}}">
        @csrf
        <input type="hidden" value="{{$u->id_user}}" name="id_user">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="{{$u->username}}" class="form-control">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" value="{{$u->email}}" class="form-control">
        </div>
        <div class="form-group">
            <label>Role</label>
            <select class="form-control" name="role">
                <option value="client" {{ $u->role == 'client' ? 'selected' : '' }}>Client</option>
                <option value="freelancer" {{ $u->role == 'freelancer' ? 'selected' : '' }}>Freelancer</option>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    @endforeach
</div>

@endsection
