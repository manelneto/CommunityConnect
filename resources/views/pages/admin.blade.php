@extends('layouts.app')
@include ('layouts.errors')

@section('main')
    <main>
        <section id="admin">
            <details>
                <summary>Find a user</summary>
                <form action="../../users/" method="get" class="form-admin">
                    @csrf
                    <label for="user">Username</label>
                    <select id="user" name="user">
                        <option value="0">None</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                        @endforeach
                    </select>
                    <button id="find-user" type="submit">Visit</button>
                </form>
            </details>
            @yield('errors')
            <details>
                <summary>Create a user</summary>
                <form action="../../users" method="post" class="form-admin">
                    @csrf
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                    <button id="create-user" type="submit">Create User</button>
                </form>
            </details>
        </section>
    </main>
@endsection
