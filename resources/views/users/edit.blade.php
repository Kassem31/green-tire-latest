@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Edit User</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $user->name }}">
                        </div>

                        <div class="form-group mb-4">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $user->email }}">
                        </div>


                        <div class="form-group mb-4">
                            <label for="role">Role:</label>
                            <select class="form-control" id="role_select" name="role_id" class="form-control"
                                placeholder="Select a role..." autocomplete="off">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="is_active">Is Active:</label>
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                                {{ $user->is_active ? 'checked' : '' }}>
                        </div>

                        <div class="form-group mb-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
                            <button type="submit" class="btn btn-primary">Update User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
